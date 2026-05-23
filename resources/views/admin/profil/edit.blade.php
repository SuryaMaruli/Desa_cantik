@extends('layouts.admin')

@section('title', 'Profil Saya - Admin')

@section('page-title', 'Profil Saya')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Profil Saya</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data" id="profilForm">
                        @csrf
                        @method('PUT')
                        
<div class="row mb-4">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <label for="foto_profil" class="form-label d-block">Foto Profil</label>
                                    <div class="d-flex justify-content-center gap-4 mb-3">
                                        <!-- Foto Lama -->
                                        <div class="text-center">
                                            <small class="text-muted d-block mb-2">Foto Saat Ini</small>
                                            <div class="mb-2">
                                                @if($user->foto_profil)
                                                    <img src="{{ asset('storage/' . $user->foto_profil) }}"
                                                         alt="Foto Profil Saat Ini" 
                                                         class="rounded-circle"
                                                         style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #F6903A;"
                                                         data-bs-toggle="modal"
                                                         data-bs-target="#fotoProfilModal"
                                                         onclick="document.getElementById('fotoProfilFull').src = this.src">
                                                @else
                                                    <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center text-white" 
                                                         style="width: 120px; height: 120px; font-size: 48px;">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        
<!-- Foto Baru (Preview) -->
                                        <div class="text-center">
                                            <small class="text-muted d-block mb-2">Foto Baru</small>
<div class="mb-2" style="width: 120px; height: 120px;">
<img id="previewNewPhoto"
                                                     alt="Foto Baru" 
                                                     class="rounded-circle"
                                                     style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #10b981; display: none;"
                                                     data-bs-toggle="modal"
                                                     data-bs-target="#fotoProfilModal"
                                                     onclick="document.getElementById('fotoProfilFull').src = this.src">
                                            </div>
                                        </div>
                                    </div>
                                    <small class="text-muted d-block">Klik foto untuk memperbesar</small>
                                    <input type="file" class="form-control mt-2" id="foto_profil" name="foto_profil" 
                                           accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                                           style="max-width: 300px; margin: 0 auto;"
onchange="window.previewNewPhoto(this)">
                                    <small class="text-muted d-block mt-1">Format: JPEG, PNG, JPG, GIF, WebP. Max 2MB.</small>
                                    @error('foto_profil')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Modal untuk melihat foto profil penuh -->
                        <div class="modal fade" id="fotoProfilModal" tabindex="-1" aria-labelledby="fotoProfilModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="fotoProfilModalLabel">Foto Profil</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        @if($user->foto_profil)
                                            <img src="{{ asset('storage/' . $user->foto_profil) }}"
                                                 alt="Foto Profil Penuh" 
                                                 id="fotoProfilFull"
                                                 class="img-fluid"
                                                 style="max-height: 70vh; object-fit: contain;">
                                        @else
                                            <p class="text-muted">Tidak ada foto profil</p>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password Baru <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
                                    <input type="password" class="form-control" id="password" name="password" 
                                           placeholder="Masukkan password baru">
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" 
                                           name="password_confirmation" placeholder="Konfirmasi password baru">
                                    @error('password_confirmation')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary me-2">
                                <i class='bx bx-arrow-back'></i> Batal
                            </a>
<button type="button" class="btn btn-primary" id="saveBtn" onclick="showConfirmSave()" disabled>
                                <i class='bx bx-save'></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Confirmation Modal -->
<div class="modal fade" id="confirmSaveModal" tabindex="-1" aria-labelledby="confirmSaveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center pb-4">
                <div class="mb-3">
                    <div class="confirm-icon-wrapper">
                        <i class='bx bx-help-circle'></i>
                    </div>
                </div>
                <h5 class="modal-title mb-2" id="confirmSaveModalLabel">Konfirmasi Penyimpanan</h5>
                <p class="text-muted mb-0">Apakah Anda yakin ingin menyimpan perubahan pada profil ini?</p>
            </div>
            <div class="modal-footer border-0 pt-0 justify-content-center">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                    <i class='bx bx-x'></i> Batal
                </button>
                <button type="button" class="btn btn-primary px-4" id="confirmSaveBtn" onclick="submitForm()">
                    <i class='bx bx-check'></i> Ya, Simpan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Preview foto baru
    window.previewNewPhoto = function(input) {
        console.log('previewNewPhoto called');
        var preview = document.getElementById('previewNewPhoto');
        
        console.log('preview element:', preview);
        console.log('files:', input.files);
        
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                console.log('FileReader loaded, result:', e.target.result);
                preview.src = e.target.result;
                preview.style.display = 'inline-block';
            };
            
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
        }
        
        // Check for changes after photo selection
        if (typeof checkForChanges === 'function') {
            checkForChanges();
        }
    }

    function showNotification(message, type = 'success') {
        document.querySelectorAll('.custom-notification').forEach(function(n) { n.remove(); });

        var notification = document.createElement('div');
        var config = {
            success: { icon: 'bx-check-circle', bg: 'linear-gradient(135deg, #10b981, #059669)', color: '#fff' },
            error: { icon: 'bx-x-circle', bg: 'linear-gradient(135deg, #ef4444, #dc2626)', color: '#fff' },
            warning: { icon: 'bx-exclamation-circle', bg: 'linear-gradient(135deg, #f59e0b, #d97706)', color: '#fff' },
            info: { icon: 'bx-info-circle', bg: 'linear-gradient(135deg, #3b82f6, #2563eb)', color: '#fff' }
        };
        var c = config[type] || config.success;

        notification.className = 'custom-notification';
        notification.style.cssText = `
            position: fixed; top: 20px; right: 20px;
            background: ${c.bg}; color: ${c.color};
            padding: 16px 24px; border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2); z-index: 10000;
            font-family: 'Poppins', sans-serif; font-size: 14px;
            display: flex; align-items: center; gap: 12px;
            animation: slideInRight 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            min-width: 280px; max-width: 400px;
        `;
        notification.innerHTML = `
            <i class="bx ${c.icon}" style="font-size: 24px;"></i>
            <span style="font-weight: 500;">${message}</span>
        `;

        document.body.appendChild(notification);

        setTimeout(function() {
            notification.style.transform = 'translateX(120%)';
            notification.style.opacity = '0';
            notification.style.transition = 'all 0.4s ease';
            setTimeout(function() { notification.remove(); }, 400);
        }, 3500);
    }

    function showConfirmSave() {
        var form = document.getElementById('profilForm');
        if (form && !form.checkValidity()) {
            form.reportValidity();
            showNotification('Lengkapi data profil terlebih dahulu.', 'warning');
            return;
        }

        var password = document.getElementById('password');
        var confirmation = document.getElementById('password_confirmation');
        if (password && confirmation && password.value && password.value !== confirmation.value) {
            showNotification('Konfirmasi password tidak sama.', 'warning');
            confirmation.focus();
            return;
        }

        var confirmModal = document.getElementById('confirmSaveModal');
        if (confirmModal) {
            var modal = new bootstrap.Modal(confirmModal);
            modal.show();
        }
    }
    
    function submitForm() {
        var submitBtn = document.getElementById('confirmSaveBtn');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Menyimpan...';
        }

        var modalEl = document.getElementById('confirmSaveModal');
        if (modalEl) {
            var modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) {
                modal.hide();
            }
        }
        
        var form = document.getElementById('profilForm');
        if (form) {
            form.submit();
        } else {
            // Fallback: try to find form by method
            var forms = document.querySelectorAll('form[method="POST"]');
            if (forms.length > 0) {
                forms[forms.length - 1].submit();
            }
        }
    }
    
// Make functions available globally immediately
    window.showConfirmSave = showConfirmSave;
    window.submitForm = submitForm;

    // Fungsi untuk memeriksa apakah ada perubahan
    function checkForChanges() {
        var saveBtn = document.getElementById('saveBtn');
        if (!saveBtn) return;
        
        var nameInput = document.getElementById('name');
        var emailInput = document.getElementById('email');
        var passwordInput = document.getElementById('password');
        var confirmationInput = document.getElementById('password_confirmation');
        var fotoInput = document.getElementById('foto_profil');
        var previewNewPhoto = document.getElementById('previewNewPhoto');
        
        // Get original values from server-rendered data
        var originalName = @json($user->name);
        var originalEmail = @json($user->email);
        
        // Check if any field has been modified
        var hasNameChanged = nameInput && nameInput.value !== originalName;
        var hasEmailChanged = emailInput && emailInput.value !== originalEmail;
        var hasPasswordChanged = passwordInput && passwordInput.value !== '';
        var hasConfirmationChanged = confirmationInput && confirmationInput.value !== '';
        var hasFotoChanged = fotoInput && fotoInput.files && fotoInput.files.length > 0;
        
        // Check if any change was made
        var hasChanges = hasNameChanged || hasEmailChanged || hasPasswordChanged || hasConfirmationChanged || hasFotoChanged || (passwordInput && passwordInput.value !== '' && confirmationInput && confirmationInput.value !== '');
        
        if (hasChanges) {
            saveBtn.disabled = false;
        } else {
            saveBtn.disabled = true;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Set initial disabled state
        var saveBtn = document.getElementById('saveBtn');
        if (saveBtn) {
            saveBtn.disabled = true;
        }
        
        var flashMessages = [
            @if(session('success'))
                { message: @json(session('success')), type: 'success' },
            @endif
            @if(session('error'))
                { message: @json(session('error')), type: 'error' },
            @endif
            @if($errors->any())
                { message: @json($errors->first()), type: 'error' },
            @endif
        ];

        flashMessages.forEach(function(flash, index) {
            setTimeout(function() {
                showNotification(flash.message, flash.type);
            }, index * 500);
        });
        
        // Add change listeners to all form fields
        var nameInput = document.getElementById('name');
        var emailInput = document.getElementById('email');
        var passwordInput = document.getElementById('password');
        var confirmationInput = document.getElementById('password_confirmation');
        var fotoInput = document.getElementById('foto_profil');
        
        if (nameInput) {
            nameInput.addEventListener('input', checkForChanges);
            nameInput.addEventListener('change', checkForChanges);
        }
        if (emailInput) {
            emailInput.addEventListener('input', checkForChanges);
            emailInput.addEventListener('change', checkForChanges);
        }
        if (passwordInput) {
            passwordInput.addEventListener('input', checkForChanges);
            passwordInput.addEventListener('change', checkForChanges);
        }
        if (confirmationInput) {
            confirmationInput.addEventListener('input', checkForChanges);
            confirmationInput.addEventListener('change', checkForChanges);
        }

var fotoInput = document.getElementById('foto_profil');
        if (fotoInput) {
            fotoInput.addEventListener('change', function() {
                var file = this.files && this.files[0];
                if (!file) {
                    // File cleared, reset preview
                    window.previewNewPhoto(this);
                    checkForChanges();
                    return;
                }

                var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
                if (allowedTypes.indexOf(file.type) === -1) {
                    this.value = '';
                    showNotification('Format foto harus JPEG, PNG, JPG, GIF, atau WebP.', 'warning');
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    this.value = '';
                    showNotification('Ukuran foto profil maksimal 2 MB.', 'warning');
                    return;
                }

                // Valid file - show preview
                window.previewNewPhoto(this);
                checkForChanges();
                showNotification('Foto profil baru siap disimpan.', 'info');
            });
        }
    });
    
    // Keyboard shortcuts for the modal
    document.addEventListener('keydown', function(e) {
        var confirmModal = document.getElementById('confirmSaveModal');
        if (confirmModal && confirmModal.classList.contains('show')) {
            if (e.key === 'Enter') {
                e.preventDefault();
                window.submitForm();
            } else if (e.key === 'Escape') {
                var modal = bootstrap.Modal.getInstance(confirmModal);
                if (modal) {
                    modal.hide();
                }
            }
        }
    });
</script>
@endpush

@push('styles')
<style>
.confirm-icon-wrapper {
    width: 80px;
    height: 80px;
    margin: 0 auto;
    background: linear-gradient(135deg, #F6903A 0%, #E57A2A 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: pulse 2s infinite;
}

.confirm-icon-wrapper i {
    font-size: 40px;
    color: white;
}

@keyframes pulse {
    0% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(246, 144, 58, 0.7);
    }
    50% {
        transform: scale(1.05);
        box-shadow: 0 0 0 15px rgba(246, 144, 58, 0);
    }
    100% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(246, 144, 58, 0);
    }
}

@keyframes slideInRight {
    from {
        transform: translateX(120%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

#confirmSaveModal .modal-content {
    border-radius: 16px;
    overflow: hidden;
}

#confirmSaveModal .modal-header .btn-close {
    margin: 0;
    padding: 1rem;
}

#confirmSaveModal .btn-primary {
    background: linear-gradient(135deg, #F6903A 0%, #E57A2A 100%);
    border: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

#confirmSaveModal .btn-primary:hover {
    background: linear-gradient(135deg, #E57A2A 0%, #D56A1A 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(246, 144, 58, 0.4);
}

#confirmSaveModal .btn-secondary {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    color: #6c757d;
    font-weight: 500;
}

#confirmSaveModal .btn-secondary:hover {
    background: #e9ecef;
    color: #495057;
}

/* Disabled state for save button */
#saveBtn:disabled {
    background: #9ca3af;
    cursor: not-allowed;
    opacity: 0.7;
}

#saveBtn:disabled:hover {
    transform: none;
    box-shadow: none;
}
</style>
@endpush
