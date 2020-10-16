# laravel code encryption
this for encrypt laravel project 



Installation
## Step 1
At the first, You have to install phpBolt.

## Step 2
Require the package with composer using the following command:
```bash
composer require nextbytetz/laravel_encryption
```
## Step 3
The service provider will automatically get registered. Or you may manually add the service provider in your config/app.php file:

```bash
'providers' => [
    // ...
    Nextbyte\Encryption\EncryptionServiceProvider::class,
];

```



## Step 4 (Optional)
You can publish the config file with this following command:

```bash
php artisan vendor:publish --provider="\Nextbyte\Encryption\EncryptionServiceProvider"
```

## Usage
Open terminal in project root and run this command:
```bash
php artisan encrypt-source
```

