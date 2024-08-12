@php
$subscribeContent = getContent('subscribe.content', true);
@endphp
<section class="section base--overlay bg_img" style="background-image: url('{{ getImage('assets/images/frontend/subscribe/' . @$subscribeContent->data_values->image, '1800x300') }}');">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <h2 class="section-title text-center text-white">{{ __(@$subscribeContent->data_values->heading) }}</h2>
                <form action="" class="subscribe-form" id="subscribe">
                    @csrf
                    <input type="email" name="email" class="form--control" placeholder="@lang('Enter email address')">
                    <button type="submit" class="btn btn--dark"><i class="fa fa-paper-plane" aria-hidden="true"></i> &nbsp; {{ __(@$subscribeContent->data_values->button_title) }}</button>
                </form>
            </div>
        </div>
    </div>
</section>

@push('script')
    <script>
        (function($) {
            "use strict";
            var formEl = $("#subscribe");
            formEl.on('submit', function(e) {
                e.preventDefault();
                var data = formEl.serialize();

                if (formEl.find('input[name=email]').val() == '') {
                    return notify('error', 'The email field is required.');
                }

                $.ajax({
                    url: '{{ route('subscribe') }}',
                    method: 'post',
                    data: data,
                    success: function(response) {
                        $('input[name=email]').val('');
                        if (response.success) {
                            notify('success', response.message);
                        } else {
                            $.each(response.error, function(key, value) {
                                notify('error', value);
                            });
                        }
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
