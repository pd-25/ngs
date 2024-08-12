<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Rules\FileTypeValidate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class GalleryController extends Controller
{
    public function index()
    {
        $pageTitle     = 'All Gallery';
        $data = Gallery::all();
        return view('admin.gallery.add_gallery', compact('pageTitle','data'));

    }

    // public function save(Request $request, $id = 0)
    // {

    //     $this->validateRecipient($request,$id);

    //     if ($id) {
    //         $gallery         = Gallery::findOrFail($id);
    //         $notification         = 'Gallery updated successfully';
    //         $gallery->status = $request->status ? 1 : 0;
    //     } else {
    //         $gallery = new Gallery();
    //         $notification = 'Gallery added successfully';
    //     }

    //     $imagePath = $request->file('image')->save('assets', 'images');

    //     $gallery->gallery_title     = $request->gallery_title;
    //     $gallery->image = $imagePath;
    //     $gallery->category_id = $request->category_id;
    //     $gallery->save();

    //     $notify[] = ['success', $notification];
    //     return back()->withNotify($notify);
    // }

    public function store(Request $request, $id=null)
    {
        $validation_rule = [
            'gallery_title'     => 'required',
            'gallery_category'     => 'required',
         
        ];
// ($request->file('image')->move(public_path('/'),'eee.jpg'));

        if($id ==0){
            $gallery = new Gallery();
            $validation_rule['image']  = ['required', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])];
            $notify[] = ['success', 'Gallery Created Successfully'];
        }else{
            $gallery = Gallery::findOrFail($id);
            $validation_rule['image']  = ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])];
            $notify[] = ['success', 'Gallery Updated Successfully'];
        }
        $request->validate($validation_rule,[
            'gallery_title'     => 'required',
            'gallery_category'     => 'required',

        ]);

        if ($request->hasFile('image')) {

            try {
                //$request->merge(['image' => $this->store_image($request->key, $request->image, $gallery->image)]);

                
                    $image = $request->file('image');
                    $path = $image->getRealPath(); 
                    $document =  time().$image->getClientOriginalName();
                    $destinationPath = env('IMAGE_UPLOAD_PATH');
                    $image->move($destinationPath, $document);  
                   // $request->file('image')->move(public_path('/'), $document);
                    $gallery->image             = $document;
                    
            

            } catch (\Exception $exp) {
                $notify[] = ['error', 'Could not upload the Image.'];
                return back()->withNotify($notify);
            }
        }else{
            $request->merge(['image'=>$gallery->image]);
        }

        $gallery->gallery_title             = $request->gallery_title;
        $gallery->gallery_category             = $request->gallery_category;
        
        $gallery->save();

        return redirect()->back()->withNotify($notify);
    }
    // }
    // protected function validateRecipient($request,$id)
    // {


    //     $rules = [
    //         'gallery_title'     => 'required',
    //         'image' => 'required|image|max:2048', // Assuming you have an "image" input field in your form

    //     ];

    //     $request->validate($rules);
    // }


    public function remove($category_id)
    {
        $gallery = Gallery::findOrFail($category_id);
        
        
        $gallery->delete();
        $notify[] = ['success', 'Content removed successfully'];
        return back()->withNotify($notify);
    }
    


   
}
