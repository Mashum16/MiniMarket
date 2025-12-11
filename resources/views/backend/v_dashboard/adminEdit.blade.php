<link href="{{ asset('css/Styles.css') }}" rel="stylesheet">

<style>
    .register-small * {
        font-size: 0.85rem !important;
    }
    .register-small h2 {
        font-size: 1.3rem !important;
        font-weight: bold;
    }
    .register-small .btn {
        font-size: 0.9rem !important;
    }
    .register-small input {
        padding: 10px 12px !important;
    }
</style>

<section class="vh-100 bg-image register-small"
  style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">

  <div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-6 col-lg-4 col-xl-4">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-4">

              <h2 class="text-uppercase text-center mb-4">Edit User</h2>

              <form action="{{ route('admin.update', $index->id) }}" 
                    method="POST" 
                    enctype="multipart/form-data">

                  @csrf
                  @method('PUT')

                  <!-- preview poto yang di ubah (gw gapaham tapi berhasil pake kode yang di create) -->
                  <div class="text-center mb-4">
                   <label for="avatarInput">
                     <img id="avatarPreview" 
                      src="{{ $index->avatar 
                        ? asset('storage/img-user/' . $index->avatar) 
                        : asset('default-avatar.png') }}"
                      class="rounded-circle border"
                      style="width: 120px; height: 120px; object-fit: cover; cursor: pointer;">
                   </label>

                    <input type="file" id="avatarInput" name="avatar" accept="image/*" 
                     class="d-none" onchange="previewAvatar(event)">
                   <p class="mt-2 text-muted" style="font-size: 14px;">Klik untuk mengganti foto profil</p>
                  </div>

                  <div class="form-outline mb-3">
                      <input type="text" name="name" placeholder="Masukkan Nama"
                             value="{{ $index->name }}" class="form-control" required />
                  </div>

                  <div class="form-outline mb-3">
                      <input type="email" name="email" placeholder="Masukkan Email"
                             value="{{ $index->email }}" class="form-control" required />
                  </div>

                  <div class="form-outline mb-3">
                      <input type="text" name="phone" placeholder="Masukkan Nomor Telepon"
                             value="{{ $index->phone }}" class="form-control"/>
                  </div>

                  <div class="form-outline mb-3">
                      <input type="password" name="password"
                             placeholder="Masukkan Password (Kosongkan jika tidak diubah)"
                             class="form-control" />
                  </div>

                  <div class="form-outline mb-3">
                      <input type="password" name="password_confirmation"
                             placeholder="Ulangi Password (Kosongkan jika tidak diubah)"
                             class="form-control" />
                  </div>

                  <div class="form-outline mb-3">
                      <select name="role" class="form-control" required>
                          <option value="customer" {{ $index->role == 'customer' ? 'selected' : '' }}>Customer</option>
                          <option value="admin" {{ $index->role == 'admin' ? 'selected' : '' }}>Admin</option>
                          <option value="staff" {{ $index->role == 'staff' ? 'selected' : '' }}>Staff</option>
                      </select>
                  </div>

                  <div class="d-flex justify-content-center">
                      <button type="submit" class="btn btn-success btn-block btn-sm gradient-custom-4 text-body">
                          Update User
                      </button>
                  </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SCRIPT PREVIEW (WAJIB DI BAWAH) -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("avatarInput");
    const preview = document.getElementById("avatarPreview");

    input.addEventListener("change", function (event) {
        const file = event.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
        }
    });
});
</script>
