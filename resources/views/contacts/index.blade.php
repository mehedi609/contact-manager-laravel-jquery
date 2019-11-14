@extends('layouts.app')

@section('content')
  @foreach ($contacts as $contact)

    <div class="card mb-2 box">
      <div class="card-body">
        <div class="row">
          <div class="col-md-10">
            <div class="media">
              <?php
              $photo = $contact->photo;
              $photo = is_null($photo) ? "https://place-hold.it/200" : asset("uploads/{$photo}")
              ?>
              <img
                src="{{$photo}}"
                class="align-self-center mr-3 img-fluid circular-square" alt="..."
                style="width: 100px; height: 100px"
              >
              <div class="media-body mt-2">
                <h4 class="mt-0 text-danger">{{$contact->name}}</h4>
                <address>
                  <strong>{{$contact->company}}</strong><br>
                  {{$contact->email}}
                </address>
              </div>
            </div>
          </div>
          <div class="col-md-2 d-flex align-items-center">
            {{--Edit Contact--}}
            <a href="{{route('contacts.edit', $contact->id)}}" class="btn btn-primary btn-sm mr-2">
              <i class="fas fa-edit"></i>
            </a>
            <form method="post" action="{{route('contacts.destroy', $contact->id)}}" style="display: inline">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger btn-sm" onclick="return confirm('Are your sure?')">
                <i class="fas fa-times-circle"></i>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

  @endforeach

  <ul class="pagination justify-content-center mt-2">
    {!! $contacts->appends(Request::query())->render() !!}
  </ul>
@stop
