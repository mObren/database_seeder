<?php

use Database\Seeders\Seeder;
use Database\TablesCreator;

require_once "vendor/autoload.php";
require_once "Config/config.php";

ini_set('max_execution_time', '0');
ini_set('memory_limit', '4G');

$tables = new TablesCreator();
$tables->createTables();
$seeder = new Seeder();
$classes = [
'UsersExtract', 
'MoviesExtract', 
'TagsExtract',
'GenresExtract', 
'MoviesGenresExtract',
'LinksExtract', 
'ScoresExtract', 
'MoviesTagsExtract',
'RatingsExtract'
];

echo date("d/m/Y : H:i:s") . "\n";

foreach ($classes as $class) {
    echo "Seeding " . strtolower(strstr($class, "Ex", true)) .  " table... \n";
    $seeder->seed($class);
    echo "Table " . strtolower(strstr($class, "Ex", true)) . " seeded sucessfully. \n";
}
echo date("d/m/Y : H:i:s") . "\n";
