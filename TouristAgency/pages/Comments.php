<h2>Comments</h2>
<br>
<?php

$mysqli = connect();
echo '<form id="frm" action="index.php?page=2" method="post" class="input-group">';
echo '<div id="dv3"><h4 id="h4_1">Select hotel</h4><h4 id="h4_2">Select stars</h4></div>';
echo '<select id="select_n" name="hotel_id">';
echo '<option value="0" >Select hotel...</option>';//

$sel = 'select ho.id, co.country,ci.city,ho.hotel	from countries co,cities ci, hotels ho	where co.id=ho.countryid and ci.id=ho.cityid order by co.country';
$res = $mysqli->query($sel);
while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
    echo '<option value="' . $row[0] . '">';
    echo $row[1] . ':&nbsp;&nbsp;' . $row[2] . ':&nbsp;&nbsp;' . $row[3] . '</option>';
}
mysqli_free_result($res);

echo '</select>';
echo '<div id="dv2">&nbsp;&nbsp;Stars: <input id="inp1" type="number" value="0" name="stars_review" min="0" max="5"></div>';
echo "<textarea id='text_area' name='comment' placeholder='Comment' cols='5' rows='5' ></textarea><br>";
echo '<input id="btn" type="submit" name="add_comment"	value="Add"	class="btn btn-sm btn-info">';
echo '</form>';


if (isset($_POST['add_comment'])) {
    if (isset($_POST['hotel_id']) && isset($_POST['stars_review'])) {
        if (comment($_POST['hotel_id'], $_POST['stars_review'], $_POST['comment'])) {
            echo "<h3 id='h3_2'><span id='spn2'> New comment added!</span><h3 />";
            echo "<script>setTimeout('window.location=document.URL', 1000)</script>";
        }
    }
}
?>