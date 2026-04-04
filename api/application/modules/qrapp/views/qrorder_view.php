<div class="container">
    <h2><?= $title ?></h2>
    <?php if (!empty($order)) : ?>
        <p><strong>ID:</strong> <?= $order->id ?></p>
        <p><strong>Client:</strong> <?= $order->customer_name ?></p>
        <p><strong>Total:</strong> <?= $order->total_amount ?></p>
        <p><strong>Date:</strong> <?= $order->order_date ?></p>
        <p><strong>Statut:</strong> <?= $order->status ?></p>
    <?php else: ?>
        <p>Commande introuvable.</p>
    <?php endif; ?>
</div>
