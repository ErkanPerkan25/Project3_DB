<?php
session_start();

$host = $_POST["host"];
$user = $_POST["user"];
$password = $_POST["password"];
$dbName = $_POST["dbName"];

$_SESSION["host"] = $_POST["host"];
$_SESSION["user"] = $_POST["user"];
$_SESSION["passw"] = $_POST["password"];
$_SESSION["dbName"] = $_POST["dbName"];

echo "Attempting to connect to DB server: $host ...";
$conn = new mysqli($host, $user, $password, $dbName);

if($conn->connect_error)
    die("Could not connect: ".mysqli_connect_error());
else
    echo" connected <br>";

// create table if not exits
$queryString = "create table if not exists Recipes".
          " (RecipeName varchar(250), Ingredient varchar(250), Quantity integer)";

$query2 = "create table if not exists Inventory".
          " (Ingredient varchar(250), Quantity integer)";

if(! $conn->query($queryString))
    die("Error creating table: " . $conn->error );

if(! $conn->query($query2))
    die("Error creating table: " . $conn->error );

$conn->close();

header("Location: //127.0.0.1/mainPage.html");
exit();

?>
