-- ====================================================================================================================
-- Script de criação e (re)inicialização do banco de dados.
-- ====================================================================================================================

-- use projeto_padrao_zf2;


-- ====================================================================================================================
-- Dropa as tabelas existentes.
-- ====================================================================================================================

drop table if exists usuarios;
drop table if exists noticias;

-- ====================================================================================================================
-- Cria as tabelas.
-- ====================================================================================================================

-- --------------------------------------------------------------------------------------------------------------------
-- NOTICIAS
-- --------------------------------------------------------------------------------------------------------------------
create table noticias (
    id int unsigned not null primary key auto_increment,
    --
    titulo varchar(100) not null,
    chamada text,
    descricao text,
    --
    criacao datetime not null,
    modificacao datetime not null,
    exclusao datetime,
    visivel tinyint(1) not null default 1
) engine=InnoDB default charset=utf8;

create index idx_noticias_criacao on noticias (criacao);
create index idx_noticias_modificacao on noticias (modificacao);
create index idx_noticias_visivel on noticias (visivel);

-- --------------------------------------------------------------------------------------------------------------------
-- USUARIOS
-- --------------------------------------------------------------------------------------------------------------------
create table usuarios (
    id int unsigned not null primary key auto_increment,
    --
    nome varchar(50) not null,
    login varchar(50) not null,
    senha char(32) not null,
    perfil varchar(10) not null, -- "admin"
    tentativas_login int not null default 0, -- "admin"
    --
    criacao datetime not null,
    modificacao datetime not null,
    exclusao datetime,
    visivel tinyint(1) not null default 1    
) engine=InnoDB default charset=utf8;

create unique index idx_usuarios_login on usuarios (login);
create index idx_usuarios_criacao on usuarios (criacao);
create index idx_usuarios_modificacao on usuarios (modificacao);
create index idx_usuarios_visivel on usuarios (visivel);

-- --------------------------------------------------------------------------------------------------------------------
-- USUARIOS
-- --------------------------------------------------------------------------------------------------------------------
insert into usuarios (id, nome, login, senha, perfil, criacao, modificacao)
values
(1, 'Magic Web Design', 'magic', md5('D#N041'), 'admin', now(), now());