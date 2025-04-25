<?php

    use App\Http\Middleware\AdminMiddleware;
    use App\Http\Controllers\Auth\RegisteredUserController;
    use App\Models\Role;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\{
        ProfileController,
        EntreeController,
        SortieController,
        DashboardController,
        CategorieController,
        FournisseurController,
        UserController,
        ProduitController,
        ArticleController,
        AdminController
    };


    

    // Routes accessibles uniquement aux utilisateurs authentifiés
    Route::middleware(['web', 'auth'])->group(function () {


        Route::get('/register', [RegisteredUserController::class, 'create'])
            ->middleware('guest')
            ->name('register');

        Route::post('/register', [RegisteredUserController::class, 'store'])
            ->middleware('guest');

        Route::middleware([AdminMiddleware::class])->group(function () {
            Route::get('/admin/utilisateurs', [AdminController::class, 'index']);
        });

        // Tableau de bord et profil
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Produits, catégories, fournisseurs, entrées, sorties
        Route::resource('produits', ProduitController::class);
        Route::resource('categories', CategorieController::class);
        Route::get('/fournisseurs/create', [FournisseurController::class, 'create'])->name('fournisseurs.create');
        //Route::post('fournisseurs', [FournisseurController::class, 'store']);
        Route::resource('fournisseurs', FournisseurController::class);
        Route::resource('entrees', EntreeController::class);
        Route::resource('sorties', SortieController::class);
        Route::resource('articles', ArticleController::class);

        // Détails produits
        Route::get('/entrees/produits', [EntreeController::class, 'produits'])->name('entrees.produits');
        Route::get('/entrees/produits/{id}', [EntreeController::class, 'produit'])->name('entrees.produit');
        Route::get('/sorties/produits', [SortieController::class, 'produits'])->name('sorties.produits');
        Route::get('/sorties/produits/{id}', [SortieController::class, 'produit'])->name('sorties.produit');

        // Export
        Route::get('/chiffre-affaires/export', [SortieController::class, 'exportChiffreAffaires'])->name('chiffre.export.excel');
        Route::get('/sorties/export/excel', [SortieController::class, 'exportExcel'])->name('sorties.export.excel');
        Route::get('/entrees/export/excel', [EntreeController::class, 'exportExcel'])->name('entrees.export.excel');
        Route::get('/sorties/pdf', [SortieController::class, 'exportPdf'])->name('sorties.export.pdf');
        Route::get('/entrees/pdf', [EntreeController::class, 'exportPdf'])->name('entrees.export.pdf');
        Route::get('/dashboard/export-pdf', [DashboardController::class, 'exportPdf'])->name('dashboard.export.pdf');

        // Routes ADMIN uniquement

        Route::middleware(['auth', 'role:admin'])->group(function () {
            Route::get('/admin/utilisateurs', [UserController::class, 'index'])->name('admin.users.index');
            Route::get('/admin/utilisateurs/create', [UserController::class, 'create'])->name('admin.users.create');
            Route::post('/admin/utilisateurs', [UserController::class, 'store'])->name('admin.users.store');
        });
        
        Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
            Route::resource('utilisateurs', \App\Http\Controllers\Admin\UserManagementController::class);
        });
        
        
        Route::middleware(['auth', 'role:admin'])->group(function () {
            Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
        });
        

    });

    // Redirection par défaut
    Route::get('/', function () {
        return view('welcome');
});

require __DIR__.'/auth.php';

