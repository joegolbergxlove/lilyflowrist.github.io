<?php
// Sisipkan file koneksi
include '../koneksi.php';

// 1. Validasi dan Ambil ID Produk dari URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = $_GET['id'];

    // Mulai transaksi database untuk keamanan data
    mysqli_begin_transaction($koneksi);

    try {
        // 2. Ambil semua nama file gambar terkait produk ini dari tabel `product_images`
        $sql_get_images = "SELECT image_filename FROM product_images WHERE product_id = $product_id";
        $result_images = mysqli_query($koneksi, $sql_get_images);

        if (!$result_images) {
            throw new Exception("Gagal mengambil data gambar: " . mysqli_error($koneksi));
        }

        // 3. Hapus setiap file gambar fisik dari folder 'thumbnails'
        while ($image = mysqli_fetch_assoc($result_images)) {
            $file_path = '../thumbnails/' . $image['image_filename'];
            if (file_exists($file_path)) {
                unlink($file_path); // Fungsi unlink() untuk menghapus file
            }
        }

        // 4. Hapus semua referensi gambar dari tabel `product_images`
        // Catatan: Langkah ini sebenarnya otomatis jika Anda menggunakan ON DELETE CASCADE,
        // tapi melakukannya secara eksplisit lebih aman.
        $sql_delete_images = "DELETE FROM product_images WHERE product_id = $product_id";
        if (!mysqli_query($koneksi, $sql_delete_images)) {
            throw new Exception("Gagal menghapus data gambar dari database: " . mysqli_error($koneksi));
        }

        // 5. Hapus produk utama dari tabel `products`
        $sql_delete_product = "DELETE FROM products WHERE id = $product_id";
        if (!mysqli_query($koneksi, $sql_delete_product)) {
            throw new Exception("Gagal menghapus produk utama: " . mysqli_error($koneksi));
        }

        // Jika semua langkah berhasil, commit transaksi
        mysqli_commit($koneksi);

        // 6. Redirect kembali ke halaman utama admin produk
        header("Location: index.php");
        exit();

    } catch (Exception $e) {
        // Jika ada kesalahan di salah satu langkah, batalkan semua perubahan
        mysqli_rollback($koneksi);
        echo "<h1>Error: Gagal menghapus produk.</h1>";
        echo "<p>" . $e->getMessage() . "</p>";
        echo "<a href='index.php'>Kembali ke Manajemen Produk</a>";
    }

} else {
    // Jika tidak ada ID atau ID tidak valid, kembalikan ke halaman utama
    header("Location: index.php");
    exit();
}
?>