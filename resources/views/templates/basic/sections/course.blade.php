@extends($activeTemplate . 'layouts.frontend')
@php
$eventData = DB::table('courses')->orderBy('id','asc')->get();
@endphp

<section class="banner-slider" id="inn-banner-slider">
    <div style="margin-top:150px ;" data-ride="carousel" class="carousel slide" id="carouselExampleIndicators">
        <div role="listbox" class="carousel-inner">
            <!-- Slide One - Set the background image for this slide in the line below -->
            <div style="background-image: url('assets/templates/basic/assetss/images/inn-banner.jpg')"
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



<section id="inn-section">
    <div style="max-width: 80rem;
    width: 100%;
    height: auto;
    padding: 0 2rem;
    margin: 0 auto;" class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 style="font-family: 'Oswald', sans-serif;font-size: 50px;
    color: #1f2120;
    line-height: 48px;
    font-weight: 800;
    margin-bottom: 10px;
    letter-spacing: 3px;">Our Courses</h1>
                <hr>
                <p>Please find below the courses</p>
                <hr>

            </div>

        </div>
        @foreach($eventData as $event)
        <div class="row course-box text-left">


            <div class="col-lg-2">
                <div class="course-img">
                    <img class="img-fluid" src="{{ env('IMAGE_SHOW_PATH').$event->image }}">
                </div>
            </div>
            <div class="col-lg-10">
                <div class="course-ctn">
                    <h3 style="color: #000000;
    font-size: 20px;
    line-height: 18px;
    font-weight: 500;
    font-family: 'Oswald', sans-serif;margin-bottom: 10px;">{{ $event->course_name ?? '' }}</h3>
                    <h4 style="    color: #004f80;
    font-size: 15px;
    line-height: 18px;
    font-weight: 500;
    margin-bottom: 10px;font-family: 'Oswald', sans-serif;margin-bottom: 10px;">{{ $event->course_type ?? '' }}</h4>
                    <p style="margin-bottom: 10px;">{{ $event->short_decsription ?? '' }}</p>
                    <a href="{{ url('single_course') }}/{{ $event->id }}" class="rmBtn-sm">View Course</a>
                </div>
            </div>


        </div>
        @endforeach

    </div>
</section>