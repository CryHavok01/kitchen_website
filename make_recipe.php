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
                    <p>If you've found a recipe you like and have all the necessary ingredients (or not, that's okay too), you can click the button to make a recipe.  Unfortunately the website can't actually do the cooking for you, but it can keep track of the ingredients you used.  When you click the button on the previous page, it submits a hidden form that contains the recipe's ID Key, so that this page can find it in the $_POST superglobal, and use it to find the recipe's name and ingredients from their respective tables.  For every ingredient, it performs the same comparison between the amount required for the recipe and what you have saved in the ingredients list as on the previous page.  The difference is that this time, after subtracting the amount of the ingredient used, it updates the owned ingredients table with the new amount.  If both units are one of the default options, or if they're both identical "other" units, then after subtracting the amount used from the amount owned, it will tell you how much of the ingredient you started with, how much you used, and how much you now have left.  If you used all of an ingredient that you own and the new total is zero or lower, it will also display a message that you should buy more of it.  If you have an ingredient saved, but the website can't perform the math because one or both units are an "other", then it will tell you that you should update the ingredient yourself.  If the recipe uses an ingredient that you didn't already own, it will just tell you how much of that ingredient you used.  And that's my website.  I think it acheived all my goals I had when I set out to build it, and I learned an incredible amount in the process.  Thank you for taking this tour, I hope it was interesting and informative for you.</p>
                    </div>
                </div>
        </div>
<?php
include_once 'dbh.php';

//display recipe name
$recipe_id = $_POST['recipe_id'];
$nameSql = "SELECT * FROM recipe_names WHERE recipe_id = '$recipe_id';";
$nameResult = mysqli_query($connection, $nameSql);
$nameRow = mysqli_fetch_assoc($nameResult);
$recName = $nameRow['recipe_name'];
echo "<h2>You made " . $recName . "!</h2>";

//find ingredients, convert units, and update spices table
$curIng = 0;
$ingName = "i" . $curIng . "-name";
while (array_key_exists($ingName, $_POST)){
    $ingName = "i" . $curIng . "-name";
    $ingUnit = "i" . $curIng . "-unit";
    $ingQuant = "i" . $curIng . "-quant";
    $curName = $_POST[$ingName];
    $curUnit = $_POST[$ingUnit];
    $curQuant = $_POST[$ingQuant];
    $sql = "SELECT * FROM spices WHERE spice_name='$curName';";
    $result = mysqli_query($connection, $sql);
    $ingDiv = FALSE;
    $cabDiv = FALSE;
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $cabName = $row['spice_name'];
        $cabQuant = $row['spice_quant'];
        $cabUnit = $row['spice_units'];
        $ingOther = $curUnit;
        $cabOther = $cabUnit;
        if ($curUnit === "Cup(s)"){
            $ingDiv = $curQuant * 48;
        } else if ($curUnit === "Ounce(s)"){
            $ingDiv = $curQuant * 6;
        } else if ($curUnit === "Tablespoon(s)"){
            $ingDiv = $curQuant * 3;
        } else if ($curUnit === "Teaspoon(s)"){
            $ingDiv = $curQuant;
        } else if ($ingOther === $cabOther) {
            $ingDiv = $curQuant;
        } else {
            echo "You used " . ($curQuant + 0) . " " . $curUnit . " of " . $curName . ".  You should update your Ingredient List.<br>";
        };
        if ($ingDiv){
            if ($cabUnit === "Cup(s)"){
                $cabDiv = $cabQuant * 48;
            } else if ($cabUnit === "Ounce(s)"){
                $cabDiv = $cabQuant * 6;
            } else if ($cabUnit === "Tablespoon(s)"){
                $cabDiv = $cabQuant * 3;
            } else if ($cabUnit === "Teaspoon(s)"){
                $cabDiv = $cabQuant;
            } else if ($ingOther === $cabOther) {
                $cabDiv = $cabQuant;
            } else {
                echo "You used " . ($curQuant + 0) . " " . $curUnit . " of " . $curName . ".  You should update your Ingredient List.<br>";
            }
        }
        if ($ingDiv && $cabDiv){
            $remaining = $cabDiv - $ingDiv;
            if ($cabUnit === "Cup(s)"){
                $convRem = round(($remaining / 48), 2);
            } else if ($cabUnit === "Ounce(s)"){
                $convRem = round(($remaining / 6), 2);
            } else if ($cabUnit === "Tablespoon(s)"){
                $convRem = round(($remaining / 3), 2);
            } else {
                $convRem = $remaining;
            };
        $cabIng = $row['spice_num'];
        $updateSql = "UPDATE spices SET spice_quant = '$convRem' WHERE spice_num = '$cabIng';";
        $updtResult = mysqli_query($connection, $updateSql);
        echo "You had " . ($cabQuant + 0 ) . " " . $cabUnit . " of " . $curName . ".  You used " . ($curQuant + 0) . " " . $curUnit . " and now you have " . ($convRem + 0 ) . " " . $cabUnit . " left.";
        if ($convRem <= 0) {
            echo "  You should get more!";
        }
        echo "<br>";
        }
    } else {
        echo "You used " . ($curQuant + 0) . " " . $curUnit . " of " . $curName . ".<br>";
    }
    $curIng++;
    $ingName = "i" . $curIng . "-name";
}

?>
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
