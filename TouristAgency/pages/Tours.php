<h2>Select Tours</h2>
<hr>
<?php
$mysqli = connect();
?>
<form action="index.php?page=1" method="post" id="toursForm">
    <select name="countryid" id="countryid" class="col-sm-3 col-md-3 col-lg-3">
        <option value="0">Select country...</option>
        <?php
        $res = $mysqli->query("SELECT * FROM countries ORDER BY country");
        while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
            echo '<option value="'.$row[0].'">'.$row[1].' </option>';
        }
        mysqli_free_result($res);
        ?>
    </select>
    <select name="cityid" id="cityid" class="col-sm-3 col-md-3 col-lg-3" style="display:none;">
        <option value="0">Select city...</option>
    </select>
</form>

<div id="hotelsTable"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#countryid').change(function() {
            var countryid = $(this).val();
            console.log('id'+countryid);
            if(countryid != 0) {
                $.ajax({
                    type: 'POST',
                    url: 'pages/get_cities.php',
                    data: {countryid: countryid},
                    success: function(data) {
                        var cities = JSON.parse(data);
                        var citySelect = $('#cityid');
                        citySelect.empty();
                        citySelect.append('<option value="0">Select city...</option>');
                        $.each(cities, function(index, city) {
                            citySelect.append('<option value="' + city.id + '">' + city.city + '</option>');
                        });
                        citySelect.show();
                    }, error: function (x, y, z) {
                        alert(x + '\n' + y + '\n' + z);
                    }
                });
            } else {
                $('#cityid').hide();
                $('#hotelsTable').empty();
            }
        });

        $('#cityid').change(function() {
            var cityid = $(this).val();
            if(cityid != 0) {
                $.ajax({
                    type: 'POST',
                    url: 'pages/get_hotels.php',
                    data: {cityid: cityid},
                    success: function(data) {
                        var hotels = JSON.parse(data);
                        var hotelsTable = '<table width="100%" class="table table-striped tbtours text-center">';
                        hotelsTable += '<thead style="font-weight: bold"> <tr><td>Hotel</td><td>Country</td><td>City</td><td>Price</td><td>Stars</td><td>link</td></tr></thead>';
                        $.each(hotels, function(index, hotel) {
                            hotelsTable += '<tr>';
                            hotelsTable += '<td>' + hotel.hotel + '</td>';
                            hotelsTable += '<td>' + hotel.country + '</td>';
                            hotelsTable += '<td>' + hotel.city + '</td>';
                            hotelsTable += '<td>$' + hotel.cost + '</td>';
                            hotelsTable += '<td>' + hotel.stars + '</td>';
                            hotelsTable += '<td><a href="pages/hotelinfo.php?hotel=' + hotel.id + '" target="_blank">more info</a></td>';
                            hotelsTable += '</tr>';
                        });
                        hotelsTable += '</table>';
                        $('#hotelsTable').html(hotelsTable);
                    }
                });
            } else {
                $('#hotelsTable').empty();
            }
        });
    });
</script>
