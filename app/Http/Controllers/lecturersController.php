<?php

namespace App\Http\Controllers;

use App\Models\lecturers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class lecturersController extends Controller
{
    //insert
    public function lecturers_insert(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'language' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'study_mode' => 'nullable|string|max:255',
            'numberOf_years_teaching' => 'nullable|integer',
            'grade_level' => 'nullable|string|max:255',
            'Subject' => 'nullable|string|max:255',
            'Certifications' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'currency' => 'nullable|string|max:10',
            'image' => 'nullable|image|max:2048', // Adjust file size limit as necessary
        ]);
    
        $create = new lecturers();
        $create->user_id = Auth::user()->id;
        $create->name = $request->name;
        $create->phone = $request->phone;
        $create->email = $request->email;
        $create->language = $request->language;
        $create->duration = $request->duration;
        $create->price = $request->price;
        $create->study_mode = $request->study_mode;
        $create->numberOf_years_teaching = $request->numberOf_years_teaching;
        $create->grade_level = $request->grade_level;
        $create->Subject = $request->Subject;
        $create->Certifications = $request->Certifications;
        $create->country = $request->country;
        $create->state = $request->state;
        $create->city = $request->city;
        $create->description = $request->description;
        $create->currency = $request->currency;
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = 'assets/' . $filename; // Define the path where the image will be stored
            $image->move(public_path('assets'), $filename); // Move the image to the specified path
    
            $baseUrl = url('/');
            $imageUrl = $baseUrl . '/' . $path;
            $create->image = $imageUrl;
        }
    
        $create->save();
    
        return response([
            'data' => $create,
        ]);
    }
    
    //update by user 
    public function lecturers_update(Request $request)
    {
        $user = Auth::user()->id;

        $create = lecturers::where('user_id', $user)->first();

        $create->user_id = $user;
        $image = $request->image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
        if ($image) {
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = 'assets/' . $filename; // Define the path where the image will be stored
            $request->image->move(public_path('assets'), $filename); // Move the image to the specified path

            $baseUrl = url('/'); // Get the base URL of the application
            $imageUrl = $baseUrl . '/' . $path; // Create the full URL of the image
            $create->image = $imageUrl; // Store the full URL in the database
        }
        $create->name = $request->name;
        $create->phone = $request->phone;
        $create->email = $request->email;
        $create->language = $request->language;
        $create->duration = $request->duration;
        $create->price = $request->price;
        $create->study_mode = $request->study_mode;
        $create->numberOf_years_teaching = $request->numberOf_years_teaching;
        $create->grade_level = $request->grade_level;
        $create->Subject = $request->Subject;
        $create->Certifications = $request->Certifications;
     
        $create->description = $request->description;



        $create->currency = $request->currency;

        $create->save();
        return response([
            'data' => $create

        ]);
    }

    public function lecturers_admin_update(Request $request,$id)
    {

        $create = lecturers::find($id);
        $image = $request->image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
        if ($image) {
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = 'assets/' . $filename; // Define the path where the image will be stored
            $request->image->move(public_path('assets'), $filename); // Move the image to the specified path

            $baseUrl = url('/'); // Get the base URL of the application
            $imageUrl = $baseUrl . '/' . $path; // Create the full URL of the image
            $create->image = $imageUrl; // Store the full URL in the database
        }
        $create->name = $request->name;
        $create->phone = $request->phone;
        $create->email = $request->email;
        $create->language = $request->language;
        $create->duration = $request->duration;
        $create->price = $request->price;
        $create->study_mode = $request->study_mode;
        $create->numberOf_years_teaching = $request->numberOf_years_teaching;
        $create->grade_level = $request->grade_level;
        $create->Subject = $request->Subject;
        $create->Certifications = $request->Certifications;
     
        $create->description = $request->description;



        $create->currency = $request->currency;

        $create->save();
        return response([
            'data' => $create

        ]);
    }
    public function lecturers_delete ($id){
        $delete = lecturers::find($id);
        $delete->delete();
         return response([
         'message' => 'Deleted Successfully'
         ]);
         }
    //primary_get
    public function primary_get(Request $request)
    {
        // Query services by type
        $query = lecturers::where("grade_level", "=", "primary school");

        // Retrieve individual search queries from the request
        $countrySearch = $request->input('countrySearch');
        $citySearch = $request->input('citySearch');
        $stateSearch = $request->input('stateSearch');
        $subjectSearch = $request->input('subjectSearch');
        $study_modeSearch = $request->input('study_modeSearch');
        $languageSearch = $request->input('languageSearch');
        $nameSearch = $request->input('nameSearch');

        // Apply filters based on the individual search queries\
        if ($nameSearch) {
            $query->where('name', 'LIKE', '%' . $nameSearch . '%');
        }
        if ($countrySearch) {
            $query->where('country', 'LIKE', '%' . $countrySearch . '%');
        }
        if ($citySearch) {
            $query->where('city', 'LIKE', '%' . $citySearch . '%');
        }
        if ($stateSearch) {
            $query->where('state', 'LIKE', '%' . $stateSearch . '%');
        }
        if ($subjectSearch) {
            $query->where( 'Subject', 'LIKE','%' . $subjectSearch . '%'
            );
        }
        if ($study_modeSearch) {
            $query->where('study_mode','LIKE','%' . $study_modeSearch . '%'
            );
        }
          if ($languageSearch) {
            $query->where('language','LIKE','%' . $languageSearch . '%'
            );
        }
        // Get the page number from the request
        $page = $request->input('page', 1);

        // Paginate the results based on the search query
        $data = $query->paginate(10, ['*'], 'page', $page);

        // Return response with paginated data and total pages
        return response([
            'data' => $data,
            'total_pages' => $data->lastPage(), // Total number of pages
        ]);
    }
     //primary_get
    public function Middle_get(Request $request)
    {
        // Query services by type
        $query = lecturers::where("grade_level", "=", "middle school");

        // Retrieve individual search queries from the request
        $countrySearch = $request->input('countrySearch');
        $citySearch = $request->input('citySearch');
        $stateSearch = $request->input('stateSearch');
        $subjectSearch = $request->input('subjectSearch');
        $study_modeSearch = $request->input('study_modeSearch');
        $languageSearch = $request->input('languageSearch');
        $nameSearch = $request->input('nameSearch');


        if ($nameSearch) {
            $query->where('name', 'LIKE', '%' . $nameSearch . '%');
        }
        // Apply filters based on the individual search queries
        if ($countrySearch) {
            $query->where('country', 'LIKE', '%' . $countrySearch . '%');
        }
        if ($citySearch) {
            $query->where('city', 'LIKE', '%' . $citySearch . '%');
        }
        if ($stateSearch) {
            $query->where('state', 'LIKE', '%' . $stateSearch . '%');
        }
        if ($subjectSearch) {
            $query->where( 'Subject', 'LIKE','%' . $subjectSearch . '%'
            );
        }
        if ($study_modeSearch) {
            $query->where('study_mode','LIKE','%' . $study_modeSearch . '%'
            );
        }
          if ($languageSearch) {
            $query->where('language','LIKE','%' . $languageSearch . '%'
            );
        }
        // Get the page number from the request
        $page = $request->input('page', 1);

        // Paginate the results based on the search query
        $data = $query->paginate(10, ['*'], 'page', $page);

        // Return response with paginated data and total pages
        return response([
            'data' => $data,
            'total_pages' => $data->lastPage(), // Total number of pages
        ]);
    }
    public function Middle_searchData(){
        $data =  lecturers::where("grade_level", "=", "middle school")->get();
        return response([
            "data" => $data

        ]);
    }


    public function High_searchData(){
        $data =  lecturers::where("grade_level", "=", "high school")->get();
        return response([
            "data" => $data,

        ]);
    }

    public function Primary_searchData(){
        $data =   lecturers::where("grade_level", "=", "primary school")->get();
        return response([
            "data" => $data,

        ]);
    }

      //primary_get
    public function High_get(Request $request)
    {
        // Query services by type
        $query = lecturers::where("grade_level", "=", "high school");

        // Retrieve individual search queries from the request
        $countrySearch = $request->input('countrySearch');
        $citySearch = $request->input('citySearch');
        $stateSearch = $request->input('stateSearch');
        $subjectSearch = $request->input('subjectSearch');
        $study_modeSearch = $request->input('study_modeSearch');
        $languageSearch = $request->input('languageSearch');

$nameSearch = $request->input('nameSearch');

        // Apply filters based on the individual search queries\
        if ($nameSearch) {
            $query->where('name', 'LIKE', '%' . $nameSearch . '%');
        }        if ($countrySearch) {
            $query->where('country', 'LIKE', '%' . $countrySearch . '%');
        }
        if ($citySearch) {
            $query->where('city', 'LIKE', '%' . $citySearch . '%');
        }
        if ($stateSearch) {
            $query->where('state', 'LIKE', '%' . $stateSearch . '%');
        }
        if ($subjectSearch) {
            $query->where( 'Subject', 'LIKE','%' . $subjectSearch . '%'
            );
        }
        if ($study_modeSearch) {
            $query->where('study_mode','LIKE','%' . $study_modeSearch . '%'
            );
        }
          if ($languageSearch) {
            $query->where('language','LIKE','%' . $languageSearch . '%'
            );
        }
        // Get the page number from the request
        $page = $request->input('page', 1);

        // Paginate the results based on the search query
        $data = $query->paginate(10, ['*'], 'page', $page);

        // Return response with paginated data and total pages
        return response([
            'data' => $data,
            'total_pages' => $data->lastPage(), // Total number of pages
        ]);
    }

    public function lecturers_updateDetails()
    {
        $user = Auth::user()->id;
        $data = lecturers::where('user_id', $user)->first();

        // Return response with the retrieved data
        return response([
            "data" => $data,
        ]);
    }
  public function lecturers_details($id)
    {
    $data = lecturers::find($id);
        // Return response with paginated data and total pages
        return response([
            "data" => $data,

        ]);
    }

    
     public function lecturers_get()
    {
    $data = lecturers::all();
        // Return response with paginated data and total pages
        return response([
            "data" => $data,

        ]);
    }
}