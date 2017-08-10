

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


CREATE TABLE IF NOT EXISTS pref_sef (
  id int(11) NOT NULL,
  link varchar(255) NOT NULL,
  link_sef varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
INSERT INTO pref_sef (id, link, link_sef) VALUES
(1, 'site/sef', 'sef.html');
ALTER TABLE pref_sef
 ADD PRIMARY KEY (id);
ALTER TABLE pref_sef
MODIFY id int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;