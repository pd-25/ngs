<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expance;
use App\Rules\FileTypeValidate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class ExpanceController extends Controller
{
    public function index()
    {
        $pageTitle     = 'All Expense Categories';
        $data = Expance::all();
        return view('admin.expance.add_expance', compact('pageTitle', 'data'));

    }

    public function store(Request $request, $id=null)
    {
        $validation_rule = [
            'category_name'     => 'required',
           
         
        ];
// ($request->file('image')->move(public_path('/'),'eee.jpg'));

        if($id ==0){
            $expance = new Expance();
            $notify[] = ['success', 'Expense Category Created Successfully'];
        }else{
            $expance = Expance::findOrFail($id);
            $notify[] = ['success', 'Expense Category Updated Successfully'];
        }
        $request->validate($validation_rule,[
            'category_name'     => 'required',
            

        ]);


        $expance->category_name             = $request->category_name;
          
        $expance->save();

        return redirect()->back()->withNotify($notify);
    }

    protected function validateRecipient($request, $id)
    {
        $rules = [
            'category_name'     => 'required',
            

        ];

        $request->validate($rules);
    }


    public function remove($id)
    {
        $expance = Expance::findOrFail($id);
        
        
        $expance->delete();
        $notify[] = ['success', 'Content removed successfully'];
        return back()->withNotify($notify);
    }
    
    
}
