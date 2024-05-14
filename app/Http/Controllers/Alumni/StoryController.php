<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\StoryService;
use App\Traits\ResponseTrait;
use App\Http\Requests\StoryRequest;

class StoryController extends Controller
{
    use ResponseTrait;

    public $storyService;

    public function __construct()
    {
        $this->storyService = new StoryService();
    }

    public function create()
    {
        $data['title'] = __('Add Story');
        $data['showStoryManagement'] = 'show';
        $data['activeStoryCreate'] = 'active-color-one';
        return view('alumni.stories.create', $data);
    }

    public function store(StoryRequest $request)
    {
        return $this->storyService->store($request);
    }

    public function pending(Request $request)
    {
        if ($request->ajax()) {
            return $this->storyService->getMyPendingStory();
        }
        $data['title'] = __('Pending Story');
        $data['showStoryManagement'] = 'show';
        $data['activePendingStoryList'] = 'active-color-one';
        return view('alumni.stories.pending', $data);
    }

    public function myStory(Request $request)
    {
        if ($request->ajax()) {
            return $this->storyService->getMyStoryList();
        }
        $data['title'] = __('My Story');
        $data['showStoryManagement'] = 'show';
        $data['activeMyStoryList'] = 'active-color-one';
        return view('alumni.stories.list', $data);
    }

    public function info($slug)
    {
        $data['story'] = $this->storyService->getBySlug($slug);
        return view('alumni.stories.edit-form', $data);
    }

    public function update(StoryRequest $request, $slug)
    {
        return $this->storyService->update($slug, $request);
    }

    public function delete($slug)
    {
        return $this->storyService->deleteBySlug($slug);
    }

}
