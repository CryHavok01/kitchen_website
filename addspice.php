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
                    <p>In order to build this website, I needed to learn about all about databases as well as PHP to manipulate data on the server side, and SQL to communicate directly with the databases.  I used the phpMyAdmin interface to create the first and simplest table, and you can add data to it here.  The table contains columns for ingredient names, units, and quantities, as well as a Primary Key, and this form allows you to enter all that information for a new ingredient.  The name input is obviously text, the quantity is a number input with up to two decimal places, and the units are a radio dial with a text option for Other.  I chose to use a radio dial because later on the website will use simple arithmetic to compare measurements, and this way I can know for sure what the correct units and conversions are, without having to worry if the user misspelled, capitalized, or pluralized the unit name.  When you submit the form, the website runs an insert php file that immediately runs two error checks.  It first checks to see if there is already an ingredient with the same name in the ingredients table (after formatting the name by capitalizing the first letter of the name, and lowercasing all other letters, to ensure there aren't multiple copies of the same ingredient only with different capitalizaion).  Second, it checks the $_POST superglobal variable to see if there are values for name, quantity, and units.  If the unit value is "other", then it also checks to see if there is a value recieved from the Other text input.  If the name of the ingredient is a duplicate, or if there is missing information, it sends you right back to this page with an error variable in the URL.  When this page loads, it first checks the $_GET superglobal for an error variable, and displays a message telling you what you did wrong based on the error found by the insert PHP.  If there are no errors, a MySQL prepared statement is used to safely insert the data into the table.  To continue learning how this site works, please visit Check Spices next.</p>
                    </div>
                </div>
        </div>
        <h2>Add New Spice</h2>
<?php
    if (array_key_exists('error', $_GET)){
        if ($_GET['error'] === "copy"){
            echo "<h3>An Ingredient with that name already exists!  Please use a different name, or update that Ingredient.</h3>";
        } else if ($_GET['error'] === "missing"){
            echo "<h3>You left something blank!  Make sure you fill out all fields and select Units.</h3>";
        }
    } else {
        echo "<h3>Please fill out all fields and Units</h3>";
    };
    ?>
<form action="spice_insert.php" method="POST">
    <input type="text" name="spice_name" placeholder="Name" autocomplete="off">
    <br>
    <input type="number" step="0.01" name="spice_quant" placeholder="Quantity" autocomplete="off">
    <br>
    <label for="spice_units">Units: </label>
        <input type="radio" name="spice_units" value="Teaspoon(s)">Teaspoon(s)<br>
        <input type="radio" name="spice_units" value="Tablespoon(s)">Tablespoon(s)<br>
        <input type="radio" name="spice_units" value="Ounce(s)">Ounce(s)<br>
        <input type="radio" name="spice_units" value="Cup(s)">Cup(s)<br>
        <input type="radio" name="spice_units" value="other">Other <input type="text" name="other_units" autocomplete="off">
        <br>
    <button type="submit" name="submit">Add Spice</button>
</form>    
<br>
</div>
<div class="links">
    <button type="button" id="nav_but">Navigation</button>
    <div class="nav_bar">
        <button type="button" id="home" onclick="window.location.href='index.php';">Home</button>
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
