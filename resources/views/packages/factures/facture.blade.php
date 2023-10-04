@extends('themes.main')
@section('title')
Factures :: Mycartraders
@endsection
@section('main')
<div class="pagetitle">
    <h1 style="font-size: 25px;">Factures</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Accueil</a></li>
            <li class="breadcrumb-item active">Factures</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body" style="overflow: auto;">
                    <h5 class="card-title" style="text-align: center;font-size: 25px;">Listes des factures
                    </h5>
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">RESERVATION</th>
                                <th scope="col">CLIENT</th>
                                <th scope="col">FACTURE</th>
                                <th scope="col">DATE & HEURE</th>
                                <th scope="col">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($factures as $facture)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $facture->nom_marque }} {{ $facture->nom_modele }} </td>
                                <td>{{ $facture->nom_user }} {{ $facture->prenom_user }}</td>
                                <td>
                                    <a href="{{ $facture->path_facture }}" target="blank" class="btn btn-secondary">
                                        <i class="bx bxs-file"></i> Telecharger
                                    </a>
                                </td>
                                <td>{{ $facture->created_at }}</td>
                                <td>
                                    <button class="btn btn-success" data-facture="{{ encodeId($facture->id_facture) }}"
                                        id="updateFacture">
                                        <i class="bi bi-pen"></i>
                                    </button>
                                    <button class="btn btn-secondary" data-facture="{{ encodeId($facture->id_facture) }}"
                                        id="getInfosFacture">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    {{-- <button class="btn btn-danger" data-facture="{{ encodeId($facture->id_facture) }}"
                                        id="deleteFacture">
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

{{-- Modal de l'envoie de facture --}}
<div class="modal fade" id="updateFactureModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">MODIFICATION D'UNE FACTURE</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('factures.update') }}" method="post" enctype="multipart/form-data" id="factures-update">
                    @csrf
                    <input type="hidden" name="id_facture" id="id_facture" value="">
                    <label for="facture" class="form-label">Facture</label>
                    <input type="file" style="height: 55px;border-radius: 10px;" name="path_facture" id="path_facture"
                        class="form-control form-control-lg"/>
                    <button type="submit" style="border-radius: 10px;" class="btn btn-success btn-md mt-3"><i
                            class="bx bx-save"></i> Enregistrer</button>
                            <button type="button" style="border-radius: 10px;" class="btn btn-danger btn-md mt-3"
                    data-bs-dismiss="modal"> <i class="bx bx-exit"></i> Annuler</button>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

{{-- Modal pour voir plus d'info sur la reservation --}}
<div class="modal fade" id="infosReservationModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">INFORMATION D'UNE FACTURE</h4>
            </div>
            <div class="modal-body row g-3">
                <div class="col-md-6 text-center">
                    <span>Code reservation</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewCodeReservation"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Prix reservation</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewPrixReservation"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Voiture</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewVoiture"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Code voiture</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewCodeVoiture"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Prix de la voiture</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewPrixVoiture"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Societe</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewSociete"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Parc</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewParking"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Date & Heure</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewDateCreated"></div>
                </div>
                {{-- <div class="col-md-6 text-center">
                    <span>Status</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewStatusReservation"></div>
                </div> --}}
                <div class="col-md-12 text-center">
                    <span>Identité du client</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewClient"></div>
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

@endsection
@push('scripts-reservations')
    <script>
        //Pour obtenir les informations d'une facture grace a l'identifiant
        $(document).on('click', '#getInfosFacture', function(){
            let id_facture = $(this).data('facture');
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            $.ajax({
                type: 'GET',
                url: '{{ route('factures.info') }}',
                dataType: 'JSON',
                data: {id_facture:id_facture},
                success: (response)=>{
                    $("#viewVoiture").html(response.nom_marque+" "+response.nom_modele);
                    $("#viewPrixVoiture").html(response.prix_voiture+" FCFA");
                    $("#viewCodeVoiture").html(response.code_voiture);
                    $("#viewCodeReservation").html(response.code_reservation);
                    $("#viewSociete").html(response.nom_societe);
                    $("#viewParking").html(response.nom_parking);
                    $("#viewPrixReservation").html(response.prix_reservation+" FCFA");
                    $("#viewClient").html(response.nom_user+" "+response.prenom_user);
                    $("#viewDateCreated").html(response.created_at);
                    // if(response.status_reservation){
                    //     $("#viewStatusReservation").html('<span class="badge bg-success">Payée</span>');
                    // }else{
                    //     $("#viewStatusReservation").html('<span class="badge bg-danger">Non Payée</span>');
                    // }
                    $("#infosReservationModal").modal('show');
                },
                error: (error)=>{
                    console.log("Response error")
                    console.log(error)
                }
                
            })
        })

        // Modifier de facture a un client
        $(document).on('click', '#updateFacture', function(){
            let id_facture = $(this).data('facture')
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            $.ajax({
                type: 'GET',
                url: '{{ route('factures.info') }}',
                dataType: 'JSON',
                data: {id_facture:id_facture},
                success: (response)=>{
                    $("#updateFactureModal").find('input[name="id_facture"]').val(response.id_facture)
                    $("#updateFactureModal").modal('show')
                },
                error: (error)=>{
                    console.log('Response Erreur Update Facture')
                    console.log(error)
                }
            })
        })
    </script>
@endpush