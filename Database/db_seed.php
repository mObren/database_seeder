<?php


require "../vendor/autoload.php";
use Database\Seeders\Seeder;


ini_set('max_execution_time', '0');

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
