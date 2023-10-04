<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//ROUTE AUTH
Auth::routes(['register' => false, 'verify' => false, 'reset' => false]);
// Route::get('/manual-logout', 'Auth\\LoginController@logout')->name('logout.manual');
// Route::post('//', 'Auth\\LoginController@login')->name('login');






//ROUTE SITEWEB PAGE
Route::get('/', 'SiteWebController@accueil')->name('accueil.get');
Route::get('/acheter-voiture', 'SiteWebController@acheterVoiture')->name('acheter.voiture.get');
Route::get('/paginate-voiture', 'SiteWebController@fetchDataVoiture')->name('fetch.voiture');
Route::get('/comment-ca-marche', 'SiteWebController@commentCaMarche')->name('comment.marche.get');
Route::get('/contactez-nous', 'SiteWebController@contactezNous')->name('contactez.nous.get');
Route::post('/contactez-nous', 'SiteWebController@contactSendMail')->name('contacts.sends.mails');
Route::get('/a-propos', 'SiteWebController@about')->name('about.get');
Route::get('/details-data-voiture', 'SiteWebController@detailsVoiture')->name('details.voiture');
Route::get('/details-voiture/{slug_marque}/{slug_modele}/{id_voiture}', 'SiteWebController@viewDetailsVoiture')->name('details.voiture.get');
//Route::any('/se-connecter', 'SiteWebController@viewLogin')->name('login');
Route::get('/inscription', 'SiteWebController@viewInscription')->name('inscription.view');
Route::post('/inscription', 'SiteWebController@inscription')->name('inscriptions.clients');










//ROUTE PAYEMENT
Route::get('/reservation', 'ReservationController@payementByPayDunya')->name('reservation');

//Route::get('/js/{files}', 'PrivateController@fileJs');

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');










//ROUTE LOGIN ADMIN

//Route::get('/mon-compte/se-connecter', 'Auth\\LoginController@viewLogin')->name('login-admin.view');
//Route::post('/se-connecter', 'Auth\\LoginController@login')->name('login');

Route::group(['prefix' => 'admin', 'middleware' => ['isAdmin', 'auth']], function () {
    Route::get('/tableau-de-bord', 'AdminController@tableauDeBord')->name('admin.dashbord');
    Route::get('/mon-compte', 'AdminController@profileAdmin')->name('admin.compte');

    //ROUTE MARQUE_VOITURE
    Route::prefix('marque-voiture')->group(function () {
        Route::get('/', 'MarqueController@getMarqueVoiture')->name('marques-voitures.get');
        Route::get('/get-spec-marque-voiture', 'MarqueController@getSpecMarqueVoiture')->name('marques-voitures.get.spec');
        Route::get('/info-marque-voiture', 'MarqueController@infoMarque')->name('marques.info');
        Route::get('/load-marque-voiture', 'MarqueController@loadDataMarque')->name('marques.load');
        Route::post('/update-marque-voiture', 'MarqueController@updateMarqueVoiture')->name('marques-voitures.update');
        Route::post('/store-marque-voiture', 'MarqueController@storeMarqueVoiture')->name('marques-voitures.store');
        Route::post('/delete-marque-voiture', 'MarqueController@deleteMarqueVoiture')->name('marques-voitures.delete');
    });
    
    //ROUTE MODELE_VOITURE
    Route::prefix('modele-voiture')->group(function () {
        Route::get('/', 'ModeleController@getModeleVoiture')->name('modeles-voitures.get');
        Route::get('/get-spec-modele-voiture', 'ModeleController@getSpecModeleVoiture')->name('modeles-voitures.get.spec');
        Route::get('/info-modele-voiture', 'ModeleController@infoModele')->name('modeles.info');
        Route::post('/update-modele-voiture', 'ModeleController@updateModeleVoiture')->name('modeles-voitures.update');
        Route::post('/store-modele-voiture', 'ModeleController@storeModeleVoiture')->name('modeles-voitures.store');
        Route::post('/delete-modele-voiture', 'ModeleController@deleteModeleVoiture')->name('modeles-voitures.delete');
    });

    //ROUTE SOCIETE
    Route::prefix('societe')->group(function () {
        Route::get('/', 'SocieteController@getSociete')->name('societes.get');
        Route::get('/get-spec-societe', 'SocieteController@getSpecSociete')->name('societes.get.spec');
        Route::get('/info-societe', 'SocieteController@infoSociete')->name('societes.info');
        Route::post('/update-societe', 'SocieteController@updateSociete')->name('societes.update');
        Route::post('/store-societe', 'SocieteController@storeSociete')->name('societes.store');
        Route::post('/delete-societe', 'SocieteController@deleteSociete')->name('societes.delete');
    });

    //ROUTE PACKING_VOITURE
    Route::prefix('parking-voiture')->group(function () {
        Route::get('/', 'ParkingController@getParkingVoiture')->name('parkings-voitures.get');
        Route::get('/get-spec-parking-voiture', 'ParkingController@getSpecParkingVoiture')->name('parkings-voitures.get.spec');
        Route::get('/info-parking-voiture', 'ParkingController@infoParking')->name('parkings.info');
        Route::post('/update-parking-voiture', 'ParkingController@updateParkingVoiture')->name('parkings-voitures.update');
        Route::post('/store-parking-voiture', 'ParkingController@storeParkingVoiture')->name('parkings-voitures.store');
        Route::post('/delete-parking-voiture', 'ParkingController@deleteParkingVoiture')->name('parkings-voitures.delete');
    });

    //ROUTE VOITURE
    Route::prefix('voiture')->group(function () {
        Route::get('/', 'VoitureController@getVoiture')->name('voitures.get');
        Route::get('/get-spec-voiture', 'VoitureController@getSpecVoiture')->name('voitures.get.spec');
        Route::post('/update-voiture', 'VoitureController@updateVoiture')->name('voitures.update');
        Route::get('/info-voiture', 'VoitureController@infoVoiture')->name('voitures.info');
        Route::post('/store-voiture', 'VoitureController@storeVoiture')->name('voitures.store');
        Route::post('/delete-voiture', 'VoitureController@deleteVoiture')->name('voitures.delete');
    });

    //ROUTE IMAGE_VOITURE
    Route::prefix('image-voiture')->group(function () {
        Route::get('/', 'ImageController@getImageVoiture')->name('images-voitures.get');
        Route::get('/get-spec-image-voiture', 'ImageController@getSpecImageVoiture')->name('images-voitures.get.spec');
        Route::post('/update-image-voiture', 'ImageController@updateImageVoiture')->name('images-voitures.update');
        Route::get('/info-image-voiture', 'ImageController@infoImageVoiture')->name('images-voitures.info');
        Route::post('/store-image-voiture', 'ImageController@storeImageVoiture')->name('images-voitures.store');
        Route::post('/delete-image-voiture', 'ImageController@deleteImageVoiture')->name('images-voitures.delete');
    });

    //ROUTE SERVICE_VOITURE
    Route::prefix('service-voiture')->group(function () {
        Route::get('/', 'ServiceController@getServiceVoiture')->name('services-voitures.get');
        Route::get('/get-spec-service-voiture', 'ServiceController@getSpecServiceVoiture')->name('services-voitures.get.spec');
        Route::get('/info-service', 'ServiceController@infoService')->name('services.info');
        Route::post('/update-service-voiture', 'ServiceController@updateServiceVoiture')->name('services-voitures.update');
        Route::post('/store-service-voiture', 'ServiceController@storeServiceVoiture')->name('services-voitures.store');
        Route::post('/delete-service-voiture', 'ServiceController@deleteServiceVoiture')->name('services-voitures.delete');
    });

    //ROUTE ADMINISTRATOR
    Route::prefix('administrateur')->group(function () {
        Route::get('/', 'AdminController@getAdmin')->name('admins.get');
        Route::get('/get-spec-admin', 'AdminController@getSpecAdmin')->name('admins.get.spec');
        Route::get('/info-admin', 'AdminController@infoAdmin')->name('admins.info');
        Route::post('/update-admin', 'AdminController@updateAdmin')->name('admins.update');
        Route::post('/update-profile-admin', 'AdminController@updateProfileAdmin')->name('admins.profile.update');
        Route::post('/mot-de-passe', 'AdminController@updateMotDePasse')->name('admins.update.mdp');
        Route::post('/store-admin', 'AdminController@storeAdmin')->name('admins.store');
        Route::post('/delete-admin', 'AdminController@deleteAdmin')->name('admins.delete');
    });

    //ROUTE GESTIONNAIRE
    Route::prefix('gestionnaire')->group(function () {
        Route::get('/', 'GestionnaireController@getGestionnaire')->name('gestionnaires.get');
        Route::get('/get-spec-gestionnaire', 'GestionnaireController@getSpecGestionnaire')->name('gestionnaires.get.spec');
        Route::get('/info-gestionnaire', 'GestionnaireController@infoGestionnaire')->name('gestionnaires.info');
        Route::post('/update-gestionnaire', 'GestionnaireController@updateGestionnaire')->name('gestionnaires.update');
        Route::post('/store-gestionnaire', 'GestionnaireController@storeGestionnaire')->name('gestionnaires.store');
        Route::post('/delete-gestionnaire', 'GestionnaireController@deleteGestionnaire')->name('gestionnaires.delete');
    });

    //ROUTE CLIENT
    Route::prefix('client')->group(function () {
        Route::get('/', 'ClientController@getClients')->name('clients.get');
        Route::get('/info-client', 'ClientController@infoClient')->name('clients.info');
        Route::post('/update-client', 'ClientController@updateClient')->name('clients.update');
        Route::post('/delete-client', 'ClientController@deleteClient')->name('clients.delete');
    });

    //ROUTE FACTURE
    Route::prefix('facture')->group(function () {
        Route::get('/', 'FactureController@getFacture')->name('factures.get');
        Route::get('/get-spec-facture', 'FactureController@ ')->name('factures.get.spec');
        Route::get('/info-facture', 'FactureController@infoFacture')->name('factures.info');
        Route::post('/download-facture', 'FactureController@downloadFacture')->name('factures.download');
        Route::post('/update-facture', 'FactureController@updateFacture')->name('factures.update');
        Route::post('/store-facture', 'FactureController@storeFacture')->name('factures.store');
        Route::post('/delete-facture', 'FactureController@deleteFacture')->name('factures.delete');
    });

    //ROUTE RESERVATION
    Route::prefix('reservation')->group(function () {
        Route::get('/', 'ReservationController@getReservations')->name('reservations.get');
        Route::get('/info-reservation', 'ReservationController@infoReservation')->name('reservations.info');
        Route::post('/annulation-reservation', 'ReservationController@annulationReservation')->name('reservations.annulation');
    });
});



//ROUTE Gestionnaire login


Route::group(['prefix' => 'gestionnaire', 'middleware' => ['isGestionnaire', 'auth']], function () {
    Route::get('/tableau-de-bord', 'GestionnaireController@tableauDeBord')->name('gestionnaire.dashbord');
    Route::get('/mon-compte', 'GestionnaireController@profileGestionnaire')->name('gestionnaire.compte');

    Route::get('/info-admin', 'Gestionnaire\GestionnaireController@infoGestionnaire')->name('gestionnaires.info.gestion');
    Route::post('/update-profile-admin', 'Gestionnaire\GestionnaireController@updateProfileGestionnaire')->name('gestionnaires.profile.update');
    Route::post('/mot-de-passe', 'Gestionnaire\GestionnaireController@updateMotDePasse')->name('gestionnaires.update.mdp');

    //ROUTE MARQUE_VOITURE
    Route::prefix('marque-voiture')->group(function () {
        Route::get('/', 'Gestionnaire\MarqueController@getMarqueVoiture')->name('marques-voitures.get.gestion');
        Route::get('/get-spec-marque-voiture', 'Gestionnaire\MarqueController@getSpecMarqueVoiture')->name('marques-voitures.get.spec.gestion');
        Route::get('/info-marque-voiture', 'Gestionnaire\MarqueController@infoMarque')->name('marques.info.gestion');
        Route::get('/load-marque-voiture', 'Gestionnaire\MarqueController@loadDataMarque')->name('marques.load.gestion');
        Route::post('/update-marque-voiture', 'Gestionnaire\MarqueController@updateMarqueVoiture')->name('marques-voitures.update.gestion');
        Route::post('/store-marque-voiture', 'Gestionnaire\MarqueController@storeMarqueVoiture')->name('marques-voitures.store.gestion');
        Route::post('/delete-marque-voiture', 'Gestionnaire\MarqueController@deleteMarqueVoiture')->name('marques-voitures.delete.gestion');
    });

    //ROUTE MODELE_VOITURE
    Route::prefix('modele-voiture')->group(function () {
        Route::get('/', 'Gestionnaire\ModeleController@getModeleVoiture')->name('modeles-voitures.get.gestion');
        Route::get('/get-spec-modele-voiture', 'Gestionnaire\ModeleController@getSpecModeleVoiture')->name('modeles-voitures.get.spec.gestion');
        Route::get('/info-modele-voiture', 'Gestionnaire\ModeleController@infoModele')->name('modeles.info.gestion');
        Route::post('/update-modele-voiture', 'Gestionnaire\ModeleController@updateModeleVoiture')->name('modeles-voitures.update.gestion');
        Route::post('/store-modele-voiture', 'Gestionnaire\ModeleController@storeModeleVoiture')->name('modeles-voitures.store.gestion');
        Route::post('/delete-modele-voiture', 'Gestionnaire\ModeleController@deleteModeleVoiture')->name('modeles-voitures.delete.gestion');
    });

    //ROUTE PACKING_VOITURE
    Route::prefix('parking-voiture')->group(function () {
        Route::get('/get-spec-parking-voiture', 'Gestionnaire\ParkingController@getSpecParkingVoiture')->name('parkings-voitures.get.spec.gestion');
    });

    //ROUTE VOITURE
    Route::prefix('voiture')->group(function () {
        Route::get('/', 'Gestionnaire\VoitureController@getVoiture')->name('voitures.get.gestion');
        Route::get('/get-spec-voiture', 'Gestionnaire\VoitureController@getSpecVoiture')->name('voitures.get.spec.gestion');
        Route::post('/update-voiture', 'Gestionnaire\VoitureController@updateVoiture')->name('voitures.update.gestion');
        Route::get('/info-voiture', 'Gestionnaire\VoitureController@infoVoiture')->name('voitures.info.gestion');
        Route::post('/store-voiture', 'Gestionnaire\VoitureController@storeVoiture')->name('voitures.store.gestion');
        Route::post('/delete-voiture', 'Gestionnaire\VoitureController@deleteVoiture')->name('voitures.delete.gestion');
    });

    //ROUTE IMAGE_VOITURE
    Route::prefix('image-voiture')->group(function () {
        Route::get('/', 'Gestionnaire\ImageController@getImageVoiture')->name('images-voitures.get.gestion');
        Route::get('/get-spec-image-voiture', 'Gestionnaire\ImageController@getSpecImageVoiture')->name('images-voitures.get.spec.gestion');
        Route::post('/update-image-voiture', 'Gestionnaire\ImageController@updateImageVoiture')->name('images-voitures.update.gestion');
        Route::get('/info-image-voiture', 'Gestionnaire\ImageController@infoImageVoiture')->name('images-voitures.info.gestion');
        Route::post('/store-image-voiture', 'Gestionnaire\ImageController@storeImageVoiture')->name('images-voitures.store.gestion');
        Route::post('/delete-image-voiture', 'Gestionnaire\ImageController@deleteImageVoiture')->name('images-voitures.delete.gestion');
    });
});





Route::group(['prefix' => 'client', 'middleware' => ['isClient', 'auth']], function () {
    Route::get('/tableau-de-bord', 'UserController@tableauDeBord')->name('utilisateur.dashbord');
    Route::get('/profile', 'UserController@profile')->name('utilisateur.profile');
    Route::get('/info-client', 'UserController@infoClient')->name('clients.infos');
    Route::post('/mon-compte', 'UserController@updateUtilisateur')->name('utilisateur.update');
    Route::get('/mot-de-passe', 'UserController@motDePasse')->name('utilisateur.mdp');
    Route::post('/mot-de-passe', 'UserController@updateMotDePasse')->name('utilisateur.update.mdp');

    //ROUTE RESERVATION
    Route::prefix('reservation')->group(function () {
        Route::get('/listes', 'ReservationController@listeReservation')->name('reservations.liste');
        Route::post('/store-reservation', 'ReservationController@storeReservation')->name('reservations.store');
    });

    //ROUTE RESERVATION
    Route::prefix('facture')->group(function () {
        Route::get('/listes', 'FactureController@listeFacture')->name('factures.liste');
    });
});

Route::get('/notifications-payement', 'ReservationController@notificationPayement');
Route::any('/payement-callback', 'ReservationController@payementCallback')->name('payements.callback');
Route::get('/payement-cancel', 'ReservationController@payementCancel')->name('payements.cancel');
Route::any('/payement-return', 'ReservationController@payementReturn')->name('payements.return');

//Reset Password
Route::get('/reinitialiser-mon-de-passe', 'PrivateController@viewResetPassword')->name('reinitialiser.mon-de-passe.get');
Route::post('/reinitialiser-mon-de-passe', 'PrivateController@resetPassword')->name('reinitialiser.mon-de-passe.check');
Route::get('/reinitialiser-mon-de-passe/{reset_code}', 'PrivateController@resetNewPassword')->name('reinitialiser.reset-code');
Route::post('/reinitialiser-mon-de-passe/{reset_code}', 'PrivateController@getPasswordReset')->name('reinitialiser.password-reset');