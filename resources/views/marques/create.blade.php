@extends('layouts.app') 


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __("Création d'une marque : ".$type->type) }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('marques.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="marque" class="col-md-4 col-form-label text-md-end">{{ __('Marque') }}</label>

                            <div class="col-md-6">
                                <input id="marque" type="text" class="form-control @error('marque') is-invalid @enderror" name="marque" value="{{ old('marque') }}" required autocomplete="marque" autofocus>
                                <input id="type" type="hidden" class="form-control @error('Type') is-invalid @enderror" name="type" value={{ $type->id }} autocomplete="type" autofocus>
                                @error('marque')
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