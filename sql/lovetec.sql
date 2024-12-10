DROP DATABASE IF EXISTS LOVETEC;
CREATE DATABASE LOVETEC; USE LOVETEC;

-- Tabela TipoEndereco
CREATE TABLE IF NOT EXISTS LOVETEC.Tipo_Endereco (
 id_tipo_endereco INT NOT NULL AUTO_INCREMENT,
 tipo_endereco VARCHAR(50) NOT NULL, PRIMARY KEY (id_tipo_endereco)
);

-- Tabela TipoTelefone
CREATE TABLE IF NOT EXISTS LOVETEC.Tipo_Telefone (
 id_tipo_telefone INT NOT NULL AUTO_INCREMENT,
 tipo_telefone VARCHAR(50) NOT NULL, PRIMARY KEY (id_tipo_telefone)
);


-- Tabela Veiculo
CREATE TABLE IF NOT EXISTS LOVETEC.Veiculo (
 id_veiculo INT NOT NULL AUTO_INCREMENT,
 modelo VARCHAR(20) NOT NULL,
 placa VARCHAR(8) NOT NULL,
 valor_diaria DECIMAL(10,2) NOT NULL,
 ano_fabricacao YEAR NOT NULL,
 cor VARCHAR(20) NOT NULL, PRIMARY KEY (id_veiculo)
);

-- Tabela Endereco
CREATE TABLE IF NOT EXISTS LOVETEC.Endereco (
 id_endereco INT NOT NULL AUTO_INCREMENT,
 rua VARCHAR(50) NOT NULL,
 bairro VARCHAR(20) NOT NULL,
 cidade VARCHAR(20) NOT NULL,
 estado VARCHAR(2) NOT NULL,
 cep VARCHAR(9) NOT NULL,
 id_tipo_endereco INT NOT NULL, PRIMARY KEY (id_endereco), FOREIGN KEY (id_tipo_endereco) REFERENCES LOVETEC.Tipo_Endereco (id_tipo_endereco)
);

-- Tabela Telefone
CREATE TABLE IF NOT EXISTS LOVETEC.Telefone (
 id_telefone INT NOT NULL AUTO_INCREMENT,
 numero_telefone VARCHAR(15) NOT NULL,
id_tipo_telefone INT NOT NULL, PRIMARY KEY (id_telefone), FOREIGN KEY (id_tipo_telefone) REFERENCES LOVETEC.Tipo_Telefone (id_tipo_telefone)
);

-- Tabela Cliente
CREATE TABLE IF NOT EXISTS LOVETEC.Cliente (
 id_cliente INT NOT NULL AUTO_INCREMENT,
 nome_cliente VARCHAR(100) NOT NULL,
 data_nasc DATE NOT NULL,
 num_cnh INT NOT NULL, UNIQUE(num_cnh),
 email VARCHAR(100) NOT NULL, UNIQUE(email),
 senha VARCHAR(255),
 id_endereco INT NOT NULL,
 id_telefone INT NOT NULL, PRIMARY KEY (id_cliente), FOREIGN KEY (id_endereco) REFERENCES LOVETEC.Endereco (id_endereco), FOREIGN KEY (id_telefone) REFERENCES LOVETEC.Telefone (id_telefone)
);

-- Tabela Locadora
CREATE TABLE IF NOT EXISTS LOVETEC.Locadora (
 id_locadora INT NOT NULL AUTO_INCREMENT,
 nome_locadora VARCHAR(100) NOT NULL,
 cnpj VARCHAR(14) NOT NULL, UNIQUE(cnpj),
 id_endereco INT NOT NULL,
 id_telefone INT NOT NULL, PRIMARY KEY (id_locadora), FOREIGN KEY (id_endereco) REFERENCES LOVETEC.Endereco (id_endereco), FOREIGN KEY (id_telefone) REFERENCES LOVETEC.Telefone (id_telefone)
);

-- Tabela Funcionario
CREATE TABLE IF NOT EXISTS LOVETEC.Funcionario (
 id_funcionario INT NOT NULL AUTO_INCREMENT,
 nome_funcionario VARCHAR(100) NOT NULL,
 email VARCHAR(100) NOT NULL, UNIQUE(email),
 senha VARCHAR(255) NOT NULL,
 id_locadora INT NOT NULL,
 id_endereco INT NOT NULL,
 id_telefone INT NOT NULL, PRIMARY KEY (id_funcionario), FOREIGN KEY (id_locadora) REFERENCES LOVETEC.Locadora (id_locadora), FOREIGN KEY (id_endereco) REFERENCES LOVETEC.Endereco (id_endereco), FOREIGN KEY (id_telefone) REFERENCES LOVETEC.Telefone (id_telefone)
);

-- Tabela Sessao
CREATE TABLE IF NOT EXISTS LOVETEC.Sessao (
 id_sessao INT NOT NULL AUTO_INCREMENT,
 id_usuario INT NOT NULL,
 tipo_usuario ENUM('cliente', 'funcionario') NOT NULL,
 PRIMARY KEY (id_sessao)
);