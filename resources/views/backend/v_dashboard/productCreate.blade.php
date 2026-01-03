<link href="{{ asset('css/Styles.css') }}" rel="stylesheet">

<script>
function previewAvatar(event) {
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('avatarPreview').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>

<style>
    .register-small * {
        font-size: 0.85rem !important;   /* KECILKAN SEMUA FONT */
    }

    .register-small h2 {
        font-size: 1.3rem !important;    /* Judul lebih kecil */
        font-weight: bold;
    }

    .register-small .btn {
        font-size: 0.9rem !important;
    }

    .register-small input {
        padding: 10px 12px !important;   /* Sesuaikan padding agar tetap rapi */
    }
</style>

<section class="vh-100 bg-image register-small"
  style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
  <div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-6 col-lg-4 col-xl-4"> <!-- Diperkecil -->
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-4">

              <h2 class="text-uppercase text-center mb-4">Buat Produk</h2>

              <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                  @csrf

                  <!-- Poto produk -->
                  <div class="text-center mb-4">
                   <label for="avatarInput">
                     <img id="avatarPreview" 
                      src="https://via.placeholder.com/120" 
                      class="rounded-circle border"
                      style="width: 120px; height: 120px; object-fit: cover; cursor: pointer;">
                   </label>

                    <input type="file" id="avatarInput" name="image" accept="image/*" 
                     class="d-none" onchange="previewAvatar(event)">
                   <p class="mt-2 text-muted" style="font-size: 14px;">Klik untuk memilih foto produk</p>
                  </div>

                  <div class="form-outline mb-3">
                      <input type="text" name="name" placeholder="Masukkan Nama Produk" class="form-control" required />
                  </div>

                  <div class="form-outline mb-3">
                      <input type="number" name="price" placeholder="Masukkan Harga" class="form-control" required />
                  </div>

                  <div class="form-outline mb-3">
                      <input type="number" name="stock" placeholder="stok" class="form-control" required />
                  </div>

                  <div class="form-outline mb-3">
                      <input type="text" name="description" placeholder="deskripsi produk" class="form-control"/>
                  </div>

                  <div class="d-flex justify-content-center">
                      <button type="submit" class="btn btn-success btn-block btn-sm gradient-custom-4 text-body">
                          Tambah Produk
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
