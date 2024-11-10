@extends('layouts.login_layout')

@section('content')
<h3 class="text-center mb-4">Register for DeskApp</h3>

<div class="d-flex justify-content-center mb-4">
    <div class="btn-role btn-outline-primary active" id="contractor-role">
        <i class="bi bi-person-badge"></i> I'm Contractor
    </div>
    <div class="btn-role btn-outline-primary" id="supplier-role">
        <i class="bi bi-person"></i> I'm Supplier
    </div>
</div>

<!-- Alert message area -->
<div id="alertMessage" class="alert d-none" role="alert"></div>

<form id="registerForm">
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

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Confirm your password">
        </div>
    </div>

    <button type="button" class="btn btn-primary w-100 mb-3" id="registerButton">Register</button>

    <div class="text-center">Already have an account?</div>
    <a href="{{ route('login') }}" class="btn btn-outline-primary w-100 mt-3">Login to DeskApp</a>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    // AJAX request for registration
    $('#registerButton').click(function() {
        $('#alertMessage').addClass('d-none').removeClass('alert-success alert-danger');

        const formData = {
            username: $('#username').val(),
            email: $('#email').val(),
            password: $('#password').val(),
            password_confirmation: $('#password_confirmation').val(),
            role: $('#role').val(),
            _token: $('input[name="_token"]').val() 
        };

        $.ajax({
            url: '{{ route("register") }}',
            type: 'POST',
            data: formData,
            success: function(response) {
                $('#alertMessage').removeClass('d-none alert-danger').addClass('alert-success').text(response.message);

                setTimeout(function() {
                    window.location.href = '{{ route("login") }}';
                }, 2000);
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = 'Registration failed. Please check the fields.';

                if (errors) {
                    errorMessage = '';
                    for (let key in errors) {
                        errorMessage += errors[key].join(' ') + ' ';
                    }
                }

                $('#alertMessage').removeClass('d-none alert-success').addClass('alert-danger').text(errorMessage);
            }
        });
    });
</script>
@endsection