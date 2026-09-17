<?php

// Import the supplied SQL only on the first deployment. Existing data is retained.
$path = getenv('DB_DATABASE') ?: '/var/lib/tet/database.sqlite';
if (is_file($path) && filesize($path) > 0) {
    exit(0);
}
$temporary = $path . '.initializing';
$database = new PDO('sqlite:' . $temporary);
$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$database->exec(file_get_contents(__DIR__ . '/../sql/database.sqlite.sql'));
if ($database->query('PRAGMA integrity_check')->fetchColumn() !== 'ok') {
    throw new RuntimeException('Imported database failed its integrity check.');
}
$database = null;
rename($temporary, $path);
echo "Imported the supplied SQLite database.\n";
