@php
$bannerContent = getContent('banner.content', true);
@endphp

<section class="hero-section bg_img"
    style="background-image: url('{{ getImage('assets/images/frontend/banner/' . $bannerContent->data_values->banner_image, '1800x800') }}');">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8 col-xxl-7">
                <h2 class="hero-section__title text-center">{{ __(@$bannerContent->data_values->heading) }}</h2>
            </div>
            <div class="col-lg-12 mt-5">
                <form action="{{ route('room.type.filter') }}" method="get" autocomplete="off">
                    <div class="filter-wrapper">
                        <div class="row g-xxl-4 g-3">
                            <input type="hidden" name="banner_form" value="1">
                            <div class="col-lg-3 col-sm-12 col-md-6">
                                <div class="custom-icon-field">
                                    <input type="text" name="date" data-range="true"
                                        data-multiple-dates-separator=" - " data-language="en"
                                        class="datepicker-here form--control" data-position='top left'
                                        placeholder="@lang('Check In - Check Out')">
                                    <i class="las la-calendar-alt"></i>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-12 col-md-6">
                                <div class="custom-icon-field">
                                    <input type="number" min="0" name="total_adult" class="form--control"
                                        placeholder="@lang('Total Adult')" value="{{ old('total_adult') }}">
                                        <i class="las la-male"></i>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-12 col-md-6">
                                <div class="custom-icon-field">
                                    <input type="number" min="0" name="total_child" class="form--control"
                                        placeholder="@lang('Total Child')" value="{{ old('total_child') }}">
                                        <i class="las la-child"></i>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-12 col-md-6">
                                <button type="submit"
                                    class="btn fs--14px btn--base w-100 px-2">@lang('CHECK AVAILABILITY')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('script-lib')
    <script src="{{ asset('assets/global/js/vendor/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/vendor/datepicker.en.js') }}"></script>
@endpush
