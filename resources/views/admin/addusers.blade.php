@extends('admin.layouts.app')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
          <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Quick Example</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="userCreate" method="POST" action="{{ route('user.create') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first-name" name="first_name"
                            placeholder="Enter first name">
                    </div>
                    <div class="form-group">
                        <label for="last-name">Last Name</label>
                        <input type="text" class="form-control" id="last-name" name="last_name"
                            placeholder="Enter last name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email"
                            name="email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"
                            name="password">
                    </div>
                    <div class="form-group">
                        <label for="date-of-birth">Date Of Birth</label>
                        <input type="text" class="form-control" id="date-of-birth" placeholder="mm/dd/yyyy"
                            name="date_of_birth">
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <input type="text" class="form-control" id="gender" placeholder="Enter gender" name="gender">
                    </div>
                    <div class="form-group">
                        <label for="platform">Platform</label>
                        <input type="text" class="form-control" id="platform" placeholder="Enter platform"
                            name="platform">
                    </div>
                    <div class="form-group">
                        <label for="img">Select image:</label>
                        <input type="file" id="img" name="image">
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
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
    
    
    
    
    
    
    
    
    <!--<div class="container">-->
    <!--    <div class="card card-primary">-->
    <!--        <div class="card-header">-->
    <!--            <h3 class="card-title">Quick Example</h3>-->
    <!--        </div>-->
            <!-- /.card-header -->
            <!-- form start -->
    <!--        <form id="userCreate" method="POST" action="{{ route('user.create') }}" enctype="multipart/form-data">-->
    <!--            @csrf-->
    <!--            <div class="card-body">-->
    <!--                <div class="form-group">-->
    <!--                    <label for="first_name">First Name</label>-->
    <!--                    <input type="text" class="form-control" id="first-name" name="first_name"-->
    <!--                        placeholder="Enter first name">-->
    <!--                </div>-->
    <!--                <div class="form-group">-->
    <!--                    <label for="last-name">Last Name</label>-->
    <!--                    <input type="text" class="form-control" id="last-name" name="last_name"-->
    <!--                        placeholder="Enter last name">-->
    <!--                </div>-->
    <!--                <div class="form-group">-->
    <!--                    <label for="exampleInputEmail1">Email address</label>-->
    <!--                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email"-->
    <!--                        name="email">-->
    <!--                </div>-->
    <!--                <div class="form-group">-->
    <!--                    <label for="exampleInputPassword1">Password</label>-->
    <!--                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"-->
    <!--                        name="password">-->
    <!--                </div>-->
    <!--                <div class="form-group">-->
    <!--                    <label for="date-of-birth">Date Of Birth</label>-->
    <!--                    <input type="text" class="form-control" id="date-of-birth" placeholder="mm/dd/yyyy"-->
    <!--                        name="date_of_birth">-->
    <!--                </div>-->

    <!--                <div class="form-group">-->
    <!--                    <label for="gender">Gender</label>-->
    <!--                    <input type="text" class="form-control" id="gender" placeholder="Enter gender" name="gender">-->
    <!--                </div>-->
    <!--                <div class="form-group">-->
    <!--                    <label for="platform">Platform</label>-->
    <!--                    <input type="text" class="form-control" id="platform" placeholder="Enter platform"-->
    <!--                        name="platform">-->
    <!--                </div>-->
    <!--                <div class="form-group">-->
    <!--                    <label for="img">Select image:</label>-->
    <!--                    <input type="file" id="img" name="image">-->
    <!--                </div>-->
    <!--                <div class="form-check">-->
    <!--                    <input type="checkbox" class="form-check-input" id="track-my-visits" name="track_my_visits">-->
    <!--                    <label class="form-check-label" for="track-my-visits">Check me out</label>-->
    <!--                </div>-->
    <!--            </div>-->
                <!-- /.card-body -->

    <!--            <div class="card-footer">-->
    <!--                <button type="submit" class="btn btn-primary">Submit</button>-->
    <!--            </div>-->
    <!--        </form>-->
    <!--    </div>-->
    <!--</div>-->

    <div id="toastsContainerTopRight" class="toasts-top-right fixed">

        <div class="toast bg-success fade show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header"><strong class="mr-auto">Registeration Complete</strong><small></small><button
                    data-dismiss="toast" type="button" class="ml-2 mb-1 close" aria-label="Close"><span
                        aria-hidden="true">×</span></button></div>
            <div class="toast-body">User Created Successfully.</div>
        </div>

        <div class="toast bg-danger fade show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header"><strong class="mr-auto">Registration Failed</strong><small></small><button
                    data-dismiss="toast" type="button" class="ml-2 mb-1 close" aria-label="Close"><span
                        aria-hidden="true">×</span></button></div>
            <div class="toast-body">An Error Occured.</div>
        </div>

    </div>

    <script>
        $(".toast").hide();
        $(document).ready(function() {
            $('#userCreate').submit(function(e) {
                e.preventDefault(); // Prevent default form submission

                // Serialize form data
                var formData = new FormData($(this)[0]);
                var url = $(this).attr("action");

                // Submit form data via AJAX
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    contentType: false,
                    dataType: "json",
                    processData: false,
                    success: function(response) {

                        // var jsonResponse = JSON.parse(response);
                        var status = response.status;

                        if (status == '1') {
                            $(".toast.bg-success").show();
                        } else {
                            $(".toast.bg-danger").show();
                        }

                    }
                });
            });

            // Event delegation to handle click on close button within the toast
            $(document).on('click', '[data-dismiss="toast"]', function() {
                // Find the closest toast element and hide it
                $(this).closest('.toast').toast('hide');
            });
        });
    </script>
@endsection
