{{-- @extends('app.index') --}}

@section('styles')
    {{-- <link rel="stylesheet" href="{{ asset('app/css/home/index.css') }}"> --}}
@endsection

@section('content')
@endsection
<script src="https://kit.fontawesome.com/6f8129a9b1.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="{{ asset('app/css/home/login.css') }}">
<section class="section_login">
    <div class="content_view_login">
        <div class="sect_login">
            <div class="content_login">
                <div class="content_titulo_login">
                    <img src="{{ asset('app/img/logo_ial.png') }}" alt=""><br><br>
                    <span>BIENVENIDOS</span>
                    <p class="title_">SOMOS JAC</p>
                    <p>Registrarse Aquí</p>
                    <div class="access_administrador">
                        <a href="{{ route('auth.login') }}"><i style="color: #0072bf; font-size:20px;"
                                class="fa-solid fa-users-between-lines"></i></a>
                    </div>
                </div><br>
                <form class="form-login" action="{{-- {{ route('auth.login.store') }} --}}" method="post">
                    @csrf
                    <input type="hidden" name="id_nuevo" id="id_nuevo" value="10" required>
                
                    {{-- Mensaje de éxito --}}
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                
                    <div class="form-group">
                        <label for="nombres" class="text-primary-m">Nombres</label>
                        <input type="text" autocomplete="off" id="nombres" name="nombre"
                            class="form-control-m {{ $errors->has('nombres') ? ' is-invalid' : '' }}"
                            value="{{ old('nombres') }}" required placeholder="Ingrese Nombres">
                        @if ($errors->has('nombres'))
                            <span class="invalid-feedback" role="alert">
                                <span style="color:#cd3232;">{{ $errors->first('nombres') }}</span>
                            </span>
                        @endif
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="apellido" class="text-primary-m">Apellidos</label>
                        <input type="text" autocomplete="off" id="apellido" name="apellido"
                            class="form-control-m {{ $errors->has('apellido') ? ' is-invalid' : '' }}"
                            value="{{ old('apellido') }}" required placeholder="Ingrese Apellido">
                        @if ($errors->has('apellido'))
                            <span class="invalid-feedback" role="alert">
                                <span style="color:#cd3232;">{{ $errors->first('apellido') }}</span>
                            </span>
                        @endif
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="tel" class="text-primary-m">WhatsApp</label>
                        <input type="text" id="tel" name="tel"
                            class="form-control-m {{ $errors->has('tel') ? ' is-invalid' : '' }}"
                            value="{{ old('tel') }}" required placeholder="Ingrese WhatsApp">
                        @if ($errors->has('tel'))
                            <span class="invalid-feedback" role="alert">
                                <span style="color:#cd3232;">{{ $errors->first('tel') }}</span>
                            </span>
                        @endif
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="fecha_nac" class="text-primary-m">Fecha de Nacimiento</label>
                        <input type="date" id="fecha_nac" name="fecha_nac"
                            class="form-control-m {{ $errors->has('fecha_nac') ? ' is-invalid' : '' }}"
                            required>
                        @if ($errors->has('fecha_nac'))
                            <span class="invalid-feedback" role="alert">
                                <span style="color:#cd3232;">{{ $errors->first('fecha_nac') }}</span>
                            </span>
                        @endif
                    </div>
                    <br>
                    <div class="">
                        <button type="submit" class="btn-m btn-primary-gradient">Registrar</button>
                    </div>
                    <br>
                </form>
                
            </div>

        </div>
    </div>
</section>



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
