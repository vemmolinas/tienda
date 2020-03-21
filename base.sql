CREATE TABLE `usuarios` (
`idUsuario INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
`usuario` VARCHAR(20) NOT NULL,
`password` VARCHAR(10) NOT NULL,
`rol` enum('administrador', 'consultor') NOT NULL
) engine='innodb';

CREATE TABLE `articulos` (
`idArticulo` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
`descripcion` VARCHAR(50) NOT NULL,
`precio` DECIMAL(4, 2) NOT NULL,
`características` VARCHAR(250) NOT NULL
) engine='innodb';

  CREATE TABLE `compras` (
  `idUsuario` INT(11) NOT NULL,
  `idArticulo` INT(11) NOT NULL,
  `fecha` date NOT NULL,
  `cantidad` INT NOT NULL,
  `tiquet` INT NOT NULL,
  constraint fk_idUsuario
    foreign key(idUsuario) references usuarios(idUsuario),
  constraint fk_idArticulo
    foreign key(idArticulo) references articulos(idArticulo),
  constraint pk_compras primary key(idUsuario,idArticulo, fecha)
  ) ENGINE='innodb';
