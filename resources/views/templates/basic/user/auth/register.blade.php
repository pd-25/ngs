@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
    $policyPages = getContent('policy_pages.element', false, null, true);
    $registerContent = getContent('register.content', true);
    @endphp

    <div class="auth-section">
        <div class="container">
            <div class="row align-items-lg-center justify-content-center justify-content-xl-between registers">
                <div class="col-lg-5 d-none d-lg-block">
                    <img src="{{ getImage('assets/images/frontend/register/' . $registerContent->data_values->image, '1037x890') }}" alt="@lang('Image')" class="img-fluid">
                </div>
                <div class="col-md-10 col-lg-7 col-xl-6">
                    <div class="auth-section__form">
                        <h3 class="title mb-2">{{ __($registerContent->data_values->form_heading) }}</h3>
                        <p class="subtitle">{{ __($registerContent->data_values->form_subheading) }} </p>
                        <form class="account-form verify-gcaptcha mt-3" action="{{ route('user.register') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('Username')</label>
                                        <div class="custom-icon-field">
                                            <input type="text" name="username" class="form--control checkUser" placeholder="@lang('Username')" value="{{ old('username') }}" required>
                                            <i class="fas fa-user"></i>
                                            <small class="text-danger usernameExist"></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('Email')</label>
                                        <div class="custom-icon-field">
                                            <input type="email" name="email" class="form--control checkUser" value="{{ old('email') }}" placeholder="@lang('Email Address')" required>
                                            <i class="fas fa-user"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="secure-password-popup">
                                            <label>@lang('Password')</label>
                                            <div class="custom-icon-field hover-input-popup">
                                                <input type="password" class="form--control" id="password-seen" name="password" placeholder="@lang('Password')" required>
                                                <i class="fas fa-lock"></i>
                                                <span class="input-eye"><i class="far fa-eye"></i></span>
                                            </div>
                                            @if ($general->secure_password)
                                                <div class="input-popup">
                                                    <p class="error lower">@lang('1 small letter minimum')</p>
                                                    <p class="error capital">@lang('1 capital letter minimum')</p>
                                                    <p class="error number">@lang('1 number minimum')</p>
                                                    <p class="error special">@lang('1 special character minimum')</p>
                                                    <p class="error minimum">@lang('6 character password')</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label>@lang('Confirm Password')</label>
                                    <div class="custom-icon-field">
                                        <input type="password" class="form--control" name="password_confirmation" placeholder="@lang('Confirm Password')" required>
                                        <i class="fas fa-lock"></i>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>@lang('Country')</label>
                                        <div class="custom-icon-field">
                                            <select name="country" class="select">
                                                @foreach ($countries as $key => $country)
                                                    <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}">
                                                        {{ __($country->country) }}</option>
                                                @endforeach
                                            </select>
                                            <i class="fas fa-lock"></i>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">@lang('Mobile')</label>
                                        <div class="input-group">
                                            <span class="input-group-text mobile-code" id="basic-addon1"></span>
                                            <input type="hidden" name="mobile_code">
                                            <input type="hidden" name="country_code">
                                            <input type="number" name="mobile" value="{{ old('mobile') }}" class="form--control checkUser" placeholder="@lang('Phone')" required>
                                            <small class="text-danger mobileExist"></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <x-captcha :placeholder='true'></x-captcha>
                                </div>

                                @if ($general->agree)
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-check custom--checkbox">
                                                <input class="form-check-input" type="checkbox" id="agree" @checked(old('agree')) name="agree">
                                                <label class="form-check-label" for="agree">
                                                    @lang('I agree with') @foreach ($policyPages as $policy)
                                                        <a class="text--base" href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}">{{ __($policy->data_values->title) }}</a>
                                                        @if (!$loop->last)
                                                            ,
                                                        @endif
                                                    @endforeach
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn--base w-100">@lang('CREATE AN ACCOUNT')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>.registers{
        margin-top: 30px;
    }
        </style>
@endsection
@push('script-lib')
    <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush
@push('script')
    <script>
        "use strict";
        (function($) {
            @if ($mobile_code)
                $(`option[data-code={{ $mobile_code }}]`).attr('selected', '');
            @endif
            $('select[name=country]').change(function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));

            @if ($general->secure_password)
                $('input[name=password]').on('input', function() {
                    secure_password($(this));
                });
                $('[name=password]').focus(function() {
                    $(this).closest('.secure-password-popup').addClass('hover-input-popup');
                });
                $('[name=password]').focusout(function() {
                    $(this).closest('.secure-password-popup').removeClass('hover-input-popup');
                });
            @endif

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false && response.type == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });
        })(jQuery);



        $('.input-eye i').on('click', function() {
            if (localStorage.clickcount === undefined) {
                localStorage.clickcount = 1;
                document.getElementById("password-seen").setAttribute("type", "text");
                $(this).removeClass('active');
            } else {
                document.getElementById("password-seen").setAttribute("type", "password");
                $(this).addClass('active');
                localStorage.clear();
            }
        });
    </script>
@endpush
