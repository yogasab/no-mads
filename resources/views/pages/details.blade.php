@extends('layouts.app')

@section('title')
Details
@endsection

@section('content')
<main>
  <section class="section-details-header"></section>
  <section class="section-details-content">
    <div class="container">
      <div class="row">
        <div class="col p-0">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item" aria-current="page">
                Paket Travel
              </li>
              <li class="breadcrumb-item active" aria-current="page">
                Details
              </li>
            </ol>
          </nav>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-8 pl-lg-0">
          <div class="card card-details">
            <h1>{{ $travel->title }}</h1>
            <p>{{ $travel->country }}</p>
            <div class="gallery">
              <div class="xzoom-container">
                <img class="xzoom" id="xzoom-default"
                  src="{{ $travel->travel_galleries->count() ? Storage::url($travel->travel_galleries->first()->image) : '' }}"
                  xoriginal="{{ $travel->travel_galleries->count() ? Storage::url($travel->travel_galleries->first()->image) : '' }}" />
                <div class="xzoom-thumbs">
                  @foreach ($travel->travel_galleries as $travel_galleries)
                  <a href="{{ Storage::url($travel_galleries->image) }}">
                    <img class="xzoom-gallery" width="128" src="{{ Storage::url($travel_galleries->image) }}"
                      xpreview="{{ Storage::url($travel_galleries->image) }}" />
                  </a>
                  @endforeach
                </div>
              </div>
              <h2>Tentang Wisata</h2>
              {!! $travel->description !!}
              <div class="features row">
                <div class="col-md-4">
                  <img src="{{ url('frontend/images/ic_event.png') }}" alt="" class="features-image" />
                  <div class="description">
                    <h3>Featured Ticket</h3>
                    <p>{{ $travel->featured_events }}</p>
                  </div>
                </div>
                <div class="col-md-4 border-left">
                  <img src="{{ url('frontend/images/ic_bahasa.png') }}" alt="" class="features-image" />
                  <div class="description">
                    <h3>Language</h3>
                    <p>{{ $travel->languages }}</p>
                  </div>
                </div>
                <div class="col-md-4 border-left">
                  <img src="{{url('frontend/images/ic_foods.png')}}" alt="" class="features-image" />
                  <div class="description">
                    <h3>Foods</h3>
                    <p>{{ $travel->foods }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card card-details card-right">
            <h2>Members are going</h2>
            <div class="members my-2">
              <img src="{{ url('frontend/images/members.png') }}" alt="" class="w-75" />
            </div>
            <hr />
            <h2>Trip Informations</h2>
            <table class="trip-informations">
              <tr>
                <th width="50%">Departure</th>
                <td width="50%" class="text-right">
                  {{ \Carbon\Carbon::create($travel->departure_date)->format('F n, Y') }}
                </td>
              </tr>
              <tr>
                <th width="50%">Duration</th>
                <td width="50%" class="text-right">{{ $travel->duration }}</td>
              </tr>
              <tr>
                <th width="50%">Type</th>
                <td width="50%" class="text-right">{{ $travel->type }}</td>
              </tr>
              <tr>
                <th width="50%">Price</th>
                <td width="50%" class="text-right">${{ number_format($travel->price) }},00/person</td>
              </tr>
            </table>
          </div>
          <div class="join-container">
            @auth
            <form action="{{ route('checkout.store', $travel->slug) }}" method="POST">
              @csrf
              <button type="submit" class="btn btn-join-now btn-block mt-3 py-2">
                Join Now
              </button>
            </form>
            @endauth
            @guest
            <a href="{{ route('login') }}" class="btn btn-block btn-login mt-3 py-2">
              Login/Register to Join
            </a>
            @endguest
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection

@push('additional-styles')
<link rel="stylesheet" href="{{ url('frontend/libraries/xzoom/dist/xzoom.css') }}" />
@endpush

@push('additional-script')
<script src="{{ url('frontend/libraries/xzoom/dist/xzoom.min.js') }}"></script>
<script>
  $(document).ready(function () {
    $(".xzoom, .xzoom-gallery").xzoom({
      zoomWidth: 500,
      title: false,
      tint: "#333",
      Xoffset: 15,
    });
  });
</script>
@endpush