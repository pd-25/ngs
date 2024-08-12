@extends($activeTemplate .'layouts.frontend')
@php
$eventData = DB::table('event')->orderBy('id','DESC')->get();
@endphp

<section class="banner-slider" id="inn-banner-slider">
      <div style="    margin-top: 150px;" data-ride="carousel" class="carousel slide" id="carouselExampleIndicators">
        <div role="listbox" class="carousel-inner">
          <!-- Slide One - Set the background image for this slide in the line below -->
          <div style="background-image: url('assets/templates/basic/assetss/images/inn-banner.jpg')" class="carousel-item active">
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

<li>{{ $event->description ?? '' }} </li>
@endforeach

</ul>

</marquee>
 </div>
 </div>

</div>
		
		</div>
	</section>
	

	
	<section id="inn-section" class="pb-0">
	<div class="container">
<div class="row">
        <div class="col-lg-12">
		<h1>Upcoming Events</h1>
		<p class="section-caption">{{ $event->description ?? '' }}</p>
		<hr>
		
		
		</div>
        </div>
		<div class="row event-box">
    @foreach($eventData as $event)
		<div style="margin-bottom: 15px;" class="col-lg-6">
		<div class="event-box-img">
  <img  class="mr-5" src="{{ env('IMAGE_SHOW_PATH').$event->image }}" >

 <!-- <img src="{'assets/templates/basic/'.$event['image'] }}" class="img-fluid" style="max-width:80px" alt="{{$event->image}}"> -->

  </div>
  </div>
  
  
  <div class="col-lg-6 align-self-center">
  

  <div class="event-box-ctn">
  <h4>{{ $event->Event_name ?? '' }}</h4>
  <p class="event-address"><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $event->address ?? '' }}</p>
  <ul class="date-list">
  <li><i class="fa fa-calendar" aria-hidden="true"></i>{{ $event->date ?? '' }}</li>
  <li><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $event->time ?? '' }}</li>
  </ul>
    <p>{{ $event->description ?? '' }}</p> 
	<!-- <a href="" class="rmBtn-sm-light" data-toggle="modal" data-target="#exampleModal">Book Now</a> -->
  </div>


</div>
@endforeach
		</div>
		
	
		
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Book Now</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form id="contact-form" method="post" action="" enctype="multipart/form-data" role="form">
          <div class="controls">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <input id="form_name" type="text" name="full_name" class="form-control" placeholder="Full Name" required="required" data-error="Firstname is required.">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <input id="form_email" type="email" name="email" class="form-control" placeholder="Email" required="required" data-error="Valid email is required.">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input id="form_phone" type="tel" name="phone" class="form-control" placeholder="Phone no.">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <textarea id="form_message" name="message" class="form-control" placeholder="Message..." rows="4" required="required" data-error="Please,leave us a message."></textarea>
                </div>
              </div>
              <div class="col-md-12">
			  <input type="submit" class="rmBtn" value="Submit Now">
              </div> 
	  
            </div>
          </div>
        </form>
      </div>
      
    </div>
  </div>
</div>
      
	</div>
	</section>


