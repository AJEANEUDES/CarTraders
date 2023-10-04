@extends('layouts.app')
@section('title')
Acheter une voiture :: Mycartraders
@endsection
@section('content')
<!--=============== SHOP ===============-->
<section class="shop section container">
    <h2 class="breadcrumb__title">Acheter une voiture</h2>
    <h3 class="breadcrumb__subtitle">Accueil > <span>Acheter une voiture</span></h3>

    <div style="margin-bottom: 50px;">
        <form action="" class="newsletter__form">
            <input type="text" class="newsletter__input" id="search"
                placeholder="Rechercher par marque, modele, annee, kilometrage, etc...">
            {{-- <button class="button">Rechercher</button> --}}
        </form>
    </div>

    <div class="shop__container grid">
        <div class="sidebar">
            <h3 class="filter__title">Selectionnez Filtres</h3>

            <div class="filter__content">
                <h3 class="filter__subtitle">Prix</h3>
                <div class="filter">
                    <p>Min </p>
                    <input type="number" min="0" name="prix_min"
                        style="border: 1px solid #000;width: 100px;border-radius: 5px;" class="newsletter__input"
                        id="prix_min" />
                    <p>Max </p>
                    <input type="number" min="0" name="prix_max"
                        style="border: 1px solid #000;width: 100px;border-radius: 5px;" class="newsletter__input"
                        id="prix_max" />
                </div>
            </div>

            <div class="filter__content">
                <h3 class="filter__subtitle">Marque</h3>
                @foreach ($marques as $marque)
                <div class="filter" id="data_marque">
                    <input type="checkbox" name="marque_id" class="marque_id" value="{{ $marque->id_marque }}" />
                    <p>{{ $marque->nom_marque }}</p><span></span>
                </div>
                @endforeach
                {{-- <div class="">
                    <a href="javascript:void(0)" id="">Voir plus</a>
                </div> --}}
            </div>

            <div class="filter__content">
                <h3 class="filter__subtitle">Modele de voiture</h3>
                @foreach ($modeles as $modele)
                <div class="filter">
                    <input type="checkbox" name="modele_id" class="modele_id" value="{{ $modele->id_modele }}" />
                    <p>{{ $modele->nom_modele }}</p><span></span>
                </div>
                @endforeach
                {{-- <div class="">
                    <a href="javascript:void(0)" id="">Voir plus</a>
                </div> --}}
            </div>

            <div class="filter__content">
                <h3 class="filter__subtitle">Kilometrage</h3>
                <div class="filter">
                    <p>Min </p>
                    <input type="number" name="kilo_min" style="border: 1px solid #000;width: 100px;border-radius: 5px;"
                        class="newsletter__input" id="kilo_min" />
                    <p>Max </p>
                    <input type="number" name="kilo_max" style="border: 1px solid #000;width: 100px;border-radius: 5px;"
                        class="newsletter__input" id="kilo_max" />
                </div>
            </div>

            <div class="filter__content">
                <h3 class="filter__subtitle">Année</h3>
                <div class="filter">
                    <p>Min </p>
                    <input type="number" min="0" name="annee_min"
                        style="border: 1px solid #000;width: 100px;border-radius: 5px;" class="newsletter__input"
                        id="annee_min" />
                    <p>Max </p>
                    <input type="number" min="0" name="annee_max"
                        style="border: 1px solid #000;width: 100px;border-radius: 5px;" class="newsletter__input"
                        id="annee_max" />
                </div>
            </div>

            <div class="filter__content">
                <h3 class="filter__subtitle">Carburant</h3>
                <div class="filter">
                    <input type="checkbox" name="diesel" id="diesel" value="Diesel" />
                    <p>Diesel</p><span></span>
                </div>
                <div class="filter">
                    <input type="checkbox" name="essence" id="essence" value="Essence" />
                    <p>Essence</p><span></span>
                </div>
                <div class="filter">
                    <input type="checkbox" name="hybride" id="hybride" value="Hybride" />
                    <p>Hybride</p><span></span>
                </div>
                <div class="filter">
                    <input type="checkbox" name="electrique" id="electrique" value="Electrique" />
                    <p>Electrique</p><span></span>
                </div>
                <div class="filter">
                    <input type="checkbox" name="glp" id="glp" value="GLP" />
                    <p>GLP</p><span></span>
                </div>
                <div class="filter">
                    <input type="checkbox" name="gnv" id="gnv" value="GNV" />
                    <p>GNV</p><span></span>
                </div>
            </div>

            <div class="filter__content">
                <h3 class="filter__subtitle">Boite</h3>
                <div class="filter">
                    <input type="checkbox" name="boite_manuelle" id="boite_manuelle" value="Manuelle" />
                    <p>Manuelle</p><span></span>
                </div>
                <div class="filter">
                    <input type="checkbox" name="boite_automatique" id="boite_automatique" value="Automatique" />
                    <p>Automatique</p><span></span>
                </div>
                <div class="filter">
                    <input type="checkbox" name="boite_robotisee" id="boite_robotisee" value="Robotisee" />
                    <p>Robotisée</p><span></span>
                </div>
            </div>

            <div class="filter__content">
                <h3 class="filter__subtitle">Nombre de place</h3>
                <div class="filter">
                    <input type="checkbox" name="" id="" />
                    <p>2</p><span></span>
                </div>
                <div class="filter">
                    <input type="checkbox" name="" id="" />
                    <p>3</p><span></span>
                </div>
                <div class="filter">
                    <input type="checkbox" name="" id="" />
                    <p>4</p><span></span>
                </div>
                <div class="filter">
                    <input type="checkbox" name="" id="" />
                    <p>5</p><span></span>
                </div>
                <div class="filter">
                    <input type="checkbox" name="" id="" />
                    <p>6</p><span></span>
                </div>
                <div class="filter">
                    <input type="checkbox" name="" id="" />
                    <p>7</p><span></span>
                </div>
                <div class="filter">
                    <input type="checkbox" name="" id="" />
                    <p>9</p><span></span>
                </div>
            </div>
        </div>

        <div id="dataVoiturePaginate">
            @include('pages.data.dataVoiture')
        </div>
    </div>

    <div class="">
        {!! $voitures->links() !!}
        {{-- <i class="bx bx-chevron-left pagination__icon"></i>
        <a href="javascript:void(0)" class="current">1</a>
        <a href="javascript:void(0)">2</a>
        <a href="javascript:void(0)">3</a>
        <a href="javascript:void(0)">4</a>
        <i class="bx bx-chevron-right pagination__icon"></i> --}}
    </div>
</section>
@endsection
@push('script-acheter-voiture')
<script>
    //Pagination avec ajax
    $(document).ready(function(){
        $(document).on('click', '.pagination a', function(e){
            e.preventDefault()
            let page = $(this).attr('href').split('page=')[1];
            getAllVoitures(page);
            searchPriceVoiture(page);
            searchKilometrageVoiture(page);
            searchAnneeVoiture(page);
            searchCarburantDieselVoiture(page);
            searchCarburantEssenceVoiture(page);
            searchCarburantHybrideVoiture(page);
            searchCarburantElectriqueVoiture(page);
            searchCarburantGlpVoiture(page);
            searchCarburantGnvVoiture(page);
            searchBoiteManuelleVoiture(page);
            searchBoiteAutomatiqueVoiture(page);
            searchBoiteRobotiseeVoiture(page);
        })

        //Search global
        $('#search').on('keyup', function(){
            $value = $(this).val();
            getAllVoitures(1);
        })

        //Search prix min
        $('#prix_min').on('keyup', function(){
            $prix_min = $(this).val();
            searchPriceVoiture(1);
        })

        //Search prix max
        $('#prix_max').on('keyup', function(){
            $prix_max = $(this).val();
            searchPriceVoiture(1);
        })

        //Search marque
        $(".marque_id").on('click', function(){
            let marques = [];
            $(".marque_id").each(function(){
                if($(this).is(":checked")){
                    marques.push($(this).val())
                }
            })
            let marqueVoiture = marques.toString()
            
            $.ajax({
                type: 'GET',
                url: '{{ route('fetch.voiture') }}'+'?page='+1,
                data: {
                    'marques': marqueVoiture,
                },
                success: (voitures)=>{ 
                    $("#dataVoiturePaginate").html(voitures)
                },
                error: (error)=>{
                    console.log("Paginate Voiture Erreur")
                    console.log(error)
                }
            })
        })

        //Search modele
        $(".modele_id").on('click', function(){
            let modeles = [];
            $(".modele_id").each(function(){
                if($(this).is(":checked")){
                    modeles.push($(this).val())
                }
            })
            let modeleVoiture = modeles.toString()
            
            $.ajax({
                type: 'GET',
                url: '{{ route('fetch.voiture') }}'+'?page='+1,
                data: {
                    'modeles': modeleVoiture,
                },
                success: (voitures)=>{ 
                    $("#dataVoiturePaginate").html(voitures)
                },
                error: (error)=>{
                    console.log("Paginate Voiture Erreur")
                    console.log(error)
                }
            })
        })

        //Search kilo min
        $('#kilo_min').on('keyup', function(){
            $kilo_min = $(this).val();
            searchKilometrageVoiture(1);
        })

        //Search kilo min
        $('#kilo_max').on('keyup', function(){
            $kilo_max = $(this).val();
            searchKilometrageVoiture(1);
        })

        //Search annee min
        $('#annee_min').on('keyup', function(){
            $annee_min = $(this).val();
            searchAnneeVoiture(1);
        })

        //Search annee max
        $('#annee_max').on('keyup', function(){
            $annee_max = $(this).val();
            searchAnneeVoiture(1);
        })

        //Search carburant diesel
        $('#diesel').on('click', function(){
            $diesel = $(this).val();
            searchCarburantDieselVoiture(1);
        })

        //Search carburant essence
        $('#essence').on('click', function(){
            $essence = $(this).val();
            searchCarburantEssenceVoiture(1);
        })

        //Search carburant hybride
        $('#hybride').on('click', function(){
            $hybride = $(this).val();
            searchCarburantHybrideVoiture(1);
        })

        //Search carburant electrique
        $('#electrique').on('click', function(){
            $electrique = $(this).val();
            searchCarburantElectriqueVoiture(1);
        })

        //Search carburant glp
        $('#glp').on('click', function(){
            $glp = $(this).val();
            searchCarburantGlpVoiture(1);
        })

        //Search carburant gnv
        $('#gnv').on('click', function(){
            $gnv = $(this).val();
            searchCarburantGnvVoiture(1);
        })

        //Search boite vitesse manuelle
        $('#boite_manuelle').on('click', function(){
            $boite_manuelle = $(this).val();
            searchBoiteManuelleVoiture(1);
        })

        //Search boite vitesse automatique
        $('#boite_automatique').on('click', function(){
            $boite_automatique = $(this).val();
            searchBoiteAutomatiqueVoiture(1);
        })

        //Search boite vitesse robotisee
        $('#boite_robotisee').on('click', function(){
            $boite_robotisee = $(this).val();
            searchBoiteRobotiseeVoiture(1);
        })
    })

    function searchPriceVoiture(page){
        let prixMin = $('#prix_min').val();
        let prixMax = $('#prix_max').val();

        $.ajax({
            type: 'GET',
            url: '{{ route('fetch.voiture') }}'+'?page='+page,
            data: {
                'prix_min': prixMin,
                'prix_max': prixMax,
            },
            success: (voitures)=>{ 
                $("#dataVoiturePaginate").html(voitures)
            },
            error: (error)=>{
                console.log("Paginate Voiture Erreur")
                console.log(error)
            }
        })
    }

    function searchKilometrageVoiture(page){
        let kiloMin = $('#kilo_min').val();
        let kiloMax = $('#kilo_max').val();

        $.ajax({
            type: 'GET',
            url: '{{ route('fetch.voiture') }}'+'?page='+page,
            data: {
                'kilo_min': kiloMin,
                'kilo_max': kiloMax,
            },
            success: (voitures)=>{ 
                $("#dataVoiturePaginate").html(voitures)
            },
            error: (error)=>{
                console.log("Paginate Voiture Erreur")
                console.log(error)
            }
        })
    }

    function searchAnneeVoiture(page){
        let yearMin = $('#annee_min').val();
        let yearMax = $('#annee_max').val();

        $.ajax({
            type: 'GET',
            url: '{{ route('fetch.voiture') }}'+'?page='+page,
            data: {
                'annee_min': yearMin,
                'annee_max': yearMax,
            },
            success: (voitures)=>{ 
                $("#dataVoiturePaginate").html(voitures)
            },
            error: (error)=>{
                console.log("Paginate Voiture Erreur")
                console.log(error)
            }
        })
    }

    function searchCarburantDieselVoiture(page){
        let carburantDiesel = $('#diesel').val();
        $.ajax({
            type: 'GET',
            url: '{{ route('fetch.voiture') }}'+'?page='+page,
            data: {
                'carburant_diesel': carburantDiesel,
            },
            success: (voitures)=>{ 
                $("#dataVoiturePaginate").html(voitures)
            },
            error: (error)=>{
                console.log("Paginate Voiture Erreur")
                console.log(error)
            }
        })
    }

    function searchCarburantEssenceVoiture(page){
        let carburantEssence = $('#essence').val();
        $.ajax({
            type: 'GET',
            url: '{{ route('fetch.voiture') }}'+'?page='+page,
            data: {
                'carburant_essence': carburantEssence,
            },
            success: (voitures)=>{ 
                $("#dataVoiturePaginate").html(voitures)
            },
            error: (error)=>{
                console.log("Paginate Voiture Erreur")
                console.log(error)
            }
        })
    }

    function searchCarburantHybrideVoiture(page){
        let carburantHybride = $('#hybride').val();
        $.ajax({
            type: 'GET',
            url: '{{ route('fetch.voiture') }}'+'?page='+page,
            data: {
                'carburant_hybride': carburantHybride,
            },
            success: (voitures)=>{ 
                $("#dataVoiturePaginate").html(voitures)
            },
            error: (error)=>{
                console.log("Paginate Voiture Erreur")
                console.log(error)
            }
        })
    }

    function searchCarburantElectriqueVoiture(page){
        let carburantElectrique = $('#hybride').val();
        $.ajax({
            type: 'GET',
            url: '{{ route('fetch.voiture') }}'+'?page='+page,
            data: {
                'carburant_electrique': carburantElectrique,
            },
            success: (voitures)=>{ 
                $("#dataVoiturePaginate").html(voitures)
            },
            error: (error)=>{
                console.log("Paginate Voiture Erreur")
                console.log(error)
            }
        })
    }

    function searchCarburantGlpVoiture(page){
        let carburantGlp = $('#glp').val();
        $.ajax({
            type: 'GET',
            url: '{{ route('fetch.voiture') }}'+'?page='+page,
            data: {
                'carburant_glp': carburantGlp,
            },
            success: (voitures)=>{ 
                $("#dataVoiturePaginate").html(voitures)
            },
            error: (error)=>{
                console.log("Paginate Voiture Erreur")
                console.log(error)
            }
        })
    }

    function searchCarburantGnvVoiture(page){
        let carburantGnv = $('#gnv').val();
        $.ajax({
            type: 'GET',
            url: '{{ route('fetch.voiture') }}'+'?page='+page,
            data: {
                'carburant_gnv': carburantGnv,
            },
            success: (voitures)=>{ 
                $("#dataVoiturePaginate").html(voitures)
            },
            error: (error)=>{
                console.log("Paginate Voiture Erreur")
                console.log(error)
            }
        })
    }

    function searchBoiteManuelleVoiture(page){
        let boiteManuelle = $('#boite_manuelle').val();
        $.ajax({
            type: 'GET',
            url: '{{ route('fetch.voiture') }}'+'?page='+page,
            data: {
                'boite_manuelle': boiteManuelle,
            },
            success: (voitures)=>{ 
                $("#dataVoiturePaginate").html(voitures)
            },
            error: (error)=>{
                console.log("Paginate Voiture Erreur")
                console.log(error)
            }
        })
    }

    function searchBoiteAutomatiqueVoiture(page){
        let boiteAutomatique = $('#boite_automatique').val();
        $.ajax({
            type: 'GET',
            url: '{{ route('fetch.voiture') }}'+'?page='+page,
            data: {
                'boite_automatique': boiteAutomatique,
            },
            success: (voitures)=>{ 
                $("#dataVoiturePaginate").html(voitures)
            },
            error: (error)=>{
                console.log("Paginate Voiture Erreur")
                console.log(error)
            }
        })
    }

    function searchBoiteRobotiseeVoiture(page){
        let boiteRobotisee = $('#boite_robotisee').val();
        $.ajax({
            type: 'GET',
            url: '{{ route('fetch.voiture') }}'+'?page='+page,
            data: {
                'boite_robotisee': boiteRobotisee,
            },
            success: (voitures)=>{ 
                $("#dataVoiturePaginate").html(voitures)
            },
            error: (error)=>{
                console.log("Paginate Voiture Erreur")
                console.log(error)
            }
        })
    }

    function getAllVoitures(page){
        let searchVoiture = $('#search').val();
        $.ajax({
            type: 'GET',
            url: '{{ route('fetch.voiture') }}'+'?page='+page,
            data: {
                'search_voiture':searchVoiture,
            },
            success: (voitures)=>{ 
                $("#dataVoiturePaginate").html(voitures)
            },
            error: (error)=>{
                console.log("Paginate Voiture Erreur")
                console.log(error)
            }
        })
    }
</script>
@endpush