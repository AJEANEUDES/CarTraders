@extends('themes.main')
@section('title')
Modeles :: Mycartraders
@endsection
@section('main')
<div class="pagetitle">
    <h1 style="font-size: 25px;">
        Modeles
        <i class="bx bx-plus-circle" data-bs-toggle="modal" data-bs-target="#addModeleModal"
            style="position: relative;top: 10px;font-size: 40px;color: #2DAF07;cursor: pointer;"></i>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Accueil</a></li>
            <li class="breadcrumb-item active">Modeles</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body" style="overflow: auto;">
                    <h5 class="card-title" style="text-align: center;font-size: 25px;">Listes des modeles de voiture
                    </h5>
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">CODE MODELE</th>
                                <th scope="col">NOM</th>
                                <th scope="col">MARQUE</th>
                                <th scope="col">STATUS</th>
                                <th scope="col">DATE & HEURE</th>
                                <th scope="col">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($modeles as $modele)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $modele->code_modele }}</td>
                                <td>{{ $modele->nom_modele }}</td>
                                <td>{{ $modele->nom_marque }}</td>
                                <td>
                                    @if($modele->status_modele)
                                    <span class="badge bg-success">Actif</span>
                                    @else
                                    <span class="badge bg-danger">Inactif</span>
                                    @endif
                                </td>
                                <td>{{ $modele->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>
                                    <button class="btn btn-success" data-modele="{{ encodeId($modele->id_modele) }}"
                                        id="updateModele">
                                        <i class="bi bi-pen"></i>
                                    </button>
                                    <button class="btn btn-secondary" data-modele="{{ encodeId($modele->id_modele) }}"
                                        id="getInfosModele">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-danger" data-modele="{{ encodeId($modele->id_modele) }}"
                                        id="deleteModele">
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

{{-- Modal pour voir plus d'info sur le modele --}}
<div class="modal fade" id="infosModeleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">INFORMATION D'UN MODELE</h4>
            </div>
            <div class="modal-body row g-3">
                <div class="col-md-6 text-center">
                    <span>Nom du modele</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewNomModele"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Marque</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewMarque"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Code du modele</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewCodeModele"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Date & Heure</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewDateCreatedModele"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Status</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewStatusModele"></div>
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

{{-- Modal pour modifier un modele de voiture --}}
<div class="modal fade" id="updateModeleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('modeles-voitures.update.gestion') }}" method="post" id="modeles-voitures-update-gestion">
                @csrf
                <div class="update-modele"></div>
                <div class="modal-header">
                    <h4 class="modal-title">MISE A JOUR D'UN MODELE</h4>
                </div>
                <div class="modal-body">
                    <label for="nom_modele" class="form-label">Nom du modele</label>
                    <input type="text" style="height: 55px;border-radius: 10px;" name="nom_modele" id="nom_modele"
                        value="" class="form-control form-control-lg" />
                    <label for="marque_id" class="form-label mt-3">Marque du modele</label>
                    <select style="height: 55px;border-radius: 10px;" name="marque_id" id="marque_id"
                        class="form-control form-control-lg ">
                        @foreach ($marques as $marque)
                        <option value="{{ $marque->id_marque }}">{{ $marque->nom_marque }}</option>
                        @endforeach
                    </select>
                    <label for="status_modele" class="form-label mt-3">Status du
                        modele</label>
                    <select style="height: 55px;border-radius: 10px;" name="status_modele" id="status_modele"
                        class="form-control form-control-lg">

                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" style="border-radius: 10px;" class="btn btn-danger btn-md"
                        data-bs-dismiss="modal">
                        <i class="bx bx-exit"></i> Annuler
                    </button>
                    <button type="submit" style="border-radius: 10px;" class="btn btn-success btn-md"><i
                            class="bx bx-save"></i>
                        Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal pour supprimer un modele --}}
<div class="modal fade" id="deleteModeleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">SUPPRESSION DU MODELE</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center;" id="viewMessageDeleteModele"></p>
            </div>
            <div class="modal-footer">
                <button type="button" style="border-radius: 10px;" class="btn btn-secondary btn-md"
                    data-bs-dismiss="modal"> <i class="bx bx-exit"></i> Non</button>
                <form action="{{ route('modeles-voitures.delete.gestion') }}" method="post" id="modeles-voitures-delete-gestion">
                    @csrf
                    <div id="formDeleteModele"></div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('packages.modeles.gestionnaire.modeleModal')
@endsection
@push('script-find-modele')
<script>
    //Modifier un modele grace a l'identifiant
    $(document).on('click', '#updateModele', function(){
        let id_modele = $(this).data('modele')

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'GET',
            url: '{{ route('modeles.info.gestion') }}',
            dataType: 'JSON',
            data: {id_modele:id_modele},
            success: (response)=>{
                $("#updateModeleModal").find('input[name="nom_modele"]').val(response.nom_modele);
                $("#updateModeleModal").find('select[name="marque_id"]').val(response.id_marque);
                if(response.status_modele){
                    $("#status_modele").html('<option value="1" selected>Active</option><option value="0">Inactive</option>');
                }else{
                    $("#status_modele").html('<option value="1">Active</option><option value="0" selected>Inactive</option>');
                }
                $(".update-modele").html('<input type="hidden" name="id_modele" value="'+response.id_modele+'">');
                $("#updateModeleModal").modal("show");
            },
            error: (error)=>{
                console.log('Response Erreur Update Modele')
                console.log(error)
            }
        })
    })

    //Obtenir plus d'information sur un modele
    $(document).on('click', '#getInfosModele', function(){
        let id_modele = $(this).data('modele')

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'GET',
            url: '{{ route('modeles.info.gestion') }}',
            dataType: 'JSON',
            data: {id_modele:id_modele},
            success: (response)=>{
                $("#viewNomModele").html(response.nom_modele);
                $("#viewMarque").html(response.nom_marque);
                $("#viewCodeModele").html(response.code_modele);
                $("#viewDateCreatedModele").html(response.created_at);
                if(response.status_modele){
                    $("#viewStatusModele").html('<span class="badge bg-success">Active</span>');
                }else{
                    $("#viewStatusModele").html('<span class="badge bg-danger">Inactive</span>');
                }
                $("#operateur").html(response.nom_user+" "+response.prenom_user);
                $("#infosModeleModal").modal('show');
            },
            error: (error)=>{
                console.log('Response Erreur Infos Modele')
                console.log(error)
            }
        })
    })

    //Supprimer un modele grace a l'identifiant
    $(document).on('click', '#deleteModele', function(){
        let id_modele = $(this).data('modele');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'GET',
            url: '{{ route('modeles.info.gestion') }}',
            dataType: 'JSON',
            data: {id_modele:id_modele},
            success: (response)=>{
                $("#viewMessageDeleteModele").html('Etes-vous sur de vouloir supprimer le modele <strong>'+response.nom_modele+'</strong>?');
                $("#formDeleteModele").html('<input type="hidden" name="id_modele" value="'+response.id_modele+'"> <button type="submit" style="border-radius: 10px;" class="btn btn-danger btn-md"><i class="bx bx-trash"></i> Oui</button>');
                $("#deleteModeleModal").modal('show');
            },
            error: (error)=>{
                console.log('Response Erreur Delete Modele')
                console.log(error)
            }
        })
    })
</script>
@endpush