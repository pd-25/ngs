@php
$content = getContent('featured_room.content', true);

$roomType = App\Models\RoomType::active()
    ->featured()
    ->with(['images', 'amenities'])
    ->get();
@endphp

@if (count($roomType) > 0)
    <section class="section section--bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center">
                    <div class="section-header">
                        <h2 class="section-title">{{ __($content->data_values->heading) }}</h2>
                        <p>{{ __($content->data_values->subheading) }}</p>
                    </div>
                </div>
            </div>
            <div class="row g-4 justify-content-center">
                <!-- room section start -->
                @foreach ($roomType as $type)
                    <div class="col-lg-6 col-xl-4 col-md-8">
                        <div class="room-card">
                            <div class="room-card__thumb">
                                <img src="{{ getImage(getFilePath('roomTypeImage') . '/' . @$type->images->first()->image, getFileSize('roomTypeImage')) }}"
                                     alt="image">
                                <ul class="room-card__utilities">
                                    @foreach ($type->amenities->take(4) as $amenity)
                                        <li data-bs-toggle="tooltip" data-bs-placement="right"
                                            title="{{ $amenity->title }}">
                                            @php echo $amenity->icon  @endphp
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="room-card__content">
                                <h3 class="title mb-2"><a
                                       href="{{ route('room.type.details', [$type->id, slug($type->name)]) }}">{{ __($type->name) }}</a>
                                </h3>
                                <div class="room-card__bottom justify-content-between align-items-center mt-2 gap-3">
                                    <div>
                                        <h6 class="price text--base mb-3">
                                            {{ showAmount($type->fare) }}
                                            {{ $general->cur_text }} / @lang('Night')
                                        </h6>

                                        <div class="room-capacity text--base d-flex align-items-center justify-content-center flex-wrap gap-3">
                                            <span class="custom--badge">
                                                @lang('Adult') &nbsp; {{ $type->total_adult }}
                                            </span>
                                            <span class="custom--badge">
                                                @lang('Child') &nbsp; {{ $type->total_child }}
                                            </span>

                                            <a href="{{ route('room.type.details', [$type->id, slug($type->name)]) }}" class="btn btn-sm btn--base">
                                                <i class="la la-desktop me-2"></i>@lang('Book Now')
                                            </a>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- room section end -->
            </div>
        </div>
    </section>
@endif
