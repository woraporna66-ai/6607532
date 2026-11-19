
<?php
require_once 'config.php';

// ดึงหมวดหมู่พร้อมนับจำนวนสินค้าในแต่ละหมวดหมู่
$sql = "SELECT c.id, c.name, c.description, COUNT(p.id) AS product_count
        FROM categories c
        LEFT JOIN products p ON c.id = p.category_id
        GROUP BY c.id, c.name, c.description
        ORDER BY c.id ASC";

$categories = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories | SL33Z</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #101010;
            color: #f5f5f5;
        }

        .sidebar {
            width: 230px;
            height: 100vh;
            background: #080808;
            color: white;
            position: fixed;
            padding: 35px 20px;
            border-right: 1px solid #292929;
        }

        .logo {
            font-size: 30px;
            font-weight: bold;
            letter-spacing: 4px;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #777;
            font-size: 11px;
            letter-spacing: 2px;
            margin-bottom: 55px;
        }

        .sidebar a {
            display: block;
            color: #999;
            text-decoration: none;
            padding: 15px;
            margin-bottom: 8px;
            border-radius: 5px;
            transition: 0.2s;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background: #252525;
            color: white;
        }

        .main {
            margin-left: 230px;
            padding: 45px;
        }

        .header {
            margin-bottom: 35px;
        }

        .header h1 {
            font-size: 34px;
            margin-bottom: 10px;
        }

        .header p {
            color: #888;
        }

        .summary {
            background: #191919;
            border: 1px solid #303030;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .summary p {
            color: #999;
            margin-bottom: 12px;
        }

        .summary h2 {
            font-size: 32px;
        }

        .section {
            background: #191919;
            border: 1px solid #303030;
            border-radius: 8px;
            padding: 28px;
            overflow-x: auto;
        }

        .section h2 {
            font-size: 20px;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            min-width: 550px;
            border-collapse: collapse;
        }

        th, td {
            padding: 17px 14px;
            text-align: left;
            border-bottom: 1px solid #303030;
        }

        th {
            color: #888;
            font-size: 12px;
            letter-spacing: 1px;
        }

        td {
            color: #ddd;
            font-size: 14px;
        }

        tr:hover td {
            background: #222;
        }

        .count {
            display: inline-block;
            background: #303030;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
        }

        .empty {
            text-align: center;
            color: #888;
            padding: 30px;
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
        }
    </style>
</head>

<body>

<div class="sidebar">
    <div class="logo">SL33Z</div>
    <div class="subtitle">CLOTHING STORE</div>

    <a href="index.php">Dashboard</a>
    <a href="products.php">Products</a>
    <a href="categories.php" class="active">Categories</a>
</div>

<div class="main">

    <div class="header">
        <h1>Categories</h1>
        <p>จัดการและตรวจสอบหมวดหมู่สินค้าในร้าน SL33Z</p>
    </div>

    <div class="summary">
        <p>หมวดหมู่ทั้งหมด</p>
        <h2><?= count($categories) ?></h2>
    </div>

    <div class="section">
        <h2>รายการหมวดหมู่สินค้า</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ชื่อหมวดหมู่</th>
                    <th>รายละเอียด</th>
                    <th>จำนวนสินค้า</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= (int)$category['id'] ?></td>
                        <td><?= htmlspecialchars($category['name']) ?></td>
                        <td><?= htmlspecialchars($category['description'] ?? '') ?></td>
                        <td>
                            <span class="count">
                                <?= (int)$category['product_count'] ?> รายการ
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (count($categories) === 0): ?>
                    <tr>
                        <td colspan="4" class="empty">
                            ยังไม่มีหมวดหมู่ในระบบ
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>

