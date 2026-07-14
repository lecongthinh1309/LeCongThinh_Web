<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Quên mật khẩu</title>
{{-- CDN Bootstrap CSS --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-3 ">
<form action="{{ route('admin.forgotpass.post') }}" class="mx-auto shadow-lg p-4 w-50 bg-light" method="POST">
@csrf
<h2>Quên mật khẩu</h2>
<x-admin.alert></x-admin.alert>

<div class="mb-3 mt-3">
<label for="f-email">Email</label>
<input type="text" class="form-control" id="f-email" placeholder=""
name="email" value="{{ old('email') }}">
</div>
<div class="mb-3 mt-3 d-flex gap-1">
<button type="submit" class="btn btn-primary">Gởi</button>
<a href="{{ route('admin.login') }}" class="btn btn-warning">Đăng nhập</a>
</div> 
</form>
</div>

</body>
</html>
