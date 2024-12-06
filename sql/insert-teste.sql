-- Inserindo tipos de endereço
INSERT INTO LOVETEC.Tipo_Endereco (tipo_endereco) VALUES
('Residencial'),
('Comercial'),
('Corporativo'),
('Industrial');

-- Inserindo tipos de telefone
INSERT INTO LOVETEC.Tipo_Telefone (tipo_telefone) VALUES
('Celular'),
('Fixo'),
('Comercial'),
('Emergencial');

-- Inserindo endereços
INSERT INTO LOVETEC.Endereco (rua, bairro, cidade, estado, cep, id_tipo_endereco) VALUES
('Rua das Flores', 'Centro', 'São Paulo', 'SP', '01000-000', 1),
('Av. Paulista', 'Bela Vista', 'São Paulo', 'SP', '01310-000', 2),
('Rua 15 de Novembro', 'Centro', 'Campinas', 'SP', '13010-000', 3);

-- Inserindo telefones
INSERT INTO LOVETEC.Telefone (numero_telefone, id_tipo_telefone) VALUES
('11987654321', 1),
('1123456789', 2),
('1932345678', 3);

-- Inserindo veículos
INSERT INTO LOVETEC.Veiculo (modelo, placa, valor_diaria, ano_fabricacao, cor) VALUES
('Fusca', 'ABC-1234', 100.00, 1975, 'Azul'),
('Civic', 'XYZ-4321', 200.00, 2020, 'Preto'),
('Fiesta', 'LMN-7890', 150.00, 2018, 'Branco');

-- Inserindo locações
INSERT INTO LOVETEC.Locacao (data_inicial, data_final, valor_diaria, valor_final, id_veiculo) VALUES
('2024-12-01', '2024-12-07', 100.00, 700.00, 1),
('2024-12-05', '2024-12-10', 200.00, 1000.00, 2),
('2024-12-10', '2024-12-12', 150.00, 300.00, 3);

-- Inserindo clientes
INSERT INTO LOVETEC.Cliente (nome_cliente, data_nasc, num_cnh, id_endereco, id_telefone) VALUES
('Carlos Silva', '1985-05-12', 123456789, 1, 1),
('Ana Pereira', '1990-11-20', 987654321, 2, 2),
('Pedro Souza', '1982-02-15', 112233445, 3, 3);

-- Inserindo locadoras
INSERT INTO LOVETEC.Locadora (nome_locadora, cnpj, id_endereco, id_telefone) VALUES
('Locadora São Paulo', '12345678000199', 1, 1),
('Locadora Campinas', '98765432000110', 2, 2);

-- Inserindo funcionários
INSERT INTO LOVETEC.Funcionario (nome_funcionario, email, senha, id_locadora, id_endereco, id_telefone) VALUES
('João Oliveira', 'joao@locadora.com', 'senha123', 1, 1, 1),
('Maria Santos', 'maria@locadora.com', 'senha456', 2, 2, 2);