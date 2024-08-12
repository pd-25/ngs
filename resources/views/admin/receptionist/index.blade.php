@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light table">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Username')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Email')</th>
                                    <th>@lang('Mobile Number')</th>
                                    <th>@lang('Address')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($receptionists as $receptionist)
                                    <tr>
                                        <td data-label="@lang('S.N.')">{{ $receptionists->firstItem() + $loop->index }}
                                        </td>
                                        <td data-label="@lang('Username')">
                                            {{ __($receptionist->username) }}
                                        </td>
                                        <td data-label="@lang('Name')">
                                            <span class="fw-bold">{{ __($receptionist->name) }}</span>
                                        </td>
                                        <td data-label="@lang('Email')">
                                            {{ __($receptionist->email) }}
                                        </td>
                                        <td data-label="@lang('Mobile Number')">
                                            {{ $receptionist->mobile }}
                                        </td>
                                        <td data-label="@lang('Address')">
                                            {{ __($receptionist->address) }}
                                        </td>
                                        <td data-label="@lang('Status')">
                                            @if ($receptionist->status == 1)
                                                <span class="badge badge--success">@lang('Active')</span>
                                            @else
                                                <span class="badge badge--danger">@lang('Disabled')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Action')">
                                            <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn"
                                                    data-resource="{{ $receptionist }}" data-modal_title="@lang('Update Receptionist')"
                                                    data-edit="1" data-has_status="1">
                                                <i class="la la-pencil"></i>@lang('Edit')
                                            </button>

                                            <a target="_blank" href="{{ route('admin.receptionist.login', $receptionist->id) }}"
                                               class="btn btn-sm btn-outline--dark"><i class="las la-sign-in-alt"></i>@lang('Log In')</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ $emptyMessage }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($receptionists->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($receptionists) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>

    {{-- Add METHOD MODAL --}}
    <div id="cuModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.receptionist.save') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label> @lang('Name')</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label> @lang('Username')</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="form-group">
                            <label> @lang('Email')</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label> @lang('Mobile Number')</label>
                            <input type="number" class="form-control" name="mobile" required>
                        </div>
                        <div class="form-group">
                            <label> @lang('Address')</label>
                            <textarea name="address"></textarea>
                        </div>
                        <div class="form-group">
                            <label> @lang('Password')</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="password" required>
                                <button class="input-group-text generatePasswordButton" type="button">
                                    <i class="las la-sync-alt"></i>
                                </button>
                            </div>
                        </div>
                        <div class="status"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal></x-confirmation-modal>
@endsection

@push('script')
    <script>
        "use strict";
        (function($) {
            $('.generatePasswordButton').on('click', function() {
                setNewPassword();
            });

            $('.cuModalBtn').on('click', function() {
                if ($(this).data('edit') == 1) {
                    $('[name=password]').parents('.form-group').find('label').removeClass('required');
                    $('[name=password]').removeAttr('required');
                } else {
                    $('[name=password]').attr('required');
                    $('[name=password]').parents('.form-group').find('label').addClass('required');
                }
            });

            $('#cuModal').on('shown.bs.modal', function() {
                $('[name=password]').val('');

                if (!$('[name=name]').val()) setNewPassword();
            });

            function setNewPassword() {
                var length = 8,
                    charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+<>?,./",
                    password = "";
                for (var i = 0, n = charset.length; i < length; ++i) {
                    password += charset.charAt(Math.floor(Math.random() * n));
                }
                $('[name=password]').val(password);
            }
        })(jQuery);
    </script>
@endpush


@push('breadcrumb-plugins')
    <div class="d-flex justify-content-end flex-wrap gap-2">
        <form action="" method="GET" class="form-inline">
            <div class="input-group justify-content-end">
                <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Username / Name')" value="{{ request()->search }}">
                <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>

        <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="@lang('Add New Receptionist')">
            <i class="las la-plus"></i>@lang('Add New')
        </button>
    </div>
@endpush
