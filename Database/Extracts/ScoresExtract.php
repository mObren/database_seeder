<?php

namespace Database\Extracts;

class ScoresExtract
{
    protected $filePath = CSV_FILES . "genome-scores.csv";
    public $tableName = "scores";
    public $columns = ['movie_id', 'tag_id', 'relevance'];
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
            list($movieId, $tagId, $relevance) = explode(",", $file[$i]);
            $string .= "($movieId, $tagId, $relevance),";
        }
        $string = rtrim($string, ",");
        return $string .= implode("),(", $args);
    }

}
