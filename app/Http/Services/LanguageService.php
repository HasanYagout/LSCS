<?php

namespace App\Http\Services;

use App\Models\Currency;
use App\Models\FileManager;
use App\Models\Language;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class LanguageService
{
    use ResponseTrait;

    public function getAllData()
    {
        $currencies = Language::orderBy('id', 'DESC')->select('id', 'language', 'iso_code', 'default', 'rtl', 'flag_id', 'font');
        return datatables($currencies)
            ->addIndexColumn()
            ->editColumn('language', function ($data) {
                $language = $data->language;
                if ($data->default == STATUS_ACTIVE) {
                    $language = $language . ' <b>(Default)';
                }

                return $language;
            })
            ->editColumn('rtl', function ($data) {
                $return = __('No');
                if ($data->rtl == STATUS_ACTIVE) {
                    $return = __('Yes');
                }

                return $return;
            })
            ->addColumn('flag', function ($data) {
                return '<div class="min-w-160 d-flex align-items-center cg-10"><div class="flex-shrink-0 w-35 h-35 bd-one bd-c-cdef84 rounded-circle overflow-hidden bg-eaeaea d-flex justify-content-center align-items-center"><img src="' . getFileUrl($data->flag_id) . '" alt="icon" class="rounded avatar-xs w-100"></div><p>'.htmlspecialchars($data->name).'</p></div>';
            })
            ->addColumn('font', function ($data) {
                if ($data->font != null) {
                    return '<spna>Yes</spna>';
                } else {
                    return '<spna>No</spna>';
                }
            })
            ->addColumn('action', function ($data) {
                if(auth()->user()->role == USER_ROLE_ADMIN){
                    $role = 'admin';
                }else{
                    $role = 'super_admin';
                }
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                <li class="align-items-center d-flex gap-2">
                    <button onclick="getEditModal(\'' . route($role.'.setting.languages.edit', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo">
                        <img src="' . asset('assets/images/icon/edit.svg') . '" alt="edit" />
                    </button>
                    <button onclick="deleteItem(\'' . route($role.'.setting.languages.delete', $data->id) . '\', \'commonDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
                        <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                    </button>
                    <a href="' . route($role.'.setting.languages.translate', $data->id) . '"
                                                                                class="btn-action" title="">
                                                                                <span class="status-btn status-btn-blue">
                                                                                    ' . __("Translator") . '</span>
                                                                            </a>
                </li>
            </ul>

                ';
            })
            ->rawColumns(['action', 'language', 'flag', 'font', 'rtl'])
            ->make(true);
    }


    public function store($request)
    {
        DB::beginTransaction();
        try {

            $language = new Language();

            if ($request->hasFile('flag')) {
                /*File Manager Call upload*/
                $newFile = new FileManager();
                $uploaded = $newFile->upload('language', $request->flag);

                if (!is_null($uploaded)) {
                    $language->flag_id = $uploaded->id;
                } else {
                    return $this->error([], getMessage(SOMETHING_WENT_WRONG));
                }
                /*End*/
            }

            if ($request->hasFile('font')) {

                $newFile = new FileManager();
                $uploaded = $newFile->upload('font', $request->font);

                if (!is_null($uploaded)) {
                    $language->font = $uploaded->id;
                } else {
                    return $this->error([], getMessage(SOMETHING_WENT_WRONG));
                }
                /*End*/
            }
            if ($request->has('default')) {
                Language::where('id', '!=', 0)->update(['default' => 0]);
            }

            $language->language = $request->language;
            $language->iso_code = $request->iso_code;
            $language->rtl = $request->rtl;
            $language->default = $request->has('default') ? STATUS_ACTIVE : STATUS_DISABLE;
            $language->save();


            // Start:: Default language setup local
            if (isset($request->default) == 1) {
                Language::where('id', '!=', $language->id)->where('default', STATUS_ACTIVE)->update(['default' => STATUS_DISABLE]);
            }


            $defaultLanguage = Language::where('default', STATUS_ACTIVE)->first();
            if ($defaultLanguage) {
                $ln = $defaultLanguage->iso_code;
                session(['local' => $ln]);
                session()->get('local');
                App::setLocale(session()->get('local'));
            }
            // End:: Default language setup local


            $path = resource_path('lang/');
            fopen($path . "$request->iso_code.json", "w");
            file_put_contents($path . "$request->iso_code.json", '{}');
            DB::commit();
            $message = getMessage(CREATED_SUCCESSFULLY);
            return $this->success(['route' => route('admin.setting.languages.index', [$language->id])], $message);
//            return $this->success([], __(UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function update($request, $id)
    {

        DB::beginTransaction();
        try {
            $language = Language::findOrFail($id);


            if ($request->hasFile('flag')) {

                /*File Manager Call upload*/
                $new_file = FileManager::where('id', $language->flag_id)->first();
                if ($new_file) {
                    $new_file->removeFile();
                    $uploaded = $new_file->upload('Language', $request->flag, '', $new_file->id);
                    if (!is_null($uploaded)) {
                        $language->flag_id = $uploaded->id;
                    } else {
                        return $this->error([], getMessage(SOMETHING_WENT_WRONG));
                    }

                } else {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('Language', $request->flag);
                    if (!is_null($uploaded)) {
                        $language->flag_id = $uploaded->id;
                    } else {
                        return $this->error([], getMessage(SOMETHING_WENT_WRONG));
                    }
                }
                /*End*/
            }
            if ($request->has('default')) {
                Language::where('id', '!=', 0)->update(['default' => 0]);
            }
            if ($request->hasFile('font')) {

                $newFile = new FileManager();
                $uploaded = $newFile->upload('font', $request->font);

                if (!is_null($uploaded)) {
                    $language->font = $uploaded->id;
                } else {
                    return $this->error([], getMessage(SOMETHING_WENT_WRONG));
                }
                /*End*/
            }
            $language->language = $request->language;
            $language->iso_code = $request->iso_code;
            $language->rtl = $request->rtl;
            $language->default = $request->has('default') ? STATUS_ACTIVE : STATUS_DISABLE;
            $language->save();

            // Start:: Default language setup local
            if (isset($request->default) == 1) {
                Language::where('id', '!=', $language->id)->where('default', STATUS_ACTIVE)->update(['default' => STATUS_DISABLE]);
            }


            $defaultLanguage = Language::where('default', STATUS_ACTIVE)->first();
            if ($defaultLanguage) {
                $ln = $defaultLanguage->iso_code;
                session(['local' => $ln]);
                session()->get('local');
                App::setLocale(session()->get('local'));
            }
            // End:: Default language setup local


            $path = resource_path('lang/');
            fopen($path . "$request->iso_code.json", "w");
            file_put_contents($path . "$request->iso_code.json", '{}');
            DB::commit();
            $message = getMessage(UPDATED_SUCCESSFULLY);
            return $this->success(['route' => route('admin.setting.languages.index', [$language->id])], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function getById($id)
    {
        return Currency::findOrFail($id);
    }

    public function updateLang($request, $id)
    {
        if (!auth()->user()->can('manage_language')) {
            return $this->error([], getMessage(DO_NOT_HAVE_PERMISSION));
        }

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
                return $this->success(['type' => $is_new], __("Already Exist"));
            } else {
                $file_data[$key] = $val;
            }
            unlink($path);

            file_put_contents($path, json_encode($file_data));
            return $this->success(['type' => 0], __("Translation Updated"));
        } catch (\Exception $e) {
            return $this->error(['type' => 0], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function deleteById($id)
    {
        DB::beginTransaction();
        try {
            $currency = Currency::findOrFail($id);
            $currency->delete();
            DB::commit();
            $message = getMessage(DELETED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }
}
