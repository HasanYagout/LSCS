<?php

namespace App\Http\Services;

use App\Models\FileManager;
use App\Models\Post;
use App\Models\PostComment;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostService
{
    use ResponseTrait;

    public function store($request)
    {
        DB::beginTransaction();
        try {
            // Authenticate and determine user
            if (auth('admin')->check()) {
                $user = auth('admin')->user();
            } else {
                $user = auth('company')->user();
            }

            // Create new post
            $post = new Post();
            $post->body = htmlspecialchars($request->body);
            $post->slug = Str::slug(substr($request->body, 0, 40)) . rand(1000, 999999); // Assuming getSlug and getSubText are meant for this
            $post->user_id = $user->id;
            $post->created_by = 'admin';
            $post->save(); // Save post to generate post_id

            // Process media files
            foreach ($request->file('file', []) as $index => $media) {
                if ($media->isValid()) {
                    $originalName = pathinfo($media->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $media->getClientOriginalExtension();
                    $date = date('Y-m-d');
                    $random = mt_rand(1000, 9999);
                    $slug = Str::slug($originalName); // Create a slug from the original filename
                    $newFileName = "{$date}_{$slug}_{$random}.{$extension}"; // New filename

                    // Move the file to the public disk under posts directory
                    $path = $media->storeAs('posts', $newFileName, 'public');

                    // Create media record
                    $post->media()->create([
                        'name' => $newFileName,
                        'user_id' => $user->id,
                        'post_id' => $post->id, // Correctly use the post_id from the saved post
                        'extension' => $extension, // Correctly save the file extension
                    ]);
                }
            }

            DB::commit(); // Commit the transaction

            $message = getMessage(CREATED_SUCCESSFULLY);
            return $this->success([], $message);

        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function update($request)
    {
        DB::beginTransaction();
        try {

            $post = Post::where('created_by', auth()->id())->where('tenant_id', getTenantId())->where('slug', $request->slug)->first();

            if(is_null($post)){
                return $this->error([], __('This post not found'));
            }

            $post->body = htmlspecialchars($request->body);
            $post->save();

            //post media

            $oldFiles = $request->oldFiles ?? [];

            foreach($request->file ?? [] as $index => $media){
                if ($request->hasFile('file.'.$index)) {

                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('posts', $media);
                    $newMedia = $post->media()->create([
                        'file' => $uploaded->id,
                        'user_id' => auth()->id(),
                    ]);

                    array_push($oldFiles, $newMedia->id);
                }
            }

            $post->media()->whereNotIn('id', $oldFiles)->delete();

            DB::commit();

            $message = getMessage(UPDATED_SUCCESSFULLY);
            return $this->success(['slug' => $post->slug], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function getBySlug($slug)
    {
        return Post::whereSlug($slug)->with(['comments', 'likes:id', 'author', 'media.file_manager'])->withCount('replies')->first();
    }

    public function deleteBySlug($request)
    {

        try {
            DB::beginTransaction();
            $post = Post::where('created_by', auth()->id())->where('tenant_id', getTenantId())->where('slug', $request->slug)->first();

            if(is_null($post)){
                return $this->error([], __('This post not found'));
            }
            $post->delete();
            DB::commit();
            $message = getMessage(DELETED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function likeDislike($request)
    {
        try {
            DB::beginTransaction();
            $post = Post::where('slug', $request->slug)->where('tenant_id', getTenantId())->first();

            if(is_null($post)){
                return $this->error([], __('This post not found'));
            }
            if($post->likes()->where('id', auth()->id())->first()){
                $message = __('Dislike successfully');
            }else{
                $message = __('Like successfully');
            }
            $post->likes()->toggle([auth()->id()]);
            DB::commit();
            return $this->success([], $message);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }


    public function storeComment($request)
    {
        DB::beginTransaction();
        try {

            $post = Post::where('slug', $request->slug)->where('tenant_id', getTenantId())->first();

            if(is_null($post)){
                return $this->error([], __('This post not found'));
            }

            $post->comments()->create([
                'user_id' => auth()->id(),
                'tenant_id' => getTenantId(),
                'parent_id' => $request->parent_id,
                'body' => htmlspecialchars($request->body),
            ]);

            DB::commit();

            $message = __("Comment saved");
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function deleteComment($request)
    {
        DB::beginTransaction();
        try {

            $comment = PostComment::where('id', $request->id)->where('user_id', auth()->id())->where('tenant_id', getTenantId())->first();
            if(is_null($comment)){
                return $this->error([], __('This post not found'));
            }

            $comment->delete();

            DB::commit();

            $message = __("Comment Deleted");
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function updateComment($request)
    {
        DB::beginTransaction();
        try {

            $comment = PostComment::where('id', $request->id)->where('user_id', auth()->id())->where('tenant_id', getTenantId())->first();
            if(is_null($comment)){
                return $this->error([], __('This post not found'));
            }

            $comment->update(['body' => htmlspecialchars($request->body)]);

            DB::commit();

            $message = __("Comment Updated");
            return $this->success(['post_slug' => $comment->post->slug], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

}
