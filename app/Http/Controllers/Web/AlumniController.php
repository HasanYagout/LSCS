<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Services\Frontend\HomeService;
use App\Traits\ResponseTrait;

class AlumniController extends Controller
{
    use ResponseTrait;
    public $homeService;

    public function __construct()
    {
        $this->homeService = new HomeService();
    }

    public function alumni()
    {
        $data['title'] = __('All Alumni');
        $data['allAlumni'] = $this->homeService->getAlumni(8);
        return view('web.alumni.index', $data);
    }
}
