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
$stmt = $pdo->query("SELECT date, temp, humi from thp");
while ($row = $stmt->fetch()) {
  print "$row[date], $row[temp], $row[humi] <br> \n";
}
// MariaDB切断
$pdo = null;
// エラー処理
} catch (PDOException $e) {
  echo $e->getMessage() . PHP_EOL;
  exit;
}
?>
</body>
</html>