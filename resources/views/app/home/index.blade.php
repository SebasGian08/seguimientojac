{{-- @extends('app.index') --}}

@section('styles')
    {{-- <link rel="stylesheet" href="{{ asset('app/css/home/index.css') }}"> --}}
@endsection

<script src="https://kit.fontawesome.com/6f8129a9b1.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="{{ asset('app/css/home/login.css') }}">
vista para asistente



<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password_alumno");
        var toggleButton = document.getElementById("toggleButton");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleButton.classList.remove("fa-eye-slash");
            toggleButton.classList.add("fa-eye");
        } else {
            passwordInput.type = "password";
            toggleButton.classList.remove("fa-eye");
            toggleButton.classList.add("fa-eye-slash");
        }
    }
</script>