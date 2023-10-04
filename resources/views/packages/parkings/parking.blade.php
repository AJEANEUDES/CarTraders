@extends('themes.main')
@section('title')
Parcs :: Mycartraders
@endsection
@section('main')
<div class="pagetitle">
    <h1 style="font-size: 25px;">
        Parcs
        <i class="bx bx-plus-circle" data-bs-toggle="modal" data-bs-target="#addParkingModal"
            style="position: relative;top: 10px;font-size: 40px;color: #2DAF07;cursor: pointer;"></i>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Accueil</a></li>
            <li class="breadcrumb-item active">Parcs</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body" style="overflow: auto;">
                    <h5 class="card-title" style="text-align: center;font-size: 25px;">Listes des parcs de voiture
                    </h5>
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">CODE PARC</th>
                                <th scope="col">NOM</th>
                                <th scope="col">STATUS</th>
                                <th scope="col">DATE & HEURE</th>
                                <th scope="col">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($parkings as $parking)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $parking->code_parking }}</td>
                                <td>{{ $parking->nom_parking }}</td>
                                <td>
                                    @if($parking->status_parking)
                                    <span class="badge bg-success">Actif</span>
                                    @else
                                    <span class="badge bg-danger">Inactif</span>
                                    @endif
                                </td>
                                <td>{{ $parking->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>
                                    <button class="btn btn-success" data-parking="{{ encodeId($parking->id_parking) }}"
                                        id="updateParking">
                                        <i class="bi bi-pen"></i>
                                    </button>
                                    <button class="btn btn-secondary"
                                        data-parking="{{ encodeId($parking->id_parking) }}" id="getInfosParking">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-danger" data-parking="{{ encodeId($parking->id_parking) }}"
                                        id="deleteParking">
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

{{-- Modal pour voir plus d'info sur le parc --}}
<div class="modal fade" id="infosParkingModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">INFORMATION DU PARC</h4>
            </div>
            <div class="modal-body row g-3">
                <div class="col-md-6 text-center">
                    <span>Nom du parc</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewNomParking"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Code du parc</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewCodeParking"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Date & Heure</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewDateCreatedParking"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Status</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewStatusParking"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Operateur (creer par)</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="operateur"></div>
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

{{-- Modal pour modifier un parc de voiture --}}
<div class="modal fade" id="updateParkingModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('parkings-voitures.update') }}" method="post" id="parkings-voitures-update">
                @csrf
                <div class="update-parking"></div>
                <div class="modal-header">
                    <h4 class="modal-title">MISE A JOUR DU PARC</h4>
                </div>
                <div class="modal-body">
                    <label for="nom_parking" class="form-label">Nom du parc</label>
                    <input type="text" style="height: 55px;border-radius: 10px;" name="nom_parking" id="nom_parking"
                        value="" class="form-control form-control-lg" />
                    <label for="status_parking" class="form-label mt-3">Status du parc</label>
                    <select style="height: 55px;border-radius: 10px;" name="status_parking" id="status_parking"
                        class="form-control form-control-lg">
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" style="border-radius: 10px;" class="btn btn-danger btn-md"
                        data-bs-dismiss="modal"> <i class="bx bx-exit"></i> Annuler</button>
                    <button type="submit" style="border-radius: 10px;" class="btn btn-success btn-md"><i
                            class="bx bx-save"></i>
                        Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal pour supprimer un parc de voiture --}}
<div class="modal fade" id="deleteParkingModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">SUPPRESSION D'UN PARC</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center;" id="viewMessageDeleteParking"></p>
            </div>
            <div class="modal-footer">
                <button type="button" style="border-radius: 10px;" class="btn btn-secondary btn-md"
                    data-bs-dismiss="modal"> <i class="bx bx-exit"></i> Non</button>
                <form action="{{ route('parkings-voitures.delete') }}" method="post" id="parkings-voitures-delete">
                    @csrf
                    <div id="formDeleteParking"></div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('packages.parkings.parkingModal')
@endsection
@push('script-parcs-voiture')
<script>
    //Modifier un parc grace a l'identifiant
    $(document).on('click', '#updateParking', function(){
        let id_parking = $(this).data('parking')

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'GET',
            url: '{{ route('parkings.info') }}',
            dataType: 'JSON',
            data: {id_parking:id_parking},
            success: (response)=>{
                $("#updateParkingModal").find('input[name="nom_parking"]').val(response.nom_parking);
                if(response.status_parking){
                    $("#status_parking").html('<option value="1" selected>Active</option><option value="0">Inactive</option>');
                }else{
                    $("#status_parking").html('<option value="1">Active</option><option value="0" selected>Inactive</option>');
                }
                $(".update-parking").html('<input type="hidden" name="id_parking" value="'+response.id_parking+'">');
                $("#updateParkingModal").modal("show");
            },
            error: (error)=>{
                console.log('Response Erreur Update Parking')
                console.log(error)
            }
        })
    })

    //Obtenir plus d'information sur un parc
    $(document).on('click', '#getInfosParking', function(){
        let id_parking = $(this).data('parking')

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'GET',
            url: '{{ route('parkings.info') }}',
            dataType: 'JSON',
            data: {id_parking:id_parking},
            success: (response)=>{
                $("#viewNomParking").html(response.nom_parking);
                $("#viewCodeParking").html(response.code_parking);
                $("#viewDateCreatedParking").html(response.created_at);
                if(response.status_parking){
                    $("#viewStatusParking").html('<span class="badge bg-success">Active</span>');
                }else{
                    $("#viewStatusParking").html('<span class="badge bg-danger">Inactive</span>');
                }
                $("#operateur").html(response.nom_user+" "+response.prenom_user);
                $("#infosParkingModal").modal('show');
            },
            error: (error)=>{
                console.log('Response Erreur Infos Parking')
                console.log(error)
            }
        })
    })

    //Supprimer un parc grace a l'identifiant
    $(document).on('click', '#deleteParking', function(){
        let id_parking = $(this).data('parking');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'GET',
            url: '{{ route('parkings.info') }}',
            dataType: 'JSON',
            data: {id_parking:id_parking},
            success: (response)=>{
                $("#viewMessageDeleteParking").html('Etes-vous sur de vouloir supprimer le parc <strong>'+response.nom_parking+'</strong>?');
                $("#formDeleteParking").html('<input type="hidden" name="id_parking" value="'+response.id_parking+'"> <button type="submit" style="border-radius: 10px;" class="btn btn-danger btn-md"><i class="bx bx-trash"></i> Oui</button>');
                $("#deleteParkingModal").modal('show');
            },
            error: (error)=>{
                console.log('Response Erreur Delete Parking')
                console.log(error)
            }
        })
    })
</script>
@endpush