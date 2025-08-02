<?php
// Sisipkan file koneksi
include '../koneksi.php';

// Validasi ID dari URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $order_id = $_GET['id'];

    // Siapkan query UPDATE untuk keamanan (Prepared Statement)
    $sql = "UPDATE orders SET order_status = 'Selesai' WHERE id = ?";
    
    $stmt = mysqli_prepare($koneksi, $sql);
    
    if ($stmt) {
        // Bind parameter ke query
        mysqli_stmt_bind_param($stmt, "i", $order_id);
        
        // Eksekusi statement
        mysqli_stmt_execute($stmt);
        
        // Tutup statement
        mysqli_stmt_close($stmt);
    }
}

// Redirect kembali ke halaman daftar pesanan
header("Location: pesanan.php");
exit();
?>