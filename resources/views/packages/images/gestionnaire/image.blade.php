@extends('themes.main')
@section('title')
Images :: Mycartraders
@endsection
@section('main')
<div class="pagetitle">
    <h1 style="font-size: 25px;">Images</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Accueil</a></li>
            <li class="breadcrumb-item active">Images</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body" style="overflow: auto;">
                    <h5 class="card-title" style="text-align: center;font-size: 25px;">Enregistrement des images de
                        voitures</h5>
                    <form action="{{ route('images-voitures.store.gestion') }}" method="post" enctype="multipart/form-data"
                        id="images-voitures-store-gestion">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-12 mb-2">
                                <div class="imgPreview"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="voiture" class="form-label">Voiture</label>
                                <select name="voiture" class="form-control form-control-lg" id="voiture">
                                    <option selected disabled>--Selectionnez la voiture--</option>
                                    @foreach ($voitures as $voiture)
                                    <option value="{{ $voiture->id_voiture }}">
                                        {{ $voiture->nom_marque }} {{ $voiture->nom_modele }} - (Parc: {{
                                        $voiture->nom_parking }}, Societe: {{ $voiture->nom_societe }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="images" class="form-label">Image</label>
                                <input type="file" name="imageFile[]" class="form-control form-control-lg" id="images"
                                    multiple>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-success btn-lg mt-3" name="submit"><i
                                        class="bx bx-save"></i> Enregistrer</button>
                            </div>
                        </div>
                    </form>
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
                    <h5 class="card-title" style="text-align: center;font-size: 25px;">Listes des images de voitures
                    </h5>
                    <div class="row">
                        @forelse ($images as $image)
                        <div class="col-md-2">
                            <div class="text-center" style="font-weight: 600;">{{ $image->nom_marque }} {{
                                $image->nom_modele }}</div>
                            <img style="margin-right: 10px;" class="mb-2" height="175" width="175"
                                src="{{ $image->path_image }}" alt="" />
                            <div class="row">
                                <div class="col-md-4">
                                    <button class="btn btn-success mb-3" data-image="{{ encodeId($image->id_image) }}"
                                        id="updateImage"><i class="bi bi-pen"></i></button>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-secondary" mb-3 data-image="{{ encodeId($image->id_image) }}"
                                        id="getInfosImage">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-danger mb-3" data-image="{{ encodeId($image->id_image) }}"
                                        id="deleteImage">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-md-12 text-center">Ooops, Aucune image pour l'instant</div>
                        @endforelse
                    </div>
                    {{-- <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">IMAGE</th>
                                <th scope="col">VOITURE</th>
                                <th scope="col">DATE & HEURE</th>
                                <th scope="col">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($images as $image)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>
                                    <img height="50" width="50" src="{{ $image->path_image }}" alt="" />
                                </td>
                                <td>{{ $image->nom_marque }} {{ $image->nom_modele }}</td>
                                <td>{{ $image->created_at }}</td>
                                <td>
                                    <button class="btn btn-success" data-image="{{ encodeId($image->id_image) }}"
                                        id="updateMarque">
                                        <i class="bi bi-pen"></i>
                                    </button>
                                    <button class="btn btn-secondary" data-image="{{ encodeId($image->id_image) }}"
                                        id="getInfosMarque">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-danger" data-image="{{ encodeId($image->id_image) }}"
                                        id="deleteMarque">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table> --}}
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Modal pour voir plus d'info sur l'image --}}
<div class="modal fade" id="infosImageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">INFORMATION D'UNE IMAGE</h4>
            </div>
            <div class="modal-body row g-3">
                <div class="col-md-6 text-center">
                    <span>Voiture</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewVoiture"></div>
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
                    <span>Prix voiture</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewPrixVoiture"></div>
                </div>
                <div class="col-md-6 text-center">
                    <span>Date & Heure</span>
                    <div style="font-weight: 600;text-transform: uppercase;" id="viewDateCreated"></div>
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

{{-- Modal pour modifier une image --}}
<div class="modal fade" id="updateImageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('images-voitures.update.gestion') }}" method="post" enctype="multipart/form-data" id="images-voitures-update-gestion">
                @csrf
                <div class="update-image"></div>
                <div class="modal-header">
                    <h4 class="modal-title">MISE A JOUR D'UNE IMAGE</h4>
                </div>
                <div class="modal-body">
                    <label for="image_voiture" class="form-label">Image</label>
                    <input type="file" style="height: 55px;border-radius: 10px;" name="image_voiture" id="image_voiture"
                        value="" class="form-control form-control-lg" />
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

{{-- Modal pour supprimer une image de voiture --}}
<div class="modal fade" id="deleteImageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">SUPPRESSION D'UNE IMAGE</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center;" id="viewMessageDeleteImage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" style="border-radius: 10px;" class="btn btn-secondary btn-md"
                    data-bs-dismiss="modal"> <i class="bx bx-exit"></i> Non</button>
                <form action="{{ route('images-voitures.delete.gestion') }}" method="post" id="images-voitures-delete-gestion">
                    @csrf
                    <div id="formDeleteImage"></div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts-images-voitures')
<script>
    //Mettre a jour une voiture grace a l'identifiant
    $(document).on('click', '#updateImage', function(){
        let id_image = $(this).data('image');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'GET',
            url: '{{ route('images-voitures.info.gestion') }}',
            dataType: 'JSON',
            data: {id_image:id_image},
            success: (response)=>{
                $(".update-image").html('<input type="hidden" name="id_image" value="'+response.id_image+'">');
                $("#updateImageModal").modal("show");
            },
            error: (error)=>{
                console.log('Response Erreur Update Image')
                console.log(error)
            }
        })
    })

    //Pour obtenir les informations d'une marque grace a l'identifiant
    $(document).on('click', '#getInfosImage', function(){
        let id_image = $(this).data('image');
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'GET',
            url: '{{ route('images-voitures.info.gestion') }}',
            dataType: 'JSON',
            data: {id_image:id_image},
            success: (response)=>{
                $("#viewVoiture").html(response.nom_marque+" "+response.nom_modele);
                $("#viewSociete").html(response.nom_societe);
                $("#viewParking").html(response.nom_parking);
                $("#viewPrixVoiture").html(response.prix_voiture+" FCFA");
                $("#viewDateCreated").html(response.created_at);
                if(response.status_voiture){
                    $("#viewStatusMarque").html('<span class="badge bg-success">Active</span>');
                }else{
                    $("#viewStatusMarque").html('<span class="badge bg-danger">Inactive</span>');
                }
                $("#operateur").html(response.nom_user+" "+response.prenom_user);
                $("#infosImageModal").modal('show');
            },
            error: (error)=>{
                console.log("Response error")
                console.log(error)
            }
            
        })
    })

    //Supprimer une image de voiture grace a l'identifiant
    $(document).on('click', '#deleteImage', function(){
        let id_image = $(this).data('image');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: 'GET',
            url: '{{ route('images-voitures.info.gestion') }}',
            dataType: 'JSON',
            data: {id_image:id_image},
            success: (response)=>{
                $("#viewMessageDeleteImage").html('Etes-vous sur de vouloir supprimer l\'image de cette voiture <strong>'+response.nom_marque+' '+response.nom_modele+'</strong>?');
                $("#formDeleteImage").html('<input type="hidden" name="id_image" value="'+response.id_image+'"> <button type="submit" style="border-radius: 10px;" class="btn btn-danger btn-md"><i class="bx bx-trash"></i> Oui</button>');
                $("#deleteImageModal").modal('show');
            },
            error: (error)=>{
                console.log('Response Erreur Delete Image')
                console.log(error)
            }
        })
    })

    //Nouveau code pour upload image voiture
    $(function(){
        //Multiple upload images preview with javascript
        let multiImgPreview = function(input, imgPreviewPlaceholder){
            if(input.files){
                let filesAmount = input.files.length;
                        
                for(let i = 0; i < filesAmount; i++){
                    let reader = new FileReader();
                    reader.onload = function(e){
                        $($.parseHTML('<img style="margin-right: 10px;" class="mb-3" height="175" width="175">')).attr('src', e.target.result).appendTo(imgPreviewPlaceholder);
                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }
        }

        $("#images").on('change', function(){
            multiImgPreview(this, 'div.imgPreview');
        })
    })
</script>
@endpush