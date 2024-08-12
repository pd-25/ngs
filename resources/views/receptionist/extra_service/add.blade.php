@extends('receptionist.layouts.app')
@section('panel')
    <div class="row mb-none-30 justify-content-center">
        <div class="col-lg-8 col-xl-6 mb-30">
            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('receptionist.extra.service.save') }}" method="POST" class="add-service-form">
                        @csrf
                        <div class="row append-service">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group flex-fill">
                                    <label>@lang('Service Date')</label>
                                    <input name="service_date" type="text" data-range="false" data-language="en" class="datepickerHere form-control bg--white" data-position='bottom left' autocomplete="off" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <div class="form-group flex-fill">
                                    <label>@lang('Room Number')</label>
                                    <input class="form-control" type="text" name="room_number" required value="{{ request()->room }}">
                                </div>
                            </div>
                        </div>


                        <label class="required">@lang('Services')</label>

                        <div class="service-wrapper">
                            <div class="first-service-wrapper">
                                <div class="d-flex service-item position-relative mb-3 flex-wrap">
                                    <select class="custom-select no-right-radius flex-fill" name="services[]" required>
                                        <option value="">@lang('Select One')</option>
                                        @foreach ($extraServices as $extraService)
                                            <option value="{{ $extraService->id }}">
                                                {{ __($extraService->name) }} - {{ $general->cur_sym . showAmount($extraService->cost) }}/@lang('piece')
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="text" class="form-control w-unset flex-fill no-left-radius" placeholder="@lang('Quantity')" name="qty[]" required>

                                    <button type="button" class="btn--danger removeServiceBtn border-0" disabled>
                                        <i class="las la-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="button" class="btn btn--success addServiceBtn border-0">
                                <i class="las la-plus"></i>@lang('Add More')
                            </button>
                        </div>


                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .no-right-radius {
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }

        .no-left-radius {
            border-top-left-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
        }

        .removeServiceBtn {
            position: absolute;
            height: 25px;
            width: 25px;
            border-radius: 50%;
            text-align: center;
            line-height: 13px;
            font-size: 12px;
            right: -8px;
            top: -8px;
        }
    </style>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/vendor/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/vendor/datepicker.en.js') }}"></script>
@endpush

@push('script')
    <script>
        "use strict";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.datepickerHere').datepicker({
            autoClose: true,
            dateFormat: "yyyy-mm-dd"
        });

        $('.addServiceBtn').on('click', function() {
            const content = $('.first-service-wrapper').html();
            $('.service-wrapper').append(content);
            let firstItem = $('.first-service-wrapper button:disabled');

            $('.service-wrapper').find(':disabled').not(firstItem).removeAttr('disabled');
        });

        $(document).on('click', '.removeServiceBtn', function() {
            $(this).parents('.service-item').remove();

        });

        let serviceForm = $('.add-service-form');
        serviceForm.on('submit', function(e) {
            e.preventDefault();

            let formData = $(this).serialize();
            let url = $(this).attr('action');

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function(response) {
                    if (response.success) {
                        notify('success', response.success);
                        let firstItem = $('.first-service-wrapper .service-item');
                        $(document).find('.service-wrapper').find('.service-item').not(firstItem).remove();
                        serviceForm.trigger("reset");
                    } else {
                        $.each(response.error, function(key, value) {
                            notify('error', value);
                        });
                    }
                },
            });
        });
    </script>
@endpush
