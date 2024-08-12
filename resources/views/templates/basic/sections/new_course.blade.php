
<section class="banner-slider" id="inn-banner-slider">
    <div style="margin-top: 150px;" data-ride="carousel" class="carousel slide" id="carouselExampleIndicators">
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
                            
                            <li>yes </li>
                            
                            <li>hello </li>
                            
                            <li>hello </li>
                            
                            <li>Gallery1 </li>
                            
                            <li>guigiuiguigiug8 </li>
                            
                            <li>testing </li>
                            
                            <li>Gallery1 </li>
                            
                            <li>Gallery1 </li>
                            
                            <li>Gallery1 </li>
                            
                            <li>Gallery1 </li>
                            
                            <li>Gallery1 </li>
                            
                            <li>Gallery1 </li>
                            
                            <li>Gallery1 </li>
                            
                        </ul>

                    </marquee>
                </div>
            </div>

        </div>

    </div>
</section>



<section id="inn-section">
    <div class="container">
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
                        
                        <button class="btn btn-outline-dark category_id" data-id="4">gallery 3</button>
                       
                        
                        <button class="btn btn-outline-dark category_id" data-id="3">gallery 2</button>
                       
                        
                        <button class="btn btn-outline-dark category_id" data-id="2">testing test</button>
                       
                        
                    </ul>
                </div>
            </div>
        </div>
        <div class="portfolio-item row append_image">

           

        </div>


    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.4.slim.min.js" integrity="sha256-a2yjHM4jnF9f54xUQakjZGaqYs/V1CYvWpoqZzC2/Bw=" crossorigin="anonymous"></script>

<script>
$(document).ready(function(){
    var baseurl = "http://localhost/nabik-griha";

    $.ajax({
        		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        		type: 'POST',
        		url: baseurl+'/filter_image_bycategory',
    		    data: {category_id: 0},
        		success: function (response) {
        		    //alert(response);
                    $(".append_image").html('');
                    $(".append_image").html(response);
        		}
        	})  
    
    $(".category_id").on('click', function(){
        var category_id = $(this).data('id');
      
        $.ajax({
        		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        		type: 'POST',
        		url: baseurl+'/filter_image_bycategory',
    		    data: {category_id: category_id},
        		success: function (response) {
        		    //alert(response);
                    $(".append_image").html('');
                    $(".append_image").html(response);
        		}
        	})        
    })
    
});

    </script>



<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="W4Gj8ISjJ4I9NZviZnsFo09w4MT1EKbS2Rd4gubY">
    <title> Nabik Griha - Gallery</title>
    <meta name="title" Content="Nabik Griha - Gallery">

    <meta name="description" content="Nabik Griha - Ultimate hotel booking solution.">
    <meta name="keywords" content="hotel,booking,hote booking,room booking,reservation,room reservation">
    <link rel="shortcut icon" href="http://localhost/nabik-griha/assets/images/logoIcon/favicon.png" type="image/x-icon">

    
    <link rel="apple-touch-icon" href="http://localhost/nabik-griha/assets/images/logoIcon/logo.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Nabik Griha - Gallery">
    
    <meta itemprop="name" content="Nabik Griha - Gallery">
    <meta itemprop="description" content="Nabik Griha - Ultimate hotel booking solution.">
    <meta itemprop="image" content="http://localhost/nabik-griha/assets/images/seo/6458a41bea4a51683530779.png">
    
    <meta property="og:type" content="website">
    <meta property="og:title" content="Nabik Griha">
    <meta property="og:description" content="Nabik Griha - Ultimate hotel booking solution.">
    <meta property="og:image" content="http://localhost/nabik-griha/assets/images/seo/6458a41bea4a51683530779.png" />
    <meta property="og:image:type" content="png" />
    <meta property="og:image:width" content="1180" />
    <meta property="og:image:height" content="600" />
    <meta property="og:url" content="http://localhost/nabik-griha/gallery">
    
    <meta name="twitter:card" content="summary_large_image">
    
    <!--new-->
	<link rel="shortcut icon" type="image/png" href="assets/templates/basic/assetss/images/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=ABeeZee:ital@0;1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet"> 
    <!-- Bootstrap core CSS -->
	<link href="assets/templates/basic/assetss/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/templates/basic/assetss/css/bootstrap-grid.css" rel="stylesheet">	
	<!-- Bootstrap core JavaScript -->
    <script src="assets/templates/basic/assetss/js/jquery-3.3.1.slim.min.js"></script>
	<script src="assets/templates/basic/assetss/js/popper.min.js"></script>
	<script src="assets/templates/basic/assetss/js/bootstrap.min.js"></script>
	<!-- Owl Carousel Assets pranab --> 
    <link href="assets/templates/basic/assetss/owl-carousel/css/owl.carousel.min.css" rel="stylesheet">
    <link href="assets/templates/basic/assetss/owl-carousel/css/owl.theme.default.min.css" rel="stylesheet">
	<!-- Owl Carousel Assets pranab -->
    <!-- Custom styles for this template -->
	<link href="css/modern-business.css" rel="stylesheet">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">	
	<link rel="stylesheet" href="css/carousel.css">
	<link rel="stylesheet" type="text/css" href="assets/templates/basic/assetss/css/reset.min.css">
	<link href="assets/templates/basic/assetss/css/style.css" rel="stylesheet">
	<link href="assets/templates/basic/assetss/css/responsive.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="assets/templates/basic/assetss/css/menu-style.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.6.3/css/ionicons.min.css">
    <!--new-->

    <!-- Bootstrap CSS -->
    <link href="http://localhost/nabik-griha/assets/global/css/bootstrap.min.css" rel="stylesheet">

    <link href="http://localhost/nabik-griha/assets/global/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="http://localhost/nabik-griha/assets/global/css/line-awesome.min.css" />

    <!-- slick slider css -->
    <link rel="stylesheet" href="http://localhost/nabik-griha/assets/templates/basic/css/slick.css">
    <!-- lightcase css -->
    <link rel="stylesheet" href="http://localhost/nabik-griha/assets/templates/basic/css/lightcase.css">
    <!-- jquery ui css -->
    <link rel="stylesheet" href="http://localhost/nabik-griha/assets/templates/basic/css/jquery-ui.css">
    <!-- datepicker css -->
    <link rel="stylesheet" href="http://localhost/nabik-griha/assets/global/css/vendor/datepicker.min.css">
    <!-- main css -->
    <link rel="stylesheet" href="http://localhost/nabik-griha/assets/templates/basic/css/main.css">

    <link rel="stylesheet" href="http://localhost/nabik-griha/assets/templates/basic/css/custom.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=ABeeZee&display=swap" rel="stylesheet">

            <link rel="stylesheet" href="http://localhost/nabik-griha/assets/templates/basic/css/cookie.css">
    <link rel="stylesheet" href="http://localhost/nabik-griha/assets/global/css/iziToast.min.css">

    
    <link rel="stylesheet" href="http://localhost/nabik-griha/assets/templates/basic/css/color.php?color=004f80">
    
    

</head>

<body>
    
    <!-- preloader start -->
    <div class="preloader">
        <a href="http://localhost/nabik-griha" class="logo">
            <img src="http://localhost/nabik-griha/assets/images/logoIcon/logo_dark.png" alt="Nabik Griha" class="logo__is" />
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

        <header class="header py-0">
 		<div class="header__top">
 			<div class="container-fluid">
 				<div class="row gy-2 align-items-center">
 					<div class="col-lg-6">
 						<ul class="header-info-list justify-content-lg-start justify-content-center">
 							<li>
 								<a href="mailto:nabikgriha@gmail.com"><i class="fa fa-envelope"></i>
 									nabikgriha@gmail.com</a>
 							</li>
 							<li>
 								<a href="tel:9433523336"><i class="fa fa-phone"></i> 9433523336</a>
 							</li>
 						</ul>
 					</div>
 					<div class="col-lg-6">
 						<div class="header-top-right justify-content-lg-end justify-content-center">
 							<div class="header-top-action-wrapper">
 								<a href="https://ngs-mai.com/panel/user/login" class="header-user-btn mr-3"><i
 										class="fa fa-sign-in"></i> Room Booking</a>
 								<a href="https://ngs-mai.com/panel/user/register" class="header-user-btn"><i
 										class="fa fa-user"></i> Courses Booking</a>

 							</div>
 						</div>
 					</div>
 				</div>
 			</div>
 		</div>

 		<div class="header__bottom">
 			<div class="container-fluid">
 				<div class="row">
 					<div class="col-lg-2 mob-off align-self-center">
 						<a href="http://localhost/nabik-griha"><img src="http://localhost/nabik-griha/assets/images/logoIcon/logo.png" class="img-fluid" style="width:200px;"></a>
 					</div>
 					<!-- Section: Navbar Menu -->
 					<div class="col-lg-8 col-12 align-self-center">

 						<!--<div class="overlay"></div>-->
 						<nav class="menu">
 							<div class="menu-mobile-header">
 								<button type="button" class="menu-mobile-arrow"><i
 										class="ion ion-ios-arrow-back"></i></button>
 								<div class="menu-mobile-title"></div>
 								<button type="button" class="menu-mobile-close"><i
 										class="ion ion-ios-close"></i></button>
 							</div>
 							<ul class="menu-section">
 								<li><a href="http://localhost/nabik-griha" class="">HOME</a>
                                </li>
                                                                                                   <!-- <li>
                                        <a href="http://localhost/nabik-griha/faq" class="">FAQS</a>
                                    </li>-->
                                                                   <!-- <li>
                                        <a href="http://localhost/nabik-griha/vision-mission-core-value" class="">VISION MISSION &amp; CORE VALUE</a>
                                    </li>-->
                                 
        
                                <!--<li>
                                <a href="http://localhost/nabik-griha/abouts" class="">ABOUT US</a>
                                </li>-->
                                <li class="menu-item-has-children">
									<a href="#">About Us<i class="ion ion-ios-arrow-down"></i></a>
									<div class="menu-subs menu-column-1">
										<ul>
											<li><a href="http://localhost/nabik-griha/abouts">About Nabik Griha</a></li>
											<li><a href="http://localhost/nabik-griha/about_maritime">About Maritime Academy</a></li>
										</ul>
									</div>
								</li>
                                <li>
                                <a href="http://localhost/nabik-griha/courses" class="">COURSES</a>
                                </li>
                                <li>
                                    <a href="http://localhost/nabik-griha/gallery" class="">GALLERY</a>
                                </li>
                                <!--<li>
                                    <a href="http://localhost/nabik-griha/event" class="">EVENT</a>
                                </li>-->
                               
        
                                <!-- <li>
                                    <a href="http://localhost/nabik-griha/updates" class="">UPDATES</a>
                                </li> -->
        
                                <li>
                                    <a href="http://localhost/nabik-griha/contact" class="">CONTACT</a>
                                </li>
 							</ul>
 						</nav>
 					</div>
 					<div class="col-lg-2 mob-off align-self-center">
 						<a href="http://localhost/nabik-griha"><img src="http://localhost/nabik-griha/assets/images/logoIcon/logo2.png" class="img-fluid"></a>
 					</div>



 				</div>

 				<div class="row justify-content-between">
 					<div class="col-4">
 						<div class="header-item-right">
 							<button type="button" class="menu-mobile-trigger">
 								<span></span>
 								<span></span>
 								<span></span>
 								<span></span>
 							</button>
 						</div>
 					</div>
 					<div class="col-4 align-self-center desk-off">
 						<a href="http://localhost/nabik-griha"><img src="http://localhost/nabik-griha/assets/images/logoIcon/logo.png" class="img-fluid"></a>
 					</div>

 					<div class="col-4 align-self-center desk-off">
 						<a href="http://localhost/nabik-griha"><img src="http://localhost/nabik-griha/assets/images/logoIcon/logo2.png" class="img-fluid"></a>
 					</div>

 				</div>


 			</div>
 		</div>
 	</header>
<!--<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row gy-2 align-items-center">
                <div class="col-lg-5 d-sm-block d-none">
                    <ul class="header-info-list justify-content-lg-start justify-content-center">
                        <li>
                            <a href="mailto:nabikgriha@gmail.com"><i class="fas fa-envelope"></i> nabikgriha@gmail.com</a>
                        </li>

                        <li>
                            <a href="tel:9433523336"><i class="fas fa-phone-alt"></i> +9433523336</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-7">
                    <div class="header-top-right justify-content-lg-end justify-content-center">
                        <div class="header-top-action-wrapper">
                                                                                        <a href="http://localhost/nabik-griha/user/login" class="header-user-btn me-3"><i class="las la-sign-in-alt"></i> Sign in</a>
                                <a href="http://localhost/nabik-griha/user/register" class="header-user-btn"><i class="las la-user"></i> Register</a>
                            
                                                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header__bottom">
        <div class="container">
            <nav class="navbar navbar-expand-xl align-items-center">
                <a class="site-logo site-title" href="http://localhost/nabik-griha">
                    <img src="http://localhost/nabik-griha/assets/images/logoIcon/logo.png" alt="logo">
                </a>
                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="menu-toggle"></span>
                </button>
                <div class="collapse navbar-collapse mt-lg-0 mt-3" id="navbarSupportedContent">
                    <ul class="navbar-nav main-menu ms-auto">
                        <li><a href="http://localhost/nabik-griha" class="">HOME</a>
                        </li>
                                                                            <li>
                                <a href="http://localhost/nabik-griha/faq" class="">FAQS</a>
                            </li>
                                                    <li>
                                <a href="http://localhost/nabik-griha/vision-mission-core-value" class="">VISION MISSION &amp; CORE VALUE</a>
                            </li>
                        
                        <li>
                        <a href="http://localhost/nabik-griha/abouts" class="">ABOUT US</a>
                        </li>
                        <li>
                        <a href="http://localhost/nabik-griha/courses" class="">COURSES</a>
                        </li>
                        <li>
                            <a href="http://localhost/nabik-griha/gallery" class="">GALLERY</a>
                        </li>
                        <li>
                            <a href="http://localhost/nabik-griha/event" class="">EVENT</a>
                        </li>
                       

                        <li>
                            <a href="http://localhost/nabik-griha/updates" class="">UPDATES</a>
                        </li> 

                        <li>
                            <a href="http://localhost/nabik-griha/contact" class="">CONTACT</a>
                        </li>
                    </ul>
                    <div class="nav-right justify-content-xl-end ps-0 ps-xl-5">
                        <a href="http://localhost/nabik-griha/book-online" class="btn btn-sm btn--base me-3"><i class="las la-user me-2"></i>BOOK ONLINE</a>
                                            </div>

                </div>
            </nav>
        </div>
    </div>
</header>-->
            
        <!-- <section class="inner-hero bg_img" style="background-image: url('http://localhost/nabik-griha/assets/images/frontend/banner/6458a48293cd21683530882.jpg');">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <h2 class="title text-white">Gallery</h2>
                </div>
            </div>
        </div>
    </section> -->
        <main class="main-wrapper">
            </main>
    <footer class="footer-section bg_img" style="background-image: url('http://localhost/nabik-griha/assets/images/frontend/footer/6458a5a47c8331683531172.jpg');">
    <div class="footer-section__top">
        <div class="position-relative z-index-2 container">

            <div class="row gy-5 justify-content-between">
                <div class="col-lg-4 col-sm-6">
                    <div class="footer-widget">
                        <a href="http://localhost/nabik-griha" class="footer-logo">
                            <img src="http://localhost/nabik-griha/assets/images/logoIcon/logo_dark.png" alt="image">
                        </a>
                        <p class="footer-about mt-3 text-white">Nullam at venenatis sem, tristique luctus quam ut rci, at consectetur metus blandit lacus nec malesuada tristique.</p>
                                                    <ul class="social-links mt-4">
                                                                    <li>
                                        <a href="https://www.google.com/" target="_blank">
                                            <i class="fab fa-facebook-f"></i>                                        </a>
                                    </li>
                                                                    <li>
                                        <a href="https://twitter.com/" target="_blank">
                                            <i class="fab fa-twitter"></i>                                        </a>
                                    </li>
                                                                    <li>
                                        <a href="https://www.instagram.com/" target="_blank">
                                            <i class="fab fa-instagram"></i>                                        </a>
                                    </li>
                                                                    <li>
                                        <a href="https://www.linkedin.com/" target="_blank">
                                            <i class="fab fa-linkedin-in"></i>                                        </a>
                                    </li>
                                                            </ul>
                                            </div>
                </div>
                <div class="col-lg-2 col-sm-6">
                    <div class="footer-widget">
                        <h5 class="footer-widget__title">Company</h5>
                        <ul class="footer-short-links">
                            
                                                            <li>
                                    <a href="http://localhost/nabik-griha/faq">FAQs</a>
                                </li>
                                                            <li>
                                    <a href="http://localhost/nabik-griha/vision-mission-core-value">Vision Mission &amp; Core Value</a>
                                </li>
                                                        <li>
                                <a href="http://localhost/nabik-griha/contact">Contact</a>
                            </li>
                            <li>
                                <a href="http://localhost/nabik-griha/updates">Blog</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="footer-widget">
                        <h5 class="footer-widget__title">Useful Link</h5>
                        <ul class="footer-short-links">
                                                            <li>
                                    <a
                                       href="http://localhost/nabik-griha/policy/privacy-policy/42">Privacy Policy</a>
                                </li>
                                                            <li>
                                    <a
                                       href="http://localhost/nabik-griha/policy/terms-of-service/43">Terms of Service</a>
                                </li>
                                                            <li>
                                    <a
                                       href="http://localhost/nabik-griha/policy/refund-and-cancellation-policy/100">Refund and Cancellation Policy</a>
                                </li>
                                                    </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="footer-widget">
                        <h5 class="footer-widget__title">Contact Us</h5>
                        <ul class="footer-contact-info">
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <p>1/1 Taratala Road, Sahapur, Kolkata 700 038</p>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <p><a
                                       href="mailto:nabikgriha@gmail.com">nabikgriha@gmail.com</a>
                                </p>
                            </li>
                            <li>
                                <i class="fas fa-phone-alt"></i>
                                <p><a
                                       href="tel:9433523336">9433523336</a>
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
                    <p class="text-white">Copyright &copy 2023
                        All Right Reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>



    <!-- jQuery library -->
    <script src="http://localhost/nabik-griha/assets/global/js/jquery-3.6.0.min.js"></script>
    <script src="http://localhost/nabik-griha/assets/global/js/bootstrap.bundle.min.js"></script>

    <!-- slick  slider js -->
    <script src="http://localhost/nabik-griha/assets/templates/basic/js/slick.min.js"></script>
    <!-- wow js  -->
    <script src="http://localhost/nabik-griha/assets/templates/basic/js/wow.min.js"></script>

    <!-- lightcase js -->
    <script src="http://localhost/nabik-griha/assets/templates/basic/js/lightcase.js"></script>

    <!-- jquery ui js -->
    <script src="http://localhost/nabik-griha/assets/templates/basic/js/jquery-ui.js"></script>

        <script src="http://localhost/nabik-griha/assets/global/js/iziToast.min.js"></script>
    <!-- main js -->
    <script src="http://localhost/nabik-griha/assets/templates/basic/js/app.js"></script>
            
    
    <script>
        "use strict";

        function notify(status, message) {
            if (typeof message == 'string') {
                iziToast[status]({
                    message: message,
                    position: "topRight"
                });
            } else {
                $.each(message, function(i, val) {
                    iziToast[status]({
                        message: val,
                        position: "topRight"
                    });
                });
            }
        }
    </script>


    <script>
        (function($) {
            "use strict";
            $(".langSel").on("change", function() {
                window.location.href = "http://localhost/nabik-griha/change/" + $(this).val();
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
                $.get('http://localhost/nabik-griha/cookie/accept', function(response) {
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
    
    <script src="assets/templates/basic/assetss/js/script.js" defer></script>
	<script src="assets/templates/basic/assetss/js/carousel.js"></script> 
    <script src="assets/templates/basic/assetss/owl-carousel/js/owl.carousel.js"></script>

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
          
          <script src="assets/templates/basic/assetss/dist/simple-lightbox.js?v2.2.1"></script>
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
