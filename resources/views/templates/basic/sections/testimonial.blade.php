@php
$testimonialContent = getContent('testimonial.content', true);
$testimonialElement = getContent('testimonial.element', false);
@endphp

<section class="section dark--overlay bg_img overflow-hidden" style="background-image: url('{{ getImage('assets/images/frontend/testimonial/' . $testimonialContent->data_values->background_image, '1800x900') }}');">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 text-center">
                <div class="section-header">
                    <h2 class="section-title text-white">{{ __($testimonialContent->data_values->heading) }}</h2>
                    <p class="text-white">{{ __($testimonialContent->data_values->subheading) }}</p>
                </div>
            </div>
        </div>
        <div class="testimonial-slider">
            @foreach ($testimonialElement as $item)
                <div class="single-slide">
                    <div class="testimonial-card">
                        <div class="testimonial-card__thumb">
                            <img src="{{ getImage('assets/images/frontend/testimonial/' . $item->data_values->image, '150x150') }}" alt="image">
                        </div>
                        <h6>{{ __($item->data_values->name) }}</h6>
                        <p class="fs--14px">{{ __($item->data_values->designation) }}</p>
                        <i class="fas fa-quote-left"></i>
                        <p class="testimonial-card__description">{{ __($item->data_values->feedback) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
