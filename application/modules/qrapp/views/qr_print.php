<!DOCTYPE html>
<html>
<head>
    <title>Impression QR Codes</title>
    <style>
        @page {
            size: A4;
            margin: 10mm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .page {
            page-break-after: always;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-start;
        }

        .qr-item {
            width: 30%; /* 3 QR par ligne */
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
            box-sizing: border-box;
        }

        .qr-item img {
            width: 180px;
            height: 180px;
            margin-bottom: 10px;
        }

        .table-name {
            font-weight: bold;
            font-size: 1em;
            margin-bottom: 3px;
        }

        .table-capacity {
            font-size: 0.9em;
            color: #555;
        }

        @media print {
            .qr-item {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <h2 style="text-align:center; margin-bottom:20px;">Liste des QR Codes des Tables</h2>

    <?php
    $counter = 0;
    echo '<div class="page">';
    foreach ($tables as $table):
        // Si le QR code n’existe pas, on met un texte
        $qr_img = !empty($table->qr_code) ? base_url('uploads/qrcodes/' . $table->qr_code) : '';
        ?>
        <div class="qr-item">
            <?php if ($qr_img): ?>
                <img src="<?php echo $qr_img; ?>" alt="QR Table <?php echo $table->tablename; ?>">
            <?php else: ?>
                <div style="color:red; height:180px; display:flex; align-items:center; justify-content:center;">QR non généré</div>
            <?php endif; ?>
            <div class="table-name"><?php echo $table->tablename; ?></div>
            <div class="table-capacity">Capacité: <?php echo $table->person_capicity; ?></div>
        </div>
    <?php
        $counter++;
        if ($counter % 12 == 0) { // 12 QR par page (3 par ligne x 4 lignes)
            echo '</div><div class="page">';
        }
    endforeach;
    echo '</div>';
    ?>

    <script>
        // Ouvre automatiquement la boîte d'impression
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
