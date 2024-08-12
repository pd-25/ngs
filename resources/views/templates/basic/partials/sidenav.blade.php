<div class="user-sidebar sidemenu">
    <button class="sidebar-close d-xl-none"><i class="las la-times"></i></button>
    <ul class="user-sidebar__menu">
        <li class="{{ menuActive('user.home') }}"><a href="{{ route('user.home') }}"><i class="la la-home"></i>
                @lang('Dashboard')</a></li>

        <li class="{{ menuActive('user.booking.request.all') }}"><a href="{{ route('user.booking.request.all') }}"><i class="la la-list"></i> @lang('Booking Requests')</a>
        </li>

        <li class="{{ menuActive('user.booking.all') }}">
            <a href="{{ route('user.booking.all') }}"><i class="la la-list-alt"></i> @lang('My Bookings')</a>
        </li>
        <li class="{{ menuActive('user.deposit.history') }}">
            <a href="{{ route('user.deposit.history') }}"> <i class="la la-money"></i> @lang('Payment Log')</a>
        </li>

        <li class="{{ menuActive('ticket.open') }}"><a href="{{ route('ticket.open') }}"><i class="la la-headphones"></i> @lang('Open Ticket')</a></li>

        <li class="{{ menuActive('ticket') }}"><a href="{{ route('ticket') }}"><i class="la la-list-ol"></i> @lang('Support Tickets')</a></li>

        <li class="{{ menuActive('user.profile.setting') }}"><a href="{{ route('user.profile.setting') }}"><i class="la la-cog"></i> @lang('Profile Setting')</a></li>

        <li class="{{ menuActive('user.change.password') }}"><a href="{{ route('user.change.password') }}"><i class="la la-lock"></i> @lang('Change Password')</a></li>

        <li><a href="{{ route('user.logout') }}"><i class="la la-sign-out-alt"></i>@lang('Sign Out')</a></li>
    </ul>
</div><!-- user-sidebar end -->

<style>
    .sidemenu{
        margin-top:105px;
    }
</style>