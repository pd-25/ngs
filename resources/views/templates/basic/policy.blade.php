@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="section mt-5">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12">
                    @php
                        echo $policy->data_values->details;
                    @endphp
                </div>
            </div>
        </div>
    </section>
@endsection
