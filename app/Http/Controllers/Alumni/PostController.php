<?php

namespace App\Http\Controllers\Alumni;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Services\PostService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PostController extends Controller
{
    use ResponseTrait;
    public $postService;

    public function __construct()
    {
        $this->postService = new PostService();
    }

    public function store(PostRequest $request)
    {
        return  $this->postService->store($request);
    }
    
    public function edit(Request $request)
    {
        $data['post'] = $this->postService->getBySlug($request->slug);
        $response['html'] = View::make('alumni.partials.post-edit', $data)->render();
        return $this->success($response);
    }
   
    public function update(PostRequest $request)
    {
        return  $this->postService->update($request);
    }
    
    public function delete(Request $request)
    {
        return  $this->postService->deleteBySlug($request);
    }
   
    public function likeDislike(Request $request)
    {
        return  $this->postService->likeDislike($request);
    }
    
    public function getSinglePost(Request $request)
    {
        $data['posts'][] = $this->postService->getBySlug($request->slug);
        $response['html'] = View::make('alumni.partials.post', $data)->render();
        return $this->success($response);
    }
    public function getSinglePostBody(Request $request)
    {
        $data['post'] = $this->postService->getBySlug($request->slug);
        $response['html'] = View::make('alumni.partials.post-body', $data)->render();
        return $this->success($response);
    }
    public function getSinglePostLike(Request $request)
    {
        $data['post'] = $this->postService->getBySlug($request->slug);
        $response['html'] = View::make('alumni.partials.post-like', $data)->render();
        return $this->success($response);
    }
    public function getSinglePostComment(Request $request)
    {
        $data['post'] = $this->postService->getBySlug($request->slug);
        $response['comment_button_html'] = View::make('alumni.partials.post-comment-button', $data)->render();
        $response['comment_box_html'] = View::make('alumni.partials.post-comment-box', $data)->render();
        return $this->success($response);
    }
    public function postComment(Request $request)
    {
        $request->validate([
            'body' => 'required'
        ]);
        
        return  $this->postService->storeComment($request);
    }
    public function postCommentDelete(Request $request)
    {
        return  $this->postService->deleteComment($request);
    }
    public function postCommentUpdate(Request $request)
    {
        return  $this->postService->updateComment($request);
    }
}
