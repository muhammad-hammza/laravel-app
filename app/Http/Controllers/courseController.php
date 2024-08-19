<?php

namespace App\Http\Controllers;
use App\Http\Model\course;

use Illuminate\Http\Request;

class courseController extends Controller
{
    public function course_insert(){
        $create = new course();
        $create->user_id = Auth::user()->id;

        $create->Course_name = $request->Course_name;
        $create->Duration = $request->Duration;
        $create->Price = $request->Price;
        $create->study_mode = $request->study_mode;
        $create->country = $request->country;
        $create->state = $request->phone;
        $create->city = $request->phone;
        $create->course_provider = $request->course_provider;
        $create->email = $request->email;
        $create->phone = $request->phone;
        $create->save();

 return  response([

'data' => $create

 ]);
    }
}
