@extends('themes.main')
@section('title')
Societes :: Mycartraders
@endsection
@section('main')
<div class="pagetitle">
    <h1 style="font-size: 25px;">
        Societes
        <i class="bx bx-plus-circle" data-bs-toggle="modal" data-bs-target="#addSocieteModal"
            style="position: relative;top: 10px;font-size: 40px;color: #2DAF07;cursor: pointer;"></i>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Accueil</a></li>
            <li class="breadcrumb-item active">Societes</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body" style="overflow: auto;">
                    <h5 class="card-title" style="text-align: center;font-size: 25px;">Listes des societes
                    </h5>
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">CODE SOCIETE</th>
                                <th scope="col">NOM</th>
                                <th scope="col">ADRESSE</th>
                                <th scope="col">TELEPHONE 1</th>
                                <th scope="col">STATUS</th>
                                <th scope="col">DATE & HEURE</th>
                                <th scope="col">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($societes as $societe)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $societe->code_societe }}</td>
                                <td>
                                    <strong>{{ Str::upper($societe->nom_societe) }}</strong>
                                </td>
                                <td>{{ $societe->adresse_societe }}</td>
                                <td>{{ $societe->telephone_societe1 }}</td>
                                <td>
                                    @if($societe->status_societe)
                                    <span class="badge bg-success">Active</span>
                                    @else
                                    <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $societe->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>
                                    <button class="btn btn-success" data-societe="{{ encodeId($societe->id_societe) }}" id="updateSociete">
                                        <i class="bi bi-pen"></i>
                                    </button>
                                    <button class="btn btn-secondary" data-societe="{{ encodeId($societe->id_societe) }}" id="getInfosSociete">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-danger" data-societe="{{ encodeId($societe->id_societe) }}" id="deleteSociete">
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

{{-- Modal pour modifier une societe --}}
<div class="modal fade" id="updateSocieteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('societes.update') }}" method="post" id="societes-update">
                @csrf
                <div class="update-societe"></div>
                <div class="modal-header">
                    <h4 class="modal-title">MISE A JOUR DE LA SOCIETE</h4>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-12">
                        <label for="nom_societe" class="form-label">Nom de la
                            societe</label>
                        <input type="text" style="height: 55px;border-radius: 10px;" name="nom_societe" id="nom_societe"
                            class="form-control form-control-lg" value="" />
                    </div>
                    <div class="col-md-12">
                        <label for="adresse_societe" class="form-label">Adresse de la
                            societe</label>
                        <input type="text" style="height: 55px;border-radius: 10px;" name="adresse_societe"
                            id="adresse_societe" class="form-control form-control-lg"
                            value="" />
                    </div>
                    <div class="col-md-6">
                        <label for="telephone_societe1" class="form-label">Telephone
                            1</label>
                        <input type="number" min="0" style="height: 55px;border-radius: 10px;"
                            class="form-control form-control-lg" name="telephone_societe1" id="telephone_societe1"
                            value="">
                    </div>
                    <div class="col-md-6">
                        <label for="telephone_societe2" class="form-label">Telephone
                            2</label>
                        <input type="number" min="0" style="height: 55px;border-radius: 10px;"
                            class="form-control form-control-lg" name="telephone_societe2" id="telephone_societe2"
                            value="">
                    </div>
                    <div class="col-md-6">
                        <label for="status_societe" class="form-label">Status de la
                            societe</label>
                        <select style="height: 55px;border-radius: 10px;" name="status_societe" id="status_societe"
                            class="form-control form-control-lg">
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="parking_id" class="form-label">Parc de la societe</label>
                        <select type="text" style="height: 55px;border-radius: 10px;" name="parking_id" id="parking_id"
                            class="form-control form-control-lg">
                            @foreach ($parkings as $parking)
                                <option value="{{ $parking->id_parking }}">{{ $parking->nom_parking }}</option>
                            @endforeach
                        </select>
                    </div>
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

{{-- Modal pour voir plus d'info sur une societe --}}
<div class="modal fade" id="infosSocieteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">INFORMATION D'UNE SOCIETE</h4>
            </div>
            <div class="modal-body row g-3">
                <div class="col-md-6 text-center">
                    <span>Code de la societe</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewCodeSociete"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Nom de la societe</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewNomSociete"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Parc de la voiture</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewParking"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Adresse de la societe</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewAdresseSociete"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Telephone1 de la societe</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewNum1"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Telephone2 de la societe</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewNum2"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Status de la societe</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewStatusSociete"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Date de creation</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewDateCreated"></div>
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

{{-- Modal pour supprimer une societe --}}
<div class="modal fade" id="deleteSocieteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">SUPPRESSION DE LA SOCIETE</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center;" id="viewMessageDeleteSociete"></p>
            </div>
            <div class="modal-footer">
                <button type="button" style="border-radius: 10px;" class="btn btn-secondary btn-md"
                    data-bs-dismiss="modal"> <i class="bx bx-exit"></i> Non</button>
                <form action="{{ route('societes.delete') }}" method="post" id="societes-delete">
                    @csrf
                    <div id="formDeleteSociete"></div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('packages.societes.societeModal')
@endsection
@push('script-societes')
<script>
    //Modifier une societe
    $(document).on('click', '#updateSociete', function(){
        let id_societe = $(this).data('societe')
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'GET',
            url: '{{ route('societes.info') }}',
            dataType: 'JSON',
            data: {id_societe:id_societe},
            success: (response)=>{
                $("#updateSocieteModal").find('input[name="nom_societe"]').val(response.nom_societe);
                $("#updateSocieteModal").find('input[name="adresse_societe"]').val(response.adresse_societe);
                $("#updateSocieteModal").find('input[name="telephone_societe1"]').val(response.telephone_societe1);
                $("#updateSocieteModal").find('input[name="telephone_societe2"]').val(response.telephone_societe2);
                $("#updateSocieteModal").find('select[name="parking_id"]').val(response.id_parking);
                if(response.status_societe){
                    $("#status_societe").html('<option value="1" selected>Active</option><option value="0">Inactive</option>');
                }else{
                    $("#status_societe").html('<option value="1">Active</option><option value="0" selected>Inactive</option>');
                }
                $(".update-societe").html('<input type="hidden" name="id_societe" value="'+response.id_societe+'">');
                $("#updateSocieteModal").modal("show");
            },
            error: (error)=>{
                console.log('Response Erreur Update Societe')
                console.log(error)
            }
        })
    })

    //Obtenir plus d'information sur une societe
    $(document).on('click', '#getInfosSociete', function(){
        let id_societe = $(this).data('societe')

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'GET',
            url: '{{ route('societes.info') }}',
            dataType: 'JSON',
            data: {id_societe:id_societe},
            success: (response)=>{
                $("#viewNomSociete").html(response.nom_societe);
                $("#viewParking").html(response.nom_parking);
                $("#viewCodeSociete").html(response.code_societe);
                $("#viewAdresseSociete").html(response.code_societe);
                $("#viewNum1").html(response.telephone_societe1);
                if(response.telephone_societe2 != null){
                    $("#viewNum2").html(response.telephone_societe2);
                }else{
                    $("#viewNum2").html('<span>Indefini</span>');
                }
                $("#viewDateCreated").html(response.created_at);
                if(response.status_societe){
                    $("#viewStatusSociete").html('<span class="badge bg-success">Active</span>');
                }else{
                    $("#viewStatusSociete").html('<span class="badge bg-danger">Inactive</span>');
                }
                $("#operateur").html(response.nom_user+" "+response.prenom_user);
                $("#infosSocieteModal").modal('show');
            },
            error: (error)=>{
                console.log('Response Erreur Infos Societe')
                console.log(error)
            }
        })
    })

    //Supprimer une societe grace a l'identifiant
    $(document).on('click', '#deleteSociete', function(){
        let id_societe = $(this).data('societe');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'GET',
            url: '{{ route('societes.info') }}',
            dataType: 'JSON',
            data: {id_societe:id_societe},
            success: (response)=>{
                $("#viewMessageDeleteSociete").html('Etes-vous sur de vouloir supprimer la societe <strong>'+response.nom_societe+'</strong>?');
                $("#formDeleteSociete").html('<input type="hidden" name="id_societe" value="'+response.id_societe+'"> <button type="submit" style="border-radius: 10px;" class="btn btn-danger btn-md"><i class="bx bx-trash"></i> Oui</button>');
                $("#deleteSocieteModal").modal('show');
            },
            error: (error)=>{
                console.log('Response Erreur Delete Societe')
                console.log(error)
            }
        })
    })
</script>
@endpush