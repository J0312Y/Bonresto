<?php
$storeinfo = $this->settinginfo;
?>
<style>
.receipt-wrap{padding:4px 2px 16px;}
.receipt-top{text-align:center;padding:10px 0 12px;border-bottom:1px dashed #e5e7eb;margin-bottom:14px;}
.receipt-top h5{font-size:15px;font-weight:700;margin:0 0 4px;color:#111;}
.receipt-top p{font-size:12px;color:#9ca3af;margin:0;}
.receipt-section-title{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:#9ca3af;margin-bottom:8px;}
.receipt-item-row{display:flex;justify-content:space-between;align-items:flex-start;padding:6px 0;border-bottom:1px solid #f3f4f6;font-size:13px;}
.receipt-item-row:last-child{border-bottom:none;}
.receipt-item-name{flex:1;color:#111;font-weight:500;}
.receipt-item-qty{background:#f3f4f6;border-radius:4px;padding:1px 6px;font-size:11px;color:#6b7280;margin-right:6px;white-space:nowrap;align-self:flex-start;margin-top:1px;}
.receipt-item-price{font-weight:600;color:#111;white-space:nowrap;margin-left:8px;}
.receipt-addon-line{font-size:11px;color:#6b7280;margin-top:2px;}
.receipt-divider{border:none;border-top:1px dashed #e5e7eb;margin:12px 0;}
.receipt-totals-row{display:flex;justify-content:space-between;align-items:center;padding:4px 0;font-size:13px;color:#374151;}
.receipt-totals-row.grand-total{font-weight:700;font-size:15px;color:#111;border-top:2px solid #111;padding-top:10px;margin-top:4px;}
.btn-download-receipt{display:block;width:100%;padding:13px;background:#111;color:#fff;border:none;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;margin-top:18px;text-align:center;letter-spacing:.2px;}
.btn-download-receipt:hover{background:#222;}
.btn-download-receipt i{margin-right:6px;}
</style>

<div class="receipt-wrap">
    <div class="receipt-top">
        <h5><?php echo !empty($storeinfo->store_name) ? htmlspecialchars($storeinfo->store_name) : (!empty($storeinfo->storename) ? htmlspecialchars($storeinfo->storename) : 'Détails de la commande'); ?></h5>
        <p>Commande #<?php echo $orderinfo->order_id; ?> &bull; <?php echo date('d/m/Y', strtotime($orderinfo->order_date)); ?></p>
    </div>

    <!-- Items -->
    <div class="receipt-section-title">Articles commandés</div>
    <?php
    $subtotal = 0;
    foreach ($iteminfo as $item):
        $itemprice = $item->price * $item->menuqty;
        $adonsprice = 0;
        $addons_display = [];
        if (!empty($item->add_on_id)) {
            $addons    = explode(",", $item->add_on_id);
            $addonsqty = explode(",", $item->addonsqty);
            $x = 0;
            foreach ($addons as $addonsid) {
                $adonsinfo   = $this->hungry_model->read('*', 'add_ons', array('add_on_id' => $addonsid));
                $adonsprice += $adonsinfo->price * $addonsqty[$x];
                $addons_display[] = $adonsinfo->add_on_name ?? '';
                $x++;
            }
        }
        $lineTotal = $itemprice + $adonsprice;
        $subtotal += $lineTotal;
    ?>
    <div class="receipt-item-row">
        <div style="display:flex;align-items:flex-start;flex:1;">
            <span class="receipt-item-qty"><?php echo $item->menuqty; ?>x</span>
            <div>
                <div class="receipt-item-name"><?php echo htmlspecialchars($item->ProductName); ?></div>
                <?php if (!empty($addons_display)): ?>
                <div class="receipt-addon-line">+ <?php echo htmlspecialchars(implode(', ', array_filter($addons_display))); ?></div>
                <?php endif; ?>
            </div>
        </div>
        <span class="receipt-item-price">
            <?php if ($currency->position == 1) echo $currency->curr_icon; ?>
            <?php echo number_format($lineTotal, 0, '.', ' '); ?>
            <?php if ($currency->position == 2) echo $currency->curr_icon; ?>
        </span>
    </div>
    <?php endforeach; ?>

    <hr class="receipt-divider">

    <!-- Totaux -->
    <?php
    $calvat       = !empty($billinfo) ? ($billinfo->VAT ?? 0) : 0;
    $discount     = !empty($billinfo) ? ($billinfo->discount ?? 0) : 0;
    if (!empty($storeinfo->service_chargeType) && $storeinfo->service_chargeType == 1) {
        $servicecharge = $subtotal * $storeinfo->servicecharge / 100;
    } else {
        $servicecharge = !empty($storeinfo->servicecharge) ? $storeinfo->servicecharge : 0;
    }
    $grandtotal = $subtotal + $calvat + $servicecharge - $discount;
    ?>
    <div class="receipt-totals-row">
        <span><?php echo display('subtotal') ?></span>
        <span><?php if ($currency->position == 1) echo $currency->curr_icon; ?><?php echo number_format($subtotal, 0, '.', ' '); ?><?php if ($currency->position == 2) echo $currency->curr_icon; ?></span>
    </div>
    <?php if ($calvat > 0): ?>
    <div class="receipt-totals-row">
        <span><?php echo display('vat_tax') ?></span>
        <span><?php if ($currency->position == 1) echo $currency->curr_icon; ?><?php echo number_format($calvat, 0, '.', ' '); ?><?php if ($currency->position == 2) echo $currency->curr_icon; ?></span>
    </div>
    <?php endif; ?>
    <?php if ($servicecharge > 0): ?>
    <div class="receipt-totals-row">
        <span><?php echo display('service_chrg') ?></span>
        <span><?php if ($currency->position == 1) echo $currency->curr_icon; ?><?php echo number_format($servicecharge, 0, '.', ' '); ?><?php if ($currency->position == 2) echo $currency->curr_icon; ?></span>
    </div>
    <?php endif; ?>
    <?php if ($discount > 0): ?>
    <div class="receipt-totals-row">
        <span><?php echo display('discount') ?></span>
        <span>-<?php if ($currency->position == 1) echo $currency->curr_icon; ?><?php echo number_format($discount, 0, '.', ' '); ?><?php if ($currency->position == 2) echo $currency->curr_icon; ?></span>
    </div>
    <?php endif; ?>
    <div class="receipt-totals-row grand-total">
        <span><?php echo display('total') ?></span>
        <span><?php if ($currency->position == 1) echo $currency->curr_icon; ?><?php echo number_format($grandtotal, 0, '.', ' '); ?><?php if ($currency->position == 2) echo $currency->curr_icon; ?></span>
    </div>

    <button class="btn-download-receipt" onclick="window.print()">
        <i class="fa fa-download"></i> Télécharger le reçu
    </button>
</div>
