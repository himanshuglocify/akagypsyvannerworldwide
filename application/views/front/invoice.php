 <!-- Header -->     
    <header class="inner-page-bg">
        <div class="container">
            <div class="inner-title">
                <span><?php echo $page_title; ?></span>
            </div>
        </div>
    </header>
    
<!--=== Breadcrumbs ===-->
    <div class="breadcrumbs">
        <div class="container">
            <h1 class="text-center"><?php echo translate('invoice_paper');?></h1>
        </div><!--/container-->
    </div><!--/breadcrumbs-->
    <!--=== End Breadcrumbs ===-->

    <!--=== Content Part ===-->
    <div class="container content invoice_div box-border margin-top-20 margin-bottom-20">
    <?php
        $sale_details = $this->db->get_where('sale',array('sale_id'=>$sale_id))->result_array();
        foreach($sale_details as $row){
    ?>
        <!--Invoice Header-->
        <div class="row invoice-header">
            <div class="col-sm-3 col-md-3 col-lg-3 col-xs-3">
                <img src="<?php echo $this->crud_model->logo('home_top_logo'); ?>" alt="" width="60%">
            </div>
			<div class="col-sm-3 col-md-3 col-lg-3 col-xs-3">
                &nbsp;
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6 invoice-numb">
            	<ul class="list-unstyled">
                    <li><strong><?php echo translate('invoice_no');?></strong> : <?php echo $row['sale_code']; ?> </li>
                    <li><strong><?php echo translate('date');?></strong> : <?php echo date('d M, Y',$row['sale_datetime'] );?></li>
                </ul>
            </div>
        </div>
        <!--End Invoice Header-->

        <!--Invoice Detials-->
        <div class="row invoice-info">
            <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
                <div class="tag-box tag-box-v3">
                    <?php
                        $info = json_decode($row['shipping_address'],true);
                    ?>
                    <h2><?php echo translate('client_information:');?></h2>
                    <ul class="list-unstyled">
                        <li><strong><?php echo translate('first_name:');?></strong> <?php echo $info['firstname']; ?></li>
                        <li><strong><?php echo translate('last_name:');?></strong> <?php echo $info['lastname']; ?></li>
                        <li><strong><?php echo translate('city_:');?></strong> <?php echo $info['city']; ?></li>
                    </ul>
                </div>        
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
                <div class="tag-box tag-box-v3">
                    <h2><?php echo translate('peyment_details_:');?></h2>  
                    <ul class="list-unstyled">       
                        <li><strong><?php echo translate('payment_status_:');?></strong> <i><?php echo translate($this->crud_model->sale_payment_status($row['sale_id'])); ?></i></li>
                        <li><strong><?php echo translate('payment_method_:');?></strong> <?php echo ucfirst(str_replace('_', ' ', $info['payment_type'])); ?></li>  
                    </ul>
                </div>
            </div>
        </div>
        <!--End Invoice Detials-->

        <!--Invoice Table-->
        <div class="panel panel-purple margin-bottom-40">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo translate('payment_invoice');?></h3>
            </div>
            <table class="table table-striped invoice-table">
                <thead>
                    <tr>
                        <th><?php echo translate('no');?></th>
                        <th><?php echo translate('item');?></th>
                        <?php /* ?> <th><?php echo translate('options');?></th>
                        <th><?php echo translate('quantity');?></th><?php */ ?>
                        <th><?php echo translate('commission');?></th>
                        <th><?php echo translate('total');?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
					$commission = '';
                        $product_details = json_decode($row['product_details'], true);
						
                        $i =0;
                        $total = 0;
                        foreach ($product_details as $row1) {
                            $i++;
                    ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row1['name']; ?></td>
                            <?php /* ?><td>
                                <?php 
                                    $option = json_decode($row1['option'],true);
                                    foreach ($option as $l => $op) {
                                        if($l !== 'color' && $op['value'] !== '' && $op['value'] !== NULL){
                                ?>
                                    <?php echo $op['title'] ?> : 
                                    <?php 
                                        if(is_array($va = $op['value'])){ 
                                            echo $va = join(', ',$va); 
                                        } else {
                                            echo $va;
                                        }
                                    ?>
                                    <br>
                                <?php
                                        }
                                    } 
                                ?>
                            </td> 
                            <td><?php echo $row1['qty']; ?></td><?php */ ?>
							<?php 
							$commission = $commission+$row1['commission'];
							?>
                            <td style="text-align:center;"><?php echo currency().$this->cart->format_number($row1['commission']); ?></td>
                            <td style="text-align:right;"><?php echo currency().$this->cart->format_number($row1['subtotal']); $total += $row1['subtotal']; ?></td>
                        </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <!--End Invoice Table-->
        <!--Invoice Footer-->
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
                <div class="tag-box tag-box-v6">
                    <h2><?php echo translate('address');?></h2>
                    <address>
                        <?php echo $info['address1']; ?> <br>
                        <?php echo $info['address2']; ?> <br>
                        <?php echo translate('city');?> : <?php echo $info['city']; ?> <br>
                        <?php echo translate('zip');?> : <?php echo $info['zip']; ?> <br>
                        <?php echo translate('phone');?> : <?php echo $info['phone']; ?> <br>
                        <?php echo translate('e-mail');?> : <a href=""><?php echo $info['email']; ?></a>
                    </address>
                </div>            
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
            	<div class="tag-box tag-box-v6" style="padding:0px 15px !important;">
                 	 <table class="table">
                     	<tr>
                        	<td><?php echo translate('sub_total_amount');?> :</td>
                        	<td><?php echo currency().$this->cart->format_number($total);?></td>
                        </tr>
                        <tr>
                        	<td><?php echo translate('total_commission');?> :</td>
                            <td><?php echo currency().$this->cart->format_number($commission);?></td>
                        </tr>
                        <tr>
                        	<td><?php echo translate('shipping');?> :</td>
                            <td><?php echo currency().$this->cart->format_number($row1['shipping']);?></td>
                        </tr>
                        <tr>
                        	<td><?php echo 'Payable 20% Amount';?> :</td>
                            <td><?php echo currency().$this->cart->format_number($row['grand_total']);?></td>
                        </tr>
                     </table>
               </div>
               
                <button class="btn-u btn-u-cust push pull-right margin-bottom-10" onclick="javascript:window.print();">
                	<i class="fa fa-print"></i> <?php echo translate('print');?>
                </button>
            </div>
        </div>
   
        <!--End Invoice Footer-->
        <style type="text/css">
            @media print {
                .push{
                    display: none;
                }
                .topbar-v3{
                    display: none;
                }
                .breadcrumbs{
                    display: none;
                }
                .footer-v2{
                    display: none;
                }
                .invoice_div{
                    display: block;
                }
            }
        </style>
        
       
    <?php } ?>
    </div><!--/container-->     
    <!--=== End Content Part ===-->