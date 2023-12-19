-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS flagfootball;
USE flagfootball;

-- Eliminar tablas si existen
DROP TABLE IF EXISTS Estadisticas;
DROP TABLE IF EXISTS Partidos;
DROP TABLE IF EXISTS Jugador;
DROP TABLE IF EXISTS Equipo;
DROP TABLE IF EXISTS Liga;

-- Crear tabla Liga
CREATE TABLE Liga (
    ID_Liga INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(255),
    Localidad VARCHAR(255)
);

-- Crear tabla Equipo
CREATE TABLE Equipo (
    ID_Equipo INT AUTO_INCREMENT PRIMARY KEY,
    Ciudad VARCHAR(255),
    Nombre VARCHAR(255),
    ID_Liga INT,
    FOREIGN KEY (ID_Liga) REFERENCES Liga(ID_Liga)
);

-- Crear tabla Jugador
CREATE TABLE Jugador (
    ID_Jugador INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(255),
    Apellido VARCHAR(255),
    Numero INT,
    ID_Equipo INT,
    FOREIGN KEY (ID_Equipo) REFERENCES Equipo(ID_Equipo)
);

-- Crear tabla Partidos
CREATE TABLE Partidos (
    ID_Partido INT AUTO_INCREMENT PRIMARY KEY,
    ID_Liga INT,
    ID_Equipo_Local INT,
    ID_Equipo_Visitante INT,
    Resultado VARCHAR(255),
    FOREIGN KEY (ID_Liga) REFERENCES Liga(ID_Liga),
    FOREIGN KEY (ID_Equipo_Local) REFERENCES Equipo(ID_Equipo),
    FOREIGN KEY (ID_Equipo_Visitante) REFERENCES Equipo(ID_Equipo)
);

-- Crear tabla Estadisticas
CREATE TABLE Estadisticas (
    ID_Estadisticas INT AUTO_INCREMENT PRIMARY KEY,
    ID_Jugador INT,
    Touchdowns INT,
    ExtraPoints INT,
    Partidos_Jugados INT,
    Puntos_Marcados INT,
    FOREIGN KEY (ID_Jugador) REFERENCES Jugador(ID_Jugador)
);
