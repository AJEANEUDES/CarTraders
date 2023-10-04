@extends('layouts.app')
@section('title')
A propos :: Mycartraders
@endsection
@section('content')
<!--=============== ABOUT ===============-->
<section class="about section container">
    <h2 class="breadcrumb__title">A propos</h2>
    <h3 class="breadcrumb__subtitle">Accueil > <span>A propos</span></h3>

    <div class="about__container grid">
        <img src="{{ asset('assets/img/logo-mct.png') }}" alt="" class="about__img">

        <div class="about__data">
            <h2 class="section__title about__title">
                Qui sommes-nous ? <br>
            </h2>
            <p class="about__description">
                Nous avons plus de 4000 avis impartiaux et nos clients font confiance à nos produits et à notre service de livraison à chaque fois.
            </p>

            <p class="about__details-description">
                <i class="bx bxs-check-square about__details-icon"></i>
                Nous livrons toujours à temps
            </p>

            <p class="about__details-description">
                <i class="bx bxs-check-square about__details-icon"></i>
                Nous vous donnons des guides pour protéger et prendre soin de vos produits
            </p>

            <p class="about__details-description">
                <i class="bx bxs-check-square about__details-icon"></i>
                Garantie de remboursement à 100 %.
            </p>
        </div>
    </div>
</section>
@endsection