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

$query = "create procedure if not exists addRecipe(RecipeName varchar(250), Ingredient varchar(250), Quantity integer) ".
         "begin".
         "  insert into Recipes values(RecipeName,Ingredient,Quantity);".
         "end";

if(! $conn->query($query))
    die("Error creating procedure: " . $conn->error );

$stmt = $conn->prepare("call addRecipe(?,?,?)");
$stmt->bind_param("ssi", $RecipeName, $Ingredient, $Quantity);

$RecipeName = $_POST["RecipeName"];
$Ingredient = $_POST["Ingredient"];
$Quantity = $_POST["Quantity"];
$stmt->execute();

$conn->close();

header("Location: //127.0.0.1/createRecipeAndAddIngredient.html");
exit();
?>
