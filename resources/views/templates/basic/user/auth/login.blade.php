@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="auth-section">
        <div class="container">
            <div class=" row align-items-lg-center justify-content-center justify-content-xl-between logins">
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="{{ getImage('assets/images/frontend/login/' . $loginContent->data_values->image, '1037x890') }}" alt="@lang('Image')" class="img-fluid">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="auth-section__form">
                        <h3 class="title mb-2">{{ __($loginContent->data_values->form_heading) }}</h3>
                        <p class="subtitle">{{ __($loginContent->data_values->form_subheading) }} </p>
                        <form method="POST" action="{{ route('user.login') }}" class="account-form verify-gcaptcha mt-3">
                            @csrf
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Username or Email')</label>
                                    <div class="custom-icon-field">
                                        <input type="text" name="username" value="{{ old('username') }}" class="form--control" placeholder="@lang('Username or email')" required>
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Password')</label>
                                    <div class="custom-icon-field">
                                        <input type="password" class="form--control" id="password-seen" name="password" placeholder="@lang('Password')" required>
                                        <i class="fas fa-lock"></i>
                                        <span class="input-eye"><i class="la la-eye"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <x-captcha :placeholder='true'></x-captcha>
                            </div>

                            <div class="d-flex justify-content-between form-group flex-wrap">
                                <div class="form-check custom--checkbox me-4">
                                    <input class="form-check-input" type="checkbox" {{ old('remember') ? 'checked' : '' }} id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        @lang('Remember Me')
                                    </label>
                                </div>

                                <a href="{{ route('user.password.request') }}" class="text--base">@lang('Forgot Password?')</a>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn--base w-100">@lang('SIGN IN ACCOUNT')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>.logins{
        margin-top: 30px;
    }
        </style>
@endsection
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
    </script>
@endpush
