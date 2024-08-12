@php
$blogContent = getContent('blog.content', true);
$blogElements = getContent('blog.element', false, 3);
@endphp

<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 text-center">
                <div class="section-header">
                    <h2 class="section-title">{{ __($blogContent->data_values->heading) }}</h2>
                    <p>{{ __($blogContent->data_values->subheading) }}</p>
                </div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center">
            @foreach ($blogElements as $blog)
                <div class="col-lg-4 col-md-6">
                    <div class="blog-post">
                        <div class="blog-post__thumb">
                            <img src="{{ getImage('assets/images/frontend/blog/thumb_' . $blog->data_values->image, '400x280') }}" alt="image">
                        </div>
                        <div class="blog-post__content">
                            <ul class="blog-meta">
                                <li>{{ showDateTime($blog->creatd_at, 'd M, Y') }}</li>
                            </ul>

                            <h5 class="title">
                                <a href="{{ route('blog.details', [slug($blog->data_values->title), $blog->id]) }}"> @php echo substr(trans($blog->data_values->title),0,60) @endphp</a>
                            </h5>

                            <p>@php echo strLimit(strip_tags($blog->data_values->description), 100)  @endphp</p>

                            <a href="{{ route('blog.details', [slug($blog->data_values->title), $blog->id]) }}" class="mt-3">@lang('Read More') <i class="las la-long-arrow-alt-right"></i></a>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
