@extends('layouts.login_layout')

@section('content')
<h3 class="text-center mb-4">Login To DeskApp</h3>

<div class="d-flex justify-content-center mb-4">
    <div class="btn-role btn-outline-primary active" id="contractor-role">
        <i class="bi bi-person-badge"></i> I'm Contractor
    </div>
    <div class="btn-role btn-outline-primary" id="supplier-role">
        <i class="bi bi-person"></i> I'm Supplier
    </div>
</div>

<form action="{{ route('login') }}" method="post">
    @csrf
    <input type="hidden" id="role" name="role" value="contractor">
    
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-person"></i></span>
            <input type="text" class="form-control" id="username" name="username" required placeholder="Enter your username">
        </div>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" class="form-control" id="password" name="password" required placeholder="Enter your password">
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember">Remember</label>
        </div>
        <a href="#" class="text-decoration-none">Forgot Password</a>
    </div>

    <button type="submit" class="btn btn-primary w-100 mb-3">Sign In</button>

    <div class="text-center">OR</div>

    <a href="{{ route('register') }}" class="btn btn-outline-primary w-100 mt-3">Register To Create Account</a>
</form>

<script>
    // JavaScript for role selection
    document.getElementById('contractor-role').addEventListener('click', function() {
        document.getElementById('supplier-role').classList.remove('active');
        this.classList.add('active');
        document.getElementById('role').value = 'contractor';
    });

    document.getElementById('supplier-role').addEventListener('click', function() {
        document.getElementById('contractor-role').classList.remove('active');
        this.classList.add('active');
        document.getElementById('role').value = 'supplier';
    });
</script>
@endsection
