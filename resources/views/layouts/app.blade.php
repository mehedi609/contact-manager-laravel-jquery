<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('font-awesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jasny-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <title>My Contact</title>
  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
      <a class="navbar-brand" href="#">Navbar</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse " id="navbarNavAltMarkup">
        <div class="navbar-nav ml-auto">

          <form action="{{route('contacts.index')}}" class="form-inline my-2 my-lg-0">
            <div class="input-group">
              <input
                type="text"
                name="term"
                value="{{Request::get('term')}}"
                class="form-control"
                placeholder="Search..."
              >
              <span class="input-group-append">
                <button class="btn btn-primary" type="submit">
                  <i class="fas fa-search"></i>
                </button>
              </span>
            </div>
          </form>

          <a
            href="{{route('contacts.create')}}"
            class="nav-item nav-link btn btn-outline-success ml-2"
          >
            <i class="fas fa-plus"></i> Add Contact
          </a>
        </div>
      </div>
    </nav>

    <div class="container">
      <div class="row">

        <div class="col-md-3">
          <div class="list-group">
            <?php $group_id = Request::get('group_id')?>
            <a
              href="{{route('contacts.index')}}"
              class="list-group-item list-group-item-action {{empty($group_id) ? 'active' : ''}}"
            >
              All Contact <span class="badge {{empty($group_id) ? 'badge-light' : 'badge-secondary'}} badge-light float-right">{{\App\Contact::count()}}</span>
            </a>

            @foreach (\App\Group::all() as $group)
              <a
                href="{{route('contacts.index', ['group_id' => $group->id])}}"
                class="list-group-item list-group-item-action {{($group_id == $group->id) ? 'active' : ''}} "
              >
                {{$group->name}} <span class="badge {{($group_id == $group->id) ? 'badge-light' : 'badge-secondary'}} badge-secondary float-right">{{$group->contacts->count()}}</span>
              </a>
            @endforeach

          </div>
        </div> {{-- /.col-md-3 --}}

        <div class="col-md-9">
          @yield('content')
        </div>
      </div>
    </div>

    <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
    <script src="{{asset('js/popper-1.15.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/jasny-bootstrap.min.js')}}"></script>
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.0.1/jquery-migrate.min.js"></script>
    @include('sweetalert::alert')
    <script>
      $(function () {
          console.log('ahoasdf')
          $("input[name=term]").autocomplete({
              source: "{{route('contacts.autocomplete')}}",
              minLength: 3,
              select: function (event, ui) {
                  $(this).val(ui.item.value)
              }
          })
      })
    </script>
    @yield('script-add-group')
  </body>
</html>
