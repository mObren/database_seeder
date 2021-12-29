<?php

class GenresExtract {


    protected $filePath = "../../csv-files/movies.csv";
    public $tableName = "genres";
    public $columns = ['name'];
    public $batch = 10;


    public function getFileContent() {
        return file($this->filePath);
    }



        public function prepareData($from, $to) {
            $genres = $this->createGenres();
            $string = '(';
            //$strsql;
            for ($i = $from; $i <= $to; $i++) {
                $string .= "'" . $genres[$i] . "'),(";
            }
            $string = rtrim($string, ",(,");
            return $string;

        }

        public function total() {
            return count($this->createGenres());
        }

        function createGenres() {
                $file = $this->getFileContent();
                $arr=[];
                for($i=1; $i<count($file);$i++){
                    $splited=explode(",", $file[$i]);
                    array_push($arr,end($splited));
                }
                $arrgenres=[];
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



}
     //   $string .=  "'" . implode("'),('", $arrgenres) . "')";
