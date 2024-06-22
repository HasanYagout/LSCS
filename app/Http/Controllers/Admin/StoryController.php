<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\CreateStoryRequest;
use App\Http\Requests\StoryRequest;
use App\Http\Services\StoryService;
use App\Models\Story;
use App\Traits\ResponseTrait;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        return view('admin.stories.my-story', $data);
    }
    public function all(Request $request)
    {
        if ($request->ajax()) {
            return $this->storyService->getAllStoryList();
        }
        $data['title'] = __('All Story');
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
    public function active(Request $request)
    {
        if ($request->ajax()) {
            return $this->storyService->allActiveList();
        }
        $data['title'] = __('Active Story');
        $data['showStoryManagement'] = 'show';
        $data['activePendingStoryList'] = 'active-color-one';
        return view('admin.stories.active', $data);
    }
    public function store(CreateStoryRequest $request)
    {

        return $this->storyService->store($request);
    }
    public function info($slug)
    {
        $data['story'] = $this->storyService->getBySlug($slug);
        return view('admin.stories.edit-form', $data);
    }

    public function update(StoryRequest $request, $slug)
    {
        return $this->storyService->update($slug, $request);
    }

    public function toggleStatus(Request $request)
    {
        $story = Story::find($request->story_id);
        if ($story) {
            $story->status = $story->status == STATUS_ACTIVE ? STATUS_INACTIVE : STATUS_ACTIVE;
            $story->save();
            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Error']);
    }

    public function delete($slug)
    {
        return $this->storyService->deleteBySlug($slug);
    }
}
