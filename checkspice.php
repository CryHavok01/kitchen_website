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
                    <p>On this page, I use SQL to SELECT all from the ingredients table and order the rows alphabetically by ingredient name.  Then for each row of the table, I use PHP to save the quantity, units, and name for that ingredient as variables, and then echo "We have [quanitity] [units] of [name]" I also embed HTML inside the PHP echo statement so that the name of each ingredient is a link to the Ingredient page of this website, with the name of that particular ingredient saved as a variable inside the URL.  This way I don't have to create a new page for every single ingredient added to the table, I can just have one page that uses a variable in the $_GET superglobal to determine which ingredient it should display details for.  To see how this works, click on the name of any ingredient you'd like.</p>
                    </div>
                </div>
        </div>
        <h2>Our Spices</h2>
    
<?php
include_once 'dbh.php';
echo "<br>";
$sql = "SELECT * FROM spices ORDER BY spice_name;";
$result = mysqli_query($connection, $sql);
while ($row = mysqli_fetch_assoc($result)){
    echo "We have " . ($row["spice_quant"] + 0) . " " . $row["spice_units"] . " of <a href='ingredient.php?ingredient=" . $row["spice_name"] . "'>" . $row["spice_name"] . "</a><br>";
}
?>
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
