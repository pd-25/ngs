@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="section">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-8">
                    <h2 class="blog-details-title mb-1">{{ __($blog->data_values->title) }}</h2>
                    <div class="blog-post__date fs--14px d-inline-flex align-items-center"><i class="las la-calendar-alt fs--18px me-2"></i>{{ showDateTime($blog->creatd_at, 'd M, Y') }}</div>
                    <div class="blog-details-thumb mt-3">
                        <img src="{{ getImage('assets/images/frontend/blog/' . $blog->data_values->image, '1000x700') }}" alt="image" class="rounded-3">
                    </div>

                    <div class="blog-details-content mt-4">
                        @php
                            echo $blog->data_values->description;
                        @endphp
                    </div>

                    <ul class="post-share d-flex align-items-center mt-5 flex-wrap">
                        <li class="caption fw-bold">@lang('Share On') : </li>
                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Facebook')">
                            <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"><i class="fab fa-facebook-f"></i></a>
                        </li>
                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Linkedin')">
                            <a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ urlencode(url()->current()) }}&amp;title=my share text&amp;summary=dit is de linkedin summary" title="@lang('Linkedin')"><i class="fab fa-linkedin-in"></i></a>
                        </li>
                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Pinterest')">
                            <a target="_blank" href="http://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&description={{ __(@$blog->data_values->title) }}&media={{ getImage('assets/images/frontend/blog/' . $blog->data_values->image, '1000x700') }}" title="@lang('Pinterest')"><i class="fab fa-pinterest"></i></a>
                        </li>
                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('Twitter')">
                            <a target="_blank" href="https://twitter.com/intent/tweet?text={{ __(@$blog->data_values->title) }}%0A{{ url()->current() }}" title="@lang('Twitter')"><i class="fab fa-twitter"></i></a>
                        </li>
                    </ul>

                    <div class="fb-comments" data-href="{{ url()->current() }}" data-width="" data-numposts="5"></div>

                </div>

                @if (count($blogLists) > 0)
                    <div class="col-lg-4 ps-xl-5">
                        <div class="blog-sidebar rounded-3">
                            <h4 class="title">@lang('Latest Posts')</h4>
                            <ul class="s-post-list">
                                @foreach ($blogLists as $listItem)
                                    <li class="s-post d-flex flex-wrap">
                                        <div class="s-post__thumb">
                                            <img src="{{ getImage('assets/images/frontend/blog/thumb_' . $listItem->data_values->image, '400x280') }}" alt="image">
                                        </div>
                                        <div class="s-post__content">
                                            <h6 class="s-post__title"><a href="{{ route('blog.details', [slug($listItem->data_values->title), $listItem->id]) }}">{{ __($listItem->data_values->title) }}</a></h6>
                                            <p class="fs--14px mt-2"><i class="las la-calendar-alt fs--14px me-1"></i>{{ showDateTime($listItem->creatd_at, 'd M, Y') }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection


@push('fbComment')
    @php echo loadExtension('fb-comment') @endphp
@endpush
