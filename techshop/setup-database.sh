#!/bin/bash

# Script to setup MySQL database and user for Laravel TechShop

echo "🔧 Setting up MySQL database and user..."

# Create database
sudo mysql -u root <<EOF
-- Create database if not exists
CREATE DATABASE IF NOT EXISTS techshop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Drop user if exists and recreate (for Laravel application)
DROP USER IF EXISTS 'laravel'@'localhost';
CREATE USER 'laravel'@'localhost' IDENTIFIED BY '123456';
GRANT ALL PRIVILEGES ON techshop.* TO 'laravel'@'localhost';
FLUSH PRIVILEGES;

-- Show databases
SHOW DATABASES;
EOF

echo "✅ Database and user setup completed!"
echo ""
echo "Database: techshop"
echo "User: laravel"
echo "Password: 123456"
echo ""
echo "Root user can now access MySQL without password using: sudo mysql -u root"
