<?php

namespace App\Http\Services;

use App\Models\FileManager;
use App\Models\Post;
use App\Models\PostComment;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class PostService
{
    use ResponseTrait;

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();
            $post = new Post();
            $post->body = htmlspecialchars($request->body);
            $post->slug = getSlug(getSubText($request->body, 40)).rand(1000, 999999);
            $post->tenant_id = getTenantId();
            $post->created_by = $user->id;
            $post->save();

            //post media
            foreach($request->file ?? [] as $index => $media){
                if ($request->hasFile('file.'.$index)) {

                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('posts', $media);
                    $post->media()->create([
                        'file' => $uploaded->id,
                        'user_id' => $user->id,
                    ]);
                }
            }

            DB::commit();

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
        return Post::whereSlug($slug)->where('tenant_id', getTenantId())->with(['comments', 'likes:id', 'author', 'media.file_manager'])->withCount('replies')->first();
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
