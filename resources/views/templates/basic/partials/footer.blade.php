@php
$socialElement = getContent('social_icon.element', false, null, true);
$policyElement = getContent('policy_pages.element', false, null, true);
$footerContent = getContent('footer.content', true);
$contactContent = getContent('contact_us.content', true);
@endphp

<footer class="footer-section bg_img" style="background-image: url('assets/images/frontend/footer/6458a5a47c8331683531172.jpg') !important;">
    <div class="footer-section__top">
        <div class="position-relative z-index-2 container">

            <div class="row gy-5 justify-content-between">
                <div class="col-lg-4 col-sm-6">
                    <div class="footer-widget">
                        <a href="{{ route('home') }}" class="footer-logo">
                            <img src="{{ asset('assets/images/logoIcon/logo_dark.png') }}" alt="image">
                        </a>
                        <p class="footer-about mt-3 text-white">@php echo trans(@$footerContent->data_values->description) @endphp</p>
                        @if (count($socialElement) > 0)
                            <ul class="social-links mt-4">
                                @foreach ($socialElement as $social)
                                    <li>
                                        <a href="{{ $social->data_values->url }}" target="_blank">
                                            @php
                                                echo $social->data_values->social_icon;
                                            @endphp
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6">
                    <div class="footer-widget">
                        <h5 class="footer-widget__title">@lang('Company')</h5>
                        <ul class="footer-short-links">
                            @php
                                $pages = App\Models\Page::where('tempname', $activeTemplate)
                                    ->where('is_default', 0)
                                    ->get();
                            @endphp

                            @foreach ($pages as $k => $data)
                                <li>
                                    <a href="{{ route('pages', [$data->slug]) }}">{{ __($data->name) }}</a>
                                </li>
                            @endforeach
                            <li>
                                <a href="{{ route('contact') }}">@lang('Contact')</a>
                            </li>
                            <li>
                                <a href="{{ route('blog') }}">@lang('Blog')</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="footer-widget">
                        <h5 class="footer-widget__title">@lang('Useful Link')</h5>
                        <ul class="footer-short-links">
                            @foreach ($policyElement as $policy)
                                <li>
                                    <a
                                       href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}">@php
                                           echo $policy->data_values->title;
                                       @endphp</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="footer-widget">
                        <h5 class="footer-widget__title">@lang('Contact Us')</h5>
                        <ul class="footer-contact-info">
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <p>{{ __($contactContent->data_values->address) }}</p>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <p><a
                                       href="mailto:{{ __($contactContent->data_values->email_address) }}">{{ __($contactContent->data_values->email_address) }}</a>
                                </p>
                            </li>
                            <li>
                                <i class="fas fa-phone-alt"></i>
                                <p><a
                                       href="tel:{{ __($contactContent->data_values->contact_number) }}">{{ __($contactContent->data_values->contact_number) }}</a>
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-section__bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p class="text-white">@lang('Copyright') &copy {{ date('Y') }}
                        @lang('All Right Reserved'). Nabik Griha | Design and Developed By <a href="https://www.webredas.com/" target="_blank" style="color:#9bdbc1 !important;">Webredas</a></p>
                </div>
            </div>
        </div>
    </div>
</footer>

@php
$cookie = App\Models\Frontend::where('data_keys', 'cookie.data')->first();
@endphp
@if ($cookie->data_values->status == 1 && !\Cookie::get('gdpr_cookie'))
    <div id="cookiePolicy" class="cookies-card bg--default radius--10px hide text-center">
        <div class="cookies-card__icon">
            <i class="fas fa-cookie-bite"></i>
        </div>
        <p class="cookies-card__content mt-4">
            @php
                echo @$cookie->data_values->short_desc;
            @endphp
            <a href="{{ route('cookie.policy') }}" target="_blank">@lang('learn more')</a>
        </p>
        <div class="cookies-card__btn mt-4">
            <button type="button" class="cookies-btn btn btn--base policy">@lang('Allow')</button>
        </div>
    </div>
@endif

@push('style-lib')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/cookie.css') }}">
@endpush
