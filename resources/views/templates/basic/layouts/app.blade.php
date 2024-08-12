<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> {{ $general->siteName(__($pageTitle)) }}</title>
    @include('partials.seo')
    
    <!--new-->
	<link rel="shortcut icon" type="image/png" href="{{url('/assets/templates/basic/assetss/images/favicon.png')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=ABeeZee:ital@0;1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet"> 
    <!-- Bootstrap core CSS -->
	<link href="{{url('/')}}/assets/templates/basic/assetss/css/bootstrap.min.css" rel="stylesheet">
	<link href="{{url('/')}}/assets/templates/basic/assetss/css/bootstrap-grid.css" rel="stylesheet">	
	<!-- Bootstrap core JavaScript -->
    <script src="{{url('/')}}/assets/templates/basic/assetss/js/jquery-3.3.1.slim.min.js"></script>
	<script src="{{url('/')}}/assets/templates/basic/assetss/js/popper.min.js"></script>
	<script src="{{url('/')}}/assets/templates/basic/assetss/js/bootstrap.min.js"></script>
	<!-- Owl Carousel Assets pranab --> 
    <link href="{{url('/')}}/assets/templates/basic/assetss/owl-carousel/css/owl.carousel.min.css" rel="stylesheet">
    <link href="{{url('/')}}/assets/templates/basic/assetss/owl-carousel/css/owl.theme.default.min.css" rel="stylesheet">
	<!-- Owl Carousel Assets pranab -->
    <!-- Custom styles for this template -->
	<link href="css/modern-business.css" rel="stylesheet">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">	
	<link rel="stylesheet" href="css/carousel.css">
	<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/templates/basic/assetss/css/reset.min.css">
	<link href="{{url('/')}}/assets/templates/basic/assetss/css/style.css" rel="stylesheet">
	<link href="{{url('/')}}/assets/templates/basic/assetss/css/responsive.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{url('/')}}/assets/templates/basic/assetss/css/menu-style.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.6.3/css/ionicons.min.css">
    <!--new-->

    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.min.css') }}" />

    <!-- slick slider css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/slick.css') }}">
    <!-- lightcase css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/lightcase.css') }}">
    <!-- jquery ui css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/jquery-ui.css') }}">
    <!-- datepicker css -->
    <link rel="stylesheet" href="{{ asset('assets/global/css/vendor/datepicker.min.css') }}">
    <!-- main css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/main.css') }}">

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom.css') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=ABeeZee&display=swap" rel="stylesheet">

    @include('partials.notify')
    @stack('style-lib')

    @stack('style')

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{ $general->base_color }}">
    
    

</head>

<body>
    @stack('fbComment')

    <!-- preloader start -->
    <div class="preloader">
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ getImage(getFilepath('logoIcon') . '/logo_dark.png') }}" alt="{{ __($general->site_name) }}" class="logo__is" />
        </a>
        <div class='preloader-dotline'>
            <div class='dot'></div>
            <div class='dot'></div>
            <div class='dot'></div>
            <div class='dot'></div>
            <div class='dot'></div>
            <div class='dot'></div>
            <div class='dot'></div>
            <div class='dot'></div>
        </div>
    </div>
    <!-- preloader end -->

    <div class="overlay"></div>

    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>

    @yield('layout')

    <!-- jQuery library -->
    <script src="{{ asset('assets/global/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>

    <!-- slick  slider js -->
    <script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>
    <!-- wow js  -->
    <script src="{{ asset($activeTemplateTrue . 'js/wow.min.js') }}"></script>

    <!-- lightcase js -->
    <script src="{{ asset($activeTemplateTrue . 'js/lightcase.js') }}"></script>

    <!-- jquery ui js -->
    <script src="{{ asset($activeTemplateTrue . 'js/jquery-ui.js') }}"></script>

    @stack('script-lib')
    <!-- main js -->
    <script src="{{ asset($activeTemplateTrue . 'js/app.js') }}"></script>
    @include('partials.plugins')
    @stack('script')


    <script>
        (function($) {
            "use strict";
            $(".langSel").on("change", function() {
                window.location.href = "{{ route('home') }}/change/" + $(this).val();
            });

            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
                matched = event.matches;
                if (matched) {
                    $('body').addClass('dark-mode');
                    $('.navbar').addClass('navbar-dark');
                } else {
                    $('body').removeClass('dark-mode');
                    $('.navbar').removeClass('navbar-dark');
                }
            });

            let matched = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (matched) {
                $('body').addClass('dark-mode');
                $('.navbar').addClass('navbar-dark');
            } else {
                $('body').removeClass('dark-mode');
                $('.navbar').removeClass('navbar-dark');
            }

            $('.policy').on('click', function() {
                $.get('{{ route('cookie.accept') }}', function(response) {
                    $('.cookies-card').addClass('d-none');
                });
            });

            setTimeout(function() {
                $('.cookies-card').removeClass('hide')
            }, 2000);

            $.each($('input, select, textarea'), function(i, element) {
                if (element.hasAttribute('required')) {
                    $(element).closest('.form-group').find('label').addClass('required');
                }
            });

        })(jQuery);
    </script>
    
    <script src="{{url('/')}}/assets/templates/basic/assetss/js/script.js" defer></script>
	<script src="{{url('/')}}/assets/templates/basic/assetss/js/carousel.js"></script> 
    <script src="{{url('/')}}/assets/templates/basic/assetss/owl-carousel/js/owl.carousel.js"></script>

<!-- End Owl pranab-->
		 <script>
            $(document).ready(function() {
              var owl = $('#owl-course');
              owl.owlCarousel({
                items: 3,
                loop: true,
				nav:false,
                margin: 0,
                autoplay: false,
                autoplayTimeout: 2000,
                autoplayHoverPause: true,
				responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:3
        }
    }
              });
              $('.play').on('click', function() {
                owl.trigger('play.owl.autoplay', [2000])
              })
              $('.stop').on('click', function() {
                owl.trigger('stop.owl.autoplay')
              })
            })
          </script>
		  <script>
            $(document).ready(function() {
              var owl = $('#owl-event');
              owl.owlCarousel({
                items: 1,
                loop: true,
				nav:false,
                margin: 0,
                autoplay: false,
                autoplayTimeout: 2000,
                autoplayHoverPause: true,
				responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
              });
              $('.play').on('click', function() {
                owl.trigger('play.owl.autoplay', [2000])
              })
              $('.stop').on('click', function() {
                owl.trigger('stop.owl.autoplay')
              })
            })
          </script>
<script>
            $(document).ready(function() {
              var owl = $('#owl-gallery');
              owl.owlCarousel({
                items: 3,
                loop: true,
				nav:false,
                margin: 0,
                autoplay: false,
                autoplayTimeout: 2000,
                autoplayHoverPause: true,
				responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:3
        }
    }
              });
              $('.play').on('click', function() {
                owl.trigger('play.owl.autoplay', [2000])
              })
              $('.stop').on('click', function() {
                owl.trigger('stop.owl.autoplay')
              })
            })
          </script>
          
          <script src="{{url('/')}}/assets/templates/basic/assetss/dist/simple-lightbox.js?v2.2.1"></script>
            <script>
                (function() {
                    var $gallery = new SimpleLightbox('.gallery a', '.gallery a p', {});
                })();
            </script>
          <script>

        // $('.portfolio-item').isotope({
        //  	itemSelector: '.item',
        //  	layoutMode: 'fitRows'
        //  });
         $('.portfolio-menu ul li').click(function(){
         	$('.portfolio-menu ul li').removeClass('active');
         	$(this).addClass('active');
         	
         	var selector = $(this).attr('data-filter');
         	$('.portfolio-item').isotope({
         		filter:selector
         	});
         	return  false;
         });
         $(document).ready(function() {
         var popup_btn = $('.popup-btn');
         popup_btn.magnificPopup({
         type : 'image',
         gallery : {
         	enabled : true
         }
         });
         });
</script>  
          
</body>

</html>
