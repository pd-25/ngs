@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('admin.hotel.room.type.save', @$roomType ? $roomType->id : 0) }}" method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            @lang('General Information')
                        </h5>
                    </div>
                    <div class="card-body general-info">
                        @csrf
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Name')</label>
                                    <input class="form-control" type="text" name="name" value="{{ old('name', @$roomType->name) }}" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">@lang('Total Adult')</label>
                                    <input class="form-control" type="number" min="1" name="total_adult" value="{{ old('total_adult', @$roomType->total_adult) }}" required>
                                </div>
                            </div>

                            <div class="col-md-4" style="display:none;">
                                <div class="form-group">
                                    <label class="form-control-label">@lang('Total Child')</label>
                                    <input class="form-control" type="number" min="0" name="total_child" value="0">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fare" class="required">@lang('Fare')</label>
                                    <div class="input-group">
                                        <input type="number" name="fare" id="fare" class="form-control" value="{{ old('fare', getAmount(@$roomType->fare)) }}" required>
                                        <span class="input-group-text">{{ __(@$general->cur_text) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> @lang('Amenities')</label>
                                    <select class="select2-multi-select" name="amenities[]" multiple="multiple">
                                        @foreach ($amenities as $item)
                                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> @lang('Complements')</label>
                                    <select class="select2-multi-select" name="complements[]" multiple="multiple">
                                        @foreach ($complements as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Keywords')</label>
                                    <select name="keywords[]" class="form-control select2-auto-tokenize" multiple="multiple"></select>
                                    <small class="text-facebook ml-2 mt-2">@lang('Separate multiple keywords by') <code>,</code>(@lang('comma')) @lang('or') <code>@lang('enter')</code> @lang('key')</small>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        @lang('Featured')
                                        <i class="fa fa-info-circle text--primary" title="@lang('Featured rooms will appear in featured rooms section')"></i>
                                    </label>
                                    <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="50" data-on="@lang('Featured')" data-off="@lang('Unfeatured')" name="feature_status" @if (@$roomType->feature_status) checked @endif>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">

                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            @lang('Room Information')
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row d-flex justify-content-center mb-3">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <h4 class="mb-1">@lang('Total Room')</h4>
                                    <input class="form-control" type="number" min="1" name="total_room" value="{{ @$roomType->rooms ? $roomType->rooms->count() : '' }}" required @isset($roomType) readonly @endisset>
                                </div>
                            </div>
                        </div>
                        <div class="room">
                            @isset($roomType)
                                <div class="row border-top pt-3">
                                    @foreach ($roomType->rooms as $room)
                                        <div class="col-md-3 room-content">
                                            <div class="form-group">
                                                <label for="bed" class="required">@lang('Room') -
                                                    <span class="serialNumber">{{ $loop->iteration }}</span>
                                                </label>
                                                <input type="text" value="{{ $room->room_number }}" class="form-control roomNumber" disabled>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <button type="button" class="btn btn--success addMore"> <i class="la la-plus"></i>
                                    @lang('Add More')</button>
                            @endisset


                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            @lang('Bed Per Room')
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row d-flex justify-content-center mb-3">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <h4 class="mb-1">@lang('Total Bed')</h4>
                                    <input class="form-control" type="number" min="1" name="total_bed" value="{{ @$roomType ? count(@$roomType->beds) : '' }}" @isset($roomType) readonly @endisset required>
                                </div>
                            </div>
                        </div>
                        <div class="bed">
                            @isset($roomType)
                                <div class="row border-top pt-3">
                                    @foreach ($roomType->beds as $bed)
                                        <div class="col-md-3 number-field-wrapper bed-content">
                                            <div class="form-group">
                                                <label for="bed" class="required">@lang('Bed') - <span
                                                          class="serialNumber">{{ $loop->iteration }}</span></label>
                                                <div class="input-group">
                                                    <select class="form-control bedType" name="bed[{{ $loop->iteration }}]">
                                                        <option value="">@lang('Select One')</option>
                                                        @foreach ($bedTypes as $bedType)
                                                            <option value="{{ $bedType->name }}" @if ($bedType->name == $bed) selected @endif>
                                                                {{ $bedType->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <button type="button" class="input-group-text bg-danger btnRemove border-0" data-name="bed"><i class="las la-times"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn--success addMore"> <i class="la la-plus"></i>@lang('Add More')</button>
                            @endisset
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            @lang('Images')
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="input-images pb-3"></div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            @lang('Description')
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea name="description" id="description" class="form-control" rows="5">{{ @$roomType->description ?? old('description') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.hotel.room.type.all') }}" class="btn btn-sm btn-outline--primary"><i
           class="las la-undo"></i>@lang('Back')</a>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/image-uploader.min.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/image-uploader.min.css') }}">
@endpush

@push('style')
    <style>
        .select2-container .select2-selection--multiple {
            min-height: 45px !important;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            let bedTypes = @json($bedTypes);


            @if (isset($images))
                let preloaded = @json($images);
            @else
                let preloaded = [];
            @endif

            $('.input-images').imageUploader({
                preloaded: preloaded,
                imagesInputName: 'images',
                preloadedInputName: 'old',
                maxSize: 2 * 1024 * 1024,
                maxFiles: 6
            });

            $('.select2-multi-select').select2({
                dropdownParent: $('.general-info')
            });

            $('.select2-auto-tokenize').select2({
                dropdownParent: $('.general-info'),
                tags: true,
                tokenSeparators: [',']
            });


            // room js
            $('[name=total_room]').on('input', function() {
                var totalRoom = $(this).val();
                if (totalRoom) {
                    let content = '<div class="row border-top pt-3">';
                    for (var i = 1; i <= totalRoom; i++) {
                        content += getRoomContent(i);
                    }
                    content += '</div>';
                    $('.room').html(content);
                }
            });

            function getRoomContent(number) {
                return `
                <div class="col-md-3 number-field-wrapper room-content">
                    <div class="form-group">
                        <label for="room" class="required">@lang('Room') - <span class="serialNumber">${number}</span></label>
                        <div class="input-group">
                            <input type="text" name="room[]" class="form-control roomNumber" required>
                            <button type="button" class="input-group-text bg-danger border-0 btnRemove" data-name="room"><i class="las la-times"></i></button>
                        </div>
                    </div>
                </div>`;
            }


            function setTotalRoom() {
                var totalRoom = $('.roomNumber').length;
                console.log(totalRoom);
                $('[name=total_room]').val(totalRoom);
            }

            //bed js
            $('[name=total_bed]').on('input', function() {
                var totalBed = $(this).val();
                if (totalBed) {
                    let content = '<div class="row border-top pt-3">';
                    for (var i = 1; i <= totalBed; i++) {
                        content += getBedContent(i);
                    }
                    content += '</div>';
                    $('.bed').html(content);
                }
            });

            function getBedContent(number) {
                return `
                    <div class="col-md-3 number-field-wrapper bed-content">
                        <div class="form-group">
                            <label for="bed" class="required">@lang('Bed') - <span class="serialNumber">${number}</span></label>
                            <div class="input-group"><select class="form-control bedType" name="bed[${number}]">
                                        <option value="">@lang('Select One')</option>
                                        ${allBedType()}
                                    </select><button type="button" class="input-group-text bg-danger border-0 btnRemove" data-name="bed"><i class="las la-times"></i></button>
                            </div>
                        </div>
                    </div>`;
            }

            function setTotalBed() {
                var totalBed = $('.bedType').length;
                $('[name=total_bed]').val(totalBed);
            }

            function allBedType() {
                var options;
                $.each(bedTypes, function(i, e) {
                    options += `<option value="${e.name}">${e.name}</option>`;
                });
                return options;
            }


            //common js
            $('[name=total_bed]').on('input', function() {
                var totalBed = $(this).val();
                if (totalBed) {
                    let content = '<div class="row border-top pt-3">';
                    for (var i = 1; i <= totalBed; i++) {
                        content += getBedContent(i);
                    }
                    content += '</div>';
                    $('.bed').html(content);
                }
            });

            $(document).on('click', '.btnRemove', function() {
                $(this).closest('.number-field-wrapper').remove();
                let divName = null;
                if ($(this).data('name') == 'bed') {
                    setTotalBed();
                    divName = $('.bed-content').find('.serialNumber');
                } else {
                    divName = $('.room-content').find('.serialNumber');
                    setTotalRoom();
                }
                resetSerialNumber(divName);
            });

            function resetSerialNumber(divName) {
                $.each(divName, function(i, e) {
                    $(e).text(i + 1)
                });
            }

            $('.addMore').on('click', function() {
                if ($(this).parents().hasClass('room')) {
                    var total = $('.roomNumber').length;
                    total += 1;

                    $('.room .row').append(getRoomContent(total));
                    setTotalRoom();
                    return;
                }

                var total = $('.bedType').length;
                total += 1;

                $('.bed .row').append(getBedContent(total));
                setTotalBed();
            });


            // Edit part
            let roomType = @json(@$roomType);
            if (roomType) {
                $.each(roomType.amenities, function(i, e) {
                    $(`select[name="amenities[]"] option[value=${e.id}]`).prop('selected', true);
                });

                $.each(roomType.complements, function(i, e) {
                    $(`select[name="complements[]"] option[value=${e.id}]`).prop('selected', true);
                });

                $('.select2-multi-select').select2({
                    dropdownParent: $('.general-info')
                });

                var keyword = $('select[name="keywords[]"]');
                keyword.html('');

                let options = '';

                $.each(roomType.keywords, function(index, value) {
                    options += `<option value="${value}" selected>${value}</option>`
                });

                keyword.append(options);
                keyword.select2({
                    dropdownParent: $('.general-info'),
                    tags: true,
                    tokenSeparators: [',']
                });
            }
        })(jQuery);
    </script>
@endpush
