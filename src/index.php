<?php
require_once 'config.php';

// นับจำนวนสินค้าทั้งหมด
$productCount = $conn->query("SELECT COUNT(*) FROM products")->fetchColumn();

// นับจำนวนหมวดหมู่
$categoryCount = $conn->query("SELECT COUNT(*) FROM categories")->fetchColumn();

// นับสินค้าที่มีจำนวนคงเหลือน้อยกว่า 5
$lowStock = $conn->query("SELECT COUNT(*) FROM products WHERE stock < 5")->fetchColumn();

// แสดงรายการสินค้าล่าสุด
$sql = "SELECT p.id, p.name, p.price, p.stock, c.name AS category
        FROM products p
        JOIN categories c ON p.category_id = c.id
        ORDER BY p.id DESC
        LIMIT 5";

$products = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SL33Z | Clothing Store</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            color: #222;
        }

        .sidebar {
            width: 230px;
            height: 100vh;
            background: #171717;
            color: white;
            position: fixed;
            padding: 30px 20px;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 3px;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #999;
            font-size: 12px;
            margin-bottom: 45px;
        }

        .sidebar a {
            display: block;
            color: #bbb;
            text-decoration: none;
            padding: 14px;
            margin-bottom: 8px;
            border-radius: 6px;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background: #333;
            color: white;
        }

        .main {
            margin-left: 230px;
            padding: 35px;
        }

        .header {
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 8px;
        }

        .header p {
            color: #777;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        }

        .card p {
            color: #777;
            margin-bottom: 15px;
        }

        .card h2 {
            font-size: 30px;
        }

        .section {
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        .section h2 {
            margin-bottom: 20px;
            font-size: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            color: #777;
            font-size: 13px;
        }

        .stock {
            font-weight: bold;
        }

        @media (max-width: 700px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .subtitle {
                margin-bottom: 15px;
            }

            .main {
                margin-left: 0;
                padding: 20px;
            }

            .cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="sidebar">
    <div class="logo">SL33Z</div>
    <div class="subtitle">CLOTHING STORE</div>

    <a href="index.php" class="active">Dashboard</a>
    <a href="products.php">Products</a>
    <a href="categories.php">Categories</a>
</div>

<div class="main">

    <div class="header">
        <h1>Dashboard</h1>
        <ยินดีต้อนรับสู่ SL33Z Clothing Store - CI/CD Version 2</p>
    </div>

    <div class="cards">
        <div class="card">
            <p>สินค้าทั้งหมด</p>
            <h2><?= $productCount ?></h2>
        </div>

        <div class="card">
            <p>หมวดหมู่ทั้งหมด</p>
            <h2><?= $categoryCount ?></h2>
        </div>

        <div class="card">
            <p>สินค้าใกล้หมด (น้อยกว่า 5 ชิ้น)</p>
            <h2><?= $lowStock ?></h2>
        </div>
    </div>

    <div class="section">
        <h2>สินค้าล่าสุด</h2>

        <table>
            <thead>
                <tr>
                    <th>ชื่อสินค้า</th>
                    <th>หมวดหมู่</th>
                    <th>ราคา</th>
                    <th>คงเหลือ</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= htmlspecialchars($product['category']) ?></td>
                        <td><?= number_format($product['price'], 2) ?> ฿</td>
                        <td class="stock"><?= (int)$product['stock'] ?></td>
                    </tr>
                <?php endforeach; ?>

                <?php if (count($products) === 0): ?>
                    <tr>
                        <td colspan="4">ยังไม่มีสินค้าในระบบ</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
