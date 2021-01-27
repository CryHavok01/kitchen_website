<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="styles.css">
        <meta charset="utf-8">
        <title>J&S Kitchen</title>
    <style>
        #recipe-step {
            width: 100%;
            height: 150px;
        }

    </style>
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
                    <p>Creating the database table for ingredients was easy because I always knew exactly how much information would be input about each ingredient.  They would always have one name, one quantiy, and one unit of measurement.  Recipes are different because I can't know beforehand how many ingredients or how many steps each recipe will contain.  Instead of putting all the data into one table, I built three separate tables that would each store part of the information for each recipe.  The first and simplest table would only store the name of each recipe, as well as a Primary ID Key.  I would then use that ID Key across the other tables to keep track of which ingredients and steps belong to which recipe.  The second table would store all the ingredients needed for recipes in columns for their names, quantities, and units, creating a new row for every new ingredient.  The last table would contain all the steps for recipes, with each new step on its own row.  Both the ingredients and steps tables have a column for Recipe ID, which inputs the same ID number as the Primary Key for that recipe's name.  That way when I need to access a full recipe, I can pull all the necessary information from all three tables using one ID key.  At first glance, the form for inputting new recipes seems pretty similar to the one for adding new ingredients to our collection, but there is one key difference.  The recipe form has buttons to add new ingredients and new steps.  Adding new fields to the form is accomplished using JQuery's .clone method.  The form stars out with two ingredient input fields, and the second one is wrapped in a div with the class name "Ingredient_Form".  When you press the New Ingredient button, JQuery creates a clone of the Ingredient_Form div, and appends it below the last ingredient form.  That creates a new field for a new ingredient, but it also creates a problem organizing the data that gets input.  Since the new cloned form is identical to the one it was cloned from, the inputs have the exact same names, and you won't be able to determine which inputs go with which ingredients when inserting them into the tables.  To solve this, I created a variable for currentIngredient that starts as 2 (since there page starts with two ingredient fields) and increments by 1 every time the New Ingredient button is clicked.  I then use JQuery to change the name of Ingredient Name input field in the new cloned div from "i2-name" to "'i' +  currentIngredient + '-name'".  For the first extra ingredient this would set the name as "i3-name", then "i4-name" for the next ingredient, and so on.  I did this for all of the inputs in the form before appending it onto the page.  So now every new ingredient field has unique names and the data can be appropriately organized for inputting into the tables.  The New Step button uses the same process to add new, correctly labeled fields for additional steps.  To learn about the next step in the process, please find your way to the Look up Recipes page.</p>
                    </div>
                </div>
        </div>

<h2>Add New Recipe</h2>
    
    <?php
    if (array_key_exists('error', $_GET)){
        if ($_GET['error'] === "copy"){
            echo "<h3>A  Recipe with that name already exists!  Please use a different name, or update that recipe.</h3>";
        } else if ($_GET['error'] === "missing"){
            echo "<h3>You left something blank!  Make sure you fill out all fields and select Units for every ingredient.</h3>";
        }
    } else {
        echo "<h3>Fill out all fields and select Units for every ingredient</h3>";
    };
    ?>
        <form action="recipe_insert.php" method="POST">
            <label>Recipe Name:  </label>
            <input type="text" name="recipe-name" class="recipe-name"  autocomplete="off"><br><br>
            <label>Ingredient 1:  </label>
            <input type="text" name="i1-name" class="i1-name" autocomplete="off"><br>
            <label>Quantity:    </label>
            <input type="number" step="0.01" name="i1-quant" class="i1-quant" autocomplete="off"><br>
            <label>Units:  </label>
                <input type="radio" name="i1-unit" class="i1-unit" value="Teaspoon(s)">Teaspoon(s)<br>
                <input type="radio" name="i1-unit" class="i1-unit" value="Tablespoon(s)">Tablespoon(s)<br>
                <input type="radio" name="i1-unit" class="i1-unit" value="Ounce(s)">Ounce(s)<br>
                <input type="radio" name="i1-unit" class="i1-unit" value="Cup(s)">Cup(s)<br>
                <input type="radio" name="i1-unit" class="i1-unit" value="other">Other <input type="text" name="i1-other" class="i1-other" autocomplete="off">
            <br><br>
            
            <div id="ing-form"> "<label id="ing-label">Ingredient 2:  </label>
            <input type="text" name="i2-name" class="i2-name" autocomplete="off"><br>
            <label>Quantity:    </label>
            <input type="number" step="0.01" name="i2-quant" class="i2-quant" autocomplete="off"><br>
            <label>Units:  </label>
                <input type="radio" name="i2-unit" class="i2-unit" value="Teaspoon(s)">Teaspoon(s)<br>
                <input type="radio" name="i2-unit" class="i2-unit" value="Tablespoon(s)">Tablespoon(s)<br>
                <input type="radio" name="i2-unit" class="i2-unit" value="Ounce(s)">Ounce(s)<br>
                <input type="radio" name="i2-unit" class="i2-unit" value="Cup(s)">Cup(s)<br>
                <input type="radio" name="i2-unit" class="i2-unit" value="other">Other <input type="text" name="i2-other" class="i2-other" autocomplete="off"><br><br></div>
            
            <div id="end-ing"></div>
            
            <button type="button" id="new-ingredient">New Ingredent</button><br><br>
            
            <label id="step-label">Step 1:</label>
            <textarea class="step1" name="step1" id="recipe-step" autocomplete="off"></textarea><br><br>
            
            <div id="step-form"><label id="step-label">Step 2:</label>
            <textarea class="step2" name="step2" id="recipe-step" autocomplete="off"></textarea><br><br></div>
            
            <div id="end-step"></div>
            
            <button type="button" id="new-step">New Step</button><br>
            
            <button type="submit" name="submit">Enter Recipe</button>
            
            
        </form>
   
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

//additional ingredients/steps
            var curIng = 2;
            var curStep = 2;
            var $newStep = $("#new-step");
            var $newIng = $("#new-ingredient");
            $newIng.on("click", function() {
                curIng++
                var $cloneIng = $("#ing-form").clone()
                $cloneIng.find("#ing-label").text("Ingredient " + curIng + ":")
                $cloneIng.find(".i2-name").val("")
                $cloneIng.find(".i2-name").attr("name", "i" + curIng + "-name")
                $cloneIng.find(".i2-quant").val("")
                $cloneIng.find(".i2-quant").attr("name", "i" + curIng + "-quant")
                $cloneIng.find(".i2-unit").attr("name", "i" + curIng + "-unit")
                $cloneIng.find(".i2-other").attr("name", "i" + curIng + "-other")
                $cloneIng.find(".i2-other").val("")
                $cloneIng.appendTo("#end-ing")
            });
            
            $newStep.on("click", function() {
                curStep++
                var $cloneStep = $("#step-form").clone()
                $cloneStep.find("#step-label").text("Step " + curStep + ":")
                $cloneStep.find(".step2").val("")
                $cloneStep.find(".step2").attr("name", "step" + curStep)
                $cloneStep.appendTo("#end-step")
            });
                
          
                    
            
        </script>
        
        
    </body>
</html>
