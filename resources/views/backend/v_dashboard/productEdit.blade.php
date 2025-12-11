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

              <form action="{{ route('products.update', $product->id) }}" 
                    method="POST" 
                    enctype="multipart/form-data">

                  @csrf
                  @method('PUT')

                  <!-- preview poto yang di ubah (ini juga sama wkwk) -->
                  <div class="text-center mb-4">
                   <label for="imageInput">
                     <img id="imagePreview" 
                      src="{{ $product->image 
                        ? asset('storage/img-product/' . $product->image) 
                        : asset('default-avatar.png') }}"
                      class="rounded-circle border"
                      style="width: 120px; height: 120px; object-fit: cover; cursor: pointer;">
                   </label>

                    <input type="file" id="imageInput" name="image" accept="image/*" 
                     class="d-none" onchange="previewAvatar(event)">
                   <p class="mt-2 text-muted" style="font-size: 14px;">Klik untuk mengganti foto profil</p>
                  </div>

                  <div class="form-outline mb-3">
                      <input type="text" name="name" placeholder="Masukkan Nama Produk"
                             value="{{ $product->name }}" class="form-control" required />
                  </div>

                  <div class="form-outline mb-3">
                      <input type="number" name="price" 
                             placeholder="Masukkan Harga"
                             value="{{ $product->price }}"
                             class="form-control" required />
                  </div>

                  <div class="form-outline mb-3">
                      <input type="number" name="stock"
                             placeholder="Masukkan Stok"
                             value="{{ $product->stock }}"
                             class="form-control" required/>
                  </div>

                  <div class="form-outline mb-3">
                      <input type="text" name="description"
                             placeholder="deskripsi produk"
                             value="{{ $product->description }}"
                             class="form-control" />
                  </div>

                  <div class="d-flex justify-content-center">
                      <button type="submit" class="btn btn-success btn-block btn-sm gradient-custom-4 text-body">
                          Update Produk
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

<!-- script buat preview poto (cuman buat nampilin poto profil kalo di ganti tapi klo disuruh jelasin wasalam) -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("imageInput");
    const preview = document.getElementById("imagePreview");

    input.addEventListener("change", function (event) {
        const file = event.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
        }
    });
});
</script>
