<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery_Category;
use App\Rules\FileTypeValidate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class GalleryCategoryController extends Controller
{
    public function index()
    {
        $pageTitle     = 'All Gallery';
        $data = Gallery_Category::all();
        return view('admin.gallery.add_gallery_category', compact('pageTitle','data'));

    }

    public function save(Request $request, $id = 0)
    {

        $this->validateRecipient($request,$id);

        if ($id) {
            $data         = Gallery_Category::findOrFail($id);
            $notification         = 'Gallery Category updated successfully';
        } else {
            $data = new Gallery_Category();
            $notification = 'Gallery Category added successfully';
        }


        $data->gallery_category     = $request->gallery_category;
        $data->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function remove($id)
    {
        $gallery = Gallery_Category::findOrFail($id);
        
        
        $gallery->delete();
        $notify[] = ['success', 'Content removed successfully'];
        return back()->withNotify($notify);
    }
    
    protected function validateRecipient($request, $id)
    {


        $rules = [
            'gallery_category'     => 'required',
                  ];

        $request->validate($rules);
    }

    
    }
   


   


   

