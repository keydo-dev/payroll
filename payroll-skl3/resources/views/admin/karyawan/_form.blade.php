@csrf
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">
            <i class="fas fa-user-edit me-2 text-primary"></i>Informasi Akun
        </h5>
    </div>
    <div class="card-body p-4">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name" class="form-label fw-semibold">
                        Nama Lengkap <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-user text-primary"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror" 
                            id="name" name="name" placeholder="Masukkan nama lengkap"
                            value="{{ old('name', $karyawan->user->name ?? '') }}" required>
                    </div>
                    @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email" class="form-label fw-semibold">
                        Email <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-envelope text-primary"></i>
                        </span>
                        <input type="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" 
                            id="email" name="email" placeholder="Masukkan alamat email"
                            value="{{ old('email', $karyawan->user->email ?? '') }}" required>
                    </div>
                    @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="password" class="form-label fw-semibold">
                        Password 
                        @if(isset($karyawan)) 
                            <span class="badge bg-soft-secondary text-secondary ms-1">Opsional</span>
                        @else 
                            <span class="text-danger">*</span>
                        @endif
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-lock text-primary"></i>
                        </span>
                        <input type="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" 
                            id="password" name="password" placeholder="{{ isset($karyawan) ? 'Kosongkan jika tidak diubah' : 'Masukkan password' }}"
                            {{ !isset($karyawan) ? 'required' : '' }}>
                        <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="password_confirmation" class="form-label fw-semibold">
                        Konfirmasi Password
                        @if(isset($karyawan)) 
                            <span class="badge bg-soft-secondary text-secondary ms-1">Opsional</span>
                        @else 
                            <span class="text-danger">*</span>
                        @endif
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-lock text-primary"></i>
                        </span>
                        <input type="password" class="form-control border-start-0 ps-0" 
                            id="password_confirmation" name="password_confirmation" 
                            placeholder="Konfirmasi password">
                        <button class="btn btn-outline-secondary border-start-0" type="button" id="toggleConfirmPassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">
            <i class="fas fa-id-card me-2 text-primary"></i>Informasi Pribadi
        </h5>
    </div>
    <div class="card-body p-4">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nik" class="form-label fw-semibold">
                        NIK <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-id-card text-primary"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0 @error('nik') is-invalid @enderror" 
                            id="nik" name="nik" placeholder="Masukkan NIK"
                            value="{{ old('nik', $karyawan->nik ?? '') }}" required>
                    </div>
                    @error('nik') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="no_telepon" class="form-label fw-semibold">
                        No Telepon
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-phone text-primary"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0 @error('no_telepon') is-invalid @enderror" 
                            id="no_telepon" name="no_telepon" placeholder="Masukkan nomor telepon"
                            value="{{ old('no_telepon', $karyawan->no_telepon ?? '') }}">
                    </div>
                    @error('no_telepon') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
            </div>
            
            <div class="col-12">
                <div class="form-group">
                    <label for="alamat" class="form-label fw-semibold">
                        Alamat
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-map-marker-alt text-primary"></i>
                        </span>
                        <textarea class="form-control border-start-0 ps-0 @error('alamat') is-invalid @enderror" 
                            id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap">{{ old('alamat', $karyawan->alamat ?? '') }}</textarea>
                    </div>
                    @error('alamat') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">
            <i class="fas fa-briefcase me-2 text-primary"></i>Informasi Pekerjaan
        </h5>
    </div>
    <div class="card-body p-4">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="posisi" class="form-label fw-semibold">
                        Posisi <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-user-tie text-primary"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0 @error('posisi') is-invalid @enderror" 
                            id="posisi" name="posisi" placeholder="Masukkan posisi"
                            value="{{ old('posisi', $karyawan->posisi ?? '') }}" required>
                    </div>
                    @error('posisi') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="tanggal_masuk" class="form-label fw-semibold">
                        Tanggal Masuk <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-calendar-alt text-primary"></i>
                        </span>
                        <input type="date" class="form-control border-start-0 ps-0 @error('tanggal_masuk') is-invalid @enderror" 
                            id="tanggal_masuk" name="tanggal_masuk" 
                            value="{{ old('tanggal_masuk', isset($karyawan->tanggal_masuk) ? \Carbon\Carbon::parse($karyawan->tanggal_masuk)->format('Y-m-d') : '') }}" required>
                    </div>
                    @error('tanggal_masuk') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="gaji_pokok" class="form-label fw-semibold">
                        Gaji Pokok <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-money-bill-wave text-primary"></i>
                        </span>
                        <span class="input-group-text bg-light border-start-0 border-end-0">Rp</span>
                        <input type="number" class="form-control border-start-0 ps-0 @error('gaji_pokok') is-invalid @enderror" 
                            id="gaji_pokok" name="gaji_pokok" placeholder="Masukkan gaji pokok"
                            value="{{ old('gaji_pokok', $karyawan->gaji_pokok ?? '') }}" step="1000" required>
                    </div>
                    @error('gaji_pokok') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mt-4">
    <a href="{{ route('admin.karyawan.index') }}" class="btn btn-outline-secondary px-4">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
    <button type="submit" class="btn btn-primary px-4">
        <i class="fas fa-save me-2"></i>{{ isset($karyawan) ? 'Update Karyawan' : 'Simpan Karyawan' }}
    </button>
</div>

<!-- Add this to your CSS or in a style tag -->
<style>
    .bg-soft-primary {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }
    .bg-soft-secondary {
        background-color: rgba(108, 117, 125, 0.1) !important;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #86b7fe;
    }
    .input-group-text {
        color: #6c757d;
    }
    .form-label {
        margin-bottom: 0.5rem;
    }
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-2px);
    }
</style>

<!-- Add this to your JavaScript section -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    
    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
    
    // Toggle confirm password visibility
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const confirmPassword = document.getElementById('password_confirmation');
    
    toggleConfirmPassword.addEventListener('click', function() {
        const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPassword.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
});
</script>