<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
.upd-card       { background:#fff; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,.07); padding:28px 32px; margin-bottom:20px; }
.upd-header     { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; }
.upd-title      { font-size:20px; font-weight:700; color:#1a202c; margin:0; }
.upd-plan       { font-size:13px; color:#6b7280; margin-top:4px; }
.upd-badge      { display:inline-flex; align-items:center; gap:5px; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600; }
.upd-pending    { background:#fef3c7; color:#92400e; }
.upd-applied    { background:#d1fae5; color:#065f46; }
.upd-failed     { background:#fee2e2; color:#991b1b; }
.upd-row        { display:flex; align-items:flex-start; gap:16px; padding:16px 0; border-bottom:1px solid #f3f4f6; }
.upd-row:last-child { border-bottom:none; }
.upd-icon       { width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.upd-icon-cfg   { background:#eff6ff; color:#3b82f6; }
.upd-icon-code  { background:#f0fdf4; color:#22c55e; }
.upd-name       { font-size:14px; font-weight:600; color:#1a202c; }
.upd-meta       { font-size:12px; color:#9ca3af; margin-top:2px; }
.upd-changelog  { font-size:13px; color:#4b5563; margin-top:6px; line-height:1.5; }
.upd-empty      { text-align:center; padding:48px 0; color:#9ca3af; }
.upd-empty i    { font-size:40px; display:block; margin-bottom:12px; }
.btn-apply      { background:#37a000; color:#fff; border:none; border-radius:8px; padding:10px 22px; font-size:14px; font-weight:600; cursor:pointer; display:inline-flex; align-items:center; gap:7px; }
.btn-apply:hover { background:#2d8600; }
.alert-ok  { background:#d1fae5; color:#065f46; border:1px solid #6ee7b7; border-radius:8px; padding:12px 16px; margin-bottom:16px; font-size:14px; }
.alert-err { background:#fee2e2; color:#991b1b; border:1px solid #fca5a5; border-radius:8px; padding:12px 16px; margin-bottom:16px; font-size:14px; }
</style>

<div class="row">
    <div class="col-md-10 col-md-offset-1">

        <?php if ($success): ?>
            <div class="alert-ok"><i class="fa fa-check-circle"></i> <?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert-err"><i class="fa fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- ── Header ──────────────────────────────────────────────── -->
        <div class="upd-card">
            <div class="upd-header">
                <div>
                    <h2 class="upd-title"><i class="fa fa-cloud-download" style="color:#37a000;margin-right:8px;"></i>Mises à jour Bonresto</h2>
                    <p class="upd-plan">
                        Version installée : <strong>v<?php echo htmlspecialchars($current_version); ?></strong>
                        &nbsp;·&nbsp;
                        Plan : <strong><?php echo htmlspecialchars($plan); ?></strong>
                        <?php if ($pending_count > 0): ?>
                            &nbsp;·&nbsp; <span style="color:#d97706;font-weight:600;"><?php echo $pending_count; ?> mise<?php echo $pending_count > 1 ? 's' : ''; ?> à jour en attente</span>
                        <?php else: ?>
                            &nbsp;·&nbsp; <span style="color:#059669;">À jour</span>
                        <?php endif; ?>
                    </p>
                </div>
                <div style="display:flex;gap:10px;align-items:center;">
                    <form method="post" action="<?php echo base_url('dashboard/autoupdate/apply'); ?>" style="margin:0;">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <button type="submit" class="btn-apply" onclick="return confirm('Vérifier et appliquer les mises à jour disponibles ?')">
                            <i class="fa fa-refresh"></i> Vérifier & Appliquer
                        </button>
                    </form>
                </div>
            </div>

            <!-- ── Updates list ──────────────────────────────────── -->
            <?php if (empty($updates)): ?>
                <div class="upd-empty">
                    <i class="fa fa-check-circle" style="color:#37a000;"></i>
                    Aucune mise à jour disponible pour le moment.
                </div>
            <?php else: ?>
                <?php foreach ($updates as $u): ?>
                    <?php
                        $is_code = $u['type'] === 'code';
                        $status  = $u['delivery_status'];
                        $badge   = match($status) {
                            'applied' => ['class' => 'upd-applied', 'icon' => 'fa-check',           'label' => 'Appliqué'],
                            'failed'  => ['class' => 'upd-failed',  'icon' => 'fa-exclamation',     'label' => 'Échoué'],
                            default   => ['class' => 'upd-pending', 'icon' => 'fa-clock-o',         'label' => 'En attente'],
                        };
                    ?>
                    <div class="upd-row">
                        <div class="upd-icon <?php echo $is_code ? 'upd-icon-code' : 'upd-icon-cfg'; ?>">
                            <i class="fa <?php echo $is_code ? 'fa-code' : 'fa-cog'; ?> fa-lg"></i>
                        </div>
                        <div style="flex:1;">
                            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                                <span class="upd-name"><?php echo htmlspecialchars($u['title']); ?></span>
                                <span class="upd-badge <?php echo $badge['class']; ?>">
                                    <i class="fa <?php echo $badge['icon']; ?>"></i> <?php echo $badge['label']; ?>
                                </span>
                            </div>
                            <div class="upd-meta">
                                v<?php echo htmlspecialchars($u['version']); ?>
                                &nbsp;·&nbsp; Module : <strong><?php echo htmlspecialchars($u['module']); ?></strong>
                                &nbsp;·&nbsp; <?php echo $is_code ? 'Mise à jour code' : 'Mise à jour config'; ?>
                                &nbsp;·&nbsp; Publié le <?php echo date('d/m/Y', strtotime($u['published_at'])); ?>
                                <?php if ($status === 'applied' && !empty($u['applied_at'])): ?>
                                    &nbsp;·&nbsp; Appliqué le <?php echo date('d/m/Y à H\hi', strtotime($u['applied_at'])); ?>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($u['changelog'])): ?>
                                <div class="upd-changelog"><?php echo nl2br(htmlspecialchars($u['changelog'])); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>
</div>
