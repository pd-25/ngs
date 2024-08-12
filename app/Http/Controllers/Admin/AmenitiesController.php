<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use Illuminate\Http\Request;

class AmenitiesController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Amenities';
        $amenities = Amenity::latest()->Paginate(getPaginate());
        return view('admin.hotel.amenities', compact('pageTitle', 'amenities'));
    }

    public function save(Request $request, $id = 0)
    {
        $request->validate([
            'title'     => 'required|string|unique:amenities,title,' . $id,
            'icon'      => 'required'
        ]);

        if ($id) {
            $amenities          = Amenity::findOrFail($id);
            $notification       = 'Amenity updated successfully';
            $amenities->status  = $request->status ? 1 : 0;
        } else {
            $amenities          = new Amenity();
            $notification       = 'Amenity added successfully';
        }

        $amenities->title   = $request->title;
        $amenities->icon    = $request->icon;
        $amenities->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }
}
