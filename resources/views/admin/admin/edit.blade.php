@extends('layouts.admin')

@section('page-title', 'Edit Admin')

@section('content')
<div class="home-content">
    <div class="content-card">
        <div class="card-header">
            <h4><i class='bx bx-edit-alt'></i> Edit Admin</h4>
        </div>

        <form action="{{ route('admin.admin.update', $admin) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $admin->name) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $admin->email) }}" required>
                        </div>
                    </div>
                </div>

<div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="password" class="form-label">Password <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
                            <input type="password" class="form-control" id="password" name="password">
                            <div class="form-text">Minimal 8 karakter</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
<label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>
                </div>

<div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="role" class="form-label">Peran (Role) <span class="text-danger">*</span></label>
@if($isSuperAdmin)
                                @if($canChangeRole)
                                    <select class="form-select" id="role" name="role" required>
                                        <option value="super_admin" {{ $admin->role === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                        <option value="admin" {{ $admin->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                @else
                                    <div class="form-control-plaintext">
                                        @if($admin->role === 'super_admin')
                                            <span class="badge bg-success"><i class='bx bx-shield-check'></i> Super Admin</span>
                                        @else
                                            <span class="badge bg-secondary"><i class='bx bx-user'></i> Admin</span>
                                        @endif
                                        <input type="hidden" name="role" value="{{ $admin->role }}">
                                    </div>
                                @endif
                            @else
                                <div class="form-control-plaintext">
                                    @if($admin->role === 'super_admin')
                                        <span class="badge bg-success"><i class='bx bx-shield-check'></i> Super Admin</span>
                                    @else
                                        <span class="badge bg-secondary"><i class='bx bx-user'></i> Admin</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

</div>
            </div>

<div class="card-footer">
                <a href="{{ route('admin.admin.index') }}" class="btn btn-secondary">
                    <i class='bx bx-arrow-back'></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary" id="saveBtn" disabled>
                    <i class='bx bx-save'></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.card-header {
    background: linear-gradient(135deg, #F6903A 0%, #E57A2A 100%);
    color: white;
    padding: 20px;
    border-radius: 10px 10px 0 0;
    margin-bottom: 0;
}

.card-header h4 {
    margin: 0;
    font-weight: 600;
}

.card-header i {
    margin-right: 10px;
}

.card-body {
    padding: 30px;
}

.card-footer {
    background-color: #f8f9fa;
    padding: 20px 30px;
    border-top: 1px solid #dee2e6;
    text-align: right;
}

.card-footer .btn {
    margin-left: 10px;
}

.form-label {
    font-weight: 600;
    color: #495057;
}

.form-control:focus,
.form-select:focus {
    border-color: #F6903A;
    box-shadow: 0 0 0 0.2rem rgba(246, 144, 58, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #F6903A 0%, #E57A2A 100%);
    border: none;
    padding: 10px 20px;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #E57A2A 0%, #D66A1A 100%);
}

.btn-primary:disabled {
    background: #9ca3af;
    cursor: not-allowed;
    opacity: 0.7;
}

.btn-primary:disabled:hover {
    background: #9ca3af;
    transform: none;
    box-shadow: none;
}

.btn-secondary {
    background-color: #6c757d;
    border: none;
    padding: 10px 20px;
}

.alert-danger {
    border-left: 4px solid #dc3545;
}

.alert-info {
    border-left: 4px solid #17a2b8;
    background-color: #d1ecf1;
    border-color: #bee5eb;
}

.form-text {
    font-size: 0.875rem;
    color: #6c757d;
}

.text-warning {
    color: #d36a18 !important;
}

.text-info {
    color: #17a2b8 !important;
}

.badge {
    padding: 8px 12px;
    font-size: 14px;
}

.bg-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
}

.bg-secondary {
    background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%) !important;
}
</style>

<script>
// Custom Notification Function (same as data-kelurahan page)
function showNotification(message, type = 'success') {
    // Hapus notifikasi yang ada terlebih dahulu
    document.querySelectorAll('.custom-notification').forEach(n => n.remove());
    
    const notification = document.createElement('div');
    const config = {
        success: { icon: 'bx-check-circle', bg: 'linear-gradient(135deg, #10b981, #059669)', color: '#fff' },
        error: { icon: 'bx-x-circle', bg: 'linear-gradient(135deg, #ef4444, #dc2626)', color: '#fff' },
        warning: { icon: 'bx-exclamation-circle', bg: 'linear-gradient(135deg, #f59e0b, #d97706)', color: '#fff' },
        info: { icon: 'bx-info-circle', bg: 'linear-gradient(135deg, #3b82f6, #2563eb)', color: '#fff' }
    };
    
    const c = config[type] || config.success;
    
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
    
    // Tambahkan animasi CSS
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight { 
            from { transform: translateX(120%); opacity: 0; } 
            to { transform: translateX(0); opacity: 1; } 
        }
    `;
    document.head.appendChild(style);
    document.body.appendChild(notification);
    
    // Hapus notifikasi setelah 3.5 detik
    setTimeout(() => {
        notification.style.transform = 'translateX(120%)';
        notification.style.opacity = '0';
        notification.style.transition = 'all 0.4s ease';
        setTimeout(() => { notification.remove(); style.remove(); }, 400);
    }, 3500);
}

// Toggle password confirmation requirement
document.getElementById('password').addEventListener('input', function(e) {
    const passwordConfirmation = document.getElementById('password_confirmation');
    if (e.target.value) {
        passwordConfirmation.required = true;
    } else {
        passwordConfirmation.required = false;
        passwordConfirmation.value = '';
    }
    checkForChanges();
});

// Get original values from server
var originalData = {
    name: @json($admin->name),
    email: @json($admin->email),
    role: @json($admin->role)
};

// Function to check if there are changes
function checkForChanges() {
    var saveBtn = document.getElementById('saveBtn');
    if (!saveBtn) return;

    var nameInput = document.getElementById('name');
    var emailInput = document.getElementById('email');
    var passwordInput = document.getElementById('password');
    var confirmationInput = document.getElementById('password_confirmation');

    // Check if any field has been modified
    var hasNameChanged = nameInput && nameInput.value !== originalData.name;
    var hasEmailChanged = emailInput && emailInput.value !== originalData.email;
    var hasPasswordChanged = passwordInput && passwordInput.value !== '';
    var hasConfirmationChanged = confirmationInput && confirmationInput.value !== '';

    // If password is filled, confirmation must also be filled
    var hasChanges = hasNameChanged || hasEmailChanged || hasPasswordChanged || hasConfirmationChanged;

    // Only enable if password AND confirmation are both filled, OR other fields changed
    if (hasChanges) {
        if (hasPasswordChanged && !hasConfirmationChanged) {
            saveBtn.disabled = true;
        } else {
            saveBtn.disabled = false;
        }
    } else {
        saveBtn.disabled = true;
    }
}

// Show notification on page load if there are errors
document.addEventListener('DOMContentLoaded', function() {
    @if($errors->any())
        showNotification('{{ $errors->first() }}', 'error');
    @endif
});

// Add event listeners to all form fields
document.addEventListener('DOMContentLoaded', function() {
    var nameInput = document.getElementById('name');
    var emailInput = document.getElementById('email');
    var passwordInput = document.getElementById('password');
    var confirmationInput = document.getElementById('password_confirmation');

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
});
</script>
@endsection
