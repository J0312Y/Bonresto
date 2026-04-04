<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Commande envoyée</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
</head>
<body style="background:#f5f5f5; padding:40px;">
<div class="container text-center">
    <div class="card p-5">
        <h3>✅ <?= $message ?></h3>
        <p>Merci d’avoir commandé. Un serveur va bientôt s’occuper de vous.</p>
        <a href="<?= base_url() ?>" class="btn btn-primary mt-3">Retour</a>
    </div>
</div>
</body>
</html>
