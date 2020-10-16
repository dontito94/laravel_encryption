<?php


namespace Nextbyte\Encryption;


use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
class ZipCommand extends Command
{

    protected $signature = 'zip
     {--file= path}
     ';

    protected $description ='Zip and move encrypted file';

    public function handle()
    {
//        $rootPath = config('encrypt.destination', 'encrypted');
        $rootPath = realpath(config('encrypt.destination', 'encrypted'));
        //initialize archive object
        $zip = new \ZipArchive();
        $zip->open('');

            // Create recursive directory iterator
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY);

foreach ($files as $name => $file) {
    // Skip directories (they would be added automatically)
    if (!$file->isDir()) {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);

        // Add current file to archive
        $zip->addFile($filePath, $relativePath);
    }
}

      // Zip archive will be created only after closing object
        $zip->close();


    }
}
