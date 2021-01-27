<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="styles.css">
        <meta charset="utf-8">
        <title>J&S Kitchen</title>
        <style>
            p {
                font-family: sans-serif;
            }
            
            .fact {
                background-color: red;
                color: white;
            }
            
            .fact {
                border-top: 1px solid rgb(222, 222, 222);
                border-bottom: 1px solid rgb(222, 222, 222);
                padding-top: 6px;
                padding-bottom: 6px;
                padding-left: 4px;
            }
            
            footer {
                position: fixed;
                bottom: 10px;
                right: 10px;
            }
            

            
        </style>
    </head>
    <body>
    <?php
    include_once 'dbh.php';
    ?>
    <div class="main">
        <div class="header">
            <h1 id="kitchen-header">Josh and Shanhu's Kitchen</h1>
            <div class="how_it_works">
                <div class="works_button">
                    <button id="works_but" type="button">How it Works</button>
                </div>
                <div class="explainer">
                    <p>Welcome to the first website I've ever made.  I built everything here from scratch by writing all the HTML, CSS, and JavaScript myself.  My favorite part of this home page is the navigation button on the top left.  I first built a series of buttons to act as links to navigate around the webiste, and then used CSS to keep them on the left side of the screen, while the main content of each page uses the rest of the screen.  To make navigation more interesting and interactive, wrapped the links in a div with a class called "nav_bar" and its display set to none, and put the Navigation button on top of it.  With JavaScript and JQuery, I created a function to run when the Navigation button is clicked.  At first, it simply changed the CSS display rule for the div to "block", which snapped the navigation bar into place.  I wanted the transition to be more interesting though, and decided to make the nav bar scroll down into place.  I ran into an issue though, because using JQuery's .animate() function needed an exact measurement as a target, or wouldn't animate anything.  I could have just written down the exact height of the div and used that number, but I wanted the animation to still work correctly if I added any new links to the nav bar.  The solution I came up with was to first save the height of the "nav_bar" div to a variable while it was still set to Display: none, and then in the onClick function, change the height of the div to 0.  The function then changes the div's display setting to "block", and finally animates the div's height to the value of the saved height variable - its own original height.  This way every time the page loads, it makes note of the correct height, and uses that to set the parameters for the animation.  I also created a navOn variable with a boolean value to determine whether or not the nav bar is currently displayed.  Inside the onClick function, I checked if navOn is false, and then scrolled the nav bar into place, or if it was true, scroll the bar back up.  Lastly, the function flips the value of navOn from false to true and changes the text of the Navigation button to "Hide", or vice versa.  I also used a similar method to animate this explanation box.  If you want to continue reading about how I built this website, please navigate to Add Spice for more information.</p>
                    </div>
                </div>
        </div>
        <p class="fact">
            This is my very first website.  I hope it works!
        </p>

        <p>This site is a way to catalog and organize all the various spices and ingredients we have in our kitchen.  It uses a MySQL database to store information on ingredients we have and recipes we like.  It can tell you whether or not we have enough ingredients to make a particular recipe, and it will update the ingredients after making a recipe by subtracting the amount of each ingredient used.  Feel free to test it out by adding or updating your own ingredients and recipes.</p>
        </div>
        
        <div class='links'>
            <button type="button" id="nav_but">Navigation</button>
            <div class="nav_bar">
                <button type="button" id="check-spices" onclick="window.location.href='checkspice.php';">Check Spices</button>
                <button type="button" id="add-spice" onclick="window.location.href='addspice.php';">Add Spice</button>
                <button type="button" id="check-recipe" onclick="window.location.href='checkrecipe.php';">Look up Recipes</button>
                <button type="button" id="add-recipe" onclick="window.location.href='addrecipe.php';">Add new Recipe</button>
            </div>
        </div>
        
            <footer>
        <a href="React/Test.html">React Test</a><br>
        <p>version 0.50</p>
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
            $(".fact").css("background-color", "green");
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
