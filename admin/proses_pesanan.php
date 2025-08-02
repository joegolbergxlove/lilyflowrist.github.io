<?php
// Sisipkan file koneksi
include '../koneksi.php';

// Cek apakah metode request adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Mulai transaksi database
    mysqli_begin_transaction($koneksi);

    try {
        // --- 1. Ambil & Simpan Data Utama ke Tabel `orders` ---
        $customer_name = mysqli_real_escape_string($koneksi, $_POST['customer_name']);
        $customer_address = mysqli_real_escape_string($koneksi, $_POST['customer_address']);
        $bouquet_type = mysqli_real_escape_string($koneksi, $_POST['bouquet_type']);
        $pickup_date = mysqli_real_escape_string($koneksi, $_POST['pickup_date']);
        $total_price = mysqli_real_escape_string($koneksi, $_POST['total_price']);

        $sql_order = "INSERT INTO orders (customer_name, customer_address, bouquet_type, pickup_date, total_price) 
                      VALUES ('$customer_name', '$customer_address', '$bouquet_type', '$pickup_date', '$total_price')";
        
        if (!mysqli_query($koneksi, $sql_order)) {
            throw new Exception("Gagal menyimpan data pesanan utama: " . mysqli_error($koneksi));
        }

        // Dapatkan ID dari pesanan yang baru saja dibuat
        $order_id = mysqli_insert_id($koneksi);

        // --- 2. Simpan Detail Spesifik Buket ke Tabel `order_details` ---
        $details_to_save = [];
        if ($bouquet_type === 'Pita Satin' && isset($_POST['satin_details'])) {
            $details_to_save = $_POST['satin_details'];
        } elseif ($bouquet_type === 'Uang' && isset($_POST['uang_details'])) {
            $details_to_save = $_POST['uang_details'];
        }

        foreach ($details_to_save as $key => $value) {
            if (!empty($value)) { // Hanya simpan jika ada nilainya
                $detail_key = mysqli_real_escape_string($koneksi, $key);
                $detail_value = mysqli_real_escape_string($koneksi, $value);
                $sql_detail = "INSERT INTO order_details (order_id, detail_key, detail_value) VALUES ('$order_id', '$detail_key', '$detail_value')";
                if (!mysqli_query($koneksi, $sql_detail)) {
                    throw new Exception("Gagal menyimpan detail buket: " . mysqli_error($koneksi));
                }
            }
        }

        // --- 3. Simpan Aksesoris ke Tabel `order_accessories` ---
        if (isset($_POST['accessories']) && is_array($_POST['accessories'])) {
            foreach ($_POST['accessories'] as $type => $data) {
                // Cek apakah checkbox 'pilih' dicentang
                if (isset($data['pilih'])) {
                    $accessory_type = mysqli_real_escape_string($koneksi, $type);
                    // Simpan detail (ukuran, warna, isi) sebagai JSON
                    $accessory_details_json = json_encode($data);

                    $sql_accessory = "INSERT INTO order_accessories (order_id, accessory_type, details) VALUES ('$order_id', '$accessory_type', '$accessory_details_json')";
                    if (!mysqli_query($koneksi, $sql_accessory)) {
                        throw new Exception("Gagal menyimpan aksesoris: " . mysqli_error($koneksi));
                    }
                }
            }
        }

        // Jika semua query berhasil, commit transaksi
        mysqli_commit($koneksi);
        echo "<h1>Pesanan Berhasil Disimpan!</h1>";
        echo "<p>Anda akan diarahkan kembali ke halaman admin...</p>";
        header("refresh:2;url=pesanan.php"); // Arahkan ke halaman daftar pesanan

    } catch (Exception $e) {
        // Jika terjadi error, batalkan semua perubahan (rollback)
        mysqli_rollback($koneksi);
        echo "<h1>Terjadi Kesalahan!</h1>";
        echo "<p>Error: " . $e->getMessage() . "</p>";
        echo "<p>Semua perubahan telah dibatalkan. Silakan coba lagi.</p>";
    }

} else {
    // Redirect jika halaman diakses langsung
    header("Location: tambah_pesanan.php");
    exit();
}
?>