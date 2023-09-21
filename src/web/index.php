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
<?
try {
  // MariaDB接続
$pdo = new PDO (
    'mysql:host=192.168.10.2;dbname=temp;charset=utf8mb4','piuser','Pi1qaz2wsx',
    [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);
$stmt = $pdo->query("SELECT date, temp, humi, pres from thp");
$data = $stmt->fetchAll();
// MariaDB切断
$pdo = null;
// エラー処理
} catch (PDOException $e) {
    echo $e->getMessage() . PHP_EOL;
    exit;
}
$dates = array_column($data, 'date');
$temps = array_column($data, 'temp');
$humis = array_column($data, 'humi');
$press = array_column($data, 'pres');
?>
<script>
    var dates = [];
    var temps = [];
    var humis = [];
    var press = [];
    dates = <?php echo $dates; ?>
    temps = <?php echo $temps; ?>
    humis = <?php echo $humis; ?>
    press = <?php echo $press; ?>
    console.log(dates);
    $("#d_temp").html(temps[0]);
    $("#d_humi").html(humis[0]);
    $("#d_pres").html(press[0]);
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