<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hotel Info</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/info.css">
</head>
<body>
<?php
include_once("functions.php");
if (isset($_GET['hotel'])) {
    $hotel = $_GET['hotel'];
    $mysqli = connect();
    $sel = 'select * from hotels where id=' . $hotel;
    $res = $mysqli->query($sel);
    $row = mysqli_fetch_array($res, MYSQLI_NUM);
    $hname = $row[1];
    $hstars = $row[4];
    $hcost = $row[5];
    $hinfo = $row[6];
    mysqli_free_result($res);
    echo '<h2 class="text-uppercase text-center h3_head_1">' . $hname . '</h2>';
    echo '<div class="row"><div class="col-md-6 text-center">';
    $mysqli = connect();
    $sel = 'select imagepath from images where hotelid=' . $hotel;
    $res = $mysqli->query($sel);
    echo '<span class="label label-info lab">Watch our pictures</span>';
    echo '<ul id="gallery">';
    $i = 0;
    while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
        echo '<li><img src="../' . $row[0] . '"></li>';
    }
    mysqli_free_result($res);
    echo '</ul> ';
    for ($i = 0; $i < $hstars; $i++) {
        if ($i == 0)
            echo '<img id="img" src="../images/star.png" alt="star">';
        else
            echo '<img src="../images/star.png" alt="star">';
    }
    echo '<h2 class="text-center h3_head_2">Cost&nbsp;<span class="label label-info">' . $hcost . ' $</span>';
    echo '<a href="#" class="btn btn-success">Book This Hotel</a></h2>';
    echo '</div><div class="col-md-6"><p class="well">' . $hinfo . '</p></div>';//
    echo '</div></main>';

    //------------------------------------------------------------------------------------------------------------------


    $sel1 = 'SELECT us.login, comm.date_time, comm.stars, comm.comment_text FROM comments comm JOIN users us ON comm.users_id = us.id WHERE comm.hotels_id=' . $hotel;
    $res = $mysqli->query($sel1);

    if ($res->num_rows == 0)
        echo "<h3 id='dv1'><span >No reviews!</span><h3 />";

    $ii = 1;
    while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {

        echo '<div id="dv1">Review: №' . $ii++;
        echo '<h3 id="h3_1">' . $row[0] . '<span id="spn1"> (' . $row[1] . ')';
        echo '</span></h3>';

        for ($j = 0; $j < 5; $j++) {
            if ($j < $row[2]) {
                echo '<img class="stars" src="../images/star.png" alt="star">';
            } else echo '<img class="stars" src="../images/void_star.png" alt="star">';
        }
        echo '<p>' . $row[3] . '</p></div><hr>';
    }
    mysqli_free_result($res);
}
?>

<script src="../js/jquery-3.1.0.min.js"></script>
<script src="../js/gallery.js"></script>
<script src="../js/info2.js"></script>
</body>
</html>