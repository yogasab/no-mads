@extends('layouts.checkout-success')

@section('content')
<main>
  <div class="section-success d-flex align-items-center">
    <div class="col text-center">
      <img src="{{ url('frontend/images/ic_mail.png') }}" alt="" />
      <h1>Oops!</h1>
      <p>
        Apparently your transaction is failed <br />
        please contact our representative for more information
      </p>
      <a href="{{ route('home') }}" class="btn btn-home-page mt-3 px-5">
        Home Page
      </a>
    </div>
  </div>
</main>
@endsection