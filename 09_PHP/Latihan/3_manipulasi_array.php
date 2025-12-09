<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisis Nilai Mahasiswa</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; }
        h2 { color: #333; text-align: center; }
        .stats { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin: 20px 0; }
        .stat-box { padding: 15px; background: #f8f9fa; border-radius: 5px; text-align: center; }
        .stat-title { font-size: 14px; color: #666; margin-bottom: 5px; }
        .stat-value { font-size: 24px; font-weight: bold; color: #2196F3; }
        .result-item { margin: 10px 0; padding: 10px; background: white; border-radius: 5px; border-left: 4px solid #4CAF50; }
        .nilai-list { display: flex; flex-wrap: wrap; gap: 5px; margin: 10px 0; }
        .nilai-item { padding: 5px 10px; background: #e3f2fd; border-radius: 3px; }
        .nilai-lulus { background: #c8e6c9; }
        .nilai-tidak-lulus { background: #ffcdd2; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Analisis Nilai Mahasiswa</h2>
        
        <?php
        // Array nilai mahasiswa
        $nilai = [75, 89, 65, 90, 85, 70, 98, 65, 69, 70, 12];
        
        echo "<p><strong>Data Nilai:</strong> " . implode(", ", $nilai) . "</p>";
        
        // 1. Nilai tertinggi
        $nilai_tertinggi = max($nilai);
        
        // 2. Nilai terendah
        $nilai_terendah = min($nilai);
        
        // 3. Rata-rata nilai
        $rata_rata = array_sum($nilai) / count($nilai);
        
        // 4. Jumlah mahasiswa yang lulus (≥70)
        $lulus = array_filter($nilai, function($n) {
            return $n >= 70;
        });
        $jumlah_lulus = count($lulus);
        
        // 5. Urutkan nilai dari tertinggi ke terendah
        $nilai_terurut = $nilai;
        rsort($nilai_terurut);
        
        // Tampilkan statistik dalam box
        echo "<div class='stats'>";
        
        echo "<div class='stat-box'>";
        echo "<div class='stat-title'>Nilai Tertinggi</div>";
        echo "<div class='stat-value'>" . $nilai_tertinggi . "</div>";
        echo "</div>";
        
        echo "<div class='stat-box'>";
        echo "<div class='stat-title'>Nilai Terendah</div>";
        echo "<div class='stat-value'>" . $nilai_terendah . "</div>";
        echo "</div>";
        
        echo "<div class='stat-box'>";
        echo "<div class='stat-title'>Rata-rata Nilai</div>";
        echo "<div class='stat-value'>" . number_format($rata_rata, 2) . "</div>";
        echo "</div>";
        
        echo "<div class='stat-box'>";
        echo "<div class='stat-title'>Jumlah Lulus</div>";
        echo "<div class='stat-value'>" . $jumlah_lulus . "/" . count($nilai) . "</div>";
        echo "</div>";
        
        echo "</div>";
        
        // Tampilkan detail nilai yang lulus dan tidak lulus
        echo "<div class='result-item'>";
        echo "<strong>Status Kelulusan (≥70):</strong><br>";
        echo "<div class='nilai-list'>";
        foreach ($nilai as $n) {
            $class = ($n >= 70) ? 'nilai-lulus' : 'nilai-tidak-lulus';
            echo "<span class='nilai-item $class'>$n " . (($n >= 70) ? '✓' : '✗') . "</span>";
        }
        echo "</div>";
        echo "</div>";
        
        // Tampilkan nilai terurut
        echo "<div class='result-item'>";
        echo "<strong>Nilai Terurut (Tinggi ke Rendah):</strong><br>";
        echo "<div class='nilai-list'>";
        foreach ($nilai_terurut as $n) {
            echo "<span class='nilai-item'>$n</span>";
        }
        echo "</div>";
        echo "</div>";
        
        // Informasi tambahan
        echo "<div class='result-item'>";
        echo "<strong>Informasi:</strong><br>";
        echo "Total Mahasiswa: " . count($nilai) . "<br>";
        echo "Persentase Kelulusan: " . number_format(($jumlah_lulus / count($nilai)) * 100, 1) . "%<br>";
        echo "Jumlah Tidak Lulus: " . (count($nilai) - $jumlah_lulus);
        echo "</div>";
        ?>
    </div>
</body>
</html>