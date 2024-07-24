<?php

namespace App\Http\Services;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CompanyService
{
    public function updateStatus($request,$id)
    {
        $user=User::find($id);
        $company=Company::with('jobs')->where('user_id',$id)->get();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Company not found.']);
        }

        // Start transaction to ensure data integrity
        DB::beginTransaction();
        try {
            $user->status = $request->status;
            $user->save();
            // Check if the status is 0 and update all associated jobs
            if ($request->status == 0) {
                foreach ($company->jobs as $job) {
                    $job->status = 0;
                    $job->save();
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Status updated successfully, including all associated jobs.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to update status: ' . $e->getMessage()]);
        }
    }

    public function all($request)
    {
        $query = Company::join('users', 'companies.user_id', '=', 'users.id')
            ->select('companies.*','users.email','users.status')
            ->where(function ($q) {
                $q->where('users.status', STATUS_ACTIVE)
                    ->orWhere('users.status', STATUS_INACTIVE);
            });

        if ($request->has('search') && $request->search['value'] != '') {
            $search = $request->search['value'];
            $query->where(function ($q) use ($search) {
                $q->where('users.email', 'like', "%{$search}%")
                    ->orWhere('companies.name', 'like', "%{$search}%")
                    ->orWhere('companies.phone', 'like', "%{$search}%");
            });
        }

        if ($request->has('order') && $request->has('columns')) {
            foreach ($request->order as $order) {
                $orderBy = $request->columns[$order['column']]['data'];
                $orderDirection = $order['dir'];
                $query->orderBy($orderBy, $orderDirection);
            }
        } else {
            $query->orderBy('companies.id', 'desc');
        }

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('name', function ($data) {
                return $data->name;
            })
            ->addColumn('email',function($data){
                return $data->email;
            })
            ->addColumn('phone',function($data){
                return $data->phone;
            })
            ->addColumn('status', function ($data) {
                $checked = $data->status ? 'checked' : '';
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                <li class="d-flex gap-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input toggle-status" type="checkbox" data-id="' . $data->user_id . '" id="toggleStatus' . $data->user_id . '" ' . $checked . '>
                        <label class="form-check-label" for="toggleStatus' . $data->user_id . '"></label>
                    </div>
                </li>
            </ul>';
            })

            ->addColumn('action', function ($data) {
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                                <li class="d-flex gap-2">
                                    <a href="' . route('admin.company.details', $data->slug) . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View"><img src="' . asset('public/assets/images/icon/eye.svg') . '" alt="" /></a>
                                </li>
                            </ul>';

            })
            ->rawColumns(['company_logo', 'action', 'title', 'employee_status', 'status', 'application_deadline'])
            ->make(true);
    }

    public function active( $request)
    {
        $query = Company::join('users', 'companies.user_id', '=', 'users.id')
            ->select('companies.*','users.email')
            ->Where('users.status', STATUS_ACTIVE);

        if ($request->has('search') && $request->search['value'] != '') {
            $search = $request->search['value'];
            $query->where(function ($q) use ($search) {
                $q->where('users.email', 'like', "%{$search}%")
                    ->orWhere('companies.name', 'like', "%{$search}%")
                    ->orWhere('companies.phone', 'like', "%{$search}%");
            });
        }

        if ($request->has('order') && $request->has('columns')) {
            foreach ($request->order as $order) {
                $orderBy = $request->columns[$order['column']]['data'];
                $orderDirection = $order['dir'];
                // Ensure the column exists in the database to avoid errors
                if (in_array($orderBy, ['email', 'name', 'phone', 'status', 'id'])) {
                    $query->orderBy($orderBy, $orderDirection);
                }
            }
        } else {
            $query->orderBy('id', 'desc');
        }



        return datatables($query)
            ->addIndexColumn()
            ->addColumn('name', function ($data) {
                return $data->name;
            })
            ->addColumn('email', function($data) {
                return $data->email;
            })
            ->addColumn('phone', function($data) {
                return $data->phone;
            })
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return '<span class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-0fa958 bg-0fa958-10">'.__('Active').'</span>';
                } else {
                    return '<span class="zBadge-free">'.__('Deactivate').'</span>';
                }
            })
            ->rawColumns(['status'])
            ->make(true);
    }


    public function pending($request)
    {

        $query = Company::join('users', 'companies.user_id', '=', 'users.id')
            ->select('companies.*','users.email')
            ->Where('users.status', STATUS_INACTIVE);


        if ($request->has('search') && $request->search['value'] != '') {
            $search = $request->search['value'];
            $query->where(function ($q) use ($search) {
                $q->where('users.email', 'like', "%{$search}%")
                    ->orWhere('companies.name', 'like', "%{$search}%")
                    ->orWhere('companies.phone', 'like', "%{$search}%");
            });
        }
        if ($request->has('order') && $request->has('columns')) {
            foreach ($request->order as $order) {
                $orderBy = $request->columns[$order['column']]['data'];
                $orderDirection = $order['dir'];
                $query->orderBy($orderBy, $orderDirection);
            }
        } else {
            $query->orderBy('id', 'desc');
        }
        return datatables($query)
            ->addIndexColumn()
            ->addColumn('name', function ($data) {
                return $data->name;
            })
            ->addColumn('email',function($data){
                return $data->email;
            })
            ->addColumn('phone',function($data){
                return $data->phone;
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

            ->addColumn('action', function ($data) {
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                                <li class="d-flex gap-2">
                                    <a href="' . route('admin.company.details', $data->slug) . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View"><img src="' . asset('public/assets/images/icon/eye.svg') . '" alt="" /></a>
                                </li>
                            </ul>';

            })
            ->rawColumns(['company_logo', 'action', 'title', 'employee_status', 'status', 'application_deadline'])
            ->make(true);
    }
}
