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
                    <img src="{{ asset('app/img/logojac.png') }}" alt=""><br><br>
                    <span>BIENVENIDOS</span>
                    <p class="title_">SOMOS JAC</p>
                    <p>Deja tu opinión aquí</p>
                </div><br>
                <form class="form-login" action="{{ route('home.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="opinion" class="text-primary-m">Tu Opinión</label>
                        <textarea id="opinion" name="opinion" class="form-control-m {{ $errors->has('opinion') ? ' is-invalid' : '' }}"
                            required placeholder="Escribe tu opinión aquí">{{ old('opinion') }}</textarea>
                        @if ($errors->has('opinion'))
                            <span class="invalid-feedback" role="alert">
                                <span style="color:#cd3232;">{{ $errors->first('opinion') }}</span>
                            </span>
                        @endif
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="text-primary-m">Calificación</label><br>
                        <div class="rating">
                            <input type="radio" id="star5" name="rating" value="5" required />
                            <label for="star5" title="5 stars">&#9733;</label>
                            <input type="radio" id="star4" name="rating" value="4" />
                            <label for="star4" title="4 stars">&#9733;</label>
                            <input type="radio" id="star3" name="rating" value="3" />
                            <label for="star3" title="3 stars">&#9733;</label>
                            <input type="radio" id="star2" name="rating" value="2" />
                            <label for="star2" title="2 stars">&#9733;</label>
                            <input type="radio" id="star1" name="rating" value="1" />
                            <label for="star1" title="1 star">&#9733;</label>
                        </div>
                        @if ($errors->has('rating'))
                            <span class="invalid-feedback" role="alert">
                                <span style="color:#cd3232;">{{ $errors->first('rating') }}</span>
                            </span>
                        @endif
                    </div>
                    <br>
                    <button type="submit" class="btn-m btn-primary-gradient">Enviar Opinión</button>
                    <br><br>
                    {{-- Mensajes de éxito y error --}}
                    @if (session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </form>

            </div>
        </div>
    </div>
</section>
<style>
    .rating {
        direction: rtl;
        display: inline-block;
    }

    .rating input {
        display: none;
    }

    .rating label {
        font-size: 30px;
        color: #b9b9b9;
        cursor: pointer;
    }

    .rating input:checked~label {
        color: #f7c04d;
        /* Color for selected stars */
    }

    .rating label:hover,
    .rating label:hover~label {
        color: #f7c04d;
        /* Hover color */
    }
</style>
