<?php
require_once 'config.php';

$productCount = $conn->query("SELECT COUNT(*) FROM products")->fetchColumn();
$categoryCount = $conn->query("SELECT COUNT(*) FROM categories")->fetchColumn();
$lowStock = $conn->query("SELECT COUNT(*) FROM products WHERE stock < 5")->fetchColumn();

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
    background: #101010;
    color: #f5f5f5;
    min-height: 100vh;
}

.sidebar {
    width: 245px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background: #080808;
    border-right: 1px solid #292929;
    padding: 38px 24px;
}

.logo {
    font-size: 38px;
    font-weight: 900;
    letter-spacing: 5px;
    color: #fff;
}

.subtitle {
    color: #777;
    font-size: 10px;
    letter-spacing: 4px;
    margin-top: 5px;
    margin-bottom: 65px;
}

.menu-label {
    color: #666;
    font-size: 10px;
    letter-spacing: 2px;
    margin: 0 12px 15px;
}

.sidebar a {
    display: block;
    color: #999;
    text-decoration: none;
    padding: 15px 16px;
    margin-bottom: 8px;
    border-radius: 6px;
    font-size: 14px;
    transition: .2s;
}

.sidebar a:hover,
.sidebar a.active {
    background: #242424;
    color: #fff;
}

.sidebar a.active {
    border-left: 3px solid #fff;
}

.main {
    margin-left: 245px;
    padding: 45px 55px;
    max-width: 1600px;
}

.topline {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #292929;
    padding-bottom: 22px;
    margin-bottom: 45px;
}

.topline span {
    color: #888;
    font-size: 11px;
    letter-spacing: 3px;
}

.status {
    border: 1px solid #333;
    padding: 9px 14px;
    border-radius: 30px;
    font-size: 10px;
    color: #bbb;
    letter-spacing: 1px;
}

.header {
    margin-bottom: 38px;
}

.eyebrow {
    color: #888;
    font-size: 11px;
    letter-spacing: 4px;
    margin-bottom: 14px;
}

.header h1 {
    font-size: clamp(34px, 5vw, 52px);
    letter-spacing: -2px;
    font-weight: 800;
    margin-bottom: 12px;
}

.header p {
    color: #999;
    font-size: 14px;
    line-height: 1.8;
}

.cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
    margin-bottom: 35px;
}

.card {
    background: linear-gradient(145deg, #202020, #171717);
    border: 1px solid #303030;
    padding: 27px;
    border-radius: 10px;
    transition: .25s;
}

.card:hover {
    border-color: #777;
    transform: translateY(-3px);
}

.card-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 28px;
}

.card-label {
    color: #aaa;
    font-size: 13px;
}

.card-number {
    font-size: 43px;
    font-weight: 800;
    letter-spacing: -2px;
}

.card-note {
    color: #666;
    font-size: 11px;
    margin-top: 8px;
}

.card-icon {
    width: 35px;
    height: 35px;
    display: grid;
    place-items: center;
    border: 1px solid #444;
    border-radius: 7px;
    color: #ddd;
    font-size: 17px;
}

.section {
    background: #191919;
    border: 1px solid #303030;
    border-radius: 10px;
    padding: 28px;
}

.section-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.section-heading h2 {
    font-size: 18px;
    letter-spacing: .5px;
}

.section-heading span {
    color: #777;
    font-size: 11px;
    letter-spacing: 1px;
}

.table-wrap {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 520px;
}

th {
    color: #777;
    font-size: 10px;
    letter-spacing: 1.5px;
    font-weight: 500;
    text-transform: uppercase;
}

th, td {
    padding: 19px 14px;
    text-align: left;
    border-bottom: 1px solid #303030;
}

td {
    color: #ddd;
    font-size: 13px;
}

tbody tr {
    transition: .2s;
}

tbody tr:hover {
    background: #252525;
}

tbody tr:last-child td {
    border-bottom: none;
}

.category-tag {
    display: inline-block;
    padding: 6px 10px;
    background: #292929;
    color: #bbb;
    border-radius: 4px;
    font-size: 11px;
}

.stock {
    font-weight: bold;
    color: #eee;
}

.empty {
    color: #888;
    text-align: center;
    padding: 30px;
}

.footer {
    color: #555;
    font-size: 10px;
    letter-spacing: 2px;
    text-align: right;
    margin-top: 30px;
}

@media (max-width: 900px) {
    .sidebar {
        width: 190px;
    }

    .main {
        margin-left: 190px;
        padding: 30px 25px;
    }

    .cards {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 600px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        padding: 20px;
    }

    .logo {
        font-size: 28px;
    }

    .subtitle {
        margin-bottom: 20px;
    }

    .menu-label {
        display: none;
    }

    .sidebar a {
        display: inline-block;
        padding: 10px;
        margin-bottom: 0;
    }

    .main {
        margin-left: 0;
        padding: 25px 18px;
    }

    .topline {
        margin-bottom: 30px;
    }

    .section {
        padding: 18px;
    }
}
</style>
</head>

<body>

<aside class="sidebar">
    <div class="logo">SL33Z</div>
    <div class="subtitle">CLOTHING STORE</div>

    <div class="menu-label">MAIN MENU</div>
    <a href="index.php" class="active">◈ &nbsp; 6607532</a>
    <a href="products.php">▤ &nbsp; Products</a>
    <a href="categories.php">▧ &nbsp; Categories</a>
</aside>

<main class="main">

    <div class="topline">
        <span>SL33Z / ADMINISTRATION</span>
        <div class="status">● &nbsp; SYSTEM ONLINE</div>
    </div>

    <header class="header">
        <div class="eyebrow">OVERVIEW / 01</div>
        <h1>Woraporn Eawchu</h1>
        <p>ยินดีต้อนรับสู่ SL33Z Clothing Store<br>
        จัดการร้านค้าของคุณได้ในที่เดียว</p>
    </header>

    <section class="cards">

        <div class="card">
            <div class="card-top">
                <div class="card-label">สินค้าทั้งหมด</div>
                <div class="card-icon">▤</div>
            </div>
            <div class="card-number"><?= $productCount ?></div>
            <div class="card-note">TOTAL PRODUCTS</div>
        </div>

        <div class="card">
            <div class="card-top">
                <div class="card-label">หมวดหมู่ทั้งหมด</div>
                <div class="card-icon">▧</div>
            </div>
            <div class="card-number"><?= $categoryCount ?></div>
            <div class="card-note">TOTAL CATEGORIES</div>
        </div>

        <div class="card">
            <div class="card-top">
                <div class="card-label">สินค้าใกล้หมด</div>
                <div class="card-icon">!</div>
            </div>
            <div class="card-number"><?= $lowStock ?></div>
            <div class="card-note">LOW STOCK / BELOW 5</div>
        </div>

    </section>

    <section class="section">
        <div class="section-heading">
            <h2>สินค้าล่าสุด</h2>
            <span>LATEST PRODUCTS / 05</span>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td>
                            <span class="category-tag">
                                <?= htmlspecialchars($product['category']) ?>
                            </span>
                        </td>
                        <td><?= number_format($product['price'], 2) ?> ฿</td>
                        <td class="stock"><?= (int)$product['stock'] ?></td>
                    </tr>
                    <?php endforeach; ?>

                    <?php if (count($products) === 0): ?>
                    <tr>
                        <td colspan="4" class="empty">ยังไม่มีสินค้าในระบบ</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <div class="footer">SL33Z CLOTHING STORE © 2026</div>

</main>

</body>
</html>
