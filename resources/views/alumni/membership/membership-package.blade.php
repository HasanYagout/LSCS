@extends('layouts.app')

@push('title')
{{$title}}
@endpush

@section('content')
<!-- Page content area start -->
<div class="p-30">
	<div class="">
		<h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{$title}}</h4>
		<div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
			<div class="row justify-content-center">
				<div class="col-lg-10">
					<!-- Current Member status -->
					<div class="py-16 px-24 mb-30 bd-ra-20 bg-f9f9f9 d-inline-flex cg-10">
						@if($user->currentMembership)
						<p
							class="align-items-center bg-success d-flex flex-shrink-0 fs-20 fw-600 h-40 justify-content-center lh-28 rounded-circle text-white w-40">
							<i class="fa-solid fa-check"></i></p>
						@else
						<p
							class="flex-shrink-0 w-40 h-40 rounded-circle bg-fdedeb d-flex justify-content-center align-items-center fs-20 fw-600 lh-28 text-ea4335">
							!</p>
						@endif
						<div class="">
							@if($user->currentMembership)
							<h4 class="fs-18 fw-500 lh-28 text-black pb-6">{{ __('Currently you are') }} {{
								$user->currentMembership->membership->title }} {{ __('Member') }}</h4>
							<p
								class="d-inline-block py-5 px-9 bd-one bd-c-ededed bd-ra-7 bg-1b1c17 fs-12 fw-500 lh-22 text-white">
								{{
								__('Expire at') }} : {{ $user->currentMembership->expired_date }}</p>
							@else
							<h4 class="fs-18 fw-500 lh-28 text-black pb-6">{{ __('Currently you have no membership
								plan') }}</h4>
							@endif
						</div>
					</div>
					<!-- Member ship package -->
					<div class="row rg-30">
						@forelse ($allMembership as $membership)
						<div class="col-lg-4 col-sm-6">
							<div class="membership-plan bd-one bd-c-ededed bd-ra-12 p-20 {{ ($user->currentMembership && $user->currentMembership->membership_id == $membership->id) ? 'active' : '' }}">
								<div class="bd-b-one bd-c-ededed pb-20 mb-20">
									<div class="max-w-60 mb-10"><img src="{{getFileUrl($membership->badge)}}" alt="">
									</div>
									<h4 class="fs-18 fw-500 lh-18 text-black pb-10">{{$membership->title}}</h4>
									<p class="fs-14 fw-500 lh-14 text-707070"><span
											class="fs-32 fw-600 lh-32 text-1b1c17">{{showPrice($membership->price)}}</span>/{{$membership->duration}}{{getDurationType($membership->duration_type)}}</p>
								</div>
								@if($user->currentMembership && $user->currentMembership->membership_id == $membership->id)
								<button class="zBtn-two">{{ __('Get Membership') }}</button>
								@else
								<a href="{{ route('checkout', ['type' => 'membership', 'slug' => $membership->slug]) }}" class="fs-15 fw-500 lh-25 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one">{{__('Get Membership')}}</a>
								@endif
							</div>
						</div>
						@empty
						<div class="text-center py-5">{{ __('No Data Found') }}</div>
						@endforelse
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Page content area end -->

@endsection
