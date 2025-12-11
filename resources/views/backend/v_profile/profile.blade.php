<link href="{{ asset('css/Styles.css') }}" rel="stylesheet">

<section style="background-color: #eee;">
  <div class="container py-5">
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb" class="bg-body-tertiary rounded-3 p-3 mb-4">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('beranda') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/profile') }}">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Profile</li>
          </ol>
        </nav>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
            <img src="{{ Auth::user()->avatar
                           ? asset('storage/img-user/'. Auth::user()->avatar)
                           : 'https://cdn-icons-png.flaticon.com/512/847/847969.png'}}"
                 alt="profile" class="rounded-circle img-fluid" style="width: 150px;">
            <h5 class="my-3">{{ $user->name }}</h5>
          </div>
        </div>
      </div>

      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Email</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{ $user->email }}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">No. Telepon</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{ $user->phone }}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Role</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{ $user->role }}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Status Akun</p>
              </div>
              <div class="col-sm-9">
                    @if($user->status ?? 1)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Non Active</span>
                    @endif
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
        </div>
      </div>
    </div>

  </div>
</section>