

  $(document).ready(function () {

        count = 0;
        $(".removeprodtxtbx").eq(0).css("display", "none");
        $(document).on("click", "#clonebtn", function () {
            count++;
            //we select the box clone it and insert it after the box
            $('#table_body').append('<tr style="border:1px solid bisque;height: 61px; id="appendRow_' + count + '"><td scope="row"><input type="radio" id="receiptAdvance_0 value="Advance" name="receipt_type[]" form="confirmation-form"><label for="country1">Advance</label><input type="radio" id="receiptSec_0" value="Sec Deposit" name="receipt_type[]" form="confirmation-form"><label for="country2">Sec Deposit</label></td><td><input type="date" class="form-control" onBlur="calculateAmount(this.value,' + count + ');" placeholder="Receipt Date" form="confirmation-form" id="dates' + count + '" name="receipt_date[]" onkeypress="javascript:return isNumber(event)" required></td><td><input type="text" class="form-control amount" placeholder="Amount" id="amounts' + count + '" name="receipt_amount[]" form="confirmation-form" required></td><td style="width: 92px;"><div class="action_container"><button type="button" class=" addmoreprodtxtbx" id="clonebtn"><i class="fa fa-plus"></i></button><button type="button" class=" removeprodtxtbx" id="removerow"><i class="fa fa-trash"></i></button></div></td></tr>');
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
