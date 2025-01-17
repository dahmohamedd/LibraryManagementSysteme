
-- Creating database
CREATE DATABASE IF NOT EXISTS LibraryManagement;
USE LibraryManagement;

-- Creating Users table
CREATE TABLE IF NOT EXISTS Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Creating Categories table
CREATE TABLE IF NOT EXISTS Categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

-- Creating Authors table
CREATE TABLE IF NOT EXISTS Authors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

-- Creating Books table
CREATE TABLE IF NOT EXISTS Books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    category_id INT,
    author_id INT,
    is_available BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (category_id) REFERENCES Categories(id) ON DELETE SET NULL,
    FOREIGN KEY (author_id) REFERENCES Authors(id) ON DELETE SET NULL
);

-- Creating Loans table
CREATE TABLE IF NOT EXISTS Loans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    book_id INT,
    loan_date DATE NOT NULL,
    return_date DATE,
    status ENUM('borrowed', 'returned') DEFAULT 'borrowed',
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES Books(id) ON DELETE CASCADE
);

-- Inserting sample data
INSERT INTO Users (name, email, password) VALUES 
('Alice Johnson', 'alice@example.com', 'password123'),
('Bob Smith', 'bob@example.com', 'password456');

INSERT INTO Categories (name) VALUES 
('Science Fiction'), 
('Non-Fiction'), 
('Mystery');

INSERT INTO Authors (name) VALUES 
('Isaac Asimov'), 
('Malcolm Gladwell'), 
('Agatha Christie');

INSERT INTO Books (title, category_id, author_id, is_available) VALUES 
('Foundation', 1, 1, TRUE),
('Outliers', 2, 2, TRUE),
('Murder on the Orient Express', 3, 3, TRUE);

INSERT INTO Loans (user_id, book_id, loan_date, return_date, status) VALUES 
(1, 1, '2025-01-10', NULL, 'borrowed');
