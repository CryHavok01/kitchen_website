<!doctype html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
<meta charset="utf-8">
<title>J&S Kitchen</title>
</head>

<body>
    <div class="main">
        <div class="header">
            <h1 id="kitchen-header">Josh and Shanhu's Kitchen</h1>
            <div class="how_it_works">
                <div class="works_button">
                    <button id="works_but" type="button">How it Works</button>
                </div>
                <div class="explainer">
                    <p>The key to my plan for this website was the ability to check the ingredients from a recipe against the ingredients we own, and this is where I figured out how to make that happen.  When this page loads, it finds the recipe name saved in the $_GET superglobal, and uses that to query the recipe names table and find the ID Key for that recipe.  It then uses the ID Key to find all the ingredients associated with that recipe from the recipe ingredients table, and echo them out as a list.  For each entry in the list, the page takes the name of the ingredient and searched the table of ingredients we own to see if there's a match.  If that ingredient is on the table, the page echoes a statement saying that we don't have that particular ingredient, or it hasn't been entered into the ingredients list.  If we do have the ingredient, the page then checks the units used in the recipe and the units in owned ingredients table.  In order to correctly compare the amounts, the units need to be one of the default measurements, ie. Cups, Teasepoons, Tablespoons, or Ounces.  If both recipe's units and the ingredients table's units are both of one those defaults, then the page does some simple arithmetic to compare them.  Both units are converted into Teaspoons, since all of the measurements can be evenly divided by Teaspoons, then the amount of the ingredient needed for the recipe is subtracted from the amount we own.  If the remaining amount is greater than 5 teaspoons (since our measurements might not always be 100% accurate), then the page echoes a green colored message that we should have enough of that ingredient.  If the remainder is between -5 and 5, then it shows a yellow message that we might not have enough, and we should check before making the recipe.  If there is less than -5 teaspoons left, then we definitely don't have enough, and the page displays a message in red saying we need to buy more.  Since we allow the user to add "other" units when inputting ingredients or recipes, the page also checks if the units aren't one of the defaults, but are the same in both the recipe and the ingredients table.  If they are the same, for example if a recipe calls for two cloves of garlic, and we own 12 cloves, then the page does the same subtraciton and lets us know if we have enough.  Otherwise, if one or both of the units are something other than the default we can't know the exact measurements, so the page shows a message saying that it isn't sure if we have enough, and that you should check before cooking.  This page also includes a delete button that uses JQuery to show a warning before giving you the option to fully delete the recipe.  There is an Update button that links to a another page where you can update the details of the recipe, and a Make Recipe button.  For the next part of the tour, please click on Update.</p>
                    </div>
                </div>
        </div>

<?php
include_once 'dbh.php';
$recipe = $_GET['recipe'];
echo "<h2>" . $recipe . "</h2>";
$sql = "SELECT * FROM recipe_names WHERE recipe_name = '$recipe';";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);
$recipe_id = $row['recipe_id'];
?>

<h3>Ingredients</h3>
<ol>
<?php
$ingNames = [];
$ingQuants = [];
$ingUnits = [];
$ingSql = "SELECT * FROM recipe_ingredients WHERE recipe_id = '$recipe_id';";
$result = mysqli_query($connection, $ingSql);
$curIng = 1;
while ($row = mysqli_fetch_assoc($result)){
    echo "<li>" . ($row['ingredient_quantity'] + 0) . " " . $row['ingredient_units'] . " of " . $row['ingredient_name'] . "</li>";
    $recIngName = $row['ingredient_name'];
    array_push($ingNames, $row["ingredient_name"]);
    array_push($ingQuants, $row["ingredient_quantity"]);
    array_push($ingUnits, $row["ingredient_units"]);
    
    $ingDivisor = FALSE;
    $cabDivisor = FALSE;
    $convertSql = "SELECT * FROM spices WHERE spice_name = '$recIngName'";
    $cabResult = mysqli_query($connection, $convertSql);
    if ($cabResult->num_rows > 0) {
        $cabinet = mysqli_fetch_assoc($cabResult);
        $ingOther = $row['ingredient_units'];
        $cabOther = $cabinet['spice_units'];
        if ($row['ingredient_units'] === "Cup(s)"){
            $ingDivisor = $row['ingredient_quantity'] * 48;
        } else if ($row['ingredient_units'] === "Ounce(s)"){
            $ingDivisor = $row['ingredient_quantity'] * 6;
        } else if ($row['ingredient_units'] === "Tablespoon(s)"){
            $ingDivisor = $row['ingredient_quantity'] * 3;
        } else if ($row['ingredient_units'] === "Teaspoon(s)"){
            $ingDivisor = $row['ingredient_quantity'];
        } else if ($ingOther === $cabOther) {
            $ingDivisor = $row['ingredient_quantity'];
        } else {
            echo "<div class='ing_maybe'>I'm not sure how much of this ingredient you have.  Go check your cabinet!</div><br>";
        };
        if ($ingDivisor){
            if ($cabinet['spice_units'] === "Cup(s)"){
                $cabDivisor = $cabinet['spice_quant'] * 48;
            } else if ($cabinet['spice_units'] === "Ounce(s)"){
                $cabDivisor = $cabinet['spice_quant'] * 6;
            } else if ($cabinet['spice_units'] === "Tablespoon(s)"){
                $cabDivisor = $cabinet['spice_quant'] * 3;
            } else if ($cabinet['spice_units'] === "Teaspoon(s)"){
                $cabDivisor = $cabinet['spice_quant'];
            } else if ($ingOther === $cabOther) {
                $cabDivisor = $cabinet['spice_quant'];
            } else {
                echo "<div class='ing_maybe'>I'm not sure how much of this ingredient you have.  Go check your cabinet!</div><br>";
            };
        };
        if ($ingDivisor && $cabDivisor){
            $remaining = $cabDivisor - $ingDivisor;
            if ($remaining > 5){
                echo "<div class='ing_yes'>You should have enough of this ingredient!</div><br>";
            } else if ($remaining <= 5 && $remaining > 0) {
                echo "<div class='ing_maybe'>You might not have enough of this ingredient.  Go check your cabinet!</div><br>";
            } else if ($remaining <= 0){
                echo "<div class='ing_no'>You don't have enough of this ingredient.  Time to go shopping!</div><br>";
            };
        }
    } else {
        echo "<div class='ing_maybe'>You don't have this ingredient, or haven't entered it into your Ingredients List.  Go check your cabinet!</div><br>";
    }
};
?>
</ol>

<h3>Instructions</h3>
<ol>
<?php
$stepSql = "SELECT * FROM recipe_steps WHERE recipe_id = '$recipe_id';";
$result = mysqli_query($connection, $stepSql);
while ($row = mysqli_fetch_assoc($result)){
    echo "<li>" . $row['step'] . "</li><br>";
}
?>
</ol>

<form action='make_recipe.php' method='POST'>
    <?php
        echo "<input type='hidden' name='recipe_id' value='" . $recipe_id . "'>";
        $length = count($ingNames);
        for ($i = 0; $i < $length; $i++){
            echo "<input type='hidden' name='i" . $i . "-name' value='" . $ingNames[$i] . "'>";
            echo "<input type='hidden' name='i" . $i . "-quant' value='" . $ingQuants[$i] . "'>";
            echo "<input type='hidden' name='i" . $i . "-unit' value='" . $ingUnits[$i] . "'>";
        };
    ?>
    <div id="make-warning">This will subtract the ingredients for this recipe from your Ingredient List.  Are you sure?<br>
    <button type='submit'>Let's get cooking!</button></div>
</form>
<button id="make-button">Make this recipe!</button><br>

<div id="warning">
    <h3>Warning!</h3>
    <p>Are you SURE you want to delete this recipe?</p>
    <form id="rec_delete" action="recipe_delete.php" method="POST">
    <br>
    <?php
    echo "<input type='hidden' name='recipe_id' value='" . $recipe_id . "'>";
    ?>
    <button type="submit" id="confirm_delete">Delete for Real!</button>
    <button type="button" id="cancel_delete">Cancel</button>
    </form>
</div>

<br><br>
<?php
    echo "<a href='recipe_update.php?recipe_id=" . $recipe_id . "'><button type='button' id='update'>Update</button></a>";
?>
<button type="button" id="delete">Delete</button>
<br><br>

</div>
<div class="links">
    <button type="button" id="nav_but">Navigation</button>
    <div class="nav_bar">
        <button type="button" id="home" onclick="window.location.href='index.html';">Home</button>
        <button type="button" id="check-spices" onclick="window.location.href='checkspice.php';">Check Spices</button>
        <button type="button" id="add-spice" onclick="window.location.href='addspice.php';">Add Spice</button>
        <button type="button" id="check-recipe" onclick="window.location.href='checkrecipe.php';">Look up Recipes</button>
        <button type="button" id="add-recipe" onclick="window.location.href='addrecipe.php';">Add new Recipe</button>
    </div>
</div>    
    
<script src="jquery-3.5.1.min.js"></script>
<script>

    //How It Works Section
            
    let worksOn = false;
    let expHeight = 0;
    let expWidth = 0;
            
    $("#works_but").on("click", () => {
        if (worksOn) {
            $(".explainer").animate({
                height: "0",
                width: "0",
                marginLeft: "100%"
            }, () => {
                $(".explainer").css("display", "none")
            });
            $("#works_but").html("How it Works")
            worksOn = false;
        } else {
            $(".explainer").css("display", "block")
            if (!expHeight && !expWidth) {
                expHeight = $(".explainer").height();
                expWidth = $(".explainer").width();
            }
            $(".explainer").css("height", "0");
            $(".explainer").css("width", "0");
            $(".explainer").css("margin-left", "100%");
            $(".explainer").animate({
                height: expHeight, 
                width: expWidth,
                marginLeft: "0"
            })
            $("#works_but").html("Hide")
            worksOn = true;
        }
    })
    
//navigation bar
    let navOn = false;
    let height = 0;
    $("#nav_but").on("click", () => {
        if (navOn) {
            $(".nav_bar").animate({height: "0"}, () => {
                $(".nav_bar").css("display", "none")
            })
            $("#nav_but").html("Navigation")
            navOn = false;
        } else {
            $(".nav_bar").css("display", "block")
            if (!height) {
                height = $(".nav_bar").height();
            }
            $(".nav_bar").css("height", "0")
            $(".nav_bar").animate({height: height})
            $("#nav_but").html("Hide")
            navOn = true;
        }
    })

//errors, buttons
    $('#warning').hide();
    $('#make-warning').hide();
    $('#make-button').on("click", function(){
        $('#make-button').hide();
        $('#make-warning').show("fast");
    });
    $('#update').on("click", function(){
    });
    $('#delete').on('click', function(){
        $('#warning').show("fast");
        $('#delete').hide();
        $('#make-button').hide();
        $('#make-warning').hide();

    });
    $('#cancel_delete').on('click', function(){
        $('#warning').hide("fast");
        $('#delete').show();
        $('#make-button').show();

    });
</script>    
    
</body>

</html>
