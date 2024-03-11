@extends('layouts.app') 


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card">
                    <div class="card-header">
                        <div class="input-group">
                            <button class="btn btn-light" onclick="showSearchBar()"><img src="{{asset('imgs/search.png')}}"  width="20" height="18"></button>
                            <button class="btn btn-light" id="allUsers"><img src="{{asset('imgs/users.png')}}"  width="20" height="18"></button>
                            <h4><strong>
                                {{"| Gestion des utilisateurs  "}}
                            </strong></h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="input-group">
                            <input type="text" name="search" id="search" class="form-control input-group-text" placeholder="Entre le code unique" style="display: none">
                            <input type="hidden" name="admin" id="admin" value="{{ Auth::user()->roles()->contains(1) }}">
                            <input type="hidden" name="manager" id="manager" value="{{ Auth::user()->roles()->contains(2) }}">
                        </div>   

                        <div id="searched" style="overflow: auto; white-space: nowrap; display: none">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th align="center"></th>
                                        <th align="center">{{ "Noms" }}</th>
                                        <th align="center">{{ "Email" }}</th>
                                        <th align="center">{{ "Contact WhatsApp" }}</th>
                                        @if (Auth::user()->roles()->contains(1))
                                            <th align="center">{{ "|   Manager" }}</th>
                                        @endif
                                        @if (Auth::user()->roles()->contains(2))
                                            <th align="center">{{ "|   Marchand" }}</th>
                                        @endif
                                        <th align="center">{{ "Articles Postés" }}</th>
                                        <th align="center">{{ "Qté Vendue" }}</th>
                                    </tr>
                                </thead>
                                <tbody id="list">

                                </tbody>
                            </table>
                        </div>

                        <div id="origin" style="overflow: auto; white-space: nowrap;">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th align="center"></th>
                                        <th align="center">{{ "Noms" }}</th>
                                        <th align="center">{{ "Email" }}</th>
                                        <th align="center">{{ "Contact WhatsApp" }}</th>                                    
                                        @if (Auth::user()->roles()->contains(1))
                                            <th align="center">{{ "|   Manager" }}</th>
                                        @endif
                                        @if (Auth::user()->roles()->contains(2))
                                            <th align="center">{{ "|   Marchand" }}</th>
                                        @endif
                                        <th align="center">{{ "Articles Postés" }}</th>
                                        <th align="center">{{ "Qté Vendue" }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ((Auth::user()->roles()->contains(1)&&Auth::user()->roles()->contains(2)&&$nbrManagers==1&&$nbrMarchands==1)||(!Auth::user()->roles()->contains(1)&&(Auth::user()->roles()->contains(2)&&$nbrMarchands==1)))
                                        <tr>
                                            <td>{{ "Aucun utilisateur" }}</td>
                                        </tr>
                                    @endif
                                    @foreach ($users as $user)
                                        @if ($user->id != Auth::user()->id && $user->id!=1 && ($user->roles()->contains(2) || $user->roles()->contains(3)))
                                            <tr>
                                                <td align="center">
                                                    @if ($user->profil==null)
                                                        <img src="{{asset('imgs/user.png')}}" alt="Erreur Image" width="40" height="40">
                                                    @else
                                                        <img src="{{ url('storage') }}/images/profil/{{ $user->id }}/profil.png" alt="Erreur Image" width="40" height="40" style="border-radius: 50%">
                                                    @endif
                                                </td>
                                                <td align="center">{{ $user->prenom." ".$user->name." ".$user->postnom }}</td>
                                                <td align="center">{{ $user->email }}</td>
                                                <td align="center">{{ $user->tel }}</td>
                                                @if (Auth::user()->roles()->contains(1))
                                                    @if ($user->roles()->contains(2))
                                                        <td align="center">
                                                            <a href="{{ route('manager',$user) }}" class="btn btn-success" ></a>
                                                        </td>
                                                    @else
                                                        <td align="center">
                                                            <a href="{{ route('manager',$user) }}" class="btn btn-danger" ></a>
                                                        </td>
                                                    @endif
                                                @endif
                                                @if (Auth::user()->roles()->contains(2))
                                                    @if ($user->roles()->contains(3))
                                                        <td align="center">
                                                            <a href="{{ route('marchand',$user) }}" class="btn btn-success" ></a>
                                                        </td>
                                                    @else
                                                        <td align="center">
                                                            <a href="{{ route('marchand',$user) }}" class="btn btn-danger" ></a>
                                                        </td>
                                                    @endif
                                                @endif
                                                <td align="center">{{ $user->nbrArtPost }}</td>
                                                <td align="center">{{ $user->nbrArtVend }}</td>
                                            </tr>
                                            @continue($nbrUsers++)
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>                            
                        </div>
                    </div>
                    <div class="card-footer" style="display: inline-block">
                        <h4><strong id="nbrUsersSearched"></strong></h4>
                        <h4><strong id="nbrUsersOrigin">{{ $nbrUsers." utilisateur(s) trouvé(s)" }}</strong></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        var cpt = 0;
        function showSearchBar(){
            if (cpt%2==0) {
                $('#search').attr("style","display: flex");
                $('#origin').attr("style","display: none");
                $('#searched').attr("style","display: none");
                $('#nbrUsersSearched').attr("style","display: none");
                $('#nbrUsersOrigin').attr("style","display: none");
                cpt++;
            } else {
                window.document.getElementById('search').style.display='none';
                $('#search').val("");
                $('#origin').attr("style","display: flex");
                $('#searched').attr("style","display: none");
                $('#nbrUsersSearched').attr("style","display: none");
                $('#nbrUsersOrigin').attr("style","display: flex");
                $('#list').html("");
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
                var search = $('#search').val();
                $.ajax({
                    url:"{{ route('search') }}",
                    type : "post", //method
                    async:true,
                    data:{search:$('#search').val()},
                    dataType : 'json',
                    success:function(data){
                        
                        var admin = $('#admin').val();
                        var manager = $('#manager').val();
                            
                        var tableTr = "";
                        var nbrLine = "";
                        var cpt = 0;
                        var id = 0;

                        data.forEach(e => {
                            if (cpt%2==0) {
                                id = e.id;
                                if (e.profil==null) {
                                    tableTr = tableTr + "<tr><td align='center'><img src='{{asset('imgs/user.png')}}' alt='Erreur Image' width='40' height='40' style='border-radius: 50%'></td>";
                                } else {
                                    tableTr = tableTr + "<tr><td align='center'><img src='{{ url('storage') }}/images/profil/"+e.id+"/profil.png' alt='Erreur Image' width='40' height='40' style='border-radius: 50%'></td>";
                                }
                                tableTr = tableTr + "<td align='center'>"+e.prenom+" "+e.name+" "+e.postnom+"</td><td align='center'>"+e.email+"</td><td align='center'>"+e.tel+"</td>";
                                nbrLine = "<td align='center'>"+e.nbrArtPost+"</td><td align='center'>"+e.nbrArtVend+"</td>";
                            } else {
                                e.forEach(a => {
                                    if (admin==true) {
                                        if (a.id==2) {
                                            tableTr = tableTr + "<td align='center'><a href='users/manager/"+id+"' class='btn btn-success'></a></td>";
                                        } else {
                                            tableTr = tableTr + "<td align='center'><a href='users/manager/"+id+"' class='btn btn-danger'></a></td>";
                                        }
                                    }
                                    if (manager==true) {
                                        if (a.id==3) {
                                            tableTr = tableTr + "<td align='center'><a href='users/marchand/"+id+"' class='btn btn-success'></a></td>";
                                        } else {
                                            tableTr = tableTr + "<td align='center'><a href='users/marchand/"+id+"' class='btn btn-danger'></a></td>";
                                        }
                                    }
                                    tableTr = tableTr + nbrLine;
                                });
                                if (e=="") {
                                    if (admin==true) {
                                        tableTr = tableTr + "<td align='center'><a href='users/manager/"+id+"' class='btn btn-danger'></a></td>";
                                    }
                                    if (manager==true) {
                                        tableTr = tableTr + "<td align='center'><a href='users/marchand/"+id+"' class='btn btn-danger'></a></td>";
                                    }
                                    tableTr = tableTr + nbrLine;
                                }
                            }
                            cpt++;
                        });
                        tableTr = tableTr + "</tr>";
                        $('#list').html(tableTr);
                        if (data=="") {
                            tableTr = tableTr + "<tr><td>Aucun résultat</td></tr>";
                            $('#list').html(tableTr);
                        }
                        $('#searched').attr("style","overflow: auto; white-space: nowrap; display: flex");
                        $('#nbrUsersSearched').attr("style","display: none");
                        $('#nbrUsersOrigin').attr("style","display: none");
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
            var i = 0;
            $('#allUsers').on("click",function(){
                if (i%2==0) {
                    $('#origin').attr("style","display: none");
                    $.ajax({
                        url:"{{ route('search') }}",
                        type : "post", //method
                        async:true,
                        dataType : 'json',
                        success:function(data){
                            
                            var admin = $('#admin').val();
                            var manager = $('#manager').val();
                                
                            var tableTr = "";
                            var nbrLine = "";
                            var cpt = 0;
                            var id = 0;
                            var nbrUsers = 0;

                            data.forEach(e => {
                                if (cpt%2==0) {
                                    nbrUsers++;
                                    id = e.id;
                                    if (e.profil==null) {
                                        tableTr = tableTr + "<tr><td align='center'><img src='{{asset('imgs/user.png')}}' alt='Erreur Image' width='40' height='40' style='border-radius: 50%'></td>";
                                    } else {
                                        tableTr = tableTr + "<tr><td align='center'><img src='{{ url('storage') }}/images/profil/"+e.id+"/profil.png' alt='Erreur Image' width='40' height='40' style='border-radius: 50%'></td>";
                                    }
                                    tableTr = tableTr + "<td align='center'>"+e.prenom+" "+e.name+" "+e.postnom+"</td><td align='center'>"+e.email+"</td><td align='center'>"+e.tel+"</td>";
                                    nbrLine = "<td align='center'>"+e.nbrArtPost+"</td><td align='center'>"+e.nbrArtVend+"</td>";
                                } else {
                                    e.forEach(a => {
                                        if (admin==true) {
                                            if (a.id==2) {
                                                tableTr = tableTr + "<td align='center'><a href='users/manager/"+id+"' class='btn btn-success'></a></td>";
                                            } else {
                                                tableTr = tableTr + "<td align='center'><a href='users/manager/"+id+"' class='btn btn-danger'></a></td>";
                                            }
                                        }
                                        if (manager==true) {
                                            if (a.id==3) {
                                                tableTr = tableTr + "<td align='center'><a href='users/marchand/"+id+"' class='btn btn-success'></a></td>";
                                            } else {
                                                tableTr = tableTr + "<td align='center'><a href='users/marchand/"+id+"' class='btn btn-danger'></a></td>";
                                            }
                                        }
                                        tableTr = tableTr + nbrLine;
                                    });
                                    if (e=="") {
                                        if (admin==true) {
                                            tableTr = tableTr + "<td align='center'><a href='users/manager/"+id+"' class='btn btn-danger'></a></td>";
                                        }
                                        if (manager==true) {
                                            tableTr = tableTr + "<td align='center'><a href='users/marchand/"+id+"' class='btn btn-danger'></a></td>";
                                        }
                                        tableTr = tableTr + nbrLine;
                                    }
                                }
                                cpt++;
                            });
                            tableTr = tableTr + "</tr>";
                            $('#list').html(tableTr);
                            if (data=="") {
                                tableTr = tableTr + "<tr><td>Aucun résultat</td></tr>";
                                $('#list').html(tableTr);
                            }
                            $('#nbrUsersSearched').html(nbrUsers+" utilisateur(s) trouvé(s)");
                            $('#nbrUsersSearched').attr("style","display: flex");
                            $('#nbrUsersOrigin').attr("style","display: none");
                            $('#searched').attr("style","overflow: auto; white-space: nowrap; display: flex");
                        },
                        error:function(response){
                            if(response.status==500){
                                console.log("error");
                            }
                        }
                    });
                    i++;
                } else {
                    window.document.getElementById('search').style.display='none';
                    $('#origin').attr("style","display: flex");
                    $('#searched').attr("style","display: none");
                    $('#nbrUsersSearched').attr("style","display: none");
                    $('#nbrUsersOrigin').attr("style","display: flex");
                    i++;
                }

                
            });
        })();
    </script>
@endsection