<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complement;

class ComplementController extends Controller
{
    public function index()
    {
        $pageTitle   = 'All Complements';
        $complements = Complement::latest()->paginate(getPaginate());
        return view('admin.hotel.complement', compact('pageTitle', 'complements'));
    }

    public function save(Request $request, $id = 0)
    {
        $request->validate([
            'name'  => 'required|string|max:255|unique:complements,name,' . $id,
            'item'  => 'required',
            'item.*' => 'string|required'
        ]);

        if (!$id) {
            $complement = new Complement();
            $notification = 'Complement added successfully';
        } else {
            $complement = Complement::findOrFail($id);
            $notification = 'Complement updated successfully';
        }

        $complement->name = $request->name;
        $complement->item = $request->item;
        $complement->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }
}
