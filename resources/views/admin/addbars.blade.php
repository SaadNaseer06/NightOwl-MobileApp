@extends('admin.layouts.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Bar</h1>
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
            <form id="userCreate" method="POST" action="{{ route('add.bar') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <!-- Type -->
                    <div class="form-group">
                        <label for="type">Type:</label>
                        <select name="type" value="{{ old('type') }}" required>
                            <option value="bar">bar</option>
                            <option value="club">club</option>
                        </select>
                        @error('type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
            
                    <!-- Image -->
                    <div class="form-group">
                        <label for="image">Image:</label>
                        <input type="file" id="image" name="image" accept="image/*" required>
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
            
                    <!-- Title -->
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
            
                    <!-- Latitude -->
                    <div class="form-group">
                        <label for="latitude">Latitude:</label>
                        <input type="text" id="latitude" name="latitude" value="{{ old('latitude') }}" required>
                        @error('latitude')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
            
                    <!-- Longtitude -->
                    <div class="form-group">
                        <label for="longitude">Longtitude:</label>
                        <input type="text" id="longtitude" name="longtitude" value="{{ old('longtitude') }}" required>
                        @error('longtitude')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
            
                    <!-- Facebook -->
                    <div class="form-group">
                        <label for="facebook">Facebook:</label>
                        <input type="text" id="facebook" placeholder="Optional" name="facebook" value="{{ old('facebook') }}">
                    </div>
            
                    <!-- Twitter -->
                    <div class="form-group">
                        <label for="twitter">Twitter:</label>
                        <input type="text" id="twitter" placeholder="Optional" name="twitter" value="{{ old('twitter') }}">
                    </div>
            
                    <!-- Instagram -->
                    <div class="form-group">
                        <label for="instagram">Instagram:</label>
                        <input type="text" id="instagram" placeholder="Optional" name="instagram" value="{{ old('instagram') }}">
                    </div>
            
                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description">{{ old('description') }}</textarea>
                    </div>
            
                    <!-- Specifications -->
                    <div id="spec-container">
                        <!-- First specification and image field -->
                        <div class="spec-item">
                            <label for="specifications">Specification:</label><br>
                            <input type="text" name="specifications[]" value="{{ old('specifications.0') }}" placeholder="Enter specification">
                            <input type="file" name="spec_image[]">
                            <button type="button" onclick="removeSpecification(this)">Remove</button>
                            @error('specifications.0')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @error('spec_image.0')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="button" onclick="addSpecification()">Add Specification</button><br><br>
                    <button type="submit">Submit</button>
                </div>
            </form>

            <script>
                function addSpecification() {
                    var container = document.getElementById('spec-container');
                    var specItem = document.createElement('div');
                    specItem.className = 'spec-item';
                    
                    // Create specification input
                    var specInput = document.createElement('input');
                    specInput.type = 'text';
                    specInput.name = 'specifications[]';
                    specInput.placeholder = 'Enter specification';
                    specItem.appendChild(specInput);
        
                    var fileInput = document.createElement('input');
                    fileInput.type = 'file';
                    fileInput.name = 'spec_image[]';
                    specItem.appendChild(fileInput);
        
                    // Create remove button
                    var removeButton = document.createElement('button');
                    removeButton.type = 'button';
                    removeButton.textContent = 'Remove';
                    removeButton.onclick = function() {
                        removeSpecification(specItem);
                    };
                    specItem.appendChild(removeButton);
        
                    container.appendChild(specItem);
                }
        
                function removeSpecification(specItem) {
                    specItem.parentNode.removeChild(specItem);
                }
            </script>

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
    <!--        <form id="userCreate" method="POST" action="{{ route('add.bar') }}" enctype="multipart/form-data">-->
    <!--            @csrf-->
    <!--            <div class="card-body">-->
                    <!-- Type -->
    <!--                <div class="form-group">-->
    <!--                    <label for="type">Type:</label>-->
    <!--                    <select name="type" value="{{ old('type') }}" required>-->
    <!--                        <option value="bar">bar</option>-->
    <!--                        <option value="club">club</option>-->
    <!--                    </select>-->
    <!--                    @error('type')-->
    <!--                        <span class="text-danger">{{ $message }}</span>-->
    <!--                    @enderror-->
    <!--                </div>-->
            
                    <!-- Image -->
    <!--                <div class="form-group">-->
    <!--                    <label for="image">Image:</label>-->
    <!--                    <input type="file" id="image" name="image" accept="image/*" required>-->
    <!--                    @error('image')-->
    <!--                        <span class="text-danger">{{ $message }}</span>-->
    <!--                    @enderror-->
    <!--                </div>-->
            
                    <!-- Title -->
    <!--                <div class="form-group">-->
    <!--                    <label for="title">Title:</label>-->
    <!--                    <input type="text" id="title" name="title" value="{{ old('title') }}" required>-->
    <!--                    @error('title')-->
    <!--                        <span class="text-danger">{{ $message }}</span>-->
    <!--                    @enderror-->
    <!--                </div>-->
            
                    <!-- Latitude -->
    <!--                <div class="form-group">-->
    <!--                    <label for="latitude">Latitude:</label>-->
    <!--                    <input type="text" id="latitude" name="latitude" value="{{ old('latitude') }}" required>-->
    <!--                    @error('latitude')-->
    <!--                        <span class="text-danger">{{ $message }}</span>-->
    <!--                    @enderror-->
    <!--                </div>-->
            
                    <!-- Longtitude -->
    <!--                <div class="form-group">-->
    <!--                    <label for="longitude">Longtitude:</label>-->
    <!--                    <input type="text" id="longtitude" name="longtitude" value="{{ old('longtitude') }}" required>-->
    <!--                    @error('longtitude')-->
    <!--                        <span class="text-danger">{{ $message }}</span>-->
    <!--                    @enderror-->
    <!--                </div>-->
            
                    <!-- Facebook -->
    <!--                <div class="form-group">-->
    <!--                    <label for="facebook">Facebook:</label>-->
    <!--                    <input type="text" id="facebook" name="facebook" value="{{ old('facebook') }}">-->
    <!--                </div>-->
            
                    <!-- Twitter -->
    <!--                <div class="form-group">-->
    <!--                    <label for="twitter">Twitter:</label>-->
    <!--                    <input type="text" id="twitter" name="twitter" value="{{ old('twitter') }}">-->
    <!--                </div>-->
            
                    <!-- Instagram -->
    <!--                <div class="form-group">-->
    <!--                    <label for="instagram">Instagram:</label>-->
    <!--                    <input type="text" id="instagram" name="instagram" value="{{ old('instagram') }}">-->
    <!--                </div>-->
            
                    <!-- Description -->
    <!--                <div class="form-group">-->
    <!--                    <label for="description">Description:</label>-->
    <!--                    <textarea id="description" name="description">{{ old('description') }}</textarea>-->
    <!--                </div>-->
            
                    <!-- Specifications -->
    <!--                <div id="spec-container">-->
                        <!-- First specification and image field -->
    <!--                    <div class="spec-item">-->
    <!--                        <label for="specifications">Specification:</label><br>-->
    <!--                        <input type="text" name="specifications[]" value="{{ old('specifications.0') }}" placeholder="Enter specification">-->
    <!--                        <input type="file" name="spec_image[]">-->
    <!--                        <button type="button" onclick="removeSpecification(this)">Remove</button>-->
    <!--                        @error('specifications.0')-->
    <!--                            <span class="text-danger">{{ $message }}</span>-->
    <!--                        @enderror-->
    <!--                        @error('spec_image.0')-->
    <!--                            <span class="text-danger">{{ $message }}</span>-->
    <!--                        @enderror-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--                <button type="button" onclick="addSpecification()">Add Specification</button><br><br>-->
    <!--                <button type="submit">Submit</button>-->
    <!--            </div>-->
    <!--        </form>-->

    <!--        <script>-->
    <!--            function addSpecification() {-->
    <!--                var container = document.getElementById('spec-container');-->
    <!--                var specItem = document.createElement('div');-->
    <!--                specItem.className = 'spec-item';-->
                    
    <!--                var specInput = document.createElement('input');-->
    <!--                specInput.type = 'text';-->
    <!--                specInput.name = 'specifications[]';-->
    <!--                specInput.placeholder = 'Enter specification';-->
    <!--                specItem.appendChild(specInput);-->
        
    <!--                var fileInput = document.createElement('input');-->
    <!--                fileInput.type = 'file';-->
    <!--                fileInput.name = 'spec_image[]';-->
    <!--                specItem.appendChild(fileInput);-->
        
    <!--                var removeButton = document.createElement('button');-->
    <!--                removeButton.type = 'button';-->
    <!--                removeButton.textContent = 'Remove';-->
    <!--                removeButton.onclick = function() {-->
    <!--                    removeSpecification(specItem);-->
    <!--                };-->
    <!--                specItem.appendChild(removeButton);-->
        
    <!--                container.appendChild(specItem);-->
    <!--            }-->
        
    <!--            function removeSpecification(specItem) {-->
    <!--                specItem.parentNode.removeChild(specItem);-->
    <!--            }-->
    <!--        </script>-->

    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
@endsection
