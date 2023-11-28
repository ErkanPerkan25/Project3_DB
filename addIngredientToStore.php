<?php
session_start();

$host = $_SESSION["host"];
$user = $_SESSION["user"];
$password = $_SESSION["passw"];
$dbName = $_SESSION["dbName"];

$conn = new mysqli($host, $user, $password, $dbName);

if($conn->connect_error)
    die("Could not connect: ".mysqli_connect_error());
else
    echo" connected <br>";

$query1 = "create procedure if not exists addIngredient(Ingredient varchar(250), Quantity integer) ".
         "begin".
         "  insert into Inventory values(Ingredient,Quantity);".
         "end";

if(! $conn->query($query1))
    die("Error creating procedure: " . $conn->error );

$stmt = $conn->prepare("call addIngredient(?,?)");
$stmt->bind_param("si", $Ingredient, $Quantity);

$Ingredient = $_POST["Ingredient"];
$Quantity = $_POST["Quantity"];
$stmt->execute();

$conn->close();
?>
