-- ------------------------------------------------------------------------------------------------
-- DROPA AS TABELAS EXISTENTES
-- ------------------------------------------------------------------------------------------------

drop table if exists escolaridades;
drop table if exists escolaridades_tipos;
drop table if exists vagas_curriculos;
drop table if exists vagas;
drop table if exists listas_curriculos;
drop table if exists listas;
drop table if exists cargos_curriculos;
drop table if exists cargos;
drop table if exists areas;
drop table if exists notas;
drop table if exists telefones;
drop table if exists anexos;
drop table if exists experiencias;
drop table if exists curriculos_palavras;
drop table if exists curriculos;
--drop table if exists usuarios;


-- ------------------------------------------------------------------------------------------------
-- CRIA AS TABELAS
-- ------------------------------------------------------------------------------------------------

/* normalmente, essa tabela deverá estar presente no sistema 'hospedeiro'
create table usuarios (
    id serial not null primary key,
    nome varchar(50) not null,
    email varchar(100) not null,
    senha char(32) not null,
    ativo boolean not null default true
);
create unique index idx_usuarios_email on usuarios (email);
*/

create table escolaridades (
    id serial not null primary key,
    nome varchar(255) not null,
    ativo boolean not null default true
);

create table escolaridades_tipos (
    id serial not null primary key,
    nome varchar(255) not null,
    ativo boolean not null default true
);

create table curriculos (
    id serial not null primary key,
    cpf numeric(11) not null,
    senha char(32) not null,
    nome varchar(50) not null,
    email varchar(100) not null,
    data_nascimento date not null,
    sexo char(1) not null,
    cidade_id int not null, -- para cidades e estados, utilizar o submódulo "geo".
    pretensao_salarial numeric(16,2),
    observacoes_gerais text,
    dh_cadastro timestamp not null default now(),
    dh_atualizacao timestamp not null,
    pontuacao smallint,
    ativo boolean not null default true,
    escolaridade_id integer not null references escolaridades(id),
    codigo varchar(32) null
);
create index idx_curriculos_cidade_id on curriculos (cidade_id);

create table curriculos_palavras (
    id int not null primary key,
    conteudo text not null,
    dh_atualizacao timestamp not null default now()
);
create index idx_curriculos_palavras_dh_atualizacao on curriculos_palavras (dh_atualizacao);

create table experiencias (
    id serial not null primary key,
    curriculo_id int not null references curriculos (id),
    empresa varchar(50) not null,
    cargo varchar(50) not null,
    resumo_atividades text,
    tempo_trabalho varchar(50),
    contato_pessoa varchar(50),
    contato_telefone varchar(50)
);
create index idx_experiencias_curriculo_id on experiencias (curriculo_id);

create table anexos (
    id serial not null primary key,
    curriculo_id int not null references curriculos (id),
    descricao varchar(255) not null,
    nome_original varchar(255) not null
);
create index idx_anexos_curriculo_id on anexos (curriculo_id);

create table telefones (
    id serial not null primary key,
    curriculo_id int not null references curriculos (id),
    numero varchar(50) not null
);
create index idx_telefones_curriculo_id on telefones (curriculo_id);

create table notas (
    id serial not null primary key,
    curriculo_id int not null references curriculos (id),
    usuario_id int not null references usuarios (id),
    texto text not null,
    dh_cadastro timestamp not null default now(),
    tipo char(1) not null
);
create index idx_notas_curriculo_id on notas (curriculo_id);
create index idx_notas_usuario_id on notas (usuario_id);

create table areas (
    id serial not null primary key,
    nome varchar(50) not null,
    ativa boolean not null default true
);

create table cargos (
    id serial not null primary key,
    area_id int not null references areas(id),
    nome varchar(50) not null,
    ativo boolean not null default true
);
create index idx_cargos_area_id on cargos (area_id);


create table cargos_curriculos (
    id serial not null primary key,
    cargo_id int not null references cargos (id),
    curriculo_id int not null references curriculos (id)
);
create index idx_cargos_curriculos_cargo_id on cargos_curriculos (cargo_id);
create index idx_cargos_curriculos_curriculo_id on cargos_curriculos (curriculo_id);

create table listas (
    id serial not null primary key,
    nome varchar(100) not null,
    data_abertura date not null default now(),
    data_fechamento date
);
ALTER TABLE listas ADD COLUMN cargo_id integer, ADD CONSTRAINT  listas_cargo_id_fk FOREIGN KEY(cargo_id) REFERENCES cargos(id);

create table listas_curriculos (
    id serial not null primary key,
    lista_id int not null references listas (id),
    curriculo_id int not null references curriculos (id)
);
create index idx_listas_curriculos_lista_id on listas_curriculos (lista_id);
create index idx_listas_curriculos_curriculo_id on listas_curriculos (curriculo_id);

create table vagas (
    id serial not null primary key,
    lista_id int not null references listas (id),
    cargo_id int not null references cargos (id),
    quantidade int not null default 1
);
create index idx_vagas_lista_id on vagas (lista_id);
create index idx_vagas_cargo_id on vagas (cargo_id);

-- ------------------------------------------------------------------------------------------------
-- DADOS INICIAIS
-- ------------------------------------------------------------------------------------------------

-- ...

-- ------------------------------------------------------------------------------------------------
-- DADOS DE EXEMPLO PARA DESENVOLVIMENTO E TESTES
-- ------------------------------------------------------------------------------------------------

insert into areas (nome) values
    ('Área Teste 1'),
    ('Área Teste 2'),
    ('Área Teste 3'),
    ('Área Teste 4'),
    ('Área Teste 5');

insert into cargos (area_id, nome) values
    (1, 'Cargo Teste 1.1'),
    (1, 'Cargo Teste 1.2'),
    (1, 'Cargo Teste 1.3'),
    (2, 'Cargo Teste 2.1'),
    (2, 'Cargo Teste 2.2'),
    (2, 'Cargo Teste 2.3'),
    (3, 'Cargo Teste 3.1'),
    (3, 'Cargo Teste 3.2'),
    (3, 'Cargo Teste 3.3'),
    (4, 'Cargo Teste 4.1'),
    (4, 'Cargo Teste 4.2'),
    (4, 'Cargo Teste 4.3'),
    (5, 'Cargo Teste 5.1'),
    (5, 'Cargo Teste 5.2'),
    (5, 'Cargo Teste 5.3');

