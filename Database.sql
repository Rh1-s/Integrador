-- BASE DE DATOS
CREATE DATABASE IF NOT EXISTS Institucion;
USE Institucion;

CREATE TABLE Login (
    UsuarioID INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_Usuario VARCHAR(100),
    Contrasena VARCHAR(100)
);

CREATE TABLE Docentes (
    DocenteID INT AUTO_INCREMENT PRIMARY KEY,
    DNI VARCHAR(12) NOT NULL,
    Nombres VARCHAR(100) NOT NULL,
    Apellidos VARCHAR(100) NOT NULL,
    Direccion VARCHAR(255),
    Fec_Registro DATE NOT NULL
);

CREATE TABLE Alumnos (
    AlumnoID INT AUTO_INCREMENT PRIMARY KEY,
    DNI VARCHAR(12) NOT NULL,
    Nombres VARCHAR(100) NOT NULL,
    Apellidos VARCHAR(100) NOT NULL,
    Fec_Nacimiento DATE,
    Fec_Registro DATE NOT NULL
);

CREATE TABLE Categoria (
    CategoriaID INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_Categoria VARCHAR(50) NOT NULL
);

CREATE TABLE Secciones (
    SeccionID INT AUTO_INCREMENT PRIMARY KEY,
    CategoriaID INT,
    Nombre_Seccion VARCHAR(10) NOT NULL,
    Cupo_Maximo INT NOT NULL,
    FOREIGN KEY (CategoriaID) REFERENCES Categoria(CategoriaID)
);

CREATE TABLE Matriculas (
    MatriculaID INT AUTO_INCREMENT PRIMARY KEY,
    AlumnoID INT,
    SeccionID INT,
    Periodo_Inicio DATE NOT NULL,
    Periodo_Fin DATE NOT NULL,
    Estado VARCHAR(20) NOT NULL,
    FOREIGN KEY (AlumnoID) REFERENCES Alumnos(AlumnoID),
    FOREIGN KEY (SeccionID) REFERENCES Secciones(SeccionID)
);

CREATE TABLE Apoderados (
    ApoderadoID INT AUTO_INCREMENT PRIMARY KEY,
    DNI VARCHAR(100) NOT NULL,
    Nombres VARCHAR(100) NOT NULL,
    Apellidos VARCHAR(100) NOT NULL,
    Telefono VARCHAR(12),
    Correo VARCHAR(100),
    Dirección VARCHAR(255)
);

CREATE TABLE Asistencias (
    AsistenciaID INT AUTO_INCREMENT PRIMARY KEY,
    AlumnoID INT,
    Fecha DATE NOT NULL,
    Estado VARCHAR(20) NOT NULL,
    FOREIGN KEY (AlumnoID) REFERENCES Alumnos(AlumnoID)
);

CREATE TABLE Observaciones (
    ObservacionID INT AUTO_INCREMENT PRIMARY KEY,
    AlumnoID INT,
    DocenteID INT,
    Fecha DATE,
    Comentario TEXT,
    FOREIGN KEY (AlumnoID) REFERENCES Alumnos(AlumnoID),
    FOREIGN KEY (DocenteID) REFERENCES Docentes(DocenteID)
);


-- Login
INSERT INTO Login (Nombre_Usuario, contrasena) VALUES ('admin', '1234');



-- CATEGORIA
INSERT INTO Categoria (Nombre_Categoria) VALUES ('Inicial');

-- SECCIONES
INSERT INTO Secciones (CategoriaID, Nombre_Seccion, Cupo_Maximo) VALUES
(1, 'Aula 1', 14),
(1, 'Aula 2', 10),
(1, 'Aula 3', 6),
(1, 'Aula 4', 4);

-- DOCENTES
INSERT INTO Docentes (DNI, Nombres, Apellidos, Direccion, Fec_Registro) VALUES 
('71451634','Martha','Zurita Meza','Jirón Joaquín capello 3054','2022-03-10'),
('73251509','Nataly Maria','Ulloa Zurita','Jirón Joaquín capello 3050','2018-03-02'),
('71957702','Isandra','Carranza Choque','Av. La marina 4050','2024-08-10'),
('67113562','Veronica','Alvarez Quispe','Jirón Crespo y Castilo 3049','2023-03-01'),
('75548164','Ana Rosa','Ulloa Zurita','Jirón Miguel Grau 6084 - La Lerla','2014-01-20');

-- ALUMNOS
INSERT INTO Alumnos (DNI, Nombres, Apellidos, Fec_Nacimiento, Fec_Registro) VALUES 
('92251762','Mia Cataleya','Fenco Huamani','2021-02-28', '2024-03-02'),
('92031777','Zeus Kalel Eduardo','Villar Infante','2020-09-24', '2024-02-28'),
('91449083','Diego Alonso','Estada Almonacid','2019-07-19', '2023-03-03'),
('91294943','Saul Ezequiel','Ortiz Zevallos','2019-04-19', '2023-03-03'),
('91281568','Alessandro Benyamin','Quispe Gavilan','2019-04-09', '2025-03-05'),
('91699456','Thiago Guillermo','Valenzuela Apaza','2020-01-26', '2025-03-05'),
('91431444','Danna Danuska','Zapata Luna','2019-07-23', '2023-03-01'),
('92646723','Danae Brianna Zendaya','Rivera Iquiapaza','2021-11-29', '2025-02-26'),
('92448265','Luna Morita','Allpacca Ccorahua','2021-07-14', '2025-02-19'),
('92432241','Kendall Rafael','Loyo Meza','2021-07-03', '2025-02-20'),
('92676328','Carlos Patricio','Semblantes Martinez','2021-12-20', '2025-02-22'),
('91884015','Gael Emiliano','Aguilar Pacheco','2020-06-08', '2023-03-01'),
('92294641','Raphael Nehemias','Calluchi Naveros','2021-03-30', '2023-03-04'),
('92012621','Jesus Efraim','Castro Carrera','2020-09-11', '2023-02-15'),
('91924775','Valentin Rey','Infante Taboada','2020-07-10', '2025-02-16'),
('92110236','Joaquin Abraham','Ramos Pinto','2020-11-14', '2025-02-25'),
('91839551','Kylie Rousse','Semblantes Martinez','2020-05-04', '2025-02-16');

-- MATRICULAS
INSERT INTO Matriculas (AlumnoID, SeccionID, Periodo_Inicio, Periodo_Fin, Estado) VALUES 
(1,1,'2025-03-05','2025-12-19','Activo'),
(2,1,'2025-03-05','2025-12-19','Activo'),
(12,1,'2025-03-05','2025-12-19','Activo'),
(13,1,'2025-03-05','2025-12-19','Activo'),
(14,1,'2025-03-05','2025-12-19','Activo'),
(15,1,'2025-03-05','2025-12-19','Activo'),
(16,1,'2025-03-05','2025-12-19','Activo'),
(17,1,'2025-03-05','2025-12-19','Activo'),
(3,2,'2025-03-05','2025-12-19','Activo'),
(4,2,'2025-03-05','2025-12-19','Activo'),
(5,2,'2025-03-05','2025-12-19','Activo'),
(6,2,'2025-03-05','2025-12-19','Activo'),
(7,2,'2025-03-05','2025-12-19','Activo'),
(8,3,'2025-03-05','2025-12-19','Activo'),
(9,3,'2025-03-05','2025-12-19','Activo'),
(10,3,'2025-03-05','2025-12-19','Activo'),
(11,3,'2025-03-05','2025-12-19','Activo');

-- APODERADOS
INSERT INTO Apoderados (DNI, Nombres, Apellidos, Telefono, Correo, Dirección) VALUES 
('71334561','Carlos Andrés','Aguilar Rojas', '973901820', 'carlos.gutierrez@email.com', 'Jirón Crespo y Castillo 2099'),
('70014581','Mariana Elena','Zevallos Torres', '922911332', 'mariana.torres@email.com', 'Jr. Armendariz 2010'),
('71234541','José Manuel','Calluchi Olivares', '999922820', 'jose.paredes@email.com', 'Avenida Universitaria 3914'),
('74456561','Patricia Rosa','Gavilan Aguilar', '955965821', 'patricia.mendoza@email.com', 'AV. Grau 3030'),
('78809551','Ricardo Iván','Castro Leon', '945646821', 'ricardo.castaneda@email.com', 'Calle Esperanza 2005'),
('72834521','Ana Lucía','Apaza Ramírez', '911256785', 'ana.chavez@email.com', 'Calle Pescadores 2124'),
('74232521','Miguel Ángel','Ramos Ponce', '903911824', 'miguel.romero@email.com', 'Jirón Grau, La perla'),
('75939531','Claudia Teresa','Infante Núñez', '918252334', 'claudia.delgado@email.com', 'Los eucaliptos 2512'),
('70330591','Luis Enrique','Semblantes Quispe', '943856204', 'luis.herrera@email.com', 'Av. La marina cruce con Av. Universitaria'),
('71104561','Sonia Milagros','Meza Zambrano', '959924214', 'sonia.vargas@email.com', 'Calle Chacarilla 2055');

-- ASISTENCIAS
INSERT INTO Asistencias (AlumnoID, Fecha, Estado) VALUES 
(1,'2025-03-12','Presente'),
(2,'2025-03-12','Presente'),
(3,'2025-03-12','Presente');

-- OBSERVACIONES
INSERT INTO Observaciones (AlumnoID, DocenteID, Fecha, Comentario) VALUES 
(1,2,'2025-03-12','Inquietud'),
(4,3,'2025-03-12','Agresivo'),
(5,1,'2025-03-12','Felicitaciones');
