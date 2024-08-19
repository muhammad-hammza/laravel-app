<?php

namespace App\Http\Controllers;

use App\Models\CV1;
use App\Models\cv10;
use App\Models\cv11;
use App\Models\cv12;
use App\Models\cv13;
use App\Models\cv14;
use App\Models\cv15;
use App\Models\cv16;
use App\Models\cv17;
use App\Models\cv18;
use App\Models\cv19;
use App\Models\CV2;
use App\Models\cv20;
use App\Models\cv3;
use App\Models\cv4;
use App\Models\cv5;
use App\Models\cv6;
use App\Models\cv7;
use App\Models\cv8;
use App\Models\cv9;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class cv_controller extends Controller
{

    //cv1 insert
    public function cv1_insert(Request $request)
    {
        $user = Auth::user();

        try {

            $create = new CV1();
            // Get the maximum ID value
            // $maxId = jobs::max('id');
            // // Increment the maximum ID value to create new unique IDs
            // $newId = $maxId + 1;

            // // Extract titles from the request
            // $titles = $request->input('titles');

            // // Initialize an empty array to store titles with IDs
            // $titlesWithIds = [];

            // Loop through each title
            // foreach ($titles as $title) {
            //     // Create the title array with the 'id' field
            //     $titleWithId = [
            //         "id" => $newId++, // Assign a new unique ID
            //         "title" => $title // Use the title from the request
            //     ];

            //     // Add the title with ID to the array
            //     $titlesWithIds[] = $titleWithId;
            // }

            // Assign the titles array to the 'title' attribute of the job
            // Create a new product instance
            $create->user_id = $user->id;
            $create->color = $request->color;
            $create->font = $request->font;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;

            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;


            // Save the job to the database
            $create->save();

            // Return a response indicating success
            return response([
                'message' => 'data inserted successfully',
                'data' => $create
            ]);
        } catch (\Exception $e) {
            // Return a response indicating an error occurred
            return response([
                'message' => 'Error inserting data: ' . $e->getMessage(),
            ], 500);
        }
    }
    //cv1 update
    public function cv1_update(Request $request, $id)
    {
        try {
            // Find the job by ID
            $create = CV1::find($id);

            // Get the new title from the request

            // Update the title field $create->color = $request->color;
            $create->font = $request->font;
            $create->color = $request->color;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;

            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;


            // Save the changes to the database
            $create->save();

            return response([
                'message' => 'Title updated successfully',
                'data' =>  $create
            ]);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    //cv1_get
    public function cv1_get()
    {
        $id = Auth::user()->id;

        $data = CV1::all();
        return response([

            "data" => $data

        ]);
    }

    //cv1_details
    public function cv1_details($id)
    {
        $user = Auth::user()->id;
        $data = CV1::find($id);

        return response([

            "data" => $data

        ]);
    }

    // cv2

    //cv2 insert
    public function cv2_insert(Request $request)
    {
        $user = Auth::user();

        try {

            $create = new CV2();
            // Get the maximum ID value
            // $maxId = jobs::max('id');
            // // Increment the maximum ID value to create new unique IDs
            // $newId = $maxId + 1;

            // // Extract titles from the request
            // $titles = $request->input('titles');

            // // Initialize an empty array to store titles with IDs
            // $titlesWithIds = [];

            // Loop through each title
            // foreach ($titles as $title) {
            //     // Create the title array with the 'id' field
            //     $titleWithId = [
            //         "id" => $newId++, // Assign a new unique ID
            //         "title" => $title // Use the title from the request
            //     ];

            //     // Add the title with ID to the array
            //     $titlesWithIds[] = $titleWithId;
            // }

            // Assign the titles array to the 'title' attribute of the job
            // Create a new product instance
            $create->user_id = $user->id;
            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->font = $request->font;
            $create->color = $request->color;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;


            // Save the job to the database
            $create->save();

            // Return a response indicating success
            return response([
                'message' => 'data inserted successfully',
                'data' => $create
            ]);
        } catch (\Exception $e) {
            // Return a response indicating an error occurred
            return response([
                'message' => 'Error inserting data: ' . $e->getMessage(),
            ], 500);
        }
    }
    //cv2 update
    public function cv2_update(Request $request, $id)
    {

        try {
            // Find the job by ID
            $create = CV2::find($id);

            // Get the new title from the request

            // Update the title field
            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->font = $request->font;
            $create->color = $request->color;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;


            // Save the changes to the database
            $create->save();

            return response([
                'message' => 'Title updated successfully',
                'data' =>  $create
            ]);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    //cv2_get
    //cv2_get
    public function cv2_get()
    {
        $user_id = Auth::user()->id;

        $data = CV2::where('user_id', $user_id)->get();
        return response([
            "data" => $data
        ]);
    }


    //cv2_details
    public function cv2_details($id)
    {

        $data = CV2::find($id);
        return response([

            "data" => $data

        ]);
    }

    //cv3
    public function cv3_insert(Request $request)
    {
        $user = Auth::user();

        try {
            $create = new cv3();
            $create->user_id = $user->id;
            $create->color = $request->color;
            $create->font = $request->font;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;
            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }

            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'data inserted successfully',
                'data' => $create
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => 'Error inserting data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function cv3_update(Request $request, $id)
    {
        try {
            $create = cv3::find($id);
            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->color = $request->color;
            $create->font = $request->font;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'Title updated successfully',
                'data' =>  $create
            ]);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function cv3_get()
    {
        $user_id = Auth::user()->id;
        $data = CV3::where('user_id', $user_id)->get();
        return response([
            "data" => $data
        ]);
    }


    public function cv3_details($id)
    {
        $data = CV3::find($id);
        return response([
            "data" => $data
        ]);
    }

    //cv4

    public function cv4_insert(Request $request)
    {
        $user = Auth::user();

        try {
            $create = new cv4();
            $create->user_id = $user->id;
            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->color = $request->color;
            $create->font = $request->font;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'data inserted successfully',
                'data' => $create
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => 'Error inserting data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function cv4_update(Request $request, $id)
    {
        try {
            $create = cv4::find($id);
            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->color = $request->color;
            $create->font = $request->font;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'Title updated successfully',
                'data' =>  $create
            ]);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function cv4_get()
    {
        $user_id = Auth::user()->id;
        $data = cv4::where('user_id', $user_id)->get();
        return response([
            "data" => $data
        ]);
    }
    public function cv4_details($id)
    {
        $data = cv4::find($id);
        return response([
            "data" => $data
        ]);
    }

    //cv5
    public function cv5_insert(Request $request)
    {
        $user = Auth::user();

        try {
            $create = new CV5();
            $create->user_id = $user->id;
            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
          $create->color = $request->color;
            $create->font = $request->font;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'data inserted successfully',
                'data' => $create
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => 'Error inserting data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function cv5_update(Request $request, $id)
    {
        try {
            $create = cv5::find($id);


            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
              $create->color = $request->color;
            $create->font = $request->font;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'Title updated successfully',
                'data' =>  $create
            ]);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function cv5_get()
    {
        $user_id = Auth::user()->id;
        $data = cv5::where('user_id', $user_id)->get();
        return response([
            "data" => $data
        ]);
    }

    public function cv5_details($id)
    {
        $data = cv5::find($id);
        return response([
            "data" => $data
        ]);
    }

    //cv6
    public function cv6_insert(Request $request)
    {
        $user = Auth::user();

        try {
            $create = new CV6();
            $create->user_id = $user->id;
            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->color = $request->color;
            $create->font = $request->font;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'data inserted successfully',
                'data' => $create
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => 'Error inserting data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function cv6_update(Request $request, $id)
    {
        try {
            $create = cv6::find($id);


            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
              $create->color = $request->color;
            $create->font = $request->font;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'Title updated successfully',
                'data' =>  $create
            ]);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function cv6_get()
    {
        $user_id = Auth::user()->id;
        $data = cv6::where('user_id', $user_id)->get();
        return response([
            "data" => $data
        ]);
    }

    public function cv6_details($id)
    {
        $data = cv6::find($id);
        return response([
            "data" => $data
        ]);
    }

    //cv7
    public function cv7_insert(Request $request)
    {
        $user = Auth::user();

        try {
            $create = new CV7();
            $create->user_id = $user->id;

            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->color = $request->color;
            $create->font = $request->font;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'data inserted successfully',
                'data' => $create
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => 'Error inserting data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function cv7_update(Request $request, $id)
    {
        try {
            $create = cv7::find($id);


            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->color = $request->color;
            $create->font = $request->font;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'Title updated successfully',
                'data' =>  $create
            ]);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function cv7_get()
    {
        $user_id = Auth::user()->id;
        $data = cv7::where('user_id', $user_id)->get();
        return response([
            "data" => $data
        ]);
    }

    public function cv7_details($id)
    {
        $data = cv7::find($id);
        return response([
            "data" => $data
        ]);
    }

    //cv8
    public function cv8_insert(Request $request)
    {
        $user = Auth::user();

        try {
            $create = new cv8();
            $create->user_id = $user->id;

            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->color = $request->color;
            $create->font = $request->font;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'data inserted successfully',
                'data' => $create
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => 'Error inserting data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function cv8_update(Request $request, $id)
    {
        try {
            $create = cv8::find($id);

            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->color = $request->color;
            $create->font = $request->font;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'Title updated successfully',
                'data' =>  $create
            ]);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function cv8_get()
    {
        $user_id = Auth::user()->id;
        $data = cv8::where('user_id', $user_id)->get();
        return response([
            "data" => $data
        ]);
    }


    public function cv8_details($id)
    {
        $data = cv8::find($id);
        return response([
            "data" => $data
        ]);
    }
    //cv9
    public function cv9_insert(Request $request)
    {
        $user = Auth::user();

        try {
            $create = new CV9();
            $create->user_id = $user->id;
            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->color = $request->color;
              $create->font = $request->font;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'data inserted successfully',
                'data' => $create
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => 'Error inserting data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function cv9_update(Request $request, $id)
    {
        try {
            $create = cv9::find($id);

            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->color = $request->color;
            $create->font = $request->font;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'Title updated successfully',
                'data' =>  $create
            ]);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function cv9_get()
    {
        $user_id = Auth::user()->id;
        $data = cv9::where('user_id', $user_id)->get();
        return response([
            "data" => $data
        ]);
    }

    public function cv9_details($id)
    {
        $data = cv9::find($id);
        return response([
            "data" => $data
        ]);
    }
    //cv10
    public function cv10_insert(Request $request)
    {
        $user = Auth::user();

        try {
            $create = new cv10();
            $create->user_id = $user->id;
            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->color = $request->color;
            $create->font = $request->font;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'data inserted successfully',
                'data' => $create
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => 'Error inserting data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function cv10_update(Request $request, $id)
    {
        try {
            $create = cv10::find($id);

            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
              $create->color = $request->color;
            $create->font = $request->font;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'Title updated successfully',
                'data' =>  $create
            ]);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function cv10_get()
    {
        $user_id = Auth::user()->id;
        $data = cv10::where('user_id', $user_id)->get();
        return response([
            "data" => $data
        ]);
    }
    public function cv10_details($id)
    {
        $data = cv10::find($id);
        return response([
            "data" => $data
        ]);
    }
    //cv11
    public function cv11_insert(Request $request)
    {
        $user = Auth::user();

        try {
            $create = new cv11();
            $create->user_id = $user->id;
            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->color = $request->color;
            $create->font = $request->font;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'data inserted successfully',
                'data' => $create
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => 'Error inserting data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function cv11_update(Request $request, $id)
    {
        try {
            $create = cv11::find($id);

            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->color = $request->color;
            $create->font = $request->font;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'Title updated successfully',
                'data' =>  $create
            ]);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function cv11_get()
    {
        $user_id = Auth::user()->id;
        $data = CV11::where('user_id', $user_id)->get();
        return response([
            "data" => $data
        ]);
    }
    public function cv11_details($id)
    {
        $data = cv11::find($id);
        return response([
            "data" => $data
        ]);
    }
    //cv12
    public function cv12_insert(Request $request)
    {
        $user = Auth::user();

        try {
            $create = new cv12();
            $create->user_id = $user->id;
            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->color = $request->color;
            $create->font = $request->font;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'data inserted successfully',
                'data' => $create
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => 'Error inserting data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function cv12_update(Request $request, $id)
    {
        try {
            $create = cv12::find($id);

            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->color = $request->color;
            $create->font = $request->font;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'Title updated successfully',
                'data' =>  $create
            ]);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function cv12_get()
    {
        $user_id = Auth::user()->id;
        $data = cv12::where('user_id', $user_id)->get();
        return response([
            "data" => $data
        ]);
    }


    public function cv12_details($id)
    {
        $data = cv12::find($id);
        return response([
            "data" => $data
        ]);
    }

    //cv13
    public function cv13_insert(Request $request)
    {
        $user = Auth::user();

        try {
            $create = new cv13();
            $create->user_id = $user->id;
            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->color = $request->color;
            $create->font = $request->font;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'data inserted successfully',
                'data' => $create
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => 'Error inserting data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function cv13_update(Request $request, $id)
    {
        try {
            $create = cv13::find($id);

            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->color = $request->color;
            $create->font = $request->font;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'Title updated successfully',
                'data' =>  $create
            ]);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function cv13_get()
    {
        $user_id = Auth::user()->id;
        $data = cv13::where('user_id', $user_id)->get();
        return response([
            "data" => $data
        ]);
    }

    public function cv13_details($id)
    {
        $data = cv13::find($id);
        return response([
            "data" => $data
        ]);
    }

    //cv14
    public function cv14_insert(Request $request)
    {
        $user = Auth::user();

        try {
            $create = new cv14();
            $create->user_id = $user->id;
            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->color = $request->color;
            $create->font = $request->font;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'data inserted successfully',
                'data' => $create
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => 'Error inserting data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function cv14_update(Request $request, $id)
    {
        try {
            $create = cv14::find($id);

            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->color = $request->color;
            $create->font = $request->font;
            $create->font_size = $request->font_size;
            $create->line_height = $request->line_height;
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'Title updated successfully',
                'data' =>  $create
            ]);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function cv14_get()
    {
        $user_id = Auth::user()->id;
        $data = cv14::where('user_id', $user_id)->get();
        return response([
            "data" => $data
        ]);
    }
    public function cv14_details($id)
    {
        $data = cv14::find($id);
        return response([
            "data" => $data
        ]);
    }
    //cv15
    public function cv15_insert(Request $request)
    {
        $user = Auth::user();

        try {
            $create = new cv15();
            $create->user_id = $user->id;
            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'data inserted successfully',
                'data' => $create
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => 'Error inserting data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function cv15_update(Request $request, $id)
    {
        try {
            $create = cv15::find($id);

            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'Title updated successfully',
                'data' =>  $create
            ]);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function cv15_get()
    {
        $user_id = Auth::user()->id;
        $data = cv15::where('user_id', $user_id)->get();
        return response([
            "data" => $data
        ]);
    }


    public function cv15_details($id)
    {
        $data = cv15::find($id);
        return response([
            "data" => $data
        ]);
    }
    public function cv16_insert(Request $request)
    {

        $user = Auth::user();

        try {
            $create = new CV16();
            $create->user_id = $user->id;
            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'data inserted successfully',
                'data' => $create
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => 'Error inserting data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function cv16_update(Request $request, $id)
    {
        try {
            $create = cv16::find($id);

            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'Title updated successfully',
                'data' =>  $create
            ]);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function cv16_get()
    {
        $user_id = Auth::user()->id;
        $data = CV16::where('user_id', $user_id)->get();
        return response([
            "data" => $data
        ]);
    }

    public function cv16_details($id)
    {
        $data = cv16::find($id);
        return response([
            "data" => $data
        ]);
    }
    //cv17
    public function cv17_insert(Request $request)
    {
        $user = Auth::user();

        try {
            $create = new cv17();
            $create->user_id = $user->id;
            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'data inserted successfully',
                'data' => $create
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => 'Error inserting data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function cv17_update(Request $request, $id)
    {
        try {
            $create = cv17::find($id);

            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'Title updated successfully',
                'data' =>  $create
            ]);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function cv17_get()
    {
        $user_id = Auth::user()->id;
        $data = cv17::where('user_id', $user_id)->get();
        return response([
            "data" => $data
        ]);
    }

    public function cv17_details($id)
    {
        $data = cv17::find($id);
        return response([
            "data" => $data
        ]);
    }
    //cv18
    public function cv18_insert(Request $request)
    {
        $user = Auth::user();

        try {
            $create = new cv18();
            $create->user_id = $user->id;
            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'data inserted successfully',
                'data' => $create
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => 'Error inserting data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function cv18_update(Request $request, $id)
    {
        try {
            $create = cv18::find($id);

            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'Title updated successfully',
                'data' =>  $create
            ]);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function cv18_get()
    {
        $user_id = Auth::user()->id;
        $data = cv18::where('user_id', $user_id)->get();
        return response([
            "data" => $data
        ]);
    }

    public function cv18_details($id)
    {
        $data = cv18::find($id);
        return response([
            "data" => $data
        ]);
    }
    //cv20
    public function cv19_insert(Request $request)
    {
        $user = Auth::user();

        try {
            $create = new cv19();
            $create->user_id = $user->id;
            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'data inserted successfully',
                'data' => $create
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => 'Error inserting data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function cv19_update(Request $request, $id)
    {
        try {
            $create = cv19::find($id);

            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'Title updated successfully',
                'data' =>  $create
            ]);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function cv19_get()
    {
        $user_id = Auth::user()->id;
        $data = cv19::where('user_id', $user_id)->get();
        return response([
            "data" => $data
        ]);
    }

    public function cv19_details($id)
    {
        $data = cv19::find($id);
        return response([
            "data" => $data
        ]);
    }
    //cv20
    public function cv20_insert(Request $request)
    {
        $user = Auth::user();

        try {
            $create = new cv20();
            $create->user_id = $user->id;
            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'data inserted successfully',
                'data' => $create
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => 'Error inserting data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function cv20_update(Request $request, $id)
    {
        try {
            $create = cv20::find($id);

            $image = $request->profile_image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
            if ($image) { // alera alee agar  eshe naw aw vara wabu yane tru bu awanay xwarawam bo bka
                $fiilename = time() . '.' . $image->getClientOriginalExtension(); //amay hamuy nagora bas aw image nawe aw varaya ka valukat tekrdwa
                $request->profile_image->move('assets', $fiilename); // ama $request->image am image a nawe colomn e tablekaya wa  aw $fiilename aw varay sarawaya
                $create->profile_image = $fiilename; // dwatr valueka yaksana baw varay sarawa esta alee $post->image =  wata colomnaka var e $fiilename e dache
            }
            $create->profile_name = $request->profile_name;
            $create->profile_description = $request->profile_description;
            $create->education_scholl = $request->education_scholl;
            $create->education_city = $request->education_city;
            $create->education_start_date = $request->education_start_date;
            $create->education_end_date = $request->education_end_date;
            $create->education_description = $request->education_description;
            $create->address = $request->address;
            $create->phone = $request->phone;
            $create->email = $request->email;
            $create->skills = $request->skills;
            $create->language = $request->language;
            $create->leveleOf_language = $request->leveleOf_language;
            $create->course_title = $request->course_title;
            $create->course_year = $request->course_year;
            $create->course_description = $request->course_description;
            $create->experiencetitle = $request->experiencetitle;
            $create->experience_year = $request->experience_year;
            $create->experience_description = $request->experience_description;

            $create->save();

            return response([
                'message' => 'Title updated successfully',
                'data' =>  $create
            ]);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function cv20_get()
    {
        $user_id = Auth::user()->id;
        $data = cv20::where('user_id', $user_id)->get();
        return response([
            "data" => $data
        ]);
    }


    public function cv20_details($id)
    {
        $data = cv20::find($id);
        return response([
            "data" => $data
        ]);
    }
}