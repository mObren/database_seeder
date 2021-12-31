<?php
namespace Database\Extracts;

class RatingsExtract {


    protected $filePath = CSV_FILES . "ratings.csv";
    public $tableName = "ratings";
    public $columns = ['user_id', 'movie_id', 'rating', "timestamp"];
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
            ////
            list($userId, $movieId, $rating, $created) = explode(",", $file[$i]);
            $created = date("Y-m-d H:i:s", $created);
            $string .= "($userId, $movieId, $rating, '$created'),";
        }
        $string = rtrim($string, ",");
        return $string .= implode("),(", $args);
        }
}
