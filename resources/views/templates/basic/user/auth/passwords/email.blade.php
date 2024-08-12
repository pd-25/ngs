@php
$content = getContent('account_recovery.content', true);
@endphp

@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="section">
        <div class="container">
            <div class="d-flex align-items-lg-center justify-content-center">
                <div class="col-lg-6 col-xl-5 col-md-8">
                    <div class="auth-section__form">
                        <p class="subtitle">@lang('To recover your account please provide your email or username to find your account.')</p>
                        <form method="POST" action="{{ route('user.password.email') }}" class="account-form mt-3">
                            @csrf
                            <div class="form-group">
                                <label>@lang('Username or Email')</label>
                                <div class="custom-icon-field">
                                    <input type="text" name="value" value="{{ old('username') }}"
                                           class="form--control" placeholder="@lang('Username or email')" required>
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
