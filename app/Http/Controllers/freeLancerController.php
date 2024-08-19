<?php

namespace App\Http\Controllers;

use App\Models\freeLancer;
use App\Models\reviews;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class freeLancerController extends Controller
{
    public function freelancer_insert(Request $request)
    {
        $create = new freeLancer();
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
        $create->name = $request->name;
        $create->email = $request->email;
        $create->phone = $request->phone;
        $create->country = $request->country;
        $create->state = $request->state;
        $create->city = $request->city;
        $create->experience = $request->experience;
        $create->description = $request->description;
        $create->functional_area = $request->functional_area;
        $create->skills = $request->skills;
        $create->per_hour_price = $request->per_hour_price;
        $create->currency = $request->currency;

        $create->save();
        return response([
            'data' => $create

        ]);
    }
    public function freelancer_update(Request $request,)
    {

        $id = Auth::user()->id;

        $update = freeLancer::where('user_id', $id)->first();

        $image = $request->image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
        if ($image) {
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = 'assets/' . $filename; // Define the path where the image will be stored
            $request->image->move(public_path('assets'), $filename); // Move the image to the specified path

            $baseUrl = url('/'); // Get the base URL of the application
            $imageUrl = $baseUrl . '/' . $path; // Create the full URL of the image
            $update->image = $imageUrl; // Store the full URL in the database
        }
        $update->name = $request->name;
        $update->email = $request->email;
        $update->phone = $request->phone;
        $update->experience = $request->experience;
        $update->description = $request->description;
        $update->functional_area = $request->functional_area;
        $update->skills = $request->skills;
        $update->per_hour_price = $request->per_hour_price;
        $update->currency = $request->currency;

        $update->save();
        return response([
            'data' => $update

        ]);
    }

    //admin update
    public function freelancer_admin_update(Request $request, $id)
    {


        $update = freeLancer::find($id);

        $image = $request->image; // yakam sht to value ka bka naw var ek lera  aw emage name inputakaya
        if ($image) {
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = 'assets/' . $filename; // Define the path where the image will be stored
            $request->image->move(public_path('assets'), $filename); // Move the image to the specified path

            $baseUrl = url('/'); // Get the base URL of the application
            $imageUrl = $baseUrl . '/' . $path; // Create the full URL of the image
            $update->image = $imageUrl; // Store the full URL in the database
        }
        $update->name = $request->name;
        $update->email = $request->email;
        $update->phone = $request->phone;
        $update->experience = $request->experience;
        $update->description = $request->description;
        $update->functional_area = $request->functional_area;
        $update->skills = $request->skills;
        $update->per_hour_price = $request->per_hour_price;
        $update->currency = $request->currency;

        $update->save();
        return response([
            'data' => $update

        ]);
    }
    public function freelancer_getAll(Request $request)
    {
        // Retrieve search query from the request

        try {
            $searchQuery = $request->input('search');
            $functionalArea_search = $request->input('functionalArea_search');
            $Experience_search  = $request->input('Experience_search');

            // Query all freelancers
            $query = FreeLancer::query();

            // If search query is provided, filter the results
            if ($searchQuery) {
                $query->where('name', 'LIKE', '%' . $searchQuery . '%');
            }
            if ($functionalArea_search) {
                $query->where('functional_area', 'LIKE', '%' . $functionalArea_search . '%');
            }
            if ($Experience_search) {
                $query->where('experience', 'LIKE', '%' . $Experience_search . '%');
            }

            // Eager load reviews
            $query->with('reviews');

            // Get the page number from the request
            $page = $request->input('page', 1);

            // Paginate the results based on the search query
            $data = $query->paginate(10, ['*'], 'page', $page);

            // Calculate average rating for each freelancer
            $data->getCollection()->transform(function ($freelancer) {
                $freelancer->average_rating = $freelancer->reviews->avg('rating');
                return $freelancer;
            });

            // Return response with paginated data and total pages
            return response([
                "data" => $data,
                'total_pages' => $data->lastPage(), // Total number of pages
            ]);
        } catch (ValidationException $e) {
            return response([
                "message" => 'error'
            ], 422);
        }
    }


    public function getSearch()
    {
        $data = freeLancer::all();
        return response([
            "data" => $data,

        ]);
    }

    public function freelancer_details($id)
    {
        try {
            // Find the freelancer by ID and eager load their reviews
            $data = FreeLancer::with('reviews')->find($id);

            // Check if the freelancer exists
            if (!$data) {
                return response()->json(['error' => 'Freelancer not found'], 404);
            }

            // Calculate the average rating for the freelancer
            $data->average_rating = $data->reviews->avg('rating');

            // Optionally, include additional details for each review
            $data->reviews->transform(function ($review) {
                $review->user_name = $review->user->name;
                return $review;
            });

            // Return the freelancer's details along with their reviews and average rating
            return response()->json([
                "data" => $data,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                "message" => 'Error occurred'
            ], 422);
        }
    }

    //find by user id to update freelnacer
    public function freelancer_updateDetails()
    {
        try {
            // Get the authenticated user's ID
            $userId = Auth::user()->id;

            // Retrieve the freelancer's data for the authenticated user and eager load the reviews
            $data = FreeLancer::where('user_id', $userId)->with('reviews')->first();

            // Check if the freelancer profile exists for the authenticated user
            if (!$data) {
                return response()->json(['error' => 'Freelancer profile not found'], 404);
            }

            // Calculate the average rating for the freelancer
            $data->average_rating = $data->reviews->avg('rating');

            // Optionally, include additional details for each review (e.g., username and comment)
            $data->reviews->transform(function ($review) {
                $review->user_name = $review->user->name;
                return $review;
            });

            // Return the freelancer's data along with reviews and average rating
            return response()->json([
                "data" => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "message" => 'Error occurred',
                "error" => $e->getMessage()
            ], 500);
        }
    }


    public function freelancer_delete($id)
    {
        $delete = freelancer::find($id);
        $delete->delete();
        return response([
            'message' => 'Deleted Successfully'
        ]);
    }

    // insert krdny freelance review
    public function addReview(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|numeric|min:0|max:5',
            'comment' => 'required|string'
        ]);

        $user = Auth::User();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $freeLancer = FreeLancer::find($id);

        if (!$freeLancer) {
            return response()->json(['error' => 'FreeLancer not found'], 404);
        }

        // Check if the review already exists
        $review = reviews::where('free_lancer_id', $id)->where('user_id', $user->id)->first();

        if ($review) {
            // Update the existing review
            $review->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);
            return response()->json(['message' => 'Review updated successfully']);
        } else {
            // Create a new review
            reviews::create([
                'free_lancer_id' => $id,
                'user_id' => $user->id,
                'username' => $user->name, // Add the user's name to the review
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);
            return response()->json(['message' => 'Review added successfully']);
        }
    }


    // henanaway hamu review  kan
    public function getAverageReview($id)
    {
        try {
            $freeLancer = FreeLancer::with('reviews.user')->find($id);

            if (!$freeLancer) {
                return response()->json(['error' => 'Freelancer not found'], 404);
            }

            // Map reviews to include rating, comment, and user_name
            $reviews = $freeLancer->reviews->map(function ($review) {
                return [
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'user_name' => $review->user->name,
                ];
            });

            // Calculate average rating
            $averageRating = $freeLancer->reviews->avg('rating');

            // Return response with average rating and detailed reviews
            return response()->json([
                'average_rating' => $averageRating,
                'reviews' => $reviews,
            ]);
        } catch (\Exception $e) {
            // Handle any other errors
            return response()->json(['error' => 'An error occurred while fetching the reviews'], 500);
        }
    }



    // ama henanaway reviwe aw useraya ka logine krdwa
    // bo nmuna au useray login e krdwa boi freelance1 chan rate danawa yan bo 2 yan har hamuy 
    public function getUserReviews($freelancerId)
    {
        $userId = Auth::id(); // Get the authenticated user's ID

        // Fetch the review for the specific freelancer by the authenticated user
        $review = Reviews::where('user_id', $userId)
            ->where('free_lancer_id', $freelancerId)
            ->first();

        if (!$review) {
            return response()->json(['error' => 'Review not found'], 404);
        }

        return response()->json(['review' => $review]);
    }
}
