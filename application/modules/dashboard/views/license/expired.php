<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
.exp-wrap  { display:flex; align-items:center; justify-content:center; min-height:60vh; }
.exp-box   { background:#fff; border-radius:16px; box-shadow:0 4px 24px rgba(0,0,0,.1); padding:48px 40px; text-align:center; max-width:480px; }
.exp-icon  { font-size:56px; margin-bottom:16px; }
.exp-title { font-size:24px; font-weight:700; color:#111827; margin:0 0 8px; }
.exp-sub   { color:#6b7280; font-size:15px; margin:0 0 24px; }
.exp-info  { background:#fef3c7; border-radius:10px; padding:16px; margin-bottom:28px; font-size:14px; color:#92400e; }
.exp-btn   { display:inline-block; padding:12px 28px; background:#2563eb; color:#fff; border-radius:8px; font-weight:600; font-size:15px; text-decoration:none; }
.exp-btn:hover { background:#1d4ed8; color:#fff; }
</style>

<div class="exp-wrap">
    <div class="exp-box">
        <div class="exp-icon">🔒</div>
        <h2 class="exp-title">Abonnement expiré</h2>
        <p class="exp-sub">
            Votre période de grâce est terminée.<br>
            L'accès au système a été suspendu.
        </p>

        <?php if (!empty($payload)): ?>
        <div class="exp-info">
            Plan : <strong><?php echo htmlspecialchars($payload['plan'] ?? '—'); ?></strong><br>
            Expiré le : <strong><?php echo date('d/m/Y', strtotime($payload['valid_until'] ?? 'now')); ?></strong><br>
            Grâce terminée le : <strong><?php echo date('d/m/Y', strtotime($payload['grace_until'] ?? 'now')); ?></strong>
        </div>
        <?php endif; ?>

        <p style="color:#6b7280;font-size:14px;margin-bottom:24px">
            Contactez votre fournisseur pour renouveler votre abonnement,<br>
            puis revenez activer votre nouvelle clé.
        </p>

        <a href="<?php echo site_url('dashboard/license'); ?>" class="exp-btn">
            Saisir une nouvelle clé
        </a>
    </div>
</div>
