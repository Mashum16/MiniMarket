<link href="{{ asset('css/Styles.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

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
    /* 1. Background Soft Mesh - Perbaikan agar tidak terpotong */
    .bg-soft-mesh {
        background-color: #f8f9fa;
        background-image: 
            radial-gradient(circle at 20% 20%, #e2f9e1 0%, transparent 40%),
            radial-gradient(circle at 80% 80%, #dcf4ff 0%, transparent 40%),
            radial-gradient(circle at 50% 50%, #f1f0ff 0%, transparent 50%);
        background-size: cover;
        background-position: center;
        background-attachment: fixed; /* Kunci agar background tidak ikut tergulung */
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    /* 2. Glassmorphism Mask - Mengikuti tinggi konten */
    .glass-mask {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(5px);
        flex-grow: 1;
        display: flex;
        align-items: center;
        padding: 40px 0; /* Memberi ruang napas di atas/bawah saat scroll */
    }

    /* 3. Register Form Styling */
    .register-small * {
        font-size: 0.88rem;
    }

    .register-small h2 {
        font-size: 1.5rem !important;
        font-weight: 800;
        letter-spacing: 1px;
        color: #333;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 15px 35px rgba(0,0,0,0.08);
        border-radius: 20px !important;
        overflow: hidden;
    }

    /* Avatar Upload Styling */
    .avatar-wrapper {
        position: relative;
        display: inline-block;
        transition: transform 0.3s ease;
    }

    .avatar-wrapper:hover {
        transform: scale(1.05);
    }

    .avatar-placeholder {
        width: 110px;
        height: 110px;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }

    .upload-icon {
        position: absolute;
        bottom: 5px;
        right: 5px;
        background: #28a745;
        color: white;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #fff;
        font-size: 12px !important;
    }

    /* Form Controls */
    .form-control {
        border-radius: 10px;
        padding: 12px 15px !important;
        border: 1px solid #e1e1e1;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        background-color: #fff;
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.1);
        outline: none;
    }

    /* Button Styling */
    .btn-register {
        background: linear-gradient(135deg, #28a745 0%, #218838 100%);
        border: none;
        color: white !important;
        font-weight: bold;
        padding: 12px !important;
        border-radius: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }
</style>
<section class="min-vh-100 bg-soft-mesh register-small">
    <div class="glass-mask">
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-12 col-md-8 col-lg-5 col-xl-4">
                    
                    <div class="card glass-card">
                        <div class="card-body p-4 p-md-5">

                            <h2 class="text-uppercase text-center mb-4">Join Us</h2>

                            @if ($errors->any())
                                <div class="alert alert-danger p-2" style="font-size: 0.7rem;">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="text-center mb-4">
                                    <div class="avatar-wrapper">
                                        <label for="avatarInput" class="mb-0">
                                            <img id="avatarPreview" 
                                                src="https://ui-avatars.com/api/?name=User&background=f8f9fa&color=28a745&size=128" 
                                                class="rounded-circle avatar-placeholder"
                                                style="cursor: pointer;">
                                            <div class="upload-icon">
                                                <i class="fas fa-camera"></i>
                                            </div>
                                        </label>
                                    </div>
                                    <input type="file" id="avatarInput" name="avatar" accept="image/*" class="d-none" onchange="previewAvatar(event)">
                                    <p class="mt-2 text-muted small">Tap to upload photo</p>
                                </div>

                                <div class="form-outline mb-3">
                                    <input type="text" name="name" placeholder="Full Name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required />
                                </div>

                                <div class="form-outline mb-3">
                                    <input type="email" name="email" placeholder="Email Address" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required />
                                </div>

                                <div class="form-outline mb-3">
                                    <input type="text" name="phone" placeholder="Phone Number" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required />
                                </div>

                                <div class="form-outline mb-3">
                                    <input type="password" name="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" required />
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control" required />
                                </div>

                                <div class="form-check d-flex justify-content-start mb-4">
                                    <input class="form-check-input me-2" type="checkbox" id="termsCheck" required />
                                    <label class="form-check-label text-muted" for="termsCheck" style="font-size: 0.75rem !important;">
                                        I agree to the <a href="#" class="text-success text-decoration-none"><u>Terms of service</u></a>
                                    </label>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-register shadow-sm">
                                        Create Account
                                    </button>
                                </div>

                                <p class="text-center text-muted mt-4 mb-0 small">
                                    Already have an account? 
                                    <a href="{{ route('login') }}" class="fw-bold text-success text-decoration-none">Login here</a>
                                </p>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>