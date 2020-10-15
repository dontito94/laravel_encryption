<?php

namespace Nextbyte\Encryption;

use Carbon\Laravel\ServiceProvider;

class EncryptionServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->commands(EncryptionCommand::class);
    }


    public function register()
    {

        // Publish config file
        $configPath = __DIR__.'/../config/encrypt.php';
        if (function_exists('config_path')) {
            $publishPath = config_path('encrypt.php');
        } else {
            $publishPath = base_path('config/encrypt.php');
        }
        $this->publishes([$configPath => $publishPath], 'config');
    }
}
