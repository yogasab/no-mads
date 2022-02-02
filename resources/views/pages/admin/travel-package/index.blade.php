@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Travel Packages</h1>
    <a href="{{ route('travel-package.create') }}" class="btn btn-sm btn-outline-primary shadow-sm">
      <i class="fa fa-plus fa-sm mr-2"></i>Add Travel Package
    </a>
  </div>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Travel Packages List</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Title</th>
              <th>Location</th>
              <th>Type</th>
              <th>Departure Date</th>
              <th>Price</th>
              <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Title</th>
              <th>Location</th>
              <th>Type</th>
              <th>Departure Date</th>
              <th>Price</th>
              <th>Action</th>
            </tr>
          </tfoot>
          <tbody>
            @forelse ($travels as $travel)
            <tr>
              <td>{{ $travel->title }}</td>
              <td>{{ $travel->location }}</td>
              <td>{{ $travel->type }}</td>
              <td>{{ $travel->departure_date }}</td>
              <td>Rp{{ number_format($travel->price) }}K</td>
              <td>
                <a href="{{ route('travel-package.edit', $travel->id) }}" class="btn btn-info">
                  Edit
                </a>
                <form action="{{ route('travel-package.destroy', $travel->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">
                    <i class="fa fa-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center">There are no Travel yet</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->
@endsection