@php
$content = getContent('about_academy.content', true);
$elements = getContent('about_academy.element', false);
$eventData = DB::table('courses')->orderBy('id','asc')->get();

@endphp
@extends($activeTemplate . 'layouts.frontend')


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
	<div class="mainsize container">
    @if (Request::path() != 'about_academy')

<div class="row">
        <div class="col-lg-7">
		<h1>{{ __($content->data_values->heading) }}</h1>
		<p class="section-caption">{{ __($content->data_values->subheading) }}</p>
			<div class="row text-justify">
				<div class="col-md-12" id="log" >{{ __($content->data_values->description) }}</div>
				<div id="divMain"></div>   
			</div>
		
		
		
        </div>
		
		
		<div class="col-lg-5">
		<img style="width: 100%;
        height: 350px;
        object-fit: fill;" src="{{ getImage('assets/images/frontend/about_academy/' . $content->data_values->image_1, '400x280') }}" class="img-fluid">
		</div>
      </div>
      @endif
      
      
      <!--<hr>
      <div class="row justify-content-center mt-5">
        <div class="col-lg-4">
<div class="inn-abt-obx">
<img style="width: 100%;margin-bottom: 20px;" src="{{ getImage('assets/images/frontend/about_academy/' . $content->data_values->image_2, '400x280') }}" class="img-fluid">
<h3>{{ __($content->data_values->name_1) }}</h3>
<p class="team-desig"> {{ __($content->data_values->title_1) }}</p>
<p class="team-ctn">{{ __($content->data_values->short_description_1) }}</p>
	 </div>	
        </div>
		
		
		<div class="col-lg-4">
<div class="inn-abt-obx">
<img style="width: 100%;margin-bottom: 20px;" src="{{ getImage('assets/images/frontend/about_academy/' . $content->data_values->image_3, '400x280') }}" class="img-fluid">
<h3>{{ __($content->data_values->name_2) }}</h3>
<p class="team-desig">{{ __($content->data_values->title_2) }}</p>
<p class="team-ctn">{{ __($content->data_values->short_description_2) }}</p>
	 </div>	
        </div>
      </div>-->
      
	</div>
	</section>


    
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