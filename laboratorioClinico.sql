-- Crear base de datos


-- ============================
-- TABLAS
-- ============================

-- Tabla: paciente
CREATE TABLE paciente (
    id_paciente INT AUTO_INCREMENT PRIMARY KEY,
    documento VARCHAR(50) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    telefono VARCHAR(30),
    email VARCHAR(100),
    estado VARCHAR(20)
);

-- Tabla: medico
CREATE TABLE medico (
    id_medico INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    matricula VARCHAR(50),
    telefono VARCHAR(30),
    email VARCHAR(100),
    estado VARCHAR(20)
);

-- Tabla: tipo_examen
CREATE TABLE tipo_examen (
    id_tipo_examen INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    estado VARCHAR(20)
);

-- Tabla: examen
CREATE TABLE examen (
    id_examen INT AUTO_INCREMENT PRIMARY KEY,
    tipo_examen_id INT,
    paciente_id INT,
    medico_id INT,
    fecha DATE,
    estado VARCHAR(20),
    FOREIGN KEY (tipo_examen_id) REFERENCES tipo_examen(id_tipo_examen),
    FOREIGN KEY (paciente_id) REFERENCES paciente(id_paciente),
    FOREIGN KEY (medico_id) REFERENCES medico(id_medico)
);

-- Tabla: resultado
CREATE TABLE resultado (
    id_resultado INT AUTO_INCREMENT PRIMARY KEY,
    examen_id INT,
    parametro VARCHAR(50),
    valor VARCHAR(50),
    unidad VARCHAR(50),
    referencia VARCHAR(50),
    observacion VARCHAR(100),
    FOREIGN KEY (examen_id) REFERENCES examen(id_examen)
);

-- Tabla: cita
CREATE TABLE cita (
    id_cita INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT,
    medico_id INT,
    fecha DATE,
    hora TIME,
    estado VARCHAR(20),
    FOREIGN KEY (paciente_id) REFERENCES paciente(id_paciente),
    FOREIGN KEY (medico_id) REFERENCES medico(id_medico)
);

-- Tabla: factura
CREATE TABLE factura (
    id_factura INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT,
    fecha DATE,
    total DECIMAL(10,2),
    estado VARCHAR(20),
    FOREIGN KEY (paciente_id) REFERENCES paciente(id_paciente)
);

-- Tabla: pago
CREATE TABLE pago (
    id_pago INT AUTO_INCREMENT PRIMARY KEY,
    factura_id INT,
    monto DECIMAL(10,2),
    fecha DATE,
    tipo_pago VARCHAR(20),
    FOREIGN KEY (factura_id) REFERENCES factura(id_factura)
);

-- Tabla: empleado
CREATE TABLE empleado (
    id_empleado INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    cargo VARCHAR(50),
    email VARCHAR(100),
    estado VARCHAR(20)
);

-- Tabla: muestra
CREATE TABLE muestra (
    id_muestra INT AUTO_INCREMENT PRIMARY KEY,
    examen_id INT,
    tipo VARCHAR(20),
    fecha_toma DATE,
    estado VARCHAR(20),
    FOREIGN KEY (examen_id) REFERENCES examen(id_examen)
);

-- ============================
-- INSERTS DE EJEMPLO
-- ============================

-- Pacientes
INSERT INTO paciente (documento, nombre, telefono, email, estado) VALUES
('1234567', 'Carlos Pérez', '0981123456', 'carlos@example.com', 'Activo'),
('2345678', 'María Gómez', '0981765432', 'maria@example.com', 'Activo'),
('3456789', 'Luis Duarte', '0971555444', 'luis@example.com', 'Activo'),
('4567890', 'Ana Rojas', '0961999888', 'ana@example.com', 'Inactivo'),
('5678901', 'Pedro Cáceres', '0972888777', 'pedro@example.com', 'Activo');

-- Médicos
INSERT INTO medico (nombre, matricula, telefono, email, estado) VALUES
('Dr. Juan López', 'M1234', '0981777333', 'juanlopez@hospital.com', 'Activo'),
('Dra. Laura Ruiz', 'M2345', '0981333444', 'lauraruiz@hospital.com', 'Activo'),
('Dr. Hugo Sánchez', 'M3456', '0981555666', 'hugosanchez@hospital.com', 'Activo'),
('Dra. Paula Vera', 'M4567', '0981444333', 'paulavera@hospital.com', 'Inactivo'),
('Dr. Mario Benítez', 'M5678', '0981666777', 'mariobenitez@hospital.com', 'Activo');

-- Tipos de examen
INSERT INTO tipo_examen (nombre, estado) VALUES
('Hematología completa', 'Activo'),
('Análisis de orina', 'Activo'),
('Glucosa en sangre', 'Activo'),
('Colesterol total', 'Activo'),
('Prueba COVID-19', 'Activo');

-- Exámenes
INSERT INTO examen (tipo_examen_id, paciente_id, medico_id, fecha, estado) VALUES
(1, 1, 1, '2025-10-01', 'Procesado'),
(2, 2, 2, '2025-10-02', 'Pendiente'),
(3, 3, 3, '2025-10-03', 'Procesado'),
(4, 4, 4, '2025-10-04', 'Pendiente'),
(5, 5, 5, '2025-10-05', 'Procesado');

-- Resultados
INSERT INTO resultado (examen_id, parametro, valor, unidad, referencia, observacion) VALUES
(1, 'Hemoglobina', '14.2', 'g/dL', '12-16', 'Normal'),
(2, 'Proteínas', 'Negativo', '', 'Negativo', 'Sin hallazgos'),
(3, 'Glucosa', '95', 'mg/dL', '70-110', 'Normal'),
(4, 'Colesterol', '220', 'mg/dL', '<200', 'Levemente alto'),
(5, 'PCR', 'Negativo', '', 'Negativo', 'Sin infección detectada');

-- Citas
INSERT INTO cita (paciente_id, medico_id, fecha, hora, estado) VALUES
(1, 1, '2025-09-30', '08:30:00', 'Atendida'),
(2, 2, '2025-09-30', '09:00:00', 'Atendida'),
(3, 3, '2025-10-01', '10:00:00', 'Pendiente'),
(4, 4, '2025-10-02', '11:00:00', 'Cancelada'),
(5, 5, '2025-10-03', '08:00:00', 'Atendida');

-- Facturas
INSERT INTO factura (paciente_id, fecha, total, estado) VALUES
(1, '2025-10-01', 150000, 'Pagada'),
(2, '2025-10-02', 120000, 'Pendiente'),
(3, '2025-10-03', 200000, 'Pagada'),
(4, '2025-10-04', 180000, 'Anulada'),
(5, '2025-10-05', 250000, 'Pagada');

-- Pagos
INSERT INTO pago (factura_id, monto, fecha, tipo_pago) VALUES
(1, 150000, '2025-10-01', 'Efectivo'),
(2, 60000, '2025-10-02', 'Tarjeta'),
(3, 200000, '2025-10-03', 'Transferencia'),
(4, 0, '2025-10-04', 'N/A'),
(5, 250000, '2025-10-05', 'Efectivo');

-- Empleados
INSERT INTO empleado (nombre, cargo, email, estado) VALUES
('Marcos Ayala', 'Recepcionista', 'marcos@lab.com', 'Activo'),
('Lucía Díaz', 'Bioquímica', 'lucia@lab.com', 'Activo'),
('Roberto López', 'Técnico', 'roberto@lab.com', 'Activo'),
('Sandra Giménez', 'Cajera', 'sandra@lab.com', 'Inactivo'),
('Miguel Ortiz', 'Administrador', 'miguel@lab.com', 'Activo');

-- Muestras
INSERT INTO muestra (examen_id, tipo, fecha_toma, estado) VALUES
(1, 'Sangre', '2025-10-01', 'Analizada'),
(2, 'Orina', '2025-10-02', 'Pendiente'),
(3, 'Sangre', '2025-10-03', 'Analizada'),
(4, 'Sangre', '2025-10-04', 'Pendiente'),
(5, 'Hisopo', '2025-10-05', 'Analizada');
