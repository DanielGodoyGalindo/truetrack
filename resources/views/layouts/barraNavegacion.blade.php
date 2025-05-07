{{-- Barra navegación --}}
<div class="d-flex flex-wrap align-items-center justify-content-center" id="barra-navegacion">
    {{-- Logo --}}
    <a href="{{ route('index') }}" class="d-flex align-items-center mb-2 mt-2 text-white text-decoration-none">
        <img src="{{ asset('img\Logo_TrueTrack.png') }}" alt="Logo TrueTrack" width="200px" height="70px"
            title="Inicio - TrueTrack" id="logo-truetrack">
    </a>
    {{-- Botones login, registrarse, editar perfil y salir --}}
    <div class="col-md-8 text-end">
        @guest
            <div class="d-flex justify-content-end gap-3">
                <button-component button-text="Login" button-url="{{ route('login') }}"
                    class="btn boton-naranja"></button-component>
                <button-component button-text="Registrarse" button-url="{{ route('register') }}"
                    class="btn boton-accion2"></button-component>
            </div>
        @endguest
        @auth
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-end gap-3">
                @if (Auth::check() && Auth::user()->rol != 'transportista')
                    <a type="button" class="btn boton-naranja" href="{{ route('profile.edit') }}">Mi
                        Perfil</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <input type="submit" class="btn boton-rojo" value="Desconectar" />
                </form>
            </div>
        @endauth
    </div>
</div>
