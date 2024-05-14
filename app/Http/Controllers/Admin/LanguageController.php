<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LanguageRequest;
use App\Http\Services\LanguageService;
use App\Models\FileManager;
use App\Models\Language;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LanguageController extends Controller
{
    use ResponseTrait;

    private $languageService;

    public function __construct()
    {
        $this->languageService = new LanguageService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->languageService->getAllData();
        }
        $data['title'] = __('Manage Language');
        $data['showManageApplicationSetting'] = 'show';
        $data['activeLanguagesSetting'] = 'active';
        return view('admin.setting.languages.index', $data);
    }

    public function store(LanguageRequest $request)
    {
        return $this->languageService->store($request);
    }

    public function edit($id)
    {
        $data['language'] = Language::findOrFail($id);
        return view('admin.setting.languages.edit-form', $data);
    }

    public function update(Request $request, $id)
    {
        return $this->languageService->update($request, $id);
    }

    public function translateLanguage($id)
    {
        $data['title'] = __('Translate');
        $data['showManageApplicationSetting'] = 'show';
        $data['activeLanguagesSetting'] = 'active-color-one';
        $data['language'] = Language::findOrFail($id);
        $iso_code = $data['language']->iso_code;
        $path = resource_path() . "/lang/$iso_code.json";
        if (!file_exists($path)) {
            fopen(resource_path() . "/lang/$iso_code.json", "w");
            file_put_contents(resource_path() . "/lang/$iso_code.json", '{}');
        }
        $data['translators'] = json_decode(file_get_contents(resource_path() . "/lang/$iso_code.json"), true);
        $data['languages'] = Language::where('iso_code', '!=', $iso_code)->get();
        return view('admin.setting.languages.translate', $data);
    }

    public function updateLanguage(Request $request, $id)
    {
        $request->validate([
            'key' => 'required',
            'val' => 'required'
        ]);
        return $this->languageService->updateLang($request, $id);
    }

    public function delete($id)
    {
        $lang = Language::findOrFail($id);
        if ($lang->default_language == 'on') {
            return redirect()->back()->with('warning', __('You Cannot delete default language'));
        }

        $path = resource_path() . "/lang/$lang->iso_code.json";
        if (file_exists($path)) {
            @unlink($path);
        }

        $file = FileManager::where('id', $lang->flag_id)->first();
        if ($file) {
            $file->removeFile();
            $file->delete();
        }

        $lang->delete();
        return redirect()->back()->with('success', __('Deleted Successfully'));
    }

    public function import(Request $request)
    {
        $language = Language::where('iso_code', $request->import)->firstOrFail();
        $currentLang = Language::where('iso_code', $request->current)->firstOrFail();
        $contents = file_get_contents(resource_path() . "/lang/$language->iso_code.json");
        file_put_contents(resource_path() . "/lang/$currentLang->iso_code.json", $contents);
        $message = UPDATED_SUCCESSFULLY;
        return $this->success([], $message);
    }

    public function updateTranslate(Request $request, $id)
    {
        $request->validate([
            'key' => 'required',
            'val' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $language = Language::findOrFail($id);
            $key = $request->key;
            $val = $request->val;
            $is_new = $request->is_new;
            $path = resource_path() . "/lang/$language->iso_code.json";
            $file_data = json_decode(file_get_contents($path), 1);

            if (!array_key_exists($key, $file_data)) {
                $file_data = array($key => $val) + $file_data;
            } else if ($is_new) {
                $message = __("Already Exist");
                return $this->error([], $message);
            } else {
                $file_data[$key] = $val;
            }
            unlink($path);
            file_put_contents($path, json_encode($file_data));
            DB::commit();
            $message = UPDATED_SUCCESSFULLY;
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }
}
