<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Rules\FileTypeValidate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class EventController extends Controller
{
    public function index()
    {
        $pageTitle     = 'All Event';
        $data = Event::all();
        return view('admin.event.add_event', compact('pageTitle','data'));

    }


    public function store(Request $request, $id=null)
    {
        $validation_rule = [
            'Event_name'     => 'required',
            'description'     => 'required',
            'address'     => 'required',
            'date'     => 'required',
            'time'     => 'required',

         
        ];
// ($request->file('image')->move(public_path('/'),'eee.jpg'));

        if($id ==0){
            $gallery = new Event();
            $validation_rule['image']  = ['required', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])];
            $notify[] = ['success', 'Event Created Successfully'];
        }else{
            $gallery = Event::findOrFail($id);
            $validation_rule['image']  = ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])];
            $notify[] = ['success', 'Event Updated Successfully'];
        }
        $request->validate($validation_rule,[
            'Event_name'     => 'required',
            'description'     => 'required',
            'address'     => 'required',
            'date'     => 'required',
            'time'     => 'required',

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

        $gallery->Event_name             = $request->Event_name;
        $gallery->description = $request->description;
        $gallery->address = $request->address;
        $gallery->date = $request->date;
        $gallery->time = $request->time;        
        $gallery->save();

        return redirect()->back()->withNotify($notify);
    }




    // public function save(Request $request, $id = 0)
    // {

    //     $this->validateRecipient($request, $id);

    //     if ($id) {
    //         $event         = Event::findOrFail($id);
    //         $notification         = 'Event updated successfully';
    //         $event->status = $request->status ? 1 : 0;
    //     } else {
    //         $event = new Event();
    //         $notification = 'Event added successfully';
    //     }

    //     $event->Event_name     = $request->Event_name;
    //     $event->description = $request->description;
    //     $event->image    = $request->image;
    //     $event->address   = $request->address;
    //     $event->date  = $request->date;
    //     $event->time  = $request->time;
    //     $event->save();

    //     $notify[] = ['success', $notification];
    //     return back()->withNotify($notify);
    // }


   

    public function remove($id)
    {
        $event = Event::findOrFail($id);
       
        $event->delete();
        $notify[] = ['success', 'Event removed successfully'];
        return back()->withNotify($notify);
    }

       
    }

    

    

   

