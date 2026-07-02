<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd lob32">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4><i class="fa fa-bell"></i> Appels serveur
                        <span id="pending-badge" class="badge badge-danger" style="background:#d9534f; margin-left:8px; <?php echo (!empty($pending_count) && $pending_count > 0) ? '' : 'display:none;'; ?>"><?php echo !empty($pending_count) ? $pending_count : 0; ?></span>
                    </h4>
                </div>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="waitercalls_table" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Table</th>
                                <th>Type</th>
                                <th>Heure</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($calls)) { foreach ($calls as $call) { ?>
                            <tr id="call-row-<?php echo $call->id; ?>" class="<?php echo $call->status == 0 ? 'warning' : ($call->status == 1 ? 'info' : ''); ?>">
                                <td><?php echo $call->id; ?></td>
                                <td><strong><?php echo !empty($call->tablename) ? htmlspecialchars($call->tablename) : 'Table #' . $call->table_id; ?></strong></td>
                                <td>
                                    <?php if ($call->call_type == 'waiter') { ?>
                                        <span class="label label-primary"><i class="fa fa-hand-paper-o"></i> Serveur</span>
                                    <?php } else { ?>
                                        <span class="label label-warning"><i class="fa fa-file-text-o"></i> Addition</span>
                                    <?php } ?>
                                </td>
                                <td><?php echo date('H:i:s', strtotime($call->created_at)); ?></td>
                                <td>
                                    <?php if ($call->status == 0) { ?>
                                        <span class="label label-danger">En attente</span>
                                    <?php } elseif ($call->status == 1) { ?>
                                        <span class="label label-info">Accepté</span>
                                    <?php } else { ?>
                                        <span class="label label-success">Terminé</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($call->status == 0) { ?>
                                        <button class="btn btn-sm btn-info" onclick="acknowledgeCall(<?php echo $call->id; ?>)"><i class="fa fa-check"></i> Accepter</button>
                                    <?php } elseif ($call->status == 1) { ?>
                                        <button class="btn btn-sm btn-success" onclick="completeCall(<?php echo $call->id; ?>)"><i class="fa fa-check-circle"></i> Terminer</button>
                                    <?php } else { ?>
                                        <span class="text-muted">-</span>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } } else { ?>
                            <tr><td colspan="6" class="text-center">Aucun appel</td></tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Audio alert for new calls -->
<audio id="call-alert-sound" preload="auto">
    <source src="<?php echo base_url('assets/2021-03-21/b1.mp3'); ?>" type="audio/mpeg">
</audio>

<script>
var lastCallCount = <?php echo !empty($pending_count) ? $pending_count : 0; ?>;
var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

function acknowledgeCall(id) {
    var data = {};
    data[csrfName] = csrfHash;
    $.ajax({
        url: '<?php echo base_url("ordermanage/order/acknowledgecall/"); ?>' + id,
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function(r) {
            if (r.status === 'success') {
                refreshCalls();
            }
        }
    });
}

function completeCall(id) {
    var data = {};
    data[csrfName] = csrfHash;
    $.ajax({
        url: '<?php echo base_url("ordermanage/order/completecall/"); ?>' + id,
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function(r) {
            if (r.status === 'success') {
                refreshCalls();
            }
        }
    });
}

function refreshCalls() {
    $.ajax({
        url: '<?php echo base_url("ordermanage/order/waitercalls_ajax"); ?>',
        type: 'GET',
        success: function(html) {
            $('#waitercalls_table tbody').html(html);
        }
    });
}

function checkNewCalls() {
    $.ajax({
        url: '<?php echo base_url("ordermanage/order/waitercalls_count"); ?>',
        type: 'GET',
        dataType: 'json',
        success: function(r) {
            if (r.count > lastCallCount) {
                var audio = document.getElementById('call-alert-sound');
                if (audio) { audio.play().catch(function(){}); }
                refreshCalls();
            }
            lastCallCount = r.count;
            if (r.count > 0) {
                $('#pending-badge').text(r.count).show();
            } else {
                $('#pending-badge').hide();
            }
        }
    });
}

// Auto-refresh every 15 seconds
setInterval(checkNewCalls, 15000);
</script>
