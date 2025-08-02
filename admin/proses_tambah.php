<?php
// Sisipkan file koneksi
include '../koneksi.php';

// Cek apakah form sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. AMBIL DATA DARI FORM
    $name = mysqli_real_escape_string($koneksi, $_POST['name']);
    $description = mysqli_real_escape_string($koneksi, $_POST['description']);
    $price = mysqli_real_escape_string($koneksi, $_POST['price']);

    // 2. SIMPAN PRODUK UTAMA KE TABEL `products`
    $sql_product = "INSERT INTO products (name, description, price) VALUES ('$name', '$description', '$price')";

    if (mysqli_query($koneksi, $sql_product)) {
        // Ambil ID dari produk yang baru saja disimpan
        $product_id = mysqli_insert_id($koneksi);
        echo "Produk baru berhasil disimpan dengan ID: " . $product_id . "<br>";

        // 3. PROSES UPLOAD GAMBAR
        $upload_dir = '../thumbnails/'; // Path ke folder thumbnails
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        // Cek apakah ada file yang diunggah
        if (!empty(array_filter($_FILES['images']['name']))) {
            
            // Looping untuk setiap file yang diunggah
            foreach ($_FILES['images']['name'] as $key => $image_name) {
                
                $tmp_name = $_FILES['images']['tmp_name'][$key];
                $file_info = pathinfo($image_name);
                $file_ext = strtolower($file_info['extension']);

                // Cek apakah tipe file diizinkan
                if (in_array($file_ext, $allowed_types)) {
                    // Buat nama file yang unik untuk menghindari duplikasi
                    $new_filename = uniqid('img_', true) . '.' . $file_ext;
                    $target_path = $upload_dir . $new_filename;

                    // Pindahkan file dari temporary ke folder thumbnails
                    if (move_uploaded_file($tmp_name, $target_path)) {
                        
                        // 4. SIMPAN NAMA FILE GAMBAR KE TABEL `product_images`
                        $sql_image = "INSERT INTO product_images (product_id, image_filename) VALUES ('$product_id', '$new_filename')";
                        
                        if (mysqli_query($koneksi, $sql_image)) {
                            echo "Gambar " . htmlspecialchars($image_name) . " berhasil diunggah dan disimpan.<br>";
                        } else {
                            echo "Error: Gagal menyimpan info gambar ke database. " . mysqli_error($koneksi) . "<br>";
                        }

                    } else {
                        echo "Error: Gagal mengunggah file " . htmlspecialchars($image_name) . ".<br>";
                    }
                } else {
                    echo "Error: Tipe file " . htmlspecialchars($image_name) . " tidak diizinkan.<br>";
                }
            }
        }

        // 5. REDIRECT KEMBALI KE HALAMAN ADMIN
        // Tunggu beberapa detik sebelum redirect agar pesan bisa dibaca (opsional)
        header("refresh:3;url=index.php");
        echo "Anda akan diarahkan kembali ke halaman admin dalam 3 detik...";
        exit();

    } else {
        echo "Error: Gagal menyimpan produk. " . mysqli_error($koneksi);
    }
} else {
    // Jika file diakses langsung tanpa submit form
    header("Location: tambah_produk.php");
    exit();
}
?>