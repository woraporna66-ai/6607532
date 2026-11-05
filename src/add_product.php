<?php
require_once 'config.php';

// ดึงหมวดหมู่สินค้าจากฐานข้อมูล
$stmt = $conn->query("SELECT * FROM categories ORDER BY name ASC");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// เมื่อกดปุ่มบันทึก
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category_id = $_POST['category_id'];

    if ($name !== '' && $price >= 0 && $stock >= 0 && $category_id !== '') {
        $sql = "INSERT INTO products (name, description, price, stock, category_id)
                VALUES (:name, :description, :price, :stock, :category_id)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':description' => $description,
            ':price' => $price,
            ':stock' => $stock,
            ':category_id' => $category_id
        ]);

        header("Location: products.php");
        exit;
    }

    $error = "กรุณากรอกข้อมูลให้ครบถ้วน";
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เพิ่มสินค้า | SL33Z</title>
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
    <h2>เพิ่มสินค้าใหม่</h2>

    <?php if (isset($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>ชื่อสินค้า</label>
        <input type="text" name="name" required>

        <label>รายละเอียด</label>
        <textarea name="description" rows="4"></textarea>

        <label>ราคา (บาท)</label>
        <input type="number" name="price" min="0" step="0.01" required>

        <label>จำนวนสินค้า</label>
        <input type="number" name="stock" min="0" required>

        <label>หมวดหมู่</label>
        <select name="category_id" required>
            <option value="">-- เลือกหมวดหมู่ --</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>">
                    <?= htmlspecialchars($category['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">บันทึกสินค้า</button>
    </form>

    <br>
    <a href="products.php">กลับหน้าสินค้า</a>
</div>

</body>
</html>
```
