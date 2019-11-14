@extends('layouts.app')

@section('content')
  <div class="card ">
    <div class="card-header">
      <h5>Add Contact</h5>
    </div>
    <Form action="{{route('contacts.store')}}" method="post" enctype="multipart/form-data">
      @include('contacts._form', ['contact' => $contact, 'buttonValue' => 'Save'])
    </form>
  </div>
@stop
