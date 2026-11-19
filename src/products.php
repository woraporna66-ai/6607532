<?php
require_once 'config.php';

$sql = "SELECT p.*, c.name AS category_name
        FROM products p
        JOIN categories c ON p.category_id = c.id
        ORDER BY p.id DESC";

$products = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | SL33Z</title>

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
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 8px;
        }

        .header p {
            color: #777;
        }

        .btn {
            background: #171717;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 6px;
        }

        .section {
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            color: #777;
            font-size: 13px;
        }

        .action a {
            text-decoration: none;
            margin-right: 10px;
            font-size: 13px;
        }

        .edit {
            color: #2563eb;
        }

        .delete {
            color: #dc2626;
        }

        @media (max-width: 700px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main {
                margin-left: 0;
                padding: 20px;
            }

            .header {
                align-items: flex-start;
                gap: 15px;
                flex-direction: column;
            }

            .section {
                overflow-x: auto;
            }
        }

/* SL33Z Dark Luxury Theme */

body {
    background: #101010;
    color: #f5f5f5;
}

.sidebar {
    background: #080808;
    border-right: 1px solid #292929;
    padding: 35px 20px;
}

.logo {
    font-size: 30px;
    letter-spacing: 4px;
}

.subtitle {
    color: #777;
    font-size: 11px;
    letter-spacing: 2px;
}

.sidebar a {
    color: #999;
    border-radius: 5px;
    transition: 0.2s;
}

.sidebar a.active,
.sidebar a:hover {
    background: #252525;
    color: white;
}

.main {
    padding: 45px;
}

.header h1 {
    font-size: 34px;
    letter-spacing: 1px;
}

.header p {
    color: #888;
}

.btn {
    background: #f5f5f5;
    color: #111;
    padding: 13px 22px;
    border-radius: 5px;
    font-weight: bold;
    transition: 0.2s;
}

.btn:hover {
    background: #ccc;
}

.section {
    background: #191919;
    border: 1px solid #303030;
    border-radius: 8px;
    padding: 28px;
    overflow-x: auto;
}

table {
    min-width: 650px;
}

th, td {
    padding: 17px 14px;
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

.action a {
    font-weight: bold;
}

.edit {
    color: #aaa;
}

.edit:hover {
    color: white;
}

.delete {
    color: #e87979;
}

.delete:hover {
    color: #ff4444;
}

@media (max-width: 700px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
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
    <a href="products.php" class="active">Products</a>
    <a href="categories.php">Categories</a>
</div>

<div class="main">

    <div class="header">
        <div>
            <h1>Products</h1>
            <p>จัดการรายการสินค้าในร้าน SL33Z</p>
        </div>

        <a href="add_product.php" class="btn">+ เพิ่มสินค้า</a>
    </div>

    <div class="section">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ชื่อสินค้า</th>
                    <th>หมวดหมู่</th>
                    <th>ราคา</th>
                    <th>คงเหลือ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $product['id'] ?></td>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= htmlspecialchars($product['category_name']) ?></td>
                        <td><?= number_format($product['price'], 2) ?> ฿</td>
                        <td><?= $product['stock'] ?></td>

                        <td class="action">
                            <a class="edit" href="edit_product.php?id=<?= $product['id'] ?>">แก้ไข</a>
                            <a class="delete"
                               href="delete_product.php?id=<?= $product['id'] ?>"
                               onclick="return confirm('ยืนยันการลบสินค้านี้หรือไม่?')">
                               ลบ
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (count($products) === 0): ?>
                    <tr>
                        <td colspan="6">ยังไม่มีสินค้าในระบบ</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
