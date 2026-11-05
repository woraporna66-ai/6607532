# SL33Z – Clothing Store

ระบบเว็บไซต์จัดการร้านขายเสื้อผ้าออนไลน์ พัฒนาด้วย PHP และ MySQL โดยใช้ Docker Compose ในการติดตั้งและจัดการระบบ

## Technologies Used
- PHP 8.2
- Apache
- MySQL 8.4
- phpMyAdmin
- Docker
- Docker Compose

## Features
- Dashboard แสดงข้อมูลสรุปสินค้า
- แสดงรายการสินค้า
- เพิ่มสินค้า (Create)
- แก้ไขสินค้า (Update)
- ลบสินค้า (Delete)
- เชื่อมต่อฐานข้อมูล MySQL ด้วย PDO
- จัดการฐานข้อมูลผ่าน phpMyAdmin

## Database Structure

ระบบประกอบด้วย 2 ตาราง

### 1. categories
จัดเก็บข้อมูลหมวดหมู่สินค้า

### 2. products
จัดเก็บข้อมูลสินค้า โดยมี category_id เป็น Foreign Key เชื่อมโยงกับ categories.id

ความสัมพันธ์: One-to-Many  
หนึ่งหมวดหมู่สามารถมีสินค้าได้หลายรายการ

## Project Structure

```text
sl33z/
├── Dockerfile
├── docker-compose.yml
├── README.md
├── database/
│   └── init.sql
└── src/
    ├── config.php
    ├── index.php
    ├── products.php
    ├── add_product.php
    ├── edit_product.php
    └── delete_product.php
```

## Installation and Usage

1. ติดตั้ง Docker และ Docker Compose
2. ดาวน์โหลดโปรเจกต์จาก GitHub
3. เปิด Terminal ในโฟลเดอร์โปรเจกต์
4. รันคำสั่ง

```bash
docker compose up -d --build
```

5. เปิดเว็บไซต์

http://localhost:8082

6. เปิด phpMyAdmin

http://localhost:8083

## Database Configuration
Database credentials are configured using environment variables in the `.env` file.

For setup, copy `.env.example` to `.env` and configure your own credentials.
## Data Persistence

ใช้ Docker Volume ชื่อ sl33z-data เพื่อเก็บข้อมูล MySQL ให้คงอยู่แม้หยุดหรือสร้าง Container ใหม่
