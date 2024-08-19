<?php

namespace App\Http\Controllers;

use App\Models\jobData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class jobsController extends Controller
{
    public function job_insert(Request $request)
    {
        $create = new jobData();
        $user = Auth::user()->id;
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
        $create->job_title = $request->job_title;
        $create->state = $request->state;
        $create->funcrional_area = $request->funcrional_area;
        $create->industry = $request->industry;
        $create->skill = $request->skill;
        $create->country = $request->country;
        $create->state = $request->state;
        $create->city = $request->city;
        $create->company_name = $request->company_name;
        $create->description = $request->description;
        $create->job_type = $request->job_type;
        $create->Phone = $request->Phone;
        $create->Email = $request->Email;
        $create->Salary = $request->Salary;
        $create->Expire_Date = $request->Expire_Date;
        $create->Period = $request->Period;
        $create->currency = $request->currency;
        $create->gender = $request->gender;

        $create->Experience = $request->Experience ;

        $create->Certifications = $request->Certifications ;

        $create->save();
        return response([
            'data' => $create

        ]);
    }

    public function job_update(Request $request,$id)
    {
        $create = jobData::find($id);
        $image = $request->image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
        if ($image) {
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = 'assets/' . $filename; // Define the path where the image will be stored
            $request->image->move(public_path('assets'), $filename); // Move the image to the specified path

            $baseUrl = url('/'); // Get the base URL of the application
            $imageUrl = $baseUrl . '/' . $path; // Create the full URL of the image
            $create->image = $imageUrl; // Store the full URL in the database
        }
        $create->job_title = $request->job_title;
        // $create->state = $request->state;
        $create->funcrional_area = $request->funcrional_area;
        $create->industry = $request->industry;
        $create->skill = $request->skill;
        // $create->country = $request->country;
        // $create->state = $request->state;
        // $create->city = $request->city;
        $create->company_name = $request->company_name;
        $create->description = $request->description;
        $create->job_type = $request->job_type;
        $create->Phone = $request->Phone;
        $create->Email = $request->Email;
        $create->Salary = $request->Salary;
        $create->Expire_Date = $request->Expire_Date;
        $create->Period = $request->Period;
        $create->currency = $request->currency;
        $create->gender = $request->gender;

        $create->Experience = $request->Experience ;

        $create->Certifications = $request->Certifications ;


        $create->save();
        return response([
            'data' => $create

        ]);
    }

    public function jobs_getAll(Request $request)
    {
        // Query all freelancers
        $query = jobData::query();

        // Retrieve individual search queries from the request
        $nameSearch = $request->input('nameSearch');
        $titleSearch = $request->input('titleSearch');
        $functionalAreaSearch = $request->input('functionalAreaSearch');
        $industrySearch = $request->input('industrySearch');
        $skillSearch = $request->input('skillSearch');
        $countrySearch = $request->input('countrySearch');
        $stateSearch = $request->input('stateSearch');


        $citySearch = $request->input('citySearch');
        $companyNameSearch = $request->input('companyNameSearch');

        
        $ExperienceSearch = $request->input('ExperienceSearch');
        $CertificationsSearch = $request->input('CertificationsSearch');
        $typeSearch = $request->input('typeSearch');
        // Apply filters based on the individual search queries
      


        // if ($titleSearch) {
        //     $query->where('job_type', 'LIKE', '%' . $typeSearch . '%');
        // }
        if ($companyNameSearch) {
            $query->where('company_name', 'LIKE', '%' . $companyNameSearch . '%');
        }
        if ($titleSearch) {
            $query->where('job_title', 'LIKE', '%' . $titleSearch . '%');
        }
        if ($functionalAreaSearch) {
            $query->where('funcrional_area', 'LIKE', '%' . $functionalAreaSearch . '%');
        }
        if ($industrySearch) {
            $query->where('industry', 'LIKE', '%' . $industrySearch . '%');
        }
        if ($skillSearch) {
            $query->where('skill', 'LIKE', '%' . $skillSearch . '%');
        }
        if ($countrySearch) {
            $query->where('country', 'LIKE', '%' . $countrySearch . '%');
        }
        if ($stateSearch) {
            $query->where('state', 'LIKE', '%' . $stateSearch . '%');
        }
        if ($citySearch) {
            $query->where('city', 'LIKE', '%' . $citySearch . '%');
        }
   
        if ($ExperienceSearch) {
            $query->where('Experience', 'LIKE', '%' . $ExperienceSearch . '%');
        }

        if ($CertificationsSearch) {
            $query->where('Certifications', 'LIKE', '%' . $CertificationsSearch . '%');
        }
        if ($typeSearch) {
            $query->where('job_type', 'LIKE', '%' . $typeSearch . '%');
        }
        // Get the page number from the request
        $page = $request->input('page', 1);

        // Paginate the results based on the search query
        $data = $query->paginate(10, ['*'], 'page', $page);

        // Return response with paginated data and total pages
        return response([
            "data" => $data,
            'total_pages' => $data->lastPage(), // Total number of pages
        ]);
    }


    //get job  babe pagination bo search
    public function searchData(){
        $data = jobData::all();
        return response([
            "data" => $data,

        ]);
    }


    public function job_details($id)
    {
        $data = jobData::find($id);
        // Return response with paginated data and total pages
        return response([
            "data" => $data,

        ]);
    }
    //find by user id to update freelnacer
    public function freelancer_updateDetails($id)
    {
        // Retrieve the freelancer details where user_id matches the given id
        $data = jobData::where('user_id', $id)->first();

        // Return response with the retrieved data
        return response([
            "data" => $data,
        ]);
    }


    public function job_delete(Request $request,$id)
    {
        $delete = jobData::find($id);
        $delete->delete();

        return response([
            'messsage' =>   'deleted successfuly' 

        ]);
    }

}