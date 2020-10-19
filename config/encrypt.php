<?php

return [
    'source'      => ['app'], // Path(s) to encrypt
    'destination' => 'encrypted', // Destination path
    'key_length'  => 6, // Encryption key length
    'zip_filename'  => 'folders.zip', // zip filename
    'zipped_destination'  => '/home/blessedkono/encrypted/folders.zip', // zip filename
    'extract_destination'  => '/home/blessedkono/next_task/', // destination for extract zipped encrypted files
    'sync_source'  => '/var/www/html/next_task/', // clean code  directory for sync with the encrypted folder
];
