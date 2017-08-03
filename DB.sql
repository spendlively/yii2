

CREATE DATABASE yii CHARACTER SET utf8 COLLATE utf8_general_ci;
GRANT ALL PRIVILEGES ON yii.* TO 'yii'@'localhost' IDENTIFIED BY 'yii' WITH GRANT OPTION;

CREATE TABLE comments( \
  id int(11) auto_increment, \
  name varchar(255), \
  text text, \
  PRIMARY KEY (id) \
) engine=innodb;

INSERT INTO comments (id, name, text) VALUES (null, 'Вася', 'Комментарий 1');
INSERT INTO comments (id, name, text) VALUES (null, 'Петя', 'Комментарий 2');
INSERT INTO comments (id, name, text) VALUES (null, 'Ваня', 'Комментарий 3');
INSERT INTO comments (id, name, text) VALUES (null, 'Сережа', 'Комментарий 4');
INSERT INTO comments (id, name, text) VALUES (null, 'Андрей', 'Комментарий 5');
INSERT INTO comments (id, name, text) VALUES (null, 'Леша', 'Комментарий 6');
