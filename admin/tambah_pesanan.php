<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Pesanan Baru - Admin Panel</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <nav class="bottom-navbar">
        <h3 class="sidebar-header">Lily Admin</h3>
        <a href="index.php" class="nav-item">
            <span class="icon">📦</span><span class="label">Produk</span>
        </a>
        <a href="pesanan.php" class="nav-item active">
            <span class="icon">📋</span><span class="label">Pesanan</span>
        </a>
        <a id="theme-toggle" class="nav-item">
            <span class="icon">🌙</span><span class="label">Tema</span>
        </a>
    </nav>
    
    <main class="main-content">
        <div class="card">
            <div class="card-header">
                <h2>Input Pesanan Baru</h2>
            </div>
            
            <form action="proses_pesanan.php" method="post">
                <div class="form-group"><label for="customer_name">Nama Pemesan:</label><input type="text" id="customer_name" name="customer_name" required></div>
                <div class="form-group"><label for="customer_address">Alamat:</label><textarea id="customer_address" name="customer_address" rows="3"></textarea></div>
                <div class="form-group">
                    <label for="bouquet_type">Jenis Buket:</label>
                    <select id="bouquet_type" name="bouquet_type" required>
                        <option value="">-- Pilih Jenis Buket --</option><option value="Pita Satin">Pita Satin</option><option value="Uang">Uang</option><option value="Snack">Snack</option><option value="Katalog">Dari Katalog</option>
                    </select>
                </div>
                <div id="form-pita-satin" class="dynamic-form"><h4>Detail Buket Pita Satin</h4><div class="form-group"><label for="satin-stem_count">Jumlah Tangkai:</label><input type="text" id="satin-stem_count" name="satin_details[jumlah_tangkai]"></div><div class="form-group"><label for="satin-color">Warna:</label><input type="text" id="satin-color" name="satin_details[warna]"></div></div>
                <div id="form-uang" class="dynamic-form"><h4>Detail Buket Uang</h4><div class="form-group"><label for="uang-nominal">Nominal Uang:</label><input type="number" id="uang-nominal" name="uang_details[nominal]"></div><div class="form-group"><label for="uang-pecahan">Pecahan:</label><select id="uang-pecahan" name="uang_details[pecahan]"><option value="2000">Rp 2.000</option><option value="5000">Rp 5.000</option><option value="10000">Rp 10.000</option><option value="20000">Rp 20.000</option><option value="50000">Rp 50.000</option><option value="100000">Rp 100.000</option></select></div></div>
                <div id="main-order-form" class="dynamic-form"><h4>Detail Pesanan Lanjutan</h4><div class="form-group"><label>Tambahan Aksesoris:</label><div><input type="checkbox" name="accessories[mahkota][pilih]" id="acc-mahkota"> Mahkota</div><div id="form-mahkota" class="dynamic-form"><input type="text" name="accessories[mahkota][ukuran]" placeholder="Ukuran"><select name="accessories[mahkota][warna]"><option value="Silver">Silver</option><option value="Gold">Gold</option></select></div><div><input type="checkbox" name="accessories[kupu-kupu][pilih]" id="acc-kupu"> Kupu-Kupu</div><div id="form-kupu" class="dynamic-form"><input type="text" name="accessories[kupu-kupu][ukuran]" placeholder="Ukuran"><select name="accessories[kupu-kupu][warna]"><option value="Silver">Silver</option><option value="Gold">Gold</option></select></div><div><input type="checkbox" name="accessories[pita_ucapan][pilih]" id="acc-pita"> Pita Ucapan</div><div id="form-pita" class="dynamic-form"><select name="accessories[pita_ucapan][jenis]"><option value="Happy Graduation">Happy Graduation</option><option value="Congratulation">Congratulation</option><option value="Happy Birthday">Happy Birthday</option></select></div><div><input type="checkbox" name="accessories[kata_ucapan][pilih]" id="acc-kata"> Kata Ucapan</div><div id="form-kata" class="dynamic-form"><textarea name="accessories[kata_ucapan][isi]" placeholder="Tulis kata ucapan di sini..."></textarea></div></div><div class="form-group"><label for="pickup_date">Tanggal Pengambilan:</label><input type="date" id="pickup_date" name="pickup_date"></div><div class="form-group"><label for="total_price">Total Harga:</label><input type="number" id="total_price" name="total_price"></div></div>
                <button type="submit" class="btn btn-primary">Simpan Pesanan</button>
            </form>
        </main>

    <script src="admin_script.js"></script>
    <script>
        // Kode JS untuk form dinamis tetap sama
        document.addEventListener('DOMContentLoaded', function() {
            const bouquetTypeSelect = document.getElementById('bouquet_type');
            const mainOrderForm = document.getElementById('main-order-form');
            const dynamicForms = { 'Pita Satin': document.getElementById('form-pita-satin'), 'Uang': document.getElementById('form-uang') };
            function toggleForms() {
                Object.values(dynamicForms).forEach(form => form.style.display = 'none');
                mainOrderForm.style.display = 'none';
                const selectedType = bouquetTypeSelect.value;
                if (selectedType) {
                    mainOrderForm.style.display = 'block';
                    if (dynamicForms[selectedType]) { dynamicForms[selectedType].style.display = 'block'; }
                }
            }
            function toggleAccessoryForm(checkboxId, formId) {
                const checkbox = document.getElementById(checkboxId);
                const form = document.getElementById(formId);
                checkbox.addEventListener('change', function() { form.style.display = this.checked ? 'block' : 'none'; });
            }
            bouquetTypeSelect.addEventListener('change', toggleForms);
            toggleAccessoryForm('acc-mahkota', 'form-mahkota');
            toggleAccessoryForm('acc-kupu', 'form-kupu');
            toggleAccessoryForm('acc-pita', 'form-pita');
            toggleAccessoryForm('acc-kata', 'form-kata');
            toggleForms();
        });
    </script>
</body>
</html>