@extends('layouts.admin')

@section('content')
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Edit {{ $travel_gallery->travel_package->title }}</h1>
  </div>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('travel-gallery.update', $travel_gallery->id) }}" method="POST"
        enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="form-group">
          <label for="travel_packages_id">Choose Travel</label>
          <select class="form-control @error('title') is-invalid @enderror" id="travel_packages_id"
            name="travel_packages_id">
            <option>Choose Travel Package</option>
            @foreach ($travel_packages as $travel)
            <option value="{{ $travel->id }}">{{ $travel->title }}</option>
            @endforeach
          </select>
          @error('travel_packages_id')
          <div class="alert alert-danger mt-2">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-group">
          <label for="image" class="form-control-label font-weight-bold">Foto Profil</label>
          <input type="file" name="image" accept="image/*"
            class="form-control-file @error('image') is-invalid @enderror" value="{{ old('image') }}" id="image">
          <img src="{{ Storage::url($travel_gallery->image) }}" id="preview-image-before-upload" style="width: 550px"
            class="img-thumbnail mt-2" alt="">
          @error('image')
          <div class="alert alert-danger mt-2">{{ $message }}</div>
          @enderror
        </div>
        <button type="submit" class="btn btn-outline-success btn-block">Update</button>
      </form>
    </div>
  </div>


</div>
@endsection

@push('ckeditor-script')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script type="text/javascript">
  $(document).ready(function (e) {
   $('#image').change(function(){
    let reader = new FileReader();
     reader.onload = (e) => { 
      $('#preview-image-before-upload').attr('src', e.target.result); 
    }
     reader.readAsDataURL(this.files[0]);  
   });
});
 
</script>
@endpush