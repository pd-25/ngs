<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExtraService;
use Illuminate\Http\Request;

class ExtraServiceController extends Controller
{
    public function index()
    {
        $pageTitle = 'Extra Services';
        $extraServices = ExtraService::latest()->paginate(getPaginate());
        return view('admin.hotel.extra_services', compact('pageTitle', 'extraServices'));
    }

    public function save(Request $request, $id = 0)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:extra_services,name,' . $id,
            'cost' => 'required',
            'qty' => 'required|integer|gt:0'
        ]);

        if ($id) {
            $extraServices = ExtraService::findOrFail($id);
            $extraServices->status = $request->status ? 1 : 0;
            $notification = 'Service updated successfully';
        } else {
            $extraServices = new ExtraService();
            $notification = 'Service added successfully';
        }

        $extraServices->name = $request->name;
        $extraServices->cost = $request->cost;
        $extraServices->qty = $request->qty;

        $extraServices->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }
}
