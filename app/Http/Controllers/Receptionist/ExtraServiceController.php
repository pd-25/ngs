<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ExtraService;
use App\Models\UsedExtraService;
use App\Models\Booking;
use App\Models\BookedRoom;
use App\Models\BookingActionHistory;

class ExtraServiceController extends Controller
{
    public function list()
    {
        $pageTitle = 'Add Extra Service';
        $extraServices = ExtraService::active()->get();
        $services = UsedExtraService::where('receptionist_id', auth()->guard('receptionist')->id())->with('extraService', 'room')->paginate(getPaginate());
        $delete = true;
        return view('receptionist.booking.service_details', compact('pageTitle', 'services', 'delete'));
    }

    public function addNew()
    {
        $pageTitle = 'Add Extra Service';
        $extraServices = ExtraService::active()->get();
        return view('receptionist.extra_service.add', compact('pageTitle', 'extraServices'));
    }

    public function addService(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_number' => 'required|integer',
            'service_date' => 'required|date_format:Y-m-d|before:tomorrow',
            'services'    => 'required|array',
            'services.*'  => 'required|exists:extra_services,id',
            'qty'         => 'required|array',
            'qty.*'       => 'integer|gt:0'
        ]);

        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $serviceRoom = BookedRoom::whereHas('room', function ($q) use ($request) {
            $q->where('room_number', $request->room_number);
        })->whereDate('booked_for', $request->service_date)->where('status', 1)->first();

        if (!$serviceRoom) {
            return response()->json(['error' => [$request->room_number . ' no. room isn\'t booked for ' . showDateTime($request->service_date, 'd M, Y')]]);
        }

        $booking = Booking::find($serviceRoom->booking_id);

        $totalAmount = 0;
        $data = [];
        foreach ($request->services as $key => $service) {
            $serviceDetails                     = ExtraService::find($service);
            $data[$key]['booking_id']           = $booking->id;
            $data[$key]['extra_service_id']     = $service;
            $data[$key]['room_id']              = $serviceRoom->room_id;
            $data[$key]['booked_room_id']       = $serviceRoom->id;
            $data[$key]['qty']                  = $request->qty[$key];
            $data[$key]['unit_price']           = $serviceDetails->cost;
            $data[$key]['total_amount']         = $request->qty[$key] * $serviceDetails->cost;
            $data[$key]['service_date']         = $request->service_date;
            $data[$key]['receptionist_id']      = auth()->guard('receptionist')->id();
            $totalAmount += $request->qty[$key] * $serviceDetails->cost;
            $data[$key]['created_at']           = now();
            $data[$key]['updated_at']           = now();
        }

        $usedExtraService  = new UsedExtraService();
        $usedExtraService->insert($data);

        $booking->total_amount += $totalAmount;
        $booking->save();

        $action = new BookingActionHistory();
        $action->booking_id = $booking->id;
        $action->remark = 'added_extra_service';
        $action->receptionist_id = auth()->guard('receptionist')->id();
        $action->save();

        return response()->json(['success' => 'Extra service added successfully']);
    }

    public function delete($id)
    {
        $service = UsedExtraService::where('receptionist_id', auth()->guard('receptionist')->id())->findOrFail($id);
        $action = new BookingActionHistory();
        $action->booking_id = $service->booking_id;
        $action->remark = 'deleted_extra_service';
        $action->receptionist_id = auth()->guard('receptionist')->id();
        $action->save();

        $service->delete();

        $notify[] = ['success', 'Extra service deleted successfully'];
        return back()->withNotify($notify);
    }
}
