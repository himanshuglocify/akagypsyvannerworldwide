
<div class="panel-heading">
    <div class="panel-control" style="float: left;">
        <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#full"><?php echo translate('full_invoice'); ?></a>
            </li>
            <?php
                if($this->crud_model->is_admin_in_sale($sale[0]['sale_id'])){
            ?>
            <li>
                <a data-toggle="tab" href="#quart"><?php echo translate('invoice_for'); ?>: <?php echo translate('admin'); ?></a>
            </li>
            <?php
                }
            ?>
            <?php
                $vendors = $this->crud_model->vendors_in_sale($sale[0]['sale_id']);
                foreach ($vendors as $ven) {
            ?>
            <li>
                <a data-toggle="tab" href="#half_<?php echo $ven; ?>"><?php echo translate('invoice_for'); ?>: <?php echo $this->crud_model->get_type_name_by_id('vendor', $ven, 'display_name'); ?> (<?php echo translate('vendor'); ?>)</a>
            </li>
            <?php
                }
            ?>
			<?php 
			$sale_id = $sale[0]['sale_id'];
			$adminpay = $this->crud_model->getsiglefield('user_payment_request','sale_id',$sale_id);
			if(count($adminpay)>0){ ?>
			 <li>
                <a data-toggle="tab" href="#req_vendor"><?php echo translate('request_payment_from_user'); ?></a>
            </li>
			<li>
                <a data-toggle="tab" href="#adjust_payment"><?php echo translate('adjust_payment'); ?></a>
            </li>
			<?php }  $payment_status = json_decode($sale[0]['payment_status'],true); 
			foreach ($payment_status as $dev) {
			if(isset($dev['vendor'])){ ?>
			<li>
                <a data-toggle="tab" href="#vendor_payment"><?php echo translate('vendor_payment'); ?></a>
            </li>
			<?php } break; } ?>
        </ul>
    </div>
</div>

<div class="panel-body ">
    <div class="tab-base"> 
        <?php
        	foreach($sale as $row){
                $info = json_decode($row['shipping_address'],true);
                //invoice and map
        ?>

        <div class="col-md-2"></div>

        <div class="col-md-8 bordered print">

            <div class="tab-content">
                <div id="full" class="tab-pane fade active in">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-lg-4 col-md-4 col-sm-12 pad-all">
                                <img src="<?php echo $this->crud_model->logo('home_top_logo'); ?>" alt="Active Super Shop" width="85%">
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-12 pad-all">
                                <b class="pull-right">
                                    <?php echo translate('invoice_no:');?> :<?php echo $row['sale_code']; ?>  
                                </b>
                                <br>
                                <b class="pull-right">
                                    <?php echo translate('date_:');?> <?php echo date('d M, Y',$row['sale_datetime'] );?>
                                </b>
                            </div>
                        </div>
                        
                        <div class="col-md-12 pad-top">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                            <!--Panel heading-->
                                <div class="panel panel-bordered-grey shadow-none">
                                    <div class="panel-heading">
                                        <h1 class="panel-title"><?php echo translate('client_information');?></h1>
                                    </div>
                                    <!--List group-->
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td><b><?php echo translate('first_name');?></b></td>
                                                <td><?php echo $info['firstname']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b><?php echo translate('last_name');?></b></td>
                                                <td><?php echo $info['lastname']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b><?php echo translate('city');?></b></td>
                                                <td><?php echo $info['city']; ?>  </td>
                                            </tr>
                                        </tbody>
                                    </table>    
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                            <!--Panel heading-->
                                <div class="panel panel-bordered-grey shadow-none">
                                    <div class="panel-heading">
                                        <h1 class="panel-title"><?php echo translate('payment_detail');?></h1>
                                    </div>
                                    <!--List group-->
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td><b><?php echo translate('payment_status');?></b></td>
                                                <td><i><?php echo translate($this->crud_model->sale_payment_status($row['sale_id'])); ?></i></td>
                                            </tr>
                                            <tr>
                                                <td><b><?php echo translate('payment_method');?></b></td>
                                                <td><?php echo ucfirst(str_replace('_', ' ', $info['payment_type'])); ?></td>
                                            </tr>
                                            <tr>
                                                <td><b><?php echo translate('payment_date');?></b></td>
                                                <td><?php echo date('d M, Y',$row['sale_datetime'] );?></td>
                                            </tr>
                                        </tbody>
                                    </table>    
                                </div>
                            </div>
                       </div>
                    </div>

                    <div class="panel-body" id="demo_s">
                        <div class="fff panel panel-bordered panel-dark shadow-none">
                            <div class="panel-heading">
                                <h1 class="panel-title"><?php echo translate('payment_invoice');?></h1>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th><?php echo translate('no');?></th>
                                            <th><?php echo translate('item');?></th>
                                            <th><?php echo translate('horse_code');?></th>
                                            <th><?php echo translate('unit_cost');?></th>
                                            <th><?php echo translate('total');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $product_details = json_decode($row['product_details'], true);
                                            $i =0;
                                            $total = 0;
                                            foreach ($product_details as $row1) {
                                                $i++;
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row1['name']; ?></td>
                                            <td><?php //echo $this->db->get_where('product', array('product_id' => $row1['id']))->row()->horse_code(); ?></td>
                                            <td><?php echo currency().$this->cart->format_number($row1['price']); ?></td>
                                            <td><?php echo currency().$this->cart->format_number($row1['subtotal']); $total += $row1['subtotal']; ?></td>
                                        </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="col-lg-6 col-md-6 col-sm-6 pull-right margin-top-20">
                                    <div class="panel panel-colorful panel-grey shadow-none">
                                        <table class="table" border="0">
                                            <tbody>
                                                <tr>
                                                    <td><b><?php echo translate('sub_total_amount');?></b></td>
                                                    <td><?php echo currency().$this->cart->format_number($total); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('tax');?></b></td>
                                                    <td><?php echo currency().$this->cart->format_number($row['vat']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('shipping');?></b></td>
                                                    <td><?php echo currency().$this->cart->format_number($row['shipping']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('grand_total');?></b></td>
                                                    <td><?php echo currency().$this->cart->format_number($row['grand_total']); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div> 
                                </div>  
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <!--List group--> 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                <!--Panel heading-->
                                    <div class="panel panel-colorful panel-grey shadow-none">
                                        <div class="panel-heading">
                                            <h1 class="panel-title"><?php echo translate('client_information');?></h1>
                                        </div>
                                        <!--List group-->
                                        <table class="table" border="0">
                                            <tbody>
                                                <tr>
                                                    <td><b><?php echo translate('address_line_1');?></b></td>
                                                    <td><?php echo $info['address1']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('address_line_2');?></b></td>
                                                    <td><?php echo $info['address2']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('zipcode');?></b></td>
                                                    <td><?php echo $info['zip']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('city');?></b></td>
                                                    <td><?php echo $info['city']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('phone');?></b></td>
                                                    <td><?php echo $info['phone']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('e-mail');?></b></td>
                                                    <td><?php echo $info['email']; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>    
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                <!--Panel heading-->
                                    <div class="panel panel-bordered-grey shadow-none">
                                        <div class="panel-heading">
                                            <h1 class="panel-title"><?php echo translate('payment_detail');?></h1>
                                        </div>
                                        <!--List group-->
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td><b><?php echo translate('payment_status');?></b></td>
                                                    <td><?php echo translate($this->crud_model->sale_payment_status($row['sale_id'])); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('payment_method');?></b></td>
                                                    <td><?php echo ucfirst(str_replace('_', ' ', $info['payment_type'])); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('payment_date');?></b></td>
                                                    <td><?php echo date('d M, Y',$row['sale_datetime'] );?></td>
                                                </tr>
                                            </tbody>
                                        </table>    
                                    </div>
                                </div>
                           </div>
                        </div>
                    </div>
                </div>


                <?php
                    foreach ($vendors as $ven) {
                ?>
                <div id="half_<?php echo $ven; ?>" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-lg-4 col-md-4 col-sm-12 pad-all">
                                <img src="<?php echo $this->crud_model->logo('home_top_logo'); ?>" alt="Active Super Shop" width="85%">
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-12 pad-all">
                                <b class="pull-right">
                                    <?php echo translate('invoice_no:');?> :<?php echo $row['sale_code']; ?>/<?php echo $ven; ?> 
                                </b>
                                <br>
                                <b class="pull-right">
                                    <?php echo translate('date_:');?> <?php echo date('d M, Y',$row['sale_datetime'] );?>
                                </b>
                            </div>
                        </div>
                        
                        <div class="col-md-12 pad-top">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                            <!--Panel heading-->
                                <div class="panel panel-bordered-grey shadow-none">
                                    <div class="panel-heading">
                                        <h1 class="panel-title"><?php echo translate('client_information');?></h1>
                                    </div>
                                    <!--List group-->
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td><b><?php echo translate('first_name');?></b></td>
                                                <td><?php echo $info['firstname']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b><?php echo translate('last_name');?></b></td>
                                                <td><?php echo $info['lastname']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b><?php echo translate('city');?></b></td>
                                                <td><?php echo $info['city']; ?>  </td>
                                            </tr>
                                        </tbody>
                                    </table>    
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                            <!--Panel heading-->
                                <div class="panel panel-bordered-grey shadow-none">
                                    <div class="panel-heading">
                                        <h1 class="panel-title"><?php echo translate('payment_detail');?></h1>
                                    </div>
                                    <!--List group-->
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td><b><?php echo translate('payment_status');?></b></td>
                                                <td><i><?php echo translate($this->crud_model->sale_payment_status($row['sale_id'],'vendor',$ven)); ?></i></td>
                                            </tr>
                                            <tr>
                                                <td><b><?php echo translate('payment_method');?></b></td>
                                                <td><?php echo ucfirst(str_replace('_', ' ', $info['payment_type'])); ?></td>
                                            </tr>
                                            <tr>
                                                <td><b><?php echo translate('payment_date');?></b></td>
                                                <td><?php echo date('d M, Y',$row['sale_datetime'] );?></td>
                                            </tr>
                                        </tbody>
                                    </table>    
                                </div>
                            </div>
                       </div>
                    </div>

                    <div class="panel-body" id="demo_s">
                        <div class="panel panel-bordered panel-dark shadow-none">
                            <div class="panel-heading">
                                <h1 class="panel-title"><?php echo translate('payment_invoice');?></h1>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th><?php echo translate('no');?></th>
                                            <th><?php echo translate('item');?></th>
                                            <th><?php echo translate('horse_code');?></th>
                                            <th><?php echo translate('unit_cost');?></th>
                                            <th><?php echo translate('total');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $product_details = json_decode($row['product_details'], true);
                                            $i =0;
                                            $total = 0;
                                            $vat = 0;
                                            $shipping = 0;
                                            foreach ($product_details as $row1) {
                                                if($this->crud_model->is_added_by('product',$row1['id'],$ven)){
                                                $i++;
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row1['name']; ?></td>
                                            <td></td>
                                            <td><?php echo currency().$this->cart->format_number($row1['price']); ?></td>
                                            <td><?php echo currency().$this->cart->format_number($row1['subtotal']); $total += $row1['subtotal']; ?></td>
                                            <?php
                                                $vat += $row1['tax'];
                                                $shipping += $row1['shipping'];
                                            ?>
                                        </tr>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="col-lg-6 col-md-6 col-sm-6 pull-right margin-top-20">
                                    <div class="panel panel-colorful panel-grey shadow-none">
                                        <table class="table" border="0">
                                            <tbody>
                                                <tr>
                                                    <td><b><?php echo translate('sub_total_amount');?></b></td>
                                                    <td><?php echo currency().$this->cart->format_number($total); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('tax');?></b></td>
                                                    <td><?php echo currency().$this->cart->format_number($vat); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('shipping');?></b></td>
                                                    <td><?php echo currency().$this->cart->format_number($shipping); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('grand_total');?></b></td>
                                                    <td><?php echo currency().$this->cart->format_number($total+$vat+$shipping); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div> 
                                </div>  
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <!--List group--> 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                <!--Panel heading-->
                                    <div class="panel panel-colorful panel-grey shadow-none">
                                        <div class="panel-heading">
                                            <h1 class="panel-title"><?php echo translate('client_information');?></h1>
                                        </div>
                                        <!--List group-->
                                        <table class="table" border="0">
                                            <tbody>
                                                <tr>
                                                    <td><b><?php echo translate('address_line_1');?></b></td>
                                                    <td><?php echo $info['address1']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('address_line_2');?></b></td>
                                                    <td><?php echo $info['address2']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('zipcode');?></b></td>
                                                    <td><?php echo $info['zip']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('city');?></b></td>
                                                    <td><?php echo $info['city']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('phone');?></b></td>
                                                    <td><?php echo $info['phone']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('e-mail');?></b></td>
                                                    <td><?php echo $info['email']; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>    
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                <!--Panel heading-->
                                    <div class="panel panel-bordered-grey shadow-none">
                                        <div class="panel-heading">
                                            <h1 class="panel-title"><?php echo translate('payment_detail');?></h1>
                                        </div>
                                        <!--List group-->
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td><b><?php echo translate('payment_status');?></b></td>
                                                    <td><?php echo translate($this->crud_model->sale_payment_status($row['sale_id'],'vendor',$ven)); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('payment_method');?></b></td>
                                                    <td><?php echo ucfirst(str_replace('_', ' ', $info['payment_type'])); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('payment_date');?></b></td>
                                                    <td><?php echo date('d M, Y',$row['sale_datetime'] );?></td>
                                                </tr>
                                            </tbody>
                                        </table>    
                                    </div>
                                </div>
                           </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                ?>


                <div id="quart" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-lg-4 col-md-4 col-sm-12 pad-all">
                                <img src="<?php echo $this->crud_model->logo('home_top_logo'); ?>" alt="Active Super Shop" width="85%">
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-12 pad-all">
                                <b class="pull-right">
                                    <?php echo translate('invoice_no:');?> : <?php echo $row['sale_code']; ?> / A
                                </b>
                                <br>
                                <b class="pull-right">
                                    <?php echo translate('date_:');?> <?php echo date('d M, Y',$row['sale_datetime'] );?>
                                </b>
                            </div>
                        </div>
                        
                        <div class="col-md-12 pad-top">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                            <!--Panel heading-->
                                <div class="panel panel-bordered-grey shadow-none">
                                    <div class="panel-heading">
                                        <h1 class="panel-title"><?php echo translate('client_information');?></h1>
                                    </div>
                                    <!--List group-->
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td><b><?php echo translate('first_name');?></b></td>
                                                <td><?php echo $info['firstname']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b><?php echo translate('last_name');?></b></td>
                                                <td><?php echo $info['lastname']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b><?php echo translate('city');?></b></td>
                                                <td><?php echo $info['city']; ?>  </td>
                                            </tr>
                                        </tbody>
                                    </table>    
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                            <!--Panel heading-->
                                <div class="panel panel-bordered-grey shadow-none">
                                    <div class="panel-heading">
                                        <h1 class="panel-title"><?php echo translate('payment_detail');?></h1>
                                    </div>
                                    <!--List group-->
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td><b><?php echo translate('payment_status');?></b></td>
                                                <td><i><?php echo translate($this->crud_model->sale_payment_status($row['sale_id'],'admin')); ?></i></td>
                                            </tr>
                                            <tr>
                                                <td><b><?php echo translate('payment_method');?></b></td>
                                                <td><?php echo ucfirst(str_replace('_', ' ', $info['payment_type'])); ?></td>
                                            </tr>
                                            <tr>
                                                <td><b><?php echo translate('payment_date');?></b></td>
                                                <td><?php echo date('d M, Y',$row['sale_datetime'] );?></td>
                                            </tr>
                                        </tbody>
                                    </table>    
                                </div>
                            </div>
                       </div>
                    </div>

                    <div class="panel-body" id="demo_s">
                        <div class="panel panel-bordered panel-dark shadow-none">
                            <div class="panel-heading">
                                <h1 class="panel-title"><?php echo translate('payment_invoice');?></h1>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th><?php echo translate('no');?></th>
                                            <th><?php echo translate('item');?></th>
                                            <th><?php echo translate('horse_code');?></th>
                                            <th><?php echo translate('unit_cost');?></th>
                                            <th><?php echo translate('total');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $product_details = json_decode($row['product_details'], true);
                                            $i =0;
                                            $total = 0;
                                            $vat = 0;
                                            $shipping = 0;
                                            foreach ($product_details as $row1) {
                                                if($this->crud_model->is_added_by('product',$row1['id'],0,'admin')){
                                                $i++;
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row1['name']; ?></td>
                                            <td>
                                            </td>
                                            <td><?php echo currency().$this->cart->format_number($row1['price']); ?></td>
                                            <td><?php echo currency().$this->cart->format_number($row1['subtotal']); $total += $row1['subtotal']; ?></td>
                                            <?php
                                                $vat += $row1['tax'];
                                                $shipping += $row1['shipping'];
                                            ?>
                                        </tr>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="col-lg-6 col-md-6 col-sm-6 pull-right margin-top-20">
                                    <div class="panel panel-colorful panel-grey shadow-none">
                                        <table class="table" border="0">
                                            <tbody>
                                                <tr>
                                                    <td><b><?php echo translate('sub_total_amount');?></b></td>
                                                    <td><?php echo currency().$this->cart->format_number($total); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('tax');?></b></td>
                                                    <td><?php echo currency().$this->cart->format_number($vat); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('shipping');?></b></td>
                                                    <td><?php echo currency().$this->cart->format_number($shipping); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('grand_total');?></b></td>
                                                    <td><?php echo currency().$this->cart->format_number($total+$vat+$shipping); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div> 
                                </div>  
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <!--List group--> 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                <!--Panel heading-->
                                    <div class="panel panel-colorful panel-grey shadow-none">
                                        <div class="panel-heading">
                                            <h1 class="panel-title"><?php echo translate('client_information');?></h1>
                                        </div>
                                        <!--List group-->
                                        <table class="table" border="0">
                                            <tbody>
                                                <tr>
                                                    <td><b><?php echo translate('address_line_1');?></b></td>
                                                    <td><?php echo $info['address1']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('address_line_2');?></b></td>
                                                    <td><?php echo $info['address2']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('zipcode');?></b></td>
                                                    <td><?php echo $info['zip']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('city');?></b></td>
                                                    <td><?php echo $info['city']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('phone');?></b></td>
                                                    <td><?php echo $info['phone']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('e-mail');?></b></td>
                                                    <td><?php echo $info['email']; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>    
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                <!--Panel heading-->
                                    <div class="panel panel-bordered-grey shadow-none">
                                        <div class="panel-heading">
                                            <h1 class="panel-title"><?php echo translate('payment_detail');?></h1>
                                        </div>
                                        <!--List group-->
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td><b><?php echo translate('payment_status');?></b></td>
                                                    <td><?php echo translate($this->crud_model->sale_payment_status($row['sale_id'],'admin')); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('payment_method');?></b></td>
                                                    <td><?php echo ucfirst(str_replace('_', ' ', $info['payment_type'])); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b><?php echo translate('payment_date');?></b></td>
                                                    <td><?php echo date('d M, Y',$row['sale_datetime'] );?></td>
                                                </tr>
                                            </tbody>
                                        </table>    
                                    </div>
                                </div>
                           </div>
                        </div>
                    </div>
                </div>
				
				
				<?php
				
				if(count($adminpay)>0)
				{
					?>
					<div id="req_vendor" class="tab-pane fade">
					<?php echo form_open(base_url().'index.php/admin/sales/'); ?>
					<table width="100%">
					<tr>
					<th>User Name</th><td><?php echo $adminpay->user_name; ?>
					</td>
					</tr>
					<tr>
					<th>User Paypal Email(*)</th>
					<td><?php echo $adminpay->user_paypal_email; ?></td>
					</tr>
					
					<tr>
					<th>Total Payment</th>
					<td><?php echo currency().$this->cart->format_number($adminpay->total_payment); ?></td>
					</tr>
					<tr>
					<th>Adjust Amount</th>
					<td><?php echo currency().$this->cart->format_number($adminpay->adjust_amount); ?></td>
					</tr>
					<tr>
					<th>Advance Payment (20%)</th>
					<td><?php echo currency().$this->cart->format_number($adminpay->advance_payment); ?></td>
					</tr>
					<tr>
					<th>First Request Payment</th>
					<td><?php echo currency().$this->cart->format_number($adminpay->first_payment); ?></td>
					</tr>
					<tr>
					<th>Remaining Payment </th>
					<td><?php echo currency().$this->cart->format_number($adminpay->remaining_payment); ?></td>
					</tr>
					<tr>
					<th>Request For Payment(in $)(*)</th>
					<td>
					<input type="text"  name="req_amount" value="" class="form-control reqfield payable_amount">
					</td>
					</tr>
					<tr>
					<th>Status</th>
					<td>
					<?php echo $adminpay->request_payment_status; ?>
					</td>
					</tr>
					<tr>
					<th>&nbsp;</th>
					<td>
					<input type="hidden" name="remaining_payment" class="remaining_paymentu" value="<?php echo $adminpay->remaining_payment; ?>" />
					<input type="hidden" name="upaymentid" value="<?php echo $adminpay->id; ?>" />
					<input type="hidden" name="sub_action_req" value="yes" />
					<input type="button" onclick="requiredField('req_vendor','payable_amount');" name="sub_action_req1" class="print_btn" value="Go"></td>
					</tr>
					<tr><td colspan="2"><span class="reqerror" style="color:red;"></span></td><tr>
					</table>
					<?php echo form_close(); ?>
					</div>
					
				<div id="adjust_payment" class="tab-pane fade">
				<?php echo form_open(base_url().'index.php/admin/sales/'); ?>
				<table width="100%">
				
				<tr>
				<th>Total Payment</th>
				<td><?php echo currency().$this->cart->format_number($adminpay->total_payment); ?></td>
				</tr>
				<tr>
				<th>Advance Payment (20%)</th>
				<td><?php echo currency().$this->cart->format_number($adminpay->advance_payment); ?></td>
				</tr>
				<tr>
				<th>Adjust Amount(*)</th>
				<td><input type="text"   name="adjust_amount_value" value="<?php echo $adminpay->adjust_amount; ?>" class="form-control reqfield payable_amount"   ></td>
				</tr>
				<tr>
					<th>Status</th>
					<td>
					<?php echo $adminpay->adjust_amount_status; ?>
					</td>
					</tr>		
				<tr>
				<th>&nbsp;</th>
				<td>
				
				<input type="hidden" name="upaymentid" value="<?php echo $adminpay->id; ?>" />
				<input type="hidden" name="sub_action_adjust" value="yes" />
				<input type="button" onclick="requiredField('adjust_payment','payable_amount');" name="sub_action_adjust1" class="print_btn" value="Go"></td>
				</tr>
				<tr><td colspan="2"><span class="reqerror" style="color:red;"></span></td><tr>
				</table>
				<?php echo form_close(); ?>
				</div>
					
					<?php
				}
			else
			{
				?>
				<div id="req_vendor" class="tab-pane fade">
				No Record.
				</div>
				<div id="adjust_payment" class="tab-pane fade">
					No Record.
				</div>
				<?php
			}
				
				?>
			<div id="vendor_payment" class="tab-pane fade">
		    <?php
			$i=1;
			foreach ($payment_status as $dev) {
			if(isset($dev['vendor'])){  ?>
			
			<?php echo form_open("admin/sales/vendor_pay/".$dev['vendor'],array('id'=>'vendor'.$i)); 
			$vendor = $this->crud_model->getsiglefield('vendor','vendor_id',$dev['vendor']);
			$horseinfo = $this->crud_model->getdublefield('vendor_payment','vendor_id',$dev['vendor'],'sale_id',$sale_id);
			
			$horsegender = $this->db->query("SELECT * FROM gender WHERE gender_id IN (SELECT gender FROM product where product_id='$horseinfo->product_id') ")->row();
			
			$gender = '';
			if($horsegender->gender_group =='male')
			{
				$gender = 'STALLION';
			}
			else if($horsegender->gender_group =='female')
			{
				$gender = 'MARE';
			}
			?>
			<table width="100%">
			<tr><td colspan="2"><h4><?php echo $gender; ?> OWNER</h4></td></tr>
			<tr><th><input type="hidden" value="<?php echo $horseinfo->vendor_payment_id; ?>" name="vendor_payment_id" />
			Vendor Name: </th><td><?php echo $vendor->username; ?></td></tr>
			<tr><th>Vendor Paypal Email(*): </th><td><input class="reqfield"  type="text" value="<?php echo $vendor->paypal_email; ?>" name="email" ></td></tr>
			<tr><th>Vendor Total Amount: </th><td><?php echo currency().$this->cart->format_number($horseinfo->amount); ?></td></tr>
			<tr><th>Payed Amount: </th><td><?php echo currency().$this->cart->format_number($horseinfo->payed_amount); ?></td></tr>
			<tr><th>Remaining Amount: </th><td><?php echo currency().$this->cart->format_number(($horseinfo->amount-$horseinfo->payed_amount)); ?>
			<input type="hidden" name="remaining_payment" class="remaining_payment" value="<?php echo ($horseinfo->amount-$horseinfo->payed_amount); ?>" />
			</td></tr>
			<tr>
			<tr><th>Vendor Payable Amount(*): </th><td><input type="text" value="" class="reqfield payable_amount" name="payable_amount" /></td></tr>
			<tr><td colspan="2"><span class="reqerror" style="color:red;"></span></td><tr>
			<tr>
				<th>&nbsp;</th>
				<td>
				<input type="hidden" name="sub_action_vendor" value="yes" />
				<input type="button" onclick="requiredVField('vendor_payment','vendor<?php echo $i; ?>','payable_amount');" name="sub_action_vendor1" class="print_btn" value="Pay"></td>
				</tr>
			
			</table>
			<?php echo form_close(); ?>
			<br />
			<hr />
			<?php } 
			$i++;
			} ?>
			</div>			
				
				
				
				
				
            </div>
            <!--<div class="row" style="height:300px;" id="mapa"></div>--->
        </div>
        <div class="col-md-2"></div>
    </div>
    <div class="col-md-12">
        <div class="col-md-9"></div>
        <div class="col-md-3 print_btn">
            <span class="btn btn-success btn-md btn-labeled fa fa-reply margin-top-10"
                onclick="print()" >
                    <?php echo translate('print');?>
            </span>
        </div>
    </div>
</div>
<!--End Invoice Footer-->

 <!--       
<script>
	$.getScript("http://maps.google.com/maps/api/js?v=3.exp&signed_in=true&callback=MapApiLoaded", function () {});
	function MapApiLoaded() {
		var map;
		function initialize() {
		  var mapOptions = {
			zoom: 16,
			center: {lat: <?php echo $position[0]; ?>, lng: <?php echo $position[1]; ?>}
		  };
		  map = new google.maps.Map(document.getElementById('mapa'),
			  mapOptions);
	
		  var marker = new google.maps.Marker({
			position: {lat: <?php echo $position[0]; ?>, lng: <?php echo $position[1]; ?>},
			map: map
		  });
	
		  var infowindow = new google.maps.InfoWindow({
			content: '<p><?php echo translate('marker_location'); ?>:</p><p><?php echo $info['address1']; ?> </p><p><?php echo $info['address2']; ?> </p><p><?php echo translate('city'); ?>: <?php echo $info['city']; ?> </p><p><?php echo translate('ZIP'); ?>: <?php echo $info['zip']; ?> </p>'
		  });
		  google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map, marker);
		  });
		}
		initialize();
	}
</script>
-->
<?php
	}
?>
<style>
@media print {
	.print_btn{
		display:none;	
	}
    #navbar-container{
        display: none;
    }
    #page-title{
        display: none;
    }
    .print{
        width: 100%;
    }
    .col-md-6{
        width: 50%;
        float: left;
    }
}
#req_vendor th {
    padding: 10px 0px;
    width: 40%;
}
#req_vendor td {
    padding: 10px;
	width: 58%;
}
#adjust_payment td {
    padding: 10px;
	width: 58%;
}
#adjust_payment th {
    padding: 10px 0px;
    width: 40%;
}
#vendor_payment th {
    padding: 10px 0px;
    width: 40%;
}
#vendor_payment td {
    padding: 10px;
	width: 58%;
}
</style>
<script>
function requiredField(arg,cls)
{
   var clname = '#'+arg+' .reqfield';
   var fillamount = '#'+arg+' .'+cls;
   var icount = '';
   var rpayment = jQuery('.remaining_paymentu').val();
   jQuery(clname).each(function(){
	   if(jQuery(this).val()=='')
	   {
		   icount = 1;
	   }
   });
   if(icount <1)
   { 
	 var fa = jQuery(fillamount).val();	  
	  if(parseInt(rpayment) > parseInt(fa))
	   {
		   jQuery('#'+arg+' form').submit();
	   }
		else
		{
			jQuery('#'+arg+' .reqerror').html('You have entered more then amount of remaining amount.');
		}
   }
   else
   {
	   jQuery('#'+arg+' .reqerror').html('(*) fiels are required!');
   }
}

function requiredVField(divId,formId,fieldname)
{
	var clname = '#'+divId+' #'+formId+' .reqfield';
   var icount = '';
   var fillamount = '#'+divId+' #'+formId+' .'+fieldname;
   var rpayment = jQuery('#'+formId+' .remaining_payment').val();
   jQuery(clname).each(function(){
	   if(jQuery(this).val()=='')
	   {
		   icount = 1;
	   }
   });
   if(icount <1)
   {
		var fa = jQuery(fillamount).val();
		
	  if(parseInt(rpayment) > parseInt(fa))
	   {
			jQuery('#'+divId+' #'+formId).submit();
	   }
		else
		{
			jQuery('#'+divId+' #'+formId+' .reqerror').html('You have entered more then amount of remaining amount.');
		}
		
   }
   else
   {
	   jQuery('#'+divId+' #'+formId+' .reqerror').html('(*) fiels are required!');
   }
}

</script>