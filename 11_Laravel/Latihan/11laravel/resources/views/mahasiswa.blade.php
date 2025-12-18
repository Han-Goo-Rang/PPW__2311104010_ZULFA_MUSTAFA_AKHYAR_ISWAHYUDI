<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas 1 - Perulangan For</title>
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
            background-color: #007bff;
            color: white;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tugas 1 - Perulangan For (Bilangan 1 s.d 10)</h1>
        <div>
            @for ($i = 1; $i <= 10; $i++)
                <span class="number">{{ $i }}</span>
            @endfor
        </div>
    </div>
</body>
</html>
