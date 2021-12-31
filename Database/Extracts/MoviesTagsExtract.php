<?php
namespace Database\Extracts;

class MoviesTagsExtract
{
    protected $filePath = CSV_FILES . "tags.csv";
    public $tableName = "movies_tags";
    public $columns = ['user_id','movie_id','tag'];
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
            list($userId,$movieId, $tag) = explode(",", $file[$i]);
            $tag=addslashes($tag);
            $string .= "($userId, $movieId, '$tag'),";
        }
        $string = rtrim($string, ",");
        return $string .= implode("),(", $args);
    }

}
