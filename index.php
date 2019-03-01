<?php
/*
 *
 * The first part handles application logic.
 *
 */

include("config.php");
$server   = $_SERVER['SERVER_ADDR'];
$db = open_db_connection($db_hostname, $db_port, $db_database, $db_username, $db_password);

// Simulate latency 

if (isset($_GET['count']))
{
        $count = $_GET['count'];
}
else
{
        $count = 10;
}

function open_db_connection($hostname, $port, $database, $username, $password)
{
        // Open a connection to the database
        $db = new PDO("mysql:host=$hostname;port=$port;dbname=$database;charset=utf8", $username, $password);
        return $db;
}

function open_memcache_connection($hostname)
{
        // Open a connection to the memcache server
        $mem = new Memcached();
        $mem->addServer($hostname, 11211);
        return $mem;
}

function retrieve_employees ($db, $count)
{
        // Print a message so that the user knows these records come from the DB.
        // Geting the latest records from the upload_images table
        $sql = "SELECT * FROM employees ORDER BY RAND() LIMIT $count";
        $statement = $db->prepare($sql);
        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
}


?>

<?php
/*
 *
 * The second part handles user interface.
 *
 */
header('Content-Type: application/json');

// Get the most recent N images
if ($enable_cache)
{
        // Attemp to get the cached records for the front page
        $mem = open_memcache_connection($cache_server);
        $images = $mem->get("front_page");
        if (!$images)
        {
                // If there is no such cached record, get it from the database
                $images = retrieve_employees($db, 10);
                // Then put the record into cache
                $mem->set("front_page", $images, time()+86400);
        }
}
else
{
        // This statement get the last 10 records from the database
        $emps = retrieve_employees($db, $count);
}

if ($storage_option == "hd")
{
        echo json_encode($emps);
        // Images are on hard disk
}
$session_id = session_id();
?>
