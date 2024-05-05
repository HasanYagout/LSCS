<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

}
