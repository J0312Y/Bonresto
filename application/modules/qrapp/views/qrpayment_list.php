<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Moyen de paiement</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($payments)) { 
            $sl=1;
            foreach($payments as $pay){ ?>
            <tr>
                <td><?php echo $sl++; ?></td>
                <td><?php echo $pay->payment_method; ?></td>
            </tr>
        <?php } } ?>
    </tbody>
</table>
