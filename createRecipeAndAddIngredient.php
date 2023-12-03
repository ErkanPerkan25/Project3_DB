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

$query1 = "create procedure if not exists addRecipe(IN RecipeName varchar(250),IN Ingredient varchar(250),IN Quantity integer) ".
         "begin".
         "  insert into Recipes values(RecipeName,Ingredient,Quantity);".
         "end;";

if(! $conn->query($query1))
    die("Error creating procedure: " . $conn->error );

$stmt = $conn->prepare("call addRecipe(?,?,?)");
$stmt->bind_param("ssi", $RecipeName, $Ingredient, $Quantity);

$RecipeName = $_POST["RecipeName"];
$Ingredient = $_POST["Ingredient"];
$Quantity = $_POST["Quantity"];
$stmt->execute();

$conn->close();

header("Location: createRecipeAndAddIngredient.html");
exit();
?>
