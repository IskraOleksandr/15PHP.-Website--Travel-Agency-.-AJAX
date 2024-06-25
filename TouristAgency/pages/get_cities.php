<?php
include_once("functions.php");
$mysqli = connect();

if(isset($_POST['countryid'])) {
    $countryid = intval($_POST['countryid']);
    $res = $mysqli->query("SELECT * FROM cities WHERE countryid=$countryid ORDER BY city");
    $cities = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $cities[] = $row;
    }
    mysqli_free_result($res);
    echo json_encode($cities);
}
?>
