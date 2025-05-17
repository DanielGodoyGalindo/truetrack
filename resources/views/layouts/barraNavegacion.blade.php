{{-- Barra navegación --}}
<div class="d-flex flex-wrap align-items-center justify-content-center" id="barra-navegacion">
    {{-- Logo --}}
    <a href="{{ route('index') }}" class="d-flex align-items-center mb-2 mt-2 text-white text-decoration-none">
        <img src="{{ asset('img\Logo_TrueTrack.png') }}" alt="Logo TrueTrack" width="200px" height="70px"
            title="Inicio - TrueTrack" id="logo-truetrack">
    </a>
    {{-- Botones login, registrarse, editar perfil y salir --}}
    <div class="d-flex col-md-8 justify-content-end">
        @guest
            <div class="d-flex justify-content-end gap-3">
                <button-component button-text="Login" button-url="{{ route('login') }}"
                    class="btn boton-naranja"></button-component>
                <button-component button-text="{{ __('messages.register') }}" button-url="{{ route('register') }}"
                    class="btn boton-accion2"></button-component>
            </div>
        @endguest
        @auth
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-end gap-3">
                @if (Auth::check() && Auth::user()->rol != 'transportista')
                    <a type="button" class="btn boton-naranja"
                        href="{{ route('profile.edit') }}">{{ __('messages.myProfile') }}</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <input type="submit" class="btn boton-rojo" value="{{ __('messages.disconnect') }}" />
                </form>
            </div>
        @endauth
        {{-- Botones para el idioma --}}
        <div class="d-flex align-items-center justify-content-center ms-5 gap-2" id="cuadro-idioma">
            <span>{{ __('messages.language') }}:</span>
            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <a rel="alternate" hreflang="{{ $localeCode }}"
                    href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                    {{ ucfirst($properties['native']) }}
                </a>
            @endforeach
        </div>
    </div>

</div>
