@extends('layouts.app')
@section('title')
Accueil :: Mycartraders
@endsection
@section('content')

<!--=============== HOME ===============-->
<section class="home container">
    <div class="swiper home-swiper">
        <div class="swiper-wrapper">
            <!-- HOME SWIPER 1 -->
            <section class="swiper-slide">
                <div class="home__content grid">
                    <div class="home__group">
                        <img src="{{ asset('assets/img/car-slide1.png') }}" alt="" class="home__img">
                        <div class="home__indicator"></div>
                        <div class="home__details-img">
                            <h4 class="home__details-title">Renault</h4>
                            <span class="home__details-subtitle">Clio</span>
                        </div>
                    </div>

                    <div class="home__data">
                        {{-- <h3 class="home__subtitle">#1 ARTICLE TENDANCE</h3> --}}
                        <h1 class="home__title">ACHETEZ <br> UNE VOITURE D'OCCASION <br> AU MEILLEUR PRIX.</h1>
                        {{-- <p class="home__description">Achetez une voiture d’occasion
                            au meilleur prix</p> --}}
                        <div class="home__buttons">
                            <a href="{{ route('acheter.voiture.get') }}" class="button">Reserver Maintenant</a>
                            {{-- <a href="javascript:void(0)" class="button--link button--flex">
                                Voir Details <i class="bx bx-right-arrow-alt button__icon"></i>
                            </a> --}}
                        </div>
                    </div>
                </div>
            </section>

            <!-- HOME SWIPER 2 -->
            <section class="swiper-slide">
                <div class="home__content grid">
                    <div class="home__group">
                        <img src="{{ asset('assets/img/car-slide5.png') }}" alt="" class="home__img home__img__slide">
                        <div class="home__indicator"></div>
                        <div class="home__details-img">
                            <h4 class="home__details-title">Mercedez</h4>
                            <span class="home__details-subtitle">Benz</span>
                        </div>
                    </div>

                    <div class="home__data">
                        {{-- <h3 class="home__subtitle">#2 ARTICLE TENDANCE</h3> --}}
                        <h1 class="home__title">ACHETEZ <br> UNE VOITURE D'OCCASION <br> EN TOUTE CONFIANCE.</h1>
                        {{-- <p class="home__description">Conveniently e-enable magnetic quality vectors
                            rather than distributed products. Phosfluorescently </p> --}}

                        <div class="home__buttons">
                            <a href="{{ route('acheter.voiture.get') }}" class="button">Reserver Maintenant</a>
                            {{-- <a href="javascript:void(0)" class="button--link button--flex">
                                Voir Details <i class="bx bx-right-arrow-alt button__icon"></i>
                            </a> --}}
                        </div>
                    </div>
                </div>
            </section>

            <!-- HOME SWIPER 3 -->
            <section class="swiper-slide">
                <div class="home__content grid">
                    <div class="home__group">
                        <img src="{{ asset('assets/img/car-slide6.png') }}" alt="" class="home__img">
                        <div class="home__indicator"></div>
                        <div class="home__details-img">
                            <h4 class="home__details-title">Toyota</h4>
                            <span class="home__details-subtitle">Tacoma</span>
                        </div>
                    </div>

                    <div class="home__data">
                        {{-- <h3 class="home__subtitle">#3 ARTICLE TENDANCE</h3> --}}
                        <h1 class="home__title">ACHETEZ <br> UNE VOITURE D'OCCASION <br> LIVREE CHEZ VOUS.</h1>
                        {{-- <p class="home__description">Conveniently e-enable magnetic quality vectors
                            rather than distributed products. Phosfluorescently </p> --}}

                        <div class="home__buttons">
                            <a href="{{ route('acheter.voiture.get') }}" class="button">Reserver Maintenant</a>
                            {{-- <a href="javascript:void(0)" class="button--link button--flex">
                                Voir Details <i class="bx bx-right-arrow-alt button__icon"></i>
                            </a> --}}
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>

<!--=============== DISCOUNT ===============-->
{{-- <section class="discount section">
    <div class="discount__container container grid">
        <img src="{{ asset('assets/img/product-1.jpg') }}" alt="" class="discount__img">

        <div class="discount__data">
            <h2 class="discount__title">50% Discount<br>On New Products</h2>
            <a href="javascript:void(0)" class="button">Go to new</a>
        </div>
    </div>
</section> --}}

<!--=============== NEW ARRIVALS ===============-->
<section class="new section">
    <h2 class="section__title">Nos dernières voitures</h2>
    <div class="new__container container">
        <div class="swiper new-swiper">
            <div class="swiper-wrapper">
                <!--NEW CONTENT 1-->
                @foreach ($voitures as $voiture)
                <div class="new__content swiper-slide">
                    <a href="{{ route('details.voiture.get', [$voiture->slug_marque, $voiture->slug_modele, encodeId($voiture->id_voiture)]) }}"
                        class="">
                        @if ($voiture->status_reserver)
                        <div class="new__tag">Reservée</div>
                        @endif
                        <img src="{{ $voiture->image_voiture }}" alt="" class="new__img">
                        <h3 class="new__title">{{ $voiture->nom_marque }} {{ $voiture->nom_modele }}</h3>
                        <span class="new__subtitle">{{ $voiture->annee_voiture }} - {{ $voiture->kilometrage_voiture }}
                            Km - {{ $voiture->carburant_voiture }} - {{ $voiture->boite_vitesse_voiture }}</span>
                        <div class="new__prices">
                            <span class="new__price">{{ $voiture->prix_voiture }} FCFA</span>
                            {{-- <span class="new__discount">15000000</span> --}}
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!--=============== STEPS ===============-->
<section class="steps section container">
    <div class="steps__bg">
        <h2 class="section__title">Bienvenue chez Mycartraders 👋
            <br>Achetez une voiture d’occasion sans stress : on vous accompagne de A à Z !
        </h2>
        <div class="steps__container grid">
            <!--STEP CARD 1-->
            <div class="steps__card">
                <div style="font-size: 40px;">👨‍🔧</div>
                <h3 class="steps__card-title">Voitures contrôlées</h3>
                <p class="steps__card-description">
                    Nous avons plusieurs variétés de voitures parmi lesquels vous pouvez choisir.
                </p>
            </div>

            <!--STEP CARD 2-->
            <div class="steps__card">
                <div style="font-size: 40px;">🚗</div>
                <h3 class="steps__card-title">Meilleur qualité / prix</h3>
                <p class="steps__card-description">
                    Une fois votre commande réglée, nous passons à l'étape suivante qui est l'expédition.
                </p>
            </div>

            <!--STEP CARD 3-->
            <div class="steps__card">
                <div style="font-size: 40px;">👍</div>
                <h3 class="steps__card-title">Garantie incluse</h3>
                <p class="steps__card-description">
                    Notre processus de livraison est simple, vous recevez la commande directement à votre domicile ou a
                    l'adresse desire.
                </p>
            </div>

            <!--STEP CARD 3-->
            <div class="steps__card">
                <div style="font-size: 40px;">👌</div>
                <h3 class="steps__card-title">Satisfait ou remboursé</h3>
                <p class="steps__card-description">
                    Notre processus de livraison est simple, vous recevez la commande directement à votre domicile ou a
                    l'adresse desire.
                </p>
            </div>
        </div>
    </div>
</section>

<!--=============== STEPS ===============-->
<section class="steps section container">
    <div class="steps__bg">
        <h2 class="section__title">Comment commander des voitures
            <br>chez Mycartraders
        </h2>
        <div class="steps__container grid">
            <!--STEP CARD 1-->
            <div class="steps__card">
                <div class="steps__card-number">01</div>
                <h3 class="steps__card-title">Choisissez des voitures</h3>
                <p class="steps__card-description">
                    Nous avons plusieurs variétés de voitures parmi lesquels vous pouvez choisir.
                </p>
            </div>

            <!--STEP CARD 2-->
            <div class="steps__card">
                <div class="steps__card-number">02</div>
                <h3 class="steps__card-title">Commander</h3>
                <p class="steps__card-description">
                    Une fois votre commande réglée, nous passons à l'étape suivante qui est l'expédition.
                </p>
            </div>

            <!--STEP CARD 3-->
            <div class="steps__card">
                <div class="steps__card-number">03</div>
                <h3 class="steps__card-title">Faites-vous livrer la commande</h3>
                <p class="steps__card-description">
                    Notre processus de livraison est simple, vous recevez la commande directement à votre domicile ou a
                    l'adresse desire.
                </p>
            </div>
        </div>
    </div>
</section>

<!--=============== TEMOIGNAGES ===============-->
<section class="new section">
    <h6 style="text-align: center;font-size: 20px;">Temoignages</h6>
    <h2 class="section__title">Ceux qu'ils en pensent ❤️</h2>
    <div class="new__container container">
        <div class="swiper new-swiper">
            <div class="swiper-wrapper">
                <!--NEW CONTENT 1-->
                <div class="new__content swiper-slide">
                    <img style="text-align: center;width: 100px; height: 100px;border-radius: 50%;"
                        src="{{ asset('assets/img/user.jpg') }}" alt="">
                    <h3 class="new__title" style="margin-bottom: 10px;">Omar Fondey</h3>
                    <span class="new__subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur, quod
                        impedit voluptatum aliquid quia iste ea. Quidem tempore qui fuga ipsa nulla deleniti facilis
                        sunt, quod veniam, praesentium harum maxime. Quidem tempore qui fuga ipsa nulla deleniti facilis
                        sunt, quod veniam, praesentium harum maxime</span>
                </div>

                <!--NEW CONTENT 1-->
                <div class="new__content swiper-slide">
                    <img style="text-align: center;width: 100px; height: 100px;border-radius: 50%;"
                        src="{{ asset('assets/img/user.jpg') }}" alt="">
                    <h3 class="new__title" style="margin-bottom: 10px;">Omar Fondey</h3>
                    <span class="new__subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur, quod
                        impedit voluptatum aliquid quia iste ea. Quidem tempore qui fuga ipsa nulla deleniti facilis
                        sunt, quod veniam, praesentium harum maxime. Quidem tempore qui fuga ipsa nulla deleniti facilis
                        sunt, quod veniam, praesentium harum maxime</span>
                </div>

                <!--NEW CONTENT 1-->
                <div class="new__content swiper-slide">
                    <img style="text-align: center;width: 100px; height: 100px;border-radius: 50%;"
                        src="{{ asset('assets/img/user.jpg') }}" alt="">
                    <h3 class="new__title" style="margin-bottom: 10px;">Omar Fondey</h3>
                    <span class="new__subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur, quod
                        impedit voluptatum aliquid quia iste ea. Quidem tempore qui fuga ipsa nulla deleniti facilis
                        sunt, quod veniam, praesentium harum maxime. Quidem tempore qui fuga ipsa nulla deleniti facilis
                        sunt, quod veniam, praesentium harum maxime</span>
                </div>

                <!--NEW CONTENT 1-->
                <div class="new__content swiper-slide">
                    <img style="text-align: center;width: 100px; height: 100px;border-radius: 50%;"
                        src="{{ asset('assets/img/user.jpg') }}" alt="">
                    <h3 class="new__title" style="margin-bottom: 10px;">Omar Fondey</h3>
                    <span class="new__subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur, quod
                        impedit voluptatum aliquid quia iste ea. Quidem tempore qui fuga ipsa nulla deleniti facilis
                        sunt, quod veniam, praesentium harum maxime. Quidem tempore qui fuga ipsa nulla deleniti facilis
                        sunt, quod veniam, praesentium harum maxime</span>
                </div>

                <!--NEW CONTENT 1-->
                <div class="new__content swiper-slide">
                    <img style="text-align: center;width: 100px; height: 100px;border-radius: 50%;"
                        src="{{ asset('assets/img/user.jpg') }}" alt="">
                    <h3 class="new__title" style="margin-bottom: 10px;">Omar Fondey</h3>
                    <span class="new__subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur, quod
                        impedit voluptatum aliquid quia iste ea. Quidem tempore qui fuga ipsa nulla deleniti facilis
                        sunt, quod veniam, praesentium harum maxime. Quidem tempore qui fuga ipsa nulla deleniti facilis
                        sunt, quod veniam, praesentium harum maxime</span>
                </div>

                <!--NEW CONTENT 1-->
                <div class="new__content swiper-slide">
                    <img style="text-align: center;width: 100px; height: 100px;border-radius: 50%;"
                        src="{{ asset('assets/img/user.jpg') }}" alt="">
                    <h3 class="new__title" style="margin-bottom: 10px;">Omar Fondey</h3>
                    <span class="new__subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur, quod
                        impedit voluptatum aliquid quia iste ea. Quidem tempore qui fuga ipsa nulla deleniti facilis
                        sunt, quod veniam, praesentium harum maxime. Quidem tempore qui fuga ipsa nulla deleniti facilis
                        sunt, quod veniam, praesentium harum maxime</span>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection