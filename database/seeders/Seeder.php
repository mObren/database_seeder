<?php

require_once '../../config/database.php';
require_once '../extracts/MoviesExtract.php';
require_once '../extracts/RatingsExtract.php';
require_once '../extracts/TagsExtract.php';
require_once '../extracts/GenresExtract.php';




class Seeder {
    
    protected function loadClass($className) {
        return new $className;
    }
    public function seed($className) {
        $db = new Database;
        $factory = $this->loadClass($className);
        $total = $factory->total();
        $round = $factory->batch;
        $increaser = $factory->batch;
        $i = 1;
        while($total > $round) {
            $sql = "INSERT INTO " . $factory->tableName . "(" . implode(",",$factory->columns) . ") VALUES" . $factory->prepareData($i, $round);
            echo $sql;
            $db->write($sql);
            $i += $increaser;
            $round += $increaser;            
            if ($total <= $round) {
                 $sql = "INSERT INTO " . $factory->tableName . "(" . implode(",",$factory->columns) . ") VALUES" . $factory->prepareData($i, $total-1);
                echo $sql;
            $db->write($sql);
            }
        }
    }
}


$seeder = new Seeder();
$seeder->seed('TagsExtract');