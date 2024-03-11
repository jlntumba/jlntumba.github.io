@extends('layouts.app') 


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md">
            <div class="card">
                <div class="card-header text-center">
                    <h4>
                        <strong>
                            {{"Gestion des livraisons"}} 
                        </strong>
                    </h4>
                    <div class="input-group">
                        <div class="input-group">
                            <a href="#" class="form-control btn btn-outline-warning"   id="users">{{ "Users" }}</a>                                
                         
                            <a href="#" class="form-control btn btn-outline-success"   id="macs">{{ "Macs" }}</a>
                        </div>
                    </div> 
                </div>
                
                <div id="usersBody" class="card-body" style="overflow: auto; white-space: nowrap;">
                    @foreach ($users as $user)
                        <div class="dropdown-divider">
                        </div>
                        <div class="card-text" style="background-color: orange;color : white">
                            <h4 class="text-center"><B>{{ $user->name." ".$user->postnom." ".$user->prenom }}</B></h4>
                        </div>
                        <div class="dropdown-divider">
                        </div>
                        @foreach (Achat::all()->where('acheteur',$user->id)->sortBy('datePaiement') as $livre)
                            @if (!$ids->contains($livre->article_id))
                                <div style="overflow: auto; white-space: nowrap;">
                                    <table class="table table-responsive table-sm">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    {{ $livre->nom }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>
                                                    <table class="table table-striped table-sm">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <table class="table table-striped table-sm">
                                                                        <tr>
                                                                            <td align="center">
                                                                                    <div class="position-absolute">
                                                                                        <form action="{{ route('livrer',$livre->article_id) }}" accept-charset="UTF-8" method="get">
                                                                                            <input type="hidden" name="user" id="user" value="{{ $livre->acheteur }}">
                                                                                            <div class="position-absolute">
                                                                                                <button type="submit" class="btn btn-warning" id="deleteButton" onclick="return confirm('Confirmez-vous la livraison de cet article : {{ $livre->nom }} ?')">
                                                                                                    <img src="{{asset('imgs/livre.png')}}" alt="Erreur Image" width="20" height="20">
                                                                                                </button>
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                <a style="text-decoration: none; border-color: white; min-height: 500% ; background-image: url('{{ url('storage') }}/images/achat/{{ $livre->nom.$livre->article_id }}/profil.png')" class="col-sm btn btn-outline-dark">
                                                                                    <img width="240" height="230" src="{{ url('storage') }}/images/achat/{{ $livre->nom.$livre->article_id }}/profil.png" alt="Erreur Image">
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                                <td>
                                                                    <table class="table table-striped table-sm">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="text-center">
                                                                                    <table class="table table-striped table-sm">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>
                                                                                                    {{ "Date Achat" }}
                                                                                                </th>
                                                                                                <th>
                                                                                                    {{ "Mode" }}
                                                                                                </th>
                                                                                                @if ($livre->taille!=null)
                                                                                                    <th>
                                                                                                        {{ "Taille" }}
                                                                                                    </th>
                                                                                                @endif
                                                                                                <th>
                                                                                                    {{ "Couleur" }}
                                                                                                </th>
                                                                                                <th>
                                                                                                    {{ "Qté" }}
                                                                                                </th>
                                                                                                <th>
                                                                                                    {{ "Coût" }}
                                                                                                </th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            @foreach (Achat::all()->where('acheteur',$user->id)->where('article_id',$livre->article_id)->sortBy('datePaiement') as $item)
                                                                                                <tr>
                                                                                                    <th>
                                                                                                        {{ $item->datePaiement }}
                                                                                                    </th>
                                                                                                    <td>
                                                                                                        {{ $item->mode }}
                                                                                                    </td>
                                                                                                    @if ($item->taille!=null)
                                                                                                        <td>
                                                                                                            {{ $item->taille }}
                                                                                                        </td>
                                                                                                    @endif
                                                                                                    <td>
                                                                                                        <a class="btn" style="background-color: {{ $item->color }}; border-color: black"></a>{{ $item->couleur }}
                                                                                                    </td>
                                                                                                    <th>
                                                                                                        {{ $item->qte }}
                                                                                                    </th>
                                                                                                    <th>
                                                                                                        {{ (($item->qte)*($item->prix))." ".$item->devise }}
                                                                                                    </th>
                                                                                                </tr>
                                                                                            @endforeach
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">
                                                                                    <div class="container card-text">
                                                                                        <p class="text-wrap">
                                                                                            <I>
                                                                                                {{ "Contact WhatsApp : ".$livre->acheteur()[0]->tel }}
                                                                                            </I>
                                                                                        </p>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">
                                                                                    <div class="container card-text">
                                                                                        <p class="text-wrap">
                                                                                            <I>
                                                                                                {{ $livre->acheteur()[0]->adresse()[0]->type." ".$livre->acheteur()[0]->adresse()[0]->nom." N° ".$livre->acheteur()[0]->adresse()[0]->numero }}
                                                                                            </I><br>
                                                                                            <I>
                                                                                                {{ "Quartier : ".$livre->acheteur()[0]->adresse()[0]->quartier.", Commune : ".$livre->acheteur()[0]->adresse()[0]->commune }}
                                                                                            </I><br>
                                                                                            <I>
                                                                                                {{ $livre->acheteur()[0]->adresse()[0]->province()[0]->nom }}
                                                                                            </I><br>
                                                                                            <I>
                                                                                                {{ "Référence : ".$livre->acheteur()[0]->adresse()[0]->ref }}
                                                                                            </I>
                                                                                        </p>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>                                                            
                                                            </tr>
                                                        </tbody>
                                                        
                                                    </table>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @continue($ids->push($livre->article_id))
                            @endif
                        @endforeach
                        @continue($ids=collect())
                    @endforeach
                </div>
                <div id="macsBody" class="card-body" style="overflow: auto; white-space: nowrap;">                        
                    @foreach ($tels as $tel)
                        <div class="dropdown-divider">
                        </div>
                        <div class="card-text" style="background-color: rgb(13, 99, 42);color : white">
                            <h4 class="text-center"><B>{{ $tel }}</B></h4>
                        </div>
                        <div class="dropdown-divider">
                        </div>
                        @foreach (AchatMac::all()->where('tel',$tel)->sortBy('datePaiement') as $livre)
                            @if (!$idsMac->contains($livre->article_id))
                                <div style="overflow: auto; white-space: nowrap;">
                                    <table class="table table-responsive table-sm">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    {{ $livre->nom }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>
                                                    <table class="table table-striped table-sm">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <table class="table table-striped table-sm">
                                                                        <tr>
                                                                            <td align="center">
                                                                                    <div class="position-absolute">
                                                                                        <form action="{{ route('livrerMac',$livre->article_id) }}" accept-charset="UTF-8" method="get">
                                                                                            <input type="hidden" name="tel" id="tel" value="{{ $livre->tel }}">
                                                                                            <div class="position-absolute">
                                                                                                <button type="submit" class="btn btn-success" id="deleteButton" onclick="return confirm('Confirmez-vous la livraison de cet article : {{ $livre->nom }} ?')">
                                                                                                    <img src="{{asset('imgs/livre.png')}}" alt="Erreur Image" width="20" height="20">
                                                                                                </button>
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                <a style="text-decoration: none; border-color: white; min-height: 500% ; background-image: url('{{ url('storage') }}/images/achat/{{ $livre->nom.$livre->article_id }}/profil.png')" class="col-sm btn btn-outline-dark">
                                                                                    <img width="240" height="230" src="{{ url('storage') }}/images/achat/{{ $livre->nom.$livre->article_id }}/profil.png" alt="Erreur Image">
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                                <td>
                                                                    <table class="table table-striped table-sm">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="text-center">
                                                                                    <table class="table table-striped table-sm">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>
                                                                                                    {{ "Nom" }}
                                                                                                </th>
                                                                                                <th>
                                                                                                    {{ "Addresse" }}
                                                                                                </th>
                                                                                                <th>
                                                                                                    {{ "Date" }}
                                                                                                </th>
                                                                                                <th>
                                                                                                    {{ "Mode" }}
                                                                                                </th>
                                                                                                @if ($livre->taille!=null)
                                                                                                    <th>
                                                                                                        {{ "Taille" }}
                                                                                                    </th>
                                                                                                @endif
                                                                                                <th>
                                                                                                    {{ "Couleur" }}
                                                                                                </th>
                                                                                                <th>
                                                                                                    {{ "Qté" }}
                                                                                                </th>
                                                                                                <th>
                                                                                                    {{ "Coût" }}
                                                                                                </th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            @foreach (AchatMac::all()->where('tel',$tel)->where('article_id',$livre->article_id)->sortBy('datePaiement') as $item)
                                                                                                <tr>
                                                                                                    <th>
                                                                                                        {{ $item->noms }}
                                                                                                    </th>
                                                                                                    <th class="text-center">
                                                                                                        <div class="container card-text">
                                                                                                            <p class="text-wrap">
                                                                                                                <I>
                                                                                                                    {{ $item->addrs }}
                                                                                                                </I>
                                                                                                            </p>
                                                                                                        </div>
                                                                                                    </th>
                                                                                                    <th>
                                                                                                        {{ $item->datePaiement }}
                                                                                                    </th>
                                                                                                    <td>
                                                                                                        {{ $item->mode }}
                                                                                                    </td>
                                                                                                    @if ($item->taille!=null)
                                                                                                        <td>
                                                                                                            {{ $item->taille }}
                                                                                                        </td>
                                                                                                    @endif
                                                                                                    <td>
                                                                                                        <a class="btn" style="background-color: {{ $item->color }}; border-color: black"></a>{{ $item->couleur }}
                                                                                                    </td>
                                                                                                    <th>
                                                                                                        {{ $item->qte }}
                                                                                                    </th>
                                                                                                    <th>
                                                                                                        {{ (($item->qte)*($item->prix))." ".$item->devise }}
                                                                                                    </th>
                                                                                                </tr>
                                                                                            @endforeach
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>                                                            
                                                            </tr>
                                                        </tbody>
                                                        
                                                    </table>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @continue($idsMac->push($livre->article_id))
                            @endif
                        @endforeach
                        @continue($idsMac=collect())
                    @endforeach
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
    <script type="text/javascript">
        var cpt = 0;
        (function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#livre').on("click",function(){
                alert($('#livre').attr('data-artID'));
            });
    
        })();
    </script>
    <script type="text/javascript">
        $('#users').on('click',function(){
            $('#usersBody').attr('style','display : block');
            $('#users').attr('class','form-control btn btn-warning');
            $('#macsBody').attr('style','display : none');
            $('#macs').attr('class','form-control btn btn-outline-success');
        });
    </script>
    <script type="text/javascript">
        $('#macs').on('click',function(){
            $('#macsBody').attr('style','display : block');
            $('#macs').attr('class','form-control btn btn-success');
            $('#usersBody').attr('style','display : none');
            $('#users').attr('class','form-control btn btn-outline-warning');
        });
    </script>
@endsection