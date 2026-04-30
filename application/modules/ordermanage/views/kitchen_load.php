<?php 
									 if(!empty($ongoingorder)){
									 foreach($ongoingorder as $onprocess){
										 $billtotal=round($onprocess->totalamount);
										  if(($onprocess->orderacceptreject==0 || empty($onprocess->orderacceptreject)) && ($onprocess->cutomertype==2)){}
										 else{
										 ?>
                                  		<div class="col-sm-3 col-md-2 col-lg-2 kcard-col">
                                            <div class="kcard">
                                                <div class="kcard-header">
                                                    <span class="kcard-order">#<?php echo $onprocess->saleinvoice; ?></span>
                                                    <span class="kcard-status <?php echo ($onprocess->order_status == 1) ? 'kcard-pending' : 'kcard-accepted'; ?>">
                                                        <?php echo ($onprocess->order_status == 1) ? 'Pending' : 'Accepted'; ?>
                                                    </span>
                                                </div>
                                                <div class="kcard-body">
                                                    <?php if (!empty($onprocess->tablename)) : ?>
                                                    <div class="kcard-row"><i class="fa fa-cutlery"></i> <strong><?php echo display('table'); ?>:</strong> <?php echo $onprocess->tablename; ?></div>
                                                    <?php endif; ?>
                                                    <div class="kcard-row"><i class="fa fa-ticket"></i> <strong><?php echo display('tok'); ?>:</strong> <?php echo $onprocess->tokenno; ?></div>
                                                    <div class="kcard-row"><i class="fa fa-user"></i> <strong><?php echo display('waiter'); ?>:</strong> <?php echo $onprocess->first_name . ' ' . $onprocess->last_name; ?></div>
                                                    <?php if (!empty($onprocess->cookedtime)) : ?>
                                                    <div class="kcard-row"><i class="fa fa-clock-o"></i> <strong><?php echo display('cookedtime'); ?>:</strong> <?php echo $onprocess->cookedtime; ?></div>
                                                    <?php endif; ?>
                                                    <?php
                                                    if (!empty($onprocess->order_time)) {
                                                        try {
                                                            $ot = new DateTime($onprocess->order_time);
                                                            $nw = new DateTime();
                                                            $df = $nw->diff($ot);
                                                            $elapsed = ($df->h > 0) ? $df->h . 'h ' . $df->i . 'min' : $df->i . ' min';
                                                        } catch (Exception $e) { $elapsed = ''; }
                                                        if ($elapsed) echo '<div class="kcard-elapsed"><i class="fa fa-hourglass-half"></i> ' . $elapsed . ' ago</div>';
                                                    }
                                                    ?>
                                                </div>
                                                <a href="javascript:;" onclick="oredrready('<?php echo $onprocess->order_id; ?>')" class="kcard-btn"><?php echo display('view_ord'); ?></a>
                                            </div>
                                        </div>
                                     <?php } } }
									  else{ 
									   $odmsg=display('no_order_run');
									  echo "<p style='padding-left:12px;'>".$odmsg."</p>";
									  }
									 ?>