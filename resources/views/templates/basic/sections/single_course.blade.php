@extends($activeTemplate . 'layouts.frontend')
@php
$eventData = DB::table('courses')->orderBy('id','DESC')->get();
@endphp
@section('content')


<section class="banner-slider" id="inn-banner-slider">
    <div data-ride="carousel" class="carousel slide" id="carouselExampleIndicators">
        <div role="listbox" class="carousel-inner">
            <!-- Slide One - Set the background image for this slide in the line below -->
            <div style="margin-top: 150px; background-image: url('../assets/templates/basic/assetss/images/inn-banner.jpg')"
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
  <div style="max-width: 80rem;line-height: 1.1;" class="container">
    <div class="row course-box text-left">
      <div class="col-lg-12">
        <div class="course-ctn">
          <h3>{{ $data->course_name ?? '' }}</h3>
          <h4>{{ $data->course_type ?? '' }}</h4>
          <p>{{ $data->short_decsription ?? '' }}</p>

          <h3>Admission Process</h3>

          <h4>Entry Requirements</h4>

          <div class="row text-justify">
            <div class="col-md-12" id="log">{{ $data->full_description ?? '' }}</div>
            <div id="divMain"></div>
          </div>



          <a style="margin-top: 15px" href="" class="rmBtn-sm" data-toggle="modal" data-target="#exampleModal">Book Now</a>
        </div>
      </div>
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Apply Now</h5>
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
                        <input id="form_name" type="text" name="full_name" class="form-control" placeholder="Full Name"
                          required="required" data-error="Firstname is required.">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input id="form_email" type="email" name="email" class="form-control" placeholder="Email"
                          required="required" data-error="Valid email is required.">
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
                        <textarea id="form_message" name="message" class="form-control" placeholder="Message..."
                          rows="4" required="required" data-error="Please,leave us a message."></textarea>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <!--<input type="submit" class="rmBtn" value="Submit Now">-->
                      <a class="rmBtn" href="#" value="Submit Now">Submit Now</a>
                    </div>

                  </div>
                </div>
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<style>
  th,
  td {
    padding-top: 10px;
    padding-bottom: 20px;
    padding-left: 30px;
    padding-right: 40px;
  }
</style>


<script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
<script>
  CKEDITOR.editorConfig = function (config) {
    config.protectedSource.push(/<i[\s\S]*?\>/g); //allows beginning <i> tag
    config.protectedSource.push(/<\/i[\s\S]*?\>/g); //allows ending </i> tag
  }
  CKEDITOR.dtd.$removeEmpty['i'] = false;

  CKEDITOR.replace('content', {
    allowedContent: true,
  });
  CKEDITOR.replace('description1', {
    allowedContent: true,
  });
  CKEDITOR.replace('description2', {
    allowedContent: true,
  });
</script>



<script>
  var support = (function () {
    if (!window.DOMParser) return false;
    var parser = new DOMParser();
    try {
      parser.parseFromString('x', 'text/html');
    } catch (err) {
      return false;
    }
    return true;
  })();

  var textToHTML = function (str) {

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

@endsection