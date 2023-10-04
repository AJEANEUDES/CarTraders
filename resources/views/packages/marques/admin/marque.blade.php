@extends('themes.main')
@section('title')
Marques :: Mycartraders
@endsection
@section('main')
<div class="pagetitle">
    <h1 style="font-size: 25px;">
        Marques
        <i class="bx bx-plus-circle" data-bs-toggle="modal" data-bs-target="#addMarqueModal"
            style="position: relative;top: 10px;font-size: 40px;color: #2DAF07;cursor: pointer;"></i>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Accueil</a></li>
            <li class="breadcrumb-item active">Marques</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body" style="overflow: auto;">
                    <h5 class="card-title" style="text-align: center;font-size: 25px;">Listes des marques de voiture
                    </h5>
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">CODE MARQUE</th>
                                <th scope="col">NOM</th>
                                <th scope="col">STATUS</th>
                                <th scope="col">DATE & HEURE</th>
                                <th scope="col">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($marques as $marque)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $marque->code_marque }}</td>
                                <td>{{ $marque->nom_marque }}</td>
                                <td>
                                    @if($marque->status_marque)
                                    <span class="badge bg-success">Active</span>
                                    @else
                                    <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $marque->created_at }}</td>
                                <td>
                                    <button class="btn btn-success" data-marque="{{ encodeId($marque->id_marque) }}"
                                        id="updateMarque">
                                        <i class="bi bi-pen"></i>
                                    </button>
                                    <button class="btn btn-secondary" data-marque="{{ encodeId($marque->id_marque) }}"
                                        id="getInfosMarque">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-danger" data-marque="{{ encodeId($marque->id_marque) }}"
                                        id="deleteMarque">
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

{{-- Modal pour voir plus d'info sur la marque --}}
<div class="modal fade" id="infosMarqueModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">INFORMATION D'UNE MARQUE</h4>
            </div>
            <div class="modal-body row g-3">
                <div class="col-md-6 text-center">
                    <span>Nom de la marque</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewNomMarque"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Code de la marque</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewCodeMarque"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Date & Heure</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewDateCreatedMarque"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Status</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewStatusMarque"></div>
                </div>
                <div class="col-md-12 text-center">
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

{{-- Modal pour modifier la marque --}}
<div class="modal fade" id="updateMarqueModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('marques-voitures.update') }}" method="post" id="marques-voitures-update">
                @csrf
                <div class="update-marque"></div>
                <div class="modal-header">
                    <h4 class="modal-title">MISE A JOUR D'UNE MARQUE</h4>
                </div>
                <div class="modal-body">
                    <label for="nom_marque" class="form-label">Nom de la marque</label>
                    <input type="text" style="height: 55px;border-radius: 10px;" name="nom_marque" id="nom_marque"
                        value="" class="form-control form-control-lg" />
                    <label for="status_marque" class="form-label mt-3">Status de la marque</label>
                    <select style="height: 55px;border-radius: 10px;" name="status_marque" id="status_marque"
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

{{-- Modal pour supprimer marque --}}
<div class="modal fade" id="deleteMarqueModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">SUPPRESSION D'UNE MARQUE</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center;" id="viewMessageDeleteMarque"></p>
            </div>
            <div class="modal-footer">
                <button type="button" style="border-radius: 10px;" class="btn btn-secondary btn-md"
                    data-bs-dismiss="modal"> <i class="bx bx-exit"></i> Non</button>
                <form action="{{ route('marques-voitures.delete') }}" method="post" id="marques-voitures-delete">
                    @csrf
                    <div id="formDeleteMarque"></div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('packages.marques.admin.marqueModal')
@endsection
@push('script-find-marque-voiture')
<script>
    //Mettre a jour une voiture grace a l'identifiant
    $(document).on('click', '#updateMarque', function(){
        let id_marque = $(this).data('marque');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'GET',
            url: '{{ route('marques.info') }}',
            dataType: 'JSON',
            data: {id_marque:id_marque},
            success: (response)=>{
                $("#updateMarqueModal").find('input[name="nom_marque"]').val(response.nom_marque);
                if(response.status_marque){
                    $("#status_marque").html('<option value="1" selected>Active</option><option value="0">Inactive</option>');
                }else{
                    $("#status_marque").html('<option value="1">Active</option><option value="0" selected>Inactive</option>');
                }
                $(".update-marque").html('<input type="hidden" name="id_marque" value="'+response.id_marque+'">');
                $("#updateMarqueModal").modal("show");
            },
            error: (error)=>{
                console.log('Response Erreur Update Marque')
                console.log(error)
            }
        })
    })

    //Pour obtenir les informations d'une marque grace a l'identifiant
    $(document).on('click', '#getInfosMarque', function(){
        let id_marque = $(this).data('marque');
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'GET',
            url: '{{ route('marques.info') }}',
            dataType: 'JSON',
            data: {id_marque:id_marque},
            success: (response)=>{
                let created_at = new Date().toLocaleDateString("fr");
                $("#viewNomMarque").html(response.nom_marque);
                $("#viewCodeMarque").html(response.code_marque);
                $("#viewDateCreatedMarque").html(new Date(response.created_at).toLocaleDateString());
                if(response.status_marque){
                    $("#viewStatusMarque").html('<span class="badge bg-success">Active</span>');
                }else{
                    $("#viewStatusMarque").html('<span class="badge bg-danger">Inactive</span>');
                }
                $("#operateur").html(response.nom_user+" "+response.prenom_user);
                $("#infosMarqueModal").modal('show');
            },
            error: (error)=>{
                console.log("Response error")
                console.log(error)
            }
            
        })
    })

    //Supprimer une voiture grace a l'identifiant
    $(document).on('click', '#deleteMarque', function(){
        let id_marque = $(this).data('marque');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'GET',
            url: '{{ route('marques.info') }}',
            dataType: 'JSON',
            data: {id_marque:id_marque},
            success: (response)=>{
                $("#viewMessageDeleteMarque").html('Etes-vous sur de vouloir supprimer la marque <strong>'+response.nom_marque+'</strong>?');
                $("#formDeleteMarque").html('<input type="hidden" name="id_marque" value="'+response.id_marque+'"> <button type="submit" style="border-radius: 10px;" class="btn btn-danger btn-md"><i class="bx bx-trash"></i> Oui</button>');
                $("#deleteMarqueModal").modal('show');
            },
            error: (error)=>{
                console.log('Response Erreur Delete Marque')
                console.log(error)
            }
        })
    })
</script>
@endpush