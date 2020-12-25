<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $fruits = array("Apple", "Banana", "Berry", "Watermelon");
        $myfruit = "";

        fruit_picker(); //first time call
        echo "My fruit is : " . $myfruit . "<br />\n";
        fruit_picker(); //second time call
        echo "My fruit is now: " . $myfruit . "<br />\n";
        fruit_picker(); //third time call
        echo "My fruit is finally: " . $myfruit . "<br />\n";
        
        function fruit_picker() {
            Global $myfruit, $fruits;
            $old_fruit = $myfruit;
            $myfruit = $fruits[rand(0, 3)];
        }
        ?>
    </body>
</html>