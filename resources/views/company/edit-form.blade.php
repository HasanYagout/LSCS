<form class="ajax reset" action="{{ route('admin.eventCategory.update', $company->id) }}" method="post"
      data-handler="commonResponseForModal">
    @csrf
    <div class="modal-body zModalTwo-body model-lg">
        <!-- Header -->
       <div class="d-flex justify-content-between align-items-center pb-30">
           <h4 class="fs-20 fw-500 lh-38 text-1b1c17">{{__('Update New')}}</h4>
           <div class="mClose">
           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><img src="{{asset('public/assets/images/icon/delete.svg')}}" alt="" /></button>
           </div>
       </div>
        <input type="hidden" name="id" value="{{$company->id}}">
        <div class="row">
            <div class="col-6">
                <div class="primary-form-group mt-2">
                    <div class="primary-form-group-wrap">
                      <label for="currentPassword" class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                      <input type="text" class="primary-form-control" name="name" value="{{$company->name}}">
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="primary-form-group mt-2">
                    <div class="primary-form-group-wrap">
                        <label for="currentPassword" class="form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                        <input type="text" class="primary-form-control" name="email" value="{{$company->email}}">
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="primary-form-group mt-2">
                    <div class="primary-form-group-wrap">
                        <label for="currentPassword" class="form-label">{{ __('Address') }} <span class="text-danger">*</span></label>
                        <input type="text" class="primary-form-control" name="address" value="{{$company->address}}">
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="primary-form-group mt-2">
                    <div class="primary-form-group-wrap">
                        <label for="currentPassword" class="form-label">{{ __('Website') }} <span class="text-danger">*</span></label>
                        <input type="text" class="primary-form-control" name="website" value="{{$company->website}}">
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="primary-form-group mt-2">
                    <div class="primary-form-group-wrap">
                        <label for="currentPassword" class="form-label">{{ __('Phone') }} <span class="text-danger">*</span></label>
                        <input type="text" class="primary-form-control" name="phone" value="{{$company->phone}}">
                    </div>
                </div>
            </div>


            <div class="col-6">
                <div class="primary-form-group mt-2">
                    <div class="primary-form-group-wrap">
                        <label for="currentPassword" class="form-label">{{ __('Logo') }} <span class="text-danger">*</span></label>
                        <img class="primary-form-control"  src="{{asset('public/storage/company'.'/'.$company->logo)}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="py-10 px-26 bg-cdef84 border-0 bd-ra-12 fs-15 fw-500 lh-25 text-black hover-bg-one">{{ __('Update') }}</button>
    </div>
</form>
