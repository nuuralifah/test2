<?php
//ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
/* * * page protection ** */
// this protect the user direct access to the page,
// this should be included in every page, except /index.php (system entry)
if (!defined("_VALID_ACCESS")) { // denied direct access to the page
    header("HTTP/1.0 404 Not Found");
    exit(); // process terminated
}
/* * * end of page protection ** */

/* * * get form action ** */
if (isset($_POST['txt_action'])) {
    if (isset($_POST['txt_form_session']) && ($_POST['txt_form_session'] == $_SESSION['form_session']))
        $str_form_action = trim($_POST['txt_action']);
    else
        $str_form_action = "frm_online_new"; // form session not valid, 
} else
    $str_form_action = "frm_online_new";  // default form action

if ($str_form_action == "frm_online_new") {
    $_SESSION['form_session'] = func_rand_str(64); // form session
    $_SESSION['magic_string'] = func_rand_str(64);    // magic string for md5 purpose
    func_header("Online Donation", $sys_config['stylesheet_path'] . "jquery.loadmask.css," .
            $sys_config['stylesheet_path'] . "jquery.fancybox.css", $sys_config['javascript_path'] . "js_md5.js," .
            $sys_config['javascript_path'] . "js_trim.js," .
            $sys_config['javascript_path'] . "jquery.loadmask.min.js," .
            $sys_config['javascript_path'] . "jquery.fancybox.pack.js," .
            $sys_config['javascript_path'] . "jquery.inputmask.min.js," .
            $sys_config['javascript_path'] . "jquery.number.min.js," .
            $sys_config['javascript_path'] . "jquery.cookie.js", 1, 1, 1);

    require($sys_config['includes_path'] . "preloader.php");
    require($sys_config['includes_path'] . "main-header.php");
    require($sys_config['includes_path'] . "top-nav-bar.php");
    require($sys_config['includes_path'] . "slider-img.php");
    require($mod_config['document_root'] . "four-items.php");
    //echo $mod_config['document_root']."four-items.php";
    
    //check if pre-selected fund id is provided
    $kk_pre_selected = 0;
    $kk_pre_selected_title = '';
    $fund_arr = array(                                                                                                                                                                          'r a  m a  d a n '                                                                                                                                     =>194,
                                                                                                                                                                                                'm y s e d e k a h'                                                                                                                                     =>180,
																																																                          'q u r b a n i'                                                                                                                                                                             =>148,
                                                                                                                                                                        'l o c a l'                                                                                                                                                                             =>179,
                                                                                                                                                                'i n t e r n a t i o n a l'                                                                                                                                                                     =>169,
                                                                                                                                                                                    ' s q u a d '                                                                                                                                                                                                             =>159,
                                                                                                                                                                            ' w a q f'                                                                                                                                                                                              =>165,
                                                                                                                                                                            ' a l y a t e e m'                                                                                                                                                                                                                                      =>121,
                                                                                                                                                                                                                                                    'o t h e r s'                                                                                                                                                                =>168);
    
    function trim_value(&$value) 
    { 
        $value = trim($value);
        $value = str_replace(' ', '', $value);
    }
    $fund_arr = array_flip($fund_arr);
    array_walk($fund_arr, 'trim_value');
    $fund_arr = array_flip($fund_arr);
    //print_r($fund_arr);
    
    if(isset($_GET['fund']) && array_key_exists($_GET['fund'], $fund_arr)){
        $kk_pre_selected_title = $_GET['fund'];
        $kk_pre_selected = $fund_arr[$kk_pre_selected_title];
    }
//    echo('fund='.$_GET['fund']
//             . ', $kk_pre_selected_title='.$kk_pre_selected_title
//            . ', $kk_pre_selected='.$kk_pre_selected);
    
    ?>
    <!--
    <div id="share-kindness-now section-padding">
            <h1 class="text-center">Share your kindness now <small>(ONLINE DONATION)</small></h1>
            <div class="container">
                    <div class="alert alert-info text-center dis_none">
                            <p >All donations to <b>ISLAMIC RELIEF MALAYSIA</b> are tax-exempted under sub-section 44 (6) of income tax 1967.<br/>Ref. No: LHDN.01/35/42/51/179-6.6249 Effective Date: 1.1.2014 until 31.12.2018</p>
                    </div>
       </div>
    </div>-->
    <style>
        #addPenama .text-danger, .deletePenama .text-danger{ color:#fff;}
        #addPenama, .deletePenama {
            font-size: 14px;
            color: #FFFFFF;
            min-height: 30px;
            line-height: 30px;
            text-align: center;
            background-color: #3271b7;
            border-radius: 4px;
            margin: 5px;
            cursor: pointer;
            width:125PX;
        }
        .deletePenama
        {
            border: none;
            background-color: rgba(252,1,5,1.00);
            width: 32px;
        }
        .dis_none{ display:none !important;}
        .section-padding{    padding-top: 133px;
                             padding-bottom: 20px;}
        #otheramount_errmsg
        {
            color: red;
        }
        </style>
        <script>
            
            function add_other_amount_value_to_summary(){
                console.log($("#otheramount").val());
                var val = parseInt($("#otheramount").val());
                if(val > 1 || val <= 999999999999){ 
                    fund_amount = val;
                    $('html, body').animate({scrollTop: $("#step-4-id").offset().top}, 1000);
                    add_donation_summary();
                }
                else{
                    $("#otheramount_errmsg").html("between 2 and 999999999").show().delay(1000).fadeOut("slow");
                    return false;
                }
                
                $('.amnt-btn-c').show(); 
            }
			function add_other_amount_value_to_summary_qurbani(){
                console.log($("#otheramount").val());
                var val = parseInt($("#otheramount").val());
                if(val > 1 || val <= 999999999999){ 
                    fund_amount = val;
                    $('html, body').animate({scrollTop: $("#step-4-id").offset().top}, 1000);
                    add_donation_summary_qurban(true);
                }
                else{
                    $("#otherunit_errmsg").html("between 2 and 999999999999").show().delay(1000).fadeOut("slow");
                    return false;
                }
                
                $('.amnt-btn-c').show(); 
            }
            
            function oneTimeClick() {
                window.location = "/donate-now/index.php?mod=pages&opt=online&ptypee=onetime&testing=2";
            }
            function monthlyClick() {
                window.location = "/donate-now/index.php?mod=pages&opt=online&ptypee=monthly&testing=2";
            }
            
            
            var fund_type = "";
            var fund_type_id = 0;
            var fund_amount = 10;
            function fundActive(id) {
                console.log('id='+id);
                var isQurbaniActive = false;
                //alert('id='+id);

                fund_amount = 0;
				var oQuanityt = $("#otherquantity").val('');
                $("#otheramount").val('');
                fund_type_id = $("#sel_"+id).val();
                $(".amnt-slct").removeClass("amnt-active");
                
                
                console.log("elem="+$("#sel_"+id).val() + ", data-amount="+$("#opt_"+fund_type_id).attr("data-amount"));
                if($("#sel_"+id).val()!==""){
                    fund_type = $("#sel_"+id + " option:selected").text();
                    $('.fund-slct').removeClass('fund-active');
    //               $('.fund-slct').attr('class','form-control');
                    $("#sel_"+id).attr('class', "form-control fund-slct fund-active");// .addClass( "fund-active" );
                    $('html, body').animate({scrollTop: $("#step-3-id").offset().top}, 1000);
                }
                
                //this section covers alyateem checks for changed buttons sections
                if(fund_type_id==122 || fund_type_id==123 || fund_type_id==124){
                    $('#div_alyateem_quantity_buttons').show();
					$('#div_alyateem_quantity_buttons .amnt-slct').removeAttr("disabled");
                    $('#lbl_alyateem_other_help').show();
                    $('#lbl_general_other_help').hide();
                    $('#div_general_amount_buttons').hide();
					$('#div_qurban_quantity_buttons').hide();
                    $('#lbl_qurban_other_help').hide();
                    fund_type = $("#sel_"+id + " option:selected").text();
                    $('html, body').animate({scrollTop: $("#step-3-id").offset().top}, 1000);
                    return;
                } else if(fund_type_id == '150' || fund_type_id == '151' || 
				fund_type_id == '152' || fund_type_id == '153' || fund_type_id == '154' || fund_type_id == '155'){
					$('#lbl_general_other_help').show();
                    $('#div_general_amount_buttons').show();
					$('#div_alyateem_quantity_buttons').hide();
                    $('#lbl_alyateem_other_help').hide();
					$('#div_qurban_quantity_buttons').show();
                    $('#lbl_qurban_other_help').show();
				}
                else{
                    $('#div_alyateem_quantity_buttons').hide();
                    $('#lbl_alyateem_other_help').hide();
                    $('#lbl_general_other_help').show();
                    $('#div_general_amount_buttons').show();
					$('#div_qurban_quantity_buttons').hide();
                    $('#lbl_qurban_other_help').hide();
                }
                ////////////////////////////////////////////////////////
                
                if($("#opt_"+fund_type_id).attr("data-amount")>0){
					if(fund_type_id == '150' || fund_type_id == '151' || fund_type_id == '152' || fund_type_id == '153' || fund_type_id == '154' || fund_type_id == '155'){
							$("#otheramount").val($("#opt_"+fund_type_id).attr("data-amount"));
							$("#fund_type_idd").val(id);
							$('.amnt-slct').prop("disabled", "disabled");
							$('html, body').animate({scrollTop: $('#div_qurban_quantity_buttons').offset().top}, 1000);
					} else {
						console.log('lock amount.');
						$("#fund_type_idd").val('');
						$("#otheramount").val($("#opt_"+fund_type_id).attr("data-amount"));
						$('.amnt-slct').prop("disabled", "disabled");
						fund_amount = $("#otheramount").val();
						add_donation_summary();
					}
                }
                else{
                    $('.amnt-slct').removeAttr("disabled");
                    console.log('no lock amount.');
                    fund_amount = 0;
                }
            }
            
            function fundActiveBtn(id) {
                fund_amount = 0;
                $("#otheramount").val('');
                $(".amnt-slct").removeClass("amnt-active");
                fund_type_id = id;
                console.log("elem="+$("#opt_"+id).text());
                if($("#opt_"+id).text()!==""){
                    fund_type = $("#opt_"+id).text();
                    $('.fund-slct').removeClass('fund-active');
                    $("#opt_"+id).attr('class', "btn fund-slct fund-active");// .addClass( "fund-active" );
                    $('html, body').animate({scrollTop: $("#step-3-id").offset().top}, 1000);
                }
                
                if($("#opt_"+fund_type_id).attr("data-amount")>0){
                    console.log('lock amount.');
                    $("#otheramount").val($("#opt_"+fund_type_id).attr("data-amount"));
                    $('.amnt-slct').prop("disabled", "disabled");
                    fund_amount = $("#otheramount").val();
                    add_donation_summary();
                }
                else{
                    $('.amnt-slct').removeAttr("disabled");
                    console.log('no lock amount.');
                    fund_amount = 0;
                }
            }
            
            function fundActiveBtnPreselected(id) {
                fund_amount = 0;
                $("#otheramount").val('');
                $(".amnt-slct").removeClass("amnt-active");
                fund_type_id = id;
                console.log("elem="+$("#opt_"+id).text());
                if($("#opt_"+id).text()!==""){
                    fund_type = $("#opt_"+id).text();
                    $('.fund-slct').removeClass('fund-active');
                    $("#opt_"+id).attr('class', "btn fund-slct fund-active");// .addClass( "fund-active" );
                    $('html, body').animate({scrollTop: $("#step-3-id").offset().top}, 1000);
                }
                
                if($("#opt_"+fund_type_id).attr("data-amount")>0){
                    console.log('lock amount.');
                    $("#otheramount").val($("#opt_"+fund_type_id).attr("data-amount"));
                    $('.amnt-slct').prop("disabled", "disabled");
                    fund_amount = $("#otheramount").val();
                    //add_donation_summary();
                }
                else{
                    $('.amnt-slct').removeAttr("disabled");
                    console.log('no lock amount.');
                    fund_amount = 0;
                }
            }
            
            function quantityActiveBtn(obj){
                fund_amount=($(obj).val()*$("#opt_"+fund_type_id).attr("data-amount")); 
                $('#selectedamount').val(fund_amount); 
                //fund_type = $("#opt_"+fund_type_id).attr("value");
                amntActiveBtn(obj, true);
                add_donation_summary();
                console.log('fund_amount = ' + fund_amount + ', fund_type_id='+fund_type_id);
            }
            
            
            function amntActiveBtn(elem, scrollanim) {
                $('.amnt-slct').removeClass('amnt-active');
                $(elem).attr('class', "btn amnt-slct amnt-active");// .addClass( "fund-active" );
                if(scrollanim)
                    $('html, body').animate({scrollTop: $("#step-4-id").offset().top}, 1000);  
            }
            
            function add_donation_summary(){
                console.log('add_donation_summary();');
                if(fund_type==="" || fund_amount===0){
                    alert("Please select fund and enter amount.");
                    return false;
                }
                var is_already_added = false;
                $('input[name^="txt_designation"]').each( function() {
                    if(this.value==fund_type_id){
                        is_already_added = true;
                    }
                    
                    
                    //alert(total_amount);
                });
                if(is_already_added){
                    alert("This fund is already added!");
                    return false;
                }
                
                
                $('#tbl_summary tr:first').after('<tr id="row_summary_id_' + fund_type_id + '"><td>\n\
                        <input type="hidden" id="txt_fund_id_' + fund_type_id + '" name="txt_designation[]" value="' + fund_type_id + '"/>' + 
                        '<input type="hidden" id="txt_fund_amount_' + fund_type_id + '" name="txt_amount[]" value="' + fund_amount + '"/>' + 
                        fund_type + '</td><td>RM ' + fund_amount + 
                        '<span class="del-fund fa fa-times" onclick="delete_item_from_summary(' + fund_type_id + ');"></span></td></tr>');
                $("#otheramount").val('');
                $('.fund-slct').removeClass('fund-active');
                $('.amnt-slct').removeClass('amnt-active');
                $('#tbl_summary').focus();
                count_total_items();
                console.log("fund_type="+fund_type+", fund_amount="+fund_amount);
                checkOptionsForContactForm();
            }
			
			function add_donation_summary_qurban(isOther=false){
                console.log('add_donation_summary_qurban();');
				
				var fund_amount = $("#otheramount").val();
				var fund_quantity = $("#selectedQuantity").val();
				var fund_type_idd= $("#fund_type_idd").val();
	
				var fund_type = $("#sel_"+fund_type_idd + " option:selected").text();
				
				console.log(fund_type_idd+"==="+fund_quantity+"==="+fund_type);
				if(fund_quantity==="" || fund_quantity===0){
					   alert("Please select Quantity.");
                    return false;
				}
                if(fund_type==="" || fund_amount===0){
                    alert("Please select fund and enter amount.");
                    return false;
                }
                var is_already_added = false;
                $('input[name^="txt_designation"]').each( function() {
                    if(this.value==fund_type_id){
                        is_already_added = true;
                    }
                    
                    
                    //alert(total_amount);
                });
                if(is_already_added){
                    alert("This fund is already added!");
                    return false;
                }
                fund_amount = fund_amount * 	fund_quantity;
                
                $('#tbl_summary tr:first').after('<tr id="row_summary_id_' + fund_type_id + '"><td>\n\
                        <input type="hidden" id="txt_fund_id_' + fund_type_id + '" name="txt_designation[]" value="' + fund_type_id + '"/>' + 
                        '<input type="hidden" id="txt_fund_amount_' + fund_type_id + '" name="txt_amount[]" value="' + fund_amount + '"/>' + 
                        fund_type + ' x '+ fund_quantity +'</td><td>RM ' + fund_amount + 
                        '<span class="del-fund fa fa-times" onclick="delete_item_from_summary(' + fund_type_id + ');"></span></td></tr>');
//                $("#otheramount").val('');
				
                $('.fund-slct').removeClass('fund-active');
                $('.amnt-slct').removeClass('amnt-active');
                $('#tbl_summary').focus();
                count_total_items();
                console.log("fund_type="+fund_type+", fund_amount="+fund_amount);
                checkOptionsForContactForm();
            }
            
            
            function checkOptionsForContactForm(){
                var is_any_alyateem_opt_added = false;
                $('input[name^="txt_designation"]').each( function() {
                    console.log('this.value='+this.value);
                    if(this.value==122 || this.value==123 || this.value==124){
                        is_any_alyateem_opt_added = true;
                    }
                    
                    //alert(total_amount);
                });
                
                if(is_any_alyateem_opt_added){
                    $('#div_chk_contact').show();
                    $('#contact').trigger('click');
                    $('#div_chk_unknown').hide();
                }
                else{
                    $('#div_chk_unknown').show();
                }
            }
            
            function count_total_items(){
                var total_amount = 0;
                $('input[name^="txt_amount"]').each( function() {
                    total_amount += parseInt(this.value);
                    console.log('this.value='+this.value + ', total_amount=' + total_amount);
                    //alert(total_amount);
                });
                $('#lbl_totalamount').text(total_amount);
                $('#txt_sub_total_amount').val(total_amount);
//                var total_amt = total_amount;
//		var total = 0;
//		$('[name="txt_amount[]"]').each(function() {
//			if( this.value == '' )
//				this.value = 0.00;
//			total = parseFloat(total) + parseFloat(this.value);
//		});
		total_amount = parseFloat(total_amount).toFixed(2);
		recalculate_channelfee_credit( total_amount );
		recalculate_channelfee_others( total_amount );
                checkOptionsForContactForm();
            }
            
            function delete_item_from_summary(id){
                //if(confirm("Are you sure you want to remove this fund from list?")){
                    $('#row_summary_id_'+id).remove();
                    count_total_items();
					var isAlYateem = 0;
            var isAlQurban = 0;
			var idd = '';
            jQuery('#tbl_summary > tbody > tr').not(':first').each(function(index, element) {
				idd = $(this).attr('id').replace('row_summary_id_','');
                if (idd == '122' || idd == '123' || idd == '124' || idd == '125' || idd == '149' || idd == '150' || idd == '151' || 
				idd == '152' || idd == '153' || idd == '154' || idd == '155') {
                    isAlYateem++;
                }
                if ( idd == '150' || idd == '151' || idd == '152' || idd == '153' || idd == '154' || idd == '155') {
                    isAlQurban++;
                }
            });
            console.log(isAlYateem);
            if (isAlYateem > 0 || isAlQurban>0) {
                $("#contact").prop("checked", true);
                $("#unknown").prop("checked", false);
				$("#unknown").prop("disabled", true);
                //$("#unknown").attr("disabled", true);
                $('#detailsbox').removeClass("contactDetails");

            }
            else
            {
                $("#unknown").prop("checked", true);
                $("#contact").prop("checked", false);
                $("#unknown").prop("disabled", false);
                $('#detailsbox').addClass("contactDetails");
            }
            if (isAlQurban > 0) {
                $('#penamaRows').fadeIn('slow');
            }
            else {
                $('#penamaRows').fadeOut('slow');
            }
        
                //}
            }
            
            /*
             * Calculate Channel Fee Credit
             */
            function recalculate_channelfee_credit(sub_amt) {
                var gst_rate = parseFloat(0.06);
                var charges_rate = parseFloat(0.017);//parseFloat(0.028);
                var channel_fee = parseFloat(sub_amt) * charges_rate;
                var channel_fee_gst = parseFloat(channel_fee) * gst_rate;
                //var grand_total = parseFloat(sub_amt) + channel_fee + channel_fee_gst;
                var grand_total = parseFloat(sub_amt) + channel_fee;
    		console.log( "grand_total=" + grand_total );
                
                document.getElementById('txt_channel_fee_credit').value = channel_fee.toFixed(2);
                document.getElementById('txt_channel_fee_credit_gst').value = channel_fee_gst.toFixed(2);
                document.getElementById('txt_grand_total_amount_credit').value = grand_total.toFixed(2);
            }

            /*
             * Calculate Channel Fee Credit
             */
            function recalculate_channelfee_others(sub_amt) {
                var gst_rate = parseFloat(0.06);
                var charges_rate = parseFloat(0.017);//parseFloat(0.022);
                var channel_fee = parseFloat(sub_amt) * charges_rate;
                channel_fee = (channel_fee > 0.6) ? channel_fee : 0.6;
                var channel_fee_gst = parseFloat(channel_fee) * gst_rate;
                //var grand_total = parseFloat(sub_amt) + channel_fee + channel_fee_gst;
                var grand_total = parseFloat(sub_amt) + channel_fee;
    		console.log( "grand_total=" + grand_total );

                document.getElementById('txt_channel_fee_others').value = channel_fee.toFixed(2);
                document.getElementById('txt_channel_fee_others_gst').value = channel_fee_gst.toFixed(2);
                document.getElementById('txt_grand_total_amount_others').value = grand_total.toFixed(2);
            }
            
            $('input[name="onetime"]').change(function () {
                console.log("onetime=" + this.val());
             });
             
             
            function check_payment_type(opt, scrollanim){
                 console.log("onetime2=" + opt);
                $('.creditpaymentmethods').show();
                $('#txt_onetime').val(opt);
                if(opt==="monthly"){
                     $('.otherpaymentmethods').hide();
                     $('#onetime').removeAttr('disabled');
                     $('#monthly').attr('disabled','disabled');
                     $('.opt_monthly').removeAttr('disabled');
                     $('#onetime-label').removeClass("pay-actv");
                     $('#monthly-label').addClass("pay-actv");   
                }
                 else{
                     //$('.creditpaymentmethods').hide();
                     $('.otherpaymentmethods').show();
                     $('.opt_monthly').attr('disabled','disabled');
                     $('#monthly').removeAttr('disabled');
                     $('#onetime').attr('disabled','disabled');
                     $('#monthly-label').removeClass("pay-actv");
                     $('#onetime-label').addClass("pay-actv");
                     fund_type = "";
                     fund_type_id = 0;
                 }
                 if(scrollanim){
                    $('html, body').animate({scrollTop: $("#step-2-id").offset().top}, 1000);
                 }
                 $('#div_alyateem_quantity_buttons').hide();
            }
            
            function isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            }
            

//            $('.fund-slct').on('change', function () {
//                    $('html, body').animate({scrollTop: $("#step-3-id").offset().top}, 2000);
//            });


$(document).ready(function(e) {
                check_payment_type("onetime",false);
                $("#otheramount").keypress(function (e) {
                        $('.amnt-btn-c').show(); 
                    //if the letter is not digit then display error and don't type anything
                        if (e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                           //display error message
                           $("#otheramount_errmsg").html("Digits Only").show().delay(1000).fadeOut("slow");
                                  return false;
                       }
                       
                       if (e.keyCode == 13) {
                           //get and add value
                           var val = parseInt($(this).val());
                            if(val < 2 || val > 999999999999)
                            {
                               $("#otheramount_errmsg").html("between 2 and 999999999999").show().delay(500).fadeOut("slow");
                                  return false;
                            }
                            else{
                                add_other_amount_value_to_summary();
                                
                            }
                       }
                       else{
                           //return false;
                       }
                  });
				  
				  $("#otherunit").keypress(function (e) {
                        $('.amnt-btn-c').show(); 
                    //if the letter is not digit then display error and don't type anything
                        if (e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                           //display error message
                           $("#otherunit_errmsg").html("Digits Only").show().delay(1000).fadeOut("slow");
                                  return false;
                       }
                       
                       if (e.keyCode == 13) {
                           //get and add value
                           var val = parseInt($(this).val());
                            if(val < 2 || val > 999999999999)
                            {
                               $("#otherunit_errmsg").html("between 2 and 999999999999").show().delay(500).fadeOut("slow");
                                  return false;
                            }
                            else{
								$('#selectedQuantity').val($("#otherunit").val());
                                add_other_amount_value_to_summary_qurbani();
                                
                            }
                       }
                       else{
                           //return false;
                       }
                  });
                  
                  
                  
                  $("#otherquantity").keypress(function (e) {
                        $('.amnt-btn-c').show(); 
                    //if the letter is not digit then display error and don't type anything
                        if (e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                           //display error message
                           $("#otherquantity_errmsg").html("Digits Only").show().delay(1000).fadeOut("slow");
                                  return false;
                       }
                       
                       if (e.keyCode == 13) {
                           //get and add value
                           var val = parseInt($(this).val());
                            if(val < 2 || val > 36)
                            {
                               $("#otherquantity_errmsg").html("between 2 and 36").show().delay(500).fadeOut("slow");
                                  return false;
                            }
                            else{
                                quantityActiveBtn($("#otherquantity"));
                                
                            }
                       }
                       else{
                           //return false;
                       }
                  });
                  
                  /*
                  $("#otheramount").keyup(function (e) {
                      console.log($(this).val());
                        var val = parseInt($(this).val());
                        if(val < 2 || val > 999999999){ 
                            e.preventDefault();
                            if(val===1){
                                $(this).val(2);
                            }
                            else{
                                $(this).val(999999999);
                            }
                            $("#otheramount_errmsg").html("between 2 and 999999999").show().delay(500).fadeOut("slow");
                                  return false;
                        }
                        
                  });*/
                  <?php
                  if($kk_pre_selected==194){
                      ?>
                              $('#monthly-label').parent().hide();
                    fundActiveBtnPreselected('<?php echo($kk_pre_selected);?>');
                    $('#btn_addmoredonation').hide();
                    <?php
                  }
                  
                  
                  //if($kk_pre_selected>0){
                      /*
                      ?>
                        fundActiveBtn('<?php echo($kk_pre_selected);?>');
                       <?php
                       
                          $('.fund-type').attr('disabled','disabled');
                          $('#opt_<?php echo($kk_pre_selected);?>').removeAttr('disabled');
                          <?php 
                            if($kk_pre_selected==194){?>
                                fundActiveBtn('<?php echo($kk_pre_selected);?>');
                          <?php
                            }else{?>
                                $('#opt_<?php echo($kk_pre_selected);?>').parent().val(<?php echo($kk_pre_selected);?>);
                                fundActive($('#opt_<?php echo($kk_pre_selected);?>').parent().attr('id').replace('sel_',''));

                            <?php 
                            }
                           
                            ?>
                        * 
                        */
                        
                  
                  //}
                  ?>
            });
            
        </script>
        <div class="container-fluid bgBlue"> <h3 class="text-white text-center">#StartNow & Donate!</h3></div> 
        <div class="dld-pdf"><a href="https://islamic-relief.org.my/wp-content/uploads/2018/03/sample_how_to_donate.pdf" target="_blank">Sample How To Donate (PDF)<span> Click here</span></a></div>


   
        <form id="frm_online form" class="donsn-frm" method="POST" action="/donate-now/json_new.php" role="molpayseamless">

        <input type="hidden" name="txt_action" value="frm_online_submit"/>
        <input type="hidden" name="txt_form_session" value="<?= $_SESSION['form_session']; ?>"/>
        <input type="hidden" id="txt_onetime" name="txt_onetime" value="onetime"/>
        <input style="display: none;" onchange="check_payment_type('onetime',true);" type="checkbox" name="onetime" value="onetime" checked id="onetime">
                            
        <div class="don-contnr">
            <?php
            /*
            <span id="step-1-id"></span>
                <div class="page-header don-sec-head">
                    <h4 class="centeralize">STEP 1: DONATION TYPE</h4>
                </div>
                <div class="centeralize rmv-10-pd">    
                
                
                    <div class="don-halfy">
                        <section>
                        <label id="onetime-label" for="onetime" class="pay-label pay-actv stp-1-cls">
                            <input onchange="check_payment_type('onetime',true);" type="checkbox" name="onetime" value="onetime" checked id="onetime">
                            <p>
                                <b>One-Time </b> <br>
                                (Debit Card / Credit Card / Online Banking)
                            </p>
                        </label>
                            
                        </section>
                    </div>     
                    <div class="don-halfy" style="display: none;"> 
                        <section>
                        <label id="monthly-label" for="monthly" class="pay-label stp-1-cls">
                            <input onchange="check_payment_type('monthly',true);" type="checkbox" name="onetime" value="monthly" id="monthly" >
                            <p>
                                <b>Monthly</b>  <br>
                                (Credit Card) 
                                <span>Recommended</span>
                            </p>
                        </label>
                            
                        </section>
                    </div>
                    <div class="clearfix"></div>
                </div>
             
                <div class="row">
                    <div class="col-xs-6 col-sm-4 form-group">
                        <a class="btn btn-success btn-sm btn-block fancybox dis_none" data-fancybox-type="iframe" href="http://www.muamalat.com.my/tools/zakat-calculators/monthly-earnings.html"><i class="fa fa-calculator fa-lg"></i> Zakat</a>
                    </div>
                    <div class="col-xs-6 col-sm-4 form-group">
                        <a class="btn btn-info btn-sm btn-block fancybox dis_none" data-fancybox-type="iframe" href="http://e-muamalat.gov.my/kalkulator-fidyah"><i class="fa fa-calculator fa-lg"></i> Fidyah</a>
                    </div>

                </div>
                * 
             */?>

            <span id="step-2-id"></span>
                <div class="page-header don-sec-head">
                    <h4 class="centeralize">STEP 1: SELECT YOUR FUND</h4>
                </div>
                <div class="rmv-10-pd fund-typey">
                <?php
                /*
                if($kk_pre_selected==194){
                    //echo('$kk_pre_selected='.$kk_pre_selected);
                    ?>
                    <div class="don-halfy"> 
                        <section>
                            <button id="opt_<?php echo($kk_pre_selected);?>" type="button" class="btn fund-slct fund-active"  onclick="fundActiveBtn('<?php echo($kk_pre_selected);?>')" value="<?= $kk_pre_selected ?>" data-amount="<?= ucwords($fund_arr[$kk_pre_selected]) ?>"><?= ucwords($fund_arr[$kk_pre_selected]) ?></button>
                        </section>
                    </div>
                    <?php
                }
                else{
                    //echo('no default selection.');
                
                */
                
                $qubaan_Arr = array(149, 150, 151, 152, 153, 154, 155, "QURBAN 1438H");
                foreach ($designations as $k => $v) {
                    ?>
                    <?php
                    foreach ($v as $kk => $vv) {
                        //echo('<br> $kk = ' .$kk );
                        if($kk_pre_selected>0 && $kk != $kk_pre_selected){
                            continue;
                        }
                        //if(in_array(ucwords($vv['designation_name']),$qubaan_Arr)) {
                        if (isset($vv['child_items']) && count($vv['child_items']) > 0) {
                            ?>

                            <div class="don-halfy">
                                <section>
                                    <select id="sel_<?php echo($kk);?>" class="form-control fund-slct" onchange="fundActive('<?php echo($kk);?>')">
                                        <option value=""><?= ucwords($vv['designation_name']) ?></option>
                                    <?php foreach ($vv['child_items'] as $kkk => $vvv) { 
                                        //$val = str_replace('"', "'", $vvv['designation_name']);
                                        ?>
                                        <option id="opt_<?= $kkk ?>" class="fund-type " value="<?= $kkk ?>" data-amount="<?= ucwords($vvv['designation_amount']) ?>"><?= ucwords($vvv['designation_name']) ?></option>
                                    <?php
                                        /*
                                        ?>
                                        <option id="opt_<?= $kkk ?>" <?php echo(strpos($vvv['designation_name'], 'MONTHLY')>0? 'disabled="disabled" class="fund-type opt_monthly"': ' class="fund-type "');?> value="<?= $kkk ?>" data-amount="<?= ucwords($vvv['designation_amount']) ?>"><?= ucwords($vvv['designation_name']) ?></option>
                                    <?php
                                         * 
                                         */ 
                                        
                                        } ?>
                                    </select>
                                </section>
                            </div>
                            <?php } else { ?>
                            <div class="don-halfy"> 
                                <section>
                                    <button id="opt_<?php echo($kk);?>" type="button" class="btn fund-type fund-slct"  onclick="fundActiveBtn('<?php echo($kk);?>')" value="<?= $kk ?>" data-amount="<?= ucwords($vv['designation_amount']) ?>"><?= ucwords($vv['designation_name']) ?></button>
                                </section>
                            </div>
                            <?php }
                        } ?>
                    <?php // }  ?>
                <?php } 
                            
                //}
                ?>
                </div>
            <span id="step-3-id"></span>
                <div class="page-header don-sec-head">
                    <h4 class="centeralize">STEP 2: SELECT AMOUNT</h4>
                </div>
                <div class="select-amount">
                    <?php
                    $ssp1 = "/* ".$mod_config['document_root']."default_values.php [".__LINE__."] */ "
			 . "SELECT * FROM ns_default_values LIMIT 1 ";
	$ssp1.="  LOCK IN SHARE MODE";
//	echo $ssp;
	$rssp1=$db->sql_query( $ssp1 ) or $db->sql_error( $ssp1 );
	$rm1 = 10;
        $rm2 = 20;
        $rm3 = 50;
        $rm4 = 100;
	while( $rwsp1 = $db->sql_fetchrow( $rssp1 ) ){
		$records_donation[] = $rwsp1;
                $rm1 = $rwsp1['rm1'];
                $rm2 = $rwsp1['rm2'];
                $rm3 = $rwsp1['rm3'];
                $rm4 = $rwsp1['rm4'];
        }
                    ?>
                        <input type="hidden" id="selectedamount" value="<?php echo($rm1);?>"/>
                        
                            <aside id="div_alyateem_quantity_buttons">
                                <p class="div_alyateem_quantity_buttons" style="font-weight: bold; clear: both;">
                                    TOTAL MONTH(S) TO SPONSOR:
                                </p>
                                <div class="div_alyateem_quantity_buttons">
                                    <section>
                                        <button type="button" class="btn amnt-slct" onclick="quantityActiveBtn(this);" value="1" data-amount="1">1 month</button>
                                    </section>
                                </div>
                                <div class="div_alyateem_quantity_buttons">
                                    <section>
                                        <button type="button" class="btn amnt-slct" onclick="quantityActiveBtn(this);" value="6" data-amount="6">6 months</button>
                                    </section>
                                </div>
                                <div class="div_alyateem_quantity_buttons">
                                    <section>
                                        <button type="button" class="btn amnt-slct" onclick="quantityActiveBtn(this);" value="12" data-amount="12">12 months</button>
                                    </section>
                                </div>
                                <div class="div_alyateem_quantity_buttons">
                                    <section>
                                        <button type="button" class="btn amnt-slct" onclick="quantityActiveBtn(this);" value="24" data-amount="24">24 months</button>
                                    </section>
                                </div>
                                <div>
                                    <section>
                                        <input class="amnt-slct amnt-other-c" type="number" onchange="" onclick="" value="" id="otherquantity" placeholder="Others" min="2" max="36" data-content="Number between 2 to 36">
                                        <span class="amnt-btn-c" id="btn_add_othequantity" onclick='
                                              var val = parseInt($("#otherquantity").val());
                                                if(val < 2 || val > 36)
                                                {
                                                   $("#otherquantity_errmsg").html("between 2 and 36").show().delay(500).fadeOut("slow");
                                                      return false;
                                                }
                                                else{
                                                    quantityActiveBtn($("#otherquantity"));
                                                }
                                              '>+</span>
                                        <span id="otherquantity_errmsg"></span>
                                    </section>
                                </div>
                            </aside>
                            
                            <aside id="div_general_amount_buttons">
                                <div class="div_general_amount_buttons">
                                    <section><input type="hidden" id="fund_type_idd" value="0"/>
                                        <button type="button" class="btn amnt-slct" onclick="fund_amount=$(this).val(); $('#selectedamount').val($(this).val()); amntActiveBtn(this, true);add_donation_summary();" value="<?php echo($rm1);?>" data-amount="<?php echo($rm1);?>">RM <?php echo($rm1);?></button>
                                    </section>
                                </div>
                                <div class="div_general_amount_buttons">
                                    <section>
                                        <button type="button" class="btn amnt-slct" onclick="fund_amount=$(this).val(); $('#selectedamount').val($(this).val()); amntActiveBtn(this, true);add_donation_summary();" value="<?php echo($rm2);?>" data-amount="<?php echo($rm2);?>">RM <?php echo($rm2);?></button>
                                    </section>
                                </div>
                                <div class="div_general_amount_buttons">
                                    <section>
                                        <button type="button" class="btn amnt-slct" onclick="fund_amount=$(this).val(); $('#selectedamount').val($(this).val()); amntActiveBtn(this, true);add_donation_summary();" value="<?php echo($rm3);?>" data-amount="<?php echo($rm3);?>">RM <?php echo($rm3);?></button>
                                    </section>
                                </div>
                                <div class="div_general_amount_buttons">
                                    <section>
                                        <button type="button" class="btn amnt-slct" onclick="fund_amount=$(this).val(); $('#selectedamount').val($(this).val()); amntActiveBtn(this, true);add_donation_summary();" value="<?php echo($rm4);?>" data-amount="<?php echo($rm4);?>">RM <?php echo($rm4);?></button>
                                    </section>
                                </div>
                                <div>
                                    <section>
                                        <input class="amnt-slct amnt-other-c" type="number" name="otheramount" onchange="fund_amount=$(this).val(); $('#selectedamount').val($(this).val());" value="" id="otheramount" placeholder="RM Others" min="2" max="999999999" pattern="\d*" data-content="Number between 2 to 999999999">
                                        <span class="amnt-btn-c" id="btn_add_otheramount" onclick='
                                              var val = parseInt($("#otheramount").val());
                                                if(val < 2 || val > 999999999999)
                                                {
                                                   $("#otheramount_errmsg").html("between 2 and 999999999999").show().delay(500).fadeOut("slow");
                                                      return false;
                                                }
                                                else{
                                                    add_other_amount_value_to_summary();

                                                }
                                              '>+</span>
                                        <span id="otheramount_errmsg"></span>
                                    </section>
                                </div>
                                 <div class="clearfix amnt-info" style="color: red;width: 100%;margin: 4px;"><label id="lbl_alyateem_other_help" style="display: none;">*For OTHERS, press ENTER or "+" button after inserting value.</label><label id="lbl_general_other_help">*For OTHER amount donation, please press ENTER or "+" button after inserting value.</label></div>
                            </aside>
                            
                            
                            
                        	<aside id="div_qurban_quantity_buttons" style="display:none">
                            		
                                <p class="div_alyateem_quantity_buttons" style="font-weight: bold; clear: both; padding-top:20px">
                                    TOTAL QUANTITY TO SPONSOR:
                                </p>
                                <div class="div_general_amount_buttons">
                                    <section>
                                    	<input type="hidden" name="selectedQuantity" value="1" id="selectedQuantity" />
                                        <button type="button" class="btn qty-slct" onclick="fund_quantity=$(this).val(); $('#selectedQuantity').val($(this).val());add_donation_summary_qurban();" value="1" data-quantity="1">1 Part</button>
                                    </section>
                                </div>
                                <div class="div_general_amount_buttons">
                                    <section>
                                        <button type="button" class="btn qty-slct" onclick="fund_quantity=$(this).val(); $('#selectedQuantity').val($(this).val()); add_donation_summary_qurban();" value="6" data-amount="6">6 Parts</button>
                                    </section>
                                </div>
                                <div class="div_general_amount_buttons">
                                    <section>
                                        <button type="button" class="btn qty-slct" onclick="fund_quantity=$(this).val(); $('#selectedQuantity').val($(this).val()); add_donation_summary_qurban();" value="12" data-amount="12">12 Parts</button>
                                    </section>
                                </div>
                                <div class="div_general_amount_buttons">
                                    <section>
                                        <button type="button" class="btn qty-slct" onclick="fund_quantity=$(this).val(); $('#selectedQuantity').val($(this).val()); add_donation_summary_qurban();" value="24" data-amount="24">24 Parts</button>
                                    </section>
                                </div>
                                <div>
                                    <section>
                                        <input class="qty-slct amnt-other-c" type="number" name="otherunit" onchange="fund_quantity=$(this).val(); $('#selectedQuantity').val($(this).val());" value="" id="otherunit" placeholder="Parts Others" min="2" max="999999999" pattern="\d*" data-content="Number between 2 to 999999999">
                                        <span class="amnt-btn-c" id="btn_add_otherunit" onclick='
                                              var val = parseInt($("#otherunit").val());
                                                if(val < 2 || val > 999999999999)
                                                {
                                                   $("#otherunit_errmsg").html("between 2 and 999999999999").show().delay(500).fadeOut("slow");
                                                      return false;
                                                }
                                                else{
                                                	$("#selectedQuantity").val($("#otherunit").val());
                                                    add_other_amount_value_to_summary_qurbani();

                                                }
                                              '>+</span>
                                        <span id="otherunit_errmsg"></span>
                                    </section>
                                </div>
                                <div class="clearfix amnt-info" id="lbl_qurban_other_help" style="color: red;width: 100%;margin: 4px;">*For OTHERS, please press ENTER or "+" button after inserting value.</div>
                            </aside>
                           
            		               
                    </div>
            
            <span id="step-4-id"></span>
                <br>
                
                <table id="tbl_summary" class="table  tble75p">
                    <tbody>
                        <tr>
                            <th>DONATION SUMMARY</th>
                            <th>AMOUNT</th>
                        </tr>
                    </tbody>
                    <tfoot id="total_fund_amount">                               
                        <tr>
                            <th>Sub Total</th>
                            <th>RM <label id='lbl_totalamount'>0</label></th>
                        </tr>
                    </tfoot>
                </table>
                <!--<p class="notepan"><span>*Note:</span>To make more than one donation, repeat Step 2 & 3 above.</p>-->
                <?php
                if($kk_pre_selected!=194){?>
                <div class="clktodon">
                    <!--<p>Click to donate selected amount:</p>-->
                    <button id='btn_addmoredonation' type="button" onclick="$('html, body').animate({scrollTop: $('#step-2-id').offset().top}, 1000);" class="btn btn-lg btn-primary addRow" name="tbl_donation"><i class="fa fa-plus fa-lg"></i> Add Fund</button>
                </div>
                <?php
                }
                ?>
                <div class="table-responsive">
                    
                    <table id="tbl_donation" class="table table-striped table-condensed" style="display:none">
                        <thead>
                            <tr>
                                <th width="50%">DONATE FORrrrrr <sup><span class="text-danger glyphicon glyphicon-asterisk"></span></sup></th>
                                <th width="20%" nowrap>COUNT <!--<sup><span class="text-danger glyphicon glyphicon-asterisk"></span></sup>--></th>
                                <th width="30%" class="text-right">AMOUNT <sup><span class="text-danger glyphicon glyphicon-asterisk"></span></sup></th>
                                <th width="5%">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <?php
                                    /*
                                    <select class="form-control input-sm" id="txt_designation_1" name="txt_designation[]" required>

                                        <!--	<option></option>
                                                                                                                                                <optgroup label="QURBAN 1438H">
                                                                                                                                                                                <option value="149" data-amount="0.00">- Sedekah Qurban</option>
                                                                                                                                                                                <option value="150" data-amount="390.00">- Group A: RM390</option>
                                                                                                                                                                                <option value="151" data-amount="550.00">- Group B: RM550</option>
                                                                                                                                                                                <option value="152" data-amount="800.00">- Group C: RM800</option>
                                                                                                                                                                                <option value="153" data-amount="1000.00">- Group D: RM1000</option>
                                                                                                                                                                                <option value="154" data-amount="1400.00">- Group E: RM1400</option>
                                                                                                                                                                                <option value="155" data-amount="2000.00">- Group F: RM2000</option>
                                                                                                                                                                        </optgroup>
                                                                                                                                                                                                            <optgroup label="WAQF">
                                                                                                                                                                                <option value="117" data-amount="210.00">- Waqf (Wakaf) Al-Quran Braille: RM210</option>
                                                                                                                                                                                <option value="118" data-amount="0.00">- Waqf Cash / Wakaf Tunai</option>
                                                                                                                                                                        </optgroup>
                                                                                                                                                                                                            <optgroup label="Al YATEEM SPONSORSHIP">
                                                                                                                                                                                <option value="122" data-amount="160.00">- Al Yateem (GROUP A) - MONTHLY (RM160) "Min. Commitment 24 Month"</option>
                                                                                                                                                                                <option value="123" data-amount="190.00">- Al Yateem (GROUP B) - MONTHLY (RM190) "Min. Commitment 24 Month"</option>
                                                                                                                                                                                <option value="124" data-amount="230.00">- Al Yateem (GROUP C) - MONTHLY (RM230) "Min. Commitment 24 Month"</option>
                                                                                                                                                                                <option value="125" data-amount="0.00">- Al Yateem (GENERAL FUND)</option>
                                                                                                                                                                        </optgroup>
                                                                                                                                                                                                            <option value="130" data-amount="0.00">Alisha Appeal (Special Appeal)</option>
                                                                                                                                                                                                            <option value="131" data-amount="0.00">Zakat</option>
                                                                                                                                                                                                            <option value="133" data-amount="0.00">General Fund</option>
                                                                                                                                                                                                            <option value="134" data-amount="0.00">Empowering Mushroom Cultivation (EMC) - Lombok</option>
                                                                                                                                                                                                            <option value="135" data-amount="0.00">Fidyah</option>
                                                                                                                                                                                                            <option value="145" data-amount="0.00">MySEDEKAH - Project Development (International), Gift Of Hope (GOH) &amp; Community Development </option>
                                                                                                                                                                                                            <option value="146" data-amount="0.00">MySEDEKAH - Save Syria</option>
                                                                                                                                                                                                            <option value="147" data-amount="0.00">MySEDEKAH - East Africa Appeal</option>-->


                                        <!--									<option></option>-->
                            <?php
                            $qubaan_Arr = array(149, 150, 151, 152, 153, 154, 155, "QURBAN 1438H");
                            foreach ($designations as $k => $v) {
                                ?>
                                <?php
                                foreach ($v as $kk => $vv) {
                                    //if(in_array(ucwords($vv['designation_name']),$qubaan_Arr)) {
                                    ?>
                                                <?php if (isset($vv['child_items']) && count($vv['child_items']) > 0) {
                                                    ?>
                                                    <optgroup label="<?= ucwords($vv['designation_name']) ?>">
                                                    <?php foreach ($vv['child_items'] as $kkk => $vvv) { ?>
                                                            <option value="<?= $kkk ?>" data-amount="<?= ucwords($vvv['designation_amount']) ?>"><?= ucwords($vvv['designation_name']) ?></option>
                                                    <?php } ?>
                                                    </optgroup>
                                                    <?php } else { ?>
                                                    <option value="<?= $kk ?>" data-amount="<?= ucwords($vv['designation_amount']) ?>"><?= ucwords($vv['designation_name']) ?></option>
                                                    <?php }
                                                } ?>
                                            <?php // }  ?>
                                        <?php } ?>
                                    </select>
                                     * 
                                     */
                                    ?>
                                </td>
                                <td>
                                    <input type="number" step="1" min="1" value="1" class="form-control input-sm text-center" id="txt_quantity_1" name="txt_quantity[]" required>
                                </td>
                                <td>
                                    <?php /*<input type="text" value="0" class="form-control input-sm text-right" id="txt_amount_1" name="txt_amount[]" required>
                                     * 
                                     */
                                    ?>
                                    <input type="hidden" id="txt_amount_peritems_1" value="0">
                                </td>
                                <td><i class="fa fa-remove fa-2x text-danger sr-only"></i></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-right">SUB-TOTAL:</th>
                                <th colspan="2" style="border-bottom: 1px solid #dddddd;">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon alert-info"><b>RM</b></span>
                            <input type="text" class="form-control input-sm text-right" id="txt_sub_total_amount" name="txt_sub_total_amount" value="0.00" readonly required>
                        </div>
                    </th>
                    
                </tfoot>
                </table>
                    <?php
                    /*
                    <div class="row">

                            <div class="col-sm-12 col-lg-12 col-sm-12 col-xs-12 text-left form-group">
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12" style="color:#09F;color: #09F;padding-bottom: 25px;    clear: both;">

                                <span style="color:#000; font-size:16px; font-weight:600;">Online Calculator:</span><a href="http://www.zakatselangor.com.my/calkulator-zakat/zakat-pendapatan/" style="font-weight: 600;" target="_blank"> ZAKAT</a> , <a href="http://www.zakatselangor.com.my/calkulator-zakat/kalkulator-fidyah/" style="font-weight: 600;" target="_blank">FIDYAH</a>
                            </div>
                    </div>
                     * 
                     */
                    ?>
                    <div class="smalltxt">
                        <label class="checkbox-inline"><input onClick="$('#tbl_donation_2').toggle(700);" type="checkbox" id="showhide_channel" name="showhide_channel" value="1" required> <p> View GRAND TOTAL donation amount <span style="font-size:10px">(after including relevant payment gateway fee)</span>.</p></label>
                    </div>



                <table id="tbl_donation_2" class="table table-striped table-condensed" style="display:none">
                    <tr>
                        <th colspan="4" class="text-center">CHANNEL FEE<span id="helpBlock" class="help-block">(Amount payable to payment gateway)</span></th>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-center" style="border-top:none">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="row">
                                        <p class="lead">Credit / Debit Card<br /><small>(1.7%)</small></p>
                                        <div class="form-group input-group input-group-sm">
                                            <span class="input-group-addon alert-info"><b>RM</b></span>
                                            <input type="text" class="form-control text-right bold" id="txt_channel_fee_credit" name="txt_channel_fee_credit" value="0.00" readonly required>
                                        </div>
                                        <div style="display: none;" class="form-group input-group input-group-sm" data-toggle="popover" data-trigger="hover" data-content="Channel fee GST">
                                            <span class="input-group-addon alert-warning"><b>GST (6%)</b></span>
                                            <input type="text" class="form-control text-right" id="txt_channel_fee_credit_gst" name="txt_channel_fee_credit_gst" value="0.00" readonly required>
                                        </div>
                                        <p class="lead" style="border-bottom: 4px double #ddd;"><b>GRAND TOTAL</b></p>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon alert-info"><b>RM</b></span>
                                            <input type="text" class="form-control text-right" id="txt_grand_total_amount_credit" name="txt_grand_total_amount_credit" value="0.00" readonly required>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <p class="lead"><strong>- OR -</strong></p>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="row">
                                            
                                            <p class="lead">Online Banking<br /><small>(RM 0.60 or 1.7%)</small></p>
                                            <div class="form-group input-group input-group-sm">
                                                <span class="input-group-addon alert-info"><b>RM</b></span>
                                                <input type="text" class="form-control text-right bold" id="txt_channel_fee_others" name="txt_channel_fee_others" value="0.00" readonly required>
                                            </div>
                                            <div style="display: none;" class="form-group input-group input-group-sm">
                                                <span class="input-group-addon alert-warning"><b>GST (6%)</b></span>
                                                <input type="text" class="form-control text-right" id="txt_channel_fee_others_gst" name="txt_channel_fee_others_gst" value="0.00" readonly required>
                                            </div>
                                            <p class="lead" style="border-bottom: 4px double #ddd;"><b>GRAND TOTAL</b></p>
                                            <div class="form-group input-group">
                                                <span class="input-group-addon alert-info"><b>RM</b></span>
                                                <input type="text" class="form-control text-right" id="txt_grand_total_amount_others" name="txt_grand_total_amount_others" value="0.00" readonly required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
    </div>
    <div class="don-contnr">
            
            <div class="page-header don-sec-head">
                <h4 class="centeralize">STEP 3: YOUR INFO</h4>
            </div>

            <div class="clearfix">        
                <div id="div_chk_contact">
                <input type="checkbox" id="contact" class="contact chb" name="contact" value="conDetails"> <b class="padleft10">My Contact Details</b><span style="padding-left: 14px;
                                                                                                                                                         ">(Receipt given)</span><br>
                </div>
                <div id="div_chk_unknown">
                <input type="checkbox"  name="contact" value="unknown" class="chb" checked id="unknown"> <b class="padleft10">Anonymous/Unknown</b><span style="padding-left: 14px;
                                                                                                                              ">(<span style="color:rgba(255,0,0,1);">No</span> receipt given</span>)</span>
                </div>
            </div>

            <div class="contactDetails" id="detailsbox">      
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="txt_fullname">Full Name <sup><span class="text-danger glyphicon glyphicon-asterisk"></span></sup></label>
                            <input type="text" class="form-control input-sm" id="txt_fullname" name="txt_fullname" placeholder="E.g.: Muhammad bin Abdullah" required>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label  for="txt_nric">NRIC/Passport Number <sup><span class="text-danger glyphicon glyphicon-asterisk"></span></sup></label>
                            <input name="txt_nric" type="text" required class="form-control input-sm" id="txt_nric" placeholder="E.g.: 880112112233" maxlength="16" data-toggle="popover" data-content="Required by LHDN">
                        </div>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label  for="txt_contact_number">Contact Number <sup><span class="text-danger glyphicon glyphicon-asterisk"></span></sup></label>
                            <input type="tel" class="form-control input-sm" id="txt_contact_number" name="txt_contact_number" placeholder="E.g.: +060137329929" required min="7" max="16" maxlength="16">
                        </div>
                    </div>  
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label  for="txt_email">Email <sup><span class="text-danger glyphicon glyphicon-asterisk"></span></sup></label>
                            <input type="email" class="form-control input-sm" id="txt_email" name="txt_email" placeholder="E.g.: yourname@gmail.com" required>
                        </div>
                    </div>
                </div>
                <div class="row"> 

                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label  for="txt_address1">Mailling Address <sup><span class="text-danger glyphicon glyphicon-asterisk"></span></sup></label>
                            <input type="text" class="form-control input-sm" id="txt_address1" name="txt_address1" placeholder="E.g.: A-05-1, Paragon Point, Seksyen 9,Jalan Medan PB5," required>
                        </div>
                    </div>
                </div>

                <div class="row" style="display:none;"> 

                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label  for="txt_country">Country <sup><span class="text-danger glyphicon glyphicon-asterisk"></span></sup></label>
                            <input type="text" class="form-control input-sm" id="txt_country" name="txt_country" placeholder="E.g.: Malaysia" required value="Malaysia">
                        </div>
                    </div>
                </div>
                <div class="row"  style="display:none;">
                    <div class="col-md-12 col-lg-12 col-sm-12">

                        <div class="page-header">
                            <h4><strong>Company Donation</strong></h4>
                        </div>
                        <div class="checkbox">


                            <div class="form-group">
                                <label class="pad0" for="txt_coregnumber"><h5>Co. Reg. Number</h5></label>
                                <input type="text" class="form-control input-sm" id="txt_coregnumber" name="txt_coregnumber" placeholder="E.g.: 6523422447354-W">
                            </div>
                        </div> 
                    </div>
                </div> 
                <div id="penamaRows" style="display:none">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12">

                            <div class="page-header">
                                                            <!--<h4><strong>Company Donation</strong></h4>-->
                            </div>
                            <p style="font-size:14px; font-weight:300;"><span style="color:#F00;">*</span>Saya mewakilkan kepada Islamic Relief Malaysia atau wakilnya untuk menyempurnakan ibadah QURBAN bagi diri saya / penama-penama dibawah untuk tahun ini kerana Allah SWT. Saya juga mengizinkan agar sebahagian dari duit tersebut digunakan sebagai kos operasi untuk IRM melaksanakan ibadah ini.</p>
                        </div>
                    </div> 
                    <div class="row" >
                        <div class="col-md-12 col-lg-12 col-sm-12">
                            <div class="form-group">
                                <label  for="txt_contact_number">Penama <sup><span class="text-danger glyphicon glyphicon-asterisk"></span></sup></label>


                                <div id="itemsPenama">
                                    <div><input type="text" name="Penama[]"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-12 col-lg-12 col-sm-12">
                            <div class="form-group" style="clear:both;">
                                <div id="addPenama">Penama <span class="text-danger glyphicon glyphicon-plus-sign"></span></div>
                            </div>
                        </div>
                    </div>  
                </div>        
            </div>  	      	


    </div> 
        
    <div class="don-contnr">
                <div class="page-header don-sec-head">
                    <h4 class="centeralize">STEP 4: PAYMENT METHOD</h4>
                </div>
                <div class="smalltxt">
                    <label class="checkbox-inline"><input type="checkbox" id="txt_disclaimer" name="txt_disclaimer" value="1" required> <p> I've read and accept the <a href="https://islamic-relief.org.my/terms-condition" target="_blank">terms &amp; conditions</a>.</p></label>
                </div>
                <br>


        <p class="smalltxt">
            <strong style="color:#7e287d;">Secure Online Payment by MOLPay</strong>
            <br />
            Please select a payment type from below to proceed for payment.
        </p>
        <p class="text-center">
            <span class="label label-danger"><i class="fa fa-exclamation-triangle fa-lg"></i> Please <b>turn off</b> pop-up blocker or <b>allow</b> pop-up for this website before click below method.</span>
        </p>
        <div class="row methods">
            <input type="hidden" name="txt_payment_method_id" id="txt_payment_method_id" value="" >
    <?php
    $sspm = "/* " . $mod_config['document_root'] . "online-donation.php [" . __LINE__ . "] */ "
            . "SELECT payment_method_id, "
            . "	payment_method_name, "
            . "	payment_method_value, "
            . "	payment_method_rename "
            . "  FROM " . $db_config['t_payment_method']
            . " WHERE payment_method_status IN ('1') "
            . "   AND payment_method_deleted IN ('0') "
            . "   AND payment_method_option IN ('Online') "
            . " ORDER BY payment_method_position ASC ";
    $rsspm = $db->sql_query($sspm) or $db->sql_error($sspm);
    $payment_method = array();
    while ($rwspm = $db->sql_fetchrow($rsspm))
        $payment_method[] = $rwspm;
    foreach ($payment_method As $k => $v) {
        ?>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 marginbttm text-center <?php echo($v['payment_method_value']=='credit'? 'creditpaymentmethods': 'otherpaymentmethods');?>">
                    <label class="hand" for="payment_options_<?= $v['payment_method_id'] ?>"><img src="<?= $sys_config['images_path'] ?>payment-method/<?= $v['payment_method_rename'] ?>" title="<?= $v['payment_method_name'] ?>" /></label>
                    <br />
                    <input type="radio" name="payment_options" id="payment_options_<?= $v['payment_method_id'] ?>" value="<?= $v['payment_method_value'] ?>" required/>
                </div>
    <?php } ?>
        </div>
        </div>
    </form>
    <!--<div class="help-block text-center">
            Note: Islamic Relief is committed to managing the resources entrusted to us in a transparent and responsible manner.
            This includes ensuring specified funds for countries are spent accordingly.<br />
            However, should Islamic Relief receive funds which, for various reasons, are not eligible for the designated programs, donations will be allocated towards areas most needed to safeguard other vulnerable communities.
    </div>-->
    </div>
    </div>  
     <div class="help-block text-center footer-place">
       Copyrights © 2019 Islamic Relief Malaysia All rights reserved.
    </div>
    <script>
        $(document).ready(function() {
            //when the Add Field button is clicked
            $("#addPenama").click(function(e) {
                //Append a new row of code to the "#items" div
                $("#itemsPenama").append('<div><input name="Penama[]" type="text" /><button class="deletePenama"><span class="text-danger glyphicon glyphicon-remove-sign"></span></button></div>');
            });
            $("body").on("click", ".deletePenama", function(e) {
                $(this).parent("div").remove();
            });
            /*
             * Declaration Parameter.
             */
            var i = 2;
            // Reset checked status for radio and checkbox.
    //	$('input[type=radio], input[type=checkbox]').prop("checked", false);

            /*
             * fancybox
             */
            $(".fancybox").fancybox({});

            //Input mask - Input helper
            /*	var txx = "+999999999999?9";
             if($("#txt_contact_number").val().length>=7) {
             txx = "+";
             for(i=0; i==$("#txt_contact_number").val().length; i++){
             txx += "9";
             }
             txx = "?9";
             }
             $("#txt_contact_number").mask(txx,{placeholder:"X"});
             */
            $('input[name="txt_amount[]"]').number(true, 2, ".", "");

            /*
             * Bind on click event to class addRow.
             */
            $(".addRow").click(function() {
                var tbl_id = $(this).attr('name');
                $("#" + tbl_id + " tbody tr:last").clone().find("input, select, i").each(function() {
                    if ($(this).is('input')) {
                        $(this).attr({
                            'id': function(_, id) {
                                return id.substring(0, id.length - 1) + i
                            },
                        });
                        if ($(this).attr("name") == "txt_amount[]")
                            $(this).val('0.00').number(true, 2, ".", "").keyup(recalculate_totalAmt);
                        else if ($(this).attr("name") == "txt_quantity[]")
                        {
                            $(this).val('1').keyup(function() {
                                var rowid = this.id.replace("txt_quantity_", "");
                                amount = document.getElementById('txt_amount_' + rowid);
                                peritems_amount = document.getElementById('txt_amount_peritems_' + rowid);
                                amount.value = parseFloat(this.value * peritems_amount.value).toFixed(2);
                                recalculate_totalAmt();
                            });
                        }
                    } else if ($(this).is('select')) {
                        $(this).attr({
                            'id': function(_, id) {
                                return id.substring(0, id.length - 1) + i
                            },
                        }).val('').on("change", designation_onchange);
                    } else if ($(this).is('i')) {
                        $(this).removeClass('sr-only').on("click", rmRow);
                    }
                }).end().appendTo("#" + tbl_id);
                i++;
                $('[name="txt_amount[]"]').keyup(recalculate_totalAmt);
                $('[name="txt_quantity[]"]').keyup(function() {
                    var rowid = this.id.replace("txt_quantity_", "");
                    amount = document.getElementById('txt_amount_' + rowid);
                    peritems_amount = document.getElementById('txt_amount_peritems_' + rowid);
                    amount.value = parseFloat(this.value * peritems_amount.value).toFixed(2);
                    recalculate_totalAmt();
                });
                recalculate_totalAmt();
            });

            /*
             * Function to remove Row.
             */
            var rmRow = function() {
                $(this).closest('tr').remove();
                recalculate_totalAmt();
            };

            /*
             * Bind on click event to class removeRow.
             */
            $(".removeRow").on("click", rmRow);

            $('#four-items select').on("change", function() {
                var strAmount = "0.00";// this.options[this.selectedIndex].getAttribute("data-amount");
                var rowid = 1;
                document.getElementById("txt_designation_" + rowid).value = this.value;
                if (parseFloat(strAmount) > 0)
                {
                    document.getElementById('txt_amount_peritems_' + rowid).value = strAmount;
                    document.getElementById('txt_amount_' + rowid).value = strAmount;
                    $('input#txt_quantity_' + rowid).prop("disabled", false).val(1);
                }
                else
                {
                    document.getElementById('txt_amount_peritems_' + rowid).value = "";
                    document.getElementById('txt_amount_' + rowid).value = "0.00";
                    $('input#txt_quantity_' + rowid).prop("disabled", true).val(1);
                }
                recalculate_totalAmt();
                /*
                 document.getElementById("txt_designation_1").value = this.value;
                 document.getElementById("txt_designation_1").focus();
                 */
                this.value = "";
            });

            /*
             * Calculate total amount
             */
            var recalculate_totalAmt = function() {
                var total_amt = document.getElementById('txt_sub_total_amount');
                var total = 0;
                $('[name="txt_amount[]"]').each(function() {
                    if (this.value == '')
                        this.value = 0.00;
                    total = parseFloat(total) + parseFloat(this.value);
                });
                total_amt.value = parseFloat(total).toFixed(2);
                recalculate_channelfee_credit(total_amt.value);
                recalculate_channelfee_others(total_amt.value);
            }
            recalculate_totalAmt();

            /*
             * Calculate Channel Fee Credit
             */
            function recalculate_channelfee_credit(sub_amt) {
                var gst_rate = parseFloat(0.06);
                var charges_rate = parseFloat(0.017);//parseFloat(0.028);
                var channel_fee = parseFloat(sub_amt) * charges_rate;
                var channel_fee_gst = parseFloat(channel_fee) * gst_rate;
                //var grand_total = parseFloat(sub_amt) + channel_fee + channel_fee_gst;
    		var grand_total = parseFloat(sub_amt) + channel_fee;
    		console.log( "grand_total= " + grand_total );

                document.getElementById('txt_channel_fee_credit').value = channel_fee.toFixed(2);
                document.getElementById('txt_channel_fee_credit_gst').value = channel_fee_gst.toFixed(2);
                document.getElementById('txt_grand_total_amount_credit').value = grand_total.toFixed(2);
            }

            /*
             * Calculate Channel Fee Credit
             */
            function recalculate_channelfee_others(sub_amt) {
                var gst_rate = parseFloat(0.06);
                var charges_rate = parseFloat(0.017);//parseFloat(0.022);
                var channel_fee = parseFloat(sub_amt) * charges_rate;
                channel_fee = (channel_fee > 0.6) ? channel_fee : 0.6;
                var channel_fee_gst = parseFloat(channel_fee) * gst_rate;
                //var grand_total = parseFloat(sub_amt) + channel_fee + channel_fee_gst;
                var grand_total = parseFloat(sub_amt) + channel_fee;
    		console.log( "grand_total= " + grand_total );
                
                document.getElementById('txt_channel_fee_others').value = channel_fee.toFixed(2);
                document.getElementById('txt_channel_fee_others_gst').value = channel_fee_gst.toFixed(2);
                document.getElementById('txt_grand_total_amount_others').value = grand_total.toFixed(2);
            }

            $('[name="txt_amount[]"]').keyup(recalculate_totalAmt);
            $('[name="txt_quantity[]"]').keyup(function() {
                var rowid = this.id.replace("txt_quantity_", "");
                amount = document.getElementById('txt_amount_' + rowid);
                peritems_amount = document.getElementById('txt_amount_peritems_' + rowid);
                amount.value = parseFloat(this.value * peritems_amount.value).toFixed(2);
                recalculate_totalAmt();
            });

            $('#txt_corporate').on("change", isCorporate).trigger("change");

            var designation_onchange = function() {
                var strAmount = "0.00";// this.options[this.selectedIndex].getAttribute("data-amount");
                var rowid = this.id.replace("txt_designation_", "");
                if (parseFloat(strAmount) > 0)
                {
                    document.getElementById('txt_amount_peritems_' + rowid).value = strAmount;
                    document.getElementById('txt_amount_' + rowid).value = strAmount;
                    $('input#txt_quantity_' + rowid).prop("disabled", false).val(1);
                }
                else
                {
                    document.getElementById('txt_amount_peritems_' + rowid).value = "";
                    document.getElementById('txt_amount_' + rowid).value = "0.00";
                    $('input#txt_quantity_' + rowid).prop("disabled", true).val(1);
                }
                recalculate_totalAmt();
            };
            $('select[name="txt_designation[]"]').change(designation_onchange).trigger("change");

            $('input[name=payment_options]').on('click', function() {
                if (!fn_onsubmit())
                    return false;
                var pmethod_id = document.getElementById('txt_payment_method_id');
                pmethod_id.value = this.id.replace("payment_options_", "");
                var $myForm = $(this).closest('form');
                //console.log( $myForm[0].checkValidity() );
                //if ( $myForm[0].checkValidity() ) {
                $myForm.trigger("submit");
                //}
                //else
                //	$myForm.trigger("onsubmit");
                return false
            });

        });
        function checkPassword(str)
        {
            // at least one number, one lowercase and one uppercase letter
            // at least six characters that are letters, numbers or the underscore
            var re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
            return re.test(str);
        }
        function fn_onsubmit()
        {
            var regex_aphabetsNspaceOnly = /^[a-zA-Z ]*$/; // alphabets and spaces only
            var regex_alphanumericOnly = /^[a-z0-9]+$/i; // alphanumeric only
            var unknown = document.getElementById("unknown");
            if (!unknown.checked) {
                var fullname = document.getElementById("txt_fullname");
                if (fullname.value.length < 5)
                {
                    alert('Please fill in your full name.');
                    fullname.select();
                    return false;
                }
                if (!regex_aphabetsNspaceOnly.test(fullname.value))
                {
                    alert('Invalid full name value. Only alphabets and space accepted.');
                    fullname.select();
                    return false;
                }
                if (fullname.value.length > 70)
                {
                    alert('Maximum character exceed 70.');
                    fullname.select();
                    return false;
                }
                var nric = document.getElementById("txt_nric");
                if (nric.value.length < 5)
                {
                    alert('Please fill in your identity card (NRIC) or passport number.');
                    nric.select();
                    return false;
                }
                if (!regex_alphanumericOnly.test(nric.value))
                {
                    alert('Invalid NRIC/Passport Number. Only alphanumeric character without dash(-) and space.');
                    nric.select();
                    return false;
                }
                if (nric.value.length > 16)
                {
                    alert('Maximum character exceed 16.');
                    nric.select();
                    return false;
                }
                var contact_number = document.getElementById("txt_contact_number");
                if (contact_number.value.length < 7)
                {
                    alert('Please fill in your contact number .');
                    contact_number.select();
                    return false;
                }
                if (contact_number.value.length > 16) {
                    alert('Invalid contact number.');
                    contact_number.select();
                    return false;
                }
                /*
                 var regex_phoneno = /^\+?(\d)$/;
                 if( !regex_phoneno.test(contact_number.value) )
                 {
                 alert('Invalid contact number value.');
                 contact_number.select();
                 return false;
                 }
                 */
                var email = document.getElementById("txt_email");
                if (email.value.length < 5)
                {
                    alert('Please fill in your email.');
                    email.select();
                    return false;
                }
                var regex_email = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                if (!regex_email.test(email.value))
                {
                    alert('Invalid email address.');
                    email.select();
                    return false;
                }
                var address1 = document.getElementById("txt_address1");
                if (address1.value.length < 5)
                {
                    alert('Please fill in your address.');
                    address1.select();
                    return false;
                }
                var regex_address1 = /^[0-9a-zA-Z -\/,.]*$/;
                if (!regex_address1.test(address1.value))
                {
                    alert('Invalid address value. Alphanumeric character only.');
                    address1.select();
                    return false;
                }
                /*var address2 = document.getElementById("txt_address2");
                 if( address2.value.length > 0 )
                 {
                 var regex_address2 = /^[0-9a-zA-Z -\/,.]*$/;
                 if( !regex_address2.test(address2.value) )
                 {
                 alert('Invalid address value. Alphanumeric character only.');
                 address2.select();
                 return false;
                 }
                 }
                 var postcode = document.getElementById("txt_postcode");
                 if( postcode.value.length < 5 )
                 {
                 alert('Please fill in your postcode.');
                 postcode.select();
                 return false;
                 }
                 var regex_postcode = /^[0-9]+$/;
                 if( !regex_postcode.test(postcode.value) )
                 {
                 alert('Invalid postcode value. Numeric character only.');
                 address1.select();
                 return false;
                 }*/
                var country = document.getElementById("txt_country");
                if (country.value.length < 5)
                {
                    alert('Please fill in your country name.');
                    country.select();
                    return false;
                }
                if (!regex_aphabetsNspaceOnly.test(country.value))
                {
                    alert('Invalid country value. Only alphabets and space accepted.');
                    country.select();
                    return false;
                }
                /*var newpass = document.getElementById('txt_new_password');
                 if( newpass.value.length > 0 )
                 {
                 if(!checkPassword(newpass.value)) {
                 alert("Password must content at least one number, one lowercase, one uppercase letter and eight character length");
                 newpass.select();
                 return false;
                 }
                 var retype_pass = document.getElementById('txt_retype_password');
                 if( retype_pass.value.length == 0 )
                 {
                 alert("Please retype your new password again.");
                 retype_pass.select();
                 return false;
                 }
                 if( newpass.value != retype_pass.value )
                 {
                 alert("Your retype password unmatch.");
                 retype_pass.select();
                 return false;
                 }
                 }
                 var designation_1 = document.getElementById("txt_designation_1");
                 if( designation_1.value.length == 0 )
                 {
                 alert('Please select designation.');
                 designation_1.focus();
                 return false;
                 }*/
            }
            var subtotal_amount = document.getElementById("txt_sub_total_amount");
            var total_amount_credit = document.getElementById("txt_grand_total_amount_credit");
            var total_amount_others = document.getElementById("txt_grand_total_amount_others");
            if (1.01 > parseFloat(subtotal_amount.value))
            {
                alert('Sub Total amount must more than RM 1.00. Please fill in donation summary.');
                subtotal_amount.focus();
                return false;
            }
            if ((1.01 > parseFloat(total_amount_credit.value)) && (1.01 > parseFloat(total_amount_others.value)))
            {
                alert('Total amount must more than RM 1.00. Please fill in donation summary.');
                subtotal_amount.focus();
                return false;
            }
            /*	var corporate = document.getElementById("txt_corporate");
             if( corporate.checked )
             {
             var coregnumber = document.getElementById("txt_coregnumber");
             if( coregnumber.value.length < 5 )
             {
             alert('Please fill in Company Registration Number.');
             coregnumber.select();
             return false;
             }
             var regex_coregnumber = /^[0-9a-zA-Z-]*$/;
             if( !regex_coregnumber.test(coregnumber.value) )
             {
             alert("Alphanumeric and dash character only.")
             coregnumber.select();
             return false;
             }
             }
             var note = document.getElementById("txt_note");
             if( note.value.length > 1000 )
             {
             alert("Maximum 1000 character limit exceeded.")
             note.select();
             return false;
             }
             if( note.value.length > 0 )
             {
             var regex_note = /^[0-9a-zA-Z ]*$/;
             if( !regex_note.test(note.value) )
             {
             alert("Alphanumeric character only.")
             note.select();
             return false;
             }
             }*/
            var disclaimer = document.getElementById("txt_disclaimer");
            if (!disclaimer.checked)
            {
                alert('Please read and accept the terms & conditions.');
                disclaimer.focus();
                return false;
            }
            return true;
        }
        function isCorporate( ) {
            $('#txt_coregnumber').prop("required", this.checked);
            if (this.checked)
                $('[for=txt_coregnumber]').append(" <sup><span class='text-danger glyphicon glyphicon-asterisk'></span></sup>");
            else
                $('[for=txt_coregnumber] sup').remove();
        }
    </script>
    <?php
//	require($sys_config['includes_path']."footer-place.php");
    //func_footer();
} elseif ($str_form_action == "frm_online_submit") {
    if (!isset($_POST['unknown']) || $_POST['unknown'] == '') {

        if (strlen(trim($_POST['txt_fullname'])) < 5) {
            $params = array(
                'status' => false, // Set False to show an error message.
                'error_code' => "IR04",
                'error_desc' => "Please fill in your full name.",
                'failureurl' => $mod_config['self']
            );
            echo json_encode($params);
            exit();
        }
        if (ctype_alpha(str_replace(' ', '', $_POST['txt_fullname'])) === false) {
            $params = array(
                'status' => false, // Set False to show an error message.
                'error_code' => "IR04",
                'error_desc' => "Full name must contain letters and spaces only.",
                'failureurl' => $mod_config['self']
            );
            echo json_encode($params);
            exit();
        }
        if (strlen(trim($_POST['txt_nric'])) < 5) {
            $params = array(
                'status' => false, // Set False to show an error message.
                'error_code' => "IR04",
                'error_desc' => "Please fill in your identity card (NRIC) or passport number.",
                'failureurl' => $mod_config['self']
            );
            echo json_encode($params);
            exit();
        }
        if (ctype_alnum($_POST['txt_nric']) === false) {
            $params = array(
                'status' => false, // Set False to show an error message.
                'error_code' => "IR04",
                'error_desc' => "NRIC or passport number must contain letters and number only.",
                'failureurl' => $mod_config['self']
            );
            echo json_encode($params);
            exit();
        }
        if (strlen(trim($_POST['txt_nric'])) > 12) {
            $params = array(
                'status' => false, // Set False to show an error message.
                'error_code' => "IR04",
                'error_desc' => "NRIC or passport number length must less than 12 characters.",
                'failureurl' => $mod_config['self']
            );
            echo json_encode($params);
            exit();
        }
        if (strlen(trim($_POST['txt_contact_number'])) < 7 || strlen(trim($_POST['txt_contact_number'])) > 12) {
            $params = array(
                'status' => false, // Set False to show an error message.
                'error_code' => "IR04",
                'error_desc' => "Please fill in your contact number.",
                'failureurl' => $mod_config['self']
            );
            echo json_encode($params);
            exit();
        }
        if (strlen(trim($_POST['txt_email'])) < 5) {
            $params = array(
                'status' => false, // Set False to show an error message.
                'error_code' => "IR04",
                'error_desc' => "Please fill in your email.",
                'failureurl' => $mod_config['self']
            );
            echo json_encode($params);
            exit();
        }
        if (!filter_var($_POST['txt_email'], FILTER_VALIDATE_EMAIL) !== false) {
            $params = array(
                'status' => false, // Set False to show an error message.
                'error_code' => "IR04",
                'error_desc' => "Email address not valid.",
                'failureurl' => $mod_config['self']
            );
            echo json_encode($params);
            exit();
        }
        if (strlen(trim($_POST['txt_address1'])) < 5) {
            $params = array(
                'status' => false, // Set False to show an error message.
                'error_code' => "IR04",
                'error_desc' => "Please fill in your address.",
                'failureurl' => $mod_config['self']
            );
            echo json_encode($params);
            exit();
        }
        $aValid = array(' ', '-', '/', ',', '.');
        if (ctype_alnum(str_replace($aValid, '', $_POST['txt_address1'])) === false) {
            $params = array(
                'status' => false, // Set False to show an error message.
                'error_code' => "IR04",
                'error_desc' => "Address 1 must contain letters, numbers and spaces only.",
                'failureurl' => $mod_config['self']
            );
            echo json_encode($params);
            exit();
        }


        if (strlen(trim($_POST['txt_country'])) < 5) {
            $params = array(
                'status' => false, // Set False to show an error message.
                'error_code' => "IR04",
                'error_desc' => "Please fill in your country name.",
                'failureurl' => $mod_config['self']
            );
            echo json_encode($params);
            exit();
        }
        if (ctype_alpha(str_replace(' ', '', $_POST['txt_country'])) === false) {
            $params = array(
                'status' => false, // Set False to show an error message.
                'error_code' => "IR04",
                'error_desc' => "Country must contain letters and spaces only.",
                'failureurl' => $mod_config['self']
            );
            echo json_encode($params);
            exit();
        }
        if (isset($_POST['txt_corporate'])) {
            if (strlen(trim($_POST['txt_coregnumber'])) < 5) {
                $params = array(
                    'status' => false, // Set False to show an error message.
                    'error_code' => "IR04",
                    'error_desc' => "Please fill in Company Registration Number.",
                    'failureurl' => $mod_config['self']
                );
                echo json_encode($params);
                exit();
            }
            if (ctype_alnum(str_replace('-', '', $_POST['txt_coregnumber'])) === false) {
                $params = array(
                    'status' => false, // Set False to show an error message.
                    'error_code' => "IR04",
                    'error_desc' => "Company Registration Number must contain letters, numbers and dash only.",
                    'failureurl' => $mod_config['self']
                );
                echo json_encode($params);
                exit();
            }
        }
    } {

        $_POST['txt_fullname'] = 'Anonymous Donor';
        $_POST['txt_nric'] = '123456789012';
        $_POST['txt_contact_number'] = '123456789012';
        $_POST['txt_email'] = 'irmadmin@gmail.com';
        $_POST['txt_country'] = 'Anonymous Country';
        $_POST['txt_address1'] = 'Anonymous Address';
    }
    if (1.01 > (float) $_POST['txt_sub_total_amount']) {
        $params = array(
            'status' => false, // Set False to show an error message.
            'error_code' => "IR04",
            'error_desc' => "Sub total amount must more than RM 1.00. Please fill in donation summary.",
            'failureurl' => $mod_config['self']
        );
        echo json_encode($params);
        exit();
    }


    if (isset($_POST['payment_options']) && $_POST['payment_options'] != "") {
        $ssd = "/* " . $mod_config['document_root'] . "four-items.php [" . __LINE__ . "] */ "
                . "SELECT designation_id, "
                . "	designation_name, "
                . "	designation_amount "
                . "  FROM " . $db_config['t_designation']
                . " WHERE designation_status IN ('1') "
                . "   AND designation_deleted IN ('0') ";
        $rssd = $db->sql_query($ssd) or $db->sql_error($ssd);
        $array_designations = array();
        while ($rwsd = $db->sql_fetchrow($rssd))
            $array_designations[$rwsd['designation_id']] = $rwsd;

        $merchantid = $sys_config['MOLPay_merchantID']; // Change to your merchant ID
        $vkey = $sys_config['MOLPay_verifykey']; // Change to your verify key

        $sidi = "/* " . $mod_config['document_root'] . "online-donation.php [" . __LINE__ . "] */ "
                . "INSERT INTO " . $db_config['t_donor_info'] . " ( "
                . "	date_create, "
                . "	donor_info_fullname, "
                . "	donor_info_nric, "
                . "	donor_info_contactno, "
                . "	donor_info_email, "
                . ((strlen($_POST['txt_new_password']) > 7) ? "	donor_info_password, " : "" )
                . "	donor_info_address_1, "
                . "	donor_info_address_2, "
                . "	donor_info_postcode, "
                . "	donor_info_country, "
                . "	donor_penama "
                . ") VALUES ("
                . "	NOW(), "
                . "	'" . mysql_real_escape_string($_POST['txt_fullname']) . "', "
                . "	'" . mysql_real_escape_string($_POST['txt_nric']) . "', "
                . "	'" . mysql_real_escape_string($_POST['txt_contact_number']) . "', "
                . "	'" . mysql_real_escape_string($_POST['txt_email']) . "', "
                . ((strlen($_POST['txt_new_password']) > 7) ? "'" . md5($_POST['txt_new_password']) . "'," : "" )
                . "	'" . mysql_real_escape_string($_POST['txt_address1']) . "', "
                . "	'" . mysql_real_escape_string($_POST['txt_address2']) . "', "
                . "	'" . mysql_real_escape_string($_POST['txt_postcode']) . "', "
                . "	'" . mysql_real_escape_string($_POST['txt_country']) . "' "
                . ") ON DUPLICATE KEY UPDATE "
                . "	donor_info_fullname = '" . mysql_real_escape_string($_POST['txt_fullname']) . "', "
                . "	donor_info_nric = '" . mysql_real_escape_string($_POST['txt_nric']) . "', "
                . "	donor_info_contactno = '" . mysql_real_escape_string($_POST['txt_contact_number']) . "', "
                . "	donor_info_address_1 = '" . mysql_real_escape_string($_POST['txt_address1']) . "', "
                . "	donor_info_address_2 = '" . mysql_real_escape_string($_POST['txt_address2']) . "', "
                . "	donor_info_postcode = '" . mysql_real_escape_string($_POST['txt_postcode']) . "', "
                . ((strlen($_POST['txt_new_password']) > 7) ? "	donor_info_password = '" . md5($_POST['txt_new_password']) . "', " : "" )
                . "	donor_info_country = '" . mysql_real_escape_string($_POST['txt_country']) . "', "
                . "	donor_penama = '" . mysql_real_escape_string(implode(',', $_POST['Penama'])) . "' ";
        //echo $sidi;
        $rsidi = $db->sql_query($sidi) or $db->sql_error($sidi);
        if (!$rsidi) {
            $params = array(
                'status' => false, // Set False to show an error message.
                'error_code' => "IR01",
                'error_desc' => "Failed to process your request. Kindly try again later.",
                'failureurl' => $mod_config['self']
            );
            echo json_encode($params);
            exit();
        }
        $donor_insert_id = $db->sql_nextid();
        $donor_id = $donor_insert_id;
        if (($donor_id == 0) && ((int) $_POST['txt_donor_id'] > 0))
            $donor_id = $_POST['txt_donor_id'];
        else {
            $ssdi = "/* " . $mod_config['document_root'] . "online-donation.php [" . __LINE__ . "] */ "
                    . "SELECT donor_info_id "
                    . "  FROM " . $db_config['t_donor_info']
                    . " WHERE donor_info_email ='" . $_POST['txt_email'] . "'"
                    . " LIMIT 1 "
                    . "  LOCK IN SHARE MODE ";  // read the lastest updated value
            // query from database using database object
            $rssdi = $db->sql_query($ssdi) or $db->sql_error($ssdi);
            if (!$rssdi || ($db->sql_numrows($rssdi) <= 0)) {
                $params = array(
                    'status' => false, // Set False to show an error message.
                    'error_code' => "IR02",
                    'error_desc' => "Failed to process your request. Kindly try again later.",
                    'failureurl' => $mod_config['self']
                );
                echo json_encode($params);
                exit();
            }
            $rwsdi = $db->sql_fetchrow($rssdi);
            $donor_id = $rwsdi['donor_info_id'];
        }
        $_POST['txt_sub_total_amount'] = ($_POST['txt_sub_total_amount'] == '') ? 0 : $_POST['txt_sub_total_amount'];
        $sip = "/* " . $mod_config['document_root'] . "online-donation.php [" . __LINE__ . "] */ "
                . "INSERT INTO " . $db_config['t_payment'] . " ("
                . "	donor_info_id, "
                . "	payment_type, "
                . "	payment_method_id, "
                . "	payment_online_status, "
                . "	payment_online_cur_subtotal_amt, "
                . "	payment_online_subtotal_amt, "
                . "	payment_online_cur_channelfee_amt, "
                . "	payment_online_channelfee_amt, "
                . "	payment_online_cur_channelgst_amt, "
                . "	payment_online_channelgst_amt, "
                . "	payment_online_curamount, "
                . "	payment_online_totalamount, "
                . "	payment_history "
                . ") VALUES ("
                . $donor_id . ", "
                . "	'Online', "
                . "	'" . $_POST['txt_payment_method_id'] . "', "
                . "	'Pending', "
                . "	'RM', "
                . $_POST['txt_sub_total_amount'] . ", "
                . "	'RM', "
                . ( ($_POST['payment_options'] == "credit3" || $_POST['payment_options'] == "credit") ? $_POST['txt_channel_fee_credit'] : $_POST['txt_channel_fee_others'] ) . ", "
                . "	'RM', "
                . ( ($_POST['payment_options'] == "credit3" || $_POST['payment_options'] == "credit") ? $_POST['txt_channel_fee_credit_gst'] : $_POST['txt_channel_fee_others_gst'] ) . ", "
                . "	'RM', "
                . ( ($_POST['payment_options'] == "credit3" || $_POST['payment_options'] == "credit") ? $_POST['txt_grand_total_amount_credit'] : $_POST['txt_grand_total_amount_others'] ) . ", "
                . " '" . date("Y-m-d H:i:s") . " - Pending | " . $_SERVER['REMOTE_ADDR'] . ": " . $_SERVER['REMOTE_HOST'] . ": " . $_SERVER['HTTP_VIA'] . ": " . $_SERVER['HTTP_X_FORWARDED_FOR'] . ": " . $_SERVER['HTTP_REFERER'] . ": " . $_SERVER['HTTP_USER_AGENT'] . "') "
        ;
        // echo $sip;
        $rsip = $db->sql_query($sip) or $db->sql_error($sip);
        if (!$rsip) {
            $params = array(
                'status' => false, // Set False to show an error message.
                'error_code' => "IR03",
                'error_desc' => "Failed to process your request. Kindly try again later.",
                'failureurl' => $mod_config['self']
            );
            echo json_encode($params);
            exit();
        }
        $payment_id = $db->sql_nextid();
        if (isset($_POST['txt_corporate'])) {
            $siai = "/* " . $mod_config['document_root'] . "online-donation.php [" . __LINE__ . "] */ "
                    . "INSERT INTO " . $db_config['t_additional_info'] . " ("
                    . "	additional_info_co_reg_number, "
                    . "	additional_info_note, "
                    . "	payment_id "
                    . ") VALUES ("
                    . "	'" . mysql_real_escape_string($_POST['txt_coregnumber']) . "', "
                    . "	'" . mysql_real_escape_string($_POST['txt_note']) . "', "
                    . "	'" . $payment_id . "' "
                    . ")";
            $rsiai = $db->sql_query($siai) or $db->sql_error($siai);
            if (!$rsiai) {
                $params = array(
                    'status' => false, // Set False to show an error message.
                    'error_code' => "IR04",
                    'error_desc' => "Failed to process your request. Kindly try again later.",
                    'failureurl' => $mod_config['self']
                );
                echo json_encode($params);
                exit();
            }
        }

        $str_designation = array();
        foreach ($_POST['txt_designation'] As $k => $v) {
            if (empty($v))
                continue;
            $sipm = "/* " . $mod_config['document_root'] . "online-donation.php [" . __LINE__ . "] */ "
                    . "INSERT INTO " . $db_config['t_payment_summary'] . " ("
                    . "	designation_id, "
                    . ( isset($_POST['txt_quantity'][$k]) ? "	quantity, " : "" )
                    . "	amount, "
                    . "	payment_id "
                    . ") VALUE ("
                    . (int) $v . ", "
                    . ( isset($_POST['txt_quantity'][$k]) ? $_POST['txt_quantity'][$k] . ", " : "" )
                    . $_POST['txt_amount'][$k] . ", "
                    . $payment_id
                    . ")";
            $rsipm = $db->sql_query($sipm) or $db->sql_error($sipm);
            if (!$rsipm) {
                $params = array(
                    'status' => false, // Set False to show an error message.
                    'error_code' => "IR05",
                    'error_desc' => "Failed to process your request. Kindly try again later.",
                    'failureurl' => $mod_config['self']
                );
                echo json_encode($params);
                exit();
            }
            $str_designation[] = ( empty($_POST['txt_quantity'][$k]) ? "" : $_POST['txt_quantity'][$k] . "x - " ) . $array_designations[$v]['designation_name'] . " : RM " . number_format($_POST['txt_amount'][$k], 2);
        }
        $_POST['txt_new_password'] = '';
        $total_amount = ( ($_POST['payment_options'] == "credit3" || $_POST['payment_options'] == "credit") ? $_POST['txt_grand_total_amount_credit'] : $_POST['txt_grand_total_amount_others'] );
        $params = array(
            'status' => true, // Set True to proceed with MOLPay
            'mpsmerchantid' => $merchantid,
            'mpschannel' => $_POST['payment_options'],
            'mpsamount' => $total_amount,
            'mpsorderid' => $payment_id,
            'mpsbill_name' => $_POST['txt_fullname'],
            'mpsbill_email' => $_POST['txt_email'],
            'mpsbill_mobile' => $_POST['txt_contact_number'],
            'mpsbill_desc' => implode(", ", $str_designation),
            'mpscountry' => "MY",
            'mpsvcode' => md5($total_amount . $merchantid . $payment_id . $vkey),
            'mpscurrency' => "RM",
            'mpslangcode' => "en",
            'mpstimer' => 0,
            'mpsreturnurl' => $sys_config['host_name'] . $sys_config['system_url'] . "?mod=pages&opt=return_molpay" . ((strlen($_POST['txt_new_password']) > 7) ? "&irmy=" . urlencode(base64_encode($_POST['txt_new_password'])) : "" )
        );
        if (!isset($_GET['ptypee']) || $_GET['ptypee'] == '') {
            $params['mpstokenstatus'] = 1; 
        }
        /* 		if(!isset($_GET['ptypee']) || $_GET['ptypee']=='') {
          $checkSum = md5( 'T&islamicrelief&T&DEMO120&RM'.$_POST['txt_sub_total_amount'].''.$sys_config['MOLPay_verifykey']);
          $recurring_array = array(0 => 'T|islamicrelief||8221498322560790|DEMO123|RM|'.$_POST['txt_sub_total_amount'].'|5392cd35b3a0c22636f272e07a707972');

          $URL ="https://www.onlinepayment.com.my/MOLPay/API/Recurring/input.php";
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_POST , TRUE );
          curl_setopt($ch, CURLOPT_POSTFIELDS , http_build_query($recurring_array));
          curl_setopt($ch, CURLOPT_URL , $URL );
          curl_setopt($ch, CURLOPT_HEADER , TRUE );
          curl_setopt($ch, CURLINFO_HEADER_OUT , TRUE );
          curl_setopt($ch, CURLOPT_RETURNTRANSFER , TRUE );
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , FALSE);
          $result = curl_exec( $ch );
          curl_close( $ch );
          print_r($result);
          } */
    } else {
        $params = array(
            'status' => false, // Set False to show an error message.
            'error_code' => "500",
            'error_desc' => "Internal Server Error",
            'failureurl' => $mod_config['self']
        );
    }
// if(isset($_GET['ptypee']) &&$_GET['ptypee']=='onetime') {
    echo json_encode($params);
    //}
}
?>

<script>
    $(document).ready(function(e) {
        //$('select.form-control').change(function(){
		$('#sel_148').on("change", function() {
			 var isAlYateem = 0;
            var isAlQurban = 0;
			var idd = '';
            jQuery('#tbl_summary > tbody > tr').not(':first').each(function(index, element) {
				idd = $(this).attr('id').replace('row_summary_id_','');
                if (idd == '122' || idd == '123' || idd == '124' || idd == '125' || idd == '149' || idd == '150' || idd == '151' || 
				idd == '152' || idd == '153' || idd == '154' || idd == '155') {
                    isAlYateem++;
                }
                if (idd == '149' || idd == '150' || idd == '151' || idd == '152' || idd == '153' || idd == '154' || idd == '155') {
                    isAlQurban++;
                }
            });
            console.log(isAlYateem+"==="+isAlQurban);
            if (isAlYateem > 0 || isAlQurban>0) {
                $("#contact").prop("checked", true);
                $("#unknown").prop("checked", false);
                //$("#unknown").attr("disabled", true);
                $('#detailsbox').removeClass("contactDetails");
				$("#unknown").prop("disabled", true);
            }
            else
            {
                $("#unknown").prop("checked", true);
                $("#contact").prop("checked", false);
                $("#unknown").prop("disabled", false);
                $('#detailsbox').addClass("contactDetails");
            }
            if (isAlQurban > 0) {
                $('#penamaRows').fadeIn('slow');
            }
            else {
                $('#penamaRows').fadeOut('slow');
            }
		});
        $(".select-amount").on("click", ".amnt-slct, .qty-slct, .amnt-btn-c", function() {
            var isAlYateem = 0;
            var isAlQurban = 0;
			var idd = '';
            jQuery('#tbl_summary > tbody > tr').not(':first').each(function(index, element) {
				idd = $(this).attr('id').replace('row_summary_id_','');
                if (idd == '122' || idd == '123' || idd == '124' || idd == '125' || idd == '150' || idd == '151' || 
				idd == '152' || idd == '153' || idd == '154' || idd == '155') {
                    isAlYateem++;
                }
                if (idd == '150' || idd == '151' || idd == '152' || idd == '153' || idd == '154' || idd == '155' || idd == '149') {
                    isAlQurban++;
                }
            });
            console.log('Alyateem:'+isAlYateem+'===AlQurban:'+isAlQurban);
            if (isAlYateem > 0 || isAlQurban>0) {
                $("#contact").prop("checked", true);
                $("#unknown").prop("checked", false);
				$("#unknown").prop("disabled", true);
                //$("#unknown").attr("disabled", true);
                $('#detailsbox').removeClass("contactDetails");

            }
            else
            {
                $("#unknown").prop("checked", true);
                $("#contact").prop("checked", false);
                $("#unknown").prop("disabled", false);
                $('#detailsbox').addClass("contactDetails");
            }
            if (isAlQurban > 0) {
                $('#penamaRows').fadeIn('slow');
            }
            else {
                $('#penamaRows').fadeOut('slow');
            }
        });
    });

</script>