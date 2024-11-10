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

<div id="alertMessage" class="alert d-none" role="alert"></div>

<form id="loginForm">
    <input type="hidden" id="role" name="role" value="contractor">
    
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
        </div>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" class="form-control" id="password" name="password" required placeholder="Enter your password">
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100 mb-3">Sign In</button>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#contractor-role').on('click', function() {
            $('#supplier-role').removeClass('active');
            $(this).addClass('active');
            $('#role').val('contractor');
        });

        $('#supplier-role').on('click', function() {
            $('#contractor-role').removeClass('active');
            $(this).addClass('active');
            $('#role').val('supplier');
        });

        $('#loginForm').on('submit', function(event) {
            event.preventDefault();
            $('#alertMessage').addClass('d-none').removeClass('alert-success alert-danger');

            const formData = {
                email: $('#email').val(),
                password: $('#password').val(),
            };

            $.ajax({
                url: '{{ route("login") }}',
                type: 'POST',
                data: JSON.stringify(formData),
                contentType: 'application/json',
                success: function(response) {
                    // Lưu access_token vào cookie
                    document.cookie = `access_token=${response.access_token}; path=/; max-age=3600; secure; samesite=strict`;

                    let redirectUrl = response.user.role === 'contractor' ? '/tender/list_contractor' : '/tender/list_supplier';
                    $('#alertMessage').removeClass('d-none alert-danger').addClass('alert-success').text('Login successful!');
                    setTimeout(() => window.location.href = redirectUrl, 1500);
                },
                error: function(error) {
                    const errorMessage = error.responseJSON ? error.responseJSON.message : 'Login failed. Please try again.';
                    $('#alertMessage').removeClass('d-none alert-success').addClass('alert-danger').text(errorMessage);
                }
            });
        });
    });
</script>
@endsection
