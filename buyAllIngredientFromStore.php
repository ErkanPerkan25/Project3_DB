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

$query = "create procedure if not exists buyIngredients(Recipe varchar(250)) ".
         "begin".
         " update Inventory set Inventory.Quantity = Inventory.Quantity - 1 where Inventory.Ingredient = Recipes.Ingredient;".
         "end";

if(! $conn->query($query))
    die("Error creating procedure: " . $conn->error );

$stmt = $conn->prepare("call buyIngredients(?)");
$stmt->bind_param("s", $RecipeName);

$Recipe = $_POST["RecipeName"];
$stmt->execute();

echo "<a href='mainPage.html'>Press here to go back to the main page</a>";

$conn->close();

?>
