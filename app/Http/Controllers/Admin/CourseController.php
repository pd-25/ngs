<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Rules\FileTypeValidate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class CourseController extends Controller
{
    public function index()
    {
        $pageTitle     = 'All Course';
        $data = Course::all();
        return view('admin.course.add_course', compact('pageTitle', 'data'));

    }

    public function store(Request $request, $id=null)
    {
        $validation_rule = [
            'course_name'     => 'required',
            'course_type'     => 'required',
            'short_decsription'     => 'required',
            'full_description'     => 'required',
            'price'     => 'required',
            'image'     => 'required',
         
        ];
// ($request->file('image')->move(public_path('/'),'eee.jpg'));

        if($id ==0){
            $gallery = new Course();
            $validation_rule['image']  = ['required', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])];
            $notify[] = ['success', 'Course Created Successfully'];
        }else{
            $gallery = Course::findOrFail($id);
            $validation_rule['image']  = ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])];
            $notify[] = ['success', 'Course Updated Successfully'];
        }
        $request->validate($validation_rule,[
            'course_name'     => 'required',
            'course_type'     => 'required',
            'short_decsription'     => 'required',
            'full_description'     => 'required',
            'price'     => 'required',
            'image'     => 'required',

        ]);

        if ($request->hasFile('image')) {

            try {
                //$request->merge(['image' => $this->store_image($request->key, $request->image, $gallery->image)]);

                
                    $image = $request->file('image');
                    $path = $image->getRealPath(); 
                    $document =  time().$image->getClientOriginalName();
                    $destinationPath = env('IMAGE_UPLOAD_PATH');
                    $image->move($destinationPath, $document);  
                   //$request->file('image')->move(public_path('/'), $document);
                    $gallery->image             = $document;
                    
            

            } catch (\Exception $exp) {
                $notify[] = ['error', 'Could not upload the Image.'];
                return back()->withNotify($notify);
            }
        }else{
            $request->merge(['image'=>$gallery->image]);
        }

        $gallery->course_name             = $request->course_name;
        $gallery->course_type = $request->course_type;
        $gallery->short_decsription = $request->short_decsription;
        $gallery->full_description = $request->full_description;
        $gallery->price = $request->price;        
        $gallery->save();

        return redirect()->back()->withNotify($notify);
    }

    // protected function validateRecipient($request, $id)
    // {
    //     $rules = [
    //         'course_name'     => 'required',
    //         'course_type'     => 'required',
    //         'short_decsription'     => 'required',
    //         'full_description'     => 'required',
    //         'price'     => 'required',
    //         'course_image'     => 'required',

    //     ];

    //     $request->validate($rules);
    // }


    public function remove($id)
    {
        $event = Course::findOrFail($id);
        
        
        $event->delete();
        $notify[] = ['success', 'Content removed successfully'];
        return back()->withNotify($notify);
    }
}
