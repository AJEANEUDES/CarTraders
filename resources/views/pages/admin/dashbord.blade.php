@extends('themes.main')
@section('title')
Tableau de bord :: Mycartraders
@endsection
@section('main')
<div class="pagetitle">
    <h1>Tableau de bord</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Accueil</a></li>
            <li class="breadcrumb-item active">Tableau de bord</li>
        </ol>
    </nav>
</div>

<section class="section dashboard">
    <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-12">
            <div class="row">
                <!-- Sales Card -->
                <div class="col-xxl-3 col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Marques</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bx bx-tag"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $marques }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Sales Card -->

                <!-- Revenue Card -->
                <div class="col-xxl-3 col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Modeles</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bx bx-bus"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $modeles }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Revenue Card -->

                <!-- Customers Card -->
                <div class="col-xxl-3 col-xl-12">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Voitures</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bx bx-car"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $voitures }}</h6>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- End Customers Card -->

                <!-- Customers Card -->
                <div class="col-xxl-3 col-xl-12">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Images</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bx bx-image"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $images }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Customers Card -->

                <!-- Customers Card -->
                <div class="col-xxl-3 col-xl-12">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Societes</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bx bxs-bank"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $societes }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Customers Card -->

                <!-- Customers Card -->
                <div class="col-xxl-3 col-xl-12">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Parcs</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-bookmarks-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $parcs }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Customers Card -->

                <!-- Customers Card -->
                <div class="col-xxl-3 col-xl-12">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Services</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bx bxs-diamond"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $services }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Customers Card -->

                <!-- Customers Card -->
                <div class="col-xxl-3 col-xl-12">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Clients</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $clients }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Customers Card -->

                 <!-- Customers Card -->
                 <div class="col-xxl-3 col-xl-12">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Administrateurs</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $admins }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Customers Card -->

                <!-- Customers Card -->
                <div class="col-xxl-3 col-xl-12">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Gestionnaires</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-file-person"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $gestionnaires }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Customers Card -->

                <!-- Customers Card -->
                <div class="col-xxl-3 col-xl-12">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Reservations</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bx bxs-carousel"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $reservations }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Customers Card -->

                <!-- Customers Card -->
                <div class="col-xxl-3 col-xl-12">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Factures</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bx bxs-file-blank"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $factures }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Customers Card -->
            </div>
        </div><!-- End Left side columns -->
    </div>
</section>
@endsection