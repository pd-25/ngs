<div class="sidebar bg--dark">
    <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a href="{{ route('receptionist.book.room') }}" class="sidebar__main-logo"><img src="{{ asset('assets/images/logoIcon/logo_dark.png') }}" alt="@lang('image')"></a>
        </div>

        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <ul class="sidebar__menu">
                <li class="sidebar-menu-item {{ menuActive('receptionist.dashboard') }}">
                    <a href="{{ route('receptionist.dashboard') }}" class="nav-link">
                        <i class="menu-icon las la-home"></i>
                        <span class="menu-title">@lang('Dashboard')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item {{ menuActive('receptionist.book.room') }}">
                    <a href="{{ route('receptionist.book.room') }}" class="nav-link">
                        <i class="menu-icon las la-box"></i>
                        <span class="menu-title">@lang('Book Room')</span>
                    </a>
                </li>


                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{ menuActive('receptionist.booking.*', 3) }}">
                        <i class="menu-icon la la-list"></i>
                        <span class="menu-title">@lang('Manage Bookings') </span>
                    </a>
                    <div class="sidebar-submenu {{ menuActive('receptionist.booking.*', 2) }}">
                        <ul>

                            <li class="sidebar-menu-item {{ menuActive('receptionist.booking.request.*') }}">
                                <a href="{{ route('receptionist.booking.request.all') }}" class="nav-link">
                                    <i class="menu-icon las la-exchange-alt"></i>
                                    <span class="menu-title">@lang('Booking Reqeuests')</span>
                                    @if ($bookingRequestCount > 0)
                                        <span class="menu-badge pill bg--danger ms-auto">
                                            {{ $bookingRequestCount }}
                                        </span>
                                    @endif
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('receptionist.booking.active*') }}" style="display:none;">
                                <a href="{{ route('receptionist.booking.active') }}" class="nav-link">
                                    <i class="menu-icon las la-check-circle"></i>
                                    <span class="menu-title">@lang('Active Bookings')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('receptionist.booking.cancelled*') }}" style="display:none;">
                                <a href="{{ route('receptionist.booking.cancelled.list') }}" class="nav-link">
                                    <i class="menu-icon las la-times-circle"></i>
                                    <span class="menu-title">@lang('Cancelled Bookings')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('receptionist.booking.checked_out*') }}" style="display:none;">
                                <a href="{{ route('receptionist.booking.checked_out.list') }}" class="nav-link">
                                    <i class="menu-icon las la-list-alt"></i>
                                    <span class="menu-title">@lang('Checked Out Bookings')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('receptionist.booking.all*') }}">
                                <a href="{{ route('receptionist.booking.all') }}" class="nav-link">
                                    <i class="menu-icon las la-history"></i>
                                    <span class="menu-title">@lang('All Bookings')</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>


                <li class="sidebar-menu-item sidebar-dropdown" style="display:none;">
                    <a href="javascript:void(0)" class="{{ menuActive('receptionist.extra.service*', 3) }}">
                        <i class="menu-icon la la-beer"></i>
                        <span class="menu-title">@lang('Extra Service') </span>
                    </a>
                    <div class="sidebar-submenu {{ menuActive('receptionist.extra.service*', 2) }}">
                        <ul>
                            <li class="sidebar-menu-item {{ menuActive('receptionist.extra.service.add') }}">
                                <a href="{{ route('receptionist.extra.service.add') }}" class="nav-link">
                                    <i class="menu-icon las la-plus-circle"></i>
                                    <span class="menu-title">@lang('Add Extra Service')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{ menuActive('receptionist.extra.service.list') }}">
                                <a href="{{ route('receptionist.extra.service.list') }}" class="nav-link">
                                    <i class="menu-icon las la-list"></i>
                                    <span class="menu-title">@lang('Added Extra Services')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="sidebar-menu-item {{ menuActive('receptionist.deposit.pending*') }}">
                    <a href="{{ route('receptionist.deposit.pending') }}" class="nav-link">
                        <i class="menu-icon las la-spinner"></i>
                        <span class="menu-title">@lang('Pending Payments')</span>
                        @if ($pendingDepositsCount)
                            <span class="menu-badge pill bg--danger ms-auto">{{ $pendingDepositsCount }}</span>
                        @endif
                    </a>
                </li>
                
                  <li class="sidebar-menu-item {{ menuActive('receptionist.expense_managment.all') }}">
                                <a href="{{ route('receptionist.expense_managment.all') }}" class="nav-link">
                                    <i class="menu-icon las la-rupee-sign"></i>
                                    <span class="menu-title">@lang('Expense Management')</span>
                                </a>
                  </li>
                  
                   <li class="sidebar-menu-item {{ menuActive('receptionist.expense_managment.report') }}">
                                <a href="{{ route('receptionist.expense_managment.report') }}" class="nav-link">
                                    <i class="menu-icon las la-user"></i>
                                    <span class="menu-title">@lang('Expense Report')</span>
                                </a>
                  </li>

                <li class="sidebar-menu-item {{ menuActive('receptionist.profile*') }}" style="display:none;">
                    <a href="{{ route('receptionist.profile') }}" class="nav-link">
                        <i class="menu-icon las la-user"></i>
                        <span class="menu-title">@lang('Profile Setting')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item {{ menuActive('receptionist.password*') }}" style="display:none;">
                    <a href="{{ route('receptionist.password') }}" class="nav-link">
                        <i class="menu-icon las la-lock"></i>
                        <span class="menu-title">@lang('Password Setting')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item">
                    <a href="{{ route('receptionist.logout') }}" class="nav-link">
                        <i class="menu-icon la la-sign-out"></i>
                        <span class="menu-title">@lang('Logout')</span>
                    </a>
                </li>


            </ul>

            <div class="text-uppercase mb-3 text-center">
                <span class="text--primary">{{ __(systemDetails()['name']) }}</span>
                <span class="text--success">@lang('V'){{ systemDetails()['version'] }} </span>
            </div>
        </div>
    </div>
</div>
<!-- sidebar end -->

@push('script')
    <script>
        $('#sidebar__menuWrapper').animate({
            scrollTop: eval($(".active").offset().top - 320)
        }, 500);
    </script>
@endpush
