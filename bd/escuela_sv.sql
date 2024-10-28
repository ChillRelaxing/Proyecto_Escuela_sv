-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS escuela_sv;
USE escuela_sv;
 
 -- Ejecutar de ultimo
 -- Haseo de contraseña para poder iniciar sesion
UPDATE usuarios
SET password = '$2y$10$KUVrASsKKRnpSA98mCyLeuZ5N95OW0ccTfdxV8A.8LTGD40By.es.'
WHERE id_usuario = 1;
 
-- Crear tabla de roles
CREATE TABLE roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE
);

-- Crear tabla de usuarios
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    id_rol INT NOT NULL,
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol) ON DELETE RESTRICT
);

-- Crear tabla de materias/cursos
CREATE TABLE materias_cursos (
    id_materia_curso INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255) NOT NULL
);

-- Crear tabla de estudiantes
CREATE TABLE estudiantes (
    id_estudiante INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    telefono VARCHAR(15),
    carnet VARCHAR(50) NOT NULL UNIQUE,
    modalidad ENUM('Presencial', 'Virtual') NOT NULL
);

-- Crea tabla intermedia para la relación muchos a muchos entre estudiantes y materias/cursos
CREATE TABLE estudiante_materia (
    id_estudiante_materia INT AUTO_INCREMENT PRIMARY KEY,
    id_estudiante INT,
    id_materia_curso INT,
    FOREIGN KEY (id_estudiante) REFERENCES estudiantes(id_estudiante) ON DELETE CASCADE,
    FOREIGN KEY (id_materia_curso) REFERENCES materias_cursos(id_materia_curso) ON DELETE CASCADE
);

-- Crear tabla de reportes
CREATE TABLE reportes (
    id_reporte INT AUTO_INCREMENT PRIMARY KEY,
    id_estudiante INT,
    id_usuario INT,
    id_materia_curso INT,
    fecha_reporte DATE NOT NULL,
    descripcion LONGTEXT,
    FOREIGN KEY (id_estudiante) REFERENCES estudiantes(id_estudiante) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_materia_curso) REFERENCES materias_cursos(id_materia_curso) ON DELETE CASCADE
);

-- Ver registros de la tabla roles
SELECT * FROM roles;

-- Ver registros de la tabla usuarios
SELECT * FROM usuarios;

-- Ver registros de la tabla materias/cursos
SELECT * FROM materias_cursos;

-- Ver registros de la tabla estudiantes
SELECT * FROM estudiantes;

-- Ver registros de la tabla estudiante_materia (relaciones entre estudiantes y materias/cursos)
SELECT * FROM estudiante_materia;

-- Ver registros de la tabla reportes
SELECT * FROM reportes;

-- Insertar en la tabla roles
INSERT INTO roles (nombre) VALUES ('Admin'), ('Profesor');

-- Insertar en la tabla usuarios 
INSERT INTO usuarios (nombre, apellido, correo, password, id_rol) 
VALUES ('Juan', 'Pérez', 'juan.perez@escuela.com', ('Leo503'), 1),
       ('Ana', 'Gómez', 'ana.gomez@escuela.com', ('Villa503'), 2);

-- Insertar en la tabla materias/cursos
INSERT INTO materias_cursos (nombre, descripcion) 
VALUES ('Matemáticas', 'Curso de matemáticas básicas'),
       ('Historia', 'Curso de historia universal');

-- Insertar en la tabla estudiantes
INSERT INTO estudiantes (nombre, apellido, correo, telefono, carnet, modalidad)
VALUES ('Carlos', 'López', 'carlos.lopez@escuela.com', '555123456', 'CL2023001', 'Presencial'),
       ('María', 'Ramírez', 'maria.ramirez@escuela.com', '555654321', 'MR2023002', 'Virtual');

-- Insertar en la tabla estudiante_materia (relación entre estudiantes y materias/cursos)
INSERT INTO estudiante_materia (id_estudiante, id_materia_curso)
VALUES (1, 1), -- Carlos López cursa Matemáticas
       (2, 2); -- María Ramírez cursa Historia

-- Insertar en la tabla reportes
INSERT INTO reportes (id_estudiante, id_usuario, id_materia_curso, fecha_reporte, descripcion)
VALUES (1, 1, 1, '2024-09-15', 'Problemas de asistencia en matemáticas'),
       (2, 2, 2, '2024-09-16', 'Problemas con las tareas de historia');





