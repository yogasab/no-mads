@extends('layouts.admin')

@section('content')
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Add Travel Package</h1>
  </div>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('travel-package.store') }}" method="POST">
        @csrf
        <div class="form-group">
          <label for="title">Place</label>
          <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title"
            placeholder="Enter a destination place" value="{{ old('title') }}">
          @error('title')
          <div class="alert alert-danger mt-2">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-group">
          <label for="location">Location</label>
          <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" id="location"
            placeholder="Enter a location" value="{{ old('location') }}">
          @error('location')
          <div class="alert alert-danger mt-2">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-group">
          <label for="description">Description</label>
          <textarea class="form-control @error('description') is-invalid @enderror" id="editor" rows="3"
            name="description">{{ old('description')  }}</textarea>
          @error('description')
          <div class="alert alert-danger mt-2">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-group">
          <label for="featured_events">Featured Events</label>
          <input type="text" name="featured_events" class="form-control @error('featured_events') is-invalid @enderror"
            id="featured_events" placeholder="Enter a featured events" value="{{ old('featured_events') }}">
          @error('featured_events')
          <div class="alert alert-danger mt-2">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-group">
          <label for="languages">Language</label>
          <input type="text" name="languages" class="form-control @error('languages') is-invalid @enderror"
            id="languages" placeholder="Enter a language" value="{{ old('languages') }}">
          @error('languages')
          <div class="alert alert-danger mt-2">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-group">
          <label for="foods">Foods</label>
          <input type="text" name="foods" class="form-control @error('foods') is-invalid @enderror" id="foods"
            placeholder="Enter a language" value="{{ old('foods') }}">
          @error('foods')
          <div class="alert alert-danger mt-2">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-group">
          <label for="departure_date">Departure Date</label>
          <input type="date" name="departure_date" class="form-control @error('departure_date') is-invalid @enderror"
            id="departure_date" placeholder="Enter a language" value="{{ old('departure_date') }}">
          @error('departure_date')
          <div class="alert alert-danger mt-2">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-group">
          <label for="duration">Duration</label>
          <input type="text" name="duration" class="form-control @error('duration') is-invalid @enderror" id="duration"
            placeholder="Enter a language" value="{{ old('duration') }}">
          @error('duration')
          <div class="alert alert-danger mt-2">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-group">
          <label for="type">Travel Type</label>
          <input type="text" name="type" class="form-control @error('type') is-invalid @enderror" id="type"
            placeholder="Enter a travel type" value="{{ old('type') }}">
          @error('type')
          <div class="alert alert-danger mt-2">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-group">
          <label for="price">Price</label>
          <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" id="price"
            placeholder="Enter a language" value="{{ old('price') }}">
          @error('price')
          <div class="alert alert-danger mt-2">{{ $message }}</div>
          @enderror
        </div>
        <button type="submit" class="btn btn-primary btn-block">Submit</button>
      </form>
    </div>
  </div>


</div>
@endsection

@push('ckeditor-script')
<script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.js"></script>
<script>
  ClassicEditor
          .create( document.querySelector( '#editor' ) )
          .then( editor => {
                  console.log( editor );
          } )
          .catch( error => {
                  console.error( error );
          } );
</script>
@endpush