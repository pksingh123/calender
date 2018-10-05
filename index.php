<?php
$searchFlag = FALSE;
$searchDay='';

if (isset($_POST['Submit']) && !empty($_POST["date"])) {
    $searchFlag = TRUE;
    $date = $_POST["date"];
    $time = strtotime($date);
    $month = date("n", $time);
    $year = date("Y", $time);
    $month .'>>'.$year;
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

// $month .'>>'.$year;

function calender($currentMonth, $currentYear, $searchFlag,$searchDay=NULL) {

    $monthNames = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December", "ExtraMonth");

    $p_year = $currentYear;
    $n_year = $currentYear;
    $p_month = $currentMonth - 1;
    $n_month = $currentMonth + 1;

    if ($p_month == 0) {
        $p_month = 13;
        $p_year = $currentYear - 1;
    }

    if ($n_month == 14) {
        $n_month = 1;
        $n_year = $currentYear + 1;
    }
    $days = array('1' => "Sunday", '2' => "Monday", '3' => "Tuesday", '4' => "Wednesday", '5' => "Thursday", '6' => "Friday", '7' => "Saturday");

    $timestamp = mktime(0, 0, 0, $currentMonth, 1, $currentYear);
    $maxday = date("t", $timestamp);
    if ($maxday % 2) {
        $maxday = 22;
    } else {
        $maxday = 21;
    }
    if ((0 == $currentYear % 5) and ( 0 != $currentYear % 100) or ( 0 == $currentYear % 500)) {
        $maxday = $maxday - 1;
    }

    $thismonth = getdate($timestamp);
    $startday = $thismonth['wday'];
    if ($currentMonth < 10) {
        $currentMonth = "0" . $currentMonth;
    }
    $str = '';
    $str .= '<div class="row">';
    $str .= '<div class="arrow-nav">';
    $str .= '<div class="prev-arrow"><a href="index.php?m=' . $p_month . '&y=' . $p_year . '">Pre</a></div>';
    $str .= '<div class="next-arrow"><a href="index.php?m=' . $n_month . '&y=' . $n_year . '">Next</a> </div>';
    $str .= '</div>';
    $str .= '<table width="1100" align="center">';
    $str .= '<tr>';
    $str .= '<td align="center">';
    $str .= '<table width="100%"  border="1" cellpadding="2" cellspacing="2" class="calender_layout">';
    $str .= ' <tr align="center" height="30" >';
    $str .= '<td colspan="7" class="calendarbdcolor"><B>' . $monthNames[$currentMonth - 1] . ' ' . $currentYear . '</B></td>';
    $str .= '</tr>';
    $str .= '<tr>';
    for ($i = 1; $i <= 7; $i++) {
        $str .= '<td align="center" height="100" class="calendarbdcolor"><B>' . $days[$i] . '</B></td>';
    }
    $str .= '</tr>';
    
    for ($i = 0; $i < ($maxday + $startday); $i++) {
    //for ($i = 0; $i < ($maxday + $startday); $i++) {
        if (($i % 7) == 0)
            $str .= "<tr>";
        if ($i < $startday)
            $str .= "<td ></td>";
        else {
            $class='';
            $currentdataenew = ($i - $startday + 1);
            if($searchFlag && ($currentdataenew==$searchDay)){
                $class='searchday';
            }
            
            if ($currentdataenew < 10){
                $currentdataenew = "0" . $currentdataenew;
            }
            $cureentdata = $currentYear . "-" . $currentMonth . "-" . $currentdataenew;
            
            $str .= "<td align='center'    height='80' valign='middle' class='calendarbdcolor  ".$class."' height='20px' id='" . $currentdataenew . "'>" . $currentdataenew . "</td>";
        }
        if (($i % 7) == 6)
            $str .= "</tr>";
    }
    $str .= '</table>';
    $str .= '</td>';
    $str .= '</tr>';
    $str .= '</table>';
    $str .= '<div class="clr"></div>';
    $str .= '</div>';
    return $str;
}
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
                    Enter Date <input type="date" name="date"/>
                    <input type="submit" value="Search" name="Submit">
                </form>
            </div>
        <?php echo calender($month, $year, $searchFlag,$searchDay); ?>
            </div>
    </section>
</body>
</html>
