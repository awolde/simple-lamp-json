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
        $sql = "SELECT * FROM employees ORDER BY RAND() LIMIT $count";
        if ($statement = $db->prepare($sql)) {
                $statement->execute();
                $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($rows);
        }
} catch(PDOException $e) {
            echo $e->getMessage();
            return null;
}
?>
