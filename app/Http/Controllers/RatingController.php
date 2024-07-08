<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BarType;
use App\Models\bookmark;
use App\Models\Review;
use App\Models\User;
use App\Models\Specification;

use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function reviews(Request $request)
    {
        $user = User::where('id', $request->input('user_id'));
        if ($user) {
            $request->validate([
                'user_id' => 'required',
                'id' => 'required',
                'comment' => 'required',
                'rating' => 'required|numeric|between:1,5'
            ]);
            $review = new Review;
            $review->user_id = $request->input('user_id');
            $review->bar_type_id = $request->input('id');
            $review->comment = $request->input('comment');
            $review->rating = $request->input('rating');
            $review->save();
            return response()->json(['status' => 1, 'message' => 'Review Created Successfully', 'data' => $review]);
        } else {
            return response()->json(['status' => 0, 'message' => 'An Error Occured!']);
        }
    }

    public function getBarRatings(Request $request)
    {
        $request->validate([
            'bar_type_id' => 'required|exists:bar_types,id', 
        ]);

        $barTypeId = $request->input('bar_type_id');

        $bar = BarType::find($barTypeId);

        if (!$bar) {
            return response()->json([
                'status' => 0,
                'message' => 'Bar not found',
            ], 404);
        }

        $reviews = Review::where('bar_type_id', $barTypeId)->get();

        $totalReviews = $reviews->count();
        if ($totalReviews === 0) {
            $averageRating = 0;
        } else {
            $totalWeightedScore = $reviews->sum('rating');
            
            $averageRating = $totalWeightedScore / $totalReviews;

            $average = round($averageRating,1);

        }

        return response()->json([
            'status' => 1,
            'message' => 'Bar ratings retrieved successfully',
            'data' => [
                'bar_id' => $bar->id,
                'bar_name' => $bar->title, 
                'average_rating' => $average,
                'total_reviews' => $totalReviews,
            ],
        ]);
    }

    public function bookmark(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'bar_type_id' => 'required',
        ]);
        $user = User::where('id', $request->input('user_id'));
        $bar = BarType::where('id', $request->input('bar_type_id'));
        if ($user && $bar) {
            $bookmark = new bookmark;
            $bookmark->user_id = $request->input('user_id');
            $bookmark->bar_type_id = $request->input('bar_type_id');
            $bookmark->save();

            return response()->json([
                'status' => 1,
                'message' => 'Bartype added to bookmark',
                'data' => $bookmark
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'something went wrong!'
            ]);
        }
    }

    public function deleteBookmark(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'bar_type_id' => 'required'
        ]);

        $bookmark = Bookmark::where('user_id', $request->input('user_id'))
                        ->where('bar_type_id', $request->input('bar_type_id'))
                        ->first();
        if($bookmark) {
            $bookmark->delete();

            return response()->json(['status' => 1 , 'message' => 'Bookmark deleted Successfully']);
        } else {
            return response()->json(['status' => 0, 'message' => 'Bookmark not found']);
        }
    }
    
    // public function getBookmarksByUserId(Request $request)
    // {
    //     $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //     ]);

    //     $bookmarks = Bookmark::where('user_id', $request->user_id)->get();
        
    //     if($bookmarks) {
    //         return response()->json(['status' => 1, 'message' => 'Bookmarks retrieved successfully', 'data' => $bookmarks]);
    //     }
    //     return response()->json(['status' => 0, 'message' => 'Bookmark not found']);

    // }
    public function getBookmarksByUserId(Request $request)
    {
        // Validate request data
        $request->validate([
            'user_id' => 'required',
        ]);
    
        $userId = $request->input('user_id');
    
        // Retrieve bookmarks for the specified user with associated BarType details
        $bookmarks = Bookmark::where('user_id', $userId)
            ->with('barType') // Eager load the related BarType model
            ->get();
    
        if ($bookmarks->isEmpty()) {
            return response()->json([
                'status' => 0,
                'message' => 'No bookmarks found for this user',
            ]);
        }
    
        $result = [];
    
        foreach ($bookmarks as $bookmark) {
            $barType = $bookmark->barType;
    
            // Fetch specifications for the BarType
            $specifications = Specification::where('bar_id', $barType->id)->get();
    
            // Fetch reviews for the BarType
            $reviews = Review::where('bar_type_id', $barType->id)->get();
            $totalReviews = $reviews->count();
    
            $averageRating = 0.0; // Default average rating
    
            if ($totalReviews > 0) {
                $totalWeightedScore = $reviews->sum('rating');
                $averageRating = $totalWeightedScore / $totalReviews; // Calculate average rating
                // Round to one decimal place
                $averageRating = number_format($averageRating, 1);
            }
    
            // Build the result array for each bookmark
            $result[] = [
                
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
                    'created_at' => $barType->created_at,
                    'updated_at' => $barType->updated_at,
                    'status' => (string)$barType->status,
                    'average_rating' => (string) $averageRating,
                    'total_reviews' => (string) $totalReviews,

            ];
        }
    
        return response()->json([
            'status' => 1,
            'message' => 'Bookmarks retrieved successfully',
            'data' => $result,
        ]);
    }
}
