@extends($activeTemplate . 'layouts.frontend')
@php
$eventData = DB::table('courses')->orderBy('id','DESC')->get();
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
  

  
  <section id="registation-section">
  <div class="container">
    <div class="row text-center justify-content-center">
      <div class="col-lg-9">
      <h1 class="mb-0">ROOM BOOKING</h1>
      <h3 class="mb-3">Main Branch</h3>
      <p>Suspendisse eu risus urna mi enim, auctor nec fermentum libero.</p>
      </div>
      </div>
      
      <div class="row justify-content-center">
      <div class="col-lg-12">
      <div class="login-box">

<form id="registation-form" method="post" action="" role="form">
        <div class="controls">
          <div class="row">
            <div class="col-lg-9">
            <div class="row">
            <div class="col-lg-4">
              <div class="form-group">
              <label>C.D.C. No.</label>
                <input id="form_cdc_no" type="text" name="form__cdc_no" class="form-control">
              </div>
               </div>
                <div class="col-lg-4">
                  <div class="form-group">
  <label for="exampleFormControlSelect1">C.D.C. Register</label>
  <select class="form-control" id="exampleFormControlSelect1">
    <option>1</option>
    <option>2</option>
    <option>3</option>
    <option>4</option>
    <option>5</option>
  </select>
</div>

               </div>
               
               <div class="col-lg-4">
                  <div class="form-group">
  <label for="exampleFormControlSelect2">C.D.C. Status</label>
  <select class="form-control" id="exampleFormControlSelect2">
    <option>1</option>
    <option>2</option>
    <option>3</option>
    <option>4</option>
    <option>5</option>
  </select>
</div>

               </div>
               
                </div>
                
                
                
                <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
              <label>Arrival Date</label>
                 <input type="datetime-local" class="form-control" id="birthdaytime" name="birthdaytime">
              </div>
               </div>
               <div class="col-lg-6">
              <div class="form-group">
              <label>Arrival Registation No.</label>
                <input id="form_ar_no" type="text" name="form__ar_no" class="form-control">
              </div>
               </div>

               
                </div>
                
                <div class="row">
            <div class="col-lg-12 board-cat-area">
              <div class="form-group">
              <label>Boarder Category</label><br>
                 <div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
<label class="form-check-label" for="inlineRadio1">General</label>
</div>
<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
<label class="form-check-label" for="inlineRadio2">Trainning</label>
</div>
<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
<label class="form-check-label" for="inlineRadio3">Officer</label>
</div>
<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio4" value="option3">
<label class="form-check-label" for="inlineRadio4">Other 1</label>
</div>
<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio5" value="option3">
<label class="form-check-label" for="inlineRadio5">Other 1</label>
</div>
<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio6" value="option3">
<label class="form-check-label" for="inlineRadio6">Other 3</label>
</div>
              </div>
               </div>
               
                </div>
                
                
                <div class="row"> 
            <div class="col-lg-3">
            <div class="form-group">
            <label>List Of Rooms</label>
            <select class="form-control" id="exampleFormControlSelect2">
    <option>1</option>
    <option>2</option>
    <option>3</option>
    <option>4</option>
    <option>5</option>
  </select>
  </div>
            </div>
            <div class="col-lg-3">
            <div class="form-group">
              <label>Room No.</label>
                <input id="form_room_no" type="text" name="form_room_no" class="form-control">
              </div>
            </div>
            <div class="col-lg-3">
            <div class="form-group">
              <label>Bed No.</label>
                <input id="form_Bed_no" type="text" name="form_Bed_no" class="form-control">
              </div>
            </div>
            <div class="col-lg-3">
            <div class="form-group">
              <label>Bed Rate</label>
                <input id="form_Bed_rate" type="text" name="form_Bed_rate" class="form-control">
              </div>
            </div>
               
                </div>
          











          
                

            
                
              
            </div>
            <div class="col-lg-3 pf-img-box">
            <h4><i class="fa fa-camera" aria-hidden="true"></i> Image of C.D.C. Holder</h4>
              <div class="proimg-area">


              </div>
            </div>
          </div>
          
          
          
          <div class="row"> 
            <div class="col-lg-4">
            <div class="form-group">
              <label>Name</label>
                <input id="form_name" type="text" name="form_name" class="form-control">
              </div>
            
            </div>
            <div class="col-lg-4">
            <div class="form-group">
              <label>Phone No.</label>
                <input id="form_phone" type="tel" name="form_phone" class="form-control">
              </div>
            
            </div>

            <div class="col-lg-2">
            <div class="form-group">
              <label>Endorse No.</label>
                <input id="form_eno" type="text" name="form_eno" class="form-control">
              </div>
            
            </div>
            <div class="col-lg-2">
            <div class="form-group">
              <label>Date of Birth</label>
                <input type="date" id="birthday" name="birthday" class="form-control">
              </div>
            
            </div>
            </div>
          
          
          
          
          
                <div class="row"> 
            <div class="col-lg-3">
            <div class="form-group">
              <label>Village</label>
                <input id="form_Village" type="text" name="form_Village" class="form-control">
              </div>
            
            </div>
            <div class="col-lg-3">
            <div class="form-group">
              <label>Office</label>
                <input id="form_Office" type="tel" name="form_Office" class="form-control">
              </div>
            
            </div>

            <div class="col-lg-2">
            <div class="form-group">
              <label>District</label>
                <input id="form_District" type="text" name="form_District" class="form-control">
              </div>
            
            </div>
            <div class="col-lg-2">
            <div class="form-group">
              <label>State</label>
                <input id="form_State" type="text" name="form_State" class="form-control">
              </div>
            
            </div>
            
            <div class="col-lg-2">
            <div class="form-group">
              <label>Country</label>
                <input id="form_Country" type="text" name="form_Country" class="form-control">
              </div>
            
            </div>
            </div>
          
          
          
          
          <div class="row"> 
            <div class="col-lg-4">
            <div class="form-group">
            <label>Receipt</label>
                <select class="form-control" id="exampleFormControlSelect3">
    <option>1</option>
    <option>2</option>
    <option>3</option>
    <option>4</option>
    <option>5</option>
  </select>
            </div>
            
            </div>
            
            <div class="col-lg-4">
            <div class="form-group">
            <label>Article</label>
                <select class="form-control" id="exampleFormControlSelect4">
    <option>1</option>
    <option>2</option>
    <option>3</option>
    <option>4</option>
    <option>5</option>
  </select>
            </div>
            
            </div>
            </div>
            
            
            
            
            
<!--            <div class="row"> -->
<!--            <div class="col-lg-12">-->
<!--            <h4>Receipt Details</h4>-->
<!--             </div>-->
            
<!--            <div class="col-lg-12">-->

<!--<table class="table regTable">-->
<!--<thead class="thead-light">-->
<!--  <tr>-->
<!--    <th scope="col">Receipt Type</th>-->
<!--    <th scope="col">Receipt No.</th>-->
<!--    <th scope="col">Receipt Date</th>-->
<!--    <th scope="col">Amount</th>-->
<!--    <th scope="col"></th>-->
<!--  </tr>-->
<!--</thead>-->
<!--<tbody>-->
<!--  <tr>-->
<!--    <th scope="row">-->
<!--                       <div class="form-check form-check-inline">-->
<!--<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio6" value="option1">-->
<!--<label class="form-check-label" for="inlineRadio6">Advance</label>-->
<!--</div>-->
<!--<div class="form-check form-check-inline">-->
<!--<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio6" value="option2">-->
<!--<label class="form-check-label" for="inlineRadio6">Sec Deposit</label>-->
<!--</div>-->
<!--</th>-->
<!--    <td><input id="" type="text" name="" class="form-control"></td>-->
<!--    <td><input type="date" id="birthday" name="birthday" class="form-control"></td>-->
<!--    <td><input id="" type="text" name="" class="form-control"></td>-->
<!--     <td>-->
<!--     <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Save"><i class="fa fa-check col-red" aria-hidden="true"></i></span>-->
<!--     <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Print"><i class="fa fa-print pl-3 col-red" aria-hidden="true"></i></span>-->
<!--<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Delete"><i class="fa fa-trash pl-3 col-red" aria-hidden="true"></i></span>-->

<!--</td>-->
<!--  </tr>-->
<!--  <tr>-->
<!--    <th scope="row">-->
<!--                       <div class="form-check form-check-inline">-->
<!--<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio6" value="option3">-->
<!--<label class="form-check-label" for="inlineRadio6">Advance</label>-->
<!--</div>-->
<!--<div class="form-check form-check-inline">-->
<!--<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio7" value="option4">-->
<!--<label class="form-check-label" for="inlineRadio7">Sec Deposit</label>-->
<!--</div>-->
<!--</th>-->
<!--    <td><input id="" type="text" name="" class="form-control"></td>-->
<!--    <td><input type="date" id="birthday" name="birthday" class="form-control"></td>-->
<!--    <td><input id="" type="text" name="" class="form-control"></td>-->
<!--    <td>-->
<!--     <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Save"><i class="fa fa-check col-red" aria-hidden="true"></i></span>-->
<!--     <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Print"><i class="fa fa-print pl-3 col-red" aria-hidden="true"></i></span>-->
<!--<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Delete"><i class="fa fa-trash pl-3 col-red" aria-hidden="true"></i></span>-->

<!--</td>-->
<!--  </tr>-->

<!--</tbody>-->
<!--</table>-->

            
<!--            </div>-->
            
<!--            </div>-->
            
            
            
            
            
            
            
            
            
            
            
            
            <div class="row"> 
            <div class="col-lg-12">
            <h4>Article Issued Details</h4>
             </div>
            
            <div class="col-lg-7">

<table class="table regTable">
<thead class="thead-light">
  <tr>
    <th scope="col">Article Name</th>
    <th scope="col">Qty</th>
    <th scope="col">Issue Date</th>
  </tr>
</thead>
<tbody>
  <tr>
    <td><select class="form-control" id="exampleFormControlSelect4">
    <option>Article Name here 1</option>
    <option>Article Name here 2</option>
    <option>Article Name here 3</option>
    <option>Article Name here 4</option>
    <option>Article Name here 5</option>
  </select></td>
    <td><select class="form-control" id="exampleFormControlSelect4">
    <option>Qty 1</option>
    <option>Qty 2</option>
    <option>Qty 3</option>
    <option>Qty 4</option>
    <option>Qty 5</option>
  </select></td>
    <td><input type="date" id="birthday" name="birthday" class="form-control"></td>

  </tr>
  
  <tr>
    <td><select class="form-control" id="exampleFormControlSelect4">
    <option>Article Name here 1</option>
    <option>Article Name here 2</option>
    <option>Article Name here 3</option>
    <option>Article Name here 4</option>
    <option>Article Name here 5</option>
  </select></td>
    <td><select class="form-control" id="exampleFormControlSelect4">
    <option>Qty 1</option>
    <option>Qty 2</option>
    <option>Qty 3</option>
    <option>Qty 4</option>
    <option>Qty 5</option>
  </select></td>
    <td><input type="date" id="birthday" name="birthday" class="form-control"></td>

  </tr>
  

</tbody>
</table>

            
            </div>
            
            
            <div class="col-lg-5">
             <div class="form-group">
              <label>Remarks(If Any)</label>
                <input id="form_Country" type="text" name="form_Country" class="form-control">
              </div>
              <div class="form-group form-check">
  <input type="checkbox" class="form-check-input" id="exampleCheck1">
  <label class="form-check-label" for="exampleCheck1">Check Remarks</label>
</div>

            
            </div>
            
            </div>
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          

          <div class="row mt-5">

            <div class="col-lg-12">
              <ul class="logBox-list">
      <li><a href="#" class="rmBtn">Save</a></li>
      <li><a href="#" class="rmBtn">Clear</a></li>
      <li><a href="#" class="rmBtn">Exit</a></li>
      </ul>
            </div>
          </div>
        </div>
      </form>



      </div>
      </div>
      </div>
    </div>
  </section>
  