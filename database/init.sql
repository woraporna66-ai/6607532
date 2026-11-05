CREATE DATABASE IF NOT EXISTS sl33z;
USE sl33z;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    category_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_products_categories
    FOREIGN KEY (category_id)
    REFERENCES categories(id)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);

INSERT INTO categories (name, description) VALUES
('T-Shirts', 'เสื้อยืด'),
('Pants', 'กางเกง'),
('Hoodies', 'เสื้อฮู้ด'),
('Accessories', 'เครื่องประดับและอุปกรณ์เสริม');

INSERT INTO products (name, description, price, stock, category_id) VALUES
('SL33Z Oversized Tee', 'เสื้อยืดทรง Oversized', 390.00, 20, 1),
('SL33Z Cargo Pants', 'กางเกง Cargo', 590.00, 15, 2),
('SL33Z Basic Hoodie', 'เสื้อ Hoodie', 790.00, 10, 3),
('SL33Z Cap', 'หมวกแก๊ป', 250.00, 25, 4),
('SL33Z Graphic Tee', 'เสื้อยืดลายกราฟิก', 450.00, 12, 1);
