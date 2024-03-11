@extends('layouts.app') 


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <strong>
                                <a href="javascript:void(0)" class="btn" id="profil" data-toggle="tooltip" data-id="profil" data-original-title="profil" >
                                    @if (Auth::user()->profil==null)
                                        <img src="{{asset('imgs/user.png')}}" alt="Erreur Image" width="30" height="30">
                                    @else
                                        <img src="{{ url('storage') }}/images/profil/{{ Auth::user()->id }}/profil.png" alt="Erreur Image" width="40" height="40" style="border-radius: 50%">
                                    @endif
                                </a>
                                @if ($user->sexe=="F")
                                    {{ "Mme. " }}
                                @else
                                {{ "M. " }}
                                @endif
                                {{ $user->name." ".$user->postnom." ".$user->prenom }}
                            </strong>
                            @if (Auth::user()->roles()->contains(3))
                                <button class="btn btn-success float-sm-end" disabled><strong>{{ "MARCHAND" }}</strong></button>
                            @endif  
                            @if (Auth::user()->roles()->contains(2))
                                <button class="btn btn-secondary float-sm-end" disabled><strong>{{ "MANAGER" }}</strong></button>  
                            @endif
                            @if (Auth::user()->roles()->contains(1))
                                <button class="btn btn-warning float-sm-end" disabled><strong>{{ "ADMIN" }}</strong></button>
                            @endif 
                        </h4>
                    </div>
                    <div class="card-body text-center">
                        <div class="text-center text-danger text-uppercase">                        
                            @if($errors->any())
                                <p>{{ $errors->first() }}</p>
                            @endif
                        </div>
                        <h5>Contact WhatsApp : <B>{{$user->tel}}</B></h5>
                        <h5>Adresse Mail : <B>{{$user->email}}</B></h5>
                        @if ($adresse!=null)
                            <h5 class="text-reset"><B class="text-body">Adresse : </B><h5>{{$adresse->type."/ ".$adresse->nom." N° ".$adresse->numero." ".$adresse->code.", \nQuartier/ ".$adresse->quartier.", Commune/ ".$adresse->commune.", \n".$adresse->province()[0]->nom}}</h5>
                            <h5 class="text-reset"><B class="text-body">Réf : </B>{{$adresse->ref}}</h5>
                            <h5 class="text-reset"><B class="text-body">Code unique : </B>{{$user->code}}</h5>
                        @endif
                    </div>
                    <div class="card-footer" style="height: 60px">
                        <table class="table table-borderless table-responsive table-sm">
                            <td align="left">
                                <form action="{{ route('users.edit',$user->id) }}" accept-charset="UTF-8" method="get">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">
                                        <img src="{{asset('imgs/modifier.png')}}" alt="Erreur Image" width="20" height="20">
                                    </button>
                                </form>
                            </td>
                            <td align="center">
                                <form action="{{ route('password.request') }}" accept-charset="UTF-8" method="get">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary">
                                        <img src="{{asset('imgs/key.png')}}" alt="Erreur Image" width="20" height="20">
                                    </button>
                                </form>
                            </td>
                            <td align="right">
                                <form action="{{ route('users.destroy',$user->id) }}" accept-charset="UTF-8" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Confirmez-vous la suppression de votre compte ?')">
                                        <img src="{{asset('imgs/delete.png')}}" alt="Erreur Image" width="20" height="20">
                                    </button>
                                </form>
                            </td>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ajaxModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header justify-content-sm-center">
                    <h4 class="modal-title" id="modalHeading" >{{ "Photo de profil" }}</h4>
                </div>
                <div class="modal-body">
                    @if ($user->profil!=null)
                        <a href="{{ route('deleteProfil',$user) }}" class="btn btn-danger" onclick="return confirm('Voulez-vous supprimer votre photo de profil ?')"><img src="{{asset('imgs/delete.png')}}" alt="Erreur Image" width="20" height="20"></a>
                        <img src="{{ url('storage') }}/images/profil/{{ Auth::user()->id }}/profil.png" alt="Erreur Image" width="100%">
                    @else
                        <img src="{{asset('imgs/user.png')}}" alt="Erreur Image" width="100%">
                    @endif
                    <br><br><br>
                    <h5 class="modal-title text-center" ><B><U>{{ "Modifiier" }}</U></B></h5>
                    {!! Form::open(array('route' => ['users.show',$user],'files'=>'true')) !!}
                        @method('get')
                        <div class="row mb-3 justify-content-center">
                            <div class="justify-content-center" style="width: 70%">
                                {!! Form::file('profil', ["class"=>"form-control","id"=>"profil","accept"=>".png,.jpg,.jpeg"]) !!}
                                @error('profil')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary float-sm-none" id="saveBtn">
                                    <img src="{{asset('imgs/save.png')}}" alt="Erreur Image" width="20" height="20">
                                </button>
                            </div>
                        </div>
    
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        /*
            Popup modal pour la photo de profil
        */
        $('#profil').click(function(){
            $('#ajaxModal').modal('show');
        });
    </script>
@endsection