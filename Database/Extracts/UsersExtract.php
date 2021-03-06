<?php
namespace Database\Extracts;
use Faker\Factory;
class UsersExtract
{

    protected $filePath = CSV_FILES . "ratings.csv";
    public $tableName = "users";
    public $columns = ['id', 'name', 'gender', 'bio', 'email', 'password', 'age', 'avatar'];
    public $batch = 30000;
    
    public function getFileContent() {
        return file($this->filePath);
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
            $faker = Factory::create();

            foreach ($userIds as $id) {
                if (!empty($id)) {
                    $string.= "(" . $id. ','
                    . "'" . addslashes($faker->name) . "'" .
                    "," . "'" .$genders[rand(0 , 2)] . "'" .
                    ',' . "'Hello.'" .
                    ',' . "'$faker->email'" . ',' .
                    "'" . bin2hex(random_bytes(20)) ."'" .
                    ',' . rand(7, 115) . ','
                    . "'" . "image" . "'),";
                }
            }
        $string = rtrim($string, ",");
        return $string .= implode("),(", $args);
    }

}
