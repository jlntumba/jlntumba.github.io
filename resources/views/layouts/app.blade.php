<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{'E~commerce'}}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Favicons -->
    <link href="{{ asset('imgs/panier.png') }}" rel="icon">
    <link href="{{ asset('imgs/panier.png') }}" rel="apple-touch-icon">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-secondary">
    <div id="app" class="">
        <nav class="navbar navbar-expand-md navbar-light bg-info shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <div class="card-img"><img src="{{asset('imgs/panier.png')}}" alt="Erreur Image" width="40" height="40">{{'~Commerce'}}</div>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @guest
                        
                        
                            <li class="nav-item dropdown">
                            </li>
                        @else
                            @if (Auth::user()->roles()->contains(2)&&Auth::user()->adresse_id!=null)
                                <li class="nav-item">
                                    <a class="nav-link btn btn-info" href="{{ route('types.index') }}"><B><img src="{{asset('imgs/types.png')}}" alt="Erreur Image" width="25" height="25"></B><br>{{ "Types" }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-info" href="{{ route('couleurs.index') }}"><B><img src="{{asset('imgs/colors.png')}}" alt="Erreur Image" width="25" height="25"></B><br>{{ "Couleurs" }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-info" href="{{ route('modes.index') }}"><B><img src="{{asset('imgs/gender.png')}}" alt="Erreur Image" width="25" height="25"></B><br>{{ "Modes" }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-info" href="{{ route('tailles.index') }}"><B><img src="{{asset('imgs/taille.png')}}" alt="Erreur Image" width="25" height="25"></B><br>{{ "Tailles" }}</a>
                                </li>
                            @endif
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        
                        
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src="{{asset('imgs/user.png')}}" alt="Erreur Image" width="35" height="35">
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @if (Route::has('login'))
                                        <a class="dropdown-item" href="{{ route('login') }}">
                                            <img src="{{asset('imgs/login.png')}}" alt="Erreur Image" width="20" height="20">{{ __('  Connexion') }}
                                        </a>
                                    @endif

                                    @if (Route::has('register'))
                                        <a class="dropdown-item" href="{{ route('register') }}">
                                            <img src="{{asset('imgs/cmpt.png')}}" alt="Erreur Image" width="20" height="20">{{ __(' Créer un compte') }}
                                        </a>                                        
                                    @endif
                                    <a class="dropdown-item" href="{{ route('panierMac') }}">
                                        <img src="{{asset('imgs/panier.png')}}" alt="Erreur Image" width="20" height="20">{{ __(' Panier') }}
                                    </a>
                                </div>
                            </li>
                        @else
                            @if ((Auth::user()->roles()->contains(1)||Auth::user()->roles()->contains(2))&&Auth::user()->adresse_id!=null)
                                <li class="nav-item">
                                    <a class="nav-link btn btn-info" href="{{ route('users.index') }}"><B><img src="{{asset('imgs/users.png')}}" alt="Erreur Image" width="25" height="25"></B><br>{{ "Admin" }}</a>
                                </li>
                            @endif
                            @if(Auth::user()->roles()->contains(3)&&Auth::user()->adresse_id!=null)
                                <li class="nav-item">
                                    <a class="nav-link btn btn-info" href="{{ route('articles.index') }}"><B><img src="{{asset('imgs/stock.png')}}" alt="Erreur Image" width="25" height="25"></B><br>{{ "Stock" }}</a>
                                </li>
                            @endif
                            @if((Auth::user()->roles()->contains(3)&&Auth::user()->adresse_id!=null)||(!Auth::user()->articlesVendus()->isEmpty()&&Auth::user()->adresse_id!=null))
                                <li class="nav-item">
                                    <a class="{{ Auth::user()->articlesVendus()->isEmpty() ? "nav-link btn btn-info" : "nav-link btn btn-info text-danger"}}" style="{{ Auth::user()->articlesVendus()->isEmpty() ? "border-width: 2px" : "border-width: 2px; font-weight: 700"}}" href="{{ route('livraison') }}"><B><img src="{{asset('imgs/livre.png')}}" alt="Erreur Image" width="25" height="25"></B><br>{{"Livraison"}}</a>                            
                                </li>
                            @endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @if (Auth::user()->profil==null)
                                        <img src="{{asset('imgs/user.png')}}" alt="Erreur Image" width="20" height="20">
                                    @else
                                        <img src="{{ url('storage') }}/images/profil/{{ Auth::user()->id }}/profil.png" alt="Erreur Image" width="25" height="25" style="border-radius: 50%">
                                    @endif
                                    {{ Auth::user()->name." ".Auth::user()->prenom}}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @if (Auth::user()!=null&&Auth::user()->adresse_id!=null)
                                        <a class="dropdown-item" href="{{ route('users.show',Auth::user()->id) }}">
                                            <img src="{{asset('imgs/user.png')}}" alt="Erreur Image" width="20" height="20">{{ __('  Profil') }}
                                        </a>
                                        
                                        <a class="dropdown-item" href="{{ route('panierUser') }}">
                                            <img src="{{asset('imgs/panier.png')}}" alt="Erreur Image" width="20" height="20">{{ __(' Panier') }}
                                        </a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <img src="{{asset('imgs/out.png')}}" alt="Erreur Image" width="20" height="20">{{ __('  Déconnexion') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-0">
            @yield('content')
            <script>
                function goBack() {
                  window.history.back();
                }
            </script>
        </main>
    </div>

    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    @yield('script')
</body>
</html>
