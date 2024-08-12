@extends($activeTemplate.'layouts.master')

@section('content')
<div class="col-md-10">
    <div class="card card-deposit custom--card">
        <div class="card-header">
            <h5 class="card-title">@lang('Payment Preview')</h5>
        </div>
        <div class="card-body card-body-deposit">
            <h4 class="my-2"> @lang('PLEASE SEND EXACTLY') <span class="text-success"> {{ $data->amount }}</span> {{__($data->currency)}}</h4>
            <h5 class="mb-2">@lang('TO') <span class="text-success"> {{ $data->sendto }}</span></h5>
            <img src="{{$data->img}}" alt="@lang('Image')">
            <h4 class="text-white bold my-4">@lang('SCAN TO SEND')</h4>
        </div>
    </div>
</div>
@endsection
