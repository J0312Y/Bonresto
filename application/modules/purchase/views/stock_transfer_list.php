<div class="form-group text-right">
    <?php if($this->permission->method('purchase','update')->access()): ?>
    <a href="<?php echo base_url('purchase/stock_transfer/create'); ?>" class="btn btn-primary btn-md">
        <i class="fa fa-exchange"></i> <?php echo display('new_transfer'); ?>
    </a>
    <a href="<?php echo base_url('purchase/stock_transfer/pending'); ?>" class="btn btn-warning btn-md">
        <i class="fa fa-inbox"></i> <?php echo display('pending_label'); ?>
        <?php if ($pending_count > 0): ?>
        <span class="badge"><?php echo (int) $pending_count; ?></span>
        <?php endif; ?>
    </a>
    <?php endif; ?>
</div>

<div class="row">
    <!-- Outgoing -->
    <div class="col-sm-6">
        <div class="panel panel-default thumbnail">
            <div class="panel-heading"><h4><i class="fa fa-arrow-up"></i> <?php echo display('transfers_sent'); ?></h4></div>
            <div class="panel-body">
                <?php if (!empty($outgoing)): ?>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo display('recipient_label'); ?></th>
                            <th><?php echo display('date_label'); ?></th>
                            <th><?php echo display('status_label'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($outgoing as $t): ?>
                        <tr>
                            <td><?php echo (int) $t->id; ?></td>
                            <td><?php echo html_escape($t->to_name); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($t->created_at)); ?></td>
                            <td>
                                <?php
                                $badges = ['pending' => 'label-warning', 'confirmed' => 'label-success', 'rejected' => 'label-danger'];
                                $labels = ['pending' => display('status_pending'), 'confirmed' => display('status_confirmed'), 'rejected' => display('status_rejected')];
                                ?>
                                <span class="label <?php echo $badges[$t->status]; ?>"><?php echo $labels[$t->status]; ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p class="text-muted"><?php echo display('no_transfer_sent'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Incoming -->
    <div class="col-sm-6">
        <div class="panel panel-default thumbnail">
            <div class="panel-heading"><h4><i class="fa fa-arrow-down"></i> <?php echo display('transfers_received'); ?></h4></div>
            <div class="panel-body">
                <?php if (!empty($incoming)): ?>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo display('sender_label'); ?></th>
                            <th><?php echo display('date_label'); ?></th>
                            <th><?php echo display('status_label'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($incoming as $t): ?>
                        <tr>
                            <td><?php echo (int) $t->id; ?></td>
                            <td><?php echo html_escape($t->from_name); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($t->created_at)); ?></td>
                            <td>
                                <span class="label <?php echo $badges[$t->status]; ?>"><?php echo $labels[$t->status]; ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p class="text-muted"><?php echo display('no_transfer_received'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
