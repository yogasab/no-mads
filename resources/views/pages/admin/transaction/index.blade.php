@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Transaction</h1>
  </div>
  @include('components.admin.flash-message')

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Transaction List</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>ID</th>
              <th>Travel Destination</th>
              <th>User</th>
              <th>Visa</th>
              <th>Total</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>ID</th>
              <th>Travel Destination</th>
              <th>User</th>
              <th>Visa</th>
              <th>Total</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </tfoot>
          <tbody>
            @forelse ($transactions as $transaction)
            <tr>
              <td>{{ $transaction->id }}</td>
              <td>{{ $transaction->travel_package->title }}</td>
              <td>{{ $transaction->user->name }}</td>
              <td>{{ $transaction->additional_visa }}</td>
              <td>{{ $transaction->transaction_total }}</td>
              <td>{{ $transaction->transaction_status }}</td>
              <td>
                <a href="{{ route('transaction.show', $transaction->id) }}" class="btn btn-info">
                  <i class="fa fa-eye"></i>
                </a>
                <a href="{{ route('transaction.edit', $transaction->id) }}" class="btn btn-outline-primary">
                  <i class="fa fa-eye"></i>
                </a>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                  <i class="fa fa-trash"></i>
                </button>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                  aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                          Delete Transaction
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        Are you sure want to delete?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                          Close
                        </button>
                        <form action="{{ route('transaction.destroy', $transaction->id) }}" method="POST"
                          class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger">
                            Delete
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
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