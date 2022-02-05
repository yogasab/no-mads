@extends('layouts.admin')

@section('content')
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Edit Transaction Status</h1>
  </div>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('transaction.update', $transaction->id) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="form-group">
          <label for="transaction_status">Transaction Status</label>
          <select class="form-control @error('title') is-invalid @enderror" id="transaction_status"
            name="transaction_status">
            <option value="{{ $transaction->transaction_status }}">
              Don't Change ({{ $transaction->transaction_status }})
            </option>
            <option value="IN_CART">In Cart</option>
            <option value="PENDING">Pending</option>
            <option value="SUCCESS">Success</option>
            <option value="FAILED">Failed</option>
          </select>
          @error('transaction_status')
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