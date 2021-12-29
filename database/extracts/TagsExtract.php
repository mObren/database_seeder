<?php

class TagsExtract {


    protected $filePath = "../../csv-files/genome-tags.csv";
    public $tableName = "tags";
    public $columns = ['id', 'tag'];
    public $batch = 500;


    public function getFileContent() {
        return file($this->filePath);
    }
    public function total() {
        return count($this->getFileContent());
    }


    public function prepareData($from, $to) {
        $file = $this->getFileContent();
        $string = '';
        for ($i = $from; $i <= $to; $i++) {
            ////
            list($id, $tag) = explode(",", $file[$i]);
            $tag = addslashes($tag);
            $string .= "($id, '$tag'),";
        }
        $string = rtrim($string, ",");
        return $string;
        }

}
