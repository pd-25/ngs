@extends($activeTemplate . 'layouts.frontend')
@section('content')
@php
$eventData = DB::table('courses')->orderBy('id','asc')->get();
@endphp

<section class="banner-slider" id="inn-banner-slider">
    <div data-ride="carousel" class="carousel slide" id="carouselExampleIndicators">
        <div role="listbox" class="carousel-inner">
            <!-- Slide One - Set the background image for this slide in the line below -->
            <div style="margin-top: 150px; background-image: url('assets/templates/basic/assetss/images/inn-banner.jpg')"
                class="carousel-item active">
            </div>
        </div>
    </div>
</section>
<!-- Page Content -->
<section id="marqe-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 col-4 marquee-heading mb-0">
                <p>Upcoming Courses</p>
            </div>
            <div class="col-lg-10 col-8">
                <div class="marquee-box">
                    <marquee direction="right">
                        <ul>
                            @foreach($eventData as $event)
                            <li>{{ $event->course_name ?? '' }} </li>
                            @endforeach

                        </ul>

                    </marquee>
                </div>
            </div>

        </div>

    </div>
</section>

    <!-- contact section start -->
    <section class="section">
        <div class="container">
            <div class="contact-wrapper pt-100 pb-100">
                <div class="contact-wrapper-right-thumb bg_img" style="background-image: url('{{ getImage('assets/images/frontend/contact_us/' . $contactCon->data_values->image, '900x1020') }}');">
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="contact-left-area bg_img" style="background-image: url('{{ getImage('assets/images/frontend/contact_us/' . $contactCon->data_values->image, '900x1020') }}');">
                            <div class="contact-info-wrapper">
                                <div class="contact-info-list mb-4">

                                    <div class="contact-info">
                                        <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
                                        <div class="content">
                                            <h6 class="title mb-1">@lang('Office Address')</h6>
                                            <p>{{ __($contactCon->data_values->address) }}</p>
                                        </div>
                                    </div><!-- contact-info end -->

                                    <div class="contact-info">
                                        <div class="icon"><i class="fas fa-envelope"></i></div>
                                        <div class="content">
                                            <h6 class="title mb-1">@lang('Email Address')</h6>
                                            <p>
                                                <a href="mailto:{{ $contactCon->data_values->email_address }}">{{ $contactCon->data_values->email_address }}</a>
                                            </p>
                                        </div>
                                    </div><!-- contact-info end -->

                                    <div class="contact-info">
                                        <div class="icon"><i class="fas fa-phone-alt"></i></div>
                                        <div class="content">
                                            <h6 class="title mb-1">@lang('Phone Number')</h6>
                                            <p><a href="tel:{{ $contactCon->data_values->contact_number }}">{{ $contactCon->data_values->contact_number }}</a>
                                            </p>
                                        </div>
                                    </div><!-- contact-info end -->

                                </div>
                                @if (count($socialElements) > 0)
                                    <h6 class="fs--16px text-center">@lang('Follow Us')</h6>
                                    <ul class="social-list justify-content-center mt-3">
                                        @foreach ($socialElements as $item)
                                            <li><a href="{{ $item->data_values->url }}" target="_blank">@php echo $item->data_values->social_icon @endphp</a></li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-lg-0 mt-4">
                        <div class="contact-right-area">
                            <div class="row mb-5">
                                <div class="col-lg-10">
                                    <h3 class="title mb-2">{{ __($contactCon->data_values->title) }}</h3>
                                    <p class="description">{{ __($contactCon->data_values->short_details) }}</p>
                                </div>
                            </div>
                            <form method="post" action="" class="verify-gcaptcha">
                                @csrf
                                @php
                                    $user = auth()->user();
                                    $name = @$user->fullname;
                                    $email = @$user->email;
                                @endphp

                                <div class="mb-3">
                                    <label>@lang('Name')</label>
                                    <div class="custom-icon-field">
                                        <input name="name" type="text" class="form--control" value="{{ old('name', $name) }}" @if ($user) readonly @endif placeholder="@lang('Enter Your Name')" required>
                                        <i class="fas fa-user-alt"></i>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label>@lang('Email')</label>
                                    <div class="custom-icon-field">
                                        <input name="email" type="email" class="form--control" value="{{ old('email', $email) }}" @if ($user) readonly @endif placeholder="@lang('Enter Email Address')" required>
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                </div>

                                <label>@lang('Subject')</label>
                                <div class="mb-3">
                                    <input name="subject" type="text" class="form--control" value="{{ old('subject') }}" placeholder="@lang('Enter Subject')" required>
                                </div>

                                <div class="mb-3">
                                    <label>@lang('Message')</label>
                                    <textarea name="message" wrap="off" class="form--control" placeholder="@lang('Write Message')" required>{{ old('message') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <x-captcha :placeholder='true'></x-captcha>
                                </div>

                                <button type="submit" class="btn btn--base">@lang('SEND MESSAGE')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="map-area">
        <!--<iframe src="https://maps.google.com/maps?q={{ @$contactCon->data_values->latitude }},{{ @$contactCon->data_values->longitude }}&hl=es;z=14&amp;output=embed"></iframe>-->
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3685.829640172799!2d88.31672977438576!3d22.51057407953592!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a027a012b2f5ff7%3A0xd8a584b8fd9f268f!2sMaritime%20Academy%20Of%20India-Nabik%20Griha%20Samity!5e0!3m2!1sen!2sin!4v1683733716091!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection
