<?php
require_once "GenresExtract.php";

class MoviesGenresExtract
{
    protected $filePath = "../../csv-files/movies.csv";
    public $tableName = "movies_genres";
    public $columns = ['movie_id', 'genre_id'];
    public $batch = 5000;

    public function getFileContent() {
        return file($this->filePath);
    }

    public function total() {
        return count($this->getFileContent());
    }

    function prepareData($from, $to, $data = null) {
        $file = $this->getFileContent();
        $helper = new GenresExtract;
        $genres = $helper->createGenres();
        array_shift($genres);
        $string = '';
        foreach ($genres as $key => $genre) {
            for($i = $from; $i<=$to; $i++) {
                if (str_contains($file[$i], $genre)) {
                    $string.= "(".strstr($file[$i], ',', true) . ',' . $key + 1 ."),";
                }
        }
        }
        return $string = rtrim($string, ',');
    }
}
