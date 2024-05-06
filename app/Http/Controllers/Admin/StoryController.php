<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoryRequest;
use App\Http\Services\StoryService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    use ResponseTrait;

    public $storyService;

    public function __construct()
    {
        $this->storyService = new StoryService();
    }
    public function myStory(Request $request)
    {
        if ($request->ajax()) {
            return $this->storyService->getMyStoryList();
        }
        $data['title'] = __('My Story');
        $data['showStoryManagement'] = 'show';
        $data['activeMyStoryList'] = 'active-color-one';
        return view('admin.stories.list', $data);
    }
    public function create()
    {
        $data['title'] = __('Add Story');
        $data['showStoryManagement'] = 'show';
        $data['activeStoryCreate'] = 'active-color-one';
        return view('admin.stories.create', $data);
    }
    public function pending(Request $request)
    {
        if ($request->ajax()) {
            return $this->storyService->allPendingList();
        }
        $data['title'] = __('Pending Story');
        $data['showStoryManagement'] = 'show';
        $data['activePendingStoryList'] = 'active-color-one';
        return view('admin.stories.pending', $data);
    }
    public function store(StoryRequest $request)
    {
        return $this->storyService->store($request);
    }
}
