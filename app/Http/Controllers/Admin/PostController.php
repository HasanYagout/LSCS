<?php

namespace App\Http\Controllers\Admin;
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



}
