@extends('themes.main')
@section('title')
Gestionnaires :: Mycartraders
@endsection
@section('main')
<div class="pagetitle">
    <h1 style="font-size: 25px;">
        Gestionnaires
        <i class="bx bx-plus-circle" data-bs-toggle="modal" data-bs-target="#addGestionnaireModal"
            style="position: relative;top: 10px;font-size: 40px;color: #2DAF07;cursor: pointer;"></i>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Accueil</a></li>
            <li class="breadcrumb-item active">Gestionnaires</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body" style="overflow: auto;">
                    <h5 class="card-title" style="text-align: center;font-size: 25px;">Listes des gestionnaires
                    </h5>
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">CODE SERVICE</th>
                                <th scope="col">NOM</th>
                                <th scope="col">PRENOM</th>
                                <th scope="col">STATUS</th>
                                <th scope="col">DATE & HEURE</th>
                                <th scope="col">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gestionnaires as $gestionnaire)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $gestionnaire->code_user }}</td>
                                <td>{{ $gestionnaire->nom_user }}</td>
                                <td>{{ $gestionnaire->prenom_user }}</td>
                                <td>
                                    @if($gestionnaire->status_user)
                                    <span class="badge bg-success">Active</span>
                                    @else
                                    <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $gestionnaire->created_at }}</td>
                                <td>
                                    <button class="btn btn-success"
                                        data-gestionnaire="{{ encodeId($gestionnaire->id) }}" id="updateGestionnaire">
                                        <i class="bi bi-pen"></i>
                                    </button>
                                    <button class="btn btn-secondary"
                                        data-gestionnaire="{{ encodeId($gestionnaire->id) }}" id="getInfosGestionnaire">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-danger" data-gestionnaire="{{ encodeId($gestionnaire->id) }}"
                                        id="deleteGestionnaire">
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

{{-- Modal pour voir plus d'info sur le gestionnaire --}}
<div class="modal fade" id="infosGestionnaireModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">INFORMATION DU GESTIONNAIRE</h4>
            </div>
            <div class="modal-body row g-3">
                <div class="col-md-6 text-center">
                    <span>Nom</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewNomGestionnaire"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Prenom</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewPrenomGestionnaire"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Email</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewEmailGestionnaire"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Telephone</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewTelephoneGestionnaire"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Adresse</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewAdresseGestionnaire"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Code du gestionnaire</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewCodeGestionnaire"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Date & Heure</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewDateCreated"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Status</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewStatusGestionnaire"></div>
                </div>
                <div class="col-md-12 text-center">
                    <span>Societe</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="societe"></div>
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

{{-- Modal pour modifier un gestionnaire --}}
<div class="modal fade" id="updateGestionnaireModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('gestionnaires.update') }}" method="post" id="gestionnaires-update">
                @csrf
                <div class="update-gestionnaire"></div>
                <div class="modal-header">
                    <h4 class="modal-title">MISE A JOUR DU GESTIONNAIRE</h4>
                </div>
                <div class="modal-body">
                    <label for="status_user" class="form-label mt-3">Status du
                        gestionnaire</label>
                    <select style="height: 55px;border-radius: 10px;" name="status_user" id="status_user"
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

{{-- Modal pour supprimer un gestionnaire --}}
<div class="modal fade" id="deleteGestionnaireModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">SUPPRESSION DU GESTIONNAIRE</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center;" id="viewMessageDeleteGestionnaire"></p>
            </div>
            <div class="modal-footer">
                <button type="button" style="border-radius: 10px;" class="btn btn-secondary btn-md"
                    data-bs-dismiss="modal"> <i class="bx bx-exit"></i> Non</button>
                <form action="{{ route('gestionnaires.delete') }}" method="post" id="gestionnaires-delete">
                    @csrf
                    <div id="formDeleteGestionnaire"></div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('packages.gestionnaires.gestionnaireModal')
@endsection
@push('scripts-gestionnaire')
<script>
    //Modifier un service grace a l'identifiant
    $(document).on('click', '#updateGestionnaire', function(){
        let id_gestionnaire = $(this).data('gestionnaire')

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'GET',
            url: '{{ route('gestionnaires.info') }}',
            dataType: 'JSON',
            data: {id_gestionnaire:id_gestionnaire},
            success: (response)=>{
                if(response.gestionnaire.status_user){
                    $("#status_user").html('<option value="1" selected>Active</option><option value="0">Inactive</option>');
                }else{
                    $("#status_user").html('<option value="1">Active</option><option value="0" selected>Inactive</option>');
                }
                $(".update-gestionnaire").html('<input type="hidden" name="id_gestionnaire" value="'+response.gestionnaire.id+'">');
                $("#updateGestionnaireModal").modal("show");
            },
            error: (error)=>{
                console.log('Response Erreur Update Gestionnaire')
                console.log(error)
            }
        })
    })

    //Obtenir plus d'information sur un service
    $(document).on('click', '#getInfosGestionnaire', function(){
        let id_gestionnaire = $(this).data('gestionnaire')

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'GET',
            url: '{{ route('gestionnaires.info') }}',
            dataType: 'JSON',
            data: {id_gestionnaire:id_gestionnaire},
            success: (response)=>{
                $("#viewNomGestionnaire").html(response.gestionnaire.nom_user);
                $("#viewPrenomGestionnaire").html(response.gestionnaire.prenom_user);
                $("#viewTelephoneGestionnaire").html(response.gestionnaire.telephone_user);
                $("#viewAdresseGestionnaire").html(response.gestionnaire.adresse_user);
                $("#viewEmailGestionnaire").html(response.gestionnaire.email_user);
                $("#viewCodeGestionnaire").html(response.gestionnaire.code_user);
                $("#viewDateCreated").html(response.gestionnaire.created_at);
                if(response.gestionnaire.status_user){
                    $("#viewStatusGestionnaire").html('<span class="badge bg-success">Active</span>');
                }else{
                    $("#viewStatusGestionnaire").html('<span class="badge bg-danger">Inactive</span>');
                }
                $("#societe").html(response.societe.nom_societe);
                $("#infosGestionnaireModal").modal('show');
            },
            error: (error)=>{
                console.log('Response Erreur Infos Gestionnaire')
                console.log(error)
            }
        })
    })

    //Supprimer un gestionnaire grace a l'identifiant
    $(document).on('click', '#deleteGestionnaire', function(){
        let id_gestionnaire = $(this).data('gestionnaire');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'GET',
            url: '{{ route('gestionnaires.info') }}',
            dataType: 'JSON',
            data: {id_gestionnaire:id_gestionnaire},
            success: (response)=>{
                $("#viewMessageDeleteGestionnaire").html('Etes-vous sur de vouloir supprimer le gestionnaire <strong>'+response.nom_user+' '+response.prenom_user+'</strong>?');
                $("#formDeleteGestionnaire").html('<input type="hidden" name="id_gestionnaire" value="'+response.id+'"> <button type="submit" style="border-radius: 10px;" class="btn btn-danger btn-md"><i class="bx bx-trash"></i> Oui</button>');
                $("#deleteGestionnaireModal").modal('show');
            },
            error: (error)=>{
                console.log('Response Erreur Delete Gestionnaire')
                console.log(error)
            }
        })
    })
</script>
@endpush