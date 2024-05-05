<?php

namespace App\Http\Services;

use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;

class AlumniService
{
    use ResponseTrait;
    public function getAlumniListWithAdvanceFilter($request){
        $selectedDepartment = $request->get('selectedDepartment');
        $selectedPassingYear = $request->get('selectedPassingYear');
        $isMember = $request->get('isMember');

        $alumniData = User::where(['users.status'=> STATUS_ACTIVE])
        ->join('alumnus', 'users.id', '=', 'alumnus.user_id')
        ->leftJoin('batches', 'batches.id', '=', 'alumnus.batch_id')
        ->leftJoin('passing_years', 'passing_years.id', '=', 'alumnus.passing_year_id')
        ->leftJoin('user_membership_plans', 'user_membership_plans.user_id', '=', 'users.id')
        ->groupBy('users.id')
        ->orderBy('users.name', 'ASC')
        ->where('users.tenant_id', getTenantId())
        ->select('users.id','users.name','users.image','users.mobile','users.email','users.show_email_in_public','users.show_phone_in_public','batches.name as batch', 'passing_years.name as passing_year','alumnus.facebook_url','alumnus.twitter_url','alumnus.instagram_url','alumnus.city','alumnus.state','alumnus.zip','alumnus.country','alumnus.address',DB::raw('max(user_membership_plans.expired_date) as expired_date'));

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
                return '<div class="min-w-160 d-flex align-items-center cg-10"><div class="flex-shrink-0 w-35 h-35 bd-one bd-c-cdef84 rounded-circle overflow-hidden bg-eaeaea d-flex justify-content-center align-items-center"><img src="' . getFileUrl($data->image) . '" alt="icon" class="rounded avatar-xs w-100"></div><p>'.htmlspecialchars($data->name).'</p></div>';
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
            ->addColumn('action', function ($data) {
                $actionLinks = "<ul class='d-flex align-items-center cg-5 justify-content-center' data-contact-name='". htmlspecialchars($data->name)."' >";
                if($data->show_phone_in_public == STATUS_SUCCESS){
                    $actionLinks .= "<li title='Phone No'><a href='#' class='d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white alumniPhone' data-bs-toggle='modal'  data-phone='". htmlspecialchars($data->mobile)."' data-bs-target='#alumniPhoneNo'><img class='max-w-14' src='". asset('assets/images/icon/phone-2.svg')."'  alt=''  /></a></li>";
                }
                if($data->show_email_in_public == STATUS_SUCCESS){
                    $actionLinks .= "<li title='Email'><a href='#' class='d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white alumniEmail' data-bs-toggle='modal'  data-email='". htmlspecialchars($data->email)."' data-bs-target='#alumniEmail'><img class='max-w-14' src='". asset('assets/images/icon/email.svg')."'  w-30 h-30 alt='' /></a></li>";
                }
                if($data->id != auth()->id()){
                    $actionLinks .= "<li title='Messenger'><a href='".route('chats.index')."?receiver_id=".$data->id."' class='d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white'  ><img class='max-w-14' src='". asset('assets/images/icon/messenger.svg')."' alt='' /></a></li>";
                }
                $actionLinks .= "<li title='".__('View Profile')."'><a href='".route('alumnus.view',['id'=>$data->id])."' target='_blank' class='d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white' ><img class='max-w-14' src='". asset('assets/images/icon/eye.svg')."' alt='' /></a></li></ul>";

                return $actionLinks ;
            })
            ->rawColumns(['name', 'batch',  'passing_year', 'address', 'action'])
            ->make(true);
    }

    public function getAlumniListAllWithAdvanceFilter($request){
        $selectedDepartment = $request->get('selectedDepartment');
        $selectedPassingYear = $request->get('selectedPassingYear');
        $isMember = $request->get('isMember');

        $alumniData = User::where('users.deleted_at','=',NULL)
        ->where('users.status','!=', STATUS_PENDING)
        ->join('alumnus', 'users.id', '=', 'alumnus.user_id')
        ->leftJoin('batches', 'batches.id', '=', 'alumnus.batch_id')
        ->leftJoin('passing_years', 'passing_years.id', '=', 'alumnus.passing_year_id')
        ->leftJoin('user_membership_plans', 'user_membership_plans.user_id', '=', 'users.id')
        ->groupBy('users.id')
        ->orderBy('users.name', 'ASC')
        ->where('users.tenant_id', getTenantId())
        ->select('users.id','users.name','users.image','users.mobile','users.email','users.status','users.show_email_in_public','users.show_phone_in_public','batches.name as batch', 'passing_years.name as passing_year','alumnus.facebook_url','alumnus.twitter_url','alumnus.instagram_url','alumnus.city','alumnus.state','alumnus.zip','alumnus.country','alumnus.address',DB::raw('max(user_membership_plans.expired_date) as expired_date'));

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
                return '<div class="min-w-160 d-flex align-items-center cg-10"><div class="flex-shrink-0 w-35 h-35 bd-one bd-c-cdef84 rounded-circle overflow-hidden bg-eaeaea d-flex justify-content-center align-items-center"><img src="' . getFileUrl($data->image) . '" alt="icon" class="rounded avatar-xs w-100"></div><p>'.htmlspecialchars($data->name).'</p></div>';
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
                if($data->id != auth()->id()){
                    $actionLinks .= "<li title='Messenger'><a href='".route('chats.index')."?receiver_id=".$data->id."' class='d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white'  ><img class='max-w-14' src='". asset('assets/images/icon/messenger.svg')."' alt='' /></a></li>";
                }

                $actionLinks .= "<li title='".__('View Profile')."'><a href='".route('alumnus.view',['id'=>$data->id])."' target='_blank' class='d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white' ><img class='max-w-14' src='". asset('assets/images/icon/eye.svg')."' alt='' /></a></li></ul>";
                return $actionLinks ;

            })
            ->rawColumns(['name', 'batch',  'passing_year', 'address','change_status', 'action'])
            ->make(true);
    }

    public function getAlumniPendingListWithAdvanceFilter($request){
        $selectedDepartment = $request->get('selectedDepartment');
        $selectedPassingYear = $request->get('selectedPassingYear');
        $isMember = $request->get('isMember');
        $alumniData = User::where(['users.status'=> STATUS_PENDING, 'users.email_verification_status' => STATUS_ACTIVE])
        ->join('alumnus', 'users.id', '=', 'alumnus.user_id')
        ->leftJoin('batches', 'batches.id', '=', 'alumnus.batch_id')
        ->leftJoin('passing_years', 'passing_years.id', '=', 'alumnus.passing_year_id')
        ->leftJoin('user_membership_plans', 'user_membership_plans.user_id', '=', 'users.id')
        ->groupBy('users.id')
        ->orderBy('users.name', 'ASC')
        ->where('users.tenant_id', getTenantId())
        ->select('users.id','users.name','users.image','users.mobile','users.email','users.show_email_in_public','users.show_phone_in_public','users.status','batches.name as batch', 'passing_years.name as passing_year','alumnus.facebook_url','alumnus.twitter_url','alumnus.instagram_url','alumnus.city','alumnus.state','alumnus.zip','alumnus.country','alumnus.address',DB::raw('max(user_membership_plans.expired_date) as expired_date'));
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
                return '<div class="min-w-160 d-flex align-items-center cg-10"><div class="flex-shrink-0 w-35 h-35 bd-one bd-c-cdef84 rounded-circle overflow-hidden bg-eaeaea d-flex justify-content-center align-items-center"><img src="' . getFileUrl($data->image) . '" alt="icon" class="rounded avatar-xs w-100"></div><p>'.htmlspecialchars($data->name).'</p></div>';
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
                $actionLinks .= "<li title='".__('View Profile')."'><a href='".route('alumnus.view',['id'=>$data->id])."' target='_blank' class='d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white' ><img class='max-w-14' src='". asset('assets/images/icon/eye.svg')."' alt='' /></a></li></ul>";
                return $actionLinks ;
            })
            ->rawColumns(['name', 'batch',  'passing_year', 'address','change_status', 'action'])
            ->make(true);
    }

    public function changeAlumniStatus($request){
        DB::beginTransaction();
        try {
            $user = User::where(['id'=> $request['alumniUserId']])->where('tenant_id', getTenantId());
            $user->update([
                'status' => $request['selectedStatus']
                ]);
             DB::commit();
            $message = __("Alumni Status Changed Successfully.");
            $userData = $user->first() ;
            $this->sendEmailNotification($request['selectedStatus'],$userData);
            return $this->success([], $message);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
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
