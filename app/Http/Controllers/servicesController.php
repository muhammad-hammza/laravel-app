<?php

namespace App\Http\Controllers;

use App\Models\jobs;
use App\Models\services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class servicesController extends Controller
{

    public function services_insert(Request $request)
    {
        $create = new services();
        
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
        $create->title = $request->title;
        $create->delevery = $request->delevery;
        $create->type = $request->type;
        $create->description = $request->description;
        $create->phone = $request->phone;
        $create->email = $request->email;
        $create->country = $request->country;
        $create->state = $request->state;
        $create->city = $request->city;
        $create->price = $request->price;
        $create->currency = $request->currency;

        $create->save();
        return response([
            'data' => $create

        ]);
    }
    public function services_update(Request $request)
    {
        $user = Auth::user()->id;

        $create = services::where('user_id', $user)->first();

        $image = $request->image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
        if ($image) {
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = 'assets/' . $filename; // Define the path where the image will be stored
            $request->image->move(public_path('assets'), $filename); // Move the image to the specified path

            $baseUrl = url('/'); // Get the base URL of the application
            $imageUrl = $baseUrl . '/' . $path; // Create the full URL of the image
            $create->image = $imageUrl; // Store the full URL in the database
        }
        $create->title = $request->title;
        $create->delevery = $request->delevery;
        $create->type = $request->type;
        $create->description = $request->description;
        $create->phone = $request->phone;
        $create->email = $request->email;
        $create->price = $request->price;
        $create->currency = $request->currency;

        $create->save();
        return response([
            'data' => $create

        ]);
    }

    //update admin

    public function services_admin_update(Request $request,$id)
    {

        $create = services::find($id);

        $image = $request->image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
        if ($image) {
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = 'assets/' . $filename; // Define the path where the image will be stored
            $request->image->move(public_path('assets'), $filename); // Move the image to the specified path

            $baseUrl = url('/'); // Get the base URL of the application
            $imageUrl = $baseUrl . '/' . $path; // Create the full URL of the image
            $create->image = $imageUrl; // Store the full URL in the database
        }
        $create->title = $request->title;
        $create->delevery = $request->delevery;
        $create->type = $request->type;
        $create->description = $request->description;
        $create->phone = $request->phone;
        $create->email = $request->email;
        $create->price = $request->price;
        $create->currency = $request->currency;

        $create->save();
        return response([
            'data' => $create

        ]);
    }

    public function services_delete ($id){
        $delete = services::find($id);
        $delete->delete();
         return response([
         'message' => 'Deleted Successfully'
         ]);
         }
    public function services_updateDetails()
    {
        $user = Auth::user()->id;

        // Retrieve the freelancer details where user_id matches the given id
        $data = services::where('user_id', $user)->first();

        // Return response with the retrieved data
        return response([
            "data" => $data,
        ]);
    }
    //get all type
    private function getServicesByType(Request $request, $type)
    {
        // Query services by type
        $query = Services::where("type", "=", $type);

        // Retrieve individual search queries from the request
        $countrySearch = $request->input('countrySearch');
        $citySearch = $request->input('citySearch');
        $stateSearch = $request->input('stateSearch');

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
    public function services_details($id)
    {
        $data = services::find($id);
        // Return response with paginated data and total pages
        return response([
            "data" => $data,

        ]);
    }
    public function services_getAll(Request $request)
    {
        // Retrieve search query from the request
        $typeSearch= $request->input('typeSearch');
        $countrySearch = $request->input('countrySearch');
        $stateSearch = $request->input('stateSearch');
        $citySearch = $request->input('citySearch');

        // Query all freelancers
        $query = services::query();

        // If search query is provided, filter the results
        if ($typeSearch) {
            $query->where('type', 'LIKE', '%' . $typeSearch . '%');
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
     public function get_search_services(){
$data = services::all();
return response ([
"data" => $data

]);


     }
    public function getCleaningServices(Request $request)
    {
        return $this->getServicesByType($request, "Cleaning the house");
    }
    public function ElectronicServices(Request $request)
    {
        return $this->getServicesByType($request, "Electronic Services");
    }
    public function Travel_Tourism(Request $request)
    {
        return $this->getServicesByType($request, "Travel and Tourism");
    }
    public function getVehicleMaintenanceServices(Request $request)
    {
        return $this->getServicesByType($request, "Vehicle Maintenance");
    }

    public function getElectricalRepairsServices(Request $request)
    {
        return $this->getServicesByType($request, "Electrical Repairs");
    }

    public function getFreightForwardingServices(Request $request)
    {
        return $this->getServicesByType($request, "Freight Forwarding");
    }

    public function getHomeApplianceRepairsServices(Request $request)
    {
        return $this->getServicesByType($request, "Home Appliance Repairs");
    }

    public function getConstructionOfHousesServices(Request $request)
    {
        return $this->getServicesByType($request, "construction of houses");
    }

    public function getGardenMaintenanceServices(Request $request)
    {
        return $this->getServicesByType($request, "Garden Maintenance");
    }

    public function getCarWashServices(Request $request)
    {
        return $this->getServicesByType($request, "Car Wash");
    }

    public function getCarpetServices(Request $request)
    {
        return $this->getServicesByType($request, "Carpet");
    }

    public function getPostServices(Request $request)
    {
        return $this->getServicesByType($request, "Post");
    }

    public function getHairdressingServices(Request $request)
    {
        return $this->getServicesByType($request, "Hairdressing");
    }

    public function getSkincareTreatmentsServices(Request $request)
    {
        return $this->getServicesByType($request, "Skincare Treatments");
    }

    public function getMakeupServices(Request $request)
    {
        return $this->getServicesByType($request, "Makeup");
    }

    public function getNailServices(Request $request)
    {
        return $this->getServicesByType($request, "Nail");
    }

    public function getVeterinaryServices(Request $request)
    {
        return $this->getServicesByType($request, "Veterinary");
    }

    public function getMortgageServices(Request $request)
    {
        return $this->getServicesByType($request, "Mortgige Services");
    }

    public function getLegalConsultationServices(Request $request)
    {
        return $this->getServicesByType($request, "Legal Consultation");
    }

    public function getPhotographyServices(Request $request)
    {
        return $this->getServicesByType($request, "Photography and Videography");
    }

    public function getTireReplacementServices(Request $request)
    {
        return $this->getServicesByType($request, "Tire Replacement");
    }

    public function getBatteryServices(Request $request)
    {
        return $this->getServicesByType($request,"battery");
    }

    public function getElectronicServices(Request $request)
    {
        return $this->getServicesByType($request, "Electronic Services");
    }



}