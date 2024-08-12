@php
$contactContent = getContent('contact_us.content', true);
$socialElements = getContent('social_icon.element', false, null, true);
@endphp
<!--<div class="modal fade" id="myModal">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Join Merchant Navy- Admission Notice</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                <p>Admission for DGS approved pre-sea G.P Training will commence from 01.07.2024, for placement in Merchant Navy. Course duration is six months (Residencial). Eligibility 40% in English & 40% in aggregate in 10th Final Exam from recognized board. Total fees 1,70,000/- (One lakh seventy thousand only). For details contact MAI office at Nabik Griha, 1/1 D.H Road. Kolkata 700038. Ph- 9830965166 </p> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mx-auto" data-dismiss="modal">Close</button>
                </div>
            </div>
      </div>
</div>
<script>
$(window).on('load',function(){
    var delayMs = 1500; // delay in milliseconds
    
    setTimeout(function(){
        $('#myModal').modal('show');
    }, delayMs);
});    

</script>-->
<div class="modal fade" id="overlay">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
       <h4 class="modal-title">Join Merchant Navy- Admission Notice</h4> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        
      </div>
      <div class="modal-body">
        <p>Admission for DGS approved pre-sea G.P Training will commence from 01.07.2024, for placement in Merchant Navy. Course duration is six months (Residencial). Eligibility 40% in English & 40% in aggregate in 10th Final Exam from recognized board. Total fees 1,70,000/- (One lakh seventy thousand only). For details contact MAI office at Nabik Griha, 1/1 D.H Road. Kolkata 700038. Ph- 9830965166 </p>
      </div>
    </div>
  </div>
</div>
<script>
    $('#overlay').modal('show');

setTimeout(function() {
    $('#overlay').modal('hide');
}, 5000);
</script>
<header class="header py-0">
 		<div class="header__top">
 			<div class="container">
 				<div class="row gy-2 align-items-center">
 					<div class="col-lg-7">
 						<ul class="header-info-list justify-content-lg-start justify-content-center">
 							<li>
 								<a href="mailto:{{ $contactContent->data_values->email_address }}"><i class="fa fa-envelope"></i>
 									{{ $contactContent->data_values->email_address }}</a>
 							</li>
 							<li>
 								<a href="tel:{{ $contactContent->data_values->contact_number }}"><i class="fa fa-phone"></i> {{ $contactContent->data_values->contact_number }}</a>
 							</li>
 						</ul>
 					</div>
 					<div class="col-lg-5">
 						<div class="header-top-right justify-content-lg-end justify-content-center">
 							<div class="header-top-action-wrapper">'
 							    <a href="{{ route('room.types') }}" class="header-user-btn mr-3"><i class="las la-user me-2"></i>Room Booking</a>
 								<!--<a href="{{ route('room_booking.all') }}" class="header-user-btn mr-3"> Room Booking</a>-->
 								<a href="{{ Route::has('course') ? route('course') : '#' }}" class="header-user-btn mr-3"><i class="las la-book me-2"></i> Courses Booking</a>
 								
 								@guest
                                <a href="{{ route('user.login') }}" class="header-user-btn mr-3"><i class="las la-sign-in-alt"></i> @lang('Sign in')</a>
                                <a href="{{ route('user.register') }}" class="header-user-btn"><i class="las la-user"></i> @lang('Register')</a>
                                @endguest

                                @auth
                                <a href="{{ route('user.logout') }}" class="header-user-btn"><i class="las la-sign-out-alt"></i> @lang('Sign Out')</a>
                                @endauth

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
 						<a href="{{ route('home') }}"><img src="{{ asset('assets/images/logoIcon/logo.png') }}" class="img-fluid" style="width:200px;"></a>
 					</div>
 					<!-- Section: Navbar Menu -->
 					<div class="col-lg-8 col-12 align-self-center">

 						<!--<div class="overlay"></div>-->
 						<nav class="menu text-center">
 							<div class="menu-mobile-header">
 								<button type="button" class="menu-mobile-arrow"><i
 										class="ion ion-ios-arrow-back"></i></button>
 								<div class="menu-mobile-title"></div>
 								<button type="button" class="menu-mobile-close"><i
 										class="ion ion-ios-close"></i></button>
 							</div>
 							<ul class="menu-section">
 								<li><a href="{{ route('home') }}" class="{{ menuActive('home') }}">@lang('HOME')</a>
                                </li>
                                @php
                                    $pages = App\Models\Page::where('tempname', $activeTemplate)
                                        ->where('is_default', 0)
                                        ->get();
                                @endphp
                                @foreach ($pages as $data)
                                   <!-- <li>
                                        <a href="{{ route('pages', [$data->slug]) }}" class="@if (request()->url() == route('pages', [$data->slug])) active @endif">{{ __(strtoupper($data->name)) }}</a>
                                    </li>-->
                                @endforeach 
        
                                <!--<li>
                                <a href="{{ Route::has('abouts') ? route('abouts') : '#' }}" class="">@lang('ABOUT US')</a>
                                </li>-->
                                <li class="menu-item-has-children">
									<a href="#">About Us<i class="ion ion-ios-arrow-down"></i></a>
									<div class="menu-subs menu-column-1">
										<ul>
											<li><a href="{{ Route::has('abouts') ? route('abouts') : '#' }}">About Nabik Griha</a></li>
											<li><a href="{{ Route::has('about_maritime') ? route('about_maritime') : '#' }}">About Maritime Academy</a></li>
										</ul>
									</div>
								</li>
                                <li>
                                <a href="{{ Route::has('course') ? route('course') : '#' }}" class="">@lang('COURSES')</a>
                                </li>
                                <li>
                                    <a href="{{ Route::has('gallery') ? route('gallery') : '#' }}" class="">@lang('GALLERY')</a>
                                </li>
                                <!--<li>
                                    <a href="{{ Route::has('event') ? route('event') : '#' }}" class="">@lang('EVENT')</a>
                                </li>-->
                               
        
                                <!-- <li>
                                    <a href="{{ route('blog') }}" class="{{ menuActive('blog') }}">@lang('UPDATES')</a>
                                </li> -->
        
                                <li>
                                    <a href="{{ route('contact') }}" class="{{ menuActive('contact') }}">@lang('CONTACT')</a>
                                </li>
                                
                                <!--<li>
                                    <a href="/assets/images/tender-notice-hospitality.pdf" class="btn_1" target="_blank">Hospitality Tender</a>
                                </li>
                                <li>
                                    <a href="/assets/images/security-tender.pdf" class="btn_2" target="_blank">Security Tender</a>
                                </li>-->
                                <li>
                                    <a href="/assets/images/MAI-PRESENTATION.pdf" class="btn_2" target="_blank">MAI PPT</a>
                                </li>
                                
                                
                                

 							</ul>
 						</nav>
 					</div>
 					<div class="col-lg-2 mob-off align-self-center">
 						<a href="{{ route('home') }}"><img src="{{ asset('assets/images/logoIcon/logo.png') }}" class="img-fluid"></a>
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
 						<a href="{{ route('home') }}"><img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" class="img-fluid"></a>
 					</div>

 					<div class="col-4 align-self-center desk-off">
 						<a href="{{ route('home') }}"><img src="{{ getImage(getFilePath('logoIcon') . '/logo2.png') }}" class="img-fluid"></a>
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
                            <a href="mailto:{{ $contactContent->data_values->email_address }}"><i class="fas fa-envelope"></i> {{ $contactContent->data_values->email_address }}</a>
                        </li>

                        <li>
                            <a href="tel:{{ $contactContent->data_values->contact_number }}"><i class="fas fa-phone-alt"></i> +{{ $contactContent->data_values->contact_number }}</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-7">
                    <div class="header-top-right justify-content-lg-end justify-content-center">
                        <div class="header-top-action-wrapper">
                            @if ($language->count())
                                <div class="language-select">
                                    <i class="fas fa-globe"></i>
                                    <select class="langSel">
                                        @foreach ($language as $item)
                                            <option value="{{ $item->code }}" @if (session('lang') == $item->code) selected @endif>{{ __($item->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            @guest
                                <a href="{{ route('user.login') }}" class="header-user-btn me-3"><i class="las la-sign-in-alt"></i> @lang('Sign in')</a>
                                <a href="{{ route('user.register') }}" class="header-user-btn"><i class="las la-user"></i> @lang('Register')</a>
                            @endguest

                            @auth
                                <a href="{{ route('user.logout') }}" class="header-user-btn me-3"><i class="las la-sign-out-alt"></i> @lang('Sign Out')</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header__bottom">
        <div class="container">
            <nav class="navbar navbar-expand-xl align-items-center">
                <a class="site-logo site-title" href="{{ route('home') }}">
                    <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="logo">
                </a>
                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="menu-toggle"></span>
                </button>
                <div class="collapse navbar-collapse mt-lg-0 mt-3" id="navbarSupportedContent">
                    <ul class="navbar-nav main-menu ms-auto">
                        <li><a href="{{ route('home') }}" class="{{ menuActive('home') }}">@lang('HOME')</a>
                        </li>
                        @php
                            $pages = App\Models\Page::where('tempname', $activeTemplate)
                                ->where('is_default', 0)
                                ->get();
                        @endphp
                        @foreach ($pages as $data)
                            <li>
                                <a href="{{ route('pages', [$data->slug]) }}" class="@if (request()->url() == route('pages', [$data->slug])) active @endif">{{ __(strtoupper($data->name)) }}</a>
                            </li>
                        @endforeach

                        <li>
                        <a href="{{ Route::has('abouts') ? route('abouts') : '#' }}" class="">@lang('ABOUT US')</a>
                        </li>
                        <li>
                        <a href="{{ Route::has('course') ? route('course') : '#' }}" class="">@lang('COURSES')</a>
                        </li>
                        <li>
                            <a href="{{ Route::has('gallery') ? route('gallery') : '#' }}" class="">@lang('GALLERY')</a>
                        </li>
                        <li>
                            <a href="{{ Route::has('event') ? route('event') : '#' }}" class="">@lang('EVENT')</a>
                        </li>
                       

                        <li>
                            <a href="{{ route('blog') }}" class="{{ menuActive('blog') }}">@lang('UPDATES')</a>
                        </li> 

                        <li>
                            <a href="{{ route('contact') }}" class="{{ menuActive('contact') }}">@lang('CONTACT')</a>
                        </li>
                    </ul>
                    <div class="nav-right justify-content-xl-end ps-0 ps-xl-5">
                        <a href="{{ route('room.types') }}" class="btn btn-sm btn--base me-3"><i class="las la-user me-2"></i>@lang('BOOK ONLINE')</a>
                        @auth
                            <a href="{{ route('user.home') }}" class="btn btn-sm btn-outline--base"><i class="las la-home"></i> @lang('Dashboard')</a>
                        @endauth
                    </div>

                </div>
            </nav>
        </div>
    </div>
</header>-->
