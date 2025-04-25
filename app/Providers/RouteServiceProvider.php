<?php

    namespace App\Providers;

    use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
    use Illuminate\Support\Facades\Route;

    class RouteServiceProvider extends ServiceProvider
    {
        /**
         * Chemin de redirection après login ou enregistrement
         */
        public const HOME = '/dashboard';

        /**
         * Définir les routes de l'application.
         */
        public function boot(): void
        {
            $this->routes(function () {
                Route::middleware('web')
                    ->group(base_path('routes/web.php'));

                Route::middleware('api')
                    ->prefix('api')
                    ->group(base_path('routes/api.php'));
            });
        }
    }
