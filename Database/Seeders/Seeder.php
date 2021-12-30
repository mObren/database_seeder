<?php
require_once '../../Config/Database.php';
require_once '../Extracts/MoviesExtract.php';
require_once '../Extracts/RatingsExtract.php';
require_once '../Extracts/TagsExtract.php';
require_once '../Extracts/GenresExtract.php';
require_once '../Extracts/UsersExtract.php';
require_once '../Extracts/MoviesGenresExtract.php';
require_once '../Extracts/MoviesTagsExtract.php';
require_once '../Extracts/LinksExtract.php';
require_once '../Extracts/ScoresExtract.php';
require_once '../create-tables.php';

class Seeder {
    protected function loadClass($className) {
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

ini_set('max_execution_time', '0');

$seeder = new Seeder();

$classes = [
'UsersExtract', 
'MoviesExtract', 
'TagsExtract',
'GenresExtract', 
'MoviesGenresExtract',
'LinksExtract', 
'ScoresExtract', 
'MoviesTagsExtract',
'RatingsExtract'
];

echo date("d/m/Y : H:i:s") . "\n";

foreach ($classes as $class) {

    echo "Seeding " . strtolower(strstr($class, "Ex", true)) .  " table... \n";
    $seeder->seed($class);
    echo "Table " . strtolower(strstr($class, "Ex", true)) . " seeded sucessfully. \n";
}
echo date("d/m/Y : H:i:s") . "\n";
