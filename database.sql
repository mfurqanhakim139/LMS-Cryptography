CREATE DATABASE IF NOT EXISTS kursus_lms_db;
USE kursus_lms_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user'
);

CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT
);

CREATE TABLE certificates (
    reg_number VARCHAR(50) PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    score VARCHAR(10) NOT NULL,
    issued_date DATE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (course_id) REFERENCES courses(id)
);

INSERT INTO users (name, email, password, role) VALUES 
('Administrator', 'admin@ugk.ac.id', 'admin123', 'admin'),
('Arga Chon Feriandref', 'arga@student.ac.id', 'siswa123', 'user');

INSERT INTO courses (title, description) VALUES ('Mastering PHP Native MVC', 'Belajar arsitektur MVC');
INSERT INTO certificates (reg_number, user_id, course_id, score, issued_date) VALUES 
('REG-UGK-001', 2, 1, '98/100', '2026-05-02');
