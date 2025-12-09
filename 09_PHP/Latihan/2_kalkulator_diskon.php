<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Diskon</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .container { max-width: 500px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; }
        h2 { color: #333; text-align: center; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px; }
        button { background: #2196F3; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0b7dda; }
        .result { margin-top: 20px; padding: 20px; background: #f8f9fa; border-radius: 5px; }
        .result h3 { color: #2196F3; margin-top: 0; }
        .result-item { margin: 10px 0; padding: 10px; background: white; border-radius: 5px; border-left: 4px solid #2196F3; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Kalkulator Diskon</h2>
        <form method="post">
            <div class="form-group">
                <label for="total_belanja">Total Belanja (Rp):</label>
                <input type="number" name="total_belanja" id="total_belanja" min="0" step="1000" required>
            </div>
            <button type="submit" name="hitung">Hitung Diskon</button>
        </form>

        <?php
        if (isset($_POST['hitung'])) {
            $total_belanja = floatval($_POST['total_belanja']);
            
            // Menentukan diskon berdasarkan total belanja
            if ($total_belanja >= 1000000) {
                $diskon_persen = 30;
            } elseif ($total_belanja >= 500000) {
                $diskon_persen = 20;
            } elseif ($total_belanja >= 100000) {
                $diskon_persen = 10;
            } else {
                $diskon_persen = 0;
            }
            
            $diskon = $total_belanja * $diskon_persen / 100;
            $total_bayar = $total_belanja - $diskon;
            
            echo "<div class='result'>";
            echo "<h3>Rincian Pembayaran</h3>";
            
            echo "<div class='result-item'>";
            echo "Total Belanja: Rp " . number_format($total_belanja, 0, ',', '.');
            echo "</div>";
            
            echo "<div class='result-item'>";
            echo "Diskon ($diskon_persen%): Rp " . number_format($diskon, 0, ',', '.');
            echo "</div>";
            
            echo "<div class='result-item' style='border-left-color: #4CAF50; font-weight: bold;'>";
            echo "Total Bayar: Rp " . number_format($total_bayar, 0, ',', '.');
            echo "</div>";
            
            // Informasi diskon berikutnya
            if ($diskon_persen < 30) {
                echo "<div class='result-item' style='border-left-color: #FF9800; font-size: 14px;'>";
                echo "Tips: ";
                if ($diskon_persen == 0) {
                    $kebutuhan = 100000 - $total_belanja;
                    echo "Tambahkan Rp " . number_format($kebutuhan, 0, ',', '.') . " untuk mendapatkan diskon 10%!";
                } elseif ($diskon_persen == 10) {
                    $kebutuhan = 500000 - $total_belanja;
                    echo "Tambahkan Rp " . number_format($kebutuhan, 0, ',', '.') . " untuk mendapatkan diskon 20%!";
                } elseif ($diskon_persen == 20) {
                    $kebutuhan = 1000000 - $total_belanja;
                    echo "Tambahkan Rp " . number_format($kebutuhan, 0, ',', '.') . " untuk mendapatkan diskon 30%!";
                }
                echo "</div>";
            }
            
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>