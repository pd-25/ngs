@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="col-lg-12">

        <div class="card custom--card">
            <div class="card-header">
                <h6 class="card-title">{{ __($pageTitle) }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('ticket.store') }}" method="post" enctype="multipart/form-data" onsubmit="return submitUserForm();">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="name" value="{{ @$user->firstname . ' ' . @$user->lastname }}">
                        <input type="hidden" name="email" value="{{ @$user->email }}">
                        <div class="col-lg-6 form-group">
                            <label>@lang('Subject')</label>
                            <input type="text" name="subject" value="{{ old('subject') }}" class="form--control"
                                   placeholder="@lang('Enter subject')" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>@lang('Priority')</label>
                            <select name="priority" class="select" required>
                                <option value="3">@lang('High')</option>
                                <option value="2">@lang('Medium')</option>
                                <option value="1">@lang('Low')</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>@lang('Message')</label>
                        <textarea name="message" id="inputMessage" class="form--control" placeholder="@lang('Your reply...')"
                                  required>{{ old('message') }}</textarea>
                    </div>
                    <div class="form-group">
                        <div class="text-end">
                            <button type="button" class="btn btn-outline--custom btn-sm addFile">
                                <i class="la la-plus"></i> @lang('Add New')
                            </button>
                        </div>
                        <div class="file-upload">
                            <label class="form-label">
                                @lang('Attachments')
                                <small class="text-danger"> (@lang('Max 5 files can be uploaded'). @lang('Maximum upload size is')
                                    {{ ini_get('upload_max_filesize') }})</small>
                            </label>


                            <input type="file" name="attachments[]" id="inputAttachments"
                                   class="form-control custom--file-upload" />
                            <div id="fileUploadsContainer"></div>
                            <p class="ticket-attachments-message text-muted">
                                @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'),
                                .@lang('pdf'), .@lang('doc'), .@lang('docx')
                            </p>
                        </div>
                    </div>
                    <div class="form-group text-end">
                        <button class="btn btn-md btn--base w-100" type="submit" id="recaptcha"><i
                               class="la la-paper-plane"></i>&nbsp;@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div><!-- card end -->
    </div>
@endsection

@push('style')
    <style>
        .input-group-text:focus {
            box-shadow: none !important;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addFile').on('click', function() {
                if (fileAdded >= 4) {
                    notify('error', 'You\'ve added maximum number of file');
                    return false;
                }
                fileAdded++;
                $("#fileUploadsContainer").append(`
                    <div class="input-group my-3">
                        <input type="file" name="attachments[]" class="form-control custom--file-upload" required />
                        <button class="input-group-text btn-danger remove-btn"><i class="las la-times"></i></button>
                    </div>
                `)
            });
            $(document).on('click', '.remove-btn', function() {
                fileAdded--;
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
