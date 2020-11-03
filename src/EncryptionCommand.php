<?php


namespace Nextbyte\Encryption;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
class EncryptionCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'encrypt-source
                { --source= : Path(s) to encrypt }
                { --destination= : Destination directory }
                { --force : Force the operation to run when destination directory already exists }
                { --keylength= : Encryption key length }';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Encrypts PHP files';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        //rsync source and destination before encryption
        exec('rsync -azv '.config('encrypt.exclude_sync_source').' '.config('encrypt.sync_source').' '.config('encrypt.extract_destination').'');


        //check installation of dependence
        if (!extension_loaded('bolt')) {
            $this->error('Please install bolt.so https://phpBolt.com');
            $this->error('PHP Version '.phpversion());
            $this->error('INI file location '.php_ini_scanned_files());
            $this->error('Extension dir: '.ini_get('extension_dir'));

            return 1;
        }

        //check options
        if (empty($this->option('source'))) {
            $sources = config('encrypt.source', ['app', 'database', 'routes']);
        } else {
            $sources = $this->option('source');
            $sources = explode(',', $sources);
        }
        if (empty($this->option('destination'))) {
            $destination = config('encrypt.destination', 'encrypted');
        } else {
            $destination = $this->option('destination');
        }
        if (empty($this->option('keylength'))) {
            $keyLength = config('encrypt.key_length', 6);
        } else {
            $keyLength = $this->option('keylength');
        }


        if (!$this->option('force')
            && File::exists(base_path($destination))
            && !$this->confirm("The directory $destination already exists. Delete directory?")
        ) {
            $this->line('Command canceled.');

            return 1;
        }

        //delete if directory exist
        File::deleteDirectory(base_path($destination));

        //create new directory
        File::makeDirectory(base_path($destination));

        //check and loop all sources to encrypt
        foreach ($sources as $source) {
            @File::makeDirectory($destination.'/'.File::dirname($source), 493, true);

            if (File::isFile($source)) {
                self::encryptFile($source, $destination, $keyLength);
                continue;
            }
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(base_path($source)));
            foreach ($files as $file) {
                $filePath = Str::replaceFirst(base_path(), '', $file->getRealPath());
                self::encryptFile($filePath, $destination, $keyLength);
            }
        }
        $this->info('Encrypting Completed Successfully!');
        $this->info("Destination directory: $destination");

        return 0;
    }

    //encrypt all sources
    private static function encryptFile($filePath, $destination, $keyLength)
    {
        $key = Str::random($keyLength);
        if (File::isDirectory(base_path($filePath))) {
            if (!File::exists(base_path($destination.$filePath))) {
                File::makeDirectory(base_path("$destination/$filePath"), 493, true);
            }

            return;
        }

        if (File::extension($filePath) != 'php') {
            File::copy(base_path($filePath), base_path("$destination/$filePath"));

            return;
        }

        $fileContents = File::get(base_path($filePath));

        $prepend = "<?php
bolt_decrypt( __FILE__ , '$key'); return 0;
##!!!##";
        $pattern = '/\<\?php/m';
        preg_match($pattern, $fileContents, $matches);
        if (!empty($matches[0])) {
            $fileContents = preg_replace($pattern, '', $fileContents);
        }
        /*$cipher = bolt_encrypt('?> ' . $fileContents, $key);*/
        $cipher = bolt_encrypt($fileContents, $key);
        File::isDirectory(dirname("$destination/$filePath")) or File::makeDirectory(dirname("$destination/$filePath"), 0755, true, true);
        File::put(base_path("$destination/$filePath"), $prepend.$cipher);

        unset($cipher);
        unset($fileContents);
    }
}
