<?php

define('DB_HOST','127.0.0.1');
define('DB_NAME','inline');
define('DB_USER','root');
define('DB_PASS','');

try {
    $db = new PDO(
        'mysql:host=' . DB_HOST,
        DB_USER,
        DB_PASS,[
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
}
catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}