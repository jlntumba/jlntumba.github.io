@extends('layouts.app') 


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>
                            <strong>
                                {{"Gestion des articles : ".$count}} 
                            </strong>
                        </h4>
                        <div class="input-group">
                            <div class="input-group">
                                <a href="#" class="form-control btn btn-outline-success"   id="modeBtn">{{ "Mode" }}</a>                                
                                <select name="mode" id="mode" style="display: none" class="form-control form-select">
                                    <option value="">{{ "Mode" }}</option>
                                    @foreach ($modes as $mode)
                                        <option value="{{ $mode->id }}">{{ $mode->mode }}</option>
                                    @endforeach
                                </select>
                                <input type="text" name="modeSrch" id="modeSrch" style="display: none" class="form-control input-group-text" placeholder="Je cherche...">
                                    
                                <a href="#" class="form-control btn btn-outline-success"   id="typeBtn">{{ "Type" }}</a>
                                <select name="type" id="type" style="display: none" class="form-control form-select">
                                    <option value="">{{ "Type" }}</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->type }}</option>
                                    @endforeach
                                </select>
                                <select name="marque" id="marque" style="display: none" class="form-control form-select">
                                    
                                </select>
                                <input type="text" name="marqueSrch" id="marqueSrch" style="display: none" class="form-control input-group-text" placeholder="Je cherche...">
                              
                                <a href="#" class="form-control btn btn-outline-success"   id="couleurBtn">{{ "Couleur" }}</a>
                                <select name="couleur" id="couleur" style="display: none" class="form-control form-select">
                                    <option value="">{{ "Couleur" }}</option>
                                    @foreach ($couleurs as $couleur)
                                        <option value="{{ $couleur->id }}" style="background-color: {{ $couleur->color }}">{{ $couleur->couleur }}</option>
                                    @endforeach
                                </select>
                                <input type="text" name="couleurSrch" id="couleurSrch" style="display: none" class="form-control input-group-text" placeholder="Je cherche...">

                                <a href="#" class="form-control btn btn-outline-success"   id="tailleBtn">{{ "Taille" }}</a>
                                <select name="taille" id="taille" style="display: none" class="form-control form-select">
                                    <option value="">{{ "Taille" }}</option>
                                    @foreach ($tailles as $taille)
                                        <option value="{{ $taille->id }}">{{ $taille->taille }}</option>
                                    @endforeach
                                </select>
                                <input type="text" name="tailleSrch" id="tailleSrch" style="display: none" class="form-control input-group-text" placeholder="Je cherche...">

                            </div>
                        </div> 
                    </div>
                    
                    <div class="card-body" style="overflow: auto; white-space: nowrap;">
                        <div>
                            <form action="{{ route('articles.create') }}" accept-charset="UTF-8" method="get">
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

                        <form action="{{ route('articles.index') }}" method="get">
                            <div class="position-absolute">
                                <button type="submit" class="btn btn-warning" id="deleteButton" onclick="return confirm('Confirmez-vous la suppression de cet (ces) articles(s) ?')" style="display: none">
                                    <img src="{{asset('imgs/delete.png')}}" alt="Erreur Image" width="20" height="20">
                                </button>
                            </div>
                            <div id="table">
                                <table class="table table-bordered table-striped table-responsive">
                                    <thead>
                                        <tr>
                                        <th>{{ "N°" }}</th>
                                        <th >{{ "Photo" }}</th>
                                        <th >{{ "Nom" }}</th>
                                        <th >{{ "Prix" }}</th>
                                        <th >{{ "Nombre" }}</th>
                                        <th >{{ "Qté vendue" }}</th>
                                        <th >{{ "Marque" }}</th>
                                        <th >{{ "Mode" }}</th>
                                        <th >{{ "Tailles" }}</th>
                                        <th >{{ "Couleurs" }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($articles->isEmpty())
                                            <td>0</td>
                                            <td>{{ "Aucun Article" }}</td>
                                        @endif
                                        @foreach ($articles as $article)
                                            <tr>
                                                <td>{{$cpt++}}</td>
                                                <td align="center">
                                                    <div class="card-img">
                                                        <img src="{{ url('storage') }}/images/{{ $article->nom.$article->id }}/profil.png" alt="Erreur Image" width="180" height="150">
                                                    </div>
                                                </td>
                                                <td align="center">{{ $article->nom }}</td>
                                                <td align="center">{{ $article->prix." ".$article->devise }}</td>
                                                @if ($article->nbr==0)
                                                    <td align="center" style="background-color: red">{{ $article->nbr }}</td>
                                                @else
                                                    <td align="center"><strong>{{ $article->nbr }}</strong></td>
                                                @endif
                                                <td align="center">{{ $article->nbrVendus }}</td>
                                                <td align="center">{{ $article->marque()[0]->marque }}</td>
                                                <td align="center">
                                                    @foreach ($article->modes() as $mode)
                                                    @if ($mode!=null)
                                                        {{ $mode->mode." " }}<br>
                                                    @endif
                                                    @endforeach 
                                                </td>
                                                <td align="center">
                                                    @foreach ($article->tailles() as $taille)
                                                    @if ($taille!=null)
                                                        {{ $taille->taille." " }}<br>
                                                    @endif
                                                    @endforeach    
                                                </td>
                                                <td align="center">
                                                    @foreach ($article->couleurs() as $couleur)
                                                    @if ($couleur!=null)
                                                        <a class="btn" style="background-color: {{ $couleur->color }}; border-color: black"></a><br>
                                                    @endif
                                                    @endforeach    
                                                </td>
                                                <td align="center">
                                                    <a href="{{route('articles.show',$article)}}" class="btn btn-success"><img src="{{asset('imgs/vue.png')}}" alt="Erreur Image" width="20" height="20"></a>
                                                </td>
                                                <td align="center">
                                                    <input type="checkbox" name="{{$article->id}}" id="{{$article->id}}" class="form-check-input" onclick="showdelete()" value="1" {{ $article->nbr>0 ? 'disabled' : '' }}>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <img src="{{asset('imgs/LOGO Plus.png')}}" alt="Erreur Image" width="9%">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        /*
            Apparution et disparution du bouton de suppression d'un article
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
        var cptMO = 0;
        (function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#modeBtn').on("click",function(){
                if (cptMO%2==0) {
                    $('#modeBtn').html('<B>Mode</B>');
                    $('#modeBtn').attr("class","form-control btn btn-success");
                    $('#typeBtn').attr("style","display: none");
                    $('#tailleBtn').attr("style","display: none");
                    $('#couleurBtn').attr("style","display: none");
                    $('#marqueBtn').attr("style","display: none");
                    $('#mode').attr("style","display: block");
                    cptMO++;

                    /**
                     * Liste articles par mode
                     * */
                    $.ajax({
                        url:"{{ route('byMode') }}",
                        type : "get", //method
                        async:true,
                        dataType : 'json',
                        success:function(data){
                            var table = "";
                            var cpt = 0;
                            data.forEach(e => {
                                if (cpt%2==0) {
                                    table = table +"<div class='dropdown-divider'></div><table class='table table-bordered table-striped table-responsive'><thead><tr class='text-center'><h4 class='text-center' style='color: darkblue'><B>"+e.mode+"</B></h4></tr>";
                                    table = table +"<tr><th>{{ 'N°' }}</th><th >{{ 'Photo' }}</th><th >{{ 'Nom' }}</th><th >{{ 'Prix' }}</th><th>{{ 'Nombre' }}</th><th>{{ 'Qté vendue' }}</th></thead><tbody>";
                                    cpt++;
                                } else {
                                    if (e==null||e=="") {
                                        table = table +"<tr class='text-center'><td>Aucun Article</td></tr>";
                                    } else {
                                        var y=1;
                                        e.forEach(i => {
                                            table = table +"<tr><td>"+y+"</td><td align='center'><div class='card-img'><img src='{{ url('storage') }}/images/"+i.nom+i.id+"/profil.png' alt='Erreur Image' width='180' height='150'></div></td>";
                                            table = table +"<td align='center'>"+i.nom+"</td>";
                                            table = table +"<td align='center'>"+i.prix+" "+i.devise+"</td>";
                                            if (i.nbr==0) {
                                                table = table +"<td align='center' style='background-color: red'>"+i.nbr+"</td>";
                                            } else {
                                                table = table +"<td align='center'><strong>"+i.nbr+"</strong></td>";
                                            }
                                            table = table + "<td align='center'>"+i.nbrVendus+"</td>";
                                            table = table +"<td align='center'><a href='articles/"+i.id+"' class='btn btn-success'><img src='{{asset('imgs/vue.png')}}' alt='Erreur Image' width='20' height='20'></a></td>";
                                            if (i.nbr>0) {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1' disabled></td></tr>";  
                                            } else {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1'></td></tr>";     
                                            }
                                            y++;
                                        });                                        
                                    }
                                    table = table +"</tbody></table>";
                                    cpt++;
                                }
                            });
                            $('#table').html(table);
                        },
                        error:function(response){
                            if(response.status==500){
                                console.log(response);
                            }
                        }
                    });

                } else {
                    $('#modeBtn').html('Mode');
                    $('#modeBtn').attr("class","form-control btn btn-outline-success");
                    $('#typeBtn').attr("style","display: block");
                    $('#tailleBtn').attr("style","display: block");
                    $('#couleurBtn').attr("style","display: block");
                    $('#marqueBtn').attr("style","display: block");
                    $('#mode').attr("style","display: none");
                    $('#modeSrch').attr("style","display: none");
                    cptMO++;

                    /**
                     * Refresh articles.index
                     * */
                    $.ajax({
                        success:function(data){
                            window.location.href="{{ route('articles.index') }}";
                        },
                        error:function(response){
                            if(response.status==500){
                                console.log("error");
                            }
                        }
                    });
                }
            });

            /***
             * Choix d'une mode pour affiner la liste
             * */
            $('#mode').on("change",function(){
                var mode = $('#mode').val();
                if (mode==null||mode=="") {
                    $('#modeSrch').attr("style","display: none");
                    /**
                     * Liste articles par mode
                     * */
                     $.ajax({
                        url:"{{ route('byMode') }}",
                        type : "get", //method
                        async:true,
                        dataType : 'json',
                        success:function(data){
                            var table = "";
                            var cpt = 0;
                            data.forEach(e => {
                                if (cpt%2==0) {
                                    table = table +"<div class='dropdown-divider'></div><table class='table table-bordered table-striped table-responsive'><thead><tr class='text-center'><h4 class='text-center' style='color: darkblue'><B>"+e.mode+"</B></h4></tr>";
                                    table = table +"<tr><th>{{ 'N°' }}</th><th >{{ 'Photo' }}</th><th >{{ 'Nom' }}</th><th >{{ 'Prix' }}</th><th >{{ 'Nombre' }}</th><th>{{ 'Qté vendue' }}</th></thead><tbody>";
                                    cpt++;
                                } else {
                                    if (e==null||e=="") {
                                        table = table +"<tr class='text-center'><td>Aucun Article</td></tr>";
                                    } else {
                                        var y=1;
                                        e.forEach(i => {
                                            table = table +"<tr><td>"+y+"</td><td align='center'><div class='card-img'><img src='{{ url('storage') }}/images/"+i.nom+i.id+"/profil.png' alt='Erreur Image' width='180' height='150'></div></td>";
                                            table = table +"<td align='center'>"+i.nom+"</td>";
                                            table = table +"<td align='center'>"+i.prix+" "+i.devise+"</td>";
                                            if (i.nbr==0) {
                                                table = table +"<td align='center' style='background-color: red'>"+i.nbr+"</td>";
                                            } else {
                                                table = table +"<td align='center'><strong>"+i.nbr+"</strong></td>";
                                            }
                                            table = table + "<td align='center'>"+i.nbrVendus+"</td>";
                                            table = table +"<td align='center'><a href='articles/"+i.id+"' class='btn btn-success'><img src='{{asset('imgs/vue.png')}}' alt='Erreur Image' width='20' height='20'></a></td>";
                                            if (i.nbr>0) {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1' disabled></td></tr>";  
                                            } else {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1'></td></tr>";     
                                            }
                                            y++;
                                        });                                        
                                    }
                                    table = table +"</tbody></table>";
                                    cpt++;
                                }
                            });
                            $('#table').html(table);
                        },
                        error:function(response){
                            if(response.status==500){
                                console.log(response);
                            }
                        }
                    });
                } else {
                    $('#modeSrch').attr("style","display: block");
                    $.ajax({
                        url:"{{ route('byOneMode') }}",
                        type : "post", //method
                        async:true,
                        data:{modeId:$('#mode').val(),search:$('#modeSrch').val()},
                        dataType : 'json',
                        success:function(data){
                            var table = "";
                            var cpt = 0;
                            data.forEach(e => {
                                if (cpt%2==0) {
                                    table = table +"<div class='dropdown-divider'></div><table class='table table-bordered table-striped table-responsive'><thead><tr class='text-center'><h4 class='text-center' style='color: darkblue'><B>"+e.mode+"</B></h4></tr>";
                                    table = table +"<tr><th>{{ 'N°' }}</th><th >{{ 'Photo' }}</th><th >{{ 'Nom' }}</th><th >{{ 'Prix' }}</th><th >{{ 'Nombre' }}</th><th>{{ 'Qté vendue' }}</th></thead><tbody>";
                                    cpt++;
                                } else {
                                    if (e==null||e=="") {
                                        table = table +"<tr class='text-center'><td>Aucun Article</td></tr>";
                                    } else {
                                        var y=1;
                                        e.forEach(i => {
                                            table = table +"<tr><td>"+y+"</td><td align='center'><div class='card-img'><img src='{{ url('storage') }}/images/"+i.nom+i.id+"/profil.png' alt='Erreur Image' width='180' height='150'></div></td>";
                                            table = table +"<td align='center'>"+i.nom+"</td>";
                                            table = table +"<td align='center'>"+i.prix+" "+i.devise+"</td>";
                                            if (i.nbr==0) {
                                                table = table +"<td align='center' style='background-color: red'>"+i.nbr+"</td>";
                                            } else {
                                                table = table +"<td align='center'><strong>"+i.nbr+"</strong></td>";
                                            }
                                            table = table + "<td align='center'>"+i.nbrVendus+"</td>";
                                            table = table +"<td align='center'><a href='articles/"+i.id+"' class='btn btn-success'><img src='{{asset('imgs/vue.png')}}' alt='Erreur Image' width='20' height='20'></a></td>";
                                            if (i.nbr>0) {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1' disabled></td></tr>";  
                                            } else {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1'></td></tr>";     
                                            }
                                            y++;
                                        });                                        
                                    }
                                    table = table +"</tbody></table>";
                                    cpt++;
                                }
                            });
                            $('#table').html(table);
                        },
                        error:function(response){
                            if(response.status==500){
                                console.log(response);
                            }
                        }
                    });
                }
            });

            /***
             * Barre de recher pour affiner encore plus
             * */
            $('#modeSrch').on("input",function(){
                $.ajax({
                    url:"{{ route('byOneMode') }}",
                    type : "post", //method
                    async:true,
                    data:{modeId:$('#mode').val(),search:$('#modeSrch').val()},
                    dataType : 'json',
                    success:function(data){
                        var table = "";
                        var cpt = 0;
                        data.forEach(e => {
                            if (cpt%2==0) {
                                table = table +"<div class='dropdown-divider'></div><table class='table table-bordered table-striped table-responsive'><thead><tr class='text-center'><h4 class='text-center' style='color: darkblue'><B>"+e.mode+"</B></h4></tr>";
                                table = table +"<tr><th>{{ 'N°' }}</th><th >{{ 'Photo' }}</th><th >{{ 'Nom' }}</th><th >{{ 'Prix' }}</th><th >{{ 'Nombre' }}</th><th>{{ 'Qté vendue' }}</th></thead><tbody>";
                                cpt++;
                            } else {
                                if (e==null||e=="") {
                                    table = table +"<tr class='text-center'><td>Aucun Article</td></tr>";
                                } else {
                                    var y=1;
                                    e.forEach(i => {
                                        table = table +"<tr><td>"+y+"</td><td align='center'><div class='card-img'><img src='{{ url('storage') }}/images/"+i.nom+i.id+"/profil.png' alt='Erreur Image' width='180' height='150'></div></td>";
                                        table = table +"<td align='center'>"+i.nom+"</td>";
                                        table = table +"<td align='center'>"+i.prix+" "+i.devise+"</td>";
                                        if (i.nbr==0) {
                                            table = table +"<td align='center' style='background-color: red'>"+i.nbr+"</td>";
                                        } else {
                                            table = table +"<td align='center'><strong>"+i.nbr+"</strong></td>";
                                        }
                                        table = table + "<td align='center'>"+i.nbrVendus+"</td>";
                                        table = table +"<td align='center'><a href='articles/"+i.id+"' class='btn btn-success'><img src='{{asset('imgs/vue.png')}}' alt='Erreur Image' width='20' height='20'></a></td>";
                                        if (i.nbr>0) {
                                            table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1' disabled></td></tr>";  
                                        } else {
                                            table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1'></td></tr>";     
                                        }
                                    y++;
                                    });                                        
                                }
                                table = table +"</tbody></table>";
                                cpt++;
                            }
                        });
                        $('#table').html(table);
                    },
                    error:function(response){
                        if(response.status==500){
                            console.log(response);
                        }
                    }
                });
            });
        })();
    </script>
    <script type="text/javascript">
        var cptTY = 0;
        (function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#typeBtn').on("click",function(){
                if (cptTY%2==0) {
                    $('#typeBtn').html('<B>Type</B>');
                    $('#typeBtn').attr("class","form-control btn btn-success");
                    $('#modeBtn').attr("style","display: none");
                    $('#tailleBtn').attr("style","display: none");
                    $('#couleurBtn').attr("style","display: none");
                    $('#marqueBtn').attr("style","display: none");
                    $('#type').attr("style","display: block");
                    cptTY++;
                    
                    /**
                     * Liste articles par type
                     * */
                    $.ajax({
                        url:"{{ route('byType') }}",
                        type : "get", //method
                        async:true,
                        dataType : 'json',
                        success:function(data){
                            var table = "";
                            var cpt = 0;
                            data.forEach(e => {
                                if (cpt%2==0) {
                                    table = table +"<div class='dropdown-divider'></div><table class='table table-bordered table-striped table-responsive'><thead><tr class='text-center'><h4 class='text-center' style='color: darkblue'><B>"+e.type+"</B></h4></tr>";
                                    table = table +"<tr><th>{{ 'N°' }}</th><th >{{ 'Photo' }}</th><th >{{ 'Nom' }}</th><th >{{ 'Prix' }}</th><th >{{ 'Nombre' }}</th><th>{{ 'Qté vendue' }}</th></thead><tbody>";
                                    cpt++;
                                } else {
                                    if (e==null||e=="") {
                                        table = table +"<tr class='text-center'><td>Aucun Article</td></tr>";
                                    } else {
                                        var y=1;
                                        e.forEach(i => {
                                            table = table +"<tr><td>"+y+"</td><td align='center'><div class='card-img'><img src='{{ url('storage') }}/images/"+i.nom+i.id+"/profil.png' alt='Erreur Image' width='180' height='150'></div></td>";
                                            table = table +"<td align='center'>"+i.nom+"</td>";
                                            table = table +"<td align='center'>"+i.prix+" "+i.devise+"</td>";
                                            if (i.nbr==0) {
                                                table = table +"<td align='center' style='background-color: red'>"+i.nbr+"</td>";
                                            } else {
                                                table = table +"<td align='center'><strong>"+i.nbr+"</strong></td>";
                                            }
                                            table = table + "<td align='center'>"+i.nbrVendus+"</td>";
                                            table = table +"<td align='center'><a href='articles/"+i.id+"' class='btn btn-success'><img src='{{asset('imgs/vue.png')}}' alt='Erreur Image' width='20' height='20'></a></td>";
                                            if (i.nbr>0) {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1' disabled></td></tr>";  
                                            } else {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1'></td></tr>";     
                                            }
                                            y++;
                                        });                                        
                                    }
                                    table = table +"</tbody></table>";
                                    cpt++;
                                }
                            });
                            $('#table').html(table);
                        },
                        error:function(response){
                            if(response.status==500){
                                console.log(response);
                            }
                        }
                    });
                } else {
                    $('#typeBtn').html('Type');
                    $('#typeBtn').attr("class","form-control btn btn-outline-success");
                    $('#modeBtn').attr("style","display: block");
                    $('#tailleBtn').attr("style","display: block");
                    $('#couleurBtn').attr("style","display: block");
                    $('#marqueBtn').attr("style","display: block");
                    $('#type').attr("style","display: none");
                    $('#typeSrch').attr("style","display: none");
                    cptTY++;

                    /**
                     * Refresh articles.index
                     * */
                    $.ajax({
                        success:function(data){
                            window.location.href="{{ route('articles.index') }}";
                        },
                        error:function(response){
                            if(response.status==500){
                                console.log("error");
                            }
                        }
                    });
                }
            });

            /***
             * Choix d'un type pour affiner la liste
             * */
            $('#type').on("change",function(){
                var type = $('#type').val();
                if (type==null||type=="") {
                    $('#marque').attr("style","display: none");
                    $.ajax({
                        url:"{{ route('byType') }}",
                        type : "get", //method
                        async:true,
                        dataType : 'json',
                        success:function(data){
                            var table = "";
                            var cpt = 0;
                            data.forEach(e => {
                                if (cpt%2==0) {
                                    table = table +"<div class='dropdown-divider'></div><table class='table table-bordered table-striped table-responsive'><thead><tr class='text-center'><h4 class='text-center' style='color: darkblue'><B>"+e.type+"</B></h4></tr>";
                                    table = table +"<tr><th>{{ 'N°' }}</th><th >{{ 'Photo' }}</th><th >{{ 'Nom' }}</th><th >{{ 'Prix' }}</th><th >{{ 'Nombre' }}</th><th>{{ 'Qté vendue' }}</th></thead><tbody>";
                                    cpt++;
                                } else {
                                    if (e==null||e=="") {
                                        table = table +"<tr class='text-center'><td>Aucun Article</td></tr>";
                                    } else {
                                        var y=1;
                                        e.forEach(i => {
                                            table = table +"<tr><td>"+y+"</td><td align='center'><div class='card-img'><img src='{{ url('storage') }}/images/"+i.nom+i.id+"/profil.png' alt='Erreur Image' width='180' height='150'></div></td>";
                                            table = table +"<td align='center'>"+i.nom+"</td>";
                                            table = table +"<td align='center'>"+i.prix+" "+i.devise+"</td>";
                                            if (i.nbr==0) {
                                                table = table +"<td align='center' style='background-color: red'>"+i.nbr+"</td>";
                                            } else {
                                                table = table +"<td align='center'><strong>"+i.nbr+"</strong></td>";
                                            }
                                            table = table + "<td align='center'>"+i.nbrVendus+"</td>";
                                            table = table +"<td align='center'><a href='articles/"+i.id+"' class='btn btn-success'><img src='{{asset('imgs/vue.png')}}' alt='Erreur Image' width='20' height='20'></a></td>";
                                            if (i.nbr>0) {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1' disabled></td></tr>";  
                                            } else {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1'></td></tr>";     
                                            }
                                            y++;
                                        });                                        
                                    }
                                    table = table +"</tbody></table>";
                                    cpt++;
                                }
                            });
                            $('#table').html(table);
                        },
                        error:function(response){
                            if(response.status==500){
                                console.log(response);
                            }
                        }
                    });
                } else {
                    $.ajax({
                        url:"{{ route('byOneType') }}",
                        type : "post", //method
                        async:true,
                        data:{typeId:$('#type').val()},
                        dataType : 'json',
                        success:function(data){
                            var table = "";
                            var cpt = 0;
                            data.forEach(e => {
                                if (cpt==0) {
                                    table = table +"<div class='dropdown-divider'></div><table class='table table-bordered table-striped table-responsive'><thead><tr class='text-center'><h4 class='text-center' style='color: darkblue'><B>"+e.type+"</B></h4></tr>";
                                    table = table +"<tr><th>{{ 'N°' }}</th><th >{{ 'Photo' }}</th><th >{{ 'Nom' }}</th><th >{{ 'Prix' }}</th><th >{{ 'Nombre' }}</th><th>{{ 'Qté vendue' }}</th></thead><tbody>";
                                } 
                                if(cpt==1) {
                                    if (e==null||e=="") {
                                        table = table +"<tr class='text-center'><td>Aucun Article</td></tr>";
                                    } else {
                                        var y=1;
                                        e.forEach(i => {
                                            table = table +"<tr><td>"+y+"</td><td align='center'><div class='card-img'><img src='{{ url('storage') }}/images/"+i.nom+i.id+"/profil.png' alt='Erreur Image' width='180' height='150'></div></td>";
                                            table = table +"<td align='center'>"+i.nom+"</td>";
                                            table = table +"<td align='center'>"+i.prix+" "+i.devise+"</td>";
                                            if (i.nbr==0) {
                                                table = table +"<td align='center' style='background-color: red'>"+i.nbr+"</td>";
                                            } else {
                                                table = table +"<td align='center'><strong>"+i.nbr+"</strong></td>";
                                            }
                                            table = table + "<td align='center'>"+i.nbrVendus+"</td>";
                                            table = table +"<td align='center'><a href='articles/"+i.id+"' class='btn btn-success'><img src='{{asset('imgs/vue.png')}}' alt='Erreur Image' width='20' height='20'></a></td>";
                                            if (i.nbr>0) {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1' disabled></td></tr>";  
                                            } else {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1'></td></tr>";     
                                            }
                                            y++;
                                        });                                        
                                    }
                                    table = table +"</tbody></table>";
                                }
                                if (cpt==2) {
                                    var marqueSelect = "";
                                    marqueSelect = marqueSelect + "<option value=''>{{ 'Marque' }}</option>";
                                    e.forEach(a => {
                                        marqueSelect = marqueSelect + "<option value="+a.id+">"+a.marque+"</option>";
                                    });
                                    $('#marque').html(marqueSelect);
                                    $('#marque').attr("style","display: block");
                                }
                                cpt++;
                            });
                            $('#table').html(table);
                        },
                        error:function(response){
                            if(response.status==500){
                                console.log(response);
                            }
                        }
                    });
                }
            });
        })();
    </script>
    <script type="text/javascript">
        var cptTY = 0;
        (function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#couleurBtn').on("click",function(){
                if (cptTY%2==0) {
                    $('#couleurBtn').html('<B>Couleur</B>');
                    $('#couleurBtn').attr("class","form-control btn btn-success");
                    $('#modeBtn').attr("style","display: none");
                    $('#tailleBtn').attr("style","display: none");
                    $('#typeBtn').attr("style","display: none");
                    $('#marqueBtn').attr("style","display: none");
                    $('#couleur').attr("style","display: block");
                    cptTY++;
                    
                    /**
                     * Liste articles par type
                     * */
                    $.ajax({
                        url:"{{ route('byCouleur') }}",
                        type : "get", //method
                        async:true,
                        dataType : 'json',
                        success:function(data){
                            var table = "";
                            var cpt = 0;
                            data.forEach(e => {
                                if (cpt%2==0) {
                                    table = table +"<div class='dropdown-divider'></div><table class='table table-bordered table-striped table-responsive'><thead><tr class='text-center'><h4 class='text-center' style='background-color: "+e.color+"'><B>"+e.couleur+"</B></h4></tr>";
                                    table = table +"<tr><th>{{ 'N°' }}</th><th >{{ 'Photo' }}</th><th >{{ 'Nom' }}</th><th >{{ 'Prix' }}</th><th >{{ 'Nombre' }}</th><th>{{ 'Qté vendue' }}</th></thead><tbody>";
                                    cpt++;
                                } else {
                                    if (e==null||e=="") {
                                        table = table +"<tr class='text-center'><td>Aucun Article</td></tr>";
                                    } else {
                                        var y=1;
                                        e.forEach(i => {
                                            table = table +"<tr><td>"+y+"</td><td align='center'><div class='card-img'><img src='{{ url('storage') }}/images/"+i.nom+i.id+"/profil.png' alt='Erreur Image' width='180' height='150'></div></td>";
                                            table = table +"<td align='center'>"+i.nom+"</td>";
                                            table = table +"<td align='center'>"+i.prix+" "+i.devise+"</td>";
                                            if (i.nbr==0) {
                                                table = table +"<td align='center' style='background-color: red'>"+i.nbr+"</td>";
                                            } else {
                                                table = table +"<td align='center'><strong>"+i.nbr+"</strong></td>";
                                            }
                                            table = table + "<td align='center'>"+i.nbrVendus+"</td>";
                                            table = table +"<td align='center'><a href='articles/"+i.id+"' class='btn btn-success'><img src='{{asset('imgs/vue.png')}}' alt='Erreur Image' width='20' height='20'></a></td>";
                                            if (i.nbr>0) {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1' disabled></td></tr>";  
                                            } else {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1'></td></tr>";     
                                            }
                                            y++;
                                        });                                        
                                    }
                                    table = table +"</tbody></table>";
                                    cpt++;
                                }
                            });
                            $('#table').html(table);
                        },
                        error:function(response){
                            if(response.status==500){
                                console.log(response);
                            }
                        }
                    });
                } else {
                    $('#couleurBtn').html('Couleur');
                    $('#couleurBtn').attr("class","form-control btn btn-outline-success");
                    $('#modeBtn').attr("style","display: block");
                    $('#tailleBtn').attr("style","display: block");
                    $('#typeBtn').attr("style","display: block");
                    $('#marqueBtn').attr("style","display: block");
                    $('#couleur').attr("style","display: none");
                    $('#couleurSrch').attr("style","display: none");
                    cptTY++;

                    /**
                     * Refresh articles.index
                     * */
                    $.ajax({
                        success:function(data){
                            window.location.href="{{ route('articles.index') }}";
                        },
                        error:function(response){
                            if(response.status==500){
                                console.log("error");
                            }
                        }
                    });
                }
            });

            /***
             * Choix d'un type pour affiner la liste
             * */
            $('#couleur').on("change",function(){
                var couleur = $('#couleur').val();
                if (couleur==null||couleur=="") {
                    $('#couleurSrch').attr("style","display: none");
                    /**
                     * Liste articles par couleur
                     * */
                     $.ajax({
                        url:"{{ route('byCouleur') }}",
                        type : "get", //method
                        async:true,
                        dataType : 'json',
                        success:function(data){
                            var table = "";
                            var cpt = 0;
                            data.forEach(e => {
                                if (cpt%2==0) {
                                    table = table +"<div class='dropdown-divider'></div><table class='table table-bordered table-striped table-responsive'><thead><tr class='text-center'><h4 class='text-center' style='background-color: "+e.color+"'><B>"+e.couleur+"</B></h4></tr>";
                                    table = table +"<tr><th>{{ 'N°' }}</th><th >{{ 'Photo' }}</th><th >{{ 'Nom' }}</th><th >{{ 'Prix' }}</th><th >{{ 'Nombre' }}</th><th>{{ 'Qté vendue' }}</th></thead><tbody>";
                                    cpt++;
                                } else {
                                    if (e==null||e=="") {
                                        table = table +"<tr class='text-center'><td>Aucun Article</td></tr>";
                                    } else {
                                        var y=1;
                                        e.forEach(i => {
                                            table = table +"<tr><td>"+y+"</td><td align='center'><div class='card-img'><img src='{{ url('storage') }}/images/"+i.nom+i.id+"/profil.png' alt='Erreur Image' width='180' height='150'></div></td>";
                                            table = table +"<td align='center'>"+i.nom+"</td>";
                                            table = table +"<td align='center'>"+i.prix+" "+i.devise+"</td>";
                                            if (i.nbr==0) {
                                                table = table +"<td align='center' style='background-color: red'>"+i.nbr+"</td>";
                                            } else {
                                                table = table +"<td align='center'><strong>"+i.nbr+"</strong></td>";
                                            }
                                            table = table + "<td align='center'>"+i.nbrVendus+"</td>";
                                            table = table +"<td align='center'><a href='articles/"+i.id+"' class='btn btn-success'><img src='{{asset('imgs/vue.png')}}' alt='Erreur Image' width='20' height='20'></a></td>";
                                            if (i.nbr>0) {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1' disabled></td></tr>";  
                                            } else {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1'></td></tr>";     
                                            }
                                            y++;
                                        });                                        
                                    }
                                    table = table +"</tbody></table>";
                                    cpt++;
                                }
                            });
                            $('#table').html(table);
                        },
                        error:function(response){
                            if(response.status==500){
                                console.log(response);
                            }
                        }
                    });
                } else {
                    $('#couleurSrch').attr("style","display: block");
                    $.ajax({
                        url:"{{ route('byOneCouleur') }}",
                        type : "post", //method
                        async:true,
                        data:{couleurId:$('#couleur').val(),search:$('#couleurSrch').val()},
                        dataType : 'json',
                        success:function(data){
                            var table = "";
                            var cpt = 0;
                            data.forEach(e => {
                                if (cpt%2==0) {
                                    table = table +"<div class='dropdown-divider'></div><table class='table table-bordered table-striped table-responsive'><thead><tr class='text-center'><h4 class='text-center' style='background-color: "+e.color+"'><B>"+e.couleur+"</B></h4></tr>";
                                    table = table +"<tr><th>{{ 'N°' }}</th><th >{{ 'Photo' }}</th><th >{{ 'Nom' }}</th><th >{{ 'Prix' }}</th><th >{{ 'Nombre' }}</th><th>{{ 'Qté vendue' }}</th></thead><tbody>";
                                    cpt++;
                                } else {
                                    if (e==null||e=="") {
                                        table = table +"<tr class='text-center'><td>Aucun Article</td></tr>";
                                    } else {
                                        var y=1;
                                        e.forEach(i => {
                                            table = table +"<tr><td>"+y+"</td><td align='center'><div class='card-img'><img src='{{ url('storage') }}/images/"+i.nom+i.id+"/profil.png' alt='Erreur Image' width='180' height='150'></div></td>";
                                            table = table +"<td align='center'>"+i.nom+"</td>";
                                            table = table +"<td align='center'>"+i.prix+" "+i.devise+"</td>";
                                            if (i.nbr==0) {
                                                table = table +"<td align='center' style='background-color: red'>"+i.nbr+"</td>";
                                            } else {
                                                table = table +"<td align='center'><strong>"+i.nbr+"</strong></td>";
                                            }
                                            table = table + "<td align='center'>"+i.nbrVendus+"</td>";
                                            table = table +"<td align='center'><a href='articles/"+i.id+"' class='btn btn-success'><img src='{{asset('imgs/vue.png')}}' alt='Erreur Image' width='20' height='20'></a></td>";
                                            if (i.nbr>0) {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1' disabled></td></tr>";  
                                            } else {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1'></td></tr>";     
                                            }
                                            y++;
                                        });                                        
                                    }
                                    table = table +"</tbody></table>";
                                    cpt++;
                                }
                            });
                            $('#table').html(table);
                        },
                        error:function(response){
                            if(response.status==500){
                                console.log(response);
                            }
                        }
                    });
                }
            });

            /***
             * Barre de recher pour affiner encore plus
             * */
            $('#couleurSrch').on("input",function(){
                $.ajax({
                    url:"{{ route('byOneCouleur') }}",
                    type : "post", //method
                    async:true,
                    data:{couleurId:$('#couleur').val(),search:$('#couleurSrch').val()},
                    dataType : 'json',
                    success:function(data){
                        var table = "";
                        var cpt = 0;
                        data.forEach(e => {
                            if (cpt%2==0) {
                                table = table +"<div class='dropdown-divider'></div><table class='table table-bordered table-striped table-responsive'><thead><tr class='text-center'><h4 class='text-center' style='background-color: "+e.color+"'><B>"+e.couleur+"</B></h4></tr>";
                                table = table +"<tr><th>{{ 'N°' }}</th><th >{{ 'Photo' }}</th><th >{{ 'Nom' }}</th><th >{{ 'Prix' }}</th><th >{{ 'Nombre' }}</th><th>{{ 'Qté vendue' }}</th></thead><tbody>";
                                cpt++;
                            } else {
                                if (e==null||e=="") {
                                    table = table +"<tr class='text-center'><td>Aucun Article</td></tr>";
                                } else {
                                    var y=1;
                                    e.forEach(i => {
                                        table = table +"<tr><td>"+y+"</td><td align='center'><div class='card-img'><img src='{{ url('storage') }}/images/"+i.nom+i.id+"/profil.png' alt='Erreur Image' width='180' height='150'></div></td>";
                                        table = table +"<td align='center'>"+i.nom+"</td>";
                                        table = table +"<td align='center'>"+i.prix+" "+i.devise+"</td>";
                                        if (i.nbr==0) {
                                            table = table +"<td align='center' style='background-color: red'>"+i.nbr+"</td>";
                                        } else {
                                            table = table +"<td align='center'><strong>"+i.nbr+"</strong></td>";
                                        }
                                        table = table + "<td align='center'>"+i.nbrVendus+"</td>";
                                        table = table +"<td align='center'><a href='articles/"+i.id+"' class='btn btn-success'><img src='{{asset('imgs/vue.png')}}' alt='Erreur Image' width='20' height='20'></a></td>";
                                        if (i.nbr>0) {
                                            table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1' disabled></td></tr>";  
                                        } else {
                                            table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1'></td></tr>";     
                                        }
                                        y++;
                                    });                                        
                                }
                                table = table +"</tbody></table>";
                                cpt++;
                            }
                        });
                        $('#table').html(table);
                    },
                    error:function(response){
                        if(response.status==500){
                            console.log(response);
                        }
                    }
                });
            });
        })();
    </script>
    <script type="text/javascript">
        var cptMA = 0;
        (function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                }
            });
            /***
             * Choix d'une marque pour affiner la liste
             * */
            $('#marque').on("change",function(){
                var marque = $('#marque').val();
                if (marque==null||marque=="") {
                    $('#marqueSrch').attr("style","display: none");
                    /**
                     * Liste articles par type
                     * */
                    $.ajax({
                        url:"{{ route('byOneType') }}",
                        type : "post", //method
                        async:true,
                        data:{typeId:$('#type').val()},
                        dataType : 'json',
                        success:function(data){
                            var table = "";
                            var cpt = 0;
                            data.forEach(e => {
                                if (cpt==0) {
                                    table = table +"<div class='dropdown-divider'></div><table class='table table-bordered table-striped table-responsive'><thead><tr class='text-center'><h4 class='text-center' style='color: darkblue'><B>"+e.type+"</B></h4></tr>";
                                    table = table +"<tr><th>{{ 'N°' }}</th><th >{{ 'Photo' }}</th><th >{{ 'Nom' }}</th><th >{{ 'Prix' }}</th><th >{{ 'Nombre' }}</th><th>{{ 'Qté vendue' }}</th></thead><tbody>";
                                } 
                                if(cpt==1) {
                                    if (e==null||e=="") {
                                        table = table +"<tr class='text-center'><td>Aucun Article</td></tr>";
                                    } else {
                                        var y=1;
                                        e.forEach(i => {
                                            table = table +"<tr><td>"+y+"</td><td align='center'><div class='card-img'><img src='{{ url('storage') }}/images/"+i.nom+i.id+"/profil.png' alt='Erreur Image' width='180' height='150'></div></td>";
                                            table = table +"<td align='center'>"+i.nom+"</td>";
                                            table = table +"<td align='center'>"+i.prix+" "+i.devise+"</td>";
                                            if (i.nbr==0) {
                                                table = table +"<td align='center' style='background-color: red'>"+i.nbr+"</td>";
                                            } else {
                                                table = table +"<td align='center'><strong>"+i.nbr+"</strong></td>";
                                            }
                                            table = table + "<td align='center'>"+i.nbrVendus+"</td>";
                                            table = table +"<td align='center'><a href='articles/"+i.id+"' class='btn btn-success'><img src='{{asset('imgs/vue.png')}}' alt='Erreur Image' width='20' height='20'></a></td>";
                                            if (i.nbr>0) {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1' disabled></td></tr>";  
                                            } else {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1'></td></tr>";     
                                            }
                                            y++;
                                        });                                        
                                    }
                                    table = table +"</tbody></table>";
                                }
                                if (cpt==2) {
                                    var marqueSelect = "";
                                    marqueSelect = marqueSelect + "<option value=''>{{ 'Marque' }}</option>";
                                    e.forEach(a => {
                                        marqueSelect = marqueSelect + "<option value="+a.id+">"+a.marque+"</option>";
                                    });
                                    $('#marque').html(marqueSelect);
                                    $('#marque').attr("style","display: block");
                                }
                                cpt++;
                            });
                            $('#table').html(table);
                        },
                        error:function(response){
                            if(response.status==500){
                                console.log(response);
                            }
                        }
                    });
                } else {
                    $('#marqueSrch').attr("style","display: block");
                    $.ajax({
                        url:"{{ route('byOneMarque') }}",
                        type : "post", //method
                        async:true,
                        data:{marqueId:$('#marque').val(),search:$('#marqueSrch').val()},
                        dataType : 'json',
                        success:function(data){
                            var table = "";
                            var cpt = 0;
                            data.forEach(e => {
                                if (cpt%2==0) {
                                    table = table +"<div class='dropdown-divider'></div><table class='table table-bordered table-striped table-responsive'><thead><tr class='text-center'><h4 class='text-center' style='color: darkblue'><B>"+e.marque+"</B></h4></tr>";
                                    table = table +"<tr><th>{{ 'N°' }}</th><th >{{ 'Photo' }}</th><th >{{ 'Nom' }}</th><th >{{ 'Prix' }}</th><th >{{ 'Nombre' }}</th><th>{{ 'Qté vendue' }}</th></thead><tbody>";
                                    cpt++;
                                } else {
                                    if (e==null||e=="") {
                                        table = table +"<tr class='text-center'><td>Aucun Article</td></tr>";
                                    } else {
                                        var y=1;
                                        e.forEach(i => {
                                            table = table +"<tr><td>"+y+"</td><td align='center'><div class='card-img'><img src='{{ url('storage') }}/images/"+i.nom+i.id+"/profil.png' alt='Erreur Image' width='180' height='150'></div></td>";
                                            table = table +"<td align='center'>"+i.nom+"</td>";
                                            table = table +"<td align='center'>"+i.prix+" "+i.devise+"</td>";
                                            if (i.nbr==0) {
                                                table = table +"<td align='center' style='background-color: red'>"+i.nbr+"</td>";
                                            } else {
                                                table = table +"<td align='center'><strong>"+i.nbr+"</strong></td>";
                                            }
                                            table = table + "<td align='center'>"+i.nbrVendus+"</td>";
                                            table = table +"<td align='center'><a href='articles/"+i.id+"' class='btn btn-success'><img src='{{asset('imgs/vue.png')}}' alt='Erreur Image' width='20' height='20'></a></td>";
                                            if (i.nbr>0) {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1' disabled></td></tr>";  
                                            } else {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1'></td></tr>";     
                                            }
                                            y++;
                                        });                                        
                                    }
                                    table = table +"</tbody></table>";
                                    cpt++;
                                }
                            });
                            $('#table').html(table);
                        },
                        error:function(response){
                            if(response.status==500){
                                console.log(response);
                            }
                        }
                    });
                }
            });

            /***
             * Barre de recher pour affiner encore plus
             * */
            $('#marqueSrch').on("input",function(){
                $.ajax({
                    url:"{{ route('byOneMarque') }}",
                    type : "post", //method
                    async:true,
                    data:{marqueId:$('#marque').val(),search:$('#marqueSrch').val()},
                    dataType : 'json',
                    success:function(data){
                        var table = "";
                        var cpt = 0;
                        data.forEach(e => {
                            if (cpt%2==0) {
                                table = table +"<div class='dropdown-divider'></div><table class='table table-bordered table-striped table-responsive'><thead><tr class='text-center'><h4 class='text-center' style='color: darkblue'><B>"+e.marque+"</B></h4></tr>";
                                table = table +"<tr><th>{{ 'N°' }}</th><th >{{ 'Photo' }}</th><th >{{ 'Nom' }}</th><th >{{ 'Prix' }}</th><th >{{ 'Nombre' }}</th><th>{{ 'Qté vendue' }}</th></thead><tbody>";
                                cpt++;
                            } else {
                                if (e==null||e=="") {
                                    table = table +"<tr class='text-center'><td>Aucun Article</td></tr>";
                                } else {
                                    var y=1;
                                    e.forEach(i => {
                                        table = table +"<tr><td>"+y+"</td><td align='center'><div class='card-img'><img src='{{ url('storage') }}/images/"+i.nom+i.id+"/profil.png' alt='Erreur Image' width='180' height='150'></div></td>";
                                        table = table +"<td align='center'>"+i.nom+"</td>";
                                        table = table +"<td align='center'>"+i.prix+" "+i.devise+"</td>";
                                        if (i.nbr==0) {
                                            table = table +"<td align='center' style='background-color: red'>"+i.nbr+"</td>";
                                        } else {
                                            table = table +"<td align='center'><strong>"+i.nbr+"</strong></td>";
                                        }
                                        table = table + "<td align='center'>"+i.nbrVendus+"</td>";
                                        table = table +"<td align='center'><a href='articles/"+i.id+"' class='btn btn-success'><img src='{{asset('imgs/vue.png')}}' alt='Erreur Image' width='20' height='20'></a></td>";
                                        if (i.nbr>0) {
                                            table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1' disabled></td></tr>";  
                                        } else {
                                            table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1'></td></tr>";     
                                        }
                                        y++;
                                    });                                        
                                }
                                table = table +"</tbody></table>";
                                cpt++;
                            }
                        });
                        $('#table').html(table);
                    },
                    error:function(response){
                        if(response.status==500){
                            console.log(response);
                        }
                    }
                });
            });
        })();
    </script>
    <script type="text/javascript">
        var cptTA = 0;
        (function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#tailleBtn').on("click",function(){
                if (cptTA%2==0) {
                    $('#tailleBtn').html('<B>Taille</B>');
                    $('#tailleBtn').attr("class","form-control btn btn-success");
                    $('#typeBtn').attr("style","display: none");
                    $('#modeBtn').attr("style","display: none");
                    $('#couleurBtn').attr("style","display: none");
                    $('#marqueBtn').attr("style","display: none");
                    $('#taille').attr("style","display: block");
                    cptTA++;
                    /**
                     * Liste articles par taille
                     * */
                    $.ajax({
                        url:"{{ route('byTaille') }}",
                        type : "get", //method
                        async:true,
                        dataType : 'json',
                        success:function(data){
                            var table = "";
                            var cpt = 0;
                            data.forEach(e => {
                                if (cpt%2==0) {
                                    table = table +"<div class='dropdown-divider'></div><table class='table table-bordered table-striped table-responsive'><thead><tr class='text-center'><h4 class='text-center' style='color: darkblue'><B>"+e.taille+"</B></h4></tr>";
                                    table = table +"<tr><th>{{ 'N°' }}</th><th >{{ 'Photo' }}</th><th >{{ 'Nom' }}</th><th >{{ 'Prix' }}</th><th >{{ 'Nombre' }}</th><th>{{ 'Qté vendue' }}</th></thead><tbody>";
                                    cpt++;
                                } else {
                                    if (e==null||e=="") {
                                        table = table +"<tr class='text-center'><td>Aucun Article</td></tr>";
                                    } else {
                                        var y=1;
                                        e.forEach(i => {
                                            table = table +"<tr><td>"+y+"</td><td align='center'><div class='card-img'><img src='{{ url('storage') }}/images/"+i.nom+i.id+"/profil.png' alt='Erreur Image' width='180' height='150'></div></td>";
                                            table = table +"<td align='center'>"+i.nom+"</td>";
                                            table = table +"<td align='center'>"+i.prix+" "+i.devise+"</td>";
                                            if (i.nbr==0) {
                                                table = table +"<td align='center' style='background-color: red'>"+i.nbr+"</td>";
                                            } else {
                                                table = table +"<td align='center'><strong>"+i.nbr+"</strong></td>";
                                            }
                                            table = table + "<td align='center'>"+i.nbrVendus+"</td>";
                                            table = table +"<td align='center'><a href='articles/"+i.id+"' class='btn btn-success'><img src='{{asset('imgs/vue.png')}}' alt='Erreur Image' width='20' height='20'></a></td>";
                                            if (i.nbr>0) {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1' disabled></td></tr>";  
                                            } else {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1'></td></tr>";     
                                            }
                                            y++;
                                        });
                                    }
                                    table = table +"</tbody></table>";
                                    cpt++;
                                }
                            });
                            $('#table').html(table);
                        },
                        error:function(response){
                            alert('eeee');
                            if(response.status==500){
                                console.log(response);
                            }
                        }
                    });
                } else {
                    $('#tailleBtn').html('Taille');
                    $('#tailleBtn').attr("class","form-control btn btn-outline-success");
                    $('#typeBtn').attr("style","display: block");
                    $('#modeBtn').attr("style","display: block");
                    $('#couleurBtn').attr("style","display: block");
                    $('#marqueBtn').attr("style","display: block");
                    $('#taille').attr("style","display: none");
                    $('#tailleSrch').attr("style","display: none");
                    cptTA++;
                    
                    /**
                     * Refresh articles.index
                     * */
                    $.ajax({
                        success:function(data){
                            window.location.href="{{ route('articles.index') }}";
                        },
                        error:function(response){
                            if(response.status==500){
                                console.log("error");
                            }
                        }
                    });
                }
            });

            /***
             * Choix d'une taille pour affiner la liste
             * */
            $('#taille').on("change",function(){
                var taille = $('#taille').val();
                if (taille==null||taille=="") {
                    $('#tailleSrch').attr("style","display: none");
                    /**
                     * Liste articles par taille
                     * */
                     $.ajax({
                        url:"{{ route('byTaille') }}",
                        type : "get", //method
                        async:true,
                        dataType : 'json',
                        success:function(data){
                            var table = "";
                            var cpt = 0;
                            data.forEach(e => {
                                if (cpt%2==0) {
                                    table = table +"<div class='dropdown-divider'></div><table class='table table-bordered table-striped table-responsive'><thead><tr class='text-center'><h4 class='text-center' style='color: darkblue'><B>"+e.taille+"</B></h4></tr>";
                                    table = table +"<tr><th>{{ 'N°' }}</th><th >{{ 'Photo' }}</th><th >{{ 'Nom' }}</th><th >{{ 'Prix' }}</th><th >{{ 'Nombre' }}</th><th>{{ 'Qté vendue' }}</th></thead><tbody>";
                                    cpt++;
                                } else {
                                    if (e==null||e=="") {
                                        table = table +"<tr class='text-center'><td>Aucun Article</td></tr>";
                                    } else {
                                        var y=1;
                                        e.forEach(i => {
                                            table = table +"<tr><td>"+y+"</td><td align='center'><div class='card-img'><img src='{{ url('storage') }}/images/"+i.nom+i.id+"/profil.png' alt='Erreur Image' width='180' height='150'></div></td>";
                                            table = table +"<td align='center'>"+i.nom+"</td>";
                                            table = table +"<td align='center'>"+i.prix+" "+i.devise+"</td>";
                                            if (i.nbr==0) {
                                                table = table +"<td align='center' style='background-color: red'>"+i.nbr+"</td>";
                                            } else {
                                                table = table +"<td align='center'><strong>"+i.nbr+"</strong></td>";
                                            }
                                            table = table + "<td align='center'>"+i.nbrVendus+"</td>";
                                            table = table +"<td align='center'><a href='articles/"+i.id+"' class='btn btn-success'><img src='{{asset('imgs/vue.png')}}' alt='Erreur Image' width='20' height='20'></a></td>";
                                            if (i.nbr>0) {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1' disabled></td></tr>";  
                                            } else {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1'></td></tr>";     
                                            }
                                            y++;
                                        });
                                    }
                                    table = table +"</tbody></table>";
                                    cpt++;
                                }
                            });
                            $('#table').html(table);
                        },
                        error:function(response){
                            if(response.status==500){
                                console.log(response);
                            }
                        }
                    });
                } else {
                    $('#tailleSrch').attr("style","display: block");
                    $.ajax({
                        url:"{{ route('byOneTaille') }}",
                        type : "post", //method
                        async:true,
                        data:{tailleId:$('#taille').val(),search:$('#tailleSrch').val()},
                        dataType : 'json',
                        success:function(data){
                            var table = "";
                            var cpt = 0;
                            data.forEach(e => {
                                if (cpt%2==0) {
                                    table = table +"<div class='dropdown-divider'></div><table class='table table-bordered table-striped table-responsive'><thead><tr class='text-center'><h4 class='text-center' style='color: darkblue'><B>"+e.taille+"</B></h4></tr>";
                                    table = table +"<tr><th>{{ 'N°' }}</th><th >{{ 'Photo' }}</th><th >{{ 'Nom' }}</th><th >{{ 'Prix' }}</th><th >{{ 'Nombre' }}</th><th>{{ 'Qté vendue' }}</th></thead><tbody>";
                                    cpt++;
                                } else {
                                    if (e==null||e=="") {
                                        table = table +"<tr class='text-center'><td>Aucun Article</td></tr>";
                                    } else {
                                        var y=1;
                                        e.forEach(i => {
                                            table = table +"<tr><td>"+y+"</td><td align='center'><div class='card-img'><img src='{{ url('storage') }}/images/"+i.nom+i.id+"/profil.png' alt='Erreur Image' width='180' height='150'></div></td>";
                                            table = table +"<td align='center'>"+i.nom+"</td>";
                                            table = table +"<td align='center'>"+i.prix+" "+i.devise+"</td>";
                                            if (i.nbr==0) {
                                                table = table +"<td align='center' style='background-color: red'>"+i.nbr+"</td>";
                                            } else {
                                                table = table +"<td align='center'><strong>"+i.nbr+"</strong></td>";
                                            }
                                            table = table + "<td align='center'>"+i.nbrVendus+"</td>";
                                            table = table +"<td align='center'><a href='articles/"+i.id+"' class='btn btn-success'><img src='{{asset('imgs/vue.png')}}' alt='Erreur Image' width='20' height='20'></a></td>";
                                            if (i.nbr>0) {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1' disabled></td></tr>";  
                                            } else {
                                                table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1'></td></tr>";     
                                            }
                                            y++;
                                        });                                        
                                    }
                                    table = table +"</tbody></table>";
                                    cpt++;
                                }
                            });
                            $('#table').html(table);
                        },
                        error:function(response){
                            if(response.status==500){
                                console.log(response);
                            }
                        }
                    });
                }
            });

            /***
             * Barre de recher pour affiner encore plus
             * */
            $('#tailleSrch').on("input",function(){
                $.ajax({
                    url:"{{ route('byOneTaille') }}",
                    type : "post", //method
                    async:true,
                    data:{tailleId:$('#taille').val(),search:$('#tailleSrch').val()},
                    dataType : 'json',
                    success:function(data){
                        var table = "";
                        var cpt = 0;
                        data.forEach(e => {
                            if (cpt%2==0) {
                                table = table +"<div class='dropdown-divider'></div><table class='table table-bordered table-striped table-responsive'><thead><tr class='text-center'><h4 class='text-center' style='color: darkblue'><B>"+e.taille+"</B></h4></tr>";
                                table = table +"<tr><th>{{ 'N°' }}</th><th >{{ 'Photo' }}</th><th >{{ 'Nom' }}</th><th >{{ 'Prix' }}</th><th >{{ 'Nombre' }}</th><th>{{ 'Qté vendue' }}</th></thead><tbody>";
                                cpt++;
                            } else {
                                if (e==null||e=="") {
                                    table = table +"<tr class='text-center'><td>Aucun Article</td></tr>";
                                } else {
                                    var y=1;
                                    e.forEach(i => {
                                        table = table +"<tr><td>"+y+"</td><td align='center'><div class='card-img'><img src='{{ url('storage') }}/images/"+i.nom+i.id+"/profil.png' alt='Erreur Image' width='180' height='150'></div></td>";
                                        table = table +"<td align='center'>"+i.nom+"</td>";
                                        table = table +"<td align='center'>"+i.prix+" "+i.devise+"</td>";
                                        if (i.nbr==0) {
                                            table = table +"<td align='center' style='background-color: red'>"+i.nbr+"</td>";
                                        } else {
                                            table = table +"<td align='center'><strong>"+i.nbr+"</strong></td>";
                                        }
                                        table = table + "<td align='center'>"+i.nbrVendus+"</td>";
                                        table = table +"<td align='center'><a href='articles/"+i.id+"' class='btn btn-success'><img src='{{asset('imgs/vue.png')}}' alt='Erreur Image' width='20' height='20'></a></td>";
                                        if (i.nbr>0) {
                                            table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1' disabled></td></tr>";  
                                        } else {
                                            table = table +"<td align='center'><input type='checkbox' name="+i.id+" id="+i.id+" class='form-check-input' onclick='showdelete()' value='1'></td></tr>";     
                                        }
                                        y++;
                                    });                                        
                                }
                                table = table +"</tbody></table>";
                                cpt++;
                            }
                        });
                        $('#table').html(table);
                    },
                    error:function(response){
                        if(response.status==500){
                            console.log(response);
                        }
                    }
                });
            });
        })();
    </script>
@endsection