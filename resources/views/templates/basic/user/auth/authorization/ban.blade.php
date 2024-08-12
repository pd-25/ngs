
@php
$content = getContent('banned_page.content', true);
@endphp

@extends($activeTemplate . 'layouts.app')
@section('layout')
    <div class="section flex-column justify-content-center m-auto">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-7 text-center">
                    <div class="row justify-content-center">
                        <div class="col-xl-10">
                            <h4 class="text--danger">{{ __(@$content->data_values->heading) }}</h4>
                        </div>
                        <div class="col-sm-6 col-8 col-lg-12 mt-3">
                            <img src="{{getImage('assets/images/frontend/banned_page/' . @$content->data_values->image, '660x320') }}" alt="@lang('image')" class="img-fluid mx-auto mb-5">
                        </div>
                    </div>
                    <p class="mx-auto text-center mb-3">{{ __($user->ban_reason) }}</p>
                    <a href="{{ route('home') }}" class="btn btn--base btn-sm"> <i class="las la-long-arrow-alt-left"></i> @lang('Go to Home')</a>
                </div>
            </div>
        </div>
    </div>
@endsection

