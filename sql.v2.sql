CREATE TABLE `cena`.`tarefas` (
  `id_tarefa` INT NOT NULL AUTO_INCREMENT,
  `tar_titulo` VARCHAR(25) NULL,
  `tar_descricao` VARCHAR(555) NULL,
  `tar_prazo` VARCHAR(45) NULL,
  `tar_prioridade` VARCHAR(45) NULL,
  `tar_status` VARCHAR(1) NULL,
  PRIMARY KEY (`id_tarefa`));


CREATE TABLE `cena`.`tarefas_usuario` (
  `id_tarefas_usuario` INT NOT NULL AUTO_INCREMENT,
  `id_user` VARCHAR(45) NULL,
  `id_tarefa` VARCHAR(45) NULL,
  `create_by` INT NULL,
  `create_date` DATE NULL,
  `edit_by` INT NULL,
  `edit_date` DATE NULL,
  PRIMARY KEY (`id_tarefas_usuario`));
  
ALTER TABLE `cena`.`tarefas_usuario` 
ADD COLUMN `status` VARCHAR(45) NULL AFTER `edit_date`;

ALTER TABLE `cena`.`tarefas` 
ADD COLUMN `dataJson` VARCHAR(555) NULL AFTER `tar_status`;
