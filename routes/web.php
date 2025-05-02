<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\Role;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\{
     ArticleController,
     CategorieController,
     Controller,
     DashboardController,
     EntreeController,
     FournisseurController,
     ProduitController,
     ProfileController,
     SortieController,
     UserController
};


/*
|--------------------------------------------------------------------------
| Routes publiques et auth de base
|--------------------------------------------------------------------------
*/

// Page d’accueil
Route::get('/', fn () => view('welcome'));


// Auth (login, logout, password reset…)
require __DIR__.'/auth.php';


// Inscription accessible aux invités
Route::middleware(['web','guest'])->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])
         ->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});


/*
|--------------------------------------------------------------------------
| Routes utilisatrices (auth)
|--------------------------------------------------------------------------
*/
Route::middleware(['web','auth'])->group(function () {
    // Dashboard & Profil
    Route::get('/dashboard', [DashboardController::class, 'index'])
         ->name('dashboard');
    Route::get('/profile',   [ProfileController::class, 'edit'])
         ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
         ->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])
         ->name('profile.destroy');

    Route::get('/admin/utilisateurs', [AdminController::class, 'index'])
     ->middleware(['auth', 'permission:manage_users']);

     // Affiche le formulaire de création
     Route::get('/invoices/create', [InvoiceController::class, 'create'])
     ->name('invoices.create');

     // Traite le formulaire et génère le PDF
     Route::post('/invoices', [InvoiceController::class, 'store'])
     ->name('invoices.store');

     Route::get('/facture/{sortie}', [InvoiceController::class, 'generate'])
          ->name('facture.generate'); 

     // Formulaire de création pour une vente donnée
     Route::get('/sorties/{sortie}/invoice/create', [InvoiceController::class,'create'])
          ->name('sorties.invoice.create');

     // Traitement + génération & sauvegarde de la facture
     Route::post('/sorties/{sortie}/invoice', [InvoiceController::class,'store'])
          ->name('sorties.invoice.store');
     
     // Ensuite votre resource normale
     Route::resource('sorties', SortieController::class);


    // Ressources principales
    Route::resource('produits',    ProduitController::class);
    Route::resource('categories',  CategorieController::class);
    Route::resource('fournisseurs',FournisseurController::class);
    Route::resource('entrees',     EntreeController::class);
    Route::resource('sorties',     SortieController::class);
    Route::resource('articles',    ArticleController::class);

    // Export
    Route::get('/chiffre-affaires/export', [SortieController::class, 'exportChiffreAffaires'])->name('chiffre.export.excel');
    Route::get('/sorties/export/excel', [SortieController::class, 'exportExcel'])->name('sorties.export.excel');
    Route::get('/entrees/export/excel', [EntreeController::class, 'exportExcel'])->name('entrees.export.excel');
    Route::get('/sorties/pdf', [SortieController::class, 'exportPdf'])->name('sorties.export.pdf');
    Route::get('/entrees/pdf', [EntreeController::class, 'exportPdf'])->name('entrees.export.pdf');
    Route::get('/dashboard/export-pdf', [DashboardController::class, 'exportPdf'])->name('dashboard.export.pdf');

    // Exports & détails (PDF / Excel / graphiques…)
    // … vos routes d’export ici …

    /*
    |--------------------------------------------------------------------------
    | Espace d’administration (seulement pour les admins)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', AdminMiddleware::class])
        ->prefix('admin')
        ->name('admin.')
        ->group(function(){
        Route::get('/', [AdminController::class, 'index'])->name('index');

        Route::resource('roles', RoleController::class)
            ->only(['index','update']);

          // Gestion des utilisateurs
          Route::resource('utilisateurs', UserManagementController::class)
          ->except(['show']); // adaptez selon vos besoins

          Route::get('/roles/{role}/permissions', [RoleController::class, 'editPermissions'])->name('roles.editPermissions');
          Route::put('/roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.updatePermissions');

          Route::get('/permissions/create', [RoleController::class, 'createPermission'])->name('permissions.create');
          Route::post('/permissions', [RoleController::class, 'storePermission'])->name('permissions.store');     
               
      });
});
