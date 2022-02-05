@extends('layouts.admin')

@section('content')
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
      {{ $transaction->user->name }} Transaction Details
    </h1>
  </div>

  <div class="card">
    <div class="card-body">
      <form style="display: none">
        <div class="form-group">
          <label class="font-weight-bold">Transacition ID</label>
          <input class="form-control" type="text" value="{{ $transaction->id }}" readonly>
        </div>
        <div class="form-group">
          <label class="font-weight-bold">Travel Package</label>
          <input class="form-control" type="text" value="{{ $transaction->travel_package->title }}" readonly>
        </div>
        <div class="form-group">
          <label class="font-weight-bold">Customer</label>
          <input class="form-control" type="text" value="{{ $transaction->user->name }}" readonly>
        </div>
        <div class="form-group">
          <label class="font-weight-bold">Additional Visa</label>
          <input class="form-control" type="text" value="{{ $transaction->additional_visa }}" readonly>
        </div>
        <div class="form-group">
          <label class="font-weight-bold">Transaction Total</label>
          <input class="form-control" type="text" value="{{ $transaction->transaction_total }}" readonly>
        </div>
        <div class="form-group">
          <label class="font-weight-bold">Transaction Status</label>
          <input class="form-control" type="text" value="{{ $transaction->transaction_status }}" readonly>
        </div>
      </form>

      <table class="table table-bordered">
        <tr>
          <th>ID</th>
          <td>{{ $transaction->id }}</td>
        </tr>
        <tr>
          <th>Destination</th>
          <td>{{ $transaction->travel_package->title }}</td>
        </tr>
        <tr>
          <th>Customer</th>
          <td>{{ $transaction->user->name }}</td>
        </tr>
        <tr>
          <th>Additional Visa</th>
          <td>${{ number_format($transaction->additional_visa) }}K</td>
        </tr>
        <tr>
          <th>Transaction Total</th>
          <td>${{number_format($transaction->transaction_total) }}K</td>
        </tr>
        <tr>
          <th>Transaction Status</th>
          <td>{{ $transaction->transaction_status }}</td>
        </tr>
        <tr>
          <th>Purchased Travel</th>
          <td>
            <table class="table table-bordered">
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Nationality</th>
                <th>Visa</th>
                <th>DOE Passport</th>
              </tr>
              @foreach ($transaction->transaction_details as $detail)
              <tr>
                <td>{{ $detail->id }}</td>
                <td>{{ $detail->username }}</td>
                <td>{{ $detail->nationality }}</td>
                <td>{{ $detail->is_visa ? '30Days' : 'N/A' }}</td>
                <td>{{ $detail->doe_passport }}</td>
              </tr>
              @endforeach
            </table>
          </td>
        </tr>
      </table>
    </div>
  </div>


</div>
@endsection