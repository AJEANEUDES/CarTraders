@extends('themes.main')
@section('title')
Voitures :: Mycartraders
@endsection
@section('main')
<div class="pagetitle">
    <h1 style="font-size: 25px;">
        Voitures
        <i class="bx bx-plus-circle" data-bs-toggle="modal" data-bs-target="#addVoitureModal"
            style="position: relative;top: 10px;font-size: 40px;color: #2DAF07;cursor: pointer;"></i>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Accueil</a></li>
            <li class="breadcrumb-item active">Voitures</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body" style="overflow: auto;">
                    <h5 class="card-title" style="text-align: center;font-size: 25px;">Listes des voitures
                    </h5>
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">CODE VOITURE</th>
                                <th scope="col">MARQUE</th>
                                <th scope="col">MODELE</th>
                                <th scope="col">PRIX</th>
                                <th scope="col">STATUS</th>
                                <th scope="col">DATE & HEURE</th>
                                <th scope="col">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($voitures as $voiture)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $voiture->code_voiture }}</td>
                                <td>{{ $voiture->marques->nom_marque }}</td>
                                <td>{{ $voiture->modeles->nom_modele }}</td>
                                <td>{{ $voiture->prix_voiture }}</td>
                                <td>
                                    @if($voiture->status_voiture)
                                    <span class="badge bg-success">Active</span>
                                    @else
                                    <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $voiture->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>
                                    <button class="btn btn-success" data-voiture="{{ encodeId($voiture->id_voiture) }}" id="updateVoiture">
                                        <i class="bi bi-pen"></i>
                                    </button>

                                    <button class="btn btn-secondary" data-voiture="{{ encodeId($voiture->id_voiture) }}" id="getInfosVoiture">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    <button class="btn btn-danger" data-voiture="{{ encodeId($voiture->id_voiture) }}" id="deteleVoiture">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body" style="overflow: auto;">
                    <h5 class="card-title" style="text-align: center;font-size: 25px;">Listes des voitures vendues
                    </h5>
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">CODE VOITURE</th>
                                <th scope="col">MARQUE</th>
                                <th scope="col">MODELE</th>
                                <th scope="col">PRIX</th>
                                <th scope="col">ETAT</th>
                                <th scope="col">DATE & HEURE</th>
                                <th scope="col">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($voitures_vendues as $voiture)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $voiture->code_voiture }}</td>
                                <td>{{ $voiture->marques->nom_marque }}</td>
                                <td>{{ $voiture->modeles->nom_modele }}</td>
                                <td>{{ $voiture->prix_voiture }}</td>
                                <td>
                                    @if($voiture->status_vente)
                                        <span class="badge bg-success">Vendue</span>
                                    @endif
                                </td>
                                <td>{{ $voiture->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>
                                    {{-- <button class="btn btn-success" data-voiture="{{ encodeId($voiture->id_voiture) }}" id="updateVoiture">
                                        <i class="bi bi-pen"></i>
                                    </button> --}}

                                    <button class="btn btn-secondary" data-voiture="{{ encodeId($voiture->id_voiture) }}" id="getInfosVoiture">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    {{-- <button class="btn btn-danger" data-voiture="{{ encodeId($voiture->id_voiture) }}" id="deteleVoiture">
                                        <i class="bi bi-trash"></i>
                                    </button> --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Modal pour voir plus d'info sur la voiture --}}
<div class="modal fade" id="infosVoitureModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">INFORMATION D'UNE VOITURE</h4>
            </div>
            <div class="modal-body row g-3">
                <div class="col-md-6 text-center">
                    <span>Marque</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewMarqueVoiture"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Modele</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewModeleVoiture"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Date de mise en circulation</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewDateCirculVoiture"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Prix</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewPrixVoiture"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Annee</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewAnneeVoiture"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Kilometrage</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewKilometrageVoiture"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Boite</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewBoiteVoiture"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Carburant</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewCarburantVoiture"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Nombre de place</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewNbresPlaceVoiture"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Puissance</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewPuissanceVoiture"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Interieur (couleur)</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewInterieurVoiture"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Exterieur (couleur)</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewExterieurVoiture"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Societe</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewSocieteVoiture"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Parc</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewParcVoiture"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Code de la voiture</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewCodeVoiture"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Date & Heure</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewDateCreatedVoiture"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Etat de vente</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewStatusVente"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" style="border-radius: 10px;" class="btn btn-secondary btn-md"
                    data-bs-dismiss="modal">
                    <i class="bx bx-exit"></i> Quitter
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal pour mettre a jour une voiture donnee --}}
<div class="modal fade" id="updateVoitureModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('voitures.update') }}" method="post" enctype="multipart/form-data" id="voitures-update">
                @csrf
                <div class="update-voiture"></div>
                <div class="modal-header">
                    <h4 class="modal-title">MISE A JOUR DE LA VOITURE</h4>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label for="marque__id" class="form-label">Marque de la voiture</label>
                        <select style="height: 55px;border-radius: 10px;"
                            class="form-control form-control-lg" name="marque__id" id="marque__id">
                            @foreach ($marques as $marque)
                                <option value="{{ $marque->id_marque }}">{{ $marque->nom_marque }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="modele__id" class="form-label">Modele de la voiture</label>
                        <select style="height: 55px;border-radius: 10px;text-transform: uppercase;"
                            class="form-control form-control-lg" name="modele__id" id="modele__id">
                            @foreach ($modeles as $modele)
                                <option value="{{ $modele->id_modele }}">{{ $modele->nom_modele }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="parking_id" class="form-label">Parc de la voiture</label>
                        <select style="height: 55px;border-radius: 10px;"
                            class="form-control form-control-lg" name="parking__id" id="parking__id">
                            @foreach ($parkings as $parking)
                                <option value="{{ $parking->id_parking }}">{{ $parking->nom_parking }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="societe__id" class="form-label">Societe de la voiture</label>
                        <select style="height: 55px;border-radius: 10px;text-transform: uppercase;"
                            class="form-control form-control-lg" name="societe__id" id="societe__id">
                            @foreach ($societes as $societe)
                                <option value="{{ $societe->id_societe }}">{{ $societe->nom_societe }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="annee_voiture" class="form-label">Année</label>
                        <input type="number" min="0" style="height: 55px;border-radius: 10px;"
                            class="form-control form-control-lg" name="annee_voiture" id="annee_voiture">
                    </div>
                    <div class="col-md-4">
                        <label for="kilometrage_voiture" class="form-label">Kilometrage</label>
                        <input type="number" min="0" style="height: 55px;border-radius: 10px;"
                            class="form-control form-control-lg" name="kilometrage_voiture" id="kilometrage_voiture">
                    </div>
                    <div class="col-md-4">
                        <label for="date_mise_circul_voiture" class="form-label">Date de mise en circulation</label>
                        <input type="date" style="height: 55px;border-radius: 10px;"
                            class="form-control form-control-lg" name="date_mise_circul_voiture"
                            id="date_mise_circul_voiture">
                    </div>
                    <div class="col-md-4">
                        <label for="carburant_voiture" class="form-label">Carburant</label>
                        <select style="height: 55px;border-radius: 10px;" class="form-control form-control-lg"
                            name="carburant_voiture" id="carburant_voiture">
                            <option selected disabled>-- Selectionnez --</option>
                            <option value="Diesel">Diesel</option>
                            <option value="Essence">Essence</option>
                            <option value="Hybride">Hybride</option>
                            <option value="Electrique">Electrique</option>
                            <option value="GLP">GLP</option>
                            <option value="GNV">GNV</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="boite_vitesse_voiture" class="form-label">Boite de vitesse</label>
                        <select style="height: 55px;border-radius: 10px;" class="form-control form-control-lg"
                            name="boite_vitesse_voiture" id="boite_vitesse_voiture">
                            <option selected disabled>-- Selectionnez --</option>
                            <option value="Manuelle">Manuelle</option>
                            <option value="Automatique">Automatique</option>
                            <option value="Robotisée">Robotisée</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="nbres_place_voiture" class="form-label">Nombre de place</label>
                        <select style="height: 55px;border-radius: 10px;" class="form-control form-control-lg"
                            name="nbres_place_voiture" id="nbres_place_voiture">
                            <option selected disabled>-- Selectionnez --</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="9">9</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="interieur_voiture" class="form-label">Interieur de la voiture (couleur)</label>
                        <input type="text" style="height: 55px;border-radius: 10px;"
                            class="form-control form-control-lg" name="interieur_voiture" id="interieur_voiture">
                    </div>
                    <div class="col-md-4">
                        <label for="exterieur_voiture" class="form-label">Exterieur de la voiture (couleur)</label>
                        <input type="text" style="height: 55px;border-radius: 10px;"
                            class="form-control form-control-lg" name="exterieur_voiture" id="exterieur_voiture">
                    </div>
                    <div class="col-md-4">
                        <label for="puissance_voiture" class="form-label">Puissance de la voiture</label>
                        <input type="text" style="height: 55px;border-radius: 10px;"
                            class="form-control form-control-lg" name="puissance_voiture" id="puissance_voiture">
                    </div>
                    <div class="col-md-6">
                        <label for="prix_voiture" class="form-label">Prix de la voiture</label>
                        <input type="number" min="0" style="height: 55px;border-radius: 10px;"
                            class="form-control form-control-lg" name="prix_voiture" id="prix_voiture">
                    </div>
                    <div class="col-md-6">
                        <label for="status_voiture" class="form-label">Status de la voiture</label>
                        <select style="height: 55px;border-radius: 10px;" class="form-control form-control-lg"
                            name="status_voiture" id="status_voiture">
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="status_vente" class="form-label">Etat de vente</label>
                        <select style="height: 55px;border-radius: 10px;" class="form-control form-control-lg"
                            name="status_vente" id="status_vente">
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="image_voiture" class="form-label">Image</label>
                        <input type="file" style="height: 55px;border-radius: 10px;" class="form-control form-control-lg"
                            name="image_voiture" id="image_voiture"/>
                    </div>
                    <div class="col-md-6" id="viewImageVoiture"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" style="border-radius: 10px;" class="btn btn-danger btn-md"
                        data-bs-dismiss="modal"> <i class="bx bx-exit"></i> Annuler</button>
                    <button type="submit" style="border-radius: 10px;" class="btn btn-success btn-md"><i
                            class="bx bx-save"></i> Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal pour supprimer une voiture donnee --}}
<div class="modal fade" id="deleteVoitureModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">SUPPRESSION D'UNE VOITURE</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center;" id="viewMessageDeleteVoiture"></p>
            </div>
            <div class="modal-footer">
                <button type="button" style="border-radius: 10px;" class="btn btn-secondary btn-md"
                    data-bs-dismiss="modal"> <i class="bx bx-exit"></i> Non</button>
                <form action="{{ route('voitures.delete') }}" method="post" id="voitures-delete">
                    @csrf
                    <div id="formDeleteVoiture"></div>
                </form>
            </div>
        </div>
    </div>
</div>


@include('packages.voitures.admin.voitureModal')
@endsection
@push('script-find-modele-voiture')
<script>
    //Pour recuperer les modeles de voiture grace a l'identifiant de la marque
    $(document).ready(function(){
        $("#marque_id").on("change", function(){
            let marque_id = $("#marque_id").val()
            //console.log(marque_id)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $.ajax({
                type: 'GET',
                url: '{{ route('marques-voitures.get.spec') }}',
                dataType: 'JSON',
                data: {marque_id: marque_id},
                success: (response) => {
                    //console.log('Request Success')
                    let optionsModele = '';
                    for(let i = 0; i < response.length; i++){
                        optionsModele += '<option value="'+response[i].id_modele+'">'+response[i].nom_modele+'</option>';
                    }

                    if(response.length > 0){
                        $('#modele_id').html(optionsModele);
                    }else{
                        $('#modele_id').html('<option value="" selected disabled>Aucun modele pour cette marque</option>');
                    }

                    $("#modele_id").on("change", function(){
                        let modele_id = $("#modele_id").val()
                    })
                },
                error: (error) => {
                    console.log('Request Erreur')
                    console.log(error)
                }
            })
        })
    })

    //Pour recuperer les societes grace a l'identifiant du parking
    $(document).ready(function(){
        $("#parking_id").on("change", function(){
            let parking_id = $("#parking_id").val()
            //console.log(parking_id)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $.ajax({
                type: 'GET',
                url: '{{ route('parkings-voitures.get.spec') }}',
                dataType: 'JSON',
                data: {parking_id: parking_id},
                success: (response) => {
                    //console.log('Request Success')
                    //console.log(response)
                    let optionsSociete = '';
                    for(let i = 0; i < response.length; i++){
                        optionsSociete += '<option value="'+response[i].id_societe+'">'+ response[i].nom_societe +'</option>';
                    }
                    if(response.length > 0){
                        $('#societe_id').html(optionsSociete);
                    }else{
                        $('#societe_id').html('<option value="" selected disabled>Aucune societe pour ce parc</option>');
                    }

                    $("#societe_id").on("change", function(){
                        let societe_id = $("#societe_id").val()
                    })
                },
                error: (error) => {
                    console.log('Request Erreur')
                    console.log(error)
                }
            })
        })
    })

    //Pour obtenir les informations d'une voiture grace a l'identifiant
    $(document).on('click', '#getInfosVoiture', function(){
        let id_voiture = $(this).data('voiture');
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'GET',
            url: '{{ route('voitures.info') }}',
            dataType: 'JSON',
            data: {id_voiture:id_voiture},
            success: (response)=>{
                let created_at = new Date().toLocaleDateString("fr");
                $("#viewMarqueVoiture").html(response.nom_marque);
                $("#viewModeleVoiture").html(response.nom_modele);
                $("#viewDateCirculVoiture").html(response.date_mise_circul_voiture);
                $("#viewPrixVoiture").html(response.prix_voiture+" FCFA");
                $("#viewAnneeVoiture").html(response.annee_voiture);
                $("#viewKilometrageVoiture").html(response.kilometrage_voiture+" Km");
                $("#viewBoiteVoiture").html(response.boite_vitesse_voiture);
                $("#viewCarburantVoiture").html(response.carburant_voiture);
                $("#viewNbresPlaceVoiture").html(response.nbres_place_voiture);
                $("#viewInterieurVoiture").html(response.interieur_voiture);
                $("#viewExterieurVoiture").html(response.exterieur_voiture);
                $("#viewSocieteVoiture").html(response.nom_societe);
                $("#viewParcVoiture").html(response.nom_parking);
                $("#viewPuissanceVoiture").html(response.puissance_voiture);
                $("#viewCodeVoiture").html(response.code_voiture);
                $("#viewDateCreatedVoiture").html(new Date(response.created_at).toLocaleDateString());
                if(response.status_vente){
                    $("#viewStatusVente").html('<span class="badge bg-success">Vendue</span>');
                }else{
                    $("#viewStatusVente").html('<span class="badge bg-danger">Non Vendue</span>');
                }
                $("#infosVoitureModal").modal('show');
            },
            error: (error)=>{
                console.log("Response error")
                console.log(error)
            }
            
        })
    })

    //Supprimer une voiture grace a l'identifiant
    $(document).on('click', '#deteleVoiture', function(){
        let id_voiture = $(this).data('voiture');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'GET',
            url: '{{ route('voitures.info') }}',
            dataType: 'JSON',
            data: {id_voiture:id_voiture},
            success: (response)=>{
                $("#viewMessageDeleteVoiture").html('Etes-vous sur de vouloir supprimer la voiture <strong>'+response.nom_marque+' '+response.nom_modele+'</strong> de la societe <strong>'+ response.nom_societe +'</strong> du parking <strong>'+response.nom_parking+'</strong>?');
                $("#formDeleteVoiture").html('<input type="hidden" name="id_voiture" value="'+response.id_voiture+'"> <button type="submit" style="border-radius: 10px;" class="btn btn-danger btn-md"><i class="bx bx-trash"></i> Oui</button>');
                $("#deleteVoitureModal").modal('show');
            },
            error: (error)=>{
                console.log('Response Erreur Delete Voiture')
                console.log(error)
            }
        })
    })

    //Mettre a jour une voiture grace a l'identifiant
    $(document).on('click', '#updateVoiture', function(){
        let id_voiture = $(this).data('voiture');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'GET',
            url: '{{ route('voitures.info') }}',
            dataType: 'JSON',
            data: {id_voiture:id_voiture},
            success: (response)=>{
                $(".update-voiture").html('<input type="hidden" name="id_voiture" value="'+response.id_voiture+'" id="id_voiture">');

                $("#updateVoitureModal").find('input[name="annee_voiture"]').val(response.annee_voiture);
                $("#updateVoitureModal").find('input[name="kilometrage_voiture"]').val(response.kilometrage_voiture);
                $("#updateVoitureModal").find('input[name="date_mise_circul_voiture"]').val(response.date_mise_circul_voiture);
                $("#updateVoitureModal").find('input[name="date_mise_circul_voiture"]').val(response.date_mise_circul_voiture);
                $("#updateVoitureModal").find('input[name="interieur_voiture"]').val(response.interieur_voiture);
                $("#updateVoitureModal").find('input[name="exterieur_voiture"]').val(response.exterieur_voiture);
                $("#updateVoitureModal").find('input[name="puissance_voiture"]').val(response.puissance_voiture);
                $("#updateVoitureModal").find('input[name="prix_voiture"]').val(response.prix_voiture);
                $("#updateVoitureModal").find('select[name="carburant_voiture"]').val(response.carburant_voiture);
                $("#updateVoitureModal").find('select[name="boite_vitesse_voiture"]').val(response.boite_vitesse_voiture);
                $("#updateVoitureModal").find('select[name="nbres_place_voiture"]').val(response.nbres_place_voiture);
                $("#updateVoitureModal").find('select[name="marque__id"]').val(response.id_marque);
                $("#updateVoitureModal").find('select[name="modele__id"]').val(response.id_modele);
                $("#updateVoitureModal").find('select[name="parking__id"]').val(response.id_parking);
                $("#updateVoitureModal").find('select[name="societe__id"]').val(response.id_societe);

                if(response.status_voiture){
                    $("#status_voiture").html('<option value="1" selected>Active</option><option value="0">Inactive</option>');
                }else{
                    $("#status_voiture").html('<option value="1">Active</option><option value="0" selected>Inactive</option>');
                }

                if(response.status_vente){
                    $("#status_vente").html('<option value="1" selected>Vendue</option><option value="0">Non Vendue</option>');
                }else{
                    $("#status_vente").html('<option value="1">Vendue</option><option value="0" selected>Non Vendue</option>');
                }

                $("#viewImageVoiture").html('<img width="100" height="100" src="'+response.image_voiture+'" />');

                $("#updateVoitureModal").modal("show");
            },
            error: (error)=>{
                console.log('Response Erreur Modifier Voiture')
                console.log(error)
            }
        })
    })
</script>
@endpush