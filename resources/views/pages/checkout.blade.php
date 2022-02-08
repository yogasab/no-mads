@extends('layouts.checkout')

@section('title')
Checkout
@endsection

@section('content')
<main>
  <section class="section-details-header"></section>
  <section class="section-details-content">
    <div class="container">
      <div class="row">
        <div class="col p-0 pl-3 pl-lg-0">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item" aria-current="page">
                Paket Travel
              </li>
              <li class="breadcrumb-item" aria-current="page">Details</li>
              <li class="breadcrumb-item active" aria-current="page">
                Checkout
              </li>
            </ol>
          </nav>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-8 pl-lg-0">
          <div class="card card-details mb-3">
            <h1>Who is Going?</h1>
            <p>Trip to Ubud, Bali, Indonesia</p>
            <div class="attendee">
              <table class="table table-responsive-sm text-center">
                <thead>
                  <tr>
                    <td scope="col">Picture</td>
                    <td scope="col">Name</td>
                    <td scope="col">Nationality</td>
                    <td scope="col">Visa</td>
                    <td scope="col">Passport</td>
                    <td scope="col"></td>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($transaction->transaction_details as $detail)
                  <tr>
                    <td>
                      <img src="https://ui-avatars.com/api/?name={{ $detail->username }}" height="60"
                        class="rounded-circle" />
                    </td>
                    <td class="align-middle">{{ $detail->username }}</td>
                    <td class="align-middle">{{ $detail->nationality }}</td>
                    <td class="align-middle">{{ $detail->is_visa ? '30 Days' : 'N/A' }}</td>
                    <td class="align-middle">
                      {{ \Carbon\Carbon::createFromDate($detail->doe_passport) >
                      \Carbon\Carbon::now() ? 'Active': 'Inactive' }}
                    </td>
                    <td class="align-middle">
                      <a href="{{ route('checkout.remove-member', $detail->id) }}">
                        <img src="{{ url('frontend/images/ic_remove.png') }}" alt="" />
                      </a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="member mt-3">
              <h2>Add Member</h2>
              <form class="form-inline" method="POST" action="{{ route('checkout.add-member', $transaction->id) }}">
                @csrf
                <label for="username" class="sr-only">Username</label>
                <input type="text" name="username"
                  class="form-control mb-2 mr-sm-2 @error('username') is-invalid @enderror" id="username" required
                  placeholder="Username" value="{{ old('username') }}" />
                @error('username')
                <div class="text-muted">{{ $message }}</div>
                @enderror
                <label for="nationality" class="sr-only">Nationality</label>
                <input type="text" name="nationality" class="form-control mb-2 mr-sm-2" style="width: 50px"
                  id="nationality" required placeholder="Nationality" />

                <label for="is_visa" class="sr-only">Visa</label>
                <select name="is_visa" id="is_visa" required class="custom-select mb-2 mr-sm-2">
                  <option value="" selected>VISA</option>
                  <option value="1">30 Days</option>
                  <option value="0">N/A</option>
                </select>

                <label for="doe_passport" class="sr-only">DOE Passport</label>
                <div class="input-group mb-2 mr-sm-2">
                  <input type="text" class="form-control datepicker" name="doe_passport" id="doe_passport"
                    placeholder="DOE Passport" style="width: 120px" />
                </div>

                <button type="submit" class="btn btn-add-now mb-2 px-4">
                  Add Now
                </button>
              </form>
              <h3 class="mt-2 mb-0">Note</h3>
              <p class="disclaimer mb-0">
                You are only able to invite member that has registered in
                Nomads.
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card card-details card-right">
            <h2>Checkout Information</h2>
            <table class="trip-informations">
              <tr>
                <th width="50%">Members</th>
                <td width="50%" class="text-right">
                  {{ $transaction->transaction_details->count() }} person
                </td>
              </tr>
              <tr>
                <th width="50%">Additional Visa</th>
                <td width="50%" class="text-right">$ {{ $transaction->additional_visa }}</td>
              </tr>
              <tr>
                <th width="50%">Trip Price</th>
                <td width="50%" class="text-right">
                  $ {{ $transaction->travel_package->price }} / person
                </td>
              </tr>
              <tr>
                <th width="50%">Sub Total</th>
                <td width="50%" class="text-right">$ 280,00</td>
              </tr>
              <tr>
                <th width="50%">Total (+Unique)</th>
                <td width="50%" class="text-right text-total">
                  <span class="text-blue">$ {{ $transaction->transaction_total }},</span><span class="text-orange">{{
                    mt_rand(0,1000) }}</span>
                </td>
              </tr>
            </table>

            <hr />
            <h2>Payment Instructions</h2>
            <p class="payment-instructions">
              Please complete your payment before to continue the wonderful
              trip
            </p>
            <div class="bank">
              <div class="bank-item pb-3">
                <img src="{{ url('frontend/images/ic_bank.png') }}" alt="" class="bank-image" />
                <div class="description">
                  <h3>PT Nomads ID</h3>
                  <p>
                    0881 8829 8800
                    <br />
                    Bank Central Asia
                  </p>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="bank-item">
                <img src="{{ url('frontend/images/ic_bank.png') }}" alt="" class="bank-image" />
                <div class="description">
                  <h3>PT Nomads ID</h3>
                  <p>
                    0899 8501 7888
                    <br />
                    Bank HSBC
                  </p>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>
          </div>
          <div class="join-container">
            <a href="{{ route('checkout.success', $transaction->id) }}" class="btn btn-block btn-join-now mt-3 py-2">I
              Have Made
              Payment
            </a>
          </div>
          <div class="text-center mt-3">
            <a href="{{ route('detail', $transaction->travel_package->slug) }}"
              class="btn btn-danger btn-block text-white">Cancel Booking</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection

@push('additional-styles')
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
@endpush

@push('additional-script')
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<script>
  $(document).ready(function () {
      $(".datepicker").datepicker({
        format: 'yyyy-mm-dd',
        uiLibrary: "bootstrap4",
        icons: {
          rightIcon: '<img src="frontend/images/ic_doe.png" alt="" />',
        },
      });
    });
</script>
@endpush