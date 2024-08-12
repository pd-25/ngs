@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-xl-12">
            <div class="card b-radius--10 ">
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table--light style--two">
                    <tbody>
                      <tr>
                          <td>{{ systemDetails()['name'] }} @lang('Version')</td>
                          <td>{{ systemDetails()['version'] }}</td>
                      </tr>
                      <tr>
                          <td>@lang('Build Version')</td>
                          <td>{{ systemDetails()['build_version'] }}</td>
                      </tr>
                      <tr>
                          <td>@lang('Laravel Version')</td>
                          <td>{{ $laravelVersion }}</td>
                      </tr>
                      <tr>
                          <td>@lang('Timezone')</td>
                          <td>{{ @$timeZone }}</td>
                      </tr>
                    </tbody>
                  </table><!-- table end -->
                </div>
              </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
<style>
  td{
    font-size: 22px !important;
  }
  .table td {
      white-space: nowrap;
  }
</style>
@endpush
