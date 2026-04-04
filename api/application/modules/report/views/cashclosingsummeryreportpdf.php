
<?php 
$startDate = date("d/m/Y", strtotime($registerinfo->opendate));
$closeDate = date("d/m/Y", strtotime($registerinfo->closedate));
$totalsales=$billinfo->nitamount+$billinfo->VAT+$billinfo->service_charge;
?>
    <div style="" id="pdfprnt">
        <table align="center" style="width:270px; padding:0 5px;">
            <thead>
                <tr>
                    <th colspan="3" style="font-size: 21px; color: #000; padding-bottom: 15px; text-align: center; "><?php echo display('day_close_report');?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-size: 17px; color: #000; text-align: left;"><?php echo display('open_date');?> :</td>
                    <td style="font-size: 17px; color: #000; text-align: right;"><?php echo $startDate;?></td>
                </tr>
                <tr>
                    <td style="font-size: 17px; color: #000; text-align: left;"><?php echo display('close_date');?> :</td>
                    <td style="font-size: 17px; color: #000; text-align: right;"><?php echo $closeDate;?></td>
                </tr>
                <tr>
                    <td style="font-size: 17px; color: #000; text-align: left;"><?php echo display('counter_no');?> :</td>
                    <td style="font-size: 17px; color: #000; text-align: right;"><?php echo $registerinfo->counter_no;?></td>
                </tr>
                <tr>
                    <td style="font-size: 17px; color: #000; text-align: left; border-bottom: 1px solid #000; border-bottom-style: dashed;"><?php echo display('user');?> :</td>
                    <td style="font-size: 17px; color: #000; text-align: right; border-bottom: 1px solid #000; border-bottom-style: dashed;"><?php echo $this->session->userdata('fullname');?></td>
                </tr>
            </tbody>
        </table>

        <table align="center" style="width:270px; padding:0 5px;">
            <thead>
                <tr>
                    <th colspan="3" style="font-size: 21px; color: #000; padding-bottom: 5px; text-align: center;"><?php echo display('sales_summary');?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2" style="font-size: 17px; color: #000; text-align: left; border-top: 1px solid #000; border-top-style: dashed;"><?php echo display('total_net_sales');?> :</td>
                    <td style="font-size: 17px; color: #000; text-align: right; border-top: 1px solid #000; border-top-style: dashed;"><?php echo number_format($billinfo->nitamount ?? 0,2);?></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size: 17px; color: #000; text-align: left;"><?php echo display('total_tax');?> :</td>
                    <td style="font-size: 17px; color: #000; text-align: right;"><?php echo number_format($billinfo->VAT ?? 0,2);?></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size: 17px; color: #000; text-align: left; border-bottom: 1px solid #000; border-bottom-style: dashed;"><?php echo display('total_sd');?> :</td>
                    <td style="font-size: 17px; color: #000; text-align: right; border-bottom: 1px solid #000; border-bottom-style: dashed;"><?php echo number_format($billinfo->service_charge ?? 0,2);?></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size: 17px; color: #000; text-align: left;"><?php echo display('total_sale');?> :</td>
                    <td style="font-size: 17px; color: #000; text-align: right;"><?php echo number_format($totalsales ?? 0,2);?></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size: 17px; color: #000; text-align: left;"><?php echo display('total_discount');?> :</td>
                    <td style="font-size: 17px; color: #000; text-align: right;"><?php echo number_format($billinfo->discount ?? 0,2);?></td>
                </tr>
            </tbody>
        </table>
		
        <table align="center" style="width:270px; padding:0 5px;">
            <thead>
                <tr>
                    <th colspan="3" style="font-size: 21px; color: #000; padding-bottom: 5px; text-align: center; "><?php echo display('payment_details');?></th>
                </tr>
            </thead>
            <tbody>
            <?php  
			$tototalsum= array_sum(array_column($totalamount, 'totalamount'));
			$changeamount=$tototalsum-$totalchange->totalexchange;
			$total=0;
			foreach ($totalamount as $amount) {
				if($amount->payment_type_id==4){
					$payamount=$amount->totalamount-$changeamount;
				}else{
					$payamount=$amount->totalamount;
				}
				$total=$total+$payamount;
				if($payamount > 0){
                ?>
                <tr>
                    <td colspan="2" style="font-size: 17px; color: #000; text-align: left; border-top: 1px solid #000; border-top-style: dashed;"><?php echo $amount->payment_method; ?> :</td>
                    <td style="font-size: 17px; color: #000; text-align: right; border-top: 1px solid #000; border-top-style: dashed;"><?php echo number_format($payamount ?? 0,3); ?></td>
                </tr>
                <?php } } ?>
                <tr>
                    <td colspan="3" style="font-size: 17px; color: #000; text-align: left; border-bottom: 1px solid #000; border-bottom-style: dashed;">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size: 17px; color: #000; text-align: left;"><?php echo display('totalpayment');?> :</td>
                    <td style="font-size: 17px; color: #000; text-align: right;"><?php echo number_format($total ?? 0,3); ?></td>
                </tr>
            </tbody>
        </table>
        <table align="center" style="width:270px; padding:0 5px; margin-bottom: 60px;">
            <thead>
                <tr>
                    <th colspan="3" style="font-size: 21px; color: #000; padding-bottom: 5px; text-align: center;"><?php echo display('cashdrawer');?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2" style="font-size: 17px; color: #000; text-align: left; border-top: 1px solid #000; border-top-style: dashed;"><?php echo display('day_opening');?> :</td>
                    <td style="font-size: 17px; color: #000; text-align: right; border-top: 1px solid #000; border-top-style: dashed;"><?php echo number_format($registerinfo->opening_balance ?? 0,3); ?></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size: 17px; color: #000; text-align: left; border-bottom: 1px solid #000; border-bottom-style: dashed;"><?php echo display('dayclosing');?> :</td>
                    <td style="font-size: 17px; color: #000; text-align: right; border-bottom: 1px solid #000; border-bottom-style: dashed;"><?php echo number_format($registerinfo->closing_balance ?? 0,3); ?></td>
                </tr>
                <tr>
                    <td colspan="3" style="font-size: 17px; color: #000;">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3" style="font-size: 17px; color: #000; text-align: left;">Print Date :<?php echo date('Y-m-d H:i'); ?></td>
                </tr>
            </tbody>
        </table>

        <table align="center" style="width:270px; padding:0 5px;">
            <tbody>
                <tr>
                    <td style="font-size: 17px; color: #000; text-align: left;"></td>
                    <td style="font-size: 17px; color: #000; text-align: right;"></td>
                </tr>
                <tr>
                    <td style="font-size: 17px; color: #000; text-align: left; border-top: 1px solid #000;"><?php echo display('counterusersignature');?></td>
                    <td style="font-size: 17px; color: #000; text-align: right; border-top: 1px solid #000;"><?php echo display('authorize_signature');?></td>
                </tr>
            </tbody>
        </table>
    </div>

<script src="<?php echo base_url('application/modules/report/assets/js/html2canvas.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('application/modules/report/assets/js/jspdf.min.js'); ?>" type="text/javascript"></script>

<script>
function ConvertHTMLToPDF() {
    const elementHTML = document.getElementById('pdfprnt');

    // Use html2canvas to render the HTML element
    html2canvas(elementHTML, {
        useCORS: true, // Ensures cross-origin resources are loaded
        scale: 2       // Improves resolution for better quality
    }).then(canvas => {
        const pdf = new jspdf.jsPDF('p', 'pt', 'a4'); // A4 paper size

        const imgData = canvas.toDataURL('image/png');
        const imgWidth = 595.28; // A4 width in points
        const pageHeight = 841.89; // A4 height in points
        const imgHeight = canvas.height * imgWidth / canvas.width;
        let heightLeft = imgHeight;

        let position = 0;

        // Add the image to the PDF
        pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
        heightLeft -= pageHeight;

        // Add additional pages if content overflows
        while (heightLeft > 0) {
            position = heightLeft - imgHeight;
            pdf.addPage();
            pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;
        }

        // Save the PDF
        pdf.save('cashregister.pdf');
    }).catch(error => {
        console.error("Error generating PDF:", error);
    });
}
</script>