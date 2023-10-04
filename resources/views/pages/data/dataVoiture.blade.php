<div class="shop__items grid">
    @forelse ($voitures as $voiture)
    <a href="{{ route('details.voiture.get', [$voiture->slug_marque, $voiture->slug_modele, encodeId($voiture->id_voiture)]) }}"
        class="" data-marque="{{ $voiture->slug_marque }}" data-modele="{{ $voiture->slug_modele }}"
        data-details="{{ encodeId($voiture->id_voiture) }}">
        <div class="shop__content">
            @if ($voiture->status_reserver)
            <div class="shop__tag">Reservée</div>
            @endif
            <img src="{{ asset($voiture->image_voiture) }}" alt="{{ $voiture->nom_marque }} {{ $voiture->nom_modele }}"
                class="shop__img">
            <h3 class="shop__title" style="color: rgb(24, 22, 22);">{{ $voiture->nom_marque }} {{ $voiture->nom_modele }}</h3>
            <span class="shop__subtitle">{{ $voiture->annee_voiture }} - {{ $voiture->kilometrage_voiture }} Km - {{
                $voiture->carburant_voiture }} - {{ $voiture->boite_vitesse_voiture }}</span>
            <div class="shop__prices">
                <span class="shop__price">{{ $voiture->prix_voiture }} FCFA</span>
            </div>
        </div>
    </a>
    @empty
    <div class="shop__data__empty">
        <i class="bx bx-car shop__data__empty__icon"></i>
        <span class="shop__data__empty__oops">Ooops!</span>
        <p class="shop__data__empty__message">Aucun resultat pour cette recherche</p>
    </div>
    @endforelse
</div>