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
php artisan vendor:publish --provider="Nextbyte\Encryption\EncryptionServiceProvider"
```

## Usage
=>some of encryption configuration
```bash
  'source'      => ['app', 'database', 'routes'], // Path(s) to encrypt
    'destination' => 'encrypted', // Destination path
    'key_length'  => 6, // Encryption key length
    'zip_filename'  => 'folders.zip', // zip filename
    'zipped_destination'  => '/home/blessedkono/encrypted/folders.zip', // zip filename
    'extract_destination'  => '/home/blessedkono/encrypted/', // destination project path
```
  
Open terminal in project root and run this command:
```bash
php artisan encrypt-source
```
=> You can zip and move encrypted files to new destination

```bash
php artisan move-destination
```
