@csrf

<div class="card-body">
  <div class="row">
    <div class="col-md-8">

      <div class="form-group row">
        <label for="name" class="col-sm-3 col-form-label">Name</label>
        <div class="col-sm-8">
          <input
            type="text"
            class="form-control @error ('name') is-invalid @enderror"
            name="name" id="name"
            value="{{empty($contact) ? old('name') : old('name', $contact->name)}}"
            placeholder="Enter Name"
          >
          @error ('name')
          <div class="invalid-feedback">
            <strong>{{$message}}</strong>
          </div>
          @enderror
        </div>
      </div>

      <div class="form-group row">
        <label for="company" class="col-sm-3 col-form-label">Company</label>
        <div class="col-sm-8">
          <input
            type="text"
            class="form-control @error ('company') is-invalid @enderror"
            name="company" id="company"
            value="{{empty($contact) ? old('company') : old('company', $contact->company)}}"
            placeholder="Enter Company"
          >
          @error ('company')
          <div class="invalid-feedback">
            <strong>{{$message}}</strong>
          </div>
          @enderror
        </div>
      </div>

      <div class="form-group row">
        <label for="email" class="col-sm-3 col-form-label">Email</label>
        <div class="col-sm-8">
          <input
            type="email"
            class="form-control @error ('email') is-invalid @enderror"
            name="email" id="email"
            value="{{empty($contact) ? old('email') : old('email', $contact->email)}}"
            placeholder="Enter Email"
          >
          @error ('email')
          <div class="invalid-feedback">
            <strong>{{$message}}</strong>
          </div>
          @enderror
        </div>
      </div>

      <div class="form-group row">
        <label for="phone" class="col-sm-3 col-form-label">Phone</label>
        <div class="col-sm-8">
          <input
            type="text"
            class="form-control"
            name="phone" id="phone"
            value="{{empty($contact) ? old('phone') : old('phone', $contact->phone)}}"
            placeholder="Enter Phone Number"
          >
        </div>
      </div>

      <div class="form-group row">
        <label for="address" class="col-sm-3 col-form-label">Address</label>
        <div class="col-sm-8">
                <textarea
                  class="form-control"
                  name="address" id="address"
                  rows="3"
                  placeholder="Enter Address"
                >{{empty($contact) ? old('address') : old('address', $contact->address)}}</textarea>
        </div>
      </div>

      <div class="form-group row">
        <label for="group_id" class="col-sm-3 col-form-label">Group</label>
        <div class="col-sm-5">
          <select class="form-control" name="group_id" id="group_id">
            <option value="">Select Group</option>
            @foreach (\App\Group::all() as $group)
              @if (empty($contact))
                @if (\Illuminate\Support\Facades\Input::old('group_id') == $group->id)
                  <option value="{{$group->id}}" selected>{{$group->name}}</option>
                @else
                  <option value="{{$group->id}}">{{$group->name}}</option>
                @endif
              @elseif ($contact->group_id == $group->id)
                <option value="{{$group->id}}" selected>{{$group->name}}</option>
              @else
                <option value="{{$group->id}}">{{$group->name}}</option>
              @endif
            @endforeach
          </select>
        </div>

        <div class="col-sm-3">
          <a href="#" id="add-group-button" class="btn btn-outline-secondary btn-block">Add Group</a>
        </div>
      </div>

      <div class="form-group row" id="add-new-group" style="display: none">
        <div class="offset-md-3 col-md-8">
          <div class="input-group">
            <input
              type="text"
              name="new_group"
              id="new_group"
              class="form-control"
            >
            <span class="input-group-append">
                <a href="#" id="add-new-btn" class="btn btn-primary" type="submit">
                  <i class="fas fa-check"></i>
                </a>
              </span>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4 d-flex align-items-center">
      <div class="fileinput fileinput-new" data-provides="fileinput">
        <div class="fileinput-new img-thumbnail" style="width: 200px; height: 200px;">
          <?php
          if (empty($contact)) {
            $photo = "https://place-hold.it/200";
          } else {
            $photo = $contact->photo;
            $photo = is_null($photo) ? "https://place-hold.it/300" : asset("uploads/{$photo}");
          }
          ?>
          <img
            src="{{$photo}}"
            class="align-self-center mr-3 img-fluid circular-square" alt="..."
          >
        </div>
        <div class="fileinput-preview fileinput-exists img-thumbnail"
             style="max-width: 200px; max-height: 200px;"></div>
        <div>
          <span class="btn btn-outline-secondary btn-file">
            <span class="fileinput-new">
                Select image
            </span>
            <span class="fileinput-exists">
                Change
            </span>
            <input type="file" name="photo">
          </span>
          <a
            href="#"
            class="btn btn-outline-secondary fileinput-exists"
            data-dismiss="fileinput"
          >
            Remove
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="card-footer text-muted">
  <div class="row">
    <div class="col-md-8">
      <div class="row">
        <div class="offset-md-3 col-md-9">
          <button type="submit" class="btn btn-primary">{{$buttonValue}}</button>
          <a href="{{route('contacts.index')}}" class="btn btn-danger ml-2">Cancel</a>
        </div>
      </div>
    </div>
  </div>
</div>

@section('script-add-group')
  <script>
    $('#add-new-group').hide();
    $('#add-group-button').click(function () {
        $('#add-new-group').slideToggle(function () {
            $('#new_group').focus();
        });
        return false;
    });

    $('#add-new-btn').click(function (event) {
        // event.preventDefault();
        $.ajax({
            url: "{{route('groups.store')}}",
            method: 'post',
            data: {
                name: $('#new_group').val(),
                _token: "{{csrf_token()}}"
            },
            success: function (response) {
                console.log(response)
            },
            error: function (error) {
                const err_msg = error.responseJSON.errors.name[0];

                if(err_msg) {
                    const inputGroup = $('#new_group').closest('.input-group');
                    inputGroup.next('.text-danger').remove();

                    inputGroup
                        .css({'border': '1px solid red', 'borderRadius': '5px'})
                        .after(`<p class="text-danger">${err_msg}</p>`)
                }
            }
        })
    })
  </script>
@stop
