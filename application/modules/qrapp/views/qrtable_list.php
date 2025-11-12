<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12">
        <h4>Liste des Tables QR</h4>
        <a href="<?php echo base_url('qrapp/qrtable/generate_all_qr'); ?>" class="btn btn-success mb-2">
            Générer tous les QR Codes
        </a>
        <a href="<?php echo base_url('qrapp/qrtable/print_qr'); ?>" class="btn btn-primary mb-2" target="_blank">
            Imprimer tous les QR Codes
        </a>

        <table class="table table-bordered table-hover" id="allqrtable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom Table</th>
                    <th>Capacité</th>
                    <th>QR Code</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tables as $table): ?>
                <tr>
                    <td><?php echo $table->tableid; ?></td>
                    <td><?php echo $table->tablename; ?></td>
                    <td><?php echo $table->person_capicity; ?></td>
                    <td>
                        <?php if (!empty($table->qr_code)): ?>
                            <img src="<?php echo base_url('uploads/qrcodes/' . $table->qr_code); ?>" width="100">
                        <?php else: ?>
                            <span class="text-danger">Non généré</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo base_url('qrapp/qrtable/generate_qr/' . $table->tableid); ?>" class="btn btn-sm btn-success">
                            Générer QR
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
