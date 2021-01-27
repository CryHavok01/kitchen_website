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
                    <p>When you clicked on the name of an ingredient on the Check Spices page, it brought you to this page, ingredient.php, with that ingredient's name saved as the value of an Ingredient variable in the URL.  When this page loads, it immediately saves the ingredient name from the variable in the $_GET superglobal, and then performs a SQL query to find the row for the ingredient you clicked on in the database's ingredients table.  It then echos the details for that ingredient, the same as on the previous page.  The difference here is that you have the option to update or delete the ingredient.  When you click the update button, a form similar to the one for adding a new ingredient appears.  One difference with this form is that I used PHP to save the details for the ingredient as variables, and then used those variables to define the default values of the input fields.  That is why the name and quantity of the ingredient automatically appear inside the form.  The other difference is that there is a hidden field that stores the ingredient's Primary ID Key from the table, so that I can be sure to update only the correct row of the table when new information is submitted.  I used JQuery to hide the form as soon as the page loads, and then to reveal and hide it again as you click the Update or Cancel button.  A warning appears when you press the Delete button using the same technique.  When you submit the updated information, an insert php file runs that performs the same error checks as when adding a new ingredient, and then uses the ID key from the hidden field to update the information only in the correct row of the table.  Choosing the Delete option runs a different php file that deletes that ingredient's row from the table entirely.  To continue the tour of this website, please navigate to the Add New Recipe page.</p>
                    </div>
                </div>
        </div>
<?php
include_once 'dbh.php';
$ingredient = $_GET['ingredient'];
$sql = "SELECT * FROM spices WHERE spice_name = '$ingredient';";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);

echo "<h2>" . $row['spice_name'] . "</h2>";

if (array_key_exists('error', $_GET)){
    if ($_GET['error'] === "copy"){
        echo "<h3>An Ingredient with that name already exists!  Please use a different name, or update that Ingredient.</h3>";
    } else if ($_GET['error'] === "missing"){
        echo "<h3>You left something blank!  Make sure you fill out all fields and select Units</h3>";
    }
};

echo "We have " . ($row['spice_quant'] + 0) . " " . $row['spice_units'] . " of " . $row['spice_name'] . ".";
?>
<br>

<form id="ing_update" action="ingredient_update.php" method="POST">
    <br>
    <?php
    echo "<input type='hidden' name='spice_num' value='" . $row['spice_num'] . "'>";
    echo "<label>Name:  </label><input type='text' name='spice_name' autocomplete='off' value='" . $row['spice_name'] . "'><br>";
    echo "<label>Quantity:  </label><input type='number' step='0.01' name='spice_quant' autocomplete='off' value='" . ($row['spice_quant'] + 0) . "'><br>";
    ?>
    <label for="spice_units">Units: </label>

    <?php
        if ($row['spice_units'] === 'Teaspoon(s)'){
            echo "<input type='radio' name='spice_units' value='Teaspoon(s)' checked='checked'>Teaspoon(s)<br>
        <input type='radio' name='spice_units' value='Tablespoon(s)'>Tablespoon(s)<br>
        <input type='radio' name='spice_units' value='Ounce(s)'>Ounce(s)<br>
        <input type='radio' name='spice_units' value='Cup(s)'>Cup(s)<br>
        <input type='radio' name='spice_units' value='other'>Other  
        <input type='text' name='other_units' autocomplete='off'>";
        } else if ($row['spice_units'] === 'Tablespoon(s)'){
            echo "<input type='radio' name='spice_units' value='Teaspoon(s)'>Teaspoon(s)<br>
        <input type='radio' name='spice_units' value='Tablespoon(s)' checked='checked'>Tablespoon(s)<br>
        <input type='radio' name='spice_units' value='Ounce(s)'>Ounce(s)<br>
        <input type='radio' name='spice_units' value='Cup(s)'>Cup(s)<br>
        <input type='radio' name='spice_units' value='other'>Other  
        <input type='text' name='other_units' autocomplete='off'>";
        } else if ($row['spice_units'] === 'Ounce(s)'){
            echo "<input type='radio' name='spice_units' value='Teaspoon(s)'>Teaspoon(s)<br>
        <input type='radio' name='spice_units' value='Tablespoon(s)'>Tablespoon(s)<br>
        <input type='radio' name='spice_units' value='Ounce(s)' checked='checked'>Ounce(s)<br>
        <input type='radio' name='spice_units' value='Cup(s)'>Cup(s)<br>
        <input type='radio' name='spice_units' value='other'>Other  
        <input type='text' name='other_units' autocomplete='off'>";
        } else if ($row['spice_units'] === 'Cup(s)'){
            echo "<input type='radio' name='spice_units' value='Teaspoon(s)'>Teaspoon(s)<br>
        <input type='radio' name='spice_units' value='Tablespoon(s)'>Tablespoon(s)<br>
        <input type='radio' name='spice_units' value='Ounce(s)'>Ounce(s)<br>
        <input type='radio' name='spice_units' value='Cup(s)' checked='checked'>Cup(s)<br>
        <input type='radio' name='spice_units' value='other'>Other  
        <input type='text' name='other_units' autocomplete='off'>";
        } else {
            echo "<input type='radio' name='spice_units' value='Teaspoon(s)'>Teaspoon(s)<br>
        <input type='radio' name='spice_units' value='Tablespoon(s)'>Tablespoon(s)<br>
        <input type='radio' name='spice_units' value='Ounce(s)'>Ounce(s)<br>
        <input type='radio' name='spice_units' value='Cup(s)'>Cup(s)<br>
        <input type='radio' name='spice_units' value='other' checked='checked'>Other  
        <input type='text' name='other_units' autocomplete='off' value='" . $row['spice_units'] . "'>";
        }

    ?>
        <br>
    <button type="submit" name="submit">Update Ingredient</button>
    <button type="button" id="cancel_update">Cancel</button>
</form>
<div id="warning">
    <h3>Warning!</h3>
    <p>Are you SURE you want to delete this item?</p>
    <form id="ing_delete" action="ingredient_delete.php" method="POST">
    <br>
    <?php
    echo "<input type='hidden' name='spice_num' value='" . $row['spice_num'] . "'>";
    ?>
    <button type="submit" id="confirm_delete">Delete for Real!</button>

    <button type="button" id="cancel_delete">Cancel</button>
    </form>
</div>

<br><br>
<button type="button" id="update">Update</button>
<button type="button" id="delete">Delete</button>
<br><br>


</div>
<div class="links">
    <button type="button" id="nav_but">Navigation</button>
    <div class="nav_bar">
        <button type="button" id="home" onclick="window.location.href='index.htmlr';">Home</button>
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
    $('#ing_update').hide();
    $('#update').on("click", function(){
        $('#ing_update').show("fast");
        $('#update').hide();
        $('#delete').hide();
    });
    $('#delete').on('click', function(){
        $('#warning').show("fast");
        $('#delete').hide();
        $('#update').hide()
    });
    $('#cancel_delete').on('click', function(){
        $('#warning').hide("fast");
        $('#delete').show();
        $('#update').show();
    });
    $('#cancel_update').on('click', function(){
        $('#ing_update').hide("fast");
        $('#update').show();
        $('#delete').show();
    });
    
</script>
</body>

</html>
