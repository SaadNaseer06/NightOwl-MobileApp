@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Quick Example</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="POST" action="{{ route('user.update', ['user' => $user]) }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first-name" name="first_name"
                            placeholder="Enter first name" value="{{ $user->first_name }}">
                    </div>
                    <div class="form-group">
                        <label for="last-name">Last Name</label>
                        <input type="text" class="form-control" id="last-name" name="last_name"
                            placeholder="Enter last name" value="{{ $user->last_name }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email"
                            name="email" value="{{ $user->email }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"
                            name="password">
                    </div>
                    <div class="form-group">
                        <label for="date-of-birth">Date Of Birth</label>
                        <input type="text" class="form-control" id="date-of-birth" placeholder="mm/dd/yyyy"
                            name="date_of_birth" value="{{ $user->date_of_birth }}">
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <input type="text" class="form-control" id="gender" placeholder="Enter gender" name="gender" value="{{ $user->gender }}">
                    </div>
                    <div class="form-group">
                        <label for="platform">Platform</label>
                        <input type="text" class="form-control" id="platform" placeholder="Enter platform"
                            name="platform" value="{{ $user->platform }}">
                    </div>
                    <div class="form-group">
                        <label for="img">Select image:</label>
                        <input type="file" id="img" name="image" value="{{ $user->image }}">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="track-my-visits" name="track_my_visits">
                        <label class="form-check-label" for="track-my-visits">Check me out</label>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
