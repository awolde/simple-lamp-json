<?php
header('Content-Type: application/json');
include("config.php");

if (isset($_GET['count']))
{
        $count = $_GET['count'];
}
else
{
        $count = 10;
}

try {
        $db = new PDO("mysql:host=$db_hostname;port=$db_port;dbname=$db_database;charset=utf8", $db_username, $db_password);
        $id = rand(10002,499999);
        $max = 499999-$count;
        #$sql = "SELECT * FROM employees ORDER BY RAND() LIMIT $count";
        $sql = "SELECT * FROM employees WHERE emp_no BETWEEN $id AND $max LIMIT $count";
        if ($statement = $db->prepare($sql)) {
                $statement->execute();
                $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
                $arr = array(
                  "server_ip" => $_SERVER['SERVER_ADDR'],
                  "server_port" => $_SERVER['SERVER_PORT']
                );
                echo json_encode(array_merge($arr, $rows));
        }
} catch(PDOException $e) {
            echo $e->getMessage();
            return null;
}
?>
