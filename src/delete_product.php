<?php
require_once 'config.php';

// รับ ID สินค้าจาก URL
$id = $_GET['id'] ?? null;

if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
    die("ไม่พบรหัสสินค้า");
}

// ดึงข้อมูลสินค้าที่ต้องการลบ
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("ไม่พบสินค้านี้");
}

// เมื่อต้องการยืนยันการลบ
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: products.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ลบสินค้า | SL33Z</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }
        .container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
        }
        button {
            background: #dc2626;
            color: white;
            padding: 12px 20px;
            border: none;
            cursor: pointer;
        }
        a {
            color: #111;
            margin-left: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>ยืนยันการลบสินค้า</h2>

    <p>คุณต้องการลบสินค้า</p>

    <h3><?= htmlspecialchars($product['name']) ?></h3>

    <p>การลบนี้ไม่สามารถย้อนกลับได้</p>

    <form method="POST">
        <button type="submit">ยืนยันการลบ</button>
        <a href="products.php">ยกเลิก</a>
    </form>
</div>

</body>
</html>
