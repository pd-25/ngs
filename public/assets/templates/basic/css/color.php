<?php
header("Content-Type:text/css");
function checkhexcolor($color)
{
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

if (isset($_GET['color']) and $_GET['color'] != '') {
    $color = "#" . $_GET['color'];
}

if (!$color or !checkhexcolor($color)) {
    $color = "#336699";
}

?>

:root{
--base-color: <?php echo $color; ?>;
}





.btn--base:hover, .cookies-btn:hover{
background-color: <?php echo $color; ?>bf;
}

a:hover{
color: <?php echo $color; ?>bf;
}
.cookies-card__icon{
background-color: <?php echo $color; ?>21;
}

.badge--primary{
background-color: <?php echo $color; ?>33;
}