@php
$content = getContent('password_reset.content', true);
@endphp

@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="section">
        <div class="container">
            <div class="row align-items-lg-center justify-content-center">
                <div class="col-lg-6 col-xl-5">
                    <div class="auth-section__form">
                        <p class="subtitle">@lang('Your account is verified successfully. Now you can change your password. Please enter a strong password and don\'t share it with anyone.')</p>
                        <form method="POST" action="{{ route('user.password.update') }}" class="account-form mt-3">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email }}">
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group">
                                <div class="secure-password-popup">
                                    <label>@lang('Password')</label>
                                    <div class="custom-icon-field">
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

                            <div class="form-group">
                                <label>@lang('Confirm Password')</label>
                                <div class="custom-icon-field">
                                    <input type="password" class="form--control" name="password_confirmation" placeholder="@lang('Confirm Password')" required>
                                    <i class="fas fa-lock"></i>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn--base w-100"> @lang('Submit')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-lib')
    <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush
@push('script')
    <script>
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

        (function($) {
            "use strict";
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
        })(jQuery);
    </script>
@endpush
