@extends('themes.main')
@section('title')
Administrateurs :: Mycartraders
@endsection
@section('main')
<div class="pagetitle">
    <h1 style="font-size: 25px;">
        Administrateurs
        <i class="bx bx-plus-circle" data-bs-toggle="modal" data-bs-target="#addAdminModal"
            style="position: relative;top: 10px;font-size: 40px;color: #2DAF07;cursor: pointer;"></i>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Accueil</a></li>
            <li class="breadcrumb-item active">Administrateurs</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body" style="overflow: auto;">
                    <h5 class="card-title" style="text-align: center;font-size: 25px;">Listes des administrateurs
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
                            @foreach ($admins as $admin)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $admin->code_user }}</td>
                                <td>{{ $admin->nom_user }}</td>
                                <td>{{ $admin->prenom_user }}</td>
                                <td>
                                    @if($admin->status_user)
                                    <span class="badge bg-success">Active</span>
                                    @else
                                    <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $admin->created_at }}</td>
                                <td>
                                    <button class="btn btn-success" data-admin="{{ encodeId($admin->id) }}"
                                        id="updateAdmin">
                                        <i class="bi bi-pen"></i>
                                    </button>
                                    <button class="btn btn-secondary"
                                        data-admin="{{ encodeId($admin->id) }}" id="getInfosAdmin">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-danger" data-admin="{{ encodeId($admin->id) }}"
                                        id="deleteAdmin">
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

{{-- Modal pour voir plus d'info sur l'admin --}}
<div class="modal fade" id="infosAdminModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">INFORMATION DE L'ADMIN</h4>
            </div>
            <div class="modal-body row g-3">
                <div class="col-md-6 text-center">
                    <span>Nom</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewNomAdmin"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Prenom</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewPrenomAdmin"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Email</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewEmailAdmin"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Telephone</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewTelephoneAdmin"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Adresse</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewAdresseAdmin"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Code de l'admin</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewCodeAdmin"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Date & Heure</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewDateCreated"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Status</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewStatusAdmin"></div>
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

{{-- Modal pour modifier un admin --}}
<div class="modal fade" id="updateAdminModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admins.update') }}" method="post" id="admins-update">
                @csrf
                <div class="update-admin"></div>
                <div class="modal-header">
                    <h4 class="modal-title">MISE A JOUR DE L'ADMIN</h4>
                </div>
                <div class="modal-body">
                    <label for="status_user" class="form-label mt-3">Status de l'admin</label>
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

{{-- Modal pour supprimer un admin --}}
<div class="modal fade" id="deleteAdminModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">SUPPRESSION DE L'ADMIN</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center;" id="viewMessageDeleteAdmin"></p>
            </div>
            <div class="modal-footer">
                <button type="button" style="border-radius: 10px;" class="btn btn-secondary btn-md"
                    data-bs-dismiss="modal"> <i class="bx bx-exit"></i> Non</button>
                <form action="{{ route('admins.delete') }}" method="post" id="admins-delete">
                    @csrf
                    <div id="formDeleteAdmin"></div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('packages.admins.adminModal')
@endsection
@push('scripts-admins')
<script>
    //Modifier un admin grace a l'identifiant
    $(document).on('click', '#updateAdmin', function(){
        let id_admin = $(this).data('admin')

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'GET',
            url: '{{ route('admins.info') }}',
            dataType: 'JSON',
            data: {id_admin:id_admin},
            success: (response)=>{
                if(response.status_user){
                    $("#status_user").html('<option value="1" selected>Active</option><option value="0">Inactive</option>');
                }else{
                    $("#status_user").html('<option value="1">Active</option><option value="0" selected>Inactive</option>');
                }
                $(".update-admin").html('<input type="hidden" name="id_admin" value="'+response.id+'">');
                $("#updateAdminModal").modal("show");
            },
            error: (error)=>{
                console.log('Response Erreur Update Admin')
                console.log(error)
            }
        })
    })

    //Obtenir plus d'information sur un admin
    $(document).on('click', '#getInfosAdmin', function(){
        let id_admin = $(this).data('admin')

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'GET',
            url: '{{ route('admins.info') }}',
            dataType: 'JSON',
            data: {id_admin:id_admin},
            success: (response)=>{
                $("#viewNomAdmin").html(response.nom_user);
                $("#viewPrenomAdmin").html(response.prenom_user);
                $("#viewTelephoneAdmin").html(response.telephone_user);
                $("#viewAdresseAdmin").html(response.adresse_user);
                $("#viewEmailAdmin").html(response.email_user);
                $("#viewCodeAdmin").html(response.code_user);
                $("#viewDateCreated").html(response.created_at);
                if(response.status_user){
                    $("#viewStatusAdmin").html('<span class="badge bg-success">Active</span>');
                }else{
                    $("#viewStatusAdmin").html('<span class="badge bg-danger">Inactive</span>');
                }
                $("#infosAdminModal").modal('show');
            },
            error: (error)=>{
                console.log('Response Erreur Infos Admin')
                console.log(error)
            }
        })
    })

    //Supprimer un admin grace a l'identifiant
    $(document).on('click', '#deleteAdmin', function(){
        let id_admin = $(this).data('admin');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'GET',
            url: '{{ route('admins.info') }}',
            dataType: 'JSON',
            data: {id_admin:id_admin},
            success: (response)=>{
                $("#viewMessageDeleteAdmin").html('Etes-vous sur de vouloir supprimer l\'aadministrateur <strong>'+response.nom_user+' '+response.prenom_user+'</strong>?');
                $("#formDeleteAdmin").html('<input type="hidden" name="id_admin" value="'+response.id+'"> <button type="submit" style="border-radius: 10px;" class="btn btn-danger btn-md"><i class="bx bx-trash"></i> Oui</button>');
                $("#deleteAdminModal").modal('show');
            },
            error: (error)=>{
                console.log('Response Erreur Delete Admin')
                console.log(error)
            }
        })
    })
</script>
@endpush