<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class WebController extends Controller
{
    public function createUser(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'first-name' => 'required|string|max:255',
                'last-name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users|max:255',
                'password' => 'required|string|min:6',
                'date-of-birth' => 'required|date_format:Y-m-d',
                'gender' => 'required',
                'platform' => 'required|string|max:255',
                'track-my-visits' => 'nullable|boolean',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/images', $imageName); 
            }

            $user = new User();
            $user->first_name = $validatedData['first_name'];
            $user->last_name = $validatedData['last_name'];
            $user->username = $validatedData['first_name'] . " " . $validatedData['last_name'];
            $user->email = $validatedData['email'];
            $user->password = Hash::make($validatedData['password']);
            $user->date_of_birth = $validatedData['date_of_birth'];
            $user->gender = $validatedData['gender'];
            $user->platform = $validatedData['platform'];
            $user->role = 1;
            $user->track_my_visits = $validatedData['track_my_visits'] ?? false;
            $user->image = $imageName;
            $user->status = 1;
            $user->save();

            return redirect();
        } catch (ValidationException $e) {
            dd("An Error Occured");
            return response()->json(['error' => 'Validation failed', 'details' => $e->errors()], 422);
        }
    }
}
