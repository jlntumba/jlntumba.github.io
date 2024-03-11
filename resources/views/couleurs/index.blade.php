@extends('layouts.app') 


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4><strong>
                            {{"Les couleurs"}}
                        </strong></h4>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="text-center text-danger text-uppercase">                        
                            @if($errors->any())
                                <h4>{{ $errors->first() }}</h4>
                            @endif
                        </div>
                        
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                <th>{{ "N°" }}</th>
                                <th align="center">{{ "Couleur" }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($couleurs->isEmpty())
                                    <td>0</td>
                                    <td>{{ "Aucun enregistré" }}</td>
                                @endif
                                @foreach ($couleurs as $couleur)
                                    <tr>
                                        <td>{{$cpt++}}</td>
                                        <td align="center"><B>{{ $couleur->couleur }}</B></td><td align="center"><a class="btn" style="background-color: {{ $couleur->color }}; border-color: black"></a></td>
                                        <td align="center">
                                            <form action="{{route('couleurs.edit',$couleur)}}" accept-charset="UTF-8" method="get">
                                                @csrf
                                                <input id="couleur" type="hidden" class="form-control @error('Couleur') is-invalid @enderror" name="couleur" value={{ $couleur->id }} autocomplete="couleur" autofocus>
                                                <button type="submit" class="btn-success">
                                                    <img src="{{asset('imgs/modifier.png')}}" alt="Erreur Image" width="20" height="20">
                                                </button>
                                                </div>
                                            </form>
                                        </td>
                                        <td align="center">
                                            <form action="{{route('couleurs.destroy',$couleur)}}" accept-charset="UTF-8" method="post">
                                                @csrf
                                                @method('delete')
                                                <input id="couleur" type="hidden" class="form-control @error('Couleur') is-invalid @enderror" name="couleur" value={{ $couleur->id }} autocomplete="type" autofocus>
                                                <button type="submit" class="btn-danger" onclick="return confirm('Confirmez-vous la suppression ? Cela entraînera la suppression des articles rattachés, les enlevant des paniers !')">
                                                    <img src="{{asset('imgs/delete.png')}}" alt="Erreur Image" width="20" height="20">
                                                </button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                            <form action="{{ route('couleurs.create') }}" accept-charset="UTF-8" method="get">
                                @csrf
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-0">
                                        <button type="submit" class="btn btn-primary">
                                            <img src="{{asset('imgs/plus.png')}}" alt="Erreur Image" width="20" height="20">
                                        </button>
                                    </div>
                                </div>
                            </form>
                    </div>
                    <div class="card-footer">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection