-- ---------------------------------------------------------
-- Admins table
-- Stores backend users (not customers). Just simple auth.
-- ---------------------------------------------------------
CREATE TABLE admins (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,         -- admin's display name
    email VARCHAR(255) NOT NULL UNIQUE, -- login email (must be unique)
    password VARCHAR(255) NOT NULL,     -- hashed password
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ---------------------------------------------------------
-- Products table
-- Each row represents one teddy bear in the shop :)
-- ---------------------------------------------------------
CREATE TABLE products (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,        -- product name
    description TEXT NOT NULL,          -- details / story about the bear
    price DECIMAL(8,2) NOT NULL DEFAULT 0.00, -- product price (2 decimals)
    image VARCHAR(255) NOT NULL,        -- filename of uploaded image
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
