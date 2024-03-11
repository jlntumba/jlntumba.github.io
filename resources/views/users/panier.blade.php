@extends('layouts.app') 


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-center"><strong>{{ "Votre panier " }}
                        @if ($panier->count()==1)
                            {{ ": ".$panier->count()." article" }}
                        @else
                            @if ($panier->count()!=0)
                                {{ ": ".$panier->count()." articles" }}
                            @endif
                        @endif
                    </strong></h5>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="container">
                        <div class="row row-cols-sm-1">
                            @for ($i = 0; $i < $panier->count(); $i++)
                                <div style="overflow: auto; white-space: nowrap;">
                                    <table class="table table-responsive table-sm">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    {{ $panier[$i]->article()[0]->nom }}
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
                                                                                <div  class="position-absolute">
                                                                                    <form action="{{ route('deletePanierUser',$panier[$i]->article_id) }}" accept-charset="UTF-8" method="post">
                                                                                        @csrf
                                                                                        @method('delete')
                                                                                        <input type="hidden" name="modeID" id="modeID" value="{{ $panier[$i]->mode_id }}">
                                                                                        <input type="hidden" name="tailleID" id="tailleID" value="{{ $panier[$i]->taille_id }}">
                                                                                        <input type="hidden" name="couleurID" id="couleurID" value="{{ $panier[$i]->couleur_id }}">
                                                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Confirmez-vous la suppression de cet article du panier ?')">
                                                                                            <img src="{{asset('imgs/delete.png')}}" alt="Erreur Image" width="20" height="20">
                                                                                        </button>
                                                                                    </form>
                                                                                </div>
                                                                                <a href="{{ route('articles.show',$panier[$i]->article()[0]) }}" style="text-decoration: none; border-color: white; min-height: 500% ; background-image: url('{{ url('storage') }}/images/{{ $panier[$i]->article()[0]->nom.$panier[$i]->article()[0]->id }}/profil.png')" class="col-sm btn btn-outline-dark">
                                                                                    <img width="240" height="230" src="{{ url('storage') }}/images/{{ $panier[$i]->article()[0]->nom.$panier[$i]->article()[0]->id }}/profil.png" alt="Erreur Image">
                                                                                </a>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <div class="container card-text">
                                                                                    <p class="text-wrap">
                                                                                        <I>
                                                                                            {{ $panier[$i]->article()[0]->description }}
                                                                                        </I>
                                                                                    </p>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                                <td>
                                                                    <table class="table table-striped table-sm">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="text-center">
                                                                                    {{ $panier[$i]->article()[0]->type()->type }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">
                                                                                    {{ $panier[$i]->article()[0]->marque()[0]->marque }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center">
                                                                                    {{ $panier[$i]->mode()[0]->mode }}
                                                                                </td>
                                                                            </tr>
                                                                            @if ($panier[$i]->article()[0]->type()->id==1)
                                                                                <tr>
                                                                                    <td class="text-center">
                                                                                        {{ $panier[$i]->taille()[0]->taille }}
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                            <tr>
                                                                                <td class="text-center">
                                                                                    <a class="btn" style="background-color: {{ $panier[$i]->couleur()[0]->color }}; border-color: black"></a>{{ $panier[$i]->couleur()[0]->couleur }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                    <table class="table table-bordered table-sm table-primary">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>
                                                                                                    {{ "Qté" }}
                                                                                                </th>
                                                                                                <th>
                                                                                                    {{ "WhatsApp Vendeur" }}
                                                                                                </th>
                                                                                                <th>
                                                                                                    {{ "Prix" }}
                                                                                                </th>
                                                                                                <th>
                                                                                                    {{ "Total" }}
                                                                                                </th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    <select style="width: 12vmax" name="qte{{ $i }}" id="qte{{ $i }}" data-articleID="{{ $panier[$i]->article()[0]->id }}" data-articlePrix="{{ $panier[$i]->article()[0]->prix }}" data-articleDevise="{{ $panier[$i]->article()[0]->devise }}" data-articleMode="{{ $panier[$i]->mode_id }}" data-articleTaille="{{ $panier[$i]->taille_id }}" data-articleCouleur="{{ $panier[$i]->couleur_id }}" class="form-control  form-select @error('qte{{ $i }}') is-invalid @enderror" autocomplete="qte{{ $i }}" autofocus required>
                                                                                                        <option value='{{ $panier[$i]->qte }}'>{{ $panier[$i]->qte }}</option>
                                                                                                        @for ($y = 1; $y <= $panier[$i]->article()[0]->nbr; $y++)
                                                                                                            @if ($panier[$i]->qte!=$y)
                                                                                                                <option value='{{ $y }}'>{{ $y }}</option>
                                                                                                            @endif
                                                                                                        @endfor
                                                                                                    </select>
                                                                                                </td>
                                                                                                <td>
                                                                                                    {{ $panier[$i]->article()[0]->marchand()->tel }}
                                                                                                </td>
                                                                                                <td>
                                                                                                    {{ $panier[$i]->article()[0]->prix." ".$panier[$i]->article()[0]->devise }}
                                                                                                </td>
                                                                                                <td id="total{{ $i }}">
                                                                                                    {{ (($panier[$i]->qte)*($panier[$i]->article()[0]->prix))." ".$panier[$i]->article()[0]->devise }}
                                                                                                </td>
                                                                                                <td>
                                                                                                    <button class="btn btn-success"  id="buy{{ $i }}" data-articleID="{{ $panier[$i]->article()[0]->id }}" data-articleMode="{{ $panier[$i]->mode_id }}" data-articleTaille="{{ $panier[$i]->taille_id }}" data-articleCouleur="{{ $panier[$i]->couleur_id }}" {{ $panier[$i]->article()[0]->nbr<$panier[$i]->qte ? 'disabled' : ''  }}>
                                                                                                        <img src="{{asset('imgs/paie.png')}}" alt="Erreur Image" width="25" height="25">
                                                                                                    </button>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                @if ($panier[$i]->article()[0]->nbr==0)
                                                                                    <td style="color: red">
                                                                                        {{ "N'est plus disponible !" }}
                                                                                    </td>
                                                                                @else
                                                                                    @if ($panier[$i]->article()[0]->nbr>=$panier[$i]->qte)
                                                                                        <td>
                                                                                            {{ "Disponibles : ". $panier[$i]->article()[0]->nbr }}
                                                                                        </td>
                                                                                    @else
                                                                                        <td style="color: red">
                                                                                            {{ "Veillez reduire la quantité de votre commande : ". $panier[$i]->article()[0]->nbr }}
                                                                                        </td>
                                                                                    @endif
                                                                                @endif
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
                            @endfor
                            <div class="dropdown-divider">
                            </div>
                            <div class="card-text" style="background-color: darkblue;color : white">
                                <h4 class="text-center"><B>{{ "Déjà payés" }}</B></h4>
                            </div>
                            <div class="dropdown-divider">
                            </div>

                            @foreach ($articlesAchetes as $achete)
                                @if ($id!=$achete->article_id)
                                    <div style="overflow: auto; white-space: nowrap;">
                                        <table class="table table-responsive table-sm">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">
                                                        {{ $achete->nom }}
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
                                                                                    <a style="text-decoration: none; border-color: white; min-height: 500% ; background-image: url('{{ url('storage') }}/images/achat/{{ $achete->nom.$achete->article_id }}/profil.png')" class="col-sm btn btn-outline-dark">
                                                                                        <img width="240" height="230" src="{{ url('storage') }}/images/achat/{{ $achete->nom.$achete->article_id }}/profil.png" alt="Erreur Image">
                                                                                    </a>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="container card-text">
                                                                                        <p class="text-wrap">
                                                                                            <I>
                                                                                                {{ $achete->description }}
                                                                                            </I>
                                                                                        </p>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td>
                                                                        <table class="table table-striped table-sm">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="text-end">
                                                                                        {{ $achete->type }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="text-end">
                                                                                        {{ $achete->marque }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <table class="table table-bordered table-sm table-primary">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>
                                                                                                        {{ "Dates de paiement" }}
                                                                                                    </th>
                                                                                                    <th>
                                                                                                        {{ "WhatsApp Vendeur" }}
                                                                                                    </th>
                                                                                                    <th>
                                                                                                        {{ "Mode" }}
                                                                                                    </th>
                                                                                                    @if ($achete->taille!=null)
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
                                                                                                        {{ "Total" }} 
                                                                                                    </th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                @foreach (Achat::where('acheteur',Auth::user()->id)->where('article_id',$achete->article_id)->get() as $a)
                                                                                                    <tr>
                                                                                                        <td>
                                                                                                            {{ $a->datePaiement }}
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            {{ $a->marchand()[0]->tel }}
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            {{ $a->mode }}
                                                                                                        </td>
                                                                                                        @if ($a->taille!=null)
                                                                                                            <td>
                                                                                                                {{ $a->taille }}
                                                                                                            </td>
                                                                                                        @endif
                                                                                                        <td>
                                                                                                            <a class="btn" style="background-color: {{ $a->color }}; border-color: black"></a>{{ $a->couleur }}
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            {{ $a->qte }}
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            {{ (($a->qte)*($a->prix))." ".$a->devise }}
                                                                                                        </td>
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
                                    @continue($id = $achete->article_id)
                                @endif
                            @endforeach

                            <div class="dropdown-divider">
                            </div>
                            <div class="card-text" style="background-color: orange;color : white">
                                <h4 class="text-center"><B>{{ "Reçus" }}</B></h4>
                            </div>
                            <div class="dropdown-divider">
                            </div>
                            @foreach ($articlesRecus as $recu)
                                @if ($idR!=$recu->article_id)
                                    <div style="overflow: auto; white-space: nowrap;">
                                        <table class="table table-responsive table-sm">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">
                                                        {{ $recu->nom }}
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
                                                                                    <div  class="position-absolute">
                                                                                        <form action="{{ route('deleteLivraisonUser',$recu->article_id) }}" accept-charset="UTF-8" method="post">
                                                                                            @csrf
                                                                                            @method('delete')
                                                                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Confirmez-vous la suppression de cet article de la liste des livraisons ?')">
                                                                                                <img src="{{asset('imgs/delete.png')}}" alt="Erreur Image" width="20" height="20">
                                                                                            </button>
                                                                                        </form>
                                                                                    </div>
                                                                                    <a style="text-decoration: none; border-color: white; min-height: 500% ; background-image: url('{{ url('storage') }}/images/achat/{{ $recu->nom.$recu->article_id }}/profil.png')" class="col-sm btn btn-outline-dark">
                                                                                        <img width="240" height="230" src="{{ url('storage') }}/images/achat/{{ $recu->nom.$recu->article_id }}/profil.png" alt="Erreur Image">
                                                                                    </a>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="container card-text">
                                                                                        <p class="text-wrap">
                                                                                            <I>
                                                                                                {{ $recu->description }}
                                                                                            </I>
                                                                                        </p>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td>
                                                                        <table class="table table-striped table-sm">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="text-end">
                                                                                        {{ $recu->type }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="text-end">
                                                                                        {{ $recu->marque }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <table class="table table-bordered table-sm table-primary">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>
                                                                                                        {{ "Dates de paiement" }}
                                                                                                    </th>
                                                                                                    <th>
                                                                                                        {{ "Dates de livraisons" }}
                                                                                                    </th>
                                                                                                    <th>
                                                                                                        {{ "WhatsApp Vendeur" }}
                                                                                                    </th>
                                                                                                    <th>
                                                                                                        {{ "Mode" }}
                                                                                                    </th>
                                                                                                    @if ($recu->taille!=null)
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
                                                                                                        {{ "Total" }}
                                                                                                    </th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                @foreach (Livraison::where('acheteur',Auth::user()->id)->where('article_id',$recu->article_id)->get() as $r)
                                                                                                    <tr>
                                                                                                        <td>
                                                                                                            {{ $r->datePaiement }}
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            {{ $r->dateLivraison }}
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            {{ $r->marchand()[0]->tel }}
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            {{ $r->mode }}
                                                                                                        </td>
                                                                                                        @if ($r->taille!=null)
                                                                                                            <td>
                                                                                                                {{ $r->taille }}
                                                                                                            </td>
                                                                                                        @endif
                                                                                                        <td>
                                                                                                            <a class="btn" style="background-color: {{ $r->color }}; border-color: black"></a>{{ $r->couleur }}
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            {{ $r->qte }}
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            {{ (($r->qte)*($r->prix))." ".$r->devise }}
                                                                                                        </td>
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
                                    @continue($idR = $recu->article_id)
                                @endif
                            @endforeach
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <img src="{{asset('imgs/LOGO Plus.png')}}" alt="Erreur Image" width="9%">
                    <input type="hidden" name="panierQte" id="panierQte" value="{{ $panier->count() }}">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ajaxModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-dialog-centered" style="text-decoration-color: white">
            <div class="modal-header justify-content-sm-center">
                <h4 class="modal-title" id="modalHeading" >{{ "Moyen de paiement" }}</h4>
            </div>
            <div class="modal-body" id="body">
                <form action=""  id="validePaiement" method="get">
                    <input type="hidden" name="artIDPaiement" id="artIDPaiement" value="">
                    <input type="hidden" name="modeArtID" id="modeArtID" value="">
                    <input type="hidden" name="tailleArtID" id="tailleArtID" value="">
                    <input type="hidden" name="couleurArtID" id="couleurArtID" value="">
                    <button type='submit' class='btn btn-success float-sm-none'>
                        {{ 'Valider' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script type="text/javascript">
        (function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).ready(function(){
                var panierQte = $('#panierQte').val();
                /**
                 * Pour chanque article dans le panier, afin d'ajouter de qté et procéder à l'achat 
                 **/
                for (let z = 0; z < panierQte; z++) {
                    $("#qte"+z).on('input',function(){
                        var artID = $(this).attr("data-articleID");
                        var artPrix = $(this).attr("data-articlePrix");
                        var artDevise = $(this).attr("data-articleDevise");
                        var qte = $('#qte'+z).val();
                        $.ajax({
                            url:"{{ route('plusQte') }}",
                            type : "get", //method
                            async:true,
                            data:{qte:$('#qte'+z).val(),artID:$('#qte'+z).attr("data-articleID"),artMode:$('#qte'+z).attr("data-articleMode"),artTaille:$('#qte'+z).attr("data-articleTaille"),artCouleur:$('#qte'+z).attr("data-articleCouleur")},
                            dataType : 'json',
                            success:function(data){
                                $('#total'+z).html(artPrix*qte+" "+artDevise);
                                $('#buy'+z).attr('disabled',false);
                            },
                            error:function(response){
                                alert('err');
                                if(response.status==500){
                                    console.log("error");
                                }
                            }
                        });
                    });
                    //achat
                    $('#buy'+z).on("click",function(){
                        var artID = $(this).attr("data-articleID");
                        var artMode=$(this).attr("data-articleMode");
                        var artTaille=$(this).attr("data-articleTaille");
                        var artCouleur=$(this).attr("data-articleCouleur");

                        $('#ajaxModal').modal('show');
                        $('#validePaiement').attr("action","{{ route('paiement') }}");
                        $('#artIDPaiement').attr("value",artID);
                        $('#modeArtID').attr("value",artMode);
                        $('#tailleArtID').attr("value",artTaille);
                        $('#couleurArtID').attr("value",artCouleur);
                    });
                }
            });
        })();
    </script>
@endsection