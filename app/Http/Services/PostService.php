<?php

namespace App\Http\Services;

use App\Models\FileManager;
use App\Models\Post;
use App\Models\PostComment;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostService
{
    use ResponseTrait;

    public function store($request)
    {
        DB::beginTransaction();
        try {
          $user=Auth::user();

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
                    $media->storeAs('public/admin/posts', $newFileName, 'public'); // Store file with custom name in specified directory

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
            // Flash a success message to the session
            session()->flash('success', 'Post has been created.');

            // Redirect to a specific route or action
            return redirect()->route('admin.home');

        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }



    public function getBySlug($slug)
    {
        return Post::whereSlug($slug)->with(['admin'])->first();
    }
    public function update($request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'slug' => 'required|string|exists:posts,slug',
            'body' => 'required|string',
            'file.*' => 'nullable|mimes:jpeg,png,jpg,gif,svg,mp4,avi,mov,wmv|max:20480', // Image and video validation
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $post = Post::where('created_by', 'admin')
                ->where('user_id', Auth::user()->id)
                ->where('slug', $request->slug)
                ->first();

            if (is_null($post)) {
                return redirect()->route('home')->with('error', __('This post not found'));
            }
            $post->body = htmlspecialchars($request->body);
            $post->save();

            // Post media
            $oldFiles = $request->oldFiles ?? [];

            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $media) {
                    $extension = $media->getClientOriginalExtension();
                    $date = now()->format('Y-m-d');
                    $randomNumber = rand(1000, 9999);


                    // Remove any existing extension from the original filename
                    $originalName = pathinfo($media->getClientOriginalName(), PATHINFO_FILENAME);
                    $slug = Str::slug($originalName); // Ensure the original name is slugged

                    $filename = "{$date}_{$slug}_{$randomNumber}.{$extension}";

                    $path = $media->storeAs('public/admin/posts', $filename); // Store file with custom name

                    $newMedia = $post->media()->create([
                        'name' => $filename,
                        'user_id' => Auth::user()->id,
                        'extension'=>$extension
                    ]);

                    array_push($oldFiles, $newMedia->id);
                }
            }

            $post->media()->whereNotIn('id', $oldFiles)->delete();

            DB::commit();

            $message = getMessage(UPDATED_SUCCESSFULLY);
            return redirect()->route('admin.home')->with('success', $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return redirect()->route('admin.home')->with('error', $message);
        }
    }
    public function deleteBySlug($request)
    {
        try {
            DB::beginTransaction();

            $post = Post::where('created_by', 'admin')
                ->where('user_id', Auth::user()->id)
                ->where('slug', $request->slug)
                ->first();

            if (is_null($post)) {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => __('This post not found')], 404);
                }
                return redirect()->route('admin.home')->with('error', __('This post not found'));
            }

//            $post->delete();
            DB::commit();
            $message = getMessage('DELETED_SUCCESSFULLY');

            if ($request->ajax()) {

                return response()->json(['success' => true, 'message' => $message]);
            }

            return redirect()->route('admin.home')->with('success', $message);
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $message], 500);
            }

            return redirect()->route('admin.home')->with('error', $message);
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
