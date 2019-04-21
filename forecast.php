<?php


session_start(); //Start the Session


if (isset($_POST['city_name'])){
    $cityName = $_POST['city_name'];
$apiKey = "c82555f18fc7749cd923a0524d87134e";
$googleApiUrl = "http://api.openweathermap.org/data/2.5/weather?q=" . $cityName . "&lang=en&units=metric&APPID=" . $apiKey;

$ch = curl_init();

curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_VERBOSE, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);

curl_close($ch);
$data = json_decode($response);
$currentTime = time();
}
?>

<!doctype html>
<html>
<head>
<title>Weather</title>
<link rel="stylesheet" href="style.css">
            <meta charset="UTF-8">
             <meta name="description" content="Homwork5">
             <meta name="author" content="Hassan Yahya">
</head>


<body>
<div class="report-container">
<h2>Fill in this form :</h2>


<form id="newForm" method="POST">
  City name*:<br>
  <input type="text" name="city_name" >
  <br>
  <br>
  Degree : <br>
  <input type="radio" name="tempDegree" value="F" checked>Fahrenheit<br>
  <input type="radio" name="tempDegree" value="C">Celsius<br>

  <br> <br>
  
  <input type="submit" onclick="showDiv()" value="Submit" >
  <input type="button" onclick="newFunction()" value="Clear">


</form>

<script>
         function newFunction() {
            document.getElementById("newForm").reset();
         }
       
         
      </script>
</div>
<div>

<div class="report-container" >
        <h2><?php echo $data->name; ?> Weather Status</h2>
        <div class="time">
            <div><?php echo date("l g:i a", $currentTime); ?></div>
            <div><?php echo date("jS F, Y",$currentTime); ?></div>
            <div><?php echo ucwords($data->weather[0]->description); ?></div>
        </div>

        <div class="weather-forecast">
            <img
                src="http://openweathermap.org/img/w/<?php echo $data->weather[0]->icon; ?>.png"
                class="weather-icon" /> 
                <br>

                <?php 

            if (isset($_POST['tempDegree'])){
        
                $degree = $_POST['tempDegree'];  
                if ($degree == "F") {
                    $maxFahTemp = $data->main->temp_max;
                    $converMax = ((9/5) * $maxFahTemp) + (32);

                    $minFahTemp = $data->main->temp_min;
                    $converMin = ((9/5) * $minFahTemp) + (32);

                    echo 'Max Temperature ';
                    echo $converMax;
                    echo '&deg;F <br>';
                    echo ' Min Temperature ';
                    echo $converMin;
                    echo '&deg;F <br>';
    
                }
                else {

                    echo 'Max Temperature ';
                    echo $data->main->temp_max;
                    echo '&deg;C <br>';
                    echo ' Min Temperature ';
                    echo $data->main->temp_min;
                    echo '&deg;C <br>';

                    
                }  
            }        
                ?>
        </div>

        <div class="time">
            <div>Humidity: <?php echo $data->main->humidity; ?> %</div>
            <div>Wind: <?php echo $data->wind->speed; ?> km/h</div>
        </div>
    </div>
</div>

</body>
</html>