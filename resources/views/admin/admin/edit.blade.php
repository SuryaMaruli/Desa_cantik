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
                            <label for="password_confirmation" class="form-label">Konfirmasi Password <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>
                </div>

                <div class="alert alert-info">
                    <i class='bx bx-info-circle'></i>
                    <strong>Info:</strong> Admin ini dibuat pada {{ $admin->created_at->format('d M Y H:i') }}
                    @if($admin->updated_at != $admin->created_at)
                        dan terakhir diperbarui pada {{ $admin->updated_at->format('d M Y H:i') }}
                    @endif
                </div>
            </div>

            <div class="card-footer">
                <a href="{{ route('admin.admin.index') }}" class="btn btn-secondary">
                    <i class='bx bx-arrow-back'></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
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

.form-control:focus {
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
</style>

<script>
// Toggle password confirmation requirement
document.getElementById('password').addEventListener('input', function(e) {
    const passwordConfirmation = document.getElementById('password_confirmation');
    if (e.target.value) {
        passwordConfirmation.required = true;
    } else {
        passwordConfirmation.required = false;
        passwordConfirmation.value = '';
    }
});
</script>
@endsection
