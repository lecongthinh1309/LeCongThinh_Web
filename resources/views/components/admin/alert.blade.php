{{-- Hiển thị tất cả lỗi Validation --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Hiển thị lỗi từ session flash 'error' --}}
@if(session('error'))
    <div class="alert alert-danger">
        <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
    </div>
@endif

{{-- Hiển thị thông báo từ session flash 'message' --}}
@if(session('message'))
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('message') }}
    </div>
@endif

{{-- Hiển thị thông báo thành công từ session flash 'success' --}}
@if(session('success'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    </div>
@endif