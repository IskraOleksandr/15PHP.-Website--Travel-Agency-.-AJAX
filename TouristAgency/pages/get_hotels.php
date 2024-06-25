<?php
include_once("functions.php");
$mysqli = connect();

if(isset($_POST['cityid'])) {
    $cityid = intval($_POST['cityid']);
    $res = $mysqli->query("SELECT co.country, ci.city, ho.hotel, ho.cost, ho.stars, ho.id  
                           FROM hotels ho
                           JOIN cities ci ON ho.cityid=ci.id
                           JOIN countries co ON ho.countryid=co.id
                           WHERE ho.cityid=$cityid");
    $hotels = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $hotels[] = $row;
    }
    mysqli_free_result($res);
    echo json_encode($hotels);
}
?>
