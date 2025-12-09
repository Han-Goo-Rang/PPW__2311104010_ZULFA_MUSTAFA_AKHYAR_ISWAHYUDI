<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konversi Suhu</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .container { max-width: 500px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; }
        h2 { color: #333; text-align: center; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px; }
        button { background: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #45a049; }
        .result { margin-top: 20px; padding: 15px; background: #f9f9f9; border-radius: 5px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Konversi Suhu</h2>
        <form method="post">
            <div class="form-group">
                <label for="temperature">Suhu:</label>
                <input type="number" step="any" name="temperature" id="temperature" required>
            </div>
            <div class="form-group">
                <label for="from">Dari:</label>
                <select name="from" id="from" required>
                    <option value="celsius">Celcius (°C)</option>
                    <option value="fahrenheit">Fahrenheit (°F)</option>
                </select>
            </div>
            <div class="form-group">
                <label for="to">Ke:</label>
                <select name="to" id="to" required>
                    <option value="fahrenheit">Fahrenheit (°F)</option>
                    <option value="celsius">Celcius (°C)</option>
                    <option value="kelvin">Kelvin (K)</option>
                </select>
            </div>
            <button type="submit" name="convert">Konversi</button>
        </form>

        <?php
        if (isset($_POST['convert'])) {
            $temperature = floatval($_POST['temperature']);
            $from = $_POST['from'];
            $to = $_POST['to'];
            $result = 0;
            $explanation = "";

            // Konversi ke Celsius dulu
            if ($from == 'celsius') {
                $celsius = $temperature;
            } elseif ($from == 'fahrenheit') {
                $celsius = ($temperature - 32) * 5/9;
            }

            // Konversi dari Celsius ke tujuan
            if ($to == 'celsius') {
                $result = $celsius;
                $explanation = "Hasil langsung dari Celsius";
            } elseif ($to == 'fahrenheit') {
                $result = ($celsius * 9/5) + 32;
                $explanation = "Rumus: (C × 9/5) + 32";
            } elseif ($to == 'kelvin') {
                $result = $celsius + 273.15;
                $explanation = "Rumus: C + 273.15";
            }

            echo "<div class='result'>";
            echo "Hasil: " . number_format($result, 2) . " ";
            if ($to == 'celsius') echo "°C";
            elseif ($to == 'fahrenheit') echo "°F";
            else echo "K";
            echo "<br><small>$explanation</small>";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>