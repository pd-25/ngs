@php
$serviceContent = getContent('service.content', true);
$seviceElement = getContent('service.element', false, 4);
@endphp

<section class="service-section section">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-6">
                <div class="video-area">
                    <div class="video-wrapper">
                        <img src="{{ getImage('assets/images/frontend/service/' . $serviceContent->data_values->video_thumb, '615x630') }}"
                            alt="image">
                        <a href="{{ $serviceContent->data_values->video_url }}" data-rel="lightcase" class="video-icon"><i class="fas fa-play"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="service-content">
                    <div class="section-header">
                        <h2 class="section-title text-white">{{ __($serviceContent->data_values->heading) }}</h2>
                        <p class="text-white">{{ __($serviceContent->data_values->subheading) }}</p>
                    </div>
                    <div class="row gy-4">
                        @foreach ($seviceElement as $service)
                            <div class="col-sm-6">
                                <div class="service-card">
                                    <div class="icon">
                                        @php
                                            echo $service->data_values->icon;
                                        @endphp
                                    </div>
                                    <h5 class="title">{{ __($service->data_values->name) }}</h5>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
