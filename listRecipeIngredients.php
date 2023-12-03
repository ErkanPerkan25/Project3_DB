<?php
session_start();

$host = $_SESSION["host"];
$user = $_SESSION["user"];
$password = $_SESSION["passw"];
$dbName = $_SESSION["dbName"];

$conn = new mysqli($host, $user, $password, $dbName);

if($conn->connect_error)
    die("Could not connect: ".mysqli_connect_error());

$query = "create procedure if not exists listRecipeIngredients(Recipe varchar(250)) ".
         "begin".
         "  select Ingredient, Quantity from Recipes where RecipeName=Recipe;".
         "end";

if(! $conn->query($query))
    die("Error creating procedure: " . $conn->error );

$stmt = $conn->prepare("call listRecipeIngredients(?)");
$stmt->bind_param("s", $Recipe);

$Recipe = $_POST["RecipeName"];
$stmt->execute();

$stmt->bind_result($iName, $Quantity);

echo "Ingredients for ".$Recipe;

echo "<table border=1>";
echo "<tr><th>Ingredient</th><th>Quantity</th></tr>";
while($stmt->fetch()){
    echo "<tr><td>".$iName."</td>".
             "<td>".$Quantity."</td></tr>";
}

echo "</table>";
echo "<a href='mainPage.html'>Press here to go back to the main page</a>";

$conn->close();

?>
