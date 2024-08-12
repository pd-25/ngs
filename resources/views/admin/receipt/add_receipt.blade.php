@extends('admin.layouts.app')

@section('panel')
    <section class="section">
                <div class="container respons">

  <div class="row m-2">
                    <table class="_table" id="tableId">
                      <thead style="background-color: #002e5a;color:white;">
                        <tr>
                          <th>{{ __('Receipt Type') }}</th>
                          {{-- <th>{{ __('Receipt No.') }}</th> --}}
                          <th>{{ __(' Receipt Date') }}</th>
                          <th>{{ __('Amount') }}</th>
                          <th width="50px"></th>
                        </tr>
                      </thead>
                      <tbody id="table_body">
                        <tr id="appendRow_0">
                          <td scope="row">
              <input type="radio" id="option1" name="option" value="option1">
<label for="option1">Advance</label>
              <input type="radio" id="option1" name="option" value="option1">
<label for="option1">Sec Deposit</label>
</td>
                          <!--<td>-->
                          <!--    <input type="date" class="form-control" id="date" name="date[]" value="{{ date('Y-m-d') }}" required>         -->
                          <!--</td>   -->
                          {{-- <td>
                            <input type="text" class="form-control" onBlur="calculateAmount(this.value,0);"
                              placeholder="Quantity" id="quantity_0" name="quantity[]"
                              onkeypress="javascript:return isNumber(event)" value="{{ old('quantity') }}" required>
                          </td> --}}
                          <td>
                            <input type="date" class="form-control" onBlur="calculateAmount(this.value,0);"
                              placeholder="Receipt Date" id="receipt_date" name="receipt_date[]"
                              onkeypress="javascript:return isNumber(event)" value="{{ old('receipt_date') }}" required>
                          </td>
                          <td>
                            <input type="text" class="form-control amount" onblur="calculateSum()" placeholder="Amount"
                              id="receipt_amount" name="receipt_amount[]" value="{{ old('receipt_amount') }}" required>
                          </td>
                          <!--<td>-->
                          <!--    <input type="file" class="form-control"  id="attachment" name="attachment[]" value="{{ old('attachment') }}" >         -->
                          <!--</td>                                        -->
                          <td style="width: 92px;">
                            <div class="action_container">
                              <a type="button" class=" addmoreprodtxtbx" id="clonebtn"><i class="fa fa-plus"></i></a>
                              <a class=" removeprodtxtbx" id="removerow"><i class="fa fa-trash"></i></a>
                            </div>
                          </td>
                        </tr>
                      </tbody>

                    </table>
                  </div>
               </div>



</section>





    <script src="{{ asset('assets/templates/basic/assetss/js/clone.js') }}"></script>




<script src="https://code.jquery.com/jquery-3.7.0.slim.min.js"
  integrity="sha256-tG5mcZUtJsZvyKAxYLVXrmjKBVLd6VpVccqz/r4ypFE=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function () {

        count = 0;
        $(".removeprodtxtbx").eq(0).css("display", "none");
        $(document).on("click", "#clonebtn", function () {
            count++;
            //we select the box clone it and insert it after the box
            $('#table_body').append('<tr id="appendRow_' + count + '"><td scope="row"><input type="radio" id="option1" name="option" value="option1"><label for="option1">Advance</label><input type="radio" id="option1" name="option" value="option1"><label for="option1">Sec Deposit</label></td><td><input type="date" class="form-control" onBlur="calculateAmount(this.value,' + count + ');" placeholder=" 	Receipt Date" id="rate_' + count + '" name="rate[]" onkeypress="javascript:return isNumber(event)" required></td><td><input type="text" class="form-control amount" placeholder="Amount" id="receipt_amount' + count + '" name="receipt_amount[]" required></td><td style="width: 92px;"><div class="action_container"><button type="button" class=" addmoreprodtxtbx" id="clonebtn"><i class="fa fa-plus"></i></button><button type="button" class=" removeprodtxtbx" id="removerow"><i class="fa fa-trash"></i></button></div></td></tr>');
            $(".removeprodtxtbx").eq(count).css("display", "block");
            $(".addmoreprodtxtbx").eq(count).css("display", "none");

        });

        $(document).on("click", "#removerow", function () {
            $(this).parents('tr').remove();
            // $('#removerow').focus();
            count--;
            window.calculateSum()
        });

    });
</script>





@endsection


@push('breadcrumb-plugins')
<div class="d-flex justify-content-end flex-wrap gap-2">
    <form action="" method="GET" class="form-inline">
        <div class="input-group justify-content-end">
            <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Username / Name')"
                value="{{ request()->search }}">
            <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>

    <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn"
        data-modal_title="@lang('Add New Receptionist')">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
</div>
@endpush
