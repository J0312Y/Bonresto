<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
.lic-card      { background:#fff; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,.08); padding:32px; margin-bottom:24px; }
.lic-badge     { display:inline-block; padding:4px 14px; border-radius:20px; font-size:13px; font-weight:600; }
.lic-active    { background:#d1fae5; color:#065f46; }
.lic-grace     { background:#fef3c7; color:#92400e; }
.lic-expired   { background:#fee2e2; color:#991b1b; }
.lic-none      { background:#f3f4f6; color:#6b7280; }
.lic-table td,
.lic-table th  { padding:8px 12px; border-bottom:1px solid #f3f4f6; font-size:14px; }
.lic-table th  { color:#6b7280; font-weight:500; width:180px; }
.lic-input     { width:100%; padding:10px 14px; border:1px solid #d1d5db; border-radius:8px; font-size:15px; letter-spacing:2px; }
.lic-btn       { padding:10px 24px; border:none; border-radius:8px; font-size:14px; font-weight:600; cursor:pointer; }
.lic-btn-pri   { background:#2563eb; color:#fff; }
.lic-btn-pri:hover { background:#1d4ed8; }
.lic-btn-sec   { background:#f3f4f6; color:#374151; margin-left:8px; }
.lic-btn-sec:hover { background:#e5e7eb; }
.lic-alert     { padding:12px 16px; border-radius:8px; margin-bottom:20px; font-size:14px; }
.lic-alert-ok  { background:#d1fae5; color:#065f46; border:1px solid #6ee7b7; }
.lic-alert-err { background:#fee2e2; color:#991b1b; border:1px solid #fca5a5; }
.lic-features  { display:flex; flex-wrap:wrap; gap:8px; margin-top:4px; }
.lic-feat      { background:#eff6ff; color:#1d4ed8; border-radius:6px; padding:3px 10px; font-size:12px; }
</style>

<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <div style="margin-bottom:20px">
            <h3 style="margin:0;font-size:22px">Gestion de la Licence</h3>
            <p style="color:#6b7280;margin-top:4px">Abonnement Bonresto SaaS</p>
        </div>

        <?php if ($error): ?>
            <div class="lic-alert lic-alert-err"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="lic-alert lic-alert-ok"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <?php if ($status !== 'none'): ?>
        <!-- ── Current License Status ────────────────────────────────────── -->
        <div class="lic-card">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
                <h4 style="margin:0">Licence actuelle</h4>
                <?php
                    $badge_class = match($status) {
                        'active'  => 'lic-active',
                        'grace'   => 'lic-grace',
                        'expired' => 'lic-expired',
                        default   => 'lic-none',
                    };
                    $badge_label = match($status) {
                        'active'  => 'Actif',
                        'grace'   => 'Période de grâce',
                        'expired' => 'Expiré',
                        default   => 'Inconnu',
                    };
                ?>
                <span class="lic-badge <?php echo $badge_class; ?>"><?php echo $badge_label; ?></span>
            </div>

            <table class="lic-table" style="width:100%">
                <tr><th>Plan</th><td><?php echo htmlspecialchars($payload['plan'] ?? '—'); ?></td></tr>
                <tr><th>Client ID</th><td><?php echo (int)($payload['client_id'] ?? 0); ?></td></tr>
                <tr><th>Valide jusqu'au</th><td><?php echo date('d/m/Y', strtotime($payload['valid_until'] ?? 'now')); ?></td></tr>
                <tr><th>Grâce jusqu'au</th><td><?php echo date('d/m/Y', strtotime($payload['grace_until'] ?? 'now')); ?></td></tr>
                <tr><th>Tables max</th><td><?php echo (int)($payload['max_tables'] ?? 0); ?></td></tr>
                <tr><th>Utilisateurs max</th><td><?php echo (int)($payload['max_users'] ?? 0); ?></td></tr>
                <tr><th>Dernière mise à jour</th><td><?php echo $cached_at ? date('d/m/Y H:i', strtotime($cached_at)) : '—'; ?></td></tr>
                <?php if (!empty($payload['features'])): ?>
                <tr>
                    <th>Fonctionnalités</th>
                    <td>
                        <div class="lic-features">
                            <?php foreach ($payload['features'] as $feat => $enabled): ?>
                                <?php if ($enabled): ?>
                                    <span class="lic-feat"><?php echo htmlspecialchars($feat); ?></span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </table>

            <div style="margin-top:20px">
                <a href="<?php echo site_url('dashboard/license/refresh'); ?>" class="lic-btn lic-btn-sec">
                    ↻ Actualiser depuis le cloud
                </a>
            </div>
        </div>
        <?php endif; ?>

        <!-- ── Activation / Upgrade Form ───────────────────────────────── -->
        <div class="lic-card">
            <?php if ($status === 'none'): ?>
                <h4 style="margin:0 0 8px">Activer votre licence</h4>
                <p style="color:#6b7280;font-size:14px;margin-bottom:20px">
                    Saisissez la clé de licence fournie par votre prestataire pour activer votre abonnement.
                    La clé a le format <strong>XXXX-XXXX-XXXX-XXXX</strong>.
                </p>
            <?php elseif (in_array($status, ['grace', 'expired'])): ?>
                <h4 style="margin:0 0 8px;color:#b45309">Renouveler / Changer de plan</h4>
                <p style="color:#6b7280;font-size:14px;margin-bottom:20px">
                    Votre abonnement <?php echo $status === 'grace' ? 'arrive à expiration' : 'est expiré'; ?>.
                    Contactez votre prestataire pour obtenir une nouvelle clé et saisissez-la ci-dessous.
                </p>
            <?php else: ?>
                <h4 style="margin:0 0 8px">Changer de plan</h4>
                <p style="color:#6b7280;font-size:14px;margin-bottom:20px">
                    Pour passer à un plan supérieur ou modifier votre abonnement, demandez une nouvelle clé
                    à votre prestataire et saisissez-la ci-dessous. La nouvelle licence remplacera l'actuelle
                    immédiatement.
                </p>
            <?php endif; ?>

            <form method="post" action="<?php echo site_url('dashboard/license/activate'); ?>">
                <input type="hidden"
                    name="<?php echo $this->security->get_csrf_token_name(); ?>"
                    value="<?php echo $this->security->get_csrf_hash(); ?>">

                <div style="display:flex;gap:12px;align-items:center">
                    <input
                        type="text"
                        name="client_key"
                        class="lic-input"
                        placeholder="XXXX-XXXX-XXXX-XXXX"
                        value=""
                        maxlength="32"
                        autocomplete="off"
                        required
                    >
                    <button type="submit" class="lic-btn lic-btn-pri" style="white-space:nowrap">
                        <?php echo ($status === 'none') ? 'Activer' : 'Appliquer'; ?>
                    </button>
                </div>
            </form>
        </div>

        <?php if ($status !== 'none'): ?>
        <!-- ── Upgrade guidance ──────────────────────────────────────────── -->
        <div class="lic-card" style="background:#f9fafb;border:1px solid #e5e7eb;">
            <h4 style="margin:0 0 12px;font-size:15px;">Comment changer de plan ?</h4>
            <ol style="color:#374151;font-size:14px;line-height:1.8;padding-left:20px;margin:0;">
                <li>Contactez votre prestataire Bonresto pour demander un changement de plan.</li>
                <li>Votre prestataire génère une nouvelle clé associée au plan souhaité.</li>
                <li>Saisissez la nouvelle clé dans le formulaire ci-dessus et cliquez sur <strong>Appliquer</strong>.</li>
                <li>Les nouveaux modules sont débloqués instantanément.</li>
            </ol>
            <p style="margin-top:12px;font-size:13px;color:#6b7280;">
                Clé actuelle :
                <code style="background:#e5e7eb;padding:2px 8px;border-radius:4px;letter-spacing:1px;">
                    <?php echo htmlspecialchars($client_key ?: '—'); ?>
                </code>
            </p>
        </div>
        <?php endif; ?>

    </div>
</div>
