<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas 2 - Perulangan While</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            max-width: 600px;
            margin: 0 auto;
        }
        h1 {
            color: #333;
        }
        .number {
            display: inline-block;
            margin: 5px;
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tugas 2 - Perulangan While (Bilangan 1 s.d 10)</h1>
        <div>
            @php
                $i = 1;
            @endphp
            @while ($i <= 10)
                <span class="number">{{ $i }}</span>
                @php
                    $i++;
                @endphp
            @endwhile
        </div>
    </div>
</body>
</html>
