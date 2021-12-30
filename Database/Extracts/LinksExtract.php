<?php

class LinksExtract
{
    protected $filePath = "../../csv-files/links.csv";
    public $tableName = "links";
    public $columns = ['movie_id', 'imdb_id', 'tmdb_id'];
    public $batch = 50000;



    public function getFileContent() {
        return file($this->filePath);
    }
    public function total() {
        return count($this->getFileContent());
    }


    public function prepareData($from, $to, $file) {
        $args = [];
        $string = '';
        for ($i = $from; $i <= $to; $i++) {
            list($movieId, $imdbId, $tmdbId) = explode(",", $file[$i]);
            $string .= "($movieId, '$imdbId', '$tmdbId'),";
        }
        $string = rtrim($string, ",");
        return $string .= implode("),(", $args);
    }

}




