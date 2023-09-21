<!DOCTYPE html>
<html>
<head>
    <title>BME280 温度・湿度・気圧</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./style.css">
    <script src="chart.min.js"></script>
    <script src="jquery-3.5.1.min.js"></script>
</head>
<body>
<?php
$dates = array();
$temps = array();
$humis = array();
$press = array();

define('DSN','mysql:host=192.168.10.2;dbname=temp');
define('DB_USER','piuser');
define('DB_PASSWORD','Pi1qaz2wsx');
error_reporting(E_ALL & ~E_NOTICE);
function connectDb(){
    try {
        return new PDO(DSN, DB_USER, DB_PASSWORD);
    }catch(PDOException $e){
        echo $e->getMessage();
        exit;
    }
}
mb_language("uni");
mb_internal_encoding("utf-8");
mb_http_input("auto");
mb_http_output("utf-8");
$dbh = connectDb();
$sth = $dbh->prepare("SELECT * FROM thp");
$sth->execute();
$userData=array();

while($row=$sth->fetch(PDO::FETCH_ASSOC)){
    $tempData[]=array(
        'date'=>$row['date'],
        'temp'=>$row['temp'],
        'humi'=>$row['humi'],
        'pres'=>$row['pres']
    );
}
$json = json_encode($tempData);
?>


<script>
    $(function(){
        var array = <?php echo $json; ?>;
        var dates = [];
        var temps = [];
        var humis = [];
        var press = [];
        array.forEach(elm => {
            dates.push(elm['date']);
            temps.push(elm['temp']);
            humis.push(elm['humi']);
            press.push(elm['pres']);
        })
        console.log(dates);
        console.log(dates[0]);
        console.log(temps[0]);
        $("#d_temp").append(temps[0]);
        $("#d_humi").append(humis[0]);
        $("#d_pres").append(press[0]);
    });
</script>
<h1>BME280 温度・湿度・気圧</h1>
<h2>現在の情報</h2>
<h3>温度</h3>
<p class="data" id="d_temp"></p>
<h3>湿度</h3>
<p class="data" id="d_humi"></p>
<h3>気圧</h3>
<p class="data" id="d_pres"></p>
</body>
</html>