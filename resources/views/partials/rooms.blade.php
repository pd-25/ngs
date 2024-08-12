<table class="table--light table-bordered booking-table table">
    <thead>
        <tr>
            <th>@lang('Date')</th>
            <th>@lang('Room')</th>
        </tr>
    </thead>
    <tbody class="room-table">
        @php
            $bookedRooms = [];
        @endphp

        @while ($checkIn <= $checkOut)
            <tr>
                <td class="text-center">{{ $checkIn->format('d M, Y') }}</td>
                <td data-label="Room" class="room-column">
                    <div class="d-flex w-100 flex-wrap gap-2">
                        @php
                            $selectedRoom = 0;
                        @endphp

                        @foreach ($rooms as $room)
                            @php
                                $bookedRooms[$room->room_number] = $bookedRooms[$room->room_number] ?? 0;
                                $booked = $room->booked->where('booked_for', $checkIn->format('Y-m-d'))->first();
                            @endphp

                            @if ($booked)
                                <button class="btn btn--danger btn-sm room-btn" room="room-{{ $room->room_number }}" disabled>{{ $room->room_number }}</button>
                                @php
                                    $bookedRooms[$room->room_number]++;
                                @endphp
                            @else
                                <button class="btn btn--primary btn-sm room-btn available"
                                        room="room-{{ $room->room_number }}"
                                        data-room_number="{{ $room->room_number }}"
                                        data-room="{{ $room }}"
                                        data-date="{{ $checkIn->format('m/d/Y') }}"
                                        data-booked_status="0">
                                    {{ $room->room_number }}
                                </button>
                                @php
                                    $selectedRoom++;
                                @endphp
                            @endif
                        @endforeach
                    </div>
                </td>
            </tr>
            @php
                $checkIn = $checkIn->copy()->addDay();
            @endphp
        @endwhile

        @php
            $selectedRooms = getSelectedRooms($bookedRooms, $numberOfRooms);
        @endphp
    </tbody>
</table>

<style>
    .removeItem {
        height: 23px;
        width: 30px;
        line-height: 0.5;
        margin-right: 5px;
        padding-right: 22px;
    }
</style>

<script>
    (function($) {
        'use strict';
        let selectedRooms = @json($selectedRooms);
        let totalRoom = @json(count($rooms));
        let numberOfRooms = Number({{ $numberOfRooms }});
        let curText = "{{ __($general->cur_text) }}";
        let selected = 0;
        let firstSelected;
        let lastSelected;
        let prevSibling;
        let nextSibiling;
        let dateColumn;
        let availableRooms;
        let needChanged = false;
        let alertBox = $(document).find('.room-assign-alert');
        let liDiv = $(document).find('.orderList');
        let bookBtn = $(document).find('.btn-book');
        let approveRequestRoute = @json(request()->routeIs('receptionist.booking.request.approve') || request()->routeIs('admin.booking.request.approve'));

        $.each(selectedRooms, function(index, element) {
            let singleRoom = $(`[room=room-${element}]`).not(`:disabled`);
            if (singleRoom.hasClass('available')) {
                singleRoom.removeClass('btn--primary').addClass('btn--success selected');
                singleRoom.data('booked_status', 1);
            }
        });

        let roomColumns = $('.room-column');

        $.each(roomColumns, function(i, element) {

            selected = $(element).find('.selected').length;

            if (selected < numberOfRooms) {
                availableRooms = $(element).find('.available.selected');

                firstSelected = availableRooms.first();
                lastSelected = availableRooms.last();

                prevSibling = $(firstSelected).prev().not(':disabled');
                nextSibiling = $(lastSelected).next().not(':disabled');
                dateColumn = $(element).siblings("td").first();
                if (prevSibling.length) {
                    prevSibling.addClass('btn--success selected');
                    prevSibling.data('booked_status', 1);
                    dateColumn.addClass('text-warning');
                    needChanged = true;
                } else if (nextSibiling.length) {
                    nextSibiling.addClass('btn--success selected');
                    nextSibiling.data('booked_status', 1);
                    dateColumn.addClass('text-warning');
                    needChanged = true;
                } else {
                    let closestRoom = $(element).find('.available:not(.selected)').first();
                    closestRoom.addClass('btn--success selected');
                    closestRoom.data('booked_status', 1);
                    dateColumn.addClass('text-warning');
                    if (closestRoom.length) {
                        needChanged = true;
                    }
                }
            }

        });

        enableDisableBooking();

        let allRooms = $('.room-table tr').first().find('.room-btn');
        let roomInfo = $('.room-btn.available').first().data('room');
        let unitFare = roomInfo.room_type.fare;

        @if(@$requestUnitFare)
            unitFare = "{{ $requestUnitFare }}";
        @endif

        let roomNumber, length, checkInDate, checkOutDate, fare, amount, totalAmount, totalFare;

        firstSelected, lastSelected = null;

        let listedRoomItem = $(document).find(`.order-list-type-${roomInfo.room_type_id}`);
        if (listedRoomItem.length) {
            listedRoomItem.remove();
            setTotalAmount();
        }

        $.each(allRooms, function(index, room) {
            roomNumber = $(room).attr('room');

            room = $(`[room=${roomNumber}].selected`);
            if (room.length) {
                appendItemFirstTime(room);
                setTotalAmount();
            }
        });

        function appendItemFirstTime(room) {
            firstSelected = room.first();
            roomInfo = firstSelected.data('room');
            fare = unitFare * room.length;
            let html = '';
            $.each(room, function(index, singleRoom) {
                let roomInfo = $(singleRoom).data('room');
                let date = $(singleRoom).data('date');
                html += `<input type="hidden" value="${roomInfo.id}-${date}" name="room[]" ${approveRequestRoute ? 'form="confirmation-form"' : ''}>`;
            });

            let orderItemDiv = $(document).find('.orderItem');

            let appendHtml = '';
            appendHtml += `<li class="orderListItem order-list-type-${roomInfo.room_type_id}
                            list-group-item d-flex justify-content-between align-items-center
                            room-${roomInfo.room_number}" data-room_number="${roomInfo.room_number}">`;

            appendHtml += html;

            appendHtml += `<span>
                                <span class="removeItem btn btn-sm btn-danger"><i class="las la-times"></i></span>
                                ${roomInfo.room_number}
                            </span>
                            <span class="totalDays">${room.length}</span>
                            <span class="unitFare">${parseFloat(unitFare).toFixed()} ${curText}</span>
                            <span class="subTotal" sub_total="${parseFloat(fare).toFixed()}">${parseFloat(fare).toFixed()} ${curText}</span>
                        </li>`;

            orderItemDiv.append(appendHtml);

            if (liDiv.hasClass('d-none')) {
                liDiv.removeClass('d-none');
            }
        }


       $('.room-btn').on('click', function() {
    let bookedStatus = $(this).data('booked_status');
    let room_number = $(this).data('room_number');
    roomInfo = $(this).data('room');
    let date = $(this).data('date');

    if (!bookedStatus) {
        // Code for selecting a room
        appendItem(date, roomInfo.room_type_id, roomInfo.id, roomInfo.room_number, unitFare, unitFare);
    } else {
        // Code for deselecting a room
        let li = $(document).find(`.orderListItem.room-${room_number}`);
        li.find(`[name="room[]"][value^="${roomInfo.id}-"]`).remove();
        li.find('.totalDays').text(li.find('[name="room[]"]').length);
        let totalFare = 0;
        li.find('.subTotal').each(function() {
            totalFare += parseFloat($(this).attr('sub_total'));
        });
        li.find('.subTotal').attr('sub_total', totalFare).text(`${totalFare.toFixed()} ${curText}`);
        if (li.find('[name="room[]"]').length === 0) {
            li.remove();
        }
    }

    // Reflect the selection in other td buttons
    let correspondingButtons = $(`.room-btn[room="room-${room_number}"]`);
    correspondingButtons.each(function() {
        if (!bookedStatus) {
            $(this).removeClass('btn--primary').addClass('btn--success selected');
            $(this).data('booked_status', 1);
        } else {
            $(this).removeClass('btn--success selected').addClass('btn--primary');
            $(this).data('booked_status', 0);
        }
    });

    setTotalAmount();
    enableDisableBooking();
});

        $(document).on('click', '.removeItem', function() {
            let li = $(this).parents('li');
            roomNumber = li.data('room_number');
            let allSelectedRooms = $(`[room=room-${roomNumber}].selected`);
            allSelectedRooms.removeClass('btn--success selected').addClass('btn--primary').data('booked_status', 0);
            li.remove();
            setTotalAmount();
            if (!$(document).find('.orderListItem').length) {
                liDiv.addClass('d-none');
            }
            enableDisableBooking();
        });

    function formatDate(date) {
        let day = String(date.getDate()).padStart(2, '0');
        let month = String(date.getMonth() + 1).padStart(2, '0');
        let year = date.getFullYear();
    
        // Format the date as MM/DD/YYYY
        return `${month}/${day}/${year}`;
    }

     function appendItem(date, roomTypeId, roomId, roomNumber, unitFare, fare) {
            let apendedRoom = $(document).find(`.room-${roomNumber}`);
            let orderItemDiv = $(document).find('.orderItem');
        
            let startDate = $('.datepicker-here').data('datepicker').selectedDates[0];
            let endDate = $('.datepicker-here').data('datepicker').selectedDates[1];
        
            if (startDate && endDate) {
                let dayCount = calculateDayCount(startDate, endDate);
        
                if (!apendedRoom.length) {
                    var sub_total = parseFloat(fare)*(dayCount);
                    var html = "";
                    
                    if (startDate && endDate) {
                        let currentDate = new Date(startDate);
                        let endDateObj = new Date(endDate);
                
                        while (currentDate <= endDateObj) {
                            let formattedDate = formatDate(currentDate);
                            currentDate.setDate(currentDate.getDate() + 1);
                            html += `<input type="hidden" value="${roomId}-${formattedDate}" name="room[]" ${approveRequestRoute ? 'form="confirmation-form"' : ''}>`;
                        }
                    }
                    
                    
                    orderItemDiv.append(`
                        <li class="orderListItem order-list-type-${roomTypeId} list-group-item d-flex justify-content-between align-items-center room-${roomNumber}" data-room_number="${roomNumber}">
                             ${html}
                            <span>
                                <span class="removeItem btn btn-sm btn-danger"><i class="las la-times"></i></span>
                                ${roomNumber}
                            </span>
                            <span class="totalDays">${dayCount}</span>
                            <span class="unitFare">${parseFloat(unitFare).toFixed()} ${curText}</span>
                            <span class="subTotal" sub_total="${parseFloat(sub_total).toFixed()}">${parseFloat(sub_total).toFixed()} ${curText}</span>
                        </li>
                    `);
        
                    if (liDiv.hasClass('d-none')) {
                        liDiv.removeClass('d-none');
                    }
                } else {
                    let room = $(document).find(`[room=room-${roomNumber}].selected`);
                    apendedRoom.append(`<input type="hidden" value="${roomId}-${date}" name="room[]" ${approveRequestRoute ? 'form="confirmation-form"' : ''}>`);
                    let subTotal = parseFloat(unitFare) * parseFloat(room.length);
                    apendedRoom.find('.subTotal').attr('sub_total', subTotal).text(`${subTotal} ${curText}`);
                    apendedRoom.find('.totalDays').text(dayCount);
                }
        
                setTotalAmount();
            }
        }
        
        function calculateDayCount(startDate, endDate) {
            // Calculate the difference in days between two dates
            const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
            const diffDays = Math.round(Math.abs((endDate - startDate) / oneDay)) + 1;
        
            return diffDays;
        }


        function diffInDays(checkInDate, checkOutDate) {
            const date1 = new Date(checkInDate);
            const date2 = new Date(checkOutDate);
            const diffTime = Math.abs(date2 - date1);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            return diffDays;
        }

        function setTotalAmount() {
            amount = 0;
            let subtotal = $(document).find('.subTotal');
            $.each(subtotal, function(index, element) {
                amount += parseFloat($(element).attr('sub_total'));
            });

            $(document).find('.totalFare').text(amount + ' ' + curText);
            $('[name=total_amount]').val(amount);
        }

        function enableDisableBooking() {
            let disabledStatus = false;
            let limitCross = false;
            let lowFromLimit = false;
            $.each(roomColumns, function(index, element) {
                if ($(element).find('.selected').length < numberOfRooms || $(element).find('.selected').length > numberOfRooms) {
                    if($(element).find('.selected').length < numberOfRooms){
                        lowFromLimit = true;
                    }
                    if($(element).find('.selected').length > numberOfRooms){
                        limitCross = true;
                    }

                    $(element).siblings("td").first().removeClass('text-warning').addClass('text-danger');

                    bookBtn.attr("disabled", true);
                    disabledStatus = true;
                } else {
                    if (needChanged) {
                        $(element).siblings("td").first().removeClass('text-danger').addClass('text-warning');
                    } else {
                        $(element).siblings("td").first().removeClass('text-danger').removeClass('text-warning');
                    }
                }
            });

            if (!disabledStatus) {
                bookBtn.attr("disabled", false);
            }

            if (needChanged) {
                if(!alertBox.hasClass('alert-warning')){
                    alertBox.removeClass('alert-info').removeClass('alert-danger').addClass('alert-warning');
                }
                alertBox.html('@lang("Date wise selected room don\'t matchted.")');
            }

            if (limitCross) {
                if(!alertBox.hasClass('alert-danger')){
                    alertBox.removeClass('alert-info').addClass('alert-danger');
                }
                alertBox.html('@lang("Selected room can\'t be greater than ")' + numberOfRooms + " in each date.");
            }
            if (lowFromLimit) {
                if(!alertBox.hasClass('alert-danger')){
                    alertBox.removeClass('alert-info').addClass('alert-danger');
                }
                alertBox.removeClass('alert-info').addClass('alert-danger');
                alertBox.html('@lang("Selected room can\'t be less than ")' + numberOfRooms + " in each date.");
            }

            if (!needChanged && !limitCross && !lowFromLimit) {
                if(!alertBox.hasClass('alert-info')){
                    alertBox.removeClass('alert-danger').addClass('alert-info');
                }
                alertBox.html("@lang('Every room can be select or deselect by a single click without booked room. Make sure that selected rooms in each date is equal to the number of rooms you have searched.')");
            }
        }
    })(jQuery);
</script>
