<?php
namespace Database\Extracts;

class MoviesExtract {


    protected $filePath = CSV_FILES . "movies.csv";
    public $tableName = "movies";
    public $columns = ['id', 'title', 'year'];
    public $batch = 5000;


    public function getFileContent() {
        return file($this->filePath);
    }

    public function total() {
        return count($this->getFileContent());
    }
    public function prepareData($from, $to, $file) {
            $portion = [];
            $args = [];
            $string = "(";
            //Create one portion for insertion
            for ($i = $from; $i <= $to; $i++) {
            $portion[] = trim(str_replace("'", "\'", "$file[$i]"));
            }
            //Convert row string into row array
            foreach ($portion as $row) {
                $row_array = explode(",", $row);
                //Check if there are more than one commas in movie ttile
                if ($row_array > 3) {
                    $subarray = []; //
                    $id = $row_array[0];
                    $title = '';
                    for ($i = 1; $i < count($row_array) - 1; $i++) {
                        $title.= $row_array[$i];
                    }
                    $a = preg_match('/["("]\d{4}[")"]/', $title, $matches);
                    if ($matches) {
                        $year =  str_replace(['(', ')'], '', $matches[0]);
                    }
                    else {
                        $year = 0;
                    }
                    $title = "'".preg_replace('/["("]\d.[^"]*/', '' , $title)."'"; //Removes year from title
                    $subarray[0] = $id;
                    $subarray[1] = $title;
                    $subarray[2] = $year;

                    $subarray = implode(',', $subarray);
                    $args[] = $subarray;
                } else {
                    $id = $row_array[0];
                    $a = preg_match('/["("]\d{4}[")"]/', $row_array[1], $matches);
                    if ($matches) {
                    $year =  str_replace(['(', ')'], '', $matches[0]); 
                    }
                    else {
                        $year = 0;
                    }
                    $title = "'".preg_replace('/["("]\d.[^"]*/', '' , $row_array[1])."'"; 
                    $subarray[0] = $id;
                    $subarray[1] = $title;
                    $subarray[2] = $year;
                    $subarray = implode(',', $subarray);
                    $args[] = $subarray;
                }
            }
            return $string .= implode("),(", $args) . ")";
    }
}