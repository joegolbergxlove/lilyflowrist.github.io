<?php
include 'koneksi.php';
$sql = "SELECT * FROM products ORDER BY id DESC";
$hasil = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk - Lily Florist</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <button id="theme-switcher">Ganti Tema</button>

        <h1>💐 Katalog Bunga Lily Florist 💐</h1>

        <div class="product-grid">
            <?php
            if (mysqli_num_rows($hasil) > 0) {
                while ($product = mysqli_fetch_assoc($hasil)) {
                    echo '<div class="product-card">';

                    // --- SLIDER GAMBAR ---
                    echo '<div class="slider-container">';
                    echo '<div class="slider-track">';

                    // Query kedua untuk mengambil semua gambar produk ini
                    $image_sql = "SELECT image_filename FROM product_images WHERE product_id = " . $product['id'];
                    $image_result = mysqli_query($koneksi, $image_sql);

                    if (mysqli_num_rows($image_result) > 0) {
                        while ($image = mysqli_fetch_assoc($image_result)) {
                            $image_path = 'thumbnails/' . htmlspecialchars($image['image_filename']);
                            echo '<img src="' . $image_path . '" alt="' . htmlspecialchars($product['name']) . '" class="product-thumbnail">';
                        }
                    } else {
                        // Tampilkan placeholder jika tidak ada gambar
                        echo '<img src="https://via.placeholder.com/300x300.png?text=Lily+Florist" alt="No Image" class="product-thumbnail">';
                    }

                    echo '</div>'; // penutup slider-track

                    // Tombol navigasi slider hanya muncul jika gambar lebih dari satu
                    if (mysqli_num_rows($image_result) > 1) {
                        echo '<button class="slider-button prev">&lt;</button>';
                        echo '<button class="slider-button next">&gt;</button>';
                    }

                    echo '</div>'; // penutup slider-container
                    // --- AKHIR SLIDER GAMBAR ---

                    echo '<h3>' . htmlspecialchars($product['name']) . '</h3>';
                    echo '<p>' . htmlspecialchars($product['description']) . '</p>';
                    echo '<p class="price">Rp ' . number_format($product['price'], 0, ',', '.') . '</p>';
                    echo '</div>'; // penutup product-card
                }
            } else {
                echo "<p style='text-align:center;'>Belum ada produk yang tersedia.</p>";
            }
            ?>
        </div>
        <footer>
            <p>Developed with ❤️ by <a href="https://www.instagram.com/joegolbergxlove" target="_blank">Joegolbergxlove</a></p>
        </footer>

        <script src="script.js"></script>
</body>

</html>
<?php
mysqli_close($koneksi);
?>