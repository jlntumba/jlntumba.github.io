@extends('layouts.app') 


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4><strong>
                            {{"Différentes tailles de vêtements"}}
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
                                <th align="center">{{ "Taille" }}</th>
                                <th align="center">{{ "Description" }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($tailles->isEmpty())
                                    <td>0</td>
                                    <td>{{ "Aucune enregistrée" }}</td>
                                @endif
                                @foreach ($tailles as $taille)
                                    <tr>
                                        <td>{{$cpt++}}</td>
                                        <td align="center">{{ $taille->taille }}</td>
                                        <td align="center">{{ $taille->description }}</td>
                                        <td align="center">
                                            <form action="{{route('tailles.edit',$taille)}}" accept-charset="UTF-8" method="get">
                                                @csrf
                                                <input id="marque" type="hidden" class="form-control @error('Marque') is-invalid @enderror" name="marque" value={{ $taille->id }} autocomplete="marque" autofocus>
                                                <button type="submit" class="btn-success">
                                                    <img src="{{asset('imgs/modifier.png')}}" alt="Erreur Image" width="20" height="20">
                                                </button>
                                                </div>
                                            </form>
                                        </td>
                                        <td align="center">
                                            <form action="{{route('tailles.destroy',$taille)}}" accept-charset="UTF-8" method="post">
                                                @csrf
                                                @method('delete')
                                                <input id="marque" type="hidden" class="form-control @error('Marque') is-invalid @enderror" name="marque" value={{ $taille->id }} autocomplete="marque" autofocus>
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
                            <form action="{{ route('tailles.create') }}" accept-charset="UTF-8" method="get">
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