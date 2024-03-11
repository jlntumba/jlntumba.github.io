@if (Auth::user()->adresse_id!=null)
    <div class="row mb-3">
        <label for="type" class="col-md-4 col-form-label text-md-end">{{ __('Type de voie') }}</label>

        <div class="col-md-3">
            <select name="type" id="type" class="form-control  form-select @error('type') is-invalid @enderror" value="{{ $user->adresse()[0]->type }}" required autocomplete="type" autofocus>
                @if ($user->adresse_id==null||$user->adresse_id==0)
                    <option value="{{ null }}"></option>  
                    @foreach ($types as $t)
                        <option value="{{ $t }}">{{ $t }}</option>
                    @endforeach
                @else
                    <option value="{{ $type }}">{{ $type }}</option>
                    @foreach ($types as $t)
                        @if ($type!=$t)
                            <option value="{{ $t }}">{{ $t }}</option>
                        @endif
                    @endforeach            
                @endif
            </select>
            @error('type')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-3">
            <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ $user->adresse()[0]->nom }}" required autocomplete="nom" autofocus>

            @error('nom')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label for="numero" class="col-md-4 col-form-label text-md-end">{{ __('N°') }}</label>

        <div class="col-md-2">
            <input id="numero" type="number" class="form-control @error('numero') is-invalid @enderror" name="numero" value="{{ $user->adresse()[0]->numero }}" required autocomplete="numero" autofocus>

            @error('numero')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-2">
            <select name="code" id="code" class="form-control  form-select @error('code') is-invalid @enderror" value="{{ $user->adresse()[0]->code }}" autocomplete="code" autofocus>
                @if ($user->adresse_id==null||$user->adresse_id==0)
                    <option value=""></option>  
                    @foreach ($codes as $c)
                        <option value="{{ $c }}">{{ $c }}</option>
                    @endforeach
                @else
                    <option value="{{ $code }}">{{ $code }}</option>
                    <option value=""></option>
                    @foreach ($codes as $c)
                        @if ($code!=$c)
                            <option value="{{ $c }}">{{ $c }}</option>
                        @endif
                    @endforeach            
                @endif
            </select>
            @error('code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label for="quartier" class="col-md-4 col-form-label text-md-end">{{ __('Quartier') }}</label>

        <div class="col-md-6">
            <input id="quartier" type="text" class="form-control @error('quartier') is-invalid @enderror" name="quartier" value="{{ $user->adresse()[0]->quartier }}" required autocomplete="quartier" autofocus>

            @error('quartier')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label for="commune" class="col-md-4 col-form-label text-md-end">{{ __('Commune') }}</label>

        <div class="col-md-6">
            <input id="commune" type="text" class="form-control @error('commune') is-invalid @enderror" name="commune" value="{{ $user->adresse()[0]->commune }}" required autocomplete="commune" autofocus>

            @error('commune')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label for="ref" class="col-md-4 col-form-label text-md-end">{{ __('Référence') }}</label>

        <div class="col-md-6">
            <textarea name="ref" id="ref" cols="30" rows="3" class="form-control @error('ref') is-invalid @enderror">{{ $user->adresse()[0]->ref }}</textarea>

            @error('ref')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label for="province" class="col-md-4 col-form-label text-md-end">{{ __('Province') }}</label>

        <div class="col-md-6">
            <select name="province" id="province" class="form-control  form-select @error('province') is-invalid @enderror" value="{{ old('province') }}" required autocomplete="province" autofocus>
                @if ($user->adresse_id==null||$user->adresse_id==0)
                    <option value=""></option>  
                @else
                    <option value="{{ $province->id }}">{{ $province->nom }}</option>              
                @endif
                @foreach ($provinces as $prov)
                    @if ($province->id!=$prov->id)
                        <option value="{{ $prov->id }}">{{ $prov->nom }}</option>
                    @endif
                @endforeach
            </select>
            @error('province')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>    
@else
    <div class="row mb-3">
        <label for="type" class="col-md-4 col-form-label text-md-end">{{ __('Type de voie') }}</label>

        <div class="col-md-3">
            <select name="type" id="type" class="form-control  form-select @error('type') is-invalid @enderror" value="{{ old('type') }}" required autocomplete="type" autofocus>
                @if ($user->adresse_id==null||$user->adresse_id==0)
                    <option value="{{ null }}"></option>  
                    @foreach ($types as $t)
                        <option value="{{ $t }}">{{ $t }}</option>
                    @endforeach
                @else
                    <option value="{{ $type }}">{{ $type }}</option>
                    @foreach ($types as $t)
                        @if ($type!=$t)
                            <option value="{{ $t }}">{{ $t }}</option>
                        @endif
                    @endforeach            
                @endif
            </select>
            @error('type')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-3">
            <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom') }}" required autocomplete="nom" autofocus>

            @error('nom')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label for="numero" class="col-md-4 col-form-label text-md-end">{{ __('N°') }}</label>

        <div class="col-md-2">
            <input id="numero" type="number" class="form-control @error('numero') is-invalid @enderror" name="numero" value="{{ old('numero') }}" required autocomplete="numero" autofocus>

            @error('numero')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-2">
            <select name="code" id="code" class="form-control  form-select @error('code') is-invalid @enderror" value="{{ old('code') }}" autocomplete="code" autofocus>
                @if ($user->adresse_id==null||$user->adresse_id==0)
                    <option value=""></option>  
                    @foreach ($codes as $c)
                        <option value="{{ $c }}">{{ $c }}</option>
                    @endforeach
                @else
                    <option value="{{ $code }}">{{ $code }}</option>
                    <option value=""></option>
                    @foreach ($codes as $c)
                        @if ($code!=$c)
                            <option value="{{ $c }}">{{ $c }}</option>
                        @endif
                    @endforeach            
                @endif
            </select>
            @error('code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label for="quartier" class="col-md-4 col-form-label text-md-end">{{ __('Quartier') }}</label>

        <div class="col-md-6">
            <input id="quartier" type="text" class="form-control @error('quartier') is-invalid @enderror" name="quartier" value="{{ old('quartier') }}" required autocomplete="quartier" autofocus>

            @error('quartier')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label for="commune" class="col-md-4 col-form-label text-md-end">{{ __('Commune') }}</label>

        <div class="col-md-6">
            <input id="commune" type="text" class="form-control @error('commune') is-invalid @enderror" name="commune" value="{{ old('commune') }}" required autocomplete="commune" autofocus>

            @error('commune')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label for="ref" class="col-md-4 col-form-label text-md-end">{{ __('Référence') }}</label>

        <div class="col-md-6">
            <textarea name="ref" id="ref" cols="30" rows="3" class="form-control @error('ref') is-invalid @enderror"></textarea>

            @error('ref')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <label for="province" class="col-md-4 col-form-label text-md-end">{{ __('Province') }}</label>

        <div class="col-md-6">
            <select name="province" id="province" class="form-control  form-select @error('province') is-invalid @enderror" value="{{ old('province') }}" required autocomplete="province" autofocus>
                @if ($user->adresse_id==null||$user->adresse_id==0)
                    <option value=""></option>  
                    @foreach ($provinces as $prov)
                        <option value="{{ $prov->id }}">{{ $prov->nom }}</option>
                    @endforeach
                @else
                    <option value="{{ $province->id }}">{{ $province->nom }}</option>
                    @foreach ($provinces as $prov)
                        @if ($province->id!=$prov->id)
                            <option value="{{ $prov->id }}">{{ $prov->nom }}</option>
                        @endif
                    @endforeach            
                @endif
            </select>
            @error('province')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
@endif
