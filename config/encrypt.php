<?php

return [
    'source'      => ['app', 'database', 'routes'], // Path(s) to encrypt
    'destination' => 'encrypted', // Destination path
    'key_length'  => 6, // Encryption key length
    'zip_filename'  => 'folders.zip', // zip filename
    'zipped_destination'  => '/home/blessedkono/encrypted/folders.zip', // zip filename
    'extract_destination'  => '/home/blessedkono/encrypted/', // zip filename

];
