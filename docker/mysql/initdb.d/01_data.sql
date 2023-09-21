SET CHARACTER_SET_CLIENT = utf8;
SET CHARACTER_SET_CONNECTION = utf8;

CREATE TABLE thp (
    date                  DATETIME PRIMARY KEY,
    temp                  INT,
    humi                  INT,
    pres                  INT
);