@extends('admin.layouts.app')

@section('panel')
    @if (@json_decode($general->system_info)->version > systemDetails()['version'])
        <div class="row">
            <div class="col-md-12">
                <div class="card bg-warning mb-3 text-white">
                    <div class="card-header">
                        <h3 class="card-title"> @lang('New Version Available') <button class="btn btn--dark float-end">@lang('Version') {{ json_decode($general->system_info)->version }}</button> </h3>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-dark">@lang('What is the Update ?')</h5>
                        <p>
                        <p>
                            <pre class="f-size--24">{{ json_decode($general->system_info)->details }}</pre>
                        </p>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (@json_decode($general->system_info)->message)
        <div class="row">
            @foreach (json_decode($general->system_info)->message as $msg)
                <div class="col-md-12">
                    <div class="alert border--primary border" role="alert">
                        <div class="alert__icon bg--primary"><i class="far fa-bell"></i></div>
                        <p class="alert__message">@php echo $msg; @endphp</p>
                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="row gy-4">
        <div class="col-xxl-3 col-sm-6" style="display:none;">
            <div class="card bg--primary has-link box--shadow2 overflow-hidden">
                <a href="{{ route('admin.users.all') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-users f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text--small text-white">@lang('Total Users')</span>
                            <h2 class="text-white">{{ $widget['total_users'] }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xxl-3 col-sm-6" style="display:none;">
            <div class="card bg--success has-link box--shadow2">
                <a href="{{ route('admin.users.active') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-user-plus f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text--small text-white">@lang('Active Users')</span>
                            <h2 class="text-white">{{ $widget['verified_users'] }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6" style="display:none;">
            <div class="card bg--danger has-link box--shadow2">
                <a href="{{ route('admin.users.email.unverified') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="lar la-envelope f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text--small text-white">@lang('Email Unverified Users')</span>
                            <h2 class="text-white">{{ $widget['email_unverified_users'] }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6" style="display:none;">
            <div class="card bg--red has-link box--shadow2">
                <a href="{{ route('admin.users.mobile.unverified') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-mobile-alt f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text--small text-white">@lang('Mobile Unverified Users')</span>
                            <h2 class="text-white">{{ $widget['mobile_unverified_users'] }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- row end-->


    <div class="row gy-4 mt-2">
        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="la la-check-circle overlay-icon text--dark"></i>
                <div class="widget-two__icon b-radius--5 bg--dark">
                    <i class="la la-check-circle"></i>
                </div>
                <div class="widget-two__content">
                    <h3>{{ $hotel['today_booked'] }}</h3>
                    <p>@lang('Today\'s Booked Room')</p>
                </div>
                <a href="{{ route('admin.booking.todays.booked') }}" class="widget-two__btn border--dark btn-outline--dark border">@lang('View All')</a>
            </div>
        </div>

        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="la la-box overlay-icon text--info"></i>
                <div class="widget-two__icon b-radius--5 bg--info">
                    <i class="las la-hospital-alt"></i>
                </div>
                <div class="widget-two__content">
                    <h3>{{ $hotel['today_available'] }}</h3>
                    <p>@lang('Today\'s Available Room')</p>
                </div>
                <a href="{{ route('admin.booking.todays.booked') }}?type=not_booked" class="widget-two__btn border--info btn-outline--info border">@lang('View All')</a>
            </div>
        </div>

        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="las la-clipboard-check overlay-icon text--warning"></i>
                <div class="widget-two__icon b-radius--5 bg--warning">
                    <i class="las la-clipboard-check"></i>
                </div>
                <div class="widget-two__content">
                    <h3>{{ $hotel['booking_requests'] }}</h3>
                    <p>@lang('Booking Requests')</p>
                </div>
                <a href="{{ route('admin.booking.request.all') }}" class="widget-two__btn border--warning btn-outline--warning border">@lang('View All')</a>
            </div>
        </div>


        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="las la-clipboard-check overlay-icon text--success"></i>
                <div class="widget-two__icon b-radius--5 bg--success">
                    <i class="las la-clipboard-check"></i>
                </div>
                <div class="widget-two__content">
                    <h3>{{ $hotel['running_bookings'] }}</h3>
                    <p>@lang('Running Booking')</p>
                </div>
                <a href="{{ route('admin.booking.active') }}" class="widget-two__btn border--success btn-outline--success border">@lang('View All')</a>
            </div>
        </div>

    </div><!-- row end-->

    <div class="row gy-4 mt-2">
        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="la la-hand-holding-usd overlay-icon text--success"></i>
                <div class="widget-two__icon b-radius--5 bg--success">
                    <i class="la la-hand-holding-usd"></i>
                </div>
                <div class="widget-two__content">
                    <h3>{{ $general->cur_sym }}{{ showAmount($deposit['total_deposit_amount']) }}</h3>
                    <p>@lang('Total Payments')</p>
                </div>
                <a href="{{ route('admin.deposit.list') }}" class="widget-two__btn border--success btn-outline--success border">@lang('View All')</a>
            </div>
        </div>

        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="la la-percentage overlay-icon text--primary"></i>
                <div class="widget-two__icon b-radius--5 bg--primary">
                    <i class="la la-percentage"></i>
                </div>
                <div class="widget-two__content">
                    <h3>{{ $general->cur_sym }}{{ showAmount($deposit['total_deposit_charge']) }}</h3>
                    <p>@lang('Payment Charge')</p>
                </div>
                <a href="{{ route('admin.deposit.list') }}" class="widget-two__btn border--primary btn-outline--primary border">@lang('View All')</a>
            </div>
        </div>

        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="la la-spinner overlay-icon text--warning"></i>
                <div class="widget-two__icon b-radius--5 bg--warning">
                    <i class="la la-spinner"></i>
                </div>
                <div class="widget-two__content">
                    <h3>{{ $deposit['total_deposit_pending'] }}</h3>
                    <p>@lang('Pending Payments')</p>
                </div>
                <a href="{{ route('admin.deposit.pending') }}" class="widget-two__btn border--warning btn-outline--warning border">@lang('View All')</a>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="la la-ban overlay-icon text--danger"></i>
                <div class="widget-two__icon b-radius--5 bg--danger">
                    <i class="la la-ban"></i>
                </div>
                <div class="widget-two__content">
                    <h3>{{ $deposit['total_deposit_rejected'] }}</h3>
                    <p>@lang('Rejected Payments')</p>
                </div>
                <a href="{{ route('admin.deposit.rejected') }}" class="widget-two__btn border--danger btn-outline--danger border">@lang('View All')</a>
            </div>
        </div>

    </div><!-- row end-->

    <div class="row mb-none-30 mt-30">
        <div class="col-xl-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Monthly Booking Report') (@lang('Last 12 Months'))</h5>
                    <div id="apex-bar-chart-1"> </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Monthly Payment Report') (@lang('Last 30 Days'))</h5>
                    <div id="apex-line"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-none-30 mt-5" style="display:none;">
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Browser') (@lang('Last 30 days'))</h5>
                    <canvas id="userBrowserChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By OS') (@lang('Last 30 days'))</h5>
                    <canvas id="userOsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Country') (@lang('Last 30 days'))</h5>
                    <canvas id="userCountryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/viser_admin/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/viser_admin/js/vendor/chart.js.2.8.0.js') }}"></script>


    <script>
        "use strict";

        //last one 12 month booking graph
        var options = {
            series: [{
                name: 'Total Booking Amount',
                data: [
                    @foreach ($months as $month)
                        {{ getAmount(@$bookingMonth->where('months', $month)->first()->bookingAmount) }},
                    @endforeach
                ]
            }],
            chart: {
                type: 'bar',
                height: 450,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '50%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: @json($months),
            },
            yaxis: {
                title: {
                    text: "{{ __($general->cur_sym) }}",
                    style: {
                        color: '#7c97bb'
                    }
                }
            },
            grid: {
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "{{ __($general->cur_sym) }}" + val + " "
                    }
                }
            }
        };


        var chart = new ApexCharts(document.querySelector("#apex-bar-chart-1"), options);
        chart.render();


         // apex-line chart
        var options = {
        chart: {
            height: 450,
            type: "area",
            toolbar: {
            show: false
            },
            dropShadow: {
            enabled: true,
            enabledSeries: [0],
            top: -2,
            left: 0,
            blur: 10,
            opacity: 0.08
            },
            animations: {
            enabled: true,
            easing: 'linear',
            dynamicAnimation: {
                speed: 1000
            }
            },
        },
        dataLabels: {
            enabled: false
        },
        colors: ['#28c76f', '#ea5455', '#546E7A', '#E91E63', '#FF9800'],
        series: [
            {
            name: "Received",
            data: [
                @foreach($trxReport['date'] as $trxDate)
                    {{ @$plusTrx->where('date',$trxDate)->first()->amount ?? 0 }},
                @endforeach
            ]
            },
            {
            name: "Returned",
            data: [
                    @foreach($trxReport['date'] as $trxDate)
                        {{ @$minusTrx->where('date',$trxDate)->first()->amount ?? 0 }},
                    @endforeach
                ]
            }
        ],
        fill: {
            type: "gradient",
            gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.7,
            opacityTo: 0.9,
            stops: [0, 90, 100]
            }
        },
        xaxis: {
            categories: [
                @foreach($trxReport['date'] as $trxDate)
                    "{{ $trxDate }}",
                @endforeach
            ]
        },
        grid: {
            padding: {
            left: 5,
            right: 5
            },
            xaxis: {
            lines: {
                show: false
            }
            },
            yaxis: {
            lines: {
                show: false
            }
            },
        },
        };
        var chart = new ApexCharts(document.querySelector("#apex-line"), options);
        chart.render();

        var ctx = document.getElementById('userBrowserChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($chart['user_browser_counter']->keys()),
                datasets: [{
                    data: {{ $chart['user_browser_counter']->flatten() }},
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(231, 80, 90, 0.75)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                maintainAspectRatio: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            }
        });



        var ctx = document.getElementById('userOsChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($chart['user_os_counter']->keys()),
                datasets: [{
                    data: {{ $chart['user_os_counter']->flatten() }},
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(0, 0, 0, 0.05)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            },
        });


        // Donut chart
        var ctx = document.getElementById('userCountryChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($chart['user_country_counter']->keys()),
                datasets: [{
                    data: {{ $chart['user_country_counter']->flatten() }},
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(231, 80, 90, 0.75)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            }
        });
    </script>
@endpush
