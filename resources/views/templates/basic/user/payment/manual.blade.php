@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="col-md-10">
        <div class="card custom--card">
            <div class="card-header">
                <h5 class="card-title">{{ __($pageTitle) }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('user.deposit.manual.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p class="mt-2 text-center">@lang('You have requested') <b class="text--success">{{ showAmount($data['amount']) }} {{ __($general->cur_text) }}</b> , @lang('Please pay')
                                <b class="text--success">{{ showAmount($data['final_amo']) . ' ' . $data['method_currency'] }} </b> @lang('for successful payment')
                            </p>
                            <h4 class="text-center">@lang('Please follow the instruction below')</h4>

                            <p class="my-3 text-center">@php echo  $data->gateway->description @endphp</p>

                        </div>

                        <x-viser-form identifier="id" identifierValue="{{ $gateway->form_id }}"></x-viser-form>

                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn--base w-100">@lang('Pay Now')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
