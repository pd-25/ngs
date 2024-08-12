<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BedType;

class BedTypeController extends Controller
{
    public function index()
    {
        $pageTitle   = "Bed List";
        $bedTypeList = BedType::latest()->paginate(getPaginate());
        return view('admin.hotel.bed_type', compact('pageTitle', 'bedTypeList'));
    }

    public function save(Request $request, $id = 0)
    {
        $request->validate([
            'name'        => 'required|string|unique:bed_types,name,' . $id
        ]);

        if ($id) {
            $bedType      = BedType::findOrFail($id);
            $notification = 'Bed type updated successfully';
        } else {
            $bedType      = new BedType();
            $notification = 'Bed type added successfully';
        }

        $bedType->name = $request->name;
        $bedType->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function delete($id)
    {
        BedType::findOrFail($id)->delete();
        $notify[] = ['success', 'Bed type deleted successfully'];
        return back()->withNotify($notify);
    }
}
