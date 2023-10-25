# raspi_temp
RaspberryPi4のbme280から温度・湿度・気圧を取得し、表示するまでのプログラム

## 起動方法
```
pi@raspberrypi:~ $ cd raspi_temp/
```
docker composeコマンドでコンテナを起動
```
pi@raspberrypi:~/raspi_temp $ docker compose up --build -d
```
