<?php
require_once '../../vendor/autoload.php';

class UsersExtract
{

    protected $filePath = "../../csv-files/ratings.csv";
    public $tableName = "users";
    public $columns = ['id', 'name', 'gender', 'bio', 'email', 'password', 'age', 'avatar'];
    public $batch = 200000;
    

       public function getFileContent() {

        $fileHandle = fopen($this->filePath, "r");
        $ratings = [];
        while(!feof($fileHandle)) {
            $ratings[] = fgets($fileHandle);
        }
        fclose($fileHandle);
        return $ratings;
    }

    public function total() {
        return count($this->getFileContent());
    }

    public function prepareData($from, $to, $file) {
        $args = [];
        $string = '';
        $userIds = [];
        for ($i = $from; $i <= $to; $i++) {
                if (strstr($file[$i], ',', true) != (strstr($file[$i-1], ',', true))) {
                    $userIds[] = strstr($file[$i], ',', true);
                }
        }
            $genders = ['m', 'f', 'x'];
            $faker = Faker\Factory::create();

            foreach ($userIds as $id) {
                if (!empty($id)) {
                    $string.= "(" . $id. ','
                    . "'" . addslashes($faker->name) . "'" .
                    "," . "'" .$genders[rand(0 , 2)] . "'" .
                    ',' . "'Hello.'" .
                    ',' . "'$faker->email'" . ',' .
                    "'2224444'" .
                    ',' . rand(7, 115) . ','
                    . "'" . "banana" . "'),";
                }
              

            }
        $string = rtrim($string, ",");
        return $string .= implode("),(", $args);
    }

}