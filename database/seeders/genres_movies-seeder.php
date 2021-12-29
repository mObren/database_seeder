<?php

$file = file("../csv-files/movies.csv");

require '../database.php';

$db = new Database;
function createGenres(){
    global $file;
    $arr=[];
    for($i=1; $i<count($file);$i++){
        $splited=explode(",", $file[$i]);
    array_push($arr,end($splited));
    }
    $arrgenres=[];
    $arrgenres[] = "genre";
    foreach($arr as $genres){
      $onecolumn=explode("|", $genres);
        foreach($onecolumn as $genre){

            if (!in_array(rtrim($genre), $arrgenres)) {
            $arrgenres[] = rtrim($genre);
            }
        }

    }
    return $arrgenres;
}


function seed() {
    global $file;
    $genres = createGenres();
    $db = new Database;
    $bingo = [];
    $bingo[0] = "skip";
    $string = '';
    foreach ($genres as $key => $genre) {
        if ($key > 0) {
            foreach($file as $row) {
                if (str_contains($row, $genre)) {
                    $string.= "(".strstr($row, ',', true) . ',' .$key ."),";
                   
                }
            }
        }
    }
    $string = rtrim($string, ',');
    $sql = 'INSERT INTO movies_genres(movie_id, genre_id) VALUES' . $string;
    $db->write($sql); 
}
seed();






