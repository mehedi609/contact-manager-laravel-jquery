@extends('layouts.app')

@section('content')
  <div class="card ">
    <div class="card-header">
      <h5>Edit Contact</h5>
    </div>
    <Form action="{{route('contacts.update', $contact->id)}}" method="post" enctype="multipart/form-data">
      @method('PATCH')
      @include('contacts._form', ['contact' => $contact, 'buttonValue' => 'Edit'])
    </form>
  </div>
@stop
