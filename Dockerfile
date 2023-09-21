# GET TEMP AND HUMI AND PRES
# image
FROM ubuntu

# Set default work directory
RUN mkdir src
WORKDIR /src

# install packages
# GPIO, I2C, Serial (for Python3.x)
RUN set -x &&\
    apt update &&\
    apt install \
        python3-rpi.gpio i2c-tools python3-smbus cu cron -y
# set bme280Test.py
COPY ./src/bme280/bme280Test.py /src/

RUN pip3 install --upgrade pip

# install smbus2
RUN pip3 install smbus2
# cron設定を配置する
COPY ./docker/cron/cron.root /etc/cron.d/cron