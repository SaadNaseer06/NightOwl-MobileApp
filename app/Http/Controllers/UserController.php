<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BarType;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // public function register(Request $request)
    // {
    //     try {
    //         $validatedData = $request->validate([
    //             'first_name' => 'required|string|max:255',
    //             'last_name' => 'required|string|max:255',
    //             'email' => 'required|string|email|unique:users|max:255',
    //             'password' => 'required|string|min:6',
    //             'date_of_birth' => 'required|date_format:Y-m-d',
    //             'gender' => 'required', // Assuming gender can be either Male or Female
    //             'platform' => 'required|string|max:255',
    //             'track_my_visits' => 'nullable', // Assuming track_my_visits is a boolean field
    //             'image' => 'required|image', // Image validation
    //         ]);

    //         // Handle image upload
    //         if ($request->hasFile('image')) {
    //             $imagePath = $request->file('image')->store('images', 'public');
    //             $finalPath = url('/') . '/storage/app/public/' . $imagePath;
    //         }

    //         $user = new User();
    //         $user->first_name = $validatedData['first_name'];
    //         $user->last_name = $validatedData['last_name'];
    //         $user->username = $validatedData['first_name'] . " " . $validatedData['last_name'];
    //         $user->email = $validatedData['email'];
    //         $user->password = Hash::make($validatedData['password']);
    //         $user->date_of_birth = $validatedData['date_of_birth'];
    //         $user->gender = $validatedData['gender'];
    //         $user->platform = $validatedData['platform'];
    //         $user->role = 1;
    //         if ($user->track_my_visits == 'on') {
    //             $user->track_my_visits = 1;
    //         } else {
    //             $user->track_my_visits = 0;
    //         }
    //         // $user->track_my_visits = $validatedData['track_my_visits'] ?? false;
    //         $user->image = $finalPath;
    //         $user->status = 1;
    //         $user->save();

    //         return response()->json(['status' => 1, 'message' => 'User registered successfully', 'data' => $user], 201);
    //     } catch (ValidationException $e) {
    //         // Return validation error response
    //         return response()->json(['status' => 0, 'message' => 'Validation failed', 'data' => $e->errors()], 202);
    //     }
    // }
    
    public function socialLogin(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'first_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'email' => 'required|string|email|max:255', // Require email field
                'password' => 'nullable|string|min:6',
                'date_of_birth' => 'nullable|date_format:Y-m-d',
                'gender' => 'nullable', // Assuming gender can be either Male or Female
                'platform' => 'nullable|string|max:255', // Change to nullable
                'track_my_visits' => 'nullable', // Assuming track_my_visits is a boolean field
                'image' => 'nullable', // Image validation
            ]);
    
            // Check if the email already exists
            $user = User::where('email', $validatedData['email'])->first();
            if ($user) {
                // Log in the existing user
                Auth::login($user);
                $token = $user->createToken('API Token')->plainTextToken;
                $user->forceFill([
                    'remember_token' => $token,
                ]);
                $user->save();
                
                $result = array(
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at,
                    'date_of_birth' => $user->date_of_birth,
                    'gender' => $user->gender,
                    'role' => $user->role,
                    'status' => $user->status,
                    'platform' => $user->platform,
                    'image' => $user->image,
                    'track_my_visits' => $user->track_my_visits,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at
                    );
    
                return response()->json(['status' => 1, 'data' => $result, 'token' => $token,'message' => 'User logged in successfully'], 200);
            }
    
            // If the email doesn't exist, continue with registration process
            // Check if platform key exists in validated data
            $platform = isset($validatedData['platform']) ? $validatedData['platform'] : null;
    
            // Check if image field is provided, if not, assume it's a social login and set image path accordingly
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
                $finalPath = url('/') . '/storage/app/public/' . $imagePath;
            } else {
                // Assuming in case of social login, image path is provided in the request
                $finalPath = $request->input('image');
            }
    
            // Create a new user
            $user = new User();
            $user->first_name = $validatedData['first_name'];
            $user->last_name = $validatedData['last_name'];
            $user->username = $validatedData['first_name'] . " " . $validatedData['last_name'];
            $user->email = $validatedData['email'];
            $user->password = Hash::make($validatedData['password']);
            $user->date_of_birth = $validatedData['date_of_birth'];
            $user->gender = $validatedData['gender'];
            $user->platform = $platform; // Set platform with the value retrieved above
            $user->role = 1;
            $user->track_my_visits = $request->has('track_my_visits') ? 1 : 0;
            $user->image = $finalPath;
            $user->status = 1;
            $user->save();
    
            return response()->json(['status' => 1, 'message' => 'User registered successfully', 'data' => $user], 201);
        } catch (ValidationException $e) {
            // If the validation error is due to email uniqueness, retrieve the existing user data and return it
            if ($e->errors()['email'][0] === 'The email has already been taken.') {
                $user = User::where('email', $validatedData['email'])->first();
                return response()->json(['status' => 1, 'message' => 'User data retrieved successfully', 'data' => $user], 200);
            }
    
            // Otherwise, return the regular validation error response
            return response()->json(['status' => 0, 'message' => 'Validation failed', 'data' => $e->errors()], 202);
        }
    }

    
    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'first_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'email' => 'nullable|string|email|unique:users|max:255',
                'password' => 'nullable|string|min:6',
                'date_of_birth' => 'nullable|date_format:Y-m-d',
                'gender' => 'nullable', // Assuming gender can be either Male or Female
                'platform' => 'nullable|string|max:255', // Change to nullable
                'track_my_visits' => 'nullable', // Assuming track_my_visits is a boolean field
                'image' => 'nullable', // Image validation
            ]);
    
            // Check if platform key exists in validated data
            $platform = isset($validatedData['platform']) ? $validatedData['platform'] : null;
    
            // Check if image field is provided, if not, assume it's a social login and set image path accordingly
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
                $finalPath = url('/') . '/storage/app/public/' . $imagePath;
            } else {
                // Assuming in case of social login, image path is provided in the request
                $finalPath = $request->input('image');
            }
    
            $user = new User();
            $user->first_name = $validatedData['first_name'];
            $user->last_name = $validatedData['last_name'];
            $user->username = $validatedData['first_name'] . " " . $validatedData['last_name'];
            $user->email = $validatedData['email'];
            $user->password = Hash::make($validatedData['password']);
            $user->date_of_birth = $validatedData['date_of_birth'];
            $user->gender = $validatedData['gender'];
            $user->platform = $platform; // Set platform with the value retrieved above
            $user->role = 1;
            $user->track_my_visits = $request->has('track_my_visits') ? 1 : 0;
            $user->image = $finalPath;
            $user->status = 1;
            $user->save();
    
            return response()->json(['status' => 1, 'message' => 'User registered successfully', 'data' => $user], 201);
        } catch (ValidationException $e) {
            // Return validation error response
            return response()->json(['status' => 0, 'message' => 'Validation failed', 'data' => $e->errors()], 202);
        }
    }


    

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if (!$user || $user->status == 0) {
                return response()->json(['status' => 0, 'message' => 'Your account is inactive'], 403);
            }

            $token = $user->createToken('API Token')->plainTextToken;
            $user->forceFill([
                'remember_token' => $token,
            ]);
            $user->save();

            // return response()->json(['token' => $token]);

            return response()->json(['status' => 1, 'data' => $user, 'token' => $token, 'message' => "User Log In Successfully"], 201);
        }

        return response()->json(['status' => '0', "data" => null, "message" => "Invalid Email or Password"], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout(); 

        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 

        return redirect('/login');
    }


    public function EditProfile(Request $request)
    {
        $user = Auth::user();
        
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'first_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
                'image' => 'nullable',
                'password' => 'nullable|string|min:6', // Password is optional
            ]);
    
             // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
                $finalPath = url('/') . '/storage/app/public/' . $imagePath;
          
                $user->image = $finalPath;
                $user->save();
            }
    
            // Update user information based on the request data
            if ($request->filled('first_name')) {
                $user->first_name = $validatedData['first_name'];
            }
    
            if ($request->filled('last_name')) {
                $user->last_name = $validatedData['last_name'];
            }
    
            $user->username = $user->first_name . " " . $user->last_name;
            $user->email = $validatedData['email'];
    
            // Update password if provided
            if ($request->filled('password')) {
                $user->password = Hash::make($validatedData['password']);
            }
    
            // Save the updated user information to the database
            $user->save();
                
                 $result = array(
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'username' => $user->username,
                'email' => $user->email,
                'date_of_birth' => $user->date_of_birth,
                'gender' => $user->gender,
                'role' => $user->role,
                'status' => $user->status,
                'platform' => $user->platform,
                'image' => $user->image,
                'email_verified_at' => $user->email_verified_at,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'track_my_visits' => $user->track_my_visits,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            );
    
            // Constructing the response data
            $responseData = $user->refresh()->toArray();
            $responseData['status'] = 1;
    
            // Return success response
            return response()->json(['status' => 0, 'data'=>$result, 'token' => $user->remember_token]);
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json(['status' => 0, 'errors' => $e->errors()], 400);
        } catch (\Exception $e) {
            // Handle other exceptions (e.g., database errors)
            return response()->json(['status' => 0, 'message' => 'An error occurred while updating user profile.'], 500);
        }
    }

    public function fetchProfile(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        
        if ($user) {
            return response()->json(['status' => 1, 'data' => $user, 'token' => $user->remember_token , 'message' => "User Data"], 201);
        }

        return response()->json(['status' => '0', "data" => null, "message" => "No Record "], 401);
    }

    public function deleteProfile(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        if ($user || $user->status == 1) {
            $user->status = 0;
            $user->save();
            return response()->json(['status' => 1, 'message' => 'User Deleted Successfully', 'data' => null]);
        }
        return response()->json(['status' => 0, 'message' => 'User Not Found']);
    }

    public function fetchUsers()
    {
        $users = User::where('status', 1)->get();
        // dd($user);

        return view('admin.allusers', compact('users'));
    }
    
    public function roleAppoint($id)
    {
        $user = User::find($id);
        if (!$user) {
            // If user with given ID is not found, handle accordingly (e.g., return error response)
            return response()->json(['status' => 0, 'message' => 'User not found'], 404);
        }
    
        // Check the current role of the user
        if ($user->role === 'user' || $user->role === 1) {
            // If current role is 'user', update to 'admin'
            $user->role = 'admin';
        } else {
            // If current role is 'admin', update to 'user'
            $user->role = 'user';
        }
    
        // Save the updated role
        $user->save();
    
        $users = User::all();
    
        return view('admin.allusers', compact('users'));
    }

    public function userDelete($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Perform the deletion (set status to inactive)
        $user->status = 0;
        $user->save();

        return back()->with('success', 'User deleted successfully');
    }

    public function editUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['status' => 0, 'message' => 'User not found!']);
        }

        // dd($user);

        return view('admin.edituser', compact('user'));
    }

    public function userUpdate(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|max:20',
            'platform' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'track_my_visits' => 'nullable|boolean',
        ]);

        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')), // Hash password if provided
            'date_of_birth' => $request->input('date_of_birth'),
            'gender' => $request->input('gender'),
            'platform' => $request->input('platform'),
            'track_my_visits' => $request->has('track_my_visits'),
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $finalPath = url('/') . '/storage/app/public/' . $imagePath;
      
            $user->image = $finalPath;
            $user->save();
        }

        // Redirect with success message
        return redirect()->back()->with('success', 'User details updated successfully.');
    }
    public function admin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            // Authentication successful
            $user = Auth::user();

            if ($user->role === 'admin') {
                // User is an admin
                return redirect('/'); // Redirect to admin dashboard
            } else {
                // User is not an admin
                Auth::logout();
                return redirect()->back()->withInput()->withErrors(['email' => 'You are not authorized to access this resource.']);
            }
        } else {
            // Authentication failed
            return redirect()->back()->withInput()->withErrors(['email' => 'Invalid credentials.']);
        }
    }

    public function fetchBars()
    {
        $bars = BarType::where('status', 1)->get();
        return view('admin.allbars', compact('bars'));
    }

    public function barDelete($id)
    {
        $bar = BarType::find($id);

        if (!$bar) {
            return response()->json(['message' => 'Bar not found'], 404);
        }

        // Perform the deletion (set status to inactive)
        $bar->status = 0;
        $bar->save();

        return back()->with('success', 'User deleted successfully');
    }

    public function barUpdate(Request $request, BarType $barType)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            // Add validation rules for other fields...
        ]);

        // Update BarType model with validated data
        $barType->update($request->only([
            'type', 'title', 'latitude', 'longtitude', 'facebook', 'instagram', 'twitter', 'description'
        ]));

        // Handle specifications
        $specifications = Specification::where('specification', $request->input('specifications'));

        foreach ($specifications as $index => $specification) {
            if ($specification) { // Only process non-empty specifications
                if (isset($barType->specifications[$index])) {
                    // Update existing specification
                    $barType->specifications[$index]->update(['specification' => $specification]);
                } else {
                    // Create new specification
                    $newSpecification = new Specification(['specification' => $specification]);
                    $barType->specifications()->save($newSpecification);
                }
            }
        }

        // Redirect with success message
        return redirect()->back()->with('success', 'Bar details updated successfully.');
    }
    
    public function index()
    {
        $bars = BarType::where('status', 1)->get();
        // dd($bars);
        $users = User::count();
        
        return view('admin.index',compact('bars','users'));
    }
}
