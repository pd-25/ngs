@extends($activeTemplate . 'layouts.frontend')
@php
$galleryData = DB::table('gallery')->orderBy('id','DESC')->get();
@endphp
@php
$galleryDeta = DB::table('gallery_category')->orderBy('id','DESC')->get();
@endphp
@php
$eventData = DB::table('courses')->orderBy('id','asc')->get();
@endphp
@section('content')

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



<section id="inn-section">
    <div class="container mainsize">
        <div class="row mb-4 justify-content-center">
            <div class="col-lg-10 text-center">
                <h2>Our Gallery</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="portfolio-menu mt-2 mb-4">
                    <ul>

                        <button class="btn btn-outline-dark active category_id" data-id="0">All</button>
                        @foreach($galleryDeta as $item)

                        <button class="btn btn-outline-dark category_id"
                            data-id="{{ __($item->id) }}">{{ __($item->gallery_category) }}</button>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>




        <div class="portfolio-item row append_image">

        </div>





    </div>
</section>

<style>
    .mfp-content{margin-top: 130px !important}
    </style>


<script src="https://code.jquery.com/jquery-3.6.4.slim.min.js"
    integrity="sha256-a2yjHM4jnF9f54xUQakjZGaqYs/V1CYvWpoqZzC2/Bw=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function () {
        var baseurl = "{{ url('/') }}";

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: baseurl + '/filter_image_bycategory',
            data: {
                category_id: 0
            },
            success: function (response) {
                //alert(response);
                $(".append_image").html('');
                $(".append_image").html(response);
            }
        })

        $(".category_id").on('click', function () {
            var category_id = $(this).data('id');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: baseurl + '/filter_image_bycategory',
                data: {
                    category_id: category_id
                },
                success: function (response) {
                    //alert(response);
                    $(".append_image").html('');
                    $(".append_image").html(response);
                }
            })
        })

    });
</script>

@endsection