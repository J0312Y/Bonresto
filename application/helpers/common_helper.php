<?php

if (!function_exists('http_post'))
{

    function http_post($url, $data)
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, count($data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $output = curl_exec($ch);

        curl_close($ch);
        return $output;
    }

}

if (!function_exists('RandomPassword'))
{
function RandomPassword(){
		$chars = "abcdefghijkmnopqrstuvwxyz023456789";
		srand((double)microtime()*1000000);
		$i = 0;
		$pass = '' ;
		while($i <= 7){
			$num = rand() % 33;
			$tmp = substr($chars, $num, 1);
			$pass = $pass.$tmp;
			$i++;
		}
		return $pass;
	}
}
if (!function_exists('time_elapsed'))
{
    function time_elapsed($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        // calculate weeks manually
        $weeks = floor($diff->d / 7);
        $days  = $diff->d - ($weeks * 7);

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );

        $result = [];

        foreach ($string as $k => $v) {
            $value = 0;

            if ($k == 'w' && $weeks) {
                $value = $weeks;
            } elseif ($k == 'd' && $days) {
                $value = $days;
            } elseif ($k != 'w' && $k != 'd' && $diff->$k) {
                $value = $diff->$k;
            }

            if ($value) {
                $result[] = $value . ' ' . $v . ($value > 1 ? 's' : '');
            }
        }

        if (!$full) {
            $result = array_slice($result, 0, 1);
        }

        return $result ? implode(', ', $result) . ' ago' : 'just now';
    }
}
if (!function_exists('SubscribeEmail'))
{
	function SubscribeEmail($email){
	   
$emailcontent='<!doctype html>
<html>
  <head>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Subscription/Contact</title>
    <style>
    @media only screen and (max-width: 620px) {
      table[class=body] h1 {
        font-size: 28px !important;
        margin-bottom: 10px !important;
      }
      table[class=body] p,
            table[class=body] ul,
            table[class=body] ol,
            table[class=body] td,
            table[class=body] span,
            table[class=body] a {
        font-size: 16px !important;
      }
      table[class=body] .wrapper,
            table[class=body] .article {
        padding: 10px !important;
      }
      table[class=body] .content {
        padding: 0 !important;
      }
      table[class=body] .container {
        padding: 0 !important;
        width: 100% !important;
      }
      table[class=body] .main {
        border-left-width: 0 !important;
        border-radius: 0 !important;
        border-right-width: 0 !important;
      }
      table[class=body] .btn table {
        width: 100% !important;
      }
      table[class=body] .btn a {
        width: 100% !important;
      }
      table[class=body] .img-responsive {
        height: auto !important;
        max-width: 100% !important;
        width: auto !important;
      }
    }

    @media all {
      .ExternalClass {
        width: 100%;
      }
      .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
        line-height: 100%;
      }
      .apple-link a {
        color: inherit !important;
        font-family: inherit !important;
        font-size: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
        text-decoration: none !important;
      }
      .btn-primary table td:hover {
        background-color: #34495e !important;
      }
      .btn-primary a:hover {
        background-color: #34495e !important;
        border-color: #34495e !important;
      }
    }
    </style>
  </head>
  <body class="" style="background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
    <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;">
      <tr>
        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
        <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;">
          <div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">

            <!-- START CENTERED WHITE CONTAINER -->
            <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">This is preheader text. Some clients will show this text as a preview.</span>
            <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;">

              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                    <tr>
                      <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Salut '.$email.',</p>
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Thanks for your subscription</p>
                        <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
                          <tbody>
                            
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>

            <!-- END MAIN CONTENT AREA -->
            </table>

            <!-- START FOOTER -->
            
            <!-- END FOOTER -->

          <!-- END CENTERED WHITE CONTAINER -->
          </div>
        </td>
        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
      </tr>
    </table>
  </body>
</html>';
	   
	return $emailcontent;
	}
}

// ── Shared email layout wrapper ──────────────────────────────────────
if (!function_exists('_reservationEmailLayout'))
{
    function _reservationEmailLayout($bodyContent) {
        $ci =& get_instance();
        $setting = $ci->db->select('storename, phone, address, logo')->from('setting')->limit(1)->get()->row();
        $storeName = $setting ? $setting->storename : 'Notre Restaurant';
        $storePhone = $setting ? $setting->phone : '';
        $storeAddress = $setting ? $setting->address : '';
        $logoUrl = ($setting && $setting->logo) ? base_url($setting->logo) : '';

        $logoHtml = '';
        if ($logoUrl) {
            $logoHtml = '<img src="'.$logoUrl.'" alt="'.htmlspecialchars($storeName).'" style="max-width:160px;max-height:60px;margin-bottom:10px;">';
        }

return '<!doctype html>
<html>
<head>
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!--[if mso]><noscript><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml></noscript><![endif]-->
  <style>
    @media only screen and (max-width:620px){
      .container{width:100% !important;padding:8px !important;}
      .main{border-radius:0 !important;}
      .wrapper{padding:16px !important;}
      .info-table td{display:block !important;width:100% !important;padding:6px 0 !important;}
    }
  </style>
</head>
<body style="margin:0;padding:0;background-color:#f0f2f5;font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;-webkit-font-smoothing:antialiased;line-height:1.5;">
  <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#f0f2f5;">
    <tr>
      <td align="center" style="padding:30px 10px;">
        <table role="presentation" class="container" border="0" cellpadding="0" cellspacing="0" width="580" style="max-width:580px;width:100%;">

          <!-- HEADER -->
          <tr>
            <td align="center" style="padding:24px 30px 18px;background:linear-gradient(135deg,#1a1a2e 0%,#16213e 100%);border-radius:12px 12px 0 0;">
              '.$logoHtml.'
              <p style="margin:0;font-size:20px;font-weight:700;color:#ffffff;letter-spacing:0.5px;">'.htmlspecialchars($storeName).'</p>
            </td>
          </tr>

          <!-- BODY -->
          <tr>
            <td class="main" style="background:#ffffff;padding:0;border-radius:0 0 12px 12px;box-shadow:0 2px 16px rgba(0,0,0,0.07);">
              <table role="presentation" class="wrapper" border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:32px 38px;">
                <tr>
                  <td>'.$bodyContent.'</td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- FOOTER -->
          <tr>
            <td align="center" style="padding:24px 30px 10px;">
              <p style="margin:0 0 4px;font-size:13px;color:#777;font-weight:600;">'.htmlspecialchars($storeName).'</p>
              '.($storeAddress ? '<p style="margin:0 0 4px;font-size:12px;color:#999;">'.htmlspecialchars($storeAddress).'</p>' : '').'
              '.($storePhone ? '<p style="margin:0 0 4px;font-size:12px;color:#999;">Tel : '.htmlspecialchars($storePhone).'</p>' : '').'
              <hr style="border:none;border-top:1px solid #e0e0e0;margin:12px 0;">
              <p style="margin:0;font-size:11px;color:#bbb;">Cet e-mail a ete envoye automatiquement. Merci de ne pas y repondre.</p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>';
    }
}

// ── Detail info row helper ──────────────────────────────────────────
if (!function_exists('_reservationInfoTable'))
{
    function _reservationInfoTable($rows) {
        $html = '<table role="presentation" class="info-table" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin:20px 0;border-collapse:collapse;border:1px solid #f0f0f0;border-radius:8px;">';
        $i = 0;
        $total = count($rows);
        foreach ($rows as $pair) {
            $i++;
            $label = $pair[0];
            $value = $pair[1];
            $borderBottom = ($i < $total) ? 'border-bottom:1px solid #f0f0f0;' : '';
            $html .= '<tr>
                <td style="padding:12px 16px;'.$borderBottom.'width:40%;vertical-align:middle;background:#fafafa;">
                    <span style="font-size:13px;color:#888;font-weight:500;">'.$label.'</span>
                </td>
                <td style="padding:12px 16px;'.$borderBottom.'vertical-align:middle;">
                    <span style="font-size:14px;color:#333;font-weight:600;">'.$value.'</span>
                </td>
            </tr>';
        }
        $html .= '</table>';
        return $html;
    }
}

// ── 1. Reservation received (pending) ───────────────────────────────
if (!function_exists('ReservationEmail'))
{
    function ReservationEmail($id, $mobile = null) {
        $ci =& get_instance();
        $reserveinfo = $ci->db->select('*')->from('tblreservation')->where('reserveid', $id)->get()->row();
        $resinfo = $ci->db->select('*')->from('customer_info')->where('customer_id', $reserveinfo->cid)->get()->row();
        $tableinfo = $ci->db->select('tablename')->from('rest_table')->where('tableid', $reserveinfo->tableid)->get()->row();
        $dateFormatted = date('d/m/Y', strtotime($reserveinfo->reserveday));

        $body = '
        <p style="margin:0 0 22px;font-size:15px;color:#333;">Bonjour <strong>'.htmlspecialchars($resinfo->customer_name).'</strong>,</p>

        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:24px;">
          <tr>
            <td style="background:linear-gradient(135deg,#fff8e1 0%,#fff3cd 100%);border-left:4px solid #ffa726;border-radius:0 8px 8px 0;padding:18px 22px;">
              <p style="margin:0;font-size:16px;font-weight:700;color:#e65100;">&#9203; En attente de confirmation</p>
              <p style="margin:8px 0 0;font-size:13px;color:#795548;line-height:1.6;">Votre demande de reservation a bien ete recue. Nous vous enverrons un e-mail de confirmation dans les plus brefs delais.</p>
            </td>
          </tr>
        </table>

        '._reservationInfoTable([
            ['Date',               $dateFormatted],
            ['Horaire',            $reserveinfo->formtime.' - '.$reserveinfo->totime],
            ['Nombre de personnes', $reserveinfo->person_capicity],
            ['Table',              $tableinfo ? $tableinfo->tablename : '-'],
            ['Telephone',          $mobile ?: ($resinfo->customer_phone ?: '-')],
        ]).'

        <p style="margin:24px 0 0;font-size:13px;color:#999;text-align:center;line-height:1.5;">
            Si vous avez des questions, n\'hesitez pas a nous contacter.
        </p>';

        return _reservationEmailLayout($body);
    }
}

// ── 2. Reservation confirmed ────────────────────────────────────────
if (!function_exists('ReservationConfirmedEmail'))
{
    function ReservationConfirmedEmail($id, $mobile = null) {
        $ci =& get_instance();
        $reserveinfo = $ci->db->select('*')->from('tblreservation')->where('reserveid', $id)->get()->row();
        $resinfo = $ci->db->select('*')->from('customer_info')->where('customer_id', $reserveinfo->cid)->get()->row();
        $tableinfo = $ci->db->select('tablename')->from('rest_table')->where('tableid', $reserveinfo->tableid)->get()->row();
        $dateFormatted = date('d/m/Y', strtotime($reserveinfo->reserveday));

        $body = '
        <p style="margin:0 0 22px;font-size:15px;color:#333;">Bonjour <strong>'.htmlspecialchars($resinfo->customer_name).'</strong>,</p>

        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:24px;">
          <tr>
            <td style="background:linear-gradient(135deg,#e8f5e9 0%,#c8e6c9 100%);border-left:4px solid #43a047;border-radius:0 8px 8px 0;padding:18px 22px;">
              <p style="margin:0;font-size:16px;font-weight:700;color:#2e7d32;">&#10003; Reservation confirmee</p>
              <p style="margin:8px 0 0;font-size:13px;color:#555;line-height:1.6;">Nous avons le plaisir de vous confirmer votre reservation. Nous vous attendons avec impatience !</p>
            </td>
          </tr>
        </table>

        '._reservationInfoTable([
            ['Date',               $dateFormatted],
            ['Horaire',            $reserveinfo->formtime.' - '.$reserveinfo->totime],
            ['Nombre de personnes', $reserveinfo->person_capicity],
            ['Table',              $tableinfo ? $tableinfo->tablename : '-'],
            ['Telephone',          $mobile ?: ($resinfo->customer_phone ?: '-')],
        ]).'

        <p style="margin:24px 0 0;font-size:13px;color:#999;text-align:center;line-height:1.5;">
            En cas d\'empechement, merci de nous prevenir le plus tot possible.
        </p>';

        return _reservationEmailLayout($body);
    }
}

// ── 3. Reservation modified ─────────────────────────────────────────
if (!function_exists('ReservationModifiedEmail'))
{
    function ReservationModifiedEmail($id, $changes = []) {
        $ci =& get_instance();
        $reserveinfo = $ci->db->select('*')->from('tblreservation')->where('reserveid', (int)$id)->get()->row();
        $resinfo = $ci->db->select('*')->from('customer_info')->where('customer_id', $reserveinfo->cid)->get()->row();
        $tableinfo = $ci->db->select('tablename')->from('rest_table')->where('tableid', $reserveinfo->tableid)->get()->row();
        $dateFormatted = date('d/m/Y', strtotime($reserveinfo->reserveday));

        $changesHtml = '';
        if (!empty($changes)) {
            $changesHtml = '<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin:0 0 20px;border-collapse:collapse;">';
            foreach ($changes as $c) {
                $changesHtml .= '<tr><td style="padding:9px 14px;border-bottom:1px solid #f5f5f5;font-size:13px;color:#555;">&#8594; '.htmlspecialchars($c).'</td></tr>';
            }
            $changesHtml .= '</table>';
        }

        $body = '
        <p style="margin:0 0 22px;font-size:15px;color:#333;">Bonjour <strong>'.htmlspecialchars($resinfo->customer_name).'</strong>,</p>

        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:24px;">
          <tr>
            <td style="background:linear-gradient(135deg,#fff3e0 0%,#ffe0b2 100%);border-left:4px solid #fb8c00;border-radius:0 8px 8px 0;padding:18px 22px;">
              <p style="margin:0;font-size:16px;font-weight:700;color:#e65100;">&#9998; Reservation modifiee</p>
              <p style="margin:8px 0 0;font-size:13px;color:#795548;line-height:1.6;">Votre reservation a ete mise a jour. Veuillez trouver ci-dessous les modifications apportees.</p>
            </td>
          </tr>
        </table>

        <p style="margin:0 0 10px;font-size:12px;font-weight:700;color:#888;text-transform:uppercase;letter-spacing:1px;">Ce qui a change</p>
        '.$changesHtml.'

        <p style="margin:0 0 10px;font-size:12px;font-weight:700;color:#888;text-transform:uppercase;letter-spacing:1px;">Nouvelles informations</p>
        '._reservationInfoTable([
            ['Date',               $dateFormatted],
            ['Horaire',            $reserveinfo->formtime.' - '.$reserveinfo->totime],
            ['Nombre de personnes', $reserveinfo->person_capicity],
            ['Table',              $tableinfo ? $tableinfo->tablename : '-'],
        ]).'

        <p style="margin:24px 0 0;font-size:13px;color:#999;text-align:center;line-height:1.5;">
            Si vous avez des questions, n\'hesitez pas a nous contacter.
        </p>';

        return _reservationEmailLayout($body);
    }
}

if (!function_exists('SendorderEmail'))
{
	function SendorderEmail($orderid,$customerid){
	   $ci =& get_instance();
	   $ordersql = $ci->db->query("SELECT * FROM customer_order where order_id='".$orderid."'");	
	   $orderinfo= $ordersql->row();
       $rowdt = $ci->db->query("SELECT order_menu.*,item_foods.ProductsID,item_foods.ProductName,item_foods.ProductImage,variant.variantid,variant.variantName,variant.price FROM order_menu Left Join item_foods ON order_menu.menu_id=item_foods.ProductsID Left Join variant ON order_menu.varientid=variant.variantid where order_menu.order_id='".$orderid."'");	
	   $oredritem= $rowdt->result();
	   $resql = $ci->db->query("SELECT * FROM customer_info where customer_id='".$customerid."'");	
	   $resinfo= $resql->row();
	   $bill = $ci->db->query("SELECT * FROM bill where order_id='".$orderid."'");	
	   $billinfo= $bill->row();
	   $items='';
	   $subtotal=0;
	   foreach($oredritem as $item){
		   $getitemin= $ci->db->query("SELECT item_foods.ProductsID,item_foods.ProductName,variant.variantid,variant.variantName,variant.price FROM item_foods Left Join variant ON item_foods.ProductsID=variant.menuid where item_foods.ProductsID='".$item->menu_id."' AND variant.variantid='".$item->varientid."'");
		   $itemininfo= $getitemin->row();	
		   if(!empty($item->add_on_id)){
			   
			   $addons=explode(",",$item->add_on_id);
			   $addonsqtym=explode(",",$item->addonsqty);
			     $x=0;
				 $addonsname='';
				 $addonsprice='';
				 $addonsqty='';
				 $adstotalprice='';
				 foreach($addons as $addonsid){
					  $getaddons = $ci->db->query("SELECT * FROM add_ons where add_on_id='".$addonsid."'");	
	                  $adonsinfo= $getaddons->row();
					  $addonsname.=$adonsinfo->add_on_name.',';
					  $addonsprice.=$adonsinfo->price.',';
					  $addonsqty.=$addonsqtym[$x].',';
					  $adstotalprice=$adonsinfo->price*$addonsqtym[$x];
					  $x++;
				 }
				  $addonsname=trim($addonsname,',');
				  $addonsprice=trim($addonsprice,',');
				  $addonsqty=trim($addonsqty,',');
				  $isaddons='Addons:'.$addonsname.' - price:'.$adstotalprice;
				  $totalp=($item->menuqty*$itemininfo->price)+$adstotalprice;
			   }
			else{
				$isaddons="";
				$adstotalprice="";
				$totalp=$item->menuqty*$itemininfo->price;
				}
	   $subtotal=$subtotal+$totalp;
	   $items.='<tr><td>'.$itemininfo->ProductName.' '.$isaddons.'</td><td>'.$itemininfo->variantName.'</td><td>'.$item->menuqty.'</td><td>'.$itemininfo->price.'</td><td>'.$totalp.'</td></tr>';
	   }
	   
$emailcontent='<!doctype html>
<html>
  <head>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Subscription/Contact</title>
    <style>
    @media only screen and (max-width: 620px) {
      table[class=body] h1 {
        font-size: 28px !important;
        margin-bottom: 10px !important;
      }
      table[class=body] p,
            table[class=body] ul,
            table[class=body] ol,
            table[class=body] td,
            table[class=body] span,
            table[class=body] a {
        font-size: 16px !important;
      }
      table[class=body] .wrapper,
            table[class=body] .article {
        padding: 10px !important;
      }
      table[class=body] .content {
        padding: 0 !important;
      }
      table[class=body] .container {
        padding: 0 !important;
        width: 100% !important;
      }
      table[class=body] .main {
        border-left-width: 0 !important;
        border-radius: 0 !important;
        border-right-width: 0 !important;
      }
      table[class=body] .btn table {
        width: 100% !important;
      }
      table[class=body] .btn a {
        width: 100% !important;
      }
      table[class=body] .img-responsive {
        height: auto !important;
        max-width: 100% !important;
        width: auto !important;
      }
    }

    @media all {
      .ExternalClass {
        width: 100%;
      }
      .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
        line-height: 100%;
      }
      .apple-link a {
        color: inherit !important;
        font-family: inherit !important;
        font-size: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
        text-decoration: none !important;
      }
      .btn-primary table td:hover {
        background-color: #34495e !important;
      }
      .btn-primary a:hover {
        background-color: #34495e !important;
        border-color: #34495e !important;
      }
    }
    </style>
  </head>
  <body class="" style="background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
    <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;">
      <tr>
        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
        <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;">
          <div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">

            <!-- START CENTERED WHITE CONTAINER -->
            <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">This is preheader text. Some clients will show this text as a preview.</span>
            <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;">

              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                    <tr>
                      <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Salut '.$resinfo->customer_name.',</p>
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Thanks for Order.Below Your order Item information.</p>
                        <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
                          <tbody>
                            <tr>
								<td>Item Name</td>
								<td>Varient</td>
								<td>quantity</td>
								<td align="right">Unit Price</td>
								<td align="right">Total Price</td>
							</tr>
							'.$items.'
							<tr>
								<td colspan="4" align="right">Subtotal</td>
								<td align="right">'.$subtotal.'</td>
							</tr>
                             <tr>
								<td colspan="4" align="right">Vat/Tax</td>
								<td align="right">'.$billinfo->VAT.'</td>
							</tr>
                            <tr>
								<td colspan="4" align="right">Discount</td>
								<td align="right">'.$billinfo->discount.'</td>
							</tr>
                            <tr>
								<td colspan="4" align="right">Service charge</td>
								<td align="right">'.$billinfo->service_charge.'</td>
							</tr>
                            <tr>
								<td colspan="4" align="right">Grand Total</td>
								<td align="right">'.$orderinfo->totalamount.'</td>
							</tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>

            <!-- END MAIN CONTENT AREA -->
            </table>

            <!-- START FOOTER -->
            
            <!-- END FOOTER -->

          <!-- END CENTERED WHITE CONTAINER -->
          </div>
        </td>
        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
      </tr>
    </table>
  </body>
</html>';
	   
	return $emailcontent;
	}
}
if (!function_exists('SendSMS'))
{

    function SendSMS($Phone, $SMS)
    {
				// Login Info
				
    }

}
if (!function_exists('generateRandomStr'))
{
function generateRandomStr($length = 4) {
        $UpperStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $LowerStr = "abcdefghijklmnopqrstuvwxyz";
        $numbers = "0123456789";
        
        $characters = $numbers;
        $charactersLength = strlen($characters);
        $randomStr = null;
        for ($i = 0; $i < $length; $i++) {
            $randomStr .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomStr;
    }
}

/**
 * Audit F-22 — verification d'une cle de tache planifiee.
 *
 * Trois defauts corriges par rapport aux tests disperses qu'elle remplace :
 *
 *   1. la cle voyageait dans la chaine de requete, donc atterrissait dans les
 *      journaux d'acces Apache, l'historique du shell et les en-tetes Referer.
 *      L'en-tete X-Cron-Key est desormais prefere ; le parametre reste accepte
 *      pour ne pas casser les taches deja programmees.
 *   2. la comparaison se faisait avec !==, dont le temps d'execution depend du
 *      nombre de caracteres communs. hash_equals compare a temps constant.
 *   3. une cle attendue vide laissait passer une cle vide.
 */
if (!function_exists('cle_cron_valide')) {
    function cle_cron_valide($attendue, $fournie = null)
    {
        if (empty($attendue)) {
            return false;   // pas de cle configuree : on refuse, on n'ouvre pas
        }

        if ($fournie === null) {
            $fournie = $_SERVER['HTTP_X_CRON_KEY']
                ?? ($_GET['key'] ?? '');
        }

        if (!is_string($fournie) || $fournie === '') {
            return false;
        }

        return hash_equals((string) $attendue, $fournie);
    }
}

/**
 * Audit F-24 — limitation de debit, sans schema ni dependance externe.
 *
 * Les points d'entree publics de /saas/licenses/* identifient un client par sa
 * seule client_key. Sans limite, ces cles sont enumerables : on peut essayer
 * des milliers de valeurs jusqu'a en trouver une active.
 *
 * Compteur glissant sur fichier, dans application/cache (refuse par le
 * .htaccess du repertoire). Choix assume : si le compteur ne peut pas ecrire,
 * on laisse passer plutot que d'enfermer dehors des clients legitimes.
 *
 * @return bool TRUE si l'appel est autorise, FALSE s'il depasse la limite.
 */
if (!function_exists('limite_debit')) {
    function limite_debit($cle, $max = 30, $fenetre = 60)
    {
        $dossier = APPPATH . 'cache/throttle';

        if (!is_dir($dossier) && !@mkdir($dossier, 0755, true)) {
            return true;
        }

        $fichier    = $dossier . '/' . sha1((string) $cle) . '.json';
        $maintenant = time();
        $coups      = [];

        if (is_readable($fichier)) {
            $lu = json_decode((string) @file_get_contents($fichier), true);
            if (is_array($lu)) {
                foreach ($lu as $t) {
                    if (is_numeric($t) && ($maintenant - (int) $t) < $fenetre) {
                        $coups[] = (int) $t;
                    }
                }
            }
        }

        if (count($coups) >= $max) {
            return false;
        }

        $coups[] = $maintenant;
        @file_put_contents($fichier, json_encode($coups), LOCK_EX);

        return true;
    }
}

/**
 * Audit F-05 — signature d'un payload de licence.
 *
 * Ed25519 des que LICENSE_SIGNING_KEY est configuree ; repli HMAC sinon, pour
 * ne pas interrompre un serveur pas encore migre. Le repli est trace, et une
 * licence ainsi signee ne peut plus declencher de mise a jour de code cote
 * client (voir License_manager::_apply_code_update).
 *
 * @return array{signature:string, niveau:string}
 */
if (!function_exists('signer_licence')) {
    function signer_licence(array $payload)
    {
        $corps  = json_encode($payload);
        $privee = getenv('LICENSE_SIGNING_KEY');

        if (!empty($privee) && function_exists('sodium_crypto_sign_detached')) {
            $brut = base64_decode((string) $privee, true);
            if ($brut !== false && strlen($brut) === SODIUM_CRYPTO_SIGN_SECRETKEYBYTES) {
                return [
                    'signature' => base64_encode(sodium_crypto_sign_detached($corps, $brut)),
                    'niveau'    => 'forte',
                ];
            }
        }

        log_message('error', 'signer_licence : LICENSE_SIGNING_KEY absente ou invalide, '
            . 'repli sur HMAC. Les mises a jour de code seront refusees cote client.');

        return [
            'signature' => hash_hmac('sha256', $corps, env_required('LICENSE_HMAC_SECRET')),
            'niveau'    => 'heritee',
        ];
    }
}
