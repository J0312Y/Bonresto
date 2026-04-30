<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title ?? 'Bonresto'); ?> — Bonresto</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f3f4f6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .brand {
            margin-bottom: 24px;
            text-align: center;
        }
        .brand h1 {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            letter-spacing: -0.5px;
        }
        .brand span { color: #2563eb; }
        .brand p { color: #6b7280; font-size: 14px; margin-top: 4px; }
        .card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,.08);
            padding: 40px;
            width: 100%;
            max-width: 520px;
        }
    </style>
</head>
<body>
    <div class="brand">
        <h1>Bon<span>resto</span></h1>
        <p>Gestion de licence</p>
    </div>
    <div class="card">
        <?php echo $content; ?>
    </div>
</body>
</html>
