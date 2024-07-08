@extends('admin.layouts.app')

@section('content')
<?php use App\Models\User; ?>

<div class="content-wrapper">
    <div class="content">
          <div class="card card-primary">
            <h1>Bar Details</h1>
            <span><h4>Name: </h4><p>{{ $bar->title }}</p></span>
            <span><h4>Type: </h4><p>{{ $bar->type }}</p></span>
            <span><h4>Image: </h4><img src="{{ $bar->image }}" style="width: 100px;"></span>
            <span><h4>Latitude: </h4><p>{{ $bar->latitude }}</p></span>
            <span><h4>Longitude: </h4><p>{{ $bar->longtitude }}</p></span>
            <span><h4>Facebook: </h4><p>{{ $bar->facebook }}</p></span>
            <span><h4>Twitter: </h4><p>{{ $bar->twitter }}</p></span>
            <span><h4>Instagram: </h4><p>{{ $bar->instagram }}</p></span>
            <span><h4>Description: </h4><p>{{ $bar->description }}</p></span>
            <h3>Bar Specifications</h3>
            @foreach ($specifications as $spec)
                <div class="spec-item" id="{{$spec->id}}">
                    <input type="text" name="specification[]" value="{{ old('specifications[]', $spec->specification) }}">
                    <img src="{{ old('specifications[]' , $spec->spec_image) }}" alt="Bar Image" style="max-width: 200px;">
                    <input type="hidden" name="spec_imag[]" value="{{ old('specifications[]', $spec->spec_image)}}">
                </div>
            @endforeach
            <h3>Bar Ratings</h3>
            <table>
                <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Rating</th>
                    <th>Comments</th>
                </tr>
                @foreach ($reviews as $review)
                    <div>
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ User::get_name($review->user_id) }}</td>
                            <td>{{ $review->rating }}</td>
                            <td>{{ $review->comment }}</td>
                        </tr>
                    </div>
                @endforeach
            </table>
        </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>






<!--<div class="container">-->
<!--    <h1>Bar Details</h1>-->
<!--    <span><h4>Name: </h4><p>{{ $bar->title }}</p></span>-->
<!--    <span><h4>Type: </h4><p>{{ $bar->type }}</p></span>-->
<!--    <span><h4>Image: </h4><img src="{{ $bar->image }}" style="width: 100px;"></span>-->
<!--    <span><h4>Latitude: </h4><p>{{ $bar->latitude }}</p></span>-->
<!--    <span><h4>Longitude: </h4><p>{{ $bar->longtitude }}</p></span>-->
<!--    <span><h4>Facebook: </h4><p>{{ $bar->facebook }}</p></span>-->
<!--    <span><h4>Twitter: </h4><p>{{ $bar->twitter }}</p></span>-->
<!--    <span><h4>Instagram: </h4><p>{{ $bar->instagram }}</p></span>-->
<!--    <span><h4>Description: </h4><p>{{ $bar->description }}</p></span>-->
<!--    <h3>Bar Specifications</h3>-->
<!--    @foreach ($specifications as $spec)-->
<!--        <div class="spec-item" id="{{$spec->id}}">-->
<!--            <input type="text" name="specification[]" value="{{ old('specifications[]', $spec->specification) }}">-->
<!--            <img src="{{ old('specifications[]' , $spec->spec_image) }}" alt="Bar Image" style="max-width: 200px;">-->
<!--            <input type="hidden" name="spec_imag[]" value="{{ old('specifications[]', $spec->spec_image)}}">-->
<!--        </div>-->
<!--    @endforeach-->
<!--    <h3>Bar Ratings</h3>-->
<!--    <table>-->
<!--        <tr>-->
<!--            <th>#</th>-->
<!--            <th>User Name</th>-->
<!--            <th>Rating</th>-->
<!--            <th>Comments</th>-->
<!--        </tr>-->
<!--        @foreach ($reviews as $review)-->
<!--            <div>-->
<!--                <tr>-->
<!--                    <td>{{ $loop->index + 1 }}</td>-->
<!--                    <td>{{ User::get_name($review->user_id) }}</td>-->
<!--                    <td>{{ $review->rating }}</td>-->
<!--                    <td>{{ $review->comment }}</td>-->
<!--                </tr>-->
<!--            </div>-->
<!--        @endforeach-->
<!--    </table>-->
<!--</div>-->
@endsection
