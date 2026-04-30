<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <style>
        body { background: #f5f5f5; padding: 20px; }
        .product-card { background: #fff; border-radius: 8px; padding: 10px; margin-bottom: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .btn-order { background: #28a745; color: #fff; border: none; padding: 10px 20px; border-radius: 5px; }
    </style>
</head>
<body>

<div class="container">
    <h3 class="text-center mb-4">Commande - <?= $table->tablename ?></h3>

    <form method="post" action="<?= base_url('qrorder/submit') ?>">
        <input type="hidden" name="table_id" value="<?= $table->tableid ?>">

        <?php foreach ($products as $p): ?>
            <div class="product-card">
                <div class="row">
                    <div class="col-md-8">
                        <strong><?= $p->product_name ?></strong><br>
                        <small><?= number_format($p->price, 2) ?> FCFA</small>
                    </div>
                    <div class="col-md-4 text-right">
                        <input type="hidden" name="product_id[]" value="<?= $p->product_id ?>">
                        <input type="number" name="quantity[]" min="0" value="0" class="form-control" style="width:80px; display:inline-block;">
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="text-center mt-3">
            <button type="submit" class="btn-order">Passer la commande</button>
        </div>
    </form>
</div>

</body>
</html>
