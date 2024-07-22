<?php

namespace App\Http\Services;

use App\Models\Alumni;
use App\Models\AppliedJobs;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;

class AlumniService
{
    use ResponseTrait;


    public function getAlumni( $request)
    {
        $alumniData = Alumni::with('student'); // Initialize query and eager load student data

        // Filter by selected year
        if ($request->has('selectedYear') && $request->selectedYear != 0) {
            $alumniData->where('graduation_year', $request->selectedYear);
        }

        // Filter by selected major
        if ($request->has('selectedMajor') && $request->selectedMajor != 0) {
            $alumniData->where('major', $request->selectedMajor);
        }

        // Handle search input
        if ($request->has('search') && isset($request->search['value']) && $request->search['value'] != '') {
            $search = $request->search['value'];
            $alumniData->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        // Handle ordering
        if ($request->has('order')) {
            $columns = $request->input('columns');
            foreach ($request->input('order') as $order) {
                $column = $columns[$order['column']]['name'];
                $direction = $order['dir'];
                $alumniData->orderBy($column, $direction);
            }
        } else {
            $alumniData->orderBy('id', 'desc');
        }

        return datatables($alumniData)
            ->addIndexColumn()
            ->addColumn('id', function ($data) {
                return $data->id;
            })
            ->addColumn('first_name', function ($data) {
                return $data->first_name;
            })
            ->addColumn('last_name', function ($data) {
                return $data->last_name;
            })
            ->addColumn('graduation_year', function ($data) {
                return $data->graduation_year;
            })
            ->addColumn('major', function ($data) {
                return $data->major;
            })
            ->addColumn('status', function ($data) {
                $checked = $data->status ? 'checked' : '';
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                <li class="d-flex gap-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input toggle-status" type="checkbox" data-id="' . $data->id . '" id="toggleStatus' . $data->id . '" ' . $checked . '>
                        <label class="form-check-label" for="toggleStatus' . $data->id . '"></label>
                    </div>
                </li>
            </ul>';
            })
            ->addColumn('student', function ($data) {
                return $data->student ? $data->student->name : 'No student data';
            })
            ->rawColumns(['first_name', 'last_name', 'graduation_year', 'major', 'status'])
            ->make(true);
    }


    public function getAlumniListAllWithAdvanceFilter($request){

        $selectedDepartment = $request->get('selectedDepartment');
        $selectedPassingYear = $request->get('selectedPassingYear');
        $isMember = $request->get('isMember');
        $alumniData = Alumni::where('status',STATUS_ACTIVE);
        if(isset($selectedDepartment) && $selectedDepartment > 0){
            $alumniData->where('department_id','=',$selectedDepartment);
        }
        if(isset($selectedPassingYear) && $selectedPassingYear > 0){
            $alumniData->where('passing_year_id','=',$selectedPassingYear);
        }
        if(isset($isMember) && $isMember >=0){
            if($isMember==ALUMNI_MEMBER){
                $alumniData->where('expired_date','!=',null);
                $alumniData->where('expired_date','>=',now());
            }
            if($isMember==ALUMNI_NON_MEMBER){
                $alumniData->where('expired_date',null);
                $alumniData->orWhere(function($query) {
                    $query->where('expired_date','!=',null);
                    $query->where('expired_date','<',now());
                });
            }
        }
        return datatables($alumniData)
            ->addIndexColumn()
            ->addColumn('first_name', function ($data) {

                    return $data->first_name;
            })
            ->addColumn('last_name', function ($data) {

                return $data->last_name;
            })
            ->addColumn('graduation_year', function ($data) {
                return $data->graduation_year;
            })
            ->addColumn('major', function ($data) {
                return $data->major;
            })
            ->addColumn('address', function ($data) {
                $location = "";
                return htmlspecialchars($location);
            })
            ->addColumn('change_status', function ($data) {
                $vassign =  '<select class="form-control form-select" name="change_status" data-id='.$data->id.' id="change_status"  required class="form-control" >';
                foreach(getAlumniGeneralStatus() as $key=>$value){
                    $vassign .= '<option ';
                    if($data->status==$key){
                        $vassign .= ' selected ';
                    }
                    $vassign .= 'value="'.$key.'">'.$value.'</option>';
                }
                $vassign .='</select>';
                return $vassign;
            })
            ->addColumn('action', function ($data) {
                $actionLinks = "<ul class='d-flex align-items-center cg-5 justify-content-center' data-contact-name='". htmlspecialchars($data->name)."' >";
                if($data->show_phone_in_public == STATUS_SUCCESS){
                    $actionLinks .= "<li title='Phone No'><a href='#' class='d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white alumniPhone' data-bs-toggle='modal'  data-phone='". htmlspecialchars($data->mobile)."' data-bs-target='#alumniPhoneNo'><img class='max-w-14' src='". asset('assets/images/icon/phone-2.svg')."'  alt=''  /></a></li>";
                }
                if($data->show_email_in_public == STATUS_SUCCESS){
                    $actionLinks .= "<li title='Email'><a href='#' class='d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white alumniEmail' data-bs-toggle='modal'  data-email='". htmlspecialchars($data->email)."' data-bs-target='#alumniEmail'><img class='max-w-14' src='". asset('assets/images/icon/email.svg')."'  w-30 h-30 alt='' /></a></li>";
                }


                $actionLinks .= "<li title='".__('View Profile')."'><a href='".route('admin.alumni.view',['id'=>$data->id])."' target='_blank' class='d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white' ><img class='max-w-14' src='". asset('public/assets/images/icon/eye.svg')."' alt='' /></a></li></ul>";
                return $actionLinks ;

            })
            ->rawColumns(['first_name','second_name', 'batch',  'passing_year', 'address','change_status', 'action'])
            ->make(true);
    }

    public function getAlumniPendingListWithAdvanceFilter($request){
        $selectedDepartment = $request->get('selectedDepartment');
        $selectedPassingYear = $request->get('selectedPassingYear');
        $isMember = $request->get('isMember');
        $alumniData = Alumni::where('status',STATUS_PENDING);
        if(isset($selectedDepartment) && $selectedDepartment > 0){
            $alumniData->where('department_id','=',$selectedDepartment);
        }
        if(isset($selectedPassingYear) && $selectedPassingYear > 0){
            $alumniData->where('passing_year_id','=',$selectedPassingYear);
        }
        if(isset($isMember) && $isMember >=0){
            if($isMember==ALUMNI_MEMBER){
                $alumniData->where('expired_date','!=',null);
                $alumniData->where('expired_date','>=',now());
            }
            if($isMember==ALUMNI_NON_MEMBER){
                $alumniData->where('expired_date',null);
                $alumniData->orWhere(function($query) {
                    $query->where('expired_date','!=',null);
                    $query->where('expired_date','<',now());
                });
            }
        }
        return datatables($alumniData)
            ->addIndexColumn()
            ->addColumn('name', function ($data) {
                return '<div class="min-w-160 d-flex align-items-center cg-10"><div class="flex-shrink-0 w-35 h-35 bd-one bd-c-primary-color rounded-circle overflow-hidden bg-eaeaea d-flex justify-content-center align-items-center"><img src="' . getFileUrl($data->image) . '" alt="icon" class="rounded avatar-xs w-100"></div><p>'.htmlspecialchars($data->name).'</p></div>';
            })
            ->addColumn('batch', function ($data) {
                return $data->batch;
            })
            ->addColumn('passing_year', function ($data) {
                return $data->passing_year;
            })
            ->addColumn('address', function ($data) {
                $location = "";
                if(isset($data->address) && $data->address !=NULL)
                {
                    $location = $location.','.$data->address ;
                }
                if(isset($data->city) && $data->city !=NULL)
                {
                    $location = $location.','.$data->city ;
                }
                if(isset($data->zip) && $data->zip !=NULL)
                {
                    $location = $location.' - '.$data->zip ;
                }
                if(isset($data->state) && $data->state !=NULL)
                {
                    $location = $location.','.$data->state ;
                }

                if(isset($data->country) && $data->country !=NULL)
                {
                    $location = $location.','.$data->country ;
                }
                $location = substr($location,1);
                return htmlspecialchars($location);
            })
            ->addColumn('change_status', function ($data) {
                $vassign =  '<select class="form-control form-select change_status" name="change_status" data-id='.$data->id.'>';
                foreach(getAlumniGeneralStatus() as $key=>$value){
                    $vassign .= '<option ';
                    if($data->status==$key){
                        $vassign .= ' selected ';
                    }
                    $vassign .= 'value="'.$key.'">'.$value.'</option>';
                }
                $vassign .='</select>';
                return $vassign;
            })
            ->addColumn('action', function ($data) {
                $actionLinks = "<ul class='d-flex align-items-center cg-5 justify-content-center' data-contact-name='". htmlspecialchars($data->name)."' >";
                if($data->show_phone_in_public == STATUS_SUCCESS){
                    $actionLinks .= "<li title='Phone No'><a href='#' class='d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white alumniPhone' data-bs-toggle='modal'  data-phone='". htmlspecialchars($data->mobile)."' data-bs-target='#alumniPhoneNo'><img class='max-w-14' src='". asset('assets/images/icon/phone-2.svg')."'  alt=''  /></a></li>";
                }
                if($data->show_email_in_public == STATUS_SUCCESS){
                    $actionLinks .= "<li title='Email'><a href='#' class='d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white alumniEmail' data-bs-toggle='modal'  data-email='". htmlspecialchars($data->email)."' data-bs-target='#alumniEmail'><img class='max-w-14' src='". asset('assets/images/icon/email.svg')."'  w-30 h-30 alt='' /></a></li>";
                }
                $actionLinks .= "<li title='".__('View Profile')."'><a href='".route('alumnus.view',['id'=>$data->id])."' target='_blank' class='d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white' ><img class='max-w-14' src='". asset('public/assets/images/icon/eye.svg')."' alt='' /></a></li></ul>";
                return $actionLinks ;
            })
            ->rawColumns(['name', 'batch',  'passing_year', 'address','change_status', 'action'])
            ->make(true);
    }

    public function changeAlumniStatus( $request) {
        DB::beginTransaction();
        try {
            $user = Alumni::withTrashed()->findOrFail($request->alumni_id); // Also consider trashed items
            if ($request->status == 0) {
                // Soft delete if status is set to '0'
                $jobs=AppliedJobs::where('alumni_id', $request->alumni_id)->get();

                if ($jobs){
                    $message = 'You Can not delete this Account because it has applied jobs';
                    return response()->json([
                        'success' => false,
                        'message' => $message
                    ]);
                }
                else{
                $user->delete();
                $message = 'Alumni has been deactivated and archived.';

                }
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 400);
        }
    }

    public function sendEmailNotification($status,$userData){
        if($status == STATUS_ACTIVE){
            $message = "Your Alumni Account Approved";
            setCommonNotification( __('Account Approval'), $message, Null, $userData->id);
            genericEmailNotify('',$userData,Null,'account-approval');
        } else if($status == STATUS_REJECT){
            $message = "Your Alumni Account Rejected";
            setCommonNotification( __('Account Approval'), $message, Null, $userData->id);
            genericEmailNotify('',$userData, Null,'account-rejection');
        } else {
        }

    }
}
