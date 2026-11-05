<?php
require_once 'config.php';

// รับ ID สินค้าจาก URL
$id = $_GET['id'] ?? null;

if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
    die("ไม่พบรหัสสินค้า");
}

// ดึงข้อมูลสินค้าที่ต้องการแก้ไข
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("ไม่พบสินค้านี้");
}

// ดึงหมวดหมู่สินค้า
$stmt = $conn->query("SELECT * FROM categories ORDER BY name ASC");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

$error = "";

// เมื่อกดบันทึก
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = $_POST['price'] ?? '';
    $stock = $_POST['stock'] ?? '';
    $category_id = $_POST['category_id'] ?? '';

    if (
        $name !== '' &&
        is_numeric($price) && $price >= 0 &&
        filter_var($stock, FILTER_VALIDATE_INT) !== false && $stock >= 0 &&
        filter_var($category_id, FILTER_VALIDATE_INT) !== false
    ) {
        $sql = "UPDATE products
                SET name = ?, description = ?, price = ?, stock = ?, category_id = ?
                WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $name,
            $description,
            $price,
            $stock,
            $category_id,
            $id
        ]);

        header("Location: products.php");
        exit;
    } else {
        $error = "กรุณากรอกข้อมูลให้ถูกต้อง";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขสินค้า | SL33Z</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 40px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
        }
        h2 { margin-top: 0; }
        label {
            display: block;
            margin-top: 15px;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
        }
        button {
            margin-top: 20px;
            padding: 12px 20px;
            background: #111;
            color: white;
            border: none;
            cursor: pointer;
        }
        a { color: #111; }
        .error { color: red; }
    </style>
</head>
<body>

<div class="container">
    <h2>แก้ไขสินค้า</h2>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>ชื่อสินค้า</label>
        <input type="text" name="name"
               value="<?= htmlspecialchars($product['name']) ?>" required>

        <label>รายละเอียด</label>
        <textarea name="description" rows="4"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>

        <label>ราคา (บาท)</label>
        <input type="number" name="price" min="0" step="0.01"
               value="<?= htmlspecialchars($product['price']) ?>" required>

        <label>จำนวนสินค้า</label>
        <input type="number" name="stock" min="0"
               value="<?= htmlspecialchars($product['stock']) ?>" required>

        <label>หมวดหมู่</label>
        <select name="category_id" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>"
                    <?= $category['id'] == $product['category_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">บันทึกการแก้ไข</button>
    </form>

    <br>
    <a href="products.php">กลับหน้าสินค้า</a>
</div>

</body>
</html>
