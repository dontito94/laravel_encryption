<?php


namespace Nextbyte\Encryption;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
class ZipCommand extends Command
{

    protected $signature = 'move-destination';

    protected $description ='Zip and move encrypted file';

    public function handle()
    {
//        $rootPath = config('encrypt.destination', 'encrypted');
        $rootPath = realpath(config('encrypt.destination', 'encrypted'));
        //initialize archive object
        $zip = new \ZipArchive();
        $zip->open(config('encrypt.zip_filename', 'encrypted.zip'), \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

            // Create recursive directory iterator
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY);

        //add each file in zip
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

        //move zipped file to destination
//        File::copy(base_path(config('encrypt.zip_filename', 'encrypted.zip')), config('encrypt.zipped_destination', '/home/blessedkono/encrypted/folders.zip'));

        //extract folder in the destination
        $zipped = $zip->open(config('encrypt.zip_filename', 'encrypted.zip'));
        if ($zipped = true)
        {
            $zip->extractTo(config('encrypt.extract_destination','/home/blessedkono/encrypted/'));
        }

        $this->info('Successfully! files moved to destination');
        // Zip archive will be created only after closing object
        $zip->close();


        File::deleteDirectory(config('encrypt.zip_filename'));

    }
}
