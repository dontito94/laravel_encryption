# laravel code encryption
this for encrypt laravel project 



Installation
#Step 1
At the first, You have to install phpBolt.

#Step 2
Require the package with composer using the following command:

composer require --dev sbamtr/laravel-source-encrypter
#Step 3
For Laravel
The service provider will automatically get registered. Or you may manually add the service provider in your config/app.php file:

'providers' => [
    // ...
    \Nextbyte\Encryption\EncryptionServiceProvider::class,
];
For Lumen
Add this line of code under the Register Service Providers section of your bootstrap/app.php:

$app->register(\\Nextbyte\Encryption\EncryptionServiceProvider::class);
#Step 4 (Optional)
You can publish the config file with this following command:

php artisan vendor:publish --provider="\Nextbyte\Encryption\EncryptionServiceProvider"

#Usage
Open terminal in project root and run this command:

php artisan encrypt-source
