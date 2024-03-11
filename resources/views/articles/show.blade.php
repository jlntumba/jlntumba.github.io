@extends('layouts.app') 


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-center"><B>{{ $article->nom }}</B></h4>
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

                    <form action="{{route('articles.show',$article)}}">
                        <div class="position-absolute">
                            <button type="submit" class="btn btn-warning" id="deleteButton" onclick="return confirm('Confirmez-vous la suppression de la(les) photo(s) ?')" style="display: none">
                                <img src="{{asset('imgs/delete.png')}}" alt="Erreur Image" width="20" height="20">
                            </button>
                        </div>
                        <div class="card-img"  style="overflow: auto; white-space: nowrap; background-color: #333">
                            <!--Image de profil de l'artcile-->
                            <a class="btn showImg" href="javascript:void(0)" data-toggle="tooltip" data-id="{{ url('storage') }}/images/{{ $article->nom.$article->id }}/profil.png" data-original-title="Show" ><img src="{{ url('storage') }}/images/{{ $article->nom.$article->id }}/profil.png" alt="Erreur Image" width="270" height="250"></a>
                            <a href="#" class="btn"><img src="{{asset('imgs/space.jpg')}}" alt="" srcset="" width="5" height="250"></a>

                            <!--Les autres images s'il y a, sauf le profil-->
                            @foreach (Storage::build(['driver'=>'local','root'=>storage_path($article->pathImg),])->files() as $item)
                                @if ($item!="profil.png")
                                    <a class="btn showImg" href="javascript:void(0)" data-toggle="tooltip" data-id="{{ url('storage') }}/images/{{ $article->nom.$article->id }}/{{ $item }}" data-original-title="Show" ><img src="{{ url('storage') }}/images/{{ $article->nom.$article->id }}/{{ $item }}" alt="Erreur Image" width="270" height="250"></a>
                                    @if (Auth::user()!=null&&$estMarchand)
                                        <input type="checkbox" name="{{$item}}" id="{{$item}}" class="form-check-input" onclick="showdelete()" value="1">                                    
                                    @endif
                                    <a href="#" class="btn"><img src="{{asset('imgs/space.jpg')}}" alt="" srcset="" width="5" height="250"></a>
                                @endif                                
                            @endforeach

                            <!--Ajout des images-->
                            @if (Auth::user()!=null&&$estMarchand)
                                <a href="javascript:void(0)" class="btn btn-secondary" id="addImg" data-toggle="tooltip" data-id="btnAdd" data-original-title="Add" ><img src="{{asset('imgs/plus.png')}}" alt="Erreur Image" width="270" height="250"></a>
                            @endif
                        </div>
                    </form><br><br>
                    
                    <div class="container card-text">
                        <h3 class="text-center text-warnig">{{ $article->marque()[0]->marque }}</h3>
                        <h4 class="text-center text-info text-dark">
                            @foreach ($article->modes() as $mode)
                                @if ($mode!=null)
                                    {{ $mode->mode." " }}
                                @endif
                            @endforeach  
                        </h4>
                        <div class="container-md"><h4 class="text-center text-info text-dark text-wrap"><strong>{{ $article->description }}</strong></h4></div>
                        @if ($article->type()->id == 1)
                            <h4 class="text-center text-info text-dark">{{'Tailles :' }}
                                @foreach ($article->tailles() as $taille)
                                    @if ($taille!=null)
                                        {{ $taille->taille." " }}
                                    @endif
                                @endforeach  
                            </h4>
                        @endif
                        <h4 class="text-center text-info text-dark">{{ 'Couleurs :' }}
                            @foreach ($article->couleurs() as $couleur)
                                @if ($couleur!=null)
                                    <td><a class="btn" style="background-color: {{ $couleur->color }}; border-color: black"></a></td>
                                @endif
                            @endforeach  
                        </h4>
                        <h4 class="text-end text-danger" style="border"><strong>{{ $article->prix." ".$article->devise }}</strong></h4>
                        
                        @if ($article->nbr==0)
                            <h5 class="text-end" style="background-color: red">
                                <strong>{{ $article->nbr.' Articles disponibles' }}</strong>
                            </h5>
                        @else
                            <h5 class="text-end">
                                <strong>{{ $article->nbr.' Articles disponibles' }}</strong>
                            </h5>
                        @endif
                        <h4 class="text-end text-info text-dark">{{ $article->marchand()->entreprise }}</h4>
                    </div>   
                </div>
                <div class="card-footer">
                    <table class="table table-bordered table-responsive table-sm">
                        <td align="left">
                            <button onclick="goBack()" class="btn btn-secondary">
                                <img src="{{asset('imgs/retour.png')}}" alt="Erreur Image" width="20" height="20">
                            </button>
                        </td>
                        @if (Auth::user()!=null&&$estMarchand)
                            @if ($article->nbr!=0)
                                <td align="right">
                                    <form action="{{ route('articles.edit',$article) }}" accept-charset="UTF-8" method="get">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">
                                            <img src="{{asset('imgs/modifier.png')}}" alt="Erreur Image" width="20" height="20">
                                        </button>
                                    </form>
                                </td>
                            @else
                                <td align="center">
                                    <form action="{{ route('articles.edit',$article) }}" accept-charset="UTF-8" method="get">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">
                                            <img src="{{asset('imgs/modifier.png')}}" alt="Erreur Image" width="20" height="20">
                                        </button>
                                    </form>
                                </td>
                                <td align="right">
                                    <form action="{{ route('articles.destroy',$article) }}" accept-charset="UTF-8" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Confirmez-vous la suppression de cet article ? Cela va aussi le supprimer des paniers')">
                                            <img src="{{asset('imgs/delete.png')}}" alt="Erreur Image" width="20" height="20">
                                        </button>
                                    </form>
                                </td>
                            @endif
                        @else
                            <td align="right">
                                <a href="#" class="btn btn-warning" id="panier"><img src="{{asset('imgs/panier.png')}}" alt="Erreur Image" width="20" height="20"></a>
                            </td>                         
                        @endif
                    </table><br>
                    <div class="card-title text-center">
                        <h6 style="color: #1b4652"><B>{{ "Autres de la même entreprise" }}</B></h6>
                        <div style="overflow: auto; white-space: nowrap;">
                            @foreach ($articlesMarchand as $art)
                                @if ($art->nbr>0)
                                    <a href="{{ route('articles.show',$art) }}" style="text-decoration: none; border-color: white; min-height: 500% ; background-image: url('{{ url('storage') }}/images/{{ $art->nom.$art->id }}/profil.png')" class="col-sm btn btn-outline-dark">
                                        <div class="card-text">
                                            <h4 class="text-center text-danger" style="background-color: darkblue; ">{{ $art->prix." ".$art->devise }}</h4>
                                        </div>
                                        <div class="card-img" style="overflow: auto; white-space: nowrap;">
                                            <img width="140" height="130" src="{{ url('storage') }}/images/{{ $art->nom.$art->id }}/profil.png" alt="Erreur Image">
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div><br>
                    <div class="card-title text-center">
                        <h6 style="color: rgb(69, 82, 27)"><B>{{ "Autres du même type" }}</B></h6>
                        <div style="overflow: auto; white-space: nowrap;">
                            @foreach ($articlesType as $art)
                                @if ($art->nbr>0)
                                    <a href="{{ route('articles.show',$art) }}" style="text-decoration: none; border-color: white; min-height: 500% ; background-image: url('{{ url('storage') }}/images/{{ $art->nom.$art->id }}/profil.png')" class="col-sm btn btn-outline-dark">
                                        <div class="card-text">
                                            <h4 class="text-center text-danger" style="background-color: darkblue; ">{{ $art->prix." ".$art->devise }}</h4>
                                        </div>
                                        <div class="card-img" style="overflow: auto; white-space: nowrap;">
                                            <img width="140" height="130" src="{{ url('storage') }}/images/{{ $art->nom.$art->id }}/profil.png" alt="Erreur Image">
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ajaxModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header justify-content-sm-center">
                <h4 class="modal-title" id="modalHeading" >{{ "Ajouter des images" }}</h4>
            </div>
            <div class="modal-body" id="form">
                {!! Form::open(array('route' => ['images',$article],'files'=>'true','id'=>'addImage')) !!}
                    <div class="row mb-3 justify-content-center">
                        <div class="justify-content-center" style="width: 70%">
                            {!! Form::file('photos[]', ["class"=>"form-control","multiple","id"=>"photos","accept"=>".png,.jpg,.jpeg"]) !!}
                            @error('photos')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-0">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary float-sm-none" id="saveBtn">
                                <img src="{{asset('imgs/save.png')}}" alt="Erreur Image" width="25" height="25">
                            </button>
                        </div>
                    </div>

                {!! Form::close() !!}
                <form method='POST' action='{{ route('panier') }}' id="addPanier">
                    @csrf
                    <div class='row mb-3'>
                        <label for='qte' class='col-md-4 col-form-label text-md-end'>{{ __('Quantité') }}</label>
                        <div class='col-md-3'>
                            <input type='hidden' name='article' id='article' value='{{ $article->id }}'>
                            @if (Auth::user()!=null)
                                <input type='hidden' name='user' id='user' value='{{ Auth::user()->id }}'>
                            @endif
                            <select name='qte' id='qte' class='form-control  form-select @error('qte') is-invalid @enderror' value='{{ old('qte') }}' autocomplete='qte' autofocus required>
                                <option value='0'>{{ '0' }}</option>
                                @for ($i = 1; $i <= $article->nbr; $i++)
                                    <option value='{{ $i }}'>{{ $i }}</option>
                                @endfor
                            </select>
                            @error('qte')<span class='invalid-feedback' role='alert'><strong>{{ $message }}</strong></span>@enderror
                        </div>
                    </div>
                    <div class='row mb-3'>
                        <label for='mode' class='col-md-4 col-form-label text-md-end'>{{ __('Mode') }}</label>
                        <div class='col-md-3'>
                            <table class='table table-bordered table-striped table-sm'>
                                @foreach ($article->modes() as $mode)
                                    <tr>
                                        <td>
                                            <label for='mode' class='form-check-label'>
                                                <input type='radio' name='moderadio' id='moderadio' value='{{ $mode->id }}'>{{ __($mode->mode) }}
                                            </label>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            @error('mode')<span class='invalid-feedback' role='alert'><strong>{{ $message }}</strong></span>@enderror
                        </div>
                    </div>
                    @if ($article->type()->id==1)
                        <div class='row mb-3'>
                            <label for='taille' class='col-md-4 col-form-label text-md-end'>{{ __('Taille') }}</label>
                            <div class='col-md-3'>
                                <table class='table table-bordered table-striped table-sm'>
                                    @foreach ($article->tailles() as $taille)
                                        <tr>
                                            <td>
                                                <label for='taille' class='form-check-label'>
                                                    <input type='radio' name='tailleradio' id='tailleradio' value='{{ $taille->id }}'>{{ __($taille->taille) }}
                                                </label>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                                @error('taille')<span class='invalid-feedback' role='alert'><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>
                    @endif
                    <div class='row mb-3'>
                        <label for='couleur' class='col-md-4 col-form-label text-md-end'>{{ __('Couleur') }}</label>
                        <div class='col-md-3'>
                            <table class='table table-bordered table-striped table-sm'>
                                @foreach ($article->couleurs() as $couleur)
                                    <tr>
                                        <td>
                                            <label for='couleur' class='form-check-label'>
                                                <input type='radio' name='couleurradio' id='couleurradio' value='{{ $couleur->id }}'>
                                                <a class='btn' style='background-color: {{ __(' '.$couleur->color) }}; border-color: black'></a>{{ $couleur->couleur }}
                                            </label>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            @error('couleur')<span class='invalid-feedback' role='alert'><strong>{{ $message }}</strong></span>@enderror
                        </div>
                        <div class='col-md-3'>
                            <button type='submit' class='btn btn-primary float-sm-none' id='saveBtn'>
                                <img src='{{asset('imgs/save.png')}}' alt='Erreur Image' width='25' height='25'>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="ajaxModalShow" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-dialog-centered" style="background-color: transparent">
            <div class="modal-body" id="body">
                <img src="#" id="image" alt='Erreur Image'>
            </div>
        </div>
    </div>
</div>  

@endsection
@section('script')
<script type="text/javascript">
    /*
        Apparution et disparution du bouton de suppression d'une image
    */
    function showdelete(){
        var cptm = 0, nbrInput = 0;
        $("form input").each(
            function(index){
                nbrInput++;
                var input = $(this);
                if(!input.is(":checked")){
                    cptm++;
                }
            }
        );
        
        if(cptm==nbrInput){
            window.document.getElementById('deleteButton').style.display='none';
        }else{
            window.document.getElementById('deleteButton').style.display='inline';
        }

    }
</script>
<script type="text/javascript">
    /*
        Popup modal pour l'ajout d'une ou plusieures images
    */
    $('#addImg').click(function(){
        $('#addPanier').attr('style','display : none');
        $('#ajaxModal').modal('show');
    });
</script>
<script type="text/javascript">
    /*
        Affichage d'une image en grand
    */
    $('body').on('click','.showImg', function(){
        var item = $(this).data('id');
        var width = document.documentElement.clientWidth;
        var height = document.documentElement.clientHeight;
        $('#ajaxModalShow').modal('show');
        $('#image').attr("src",item);
        $('#image').attr("width",(width-30));
    });
    $('#ajaxModalShow').click(function(){
        $('#ajaxModalShow').modal('hide');
    });
</script>
<script type="text/javascript">
/**
 * Ajout de la quantité de l'article et TOOODOOOO tailles
*/
    $('#panier').click(function(){
        $('#addImage').attr('style','display : none');
        $("#modalHeading").html("Renseigne la quantité et les tailles");
        $('#ajaxModal').modal('show');
    });    
</script>
@endsection