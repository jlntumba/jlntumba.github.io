@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md">
            <div class="card">
                <div class="card-header">
                    <div class="input-group">
                        <button class="btn btn-light" onclick="showfilter()"><img src="{{asset('imgs/filtre.png')}}"  width="20" height="18"></button>
                        <input type="text" name="search" id="search" class="form-control input-group-text" placeholder="Je cherche...">
                        
                        <div class="input-group">
                            <select name="type" id="type" style="display: none" class="form-control form-select">
                                <option value="">{{ "Type" }}</option>
                                @foreach ($typesVetement as $type)
                                    <option value="{{ $type->id }}">{{ $type->type }}</option>
                                @endforeach
                            </select>

                            <select name="marque" id="marque" style="display: none" class="form-control form-select">
                                
                            </select>

                            <select name="mode" id="mode" style="display: none" class="form-control form-select">
                                <option value="">{{ "Mode" }}</option>
                                @foreach ($modes as $mode)
                                    <option value="{{ $mode->id }}">{{ $mode->mode }}</option>
                                @endforeach
                            </select>

                            <select name="taille" id="taille" style="display: none" class="form-control form-select">
                                <option value="">{{ "Taille" }}</option>
                                @foreach ($tailles as $taille)
                                    <option value="{{ $taille->id }}">{{ $taille->taille }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> 
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ((Auth::user()!=null&&Auth::user()->adresse_id!=null)||(Auth::user()==null))
                        
                        <div class="container" id="content">

                            
                            @if ($articles->isEmpty())
                                <div class="row row-cols-sm-1">
                                    <div class="col-sm">
                                        <h4 class="text-center text-danger">{{ "Aucun Article" }}</h4>
                                    </div>
                                </div>
                            @endif
                                
                            <div class="row row-cols-sm-4">
                                @foreach ($articles as $article)
                                    @if ($article->nbr>0)
                                        <a href="{{ route('articles.show',$article) }}" style="text-decoration: none; border-color: white; min-height: 500% ; background-image: url('{{ url('storage') }}/images/{{ $article->nom.$article->id }}/profil.png')" class="col-sm btn btn-outline-dark">
                                            <div class="card-text">
                                                <h4 class="text-center text-warning" style="background-color: darkblue; "><strong>{{ $article->prix." ".$article->devise }}</strong></h4>
                                            </div>
                                            <div class="card-img" style="overflow: auto; white-space: nowrap;">
                                                <img width="240" height="230" src="{{ url('storage') }}/images/{{ $article->nom.$article->id }}/profil.png" alt="Erreur Image">
                                            </div>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @else
                        <form method="post" action="{{ route('adresses.update',$user->id) }}">
                            @csrf
                            @method('put')
                            @include('users.adresse')
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary float-sm-end">
                                        <img src="{{asset('imgs/save.png')}}" alt="Erreur Image" width="25" height="25">
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif

                    
                </div>
                <div class="card-footer">
                    @if ((Auth::user()!=null&&Auth::user()->adresse_id!=null)||(Auth::user()==null))
                        <img src="{{asset('imgs/LOGO Plus.png')}}" alt="Erreur Image" width="9%">
                    @else
                        <h1 class="text-center text-danger">{{ ("Renseignez votre adresse") }}</h1>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    //elem = document.get
    var cpt = 0;
    function showfilter(){
        if (cpt%2==0) {
            window.document.getElementById('mode').style.display='block';
            window.document.getElementById('type').style.display='block';

            var type = $('#type').val();
            if (type!="") {
                window.document.getElementById('marque').style.display='block';
            }
            if (type==1) {
                window.document.getElementById('taille').style.display='block';
            }

            cpt++;
        } else {
            window.document.getElementById('mode').style.display='none';
            window.document.getElementById('type').style.display='none';
            window.document.getElementById('marque').style.display='none';
            window.document.getElementById('taille').style.display='none';
            cpt++;
        }
    }
</script>

<script type="text/javascript">
    (function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#search').on("input",function(){
            $.ajax({
                url:"{{ route('searchArticles') }}",
                type : "post", //method
                async:true,
                data:{search:$('#search').val(),marque:$('#marque').val(),mode:$('#mode').val(),type:$('#type').val(),taille:$('#taille').val()},
                dataType : 'json',
                success:function(data){
                    let content = "";
                    if (data=="") {
                        $('#content').html("<div class='row row-cols-sm-1'><div class='col-sm'><h4 class='text-center text-danger'>{{ 'Aucun Article' }}</h4></div></div>");
                    }else{

                        content = content + "<div class='row row-cols-sm-4'>";

                        data.forEach(e => {
                            if (e.nbr>0) {
                                content = content + "<a href='articles/"+e.id+"' style='text-decoration: none; border-color: white; min-height: 500% ; background-image: url({{ url('storage') }}/images/"+e.nom+e.id+"/profil.png)' class='col-sm btn btn-outline-dark'>";
                                content = content + "<div class='card-text'><h4 class='text-center text-warning' style='background-color: darkblue;'><strong>"+e.prix+" "+e.devise+"</strong></h4></div>";
                                content = content + "<div class='card-img' style='overflow: auto; white-space: nowrap;'><img width='240' height='230' src='{{  url('storage') }}/images/"+e.nom+e.id+"/profil.png' alt='Erreur Image'></div>";
                                content = content + "</a>";
                            }
                        });

                        content = content + "</div>";

                        $('#content').html(content);
                    }
                },
                error:function(response){
                    if(response.status==500){
                        console.log("error");
                    }
                }
            });
        });
    })();
</script>

<script type="text/javascript">
    (function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#marque').on("change",function(){
            $.ajax({
                url:"{{ route('searchArticles') }}",
                type : "post", //method
                async:true,
                data:{search:$('#search').val(),marque:$('#marque').val(),mode:$('#mode').val(),type:$('#type').val(),taille:$('#taille').val()},
                dataType : 'json',
                success:function(data){
                    let content = "";
                    if (data=="") {
                        $('#content').html("<div class='row row-cols-sm-1'><div class='col-sm'><h4 class='text-center text-danger'>{{ 'Aucun Article' }}</h4></div></div>");
                    }else{

                        content = content + "<div class='row row-cols-sm-4'>";

                        data.forEach(e => {
                            if (e.nbr>0) {
                                content = content + "<a href='articles/"+e.id+"' style='text-decoration: none; border-color: white; min-height: 500% ; background-image: url({{ url('storage') }}/images/"+e.nom+e.id+"/profil.png)' class='col-sm btn btn-outline-dark'>";
                                content = content + "<div class='card-text'><h4 class='text-center text-warning' style='background-color: darkblue;'><strong>"+e.prix+" "+e.devise+"</strong></h4></div>";
                                content = content + "<div class='card-img' style='overflow: auto; white-space: nowrap;'><img width='240' height='230' src='{{  url('storage') }}/images/"+e.nom+e.id+"/profil.png' alt='Erreur Image'></div>";
                                content = content + "</a>";
                            }
                        });

                        content = content + "</div>";

                        $('#content').html(content);
                    }
                },
                error:function(response){
                    if(response.status==500){
                        console.log("error");
                    }
                }
            });
        });
    })();
</script>

<script type="text/javascript">
    (function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#mode').on("change",function(){
            $.ajax({
                url:"{{ route('searchArticles') }}",
                type : "post", //method
                async:true,
                data:{search:$('#search').val(),marque:$('#marque').val(),mode:$('#mode').val(),type:$('#type').val(),taille:$('#taille').val()},
                dataType : 'json',
                success:function(data){
                    let content = "";
                    if (data=="") {
                        $('#content').html("<div class='row row-cols-sm-1'><div class='col-sm'><h4 class='text-center text-danger'>{{ 'Aucun Article' }}</h4></div></div>");
                    }else{

                        content = content + "<div class='row row-cols-sm-4'>";

                        data.forEach(e => {
                            if (e.nbr>0) {
                                content = content + "<a href='articles/"+e.id+"' style='text-decoration: none; border-color: white; min-height: 500% ; background-image: url({{ url('storage') }}/images/"+e.nom+e.id+"/profil.png)' class='col-sm btn btn-outline-dark'>";
                                content = content + "<div class='card-text'><h4 class='text-center text-warning' style='background-color: darkblue;'><strong>"+e.prix+" "+e.devise+"</strong></h4></div>";
                                content = content + "<div class='card-img' style='overflow: auto; white-space: nowrap;'><img width='240' height='230' src='{{  url('storage') }}/images/"+e.nom+e.id+"/profil.png' alt='Erreur Image'></div>";
                                content = content + "</a>";
                            }
                        });

                        content = content + "</div>";

                        $('#content').html(content);
                    }
                },
                error:function(response){
                    if(response.status==500){
                        console.log("error");
                    }
                }
            });
        });
    })();
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
                $('#marque').attr('style','display : block');
                $.ajax({
                    url:"{{ route('listMarques') }}",
                    type : "get", //method
                    async:true,
                    data:{type:$('#type').val()},
                    dataType : 'json',
                    success:function(data){
                        var marque = "";
                        marque = marque + "<option value=''>Marque</option>";
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
                    $('#taille').attr('style','display : block');
                }else{
                    $('#taille').attr('style','display : none');
                }
            } else {
                $('#taille').attr('style','display : none');
                $('#marque').attr('style','display : none');
            }
            $.ajax({
                url:"{{ route('searchArticles') }}",
                type : "post", //method
                async:true,
                data:{search:$('#search').val(),marque:$('#marque').val(),mode:$('#mode').val(),type:$('#type').val(),taille:$('#taille').val()},
                dataType : 'json',
                success:function(data){
                    let content = "";
                    if (data=="") {
                        $('#content').html("<div class='row row-cols-sm-1'><div class='col-sm'><h4 class='text-center text-danger'>{{ 'Aucun Article' }}</h4></div></div>");
                    }else{

                        content = content + "<div class='row row-cols-sm-4'>";

                        data.forEach(e => {
                            if (e.nbr>0) {
                                content = content + "<a href='articles/"+e.id+"' style='text-decoration: none; border-color: white; min-height: 500% ; background-image: url({{ url('storage') }}/images/"+e.nom+e.id+"/profil.png)' class='col-sm btn btn-outline-dark'>";
                                content = content + "<div class='card-text'><h4 class='text-center text-warning' style='background-color: darkblue;'><strong>"+e.prix+" "+e.devise+"</strong></h4></div>";
                                content = content + "<div class='card-img' style='overflow: auto; white-space: nowrap;'><img width='240' height='230' src='{{  url('storage') }}/images/"+e.nom+e.id+"/profil.png' alt='Erreur Image'></div>";
                                content = content + "</a>";
                            }
                        });

                        content = content + "</div>";

                        $('#content').html(content);
                    }
                },
                error:function(response){
                    if(response.status==500){
                        console.log("error");
                    }
                }
            });
        });
    })();
</script>

<script type="text/javascript">
    (function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#taille').on("change",function(){
            $.ajax({
                url:"{{ route('searchArticles') }}",
                type : "post", //method
                async:true,
                data:{search:$('#search').val(),marque:$('#marque').val(),mode:$('#mode').val(),type:$('#type').val(),taille:$('#taille').val()},
                dataType : 'json',
                success:function(data){
                    let content = "";
                    if (data=="") {
                        $('#content').html("<div class='row row-cols-sm-1'><div class='col-sm'><h4 class='text-center text-danger'>{{ 'Aucun Article' }}</h4></div></div>");
                    }else{

                        content = content + "<div class='row row-cols-sm-4'>";

                        data.forEach(e => {
                            if (e.nbr>0) {
                                content = content + "<a href='articles/"+e.id+"' style='text-decoration: none; border-color: white; min-height: 500% ; background-image: url({{ url('storage') }}/images/"+e.nom+e.id+"/profil.png)' class='col-sm btn btn-outline-dark'>";
                                content = content + "<div class='card-text'><h4 class='text-center text-warning' style='background-color: darkblue;'><strong>"+e.prix+" "+e.devise+"</strong></h4></div>";
                                content = content + "<div class='card-img' style='overflow: auto; white-space: nowrap;'><img width='240' height='230' src='{{  url('storage') }}/images/"+e.nom+e.id+"/profil.png' alt='Erreur Image'></div>";
                                content = content + "</a>";
                            }
                        });

                        content = content + "</div>";

                        $('#content').html(content);
                    }
                },
                error:function(response){
                    if(response.status==500){
                        console.log("error");
                    }
                }
            });
        });
    })();
</script>
@endsection