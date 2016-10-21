<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'company_name' => 'max:64',
            'address' => 'max:100',
            'phone' => 'max:32',
            'description' => 'max:1000'
        ]);
    }

    protected function update(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user = Auth::user();
        $user->name = $request->input('name');
        $user->company_name = $request->input('company_name');
        $user->address = $request->input('address');
        $user->phone = $request->input('phone');
        $user->description = $request->input('description');
        $user->is_professional = ($request->input('is_professional')) ? true : false;
        $user->save();

        Session::flash('message-success', 'Profile successfully updated.');

        return redirect()->action('PagesController@indexUser');
    }
}
