@extends($activeTemplate . 'layouts.frontend')
@php
$courseData = DB::table('courses')->orderBy('id','DESC')->get();
$eventData = DB::table('event')->orderBy('id','DESC')->get();
$galleryData = DB::table('gallery')->orderBy('id','DESC')->get();

$content = getContent('about.content', true);
$elements = getContent('about.element', false);
@endphp

    <!--<section id="banner-slider" class="banner-slider">
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
		  <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
          <div class="carousel-item active" style="background-image: url('assets/templates/basic/assetss/images/banner.jpg');">
            <div class="carousel-caption">
			<p class="bannerCaption">Welcome To</p>
			  <h1>Nabik Griha</h1>
			  <p class="bannerCaption-sm">Integer vitae fringilla sem, in tempus ante tincidunt dolor non felis rutrum, a fringilla erat ullamcorper enean vitae sollicitudin lectus. </p>
			  <a href="" class="banner-btn">View Courses</a>
            </div>
          </div> 
		  

        </div>
     <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"><img src="images/ban-left-btn.png" class="img-fluid"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"><img src="images/ban-right-btn.png" class="img-fluid"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </section>-->
    <section id="banner-slider" class="banner-slider" style="margin-top:150px;">
 		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
 			<ol class="carousel-indicators">
 				<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
 				<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
 				<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
 			</ol>
 			<div class="carousel-inner" role="listbox">
 				<!-- Slide One - Set the background image for this slide in the line below -->
 				<div class="carousel-item active" style="background-image: url('assets/templates/basic/assetss/images/banner1.jpg');">
 					<!--<div class="carousel-caption">
 						<p class="bannerCaption">Welcome To</p>
 						<h1>NABIK GRIHA SAMITY</h1>
 						<p class="bannerCaption-sm mob-off">With a focus on practical training and the latest industry
 							standards, we strive to produce highly skilled professionals who are well-prepared to
 							tackle the challenges of the maritime world.</p>
 						 <a href="courses.html" class="banner-btn">View Courses</a>
 					</div>-->
 				</div>

 				<div class="carousel-item" style="background-image: url('assets/templates/basic/assetss/images/banner2.jpg');">
 					<!--<div class="carousel-caption">
 						<p class="bannerCaption">Welcome To</p>
 						<h1>NABIK GRIHA SAMITY</h1>
 						<p class="bannerCaption-sm mob-off">With a focus on practical training and the latest industry
 							standards, we strive to produce highly skilled professionals who are well-prepared to
 							tackle the challenges of the maritime world.</p>
 						 <a href="courses.html" class="banner-btn">View Courses</a>
 					</div>-->
 				</div>
 				
 				<!--<div class="carousel-item" style="background-image: url('assets/templates/basic/assetss/images/banner3.jpg');">
 					<div class="carousel-caption">
 						<p class="bannerCaption">Welcome To</p>
 						<h1>NABIK GRIHA SAMITY</h1>
 						<p class="bannerCaption-sm mob-off">With a focus on practical training and the latest industry
 							standards, we strive to produce highly skilled professionals who are well-prepared to
 							tackle the challenges of the maritime world.</p>
 						 <a href="courses.html" class="banner-btn">View Courses</a>
 					</div>
 				</div>-->


 			</div>
 			<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
 				<span class="carousel-control-prev-icon" aria-hidden="true"><img src="assets/templates/basic/assetss/images/ban-left-btn.png"
 						class="img-fluid"></span>
 				<span class="sr-only">Previous</span>
 			</a>
 			<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
 				<span class="carousel-control-next-icon" aria-hidden="true"><img src="assets/templates/basic/assetss/images/ban-right-btn.png"
 						class="img-fluid"></span>
 				<span class="sr-only">Next</span>
 			</a>
 		</div>
 	</section>
    <!-- Page Content -->
	<section id="marqe-section">
	<div class="container-fluid">
<div class="row">
<div class="col-lg-2 col-4 marquee-heading mb-0">
<p >Upcoming Courses</p>
</div>
 <div class="col-lg-10 col-8">
        <div class="marquee-box">
            <marquee direction="right">
                <ul>
                    @foreach($coursedata as $course)
                    <li>{{ $course->course_name ?? '' }} </li>
                    @endforeach
                </ul>
            </marquee>
        </div>
    </div>

</div>
		
		</div>
	</section>
	
	
	
	<section id="welcome-section">
	<div class="container">
		<div class="row justify-content-center mb-4">
			
			<div class="col-lg-12 text-center mb-4">
		    <h1 style="">About Us</h1>
		    
		   </div>
		   <div class="col-lg-6">
		<p class="section-caption">Welcome to Nabik Griha Samity</p>
		<p>Nabik Griha Samity, a benevolent institution, was established in the year 1954. It was inaugurated by then Chief Minister of West Bengal Dr. Bidhan Chandra Roy on the 12th of February, 1954 and has been in dedicated services since its inception and continues to do so to the sea going fraternity.</p>
        
        <p>This institution provides lodging facility to seafarers during their stay in Kolkata at a very nominal rate and also runs a D. G. Shipping approved maritime institution, Maritime Academy of India providing G. P. Rating course and various other STCW courses.</p>
        <p>Nabik Ghriha Samity is run by a charitable trust comprising of members from Mercantile Marine Department, Govt of India, Kolkata, representatives of various shipping companies and Forward Seamen’s Union of India. The board of trustees is Chaired by the Principal Officer, Mercantile Marine Department, Kolkata.</p>
        
        <p>Nabik Griha Samity has its registered office at Seaman’s Welfare Office, Marine House, Hastings, Kolkata 700 022.</p>
			
			<!--<div id="divMain"></div>   -->
		
	<!--	<a href="{{ Route::has('abouts') ? route('abouts') : '#' }}" class="rmBtn">Read More</a>-->
			</div>
	
		<div class="col-lg-6">
		<p class="section-caption">Welcome to Maritime Academy of India</p>
		<p id="log">Maritime Academy of India (MTI No: 302005), under management of ‘NABIK GRIHA SAMITY’, is a charitable trust for the welfare of seafarers under the Chairmanship of Principal Officer, Kolkata MMD. </p>
		<p id="log">The Maritime Academy of India is well known in the Shipping Industry for its dedication towards quality in maritime education and practical training conducted in our Workshop. The institution is located at 1/1, Taratala Road. Kolkata-700 038, West Bengal. The Academy provides a complete learning environment supported by an excellent Training in our Workshop.</p>

        <p id="log">The academy's cutting-edge facilities, experienced faculty staff and skilled trainers contribute to its position as a top school for maritime education. Furthermore, the Academy offers outstanding housing facilities for students. </p>

			
			<!--<div id="divMain"></div>   -->
		
		<!--<a href="{{ Route::has('about_maritime') ? route('abouts') : '#' }}" class="rmBtn">Read More</a>-->
			</div>
			
			
			

		</div>

		
     </div>
	</section>
	

	
<!--	<section id="welcome-section">
	<div class="container">
		<div class="row justify-content-center mb-4">
			@if (Request::path() != 'about_academy')
			
			<div class="col-lg-12 text-center mb-4">
		    <h1 style="">{{ __($content->data_values->heading) }}</h1>
		    
		   </div>
		   <div class="col-lg-6">
		<p class="section-caption">Welcome to Nabik Griha Samity</p>
		<p>Nabik Griha Samity, a benevolent institution, was established in the year 1954. It was inaugurated by then Chief Minister of West Bengal Dr. Bidhan Chandra Roy on the 12th of February, 1954 and has been in dedicated services since its inception and continues to do so to the sea going fraternity.</p>
        
        <p>This institution provides lodging facility to seafarers during their stay in Kolkata at a very nominal rate and also runs a D. G. Shipping approved maritime institution, Maritime Academy of India providing G. P. Rating course and various other STCW courses.</p>
        <p>Nabik Ghriha Samity is run by a charitable trust comprising of members from Mercantile Marine Department, Govt of India, Kolkata, representatives of various shipping companies and Forward Seamen’s Union of India. The board of trustees is Chaired by the Principal Officer, Mercantile Marine Department, Kolkata.</p>
        
        <p>Nabik Griha Samity has its registered office at Seaman’s Welfare Office, Marine House, Hastings, Kolkata 700 022.</p>
			
			<div id="divMain"></div>   
		
<a href="{{ Route::has('abouts') ? route('abouts') : '#' }}" class="rmBtn">Read More</a>
			</div>
	
		<div class="col-lg-6">
		<p class="section-caption">Welcome to Maritime Academy of India</p>
		<p id="log">Maritime Academy of India, a maritime academy, run by Nabik Griha Samity, started its operation in the year 2010.</p>
		<p id="log">The Maritime Academy of India is well known in the industry for its dedication to quality in maritime education and hostelling. The institution, which is located in Sahapur, New Alipore, Kolkata, West Bengal, provides a complete learning environment that educates prospective navy personnel on the industry's problems.</p>

        <p id="log">The academy provides a variety of programs, including certificate and degree programs in marine studies. The Maritime Academy of India guarantees that its students gain the required theoretical knowledge and practical abilities to flourish in their chosen areas by emphasizing academic rigor and practical training.</p>
        
        <p id="log">The academy's cutting-edge facilities, skilled staff, and strong industry contacts contribute to its position as a top school for maritime education and for providing a wonderful learning environment. Furthermore, the academy offers outstanding housing facilities for students, establishing a suitable academic atmosphere and camaraderie among aspiring marine professionals.</p>
			
			<div id="divMain"></div>   
		
		<a href="{{ Route::has('about_maritime') ? route('abouts') : '#' }}" class="rmBtn">Read More</a>
			</div>
			
			
			
			
			
			<div class="col-lg-6">
				<img style="width: 100%" src="{{ getImage('assets/images/frontend/about/' . $content->data_values->image_1, '600x500') }}" class="img-fluid">
			</div>
			@endif
		</div>

		
     </div>
	</section>-->
	
	
<section id="room-book-section">
	<div class="container-fluid p-0">
	<div class="row justify-content-center">
	<div class="col-lg-6">
		<img src="assets/templates/basic/assetss/images/rm-pic.jpg" class="mr-3" alt="...">
		</div>
	<div style="padding-right: 120px;" class="col-lg-6 align-self-center right-padding-box">
	<h1 style="">Why choose us</h1>
	<p class="section-caption">Our Maritime training institution is the ideal choice for individuals seeking a career in the maritime industry.</p>
	<p>We have highly experienced faculty members who give hands-on training based on the most recent industry standards. Our cutting-edge facilities, which include simulators and training boats, enable our students to practice in a setting that closely resembles real-world conditions.</p>
	<a href="{{ route('room.types') }}" class="rmBtn-light">Book Your Room</a>
		</div>
		
	</div>

		
     </div>
	</section>	
		
	
	
	
	
<section id="course-section">
	<div class="container-fluid">
        <div class="row justify-content-center mb-3">
    	    <div class="col-lg-12 text-center">
            	<h2>DG Shipping Approved Course</h2>
            	<p class="section-caption">Select Your Course</p>
    		</div>
    	</div>

	  <div class="row justify-content-center">
		<div class="col-lg-12">
            <div id="demo-pranab">
                <div id="owl-course" class="owl-carousel owl-theme">  
        		  @foreach($coursedata as $course)
                  <div class="item">
        		    <div class="course-box">  
            		  <img style="height: 120px;" src="{{ env('IMAGE_SHOW_PATH').$course->image }}" class="img-fluid" alt="{{ $course->course_name ?? '' }}">
            		  <h3>{{ $course->course_name ?? '' }}</h3>
            		  <h4>{{ $course->course_type ?? '' }}</h4>
            		  <p>{{ $course->short_decsription ?? '' }} </p>
            		  <a href="{{ url('single_course') }}/{{ $course->id }}" class="rmBtn-sm">View Course</a>
            		 </div>
        		  </div>
        		  @endforeach
                </div>
            </div>
		</div>
	   </div>
		
     </div>
	</section>
	

<section class="bg-white" id="event-section">
	<div class="container">
    	<div class="row justify-content-center mb-3">
        	<div class="col-lg-12 text-center">
        	    <h2>Upcoming Events</h2>
        	</div>
    	</div>

	    <div class="row justify-content-center">
            <div class="col-lg-12">
                <div id="demo-pranab">
                    <div id="owl-event" class="owl-carousel owl-theme">
        
                        @foreach($eventdata as $event)
        
                        <div class="item">
                            <div class="media">
                                <img style="height: 290px;width: 480px;" src="{{ env('IMAGE_SHOW_PATH').$event->image }}" class="mr-5" alt="...">
                                <div class="media-body align-self-center">
                                    <h4>{{ $event->Event_name ?? '' }}</h4>
                                    <p class="event-address"><i class="fa fa-map-marker" aria-hidden="true"></i>
                                        {{ $event->address ?? '' }}</p>
                                    <ul class="date-list">
                                        <li><i class="fa fa-calendar" aria-hidden="true"></i> {{ $event->date ?? '' }}</li>
                                        <li><i class="fa fa-clock-o" aria-hidden="true"></i>{{ $event->time ?? '' }}</li>
                                    </ul>
                                    <p>{{ $event->description ?? '' }}</p>
                                    <!-- <a href="" class="rmBtn-sm-light">Book Now</a> -->
                                </div>
                            </div>
                        </div>
        
                        @endforeach
        
        
                    </div>
                </div>
            </div>
        </div>
     </div>
	</section>
	
	
<section id="gallery-section">
	<div class="container-fluid">
	    <div style="margin-bottom: -10px;" class="row">
	        <div class="col-lg-3 p-0 align-self-center">
            	<div class="gal-ctn-box">
                	<h2>Our Gallery</h2>
                	<p>Some of our recent pictures</p>
                	<a href="{{ Route::has('gallery') ? route('gallery') : '#' }}" class="rmBtn">Read More</a>
	            </div>
	        </div>
            <div class="col-lg-9 p-0">
		        <div id="demo-pranab">
                    <div id="owl-gallery" class="owl-carousel owl-theme"> 
		                @foreach($gallerydata as $gallery)
                        <div class="item">
                            <img src="{{ env('IMAGE_SHOW_PATH').$gallery->image }}" class="img-fluid">	  
                        </div>
		                @endforeach
		            </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
	.dark-mode{    background: #f8f8f8;
}
	</style>
<script>
    var support = (function() {
        if (!window.DOMParser) return false;
        var parser = new DOMParser();
        try {
            parser.parseFromString('x', 'text/html');
        } catch (err) {
            return false;
        }
        return true;
    })();

    var textToHTML = function(str) {

        // check for DOMParser support
        if (support) {
            var parser = new DOMParser();
            var doc = parser.parseFromString(str, 'text/html');
            return doc.body.innerHTML;
        }

        // Otherwise, create div and append HTML
        var dom = document.createElement('div');
        dom.innerHTML = str;
        return dom;

    };

    var myValue9 = document.getElementById("log").innerText;

    document.getElementById("divMain").innerHTML = textToHTML(myValue9);

    document.getElementById("log").innerText = "";
</script>