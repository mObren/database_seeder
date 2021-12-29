<?php

require_once 'vendor/autoload.php';
require_once 'database.php';

$ratings = file('csv-files/ratings.csv');
$userIds = [];
$userIds[] = strstr($ratings[1], ',', true);
for ($i = 2; $i < count($ratings); $i++) {
    if (strstr($ratings[$i], ',', true) != (strstr($ratings[$i-1], ',', true))) {
        $userIds[] = strstr($ratings[$i], ',', true);
    }
}
function seed() {
    $string = '';
    $db = new Database;
    $genders = ['m', 'f', 'x'];
    $faker = Faker\Factory::create();


    global $userIds;

   foreach ($userIds as $id) {
    $string.= "(" . $id. ',' 
        . "'" . addslashes($faker->name) . "'" . 
        "," . "'" .$genders[rand(0 , 2)] . "'" .
        ',' . "'Hello.'" .
         ',' . "'$faker->email'" . ',' . 
        "'2224444'" . 
        ',' . rand(7, 115) . ',' 
        . "'" . "banana" . "'),";
        
    }
    $string = rtrim($string, ',');
    $sql = "INSERT INTO users(id, name, gender, bio, email, password, age, avatar) VALUES" . $string;
        $db->write($sql);
    }

    
    seed();
