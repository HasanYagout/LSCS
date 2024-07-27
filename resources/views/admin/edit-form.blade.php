<form method="POST" action="{{ route('admin.update') }}">
    @csrf
    <div class="modal-body zModalTwo-body model-lg">
        <div class="d-flex justify-content-between align-items-center pb-30">
            <h4 class="fs-20 fw-500 lh-38 text-1b1c17">{{__('Update New')}}</h4>
            <div class="mClose">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><img
                        src="{{asset('public/assets/images/icon/delete.svg')}}" alt="" /></button>
            </div>
        </div>
       <div class="row g-3">
           <div class="col-md-4">
               <div class="form-group">
                   <label for="first_name">First Name</label>
                   <input type="text" name="first_name" id="first_name" class="form-control" value="{{$admin->first_name}}" required>
               </div>
           </div>
           <div class="col-md-4">

               <div class="form-group">
                   <label for="last_name">Last Name</label>
                   <input type="text" name="last_name" id="last_name" class="form-control" value="{{$admin->last_name}}" required>
               </div>

           </div>
           <div class="col-md-4">
               <div class="form-group">
                   <label for="phone">Phone Number</label>
                   <input type="text" name="phone" id="phone" class="form-control" value="{{$admin->phone}}" required>
               </div>
           </div>
           <div class="col-md-4">
               <div class="form-group">
                   <label for="email">Email</label>
                   <input type="email" name="email" id="email" class="form-control" value="{{$userInfo->email}}" required>
               </div>
           </div>

           <div class="col-md-4">
               <div class="form-group">
                   <label for="type">Type</label>
                   <select class="primary-form-control sf-select-without-search" name="type" id="">
                       <option value="admin" {{$admin->role_id==1?'selected':''}}>Admin</option>
                       <option value="instructor"{{$admin->role_id==4?'selected':''}}>Instructor</option>
                   </select>
               </div>
           </div>

       </div>
    </div>

    <div class="modal-footer">
        <button type="submit"
                class="bd-ra-12 bg-cdef84 border-0 fs-15 fw-500 hover-bg-one lh-25 m-auto my-4 px-26 py-10 text-black w-auto">
            {{ __('Update') }}
        </button>
    </div>

</form>
