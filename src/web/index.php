<!DOCTYPE html>
<html>
<head>
    <title>BME280 温度・湿度・気圧</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;400;600;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Akshar:wght@300&display=swap" rel="stylesheet">
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
<h1>BME280 温度・湿度・気圧</h1>
<h2>現在の情報</h2>
<h3>温度</h3>
<p class="data" id="d_temp"></p>
<h3>湿度</h3>
<p class="data" id="d_humi"></p>
<h3>気圧</h3>
<p class="data" id="d_pres"></p>
<h2>温度グラフ</h2>
<div class="canvas-container">
    <canvas id="myLineChart1"></canvas>
</div>
<h2>湿度グラフ</h2>
<div class="canvas-container">
    <canvas id="myLineChart2"></canvas>
</div>
<h2>気圧グラフ</h2>
<div class="canvas-container">
    <canvas id="myLineChart3"></canvas>
</div>
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
        var ctx1 = document.getElementById("myLineChart1");
        ctx1.attr('width', container.width());
        ctx1.attr('height', 300);
        var ctx2 = document.getElementById("myLineChart2");
        ctx2.attr('width', container.width());
        ctx2.attr('height', 300);
        var ctx3 = document.getElementById("myLineChart3");
        ctx3.attr('width', container.width());
        ctx3.attr('height', 300);
        var myLineChart1 = new Chart(ctx1, {
            type: 'line',
            data: {
            labels: dates,
            datasets: [
                {
                label: '気温(度）',
                data: temps,
                borderColor: "rgba(255,0,0,1)",
                backgroundColor: "rgba(0,0,0,0)"
                }
            ],
            },
            options: {
            title: {
                display: true,
                text: '室温'
            },
            scales: {
                yAxes: [{
                ticks: {
                    suggestedMax: 40,
                    suggestedMin: 0,
                    stepSize: 10,
                    callback: function(value, index, values){
                    return  value +  '度'
                    }
                }
                }]
            },
            }
        });
        var myLineChart2 = new Chart(ctx2, {
            type: 'line',
            data: {
            labels: dates,
            datasets: [
                {
                label: '湿温(%）',
                data: humis,
                borderColor: "rgba(0,255,0,1)",
                backgroundColor: "rgba(0,0,0,0)"
                }
            ],
            },
            options: {
            title: {
                display: true,
                text: '湿度'
            },
            scales: {
                yAxes: [{
                ticks: {
                    suggestedMax: 40,
                    suggestedMin: 0,
                    stepSize: 10,
                    callback: function(value, index, values){
                    return  value +  '%'
                    }
                }
                }]
            },
            }
        });
        var myLineChart3 = new Chart(ctx3, {
            type: 'line',
            data: {
            labels: dates,
            datasets: [
                {
                label: '気圧(hPa）',
                data: press,
                borderColor: "rgba(255,0,0,1)",
                backgroundColor: "rgba(0,0,0,0)"
                }
            ],
            },
            options: {
            title: {
                display: true,
                text: '気圧'
            },
            scales: {
                yAxes: [{
                ticks: {
                    suggestedMax: 40,
                    suggestedMin: 0,
                    stepSize: 10,
                    callback: function(value, index, values){
                    return  value +  'hPa'
                    }
                }
                }]
            },
            }
        });
    });
</script>

</body>
</html>