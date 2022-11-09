CREATE TABLE user
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    login VARCHAR(20) NOT NULL,
    senha VARCHAR(50) NOT NULL,
    token VARCHAR(100) NOT NULL,
    telefone INT(11) NOT NULL,
    status INT(1) NOT NULL,
    auth_error INT(1) NOT NULL
);


CREATE TABLE cod
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    chave INT(4) NOT NULL,
    user_id int,
  foreign key (user_id) references user(id),
);