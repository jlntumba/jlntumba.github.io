@extends('layouts.app') 


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __("Création d'une taille") }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('tailles.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="taille" class="col-md-4 col-form-label text-md-end">{{ __('Taille') }}</label>

                            <div class="col-md-6">
                                <input id="taille" type="text" class="form-control @error('taille') is-invalid @enderror" name="taille" value="{{ old('taille') }}" required autocomplete="taille" autofocus>

                                @error('taille')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control @error('taille') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="description" autofocus>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!--<div class="dropdown-divider"></div>-->

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary float-sm-end">
                                    <img src="{{asset('imgs/save.png')}}" alt="Erreur Image" width="25" height="25">
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-0">
                            <button onclick="goBack()" class="btn btn-secondary">
                                <img src="{{asset('imgs/retour.png')}}" alt="Erreur Image" width="20" height="20">
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection