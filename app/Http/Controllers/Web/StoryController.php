<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Services\Frontend\HomeService;
use App\Http\Services\NewsService;
use App\Http\Services\StoryService;
use App\Traits\ResponseTrait;

class StoryController extends Controller
{
    use ResponseTrait;

    public $storyService;

    public function __construct()
    {
        $this->storyService = new StoryService();
    }

    public function list()
    {
        $data['title'] = __('Story');
        $data['stories'] = $this->storyService->getAll(8);
        return view('web.stories.list', $data);
    }

    public function view($slug)
    {
        $data['title'] = __('Story');
        $data['story'] = $this->storyService->getBySlug($slug);
        return view('web.stories.view', $data);
    }

}
