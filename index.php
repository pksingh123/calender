<?php

include 'calender.php';
$searchFlag = FALSE;
$searchDay='';
$date='';
if (isset($_POST['Submit']) && !empty($_POST["date"])) {
    $searchFlag = TRUE;
    $date = $_POST["date"];
    $time = strtotime($date);
    $month = date("n", $time);
    $year = date("Y", $time);
    $searchDay=date("d", $time);
} else {
    if (!isset($_REQUEST["m"])) {
        $_REQUEST["m"] = date("n");
    }
    if (!isset($_REQUEST["y"])) {
        $_REQUEST["y"] = date("Y");
    }
    $month = $_REQUEST["m"];
    $year = $_REQUEST["y"];
}
/*
 * calender.php
 * Call function to display calender 
 */
$calender_string=calender($month, $year, $searchFlag,$searchDay);
?>
<html>
    <head>
        <style>
            .arrow-nav{width: 150px; margin: 0 auto;}
            .prev-arrow{display: inline-block;background-color: #f2f2f2; padding: 8px 19px; border-radius: 5px; border: 1px solid #ccc;}
            .next-arrow{display: inline-block;float: right;background-color: #f2f2f2; padding: 8px 19px; border-radius: 5px;  border: 1px solid #ccc;}
            .calender_layout{background: #f2f2f2;}
            .prev-arrow a,.next-arrow a{color:#000;}
            .container{width:1100px; margin:0 auto;position: relative;}
            .search_btn{position: absolute;right: 10px;}
            .search_btn form input[type="date"]{padding: 3px;}
            .search_btn form input[type="submit"]{padding: 5px;}
            .searchday{background: #2dcc70;color:#fff;}
        </style>
    </head>
    <body>   
        <section>
            <div class="container">
            <div class="clr"></div>
            <div class="row search_btn">
                <form action="<?=$_SERVER['PHP_SELF'];?>" method="POST">
                    Enter Date <input type="date" name="date" value="<?=$date;?>"/>
                    <input type="submit" value="Search" name="Submit">
                </form>
            </div>
            <?php echo $calender_string; ?>
            </div>
    </section>
</body>
</html>
