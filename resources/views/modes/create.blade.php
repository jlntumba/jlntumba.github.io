@extends('layouts.app') 


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __("Création d'une mode") }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('modes.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="mode" class="col-md-4 col-form-label text-md-end">{{ __('Mode') }}</label>

                            <div class="col-md-6">
                                <input id="mode" type="text" class="form-control @error('mode') is-invalid @enderror" name="mode" value="{{ old('mode') }}" required autocomplete="mode" autofocus>

                                @error('mode')
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