<?php
namespace Database\Seeders;
use Database\Database;

class Seeder {

    public function __construct()
    {
        
    }
    protected function loadClass($className) {
        $className = "Database\Extracts\\" . $className;
        return new $className;
    }
    public function seed($className) {
        $db = new Database;
        $factory = $this->loadClass($className);
        $total = $factory->total();
        $data = $factory->getFileContent();
        $round = $factory->batch;
        $increaser = $factory->batch;
        $i = 1;

        while($total >= $round) {
            $sql = "INSERT INTO " . $factory->tableName . "(" . implode(",",$factory->columns) . ") VALUES" . $factory->prepareData($i, $round, $data);
            $i += $increaser;
            $round += $increaser;      
            $db->write($sql);

            if ($total < $round && !empty($factory->prepareData($i, $total - 1, $data))) {
                $sql = "INSERT INTO " . $factory->tableName . "(" . implode(",",$factory->columns) . ") VALUES" . $factory->prepareData($i, $total-1, $data);
                $db->write($sql);
            }
        }
    }
}

