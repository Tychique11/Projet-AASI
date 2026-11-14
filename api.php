<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProprieteController;
use App\Http\Controllers\Api\UniteLocativeController;
use App\Http\Controllers\Api\LocataireController;
use App\Http\Controllers\Api\ContratController;
use App\Http\Controllers\Api\PaiementController;
use App\Http\Controllers\Api\DemandeController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\StatistiquesController;
use App\Http\Controllers\Api\ConfigurationController;
use App\Http\Controllers\Api\PreavisController;
use App\Http\Controllers\Api\PaiementMobileController;
use App\Http\Controllers\Api\NotificationSettingsController;

// Routes publiques
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/test-mail', [AuthController::class, 'testMail']);
Route::post('/add-locataires', [LocataireController::class, 'store']);

// Routes protégées
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/gerant/proprietes-avec-locataires', [GerantController::class, 'proprietesAvecLocataires']);
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/update-pin', [AuthController::class, 'updatePin']);
    Route::post('/verify-pin', [AuthController::class, 'verifyPin']);

    // Propriétés
    Route::get('/proprietes', [ProprieteController::class, 'index']);
    Route::post('/proprietes', [ProprieteController::class, 'store']);
    Route::get('/proprietes/{id}', [ProprieteController::class, 'show']);
    Route::put('/proprietes/{id}', [ProprieteController::class, 'update']);
    Route::delete('/proprietes/{id}', [ProprieteController::class, 'destroy']);
    Route::get('/proprietes/{id}/historique', [ProprieteController::class, 'historique']);
    Route::get('/proprietes/dashboard/stats', [ProprieteController::class, 'dashboard']);

    // Unités locatives
    Route::get('/unites', [UniteLocativeController::class, 'index']);
    Route::post('/unites', [UniteLocativeController::class, 'store']);
    Route::get('/unites/{id}', [UniteLocativeController::class, 'show']);
    Route::put('/unites/{id}', [UniteLocativeController::class, 'update']);
    Route::delete('/unites/{id}', [UniteLocativeController::class, 'destroy']);
    Route::get('/unites/{id}/contrat-actif', [UniteLocativeController::class, 'contratActif']);

    // Locataires
    Route::get('/locataires', [LocataireController::class, 'index']);
    
    
    Route::get('/locataires/{id}', [LocataireController::class, 'show']);
    Route::put('/locataires/{id}', [LocataireController::class, 'update']);
    Route::delete('/locataires/{id}', [LocataireController::class, 'destroy']);
    Route::post('/locataires/{id}/associer', [LocataireController::class, 'associerPropriete']);
    Route::get('/locataires/{id}/contrats', [LocataireController::class, 'contrats']);
    Route::get('/locataires/{id}/paiements', [LocataireController::class, 'paiements']);
    
    // Contrats
    Route::get('/contrats', [ContratController::class, 'index']);
    Route::post('/contrats', [ContratController::class, 'store']);
    Route::get('/contrats/{id}', [ContratController::class, 'show']);
    Route::put('/contrats/{id}', [ContratController::class, 'update']);
    Route::delete('/contrats/{id}', [ContratController::class, 'destroy']);
    Route::post('/contrats/{id}/resilier', [ContratController::class, 'resilier']);
    Route::post('/contrats/{id}/renouveler', [ContratController::class, 'renouveler']);
    Route::get('/contrats/{id}/paiements', [ContratController::class, 'paiements']);
    Route::get('/locataires/{id}/historique-contrats', [ContratController::class, 'historique']);

    // Paiements
    Route::get('/paiements', [PaiementController::class, 'index']);
    Route::post('/paiements', [PaiementController::class, 'store']);
    Route::get('/paiements/{id}', [PaiementController::class, 'show']);
    Route::post('/paiements/{id}/valider', [PaiementController::class, 'valider']);
    Route::post('/paiements/{id}/annuler', [PaiementController::class, 'annuler']);
    Route::get('/paiements/{id}/recu', [PaiementController::class, 'downloadRecu']);
    Route::get('/paiements/historique', [PaiementController::class, 'historique']);
    Route::get('/paiements/stats', [PaiementController::class, 'stats']);

    // Demandes
    Route::get('/demandes', [DemandeController::class, 'index']);
    Route::post('/demandes', [DemandeController::class, 'store']);
    Route::get('/demandes/{id}', [DemandeController::class, 'show']);
    Route::put('/demandes/{id}', [DemandeController::class, 'update']);
    Route::delete('/demandes/{id}', [DemandeController::class, 'destroy']);
    Route::post('/demandes/{id}/traiter', [DemandeController::class, 'traiter']);
    Route::post('/demandes/{id}/resoudre', [DemandeController::class, 'resoudre']);
    Route::get('/demandes/stats', [DemandeController::class, 'stats']);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/marquer-lue/{id}', [NotificationController::class, 'marquerLue']);
    Route::get('/notifications/retards', [NotificationController::class, 'detecterRetards']);
    Route::post('/notifications/envoyer-retard', [NotificationController::class, 'envoyerNotificationRetard']);
    Route::get('/notifications/rappel-auto', [NotificationController::class, 'rappelAutomatique']);
    Route::post('/notifications/proprietaire', [NotificationController::class, 'notifierProprietaire']);

    // Statistiques
    Route::get('/statistiques', [StatistiquesController::class, 'index']);
    Route::get('/statistiques/rapport-mensuel', [StatistiquesController::class, 'rapportMensuel']);
    Route::get('/statistiques/proprietes-autorisees', [StatistiquesController::class, 'proprietesAutorisees']);

    // Configuration
    Route::get('/configuration', [ConfigurationController::class, 'index']);
    Route::put('/configuration', [ConfigurationController::class, 'update']);
    Route::post('/configuration/logo', [ConfigurationController::class, 'uploadLogo']);
    Route::post('/configuration/signature', [ConfigurationController::class, 'uploadSignature']);

    // ===== PRÉAVIS =====
    Route::get('/preavis', [PreavisController::class, 'index']);
    Route::post('/preavis', [PreavisController::class, 'store']);
    Route::get('/preavis/{id}', [PreavisController::class, 'show']);
    Route::post('/preavis/{id}/approuver', [PreavisController::class, 'approuver']);
    Route::post('/preavis/{id}/rejeter', [PreavisController::class, 'rejeter']);
    Route::get('/preavis/stats', [PreavisController::class, 'stats']);

    // ===== PAIEMENT MOBILE =====
    Route::post('/paiement-mobile/initier', [PaiementMobileController::class, 'initierPaiement']);
    Route::get('/paiement-mobile/verifier/{reference}', [PaiementMobileController::class, 'verifierStatut']);
    Route::post('/paiement-mobile/webhook', [PaiementMobileController::class, 'webhookConfirmation']);
    Route::get('/paiement-mobile/historique', [PaiementMobileController::class, 'historique']);

    // ===== PARAMÈTRES NOTIFICATIONS =====
    Route::get('/notification-settings', [NotificationSettingsController::class, 'index']);
    Route::put('/notification-settings', [NotificationSettingsController::class, 'update']);
    Route::post('/notification-settings/reset', [NotificationSettingsController::class, 'reset']);
    Route::post('/notification-settings/test', [NotificationSettingsController::class, 'test']);
    Route::get('/notification-settings/stats', [NotificationSettingsController::class, 'stats']);
    Route::get('/notifications/retards', [NotificationController::class, 'envoyerNotificationsRetard']);

    
    Route::post('/check-email', [AuthController::class, 'checkEmail']);
    Route::post('/check-phone', [AuthController::class, 'checkPhone']);
    
    // Locataires sans contrat
    Route::get('/locataires/sans-contrat', [LocataireController::class, 'sansContrat']); 
   
     
   
});



