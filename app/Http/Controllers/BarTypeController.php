<?php

namespace App\Http\Controllers;

use App\Models\BarType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Review;
use App\Models\Specification;
use App\Models\bookmark;
use App\Models\VisitedBar;
use Illuminate\Support\Facades\DB;

class BarTypeController extends Controller
{
    /**
     * Create a new bar type.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            $validatedData = $request->validate([
                'type' => 'required',
                'image' => 'required',
                'title' => 'required',
                'latitude' => 'required',
                'longtitude' => 'required',
                'facebook' => 'nullable',
                'twitter' => 'nullable',
                'instagram' => 'nullable',
                'description' => 'nullable',
                'specifications.*' => 'nullable', // Allow an array of specifications
            ]);

            $imagePath = $request->file('image')->store('images', 'public');
            $finalPath = url('/') . '/storage/app/public/' . $imagePath;

            // Create new BarType
            $bar = new BarType();
            $bar->type = $validatedData['type'];
            $bar->image = $finalPath;
            $bar->title = $validatedData['title'];
            $bar->latitude = $validatedData['latitude'];
            $bar->longtitude = $validatedData['longtitude'];
            $bar->facebook = $validatedData['facebook'];
            $bar->twitter = $validatedData['twitter'];
            $bar->instagram = $validatedData['instagram'];
            $bar->description = $validatedData['description'];
            $bar->status = 1;
            $bar->save();

            foreach ($validatedData['specifications'] ?? [] as $key => $spec) {
                $specification = new Specification();
                $specification->bar_id = $bar->id;
                $specification->specification = $spec;

                // Handle associated image upload
                if ($request->hasFile('images.' . $key)) {
                    $imagePath = $request->file('images.' . $key)->store('spec_image', 'public');
                    $specification->image = url('/storage/app/public/' . $imagePath);
                }

                // Save specification
                $specification->save();
            }

            $result = array(
                'id' => $bar->id,
                'type' => $bar->type,
                'image' => $bar->image,
                'title' => $bar->title,
                'latitude' => $bar->latitude,
                'longtitude' => $bar->longtitude,
                'facebook' => $bar->facebook,
                'twitter' => $bar->twitter,
                'instagram' => $bar->instagram,
                'description' => $bar->description,
                'specifications' => $validatedData['specifications'],
                'status' => "1"
            );

            return response()->json(['status' => 1, 'message' => 'BarType Created Successfully', 'data' => $result], 201);
        } else {
            return response()->json(['status' => 0, 'message' => 'Only Admin Can Add BarTypes'], 401);
        }
    }

    public function EditBar(Request $request)
    {
        $bar = BarType::findOrFail($request->input('id'));

        if ($bar) {
            $validatedData = $request->validate([
                'type' => 'required',
                'image' => 'required',
                'title' => 'required',
                'latitude' => 'required',
                'longtitude' => 'required',
                'facebook' => 'nullable',
                'twitter' => 'nullable',
                'instagram' => 'nullable',
                'description' => 'nullable',
                'specifications.*' => 'nullable', // Allow an array of specifications
            ]);

            dd("ERRE");
            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
                $finalPath = url('/') . '/storage/app/public/' . $imagePath;
            }

            $bar->type = $validatedData['type'];
            if (isset($finalPath)) {
                $bar->image = $finalPath;
            }
            $bar->title = $validatedData['title'];
            $bar->latitude = $validatedData['latitude'];
            $bar->longtitude = $validatedData['longtitude'];
            $bar->facebook = $validatedData['facebook'];
            $bar->twitter = $validatedData['twitter'];
            $bar->instagram = $validatedData['instagram'];
            $bar->description = $validatedData['description'];
            $bar->save();

            // Delete existing specifications for the BarType
            $bar->specifications()->delete();

            // Insert new specifications for the BarType
            $specifications = $validatedData['specifications'] ?? [];
            if (!empty($specifications)) {
                $specData = [];
                foreach ($specifications as $spec) {
                    $specData[] = [
                        'specification' => $spec,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                $bar->specifications()->createMany($specData);
            }

            return response()->json([
                'status' => 1,
                'message' => 'Record Updated Successfully',
                'data' => $validatedData['specifications'],
            ]);
        } else {
            return response()->json(['message' => 'Bar not found'], 404);
        }
    }

    // public function getBars()
    // {
    //     $bars = BarType::where('status', '1')->get();

    //     if ($bars->isEmpty()) {
    //         return response()->json([
    //             'status' => 0,
    //             'message' => 'No bars found'
    //         ]);
    //     }

    //     $result = [];

    //     foreach ($bars as $activeBars) {
    //         $specifications = Specification::where('bar_id', $activeBars->id)->get();

    //         $reviews = Review::where('bar_type_id', $activeBars->id)->get();
    //         $totalReviews = $reviews->count();

    //         $averageRating = 0.0; // Default average rating

    //         if ($totalReviews > 0) {
    //             $totalWeightedScore = $reviews->sum('rating');
    //             $averageRating = $totalWeightedScore / $totalReviews; // Calculate average rating
    //             // Round to one decimal place
    //             $averageRating = number_format($averageRating, 1);
    //         }

    //         $result[] = [
    //             'id' => $activeBars->id,
    //             'type' => $activeBars->type,
    //             'image' => $activeBars->image,
    //             'title' => $activeBars->title,
    //             'latitude' => $activeBars->latitude,
    //             'longtitude' => $activeBars->longtitude,
    //             'facebook' => $activeBars->facebook,
    //             'twitter' => $activeBars->twitter,
    //             'instagram' => $activeBars->instagram,
    //             'description' => $activeBars->description,
    //             'specifications' => $specifications,
    //             'created_at' => $activeBars->created_at,
    //             'updated_at' => $activeBars->updated_at,
    //             'status' => "1",
    //             'average_rating' => (string)$averageRating,
    //             'total_reviews' => (string)$totalReviews,
    //         ];
    //     }

    //     return response()->json([
    //         'status' => 1,
    //         'message' => 'Bars Retrieved Successfully',
    //         'data' => $result
    //     ]);
    // }

    public function getBars()
    {
        $bars = BarType::where('status', '1')->get();
        if ($bars->isEmpty()) {
            return response()->json([
                'status' => 0,
                'message' => 'No bars found'
            ]);
        }

        $result = [];

        foreach ($bars as $activeBars) {
            $specifications = Specification::where('bar_id', $activeBars->id)->get();

            $reviews = Review::where('bar_type_id', $activeBars->id)->get();
            $totalReviews = $reviews->count();

            $averageRating = 0.0;

            if ($totalReviews > 0) {
                $totalWeightedScore = $reviews->sum('rating');
                $averageRating = $totalWeightedScore / $totalReviews; // Calculate average rating
                // Round to one decimal place
                $averageRating = number_format($averageRating, 1);
            }

            if ($averageRating == 0) {
                $averageRating = 0.0;
                // dd($averageRating);
            }

            $result[] = [
                'id' => $activeBars->id,
                'type' => $activeBars->type,
                'image' => $activeBars->image,
                'title' => $activeBars->title,
                'latitude' => $activeBars->latitude,
                'longtitude' => $activeBars->longtitude,
                'facebook' => $activeBars->facebook,
                'twitter' => $activeBars->twitter,
                'instagram' => $activeBars->instagram,
                'description' => $activeBars->description,
                'specifications' => $specifications,
                'created_at' => $activeBars->created_at,
                'updated_at' => $activeBars->updated_at,
                'status' => "1",
                'average_rating' => (string)$averageRating,
                'total_reviews' => (string)$totalReviews,
            ];
        }

        return response()->json([
            'status' => 1,
            'message' => 'Bars Retrieved Successfully',
            'data' => $result
        ]);
    }





    public function deleteBar(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:bar_types,id'
        ]);

        $bar = BarType::findOrFail($request->input('id'));

        $bar->status = 0;

        $bar->save();

        return response()->json([
            'status' => 1,
            'message' => 'Bartype deleted successfully',
            'data' => $bar
        ]);
    }

    public function allBars()
    {
        $bars = BarType::all();

        if (!$bars) {
            return response()->json(['status' => 0, 'message' => 'bars not found']);
        }

        return response()->json(['status' => 1, 'data' => $bars]);
    }

    public function recommendedBars()
    {
        // Get all bar types with status = 1
        $barTypes = BarType::where('status', '1')->get();

        // Array to store recommended bars
        $recommendedBars = [];

        // Iterate through each bar type
        foreach ($barTypes as $barType) {
            // Retrieve reviews for the current bar type
            $reviews = Review::where('bar_type_id', $barType->id)->get();

            // Calculate average rating for the current bar type
            $totalReviews = $reviews->count();
            if ($totalReviews > 0) {
                $totalWeightedScore = $reviews->sum('rating');
                $averageRating = $totalWeightedScore / $totalReviews;

                // Check if average rating is >= 4
                if ($averageRating >= 4) {
                    // Retrieve specifications for the current bar type
                    $specifications = Specification::where('bar_id', $barType->id)->get();

                    // Add bar details to recommendedBars array
                    $recommendedBars[] = [
                        'id' => $barType->id,
                        'type' => $barType->type,
                        'image' => $barType->image,
                        'title' => $barType->title,
                        'latitude' => $barType->latitude,
                        'longtitude' => $barType->longtitude,
                        'facebook' => $barType->facebook,
                        'twitter' => $barType->twitter,
                        'instagram' => $barType->instagram,
                        'description' => $barType->description,
                        'specifications' => $specifications,
                        'average_rating' => number_format($averageRating, 1),
                        'total_reviews' => (string)$totalReviews,
                        'created_at' => $barType->created_at,
                        'updated_at' => $barType->updated_at,
                        'status' => (string)$barType->status,
                    ];
                }
            }
        }

        // Check if any recommended bars were found
        if (empty($recommendedBars)) {
            return response()->json([
                'status' => 0,
                'message' => 'No bars found with a rating of 4 or higher',
            ]);
        }

        // Return JSON response with recommended bars
        return response()->json([
            'status' => 1,
            'message' => 'Recommended bars retrieved successfully',
            'data' => $recommendedBars,
        ]);
    }



    public function nearestBar(Request $request)
    {
        $lat = $request->input('lat');
        $lng = $request->input('lng');
        if (!$lat || !$lng) {
            return response()->json(['status' => 0, 'message' => 'Latitude and longitude are required.'], 400);
        }

        $earthRadius = 6371000;

        $nearestBars = BarType::where('status', 1)->get();

        $response = [];

        foreach ($nearestBars as $bar) {
            $specifications = DB::table('specifications')
                ->where('bar_id', $bar->id)
                ->get();

            $reviews = Review::where('bar_type_id', $bar->id)->get();
            $totalReviews = $reviews->count();

            $averageRating = 0.0;

            if ($totalReviews > 0) {
                $totalWeightedScore = $reviews->sum('rating');
                $averageRating = $totalWeightedScore / $totalReviews; // Calculate average rating
                // Round to one decimal place
                $averageRating = number_format($averageRating, 1);
            }
            $latFrom = deg2rad(floatval($bar->latitude));
            $lonFrom = deg2rad(floatval($bar->longtitude));
            $latTo = deg2rad($lat);
            $lonTo = deg2rad($lng);

            $latDelta = $latTo - $latFrom;
            $lonDelta = $lonTo - $lonFrom;

            $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

            $meter = $angle * $earthRadius;
            $km = $meter / 1000;

            if ($km <= 2500) {

                $response[] = [
                    'id' => $bar->id,
                    'type' => $bar->type,
                    'image' => $bar->image,
                    'title' => $bar->title,
                    'latitude' => $bar->latitude,
                    'longtitude' => $bar->longtitude,
                    'facebook' => $bar->facebook,
                    'twitter' => $bar->twitter,
                    'instagram' => $bar->instagram,
                    'description' => $bar->description,
                    'specifications' => $specifications,
                    'created_at' => $bar->created_at,
                    'updated_at' => $bar->updated_at,
                    'status' => "1",
                    'average_rating' => (string)$averageRating,
                    'total_reviews' => (string)$totalReviews,
                    'distance' => (string)round($km, 2)
                ];
            }
        }

        if (empty($response)) {
            $earthRadius = 6371000;

            $allBars = BarType::where('status', 1)->get();
    
            $result = [];
    
            foreach ($allBars as $bar) {
                $specifications = DB::table('specifications')
                    ->where('bar_id', $bar->id)
                    ->get();
    
                $reviews = Review::where('bar_type_id', $bar->id)->get();
                $totalReviews = $reviews->count();
    
                $averageRating = 0.0;
    
                if ($totalReviews > 0) {
                    $totalWeightedScore = $reviews->sum('rating');
                    $averageRating = $totalWeightedScore / $totalReviews; // Calculate average rating
                    // Round to one decimal place
                    $averageRating = number_format($averageRating, 1);
                }
                $latFrom = deg2rad(floatval($bar->latitude));
                $lonFrom = deg2rad(floatval($bar->longtitude));
                $latTo = deg2rad($lat);
                $lonTo = deg2rad($lng);
    
                $latDelta = $latTo - $latFrom;
                $lonDelta = $lonTo - $lonFrom;
    
                $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                    cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
    
                $meter = $angle * $earthRadius;
                $km = $meter / 1000;
                $response[] = [
                    'id' => $bar->id,
                    'type' => $bar->type,
                    'image' => $bar->image,
                    'title' => $bar->title,
                    'latitude' => $bar->latitude,
                    'longtitude' => $bar->longtitude,
                    'facebook' => $bar->facebook,
                    'twitter' => $bar->twitter,
                    'instagram' => $bar->instagram,
                    'description' => $bar->description,
                    'specifications' => $specifications,
                    'created_at' => $bar->created_at,
                    'updated_at' => $bar->updated_at,
                    'status' => "1",
                    'average_rating' => (string)$averageRating,
                    'total_reviews' => (string)$totalReviews,
                    'distance' => (string)round($km, 2)
                    ];
            }
        }
    
            return response()->json(['status' => 1, 'message' => 'Bars Retrieved Successfully', 'data' => $response], 200);
        }


    public function visitedBar(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'bar_type_id' => 'required|integer'
        ]);

        $bar = VisitedBar::create([
            'user_id' => $request->input('user_id'),
            'bar_type_id' => $request->input('bar_type_id')
        ]);

        $result = array(
            'id' => $bar->id,
            'user_id' => $bar->user_id,
            'bar_type_id' => $bar->bar_type_id,
            'visited_time' => now()->toDateTimeString()
        );

        return response()->json(['status' => 1, 'message' => 'BarType added in visted bars', 'data' => $result]);


        if (!$bar) {
            return response()->json(['status' => 0, 'message' => 'Visited Bars not found']);
        }
    }


    public function getVisitedBarsByType(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
        ]);

        $visitedBars = VisitedBar::with('barType')
            ->where('user_id', $request->input('user_id'))
            ->get();

        if ($visitedBars->isEmpty()) {
            return response()->json(['status' => 0, 'message' => 'No visited bars found for the specified user and bar type']);
        }

        $barsData = [];

        foreach ($visitedBars as $visitedBar) {
            $barType = $visitedBar->barType;

            $specifications = DB::table('specifications')
                ->where('bar_id', $barType->id)
                ->get();
                
            $reviews = Review::where('user_id', $request->input('user_id'))->get();
            $totalReviews = $reviews->count();

            $averageRating = 0.0; // Default average rating

            if ($totalReviews > 0) {
                $totalWeightedScore = $reviews->sum('rating');
                $averageRating = $totalWeightedScore / $totalReviews; // Calculate average rating
                // Round to one decimal place
                $averageRating = number_format($averageRating, 1);
            }

            if ($barType) {
                $barsData[] = [
                    // $barsData = [
                    'id' => $visitedBar->id,
                    'user_id' => $visitedBar->user_id,
                    'visited_time' => $visitedBar->created_at->toDateTimeString(),
                    'type' => $barType->type,
                    'title' => $barType->title,
                    'image' => $barType->image,
                    'description' => $barType->description,
                    'latitude' => $barType->latitude,
                    'longtitude' => $barType->longtitude,
                    'facebook' => $barType->facebook,
                    'twitter' => $barType->twitter,
                    'instagram' => $barType->instagram,
                    'specifications' => $specifications,
                    'created_at' => $barType->created_at,
                    'updated_at' => $barType->updated_at,
                    'status' => "1",
                    'average_rating' => (string)$averageRating,
                    'total_reviews' => (string)$totalReviews,
                ];
            }
        }

        return response()->json(['status' => 1, 'message' => 'Visited bars details retrieved successfully', 'data' => $barsData]);
    }


    public function getBarByType(Request $request)
    {
        $type = $request->type;
        // Validate the type parameter (optional, depending on your requirements)
        if (!in_array($type, ['bar', 'club'])) {
            return response()->json(['status' => 0, 'message' => 'Invalid type specified'], 400);
        }

        // Retrieve all bars or clubs based on the specified type
        $bars = BarType::where('status', 1)
            ->where('type', $type)
            ->get();

        if ($bars->isEmpty()) {
            return response()->json([
                'status' => 0,
                'message' => 'No bars found'
            ]);
        }

        $result = [];

        foreach ($bars as $activeBars) {
            $specifications = Specification::where('bar_id', $activeBars->id)->get();

            $reviews = Review::where('bar_type_id', $activeBars->id)->get();
            $totalReviews = $reviews->count();

            $averageRating = 0.0; // Default average rating

            if ($totalReviews > 0) {
                $totalWeightedScore = $reviews->sum('rating');
                $averageRating = $totalWeightedScore / $totalReviews; // Calculate average rating
                // Round to one decimal place
                $averageRating = number_format($averageRating, 1);
            }

            $result[] = [
                'id' => $activeBars->id,
                'type' => $activeBars->type,
                'image' => $activeBars->image,
                'title' => $activeBars->title,
                'latitude' => $activeBars->latitude,
                'longtitude' => $activeBars->longtitude,
                'facebook' => $activeBars->facebook,
                'twitter' => $activeBars->twitter,
                'instagram' => $activeBars->instagram,
                'description' => $activeBars->description,
                'specifications' => $specifications,
                'created_at' => $activeBars->created_at,
                'updated_at' => $activeBars->updated_at,
                'status' => (string) $activeBars->status,
                'average_rating' => (string) $averageRating,
                'total_reviews' => (string) $totalReviews,
            ];
        }

        return response()->json([
            'status' => 1,
            'message' => 'Bars Retrieved Successfully',
            'data' => $result
        ]);
    }

    public function getBookmark(Request $request)
    {
        // Validate the request data
        $request->validate([
            'user_id' => 'required',
            'bar_type_id' => 'required',
        ]);

        // Retrieve bookmarks based on user_id and bar_type_id
        $bookmarks = bookmark::where('user_id', $request->user_id)
            ->where('bar_type_id', $request->bar_type_id)
            ->first();

        if ($bookmarks) {
            return response()->json(['status' => 1, 'message' => 'Bookmarks retrieved successfully', 'data' => $bookmarks]);
        } else {
            return response()->json(['status' => 0, 'message' => 'Bookmarks not found', 'data' => NULL]);
        }
    }

    public function barEdit($id)
    {
        try {
            // Find the bar type by ID along with its specifications
            $bar = BarType::with('specifications')->findOrFail($id);

            $specifications = DB::table('specifications')
                ->where('bar_id', $id)
                ->get();

            // Render the edit bar form view with the retrieved data
            return view('admin.editbar', compact('bar', 'specifications'));
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., bar not found)
            return back()->with('error', 'Error occurred: ' . $e->getMessage());
        }
    }

    public function add(Request $request)
    {
        // Ensure the user is authenticated and has admin role
        if (Auth::check() && Auth::user()->role === 'admin') {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'type' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation rules
                'title' => 'required',
                'latitude' => 'required',
                'longtitude' => 'required',
                'facebook' => 'nullable',
                'twitter' => 'nullable',
                'instagram' => 'nullable',
                'description' => 'nullable',
                'specifications.*' => 'nullable',
                'spec_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Image validation rules for spec images
            ]);

            $imagePath = $request->file('image')->store('images', 'public');
            $finalImagePath = url('/') . '/storage/app/public/' . $imagePath;

            $bar = new BarType();
            $bar->type = $validatedData['type'];
            $bar->image = $finalImagePath;
            $bar->title = $validatedData['title'];
            $bar->latitude = $validatedData['latitude'];
            $bar->longtitude = $validatedData['longtitude'];
            $bar->facebook = $validatedData['facebook'];
            $bar->twitter = $validatedData['twitter'];
            $bar->instagram = $validatedData['instagram'];
            $bar->description = $validatedData['description'];
            $bar->status = 1;
            $bar->save();

            $specifications = $request->input('specifications');
            $images = $request->file('spec_image');

            foreach ($specifications as $key => $spec) {
                //  echo $images[$key];
                $imagePath = $images[$key]->store('images', 'public');
                $finalPath = url('/') . '/storage/app/public/' . $imagePath;
                $specs = $specifications[$key];

                $specification = new Specification();
                $specification->bar_id = $bar->id;
                $specification->specification = $spec;
                $specification->spec_image = $finalPath;
                // Save the specification
                $specification->save();

                $res[] = array(
                    'image' => $finalPath,
                    'specification' => $spec,
                );
            }

            // Prepare response data
            $result = [
                'id' => $bar->id,
                'type' => $bar->type,
                'image' => $bar->image,
                'title' => $bar->title,
                'latitude' => $bar->latitude,
                'longtitude' => $bar->longtitude,
                'facebook' => $bar->facebook,
                'twitter' => $bar->twitter,
                'instagram' => $bar->instagram,
                'description' => $bar->description,
                'specifications' => $res,
                'status' => "1"
            ];

            // Redirect to a specific route after successful addition
            return redirect('/bars')->with('success', 'BarType added successfully!');
        } else {
            // Unauthorized access response
            return response()->json(['status' => 0, 'message' => 'Only Admin can add BarTypes'], 401);
        }
    }

    public function update(Request $request, $id)
    {
        $bar = BarType::findOrFail($id);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $finalPath = url('/') . '/storage/app/public/' . $imagePath;
            $bar->image = $finalPath;
        }

        $bar->update([
            'type' => $request->input('type'),
            'title' => $request->input('title'),
            'latitude' => $request->input('latitude'),
            'longtitude' => $request->input('longtitude'),
            'facebook' => $request->input('facebook'),
            'twitter' => $request->input('twitter'),
            'instagram' => $request->input('instagram'),
            'description' => $request->input('description')
        ]);

        // Update specifications
        $bar->specifications()->delete(); // Delete existing specifications




        if ($request->hasFile('spec_image')) {
            $specifications = $request->input('specifications');
            $images = $request->file('spec_image');
            foreach ($specifications as $key => $spec) {
                if ($specifications[$key] != null) {

                    $imagePath = $images[$key]->store('images', 'public');
                    $finalPath = url('/') . '/storage/app/public/' . $imagePath;
                    $specs = $specifications[$key];

                    $specification = new Specification();
                    $specification->bar_id = $bar->id;
                    $specification->specification = $spec;
                    $specification->spec_image = $finalPath;
                    // Save the specification
                    $specification->save();
                }
            }
        }

        if ($request->input('spec_imag') != "") {
            $specifications = $request->input('specification');
            $images = $request->input('spec_imag');
            foreach ($specifications as $key => $spec) {
                if ($specifications[$key] != null) {

                    $specs = $specifications[$key];

                    $specification = new Specification();
                    $specification->bar_id = $bar->id;
                    $specification->specification = $spec;
                    $specification->spec_image = $images[$key];
                    // Save the specification
                    $specification->save();
                }
            }
        }

        return redirect('/bars')->with('success', 'Bar updated successfully');
    }

    public function inactiveBars()
    {
        $inactive = BarType::where('status', 0)->get();
        return view('admin.inactive', compact('inactive'));
    }
    
    public function inactiveDelete($id) 
    {
        $bar = BarType::find($id);
        $bar->delete();
        
        return redirect('/inactive');
    }

    public function barActive($id)
    {
        $bar = BarType::find($id);

        if (!$bar) {
            return response()->json(['message' => 'Bar not found'], 404);
        }

        // Perform the deletion (set status to inactive)
        $bar->status = 1;
        $bar->save();

        return back()->with('success', 'Bar Activate Successfully');
    }
    
    public function search(Request $request)
    {
        $query = $request->input('q');
    
        // Perform a regular database query to find matching records
        $bars = BarType::where('title', 'like', '%' . $query . '%')->get();
    
        if ($bars->isEmpty()) {
            return response()->json(['status' =>  0,'message' => 'No results found'], 404);
        }
        
        $results = [];

        foreach ($bars as $activeBars) {
            $specifications = Specification::where('bar_id', $activeBars->id)->get();

            $reviews = Review::where('bar_type_id', $activeBars->id)->get();
            $totalReviews = $reviews->count();

            $averageRating = 0.0;

            if ($totalReviews > 0) {
                $totalWeightedScore = $reviews->sum('rating');
                $averageRating = $totalWeightedScore / $totalReviews; // Calculate average rating
                // Round to one decimal place
                $averageRating = number_format($averageRating, 1);
            }

            if ($averageRating == 0) {
                $averageRating = 0.0;
            }

            $results[] = [
                'id' => $activeBars->id,
                'type' => $activeBars->type,
                'image' => $activeBars->image,
                'title' => $activeBars->title,
                'latitude' => $activeBars->latitude,
                'longtitude' => $activeBars->longtitude,
                'facebook' => $activeBars->facebook,
                'twitter' => $activeBars->twitter,
                'instagram' => $activeBars->instagram,
                'description' => $activeBars->description,
                'specifications' => $specifications,
                'created_at' => $activeBars->created_at,
                'updated_at' => $activeBars->updated_at,
                'status' => "1",
                'average_rating' => (string)$averageRating,
                'total_reviews' => (string)$totalReviews,
            ];
        }
    
        return response()->json(['status' => 1, 'message' => 'Bars Retrived Successfully' ,'data' => $results]);
    }
    public function viewBar($id) {
        $bar = BarType::find($id);
        try {
            // Find the bar type by ID along with its specifications
            $bar = BarType::with('specifications')->findOrFail($id);

            $specifications = DB::table('specifications')
                ->where('bar_id', $id)
                ->get();
                
            $reviews = DB::table('reviews')
                ->where('bar_type_id', $id)
                ->get();

            // Render the edit bar form view with the retrieved data
            return view('admin.view-bar', compact('bar', 'specifications', 'reviews'));
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., bar not found)
            return back()->with('error', 'Error occurred: ' . $e->getMessage());
        }
    } 
}
