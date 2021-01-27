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
                    <p>After you've submit a new recipe, the website runs a php file that performs the same error checks as when adding a new ingredient, and bounces you back to the Add new Recipe page if any errors are detected.  If there are no errors, the php file first uses a prepared statement to input the recipe's name into the names table.  It then querries that table to find the Primary ID Key of the newly created row, and saves that number as a variable to insert as the Recipe ID for all the ingredients and steps for the new recipe.  Since I don't know in advance how many ingredients will be input with each recipe, I needed to ensure that the php doesn't leavy and ingredients out, or input empty data for ingredients that don't exist.  I again created a currentIngredient variable, and used that run a loop that starts by searching the $_POST superglobal for the next ingredient to input.  On the first loop, it searches $_POST for an array key called "i1-name" and if that exists, it then saves the values of "i1-name", "i1-quantity", and "i1-units" from $_POST to variables, inputs those variables into a prepared SQL statement, and then updates the table with all the information for the new ingredient.  The loop then increments the currentIngredent variable by 1, and starts again by searching $_POST for an array key named "i2-name".  The loop continues to run until after the last ingredient is input, it can't find an array key for an ingredient that doesn't exist.  For example, if a recipe has 4 ingredients, after four loops, it will search for "i5-name" and when it can't find it, it will end the loop, close the prepared statement, and move on to the recipe steps.  The next section uses the same process to loop through all the steps and then end once the last step has been input.  After the entire process is complete, we have a whole new recipe, safely and correctly input into three different tables.  On this page, I run a SQL query to find the names of all our recipes, and display them in alphabetical order.  I used a PHP echo statment to print the name of each recipe as a link to one common recipe page, with that recipe's name saved as a $_GET variable in the URL.  Please click on any recipe you'd like to continue.</p>
                    </div>
                </div>
        </div>
<h2>Our Recipes</h2>
    
<ul>
<?php
include_once 'dbh.php';
echo "<br>";
$sql = "SELECT * FROM recipe_names ORDER BY recipe_name;";
$result = mysqli_query($connection, $sql);
while ($row = mysqli_fetch_assoc($result)){
    echo "<li><a href='recipe.php?recipe=" . $row["recipe_name"] . "'>" . $row["recipe_name"] . "</a></li>";
}
?>
</ul>
<br>

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
</script>    
    
    
</body>

</html>
