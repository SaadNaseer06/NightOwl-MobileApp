@extends('admin.layouts.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Bar Type</h1>
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
                <h3 class="card-title">Edit Bar Type</h3>
            </div>
            <!-- /.card-header -->
            <!-- Form for editing existing bar type -->
            <form id="editBarForm" method="POST" action="{{ route('bar.update', $bar->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <!-- Type -->
                    <div class="form-group">
                        <label for="type">Type:</label>
                        <input type="text" id="type" name="type" value="{{ $bar->type }}" required>
                    </div>

                    <div class="form-group">
                        <label for="image">Current Image:</label>
                        <img src="{{ $bar->image }}" alt="Bar Image" style="max-width: 200px;"><br>
                        <label for="image">New Image:</label>
                        <input type="file" id="image" name="image" accept="image/*">
                    </div>

                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" value="{{ $bar->title }}" required>
                    </div>

                    <div class="form-group">
                        <label for="latitude">Latitude:</label>
                        <input type="text" id="latitude" name="latitude" value="{{ $bar->latitude }}" required>
                    </div>

                    <div class="form-group">
                        <label for="longtitude">longtitude:</label>
                        <input type="text" id="longtitude" name="longtitude" value="{{ $bar->longtitude }}" required>
                    </div>

                    <div class="form-group">
                        <label for="facebook">Facebook:</label>
                        <input type="text" id="facebook" name="facebook" value="{{ $bar->facebook }}">
                    </div>

                    <div class="form-group">
                        <label for="twitter">Twitter:</label>
                        <input type="text" id="twitter" name="twitter" value="{{ $bar->twitter }}">
                    </div>

                    <div class="form-group">
                        <label for="instagram">Instagram:</label>
                        <input type="text" id="instagram" name="instagram" value="{{ $bar->instagram }}">
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description">{{ $bar->description }}</textarea>
                    </div>
                    <label for="specifications">Specification:</label><br>
                    <div id="spec-container">
                        @if (!is_null($specifications) && count($specifications) > 0)
                            @foreach ($specifications as $spec)
                                <div class="spec-item" id="{{$spec->id}}">
                                   
                                    <input type="text" name="specification[]" value="{{ old('specifications[]', $spec->specification) }}">
                                    
                                    <img src="{{ old('specifications[]' , $spec->spec_image) }}" alt="Bar Image" style="max-width: 200px;">
                                                               <button type="button" class="rbtn" rel="{{$spec->id}}">Remove</button>

                                    
                                    <input type="hidden" name="spec_imag[]" value="{{ old('specifications[]', $spec->spec_image)}}">
                                </div>
                            @endforeach
                        @else
                            <!-- Default specification item if no specifications are available -->
                            <!--<div class="spec-item">-->
                            <!--    <label for="specifications">Specification:</label><br>-->
                            <!--    <input type="text" name="specifications[]" value="">-->
                            <!--    <input type="file" name="spec_images[]" accept="image/*">-->
                            <!--    <button type="button" onclick="removeSpecification(this)">Remove</button>-->
                            <!--</div>-->
                        @endif
                        
                            <div class="spec-item">
                              <label for="specifications">Specification:</label><br>
                              <input type="text" name="specifications[]" value="">
                              <input type="file" name="spec_image[]" accept="image/*">
                              <button type="button" onclick="removeSpecification(this)">Remove</button>
                            </div>
                   <button type="button" onclick="addSpecification()">Add Specification</button><br><br>
                    </div>


                    <button type="submit">Update Bar Type</button>
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
        
                    // Create image input
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
                
                jQuery(".rbtn").click(function(){
                    var id = jQuery(this).attr("rel");
                    jQuery("#"+id).remove();
                })
                
                
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
    <!--            <h3 class="card-title">Edit Bar Type</h3>-->
    <!--        </div>-->
            <!-- /.card-header -->
            <!-- Form for editing existing bar type -->
    <!--        <form id="editBarForm" method="POST" action="{{ route('bar.update', $bar->id) }}" enctype="multipart/form-data">-->
    <!--            @csrf-->
    <!--            @method('PUT')-->

    <!--            <div class="card-body">-->
                    <!-- Type -->
    <!--                <div class="form-group">-->
    <!--                    <label for="type">Type:</label>-->
    <!--                    <input type="text" id="type" name="type" value="{{ $bar->type }}" required>-->
    <!--                </div>-->

    <!--                <div class="form-group">-->
    <!--                    <label for="image">Current Image:</label>-->
    <!--                    <img src="{{ $bar->image }}" alt="Bar Image" style="max-width: 200px;"><br>-->
    <!--                    <label for="image">New Image:</label>-->
    <!--                    <input type="file" id="image" name="image" accept="image/*">-->
    <!--                </div>-->

    <!--                <div class="form-group">-->
    <!--                    <label for="title">Title:</label>-->
    <!--                    <input type="text" id="title" name="title" value="{{ $bar->title }}" required>-->
    <!--                </div>-->

    <!--                <div class="form-group">-->
    <!--                    <label for="latitude">Latitude:</label>-->
    <!--                    <input type="text" id="latitude" name="latitude" value="{{ $bar->latitude }}" required>-->
    <!--                </div>-->

    <!--                <div class="form-group">-->
    <!--                    <label for="longtitude">longtitude:</label>-->
    <!--                    <input type="text" id="longtitude" name="longtitude" value="{{ $bar->longtitude }}" required>-->
    <!--                </div>-->

    <!--                <div class="form-group">-->
    <!--                    <label for="facebook">Facebook:</label>-->
    <!--                    <input type="text" id="facebook" name="facebook" value="{{ $bar->facebook }}">-->
    <!--                </div>-->

    <!--                <div class="form-group">-->
    <!--                    <label for="twitter">Twitter:</label>-->
    <!--                    <input type="text" id="twitter" name="twitter" value="{{ $bar->twitter }}">-->
    <!--                </div>-->

    <!--                <div class="form-group">-->
    <!--                    <label for="instagram">Instagram:</label>-->
    <!--                    <input type="text" id="instagram" name="instagram" value="{{ $bar->instagram }}">-->
    <!--                </div>-->

    <!--                <div class="form-group">-->
    <!--                    <label for="description">Description:</label>-->
    <!--                    <textarea id="description" name="description">{{ $bar->description }}</textarea>-->
    <!--                </div>-->
    <!--                <label for="specifications">Specification:</label><br>-->
    <!--                <div id="spec-container">-->
    <!--                    @if (!is_null($specifications) && count($specifications) > 0)-->
    <!--                        @foreach ($specifications as $spec)-->
    <!--                            <div class="spec-item" id="{{$spec->id}}">-->
                                   
    <!--                                <input type="text" name="specification[]" value="{{ old('specifications[]', $spec->specification) }}">-->
                                    
    <!--                                <img src="{{ old('specifications[]' , $spec->spec_image) }}" alt="Bar Image" style="max-width: 200px;">-->
    <!--                                                           <button type="button" class="rbtn" rel="{{$spec->id}}">Remove</button>-->

                                    
    <!--                                <input type="hidden" name="spec_imag[]" value="{{ old('specifications[]', $spec->spec_image)}}">-->
    <!--                            </div>-->
    <!--                        @endforeach-->
    <!--                    @else-->
                            <!-- Default specification item if no specifications are available -->
                            <!--<div class="spec-item">-->
                            <!--    <label for="specifications">Specification:</label><br>-->
                            <!--    <input type="text" name="specifications[]" value="">-->
                            <!--    <input type="file" name="spec_images[]" accept="image/*">-->
                            <!--    <button type="button" onclick="removeSpecification(this)">Remove</button>-->
                            <!--</div>-->
    <!--                    @endif-->
                        
    <!--                        <div class="spec-item">-->
    <!--                          <label for="specifications">Specification:</label><br>-->
    <!--                          <input type="text" name="specifications[]" value="">-->
    <!--                          <input type="file" name="spec_image[]" accept="image/*">-->
    <!--                          <button type="button" onclick="removeSpecification(this)">Remove</button>-->
    <!--                        </div>-->
    <!--               <button type="button" onclick="addSpecification()">Add Specification</button><br><br>-->
    <!--                </div>-->


    <!--                <button type="submit">Update Bar Type</button>-->
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
                
    <!--            jQuery(".rbtn").click(function(){-->
    <!--                var id = jQuery(this).attr("rel");-->
    <!--                jQuery("#"+id).remove();-->
    <!--            })-->
                
                
    <!--        </script>-->
    <!--    </div>-->
    <!--</div>-->
@endsection
