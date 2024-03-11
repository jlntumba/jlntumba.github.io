@extends('layouts.app') 


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center"><B>{{ __("Modification de l'article") }}</B></div>

                <div class="card-body">                   
                    <div class="text-center text-danger text-uppercase">                        
                        @if($errors->any())
                            <p>{{ $errors->first() }}</p>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('articles.update',$article) }}">
                        @csrf
                        @method('put')
                        <div class="row mb-3">
                            <label for="nom" class="col-md-4 col-form-label text-md-end">{{ __('Nom') }}</label>

                            <div class="col-md-6">
                                <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ $article->nom }}" required autocomplete="nom" autofocus>

                                @error('nom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <textarea name="description" id="description" cols="30" rows="10" class="form-control @error('nom') is-invalid @enderror" required style="height: 100px">{{ $article->description }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="prix" class="col-md-4 col-form-label text-md-end">{{ __('Prix') }}</label>
                    
                            <div class="col-md-2">
                                <input id="prix" type="number" class="form-control @error('prix') is-invalid @enderror" name="prix" value="{{ $article->prix }}" required autocomplete="prix" autofocus>
                    
                                @error('prix')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <select name="devise" id="devise" class="form-control  form-select @error('devise') is-invalid @enderror" value="{{ $article->devise }}" autocomplete="devise" autofocus required>
                                    @if ($article->devise=="$")
                                        <option value="{{ "$" }}">{{ "$" }}</option>
                                        <option value="{{ "€" }}">{{ "€" }}</option>
                                        <option value="{{ "FC" }}">{{ "FC" }}</option>
                                    @endif
                                    @if ($article->devise=="€")
                                        <option value="{{ "€" }}">{{ "€" }}</option>
                                        <option value="{{ "FC" }}">{{ "FC" }}</option>
                                        <option value="{{ "$" }}">{{ "$" }}</option>
                                    @endif
                                    @if ($article->devise=="FC")
                                        <option value="{{ "FC" }}">{{ "FC" }}</option>
                                        <option value="{{ "$" }}">{{ "$" }}</option>
                                        <option value="{{ "€" }}">{{ "€" }}</option>
                                    @endif
                                </select>
                                @error('devise')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="nbr" class="col-md-4 col-form-label text-md-end">{{ __('Nombre') }}</label>

                            <div class="col-md-2">
                                <input id="nbr" type="number" class="form-control @error('nbr') is-invalid @enderror" name="nbr" value="{{ $article->nbr }}" required autocomplete="nbr" autofocus>
                                @error('nbr')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="type" class="col-md-4 col-form-label text-md-end">{{ __('Type') }}</label>

                            <div class="col-md-6">
                                <select name="type" id="type" class="form-control  form-select @error('type') is-invalid @enderror" value="{{ old('type') }}" autocomplete="type" autofocus required>
                                    <option value="{{ $typeArt->id }}">{{ $typeArt->type }}</option>
                                    @foreach ($types as $item)
                                        <option value="{{ $item->id }}">{{ $item->type }}</option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @if (Auth::user()->roles()->contains(1))
                                <div class="col-md-1">
                                    <a href="javascript:void(0)" class="btn" id="plusType" data-toggle="tooltip" data-id="btnAdd" data-original-title="Add" ><img src="{{asset('imgs/plus.png')}}" alt="Erreur Image" width="20" height="20"></a>
                                </div>
                            @endif
                        </div>
                        <div class="row mb-3">
                            <label for="marque" class="col-md-4 col-form-label text-md-end">{{ __('Marque') }}</label>

                            <div class="col-md-6">
                                <select name="marque" id="marque" class="form-control  form-select @error('marque') is-invalid @enderror" value="{{ old('marque') }}" autocomplete="marque" autofocus required>
                                    <option value="{{ $marqueArt->id }}">{{ $marqueArt->marque }}</option>
                                    @foreach ($marques as $item)
                                        <option value="{{ $item->id }}">{{ $item->marque }}</option>
                                    @endforeach
                                </select>
                                @error('marque')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @if (Auth::user()->roles()->contains(1))
                                <div class="col-md-1">
                                    <a href="javascript:void(0)" class="btn" id="plusMarque" data-toggle="tooltip" data-id="btnAdd" data-original-title="Add" ><img src="{{asset('imgs/plus.png')}}" alt="Erreur Image" width="20" height="20"></a>
                                </div>
                            @endif
                        </div>
                        <div class="row mb-3">
                            <label for="modes" class="col-md-4 col-form-label text-md-end">{{ __('Modes') }}</label>
                            
                            <div class="col-md-2">
                                <table class="table table-bordered table-striped table-sm">
                                    @foreach ($modes as $item)
                                        <tr>
                                            <td>
                                                <input class="form-check-input" type="checkbox"  name="{{ "mode".$item->id }}" id="{{ $item->mode.$item->id }}" value="1" {{$modesArt->contains($item) ? 'checked' : '' }}>
                                                <label for="modes" class="form-check-label">
                                                    {{ __($item->mode) }}
                                                </label>

                                                @error( $item->id )
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            @if (Auth::user()->roles()->contains(1))
                                <div class="col-md-1">
                                    <a href="javascript:void(0)" class="btn" id="plusMode" data-toggle="tooltip" data-id="btnAdd" data-original-title="Add" ><img src="{{asset('imgs/plus.png')}}" alt="Erreur Image" width="20" height="20"></a>
                                </div>
                            @endif
                        </div>
                        <div class="row mb-3" id="taillesDiv">
                            <label for="tailles" class="col-md-4 col-form-label text-md-end">{{ __('Tailles') }}</label>
                            
                            <div class="col-md-2">
                                <table class="table table-bordered table-striped table-sm">
                                    @foreach ($tailles as $item)
                                        <tr>
                                            <td>
                                                <input class="form-check-input" type="checkbox"  name="{{ "taille".$item->id }}" id="{{ $item->taille.$item->id }}" value="1" {{$taillesArt->contains($item) ? 'checked' : '' }}>
                                                <label for="tailles" class="form-check-label">
                                                    {{ __($item->taille) }}
                                                </label>

                                                @error( $item->id )
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            @if (Auth::user()->roles()->contains(1))
                                <div class="col-md-1">
                                    <a href="javascript:void(0)" class="btn" id="plusTaille" data-toggle="tooltip" data-id="btnAdd" data-original-title="Add" ><img src="{{asset('imgs/plus.png')}}" alt="Erreur Image" width="20" height="20"></a>
                                </div>
                            @endif
                        </div>
                        <div class="row mb-3">
                            <label for="couleurs" class="col-md-4 col-form-label text-md-end">{{ __('Couleurs') }}</label>
                            
                            <div class="col-md-2">
                                <table class="table table-bordered table-striped table-sm">
                                    @foreach ($couleurs as $item)
                                        <tr>
                                            <td>
                                                <input class="form-check-input" type="checkbox"  name="{{ "couleur".$item->id }}" id="{{ $item->couleur.$item->id }}" value="1" {{$couleursArt->contains($item) ? 'checked' : '' }}>
                                                <a class="btn" style="background-color: {{ $item->color }}; border-color: black"></a>
                                                <label for="couleurs" class="form-check-label">
                                                    {{ __($item->couleur) }}
                                                </label>

                                                @error( $item->id )
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            @if (Auth::user()->roles()->contains(1))
                                <div class="col-md-1">
                                    <a href="javascript:void(0)" class="btn" id="plusCouleur" data-toggle="tooltip" data-id="btnAdd" data-original-title="Add" ><img src="{{asset('imgs/plus.png')}}" alt="Erreur Image" width="20" height="20"></a>
                                </div>
                            @endif
                            <div class="row mb-0">
                                <div class="col-md-7 offset-md-4">
                                    <button type="submit" class="btn btn-primary float-sm-end" id="btn">
                                        <img src="{{asset('imgs/save.png')}}" alt="Erreur Image" width="25" height="25">
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <table  class="table table-borderless table-responsive table-sm">
                        <td align="left">
                            <button onclick="goBack()" class="btn btn-secondary">
                                <img src="{{asset('imgs/retour.png')}}" alt="Erreur Image" width="25" height="25">
                            </button>
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
                <h4 class="modal-title" id="modalHeading" ></h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="" id="form">
                    @csrf
                    <div class="row mb-3 justify-content-center">
                        <div class="justify-content-center" style="width: 70%">
                            <input type="hidden" name="typeID" id="typeID">
                            <input id="input" type="text" class="form-control" name="" value="" required autofocus placeholder="">
                        </div>
                    </div>
                    <div class="row mb-3  justify-content-center">
                        <div class="justify-content-center" style="width: 70%">
                            <input id="descript" style="display: none" type="text" class="form-control" name="descript" value="{{ old('descript') }}" autofocus placeholder="Entrer une courte description">
                        </div>
                    </div>
                    <div class="row mb-3  justify-content-center">
                        <div class="justify-content-center" style="width: 70%">
                            <input id="color" style="display: none" type="text" class="form-control" name="color" value="{{ old('color') }}" autofocus placeholder="English/Anglais">
                        </div>
                    </div>
                    <div class="row mb-0">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary float-sm-none" id="saveBtn">
                                <img src="{{asset('imgs/save.png')}}" alt="Erreur Image" width="25" height="25">
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script type="text/javascript">

        var type = $('#type').val();
        if (type!=1) {
            $('#taillesDiv').attr('style',"display : none");
        }

        /*
            Popup modal pour l'ajout d'une marque
        */
        $('#plusMarque').click(function(){
            var typeID = $('#type').val();
            $("#form").trigger("reset");
            $('#modalHeading').html('Ajouter une marque');
            $('#form').attr("action","{{ route('marqueU',$article) }}");
            $("#input").attr("name","marque");
            $("#input").attr("placeholder","Nom de la marque");
            $("#input").attr("value","{{ old('marque') }}");
            $("#typeID").attr("value",typeID);
            $('#ajaxModal').modal('show');
        });
        /*
            Popup modal pour l'ajout d'une mode
        */
        $('#plusMode').click(function(){
            $("#form").trigger("reset");
            $('#modalHeading').html('Ajouter une mode');
            $('#form').attr("action","{{ route('modeU',$article) }}");
            $("#input").attr("name","mode");
            $("#input").attr("placeholder","Nom de la mode");
            $("#input").attr("value","{{ old('mode') }}");
            $('#ajaxModal').modal('show');
        });
        /*
            Popup modal pour l'ajout d'un type
        */
        $('#plusType').click(function(){
            $("#form").trigger("reset");
            $('#modalHeading').html('Ajouter un type');
            $('#form').attr("action","{{ route('typeU',$article) }}");
            $("#input").attr("name","type");
            $("#input").attr("placeholder","Nom du type");
            $("#input").attr("value","{{ old('type') }}");
            $('#ajaxModal').modal('show');
        });
        /*
            Popup modal pour l'ajout d'une taille
        */
        $('#plusTaille').click(function(){
            $("#form").trigger("reset");
            $('#modalHeading').html('Ajouter une taille');
            $('#form').attr("action","{{ route('tailleU',$article) }}");
            $("#input").attr("name","taille");
            $("#input").attr("placeholder","Nom de la taille");
            $("#input").attr("value","{{ old('taille') }}");            
            $("#descript").attr("style","display: block");
            $('#ajaxModal').modal('show');
        });
        /*
            Popup modal pour l'ajout d'une couleur
        */
        $('#plusCouleur').click(function(){
            $("#form").trigger("reset");
            $('#modalHeading').html('Ajouter une couleur');
            $('#form').attr("action","{{ route('couleurU',$article) }}");
            $("#input").attr("name","couleur");
            $("#input").attr("placeholder","Nom de la couleur");
            $("#input").attr("value","{{ old('couleur') }}");            
            $("#color").attr("style","display: block");
            $('#ajaxModal').modal('show');
        });
    </script>
    <script type="text/javascript">
        (function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#type').on("change",function(){
                var type = $('#type').val();
                if (type!="") {
                    $('#marqueDiv').attr('style','display : flex');
                    $.ajax({
                        url:"{{ route('listMarques') }}",
                        type : "get", //method
                        async:true,
                        data:{type:$('#type').val()},
                        dataType : 'json',
                        success:function(data){
                            var marque = "";
                            marque = marque + "<option value=''></option>";
                            data.forEach(e => {
                                marque = marque + "<option value='"+e.id+"'>"+e.marque+"</option>";
                            });
                            $('#marque').html(marque);
                        },
                        error:function(response){
                            if(response.status==500){
                                console.log("error");
                            }
                        }
                    });
                    if (type==1) {
                        $('#taillesDiv').attr('style','display : flex');
                    }else{
                        $('#taillesDiv').attr('style','display : none');
                    }
                } else {
                    $('#taillesDiv').attr('style','display : none');
                    $('#marqueDiv').attr('style','display : none');
                }
            });
        })();
    </script>
@endsection