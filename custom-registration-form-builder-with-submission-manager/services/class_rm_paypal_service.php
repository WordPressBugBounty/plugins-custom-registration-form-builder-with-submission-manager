<?php

class RM_Paypal_Service implements RM_Gateway_Service
{
    public $paypal;
    public $options;
    public $paypal_email;
    public $currency;
    public $paypal_page_style;
    public $paypal_modern_method;
    public $paypal_client_id;
    
    public static $instance;
    
    
    public static function get_instance(){
        if (!empty(self::$instance)) {
            return self::$instance;
        }
       return new RM_Paypal_service();
    }
    
    function __construct() {
        require_once RM_EXTERNAL_DIR . 'PayPal/paypal.php';
        /* $this->options= new RM_Options();
        $sandbox =  $this->options->get_value_of('paypal_test_mode');
        $this->paypal_email = $this->options->get_value_of('paypal_email');
        $this->currency = $this->options->get_value_of('currency');
        $this->paypal_page_style = $this->options->get_value_of('paypal_page_style');
        $this->paypal_client_id = $this->options->get_value_of('paypal_client_id');
        $this->paypal_modern_method = $this->options->get_value_of('paypal_modern_enable'); */
        $sandbox = get_option('rm_option_paypal_test_mode');
        $this->paypal_email = get_option('rm_option_paypal_email');
        $this->currency = get_option('rm_option_currency', 'USD');
        $this->paypal_page_style = get_option('rm_option_paypal_page_style');
        $this->paypal_client_id = get_option('rm_option_paypal_client_id');
        $this->paypal_modern_method = get_option('rm_option_paypal_modern_enable');
        $this->paypal = new rm_paypal_class();
        
        if ($sandbox == 'yes')
            $this->paypal->toggle_sandbox(true);
        else
            $this->paypal->toggle_sandbox(false);
        
        if($this->paypal_modern_method == 'yes'){
            $this->paypal->toggle_modern_method(true);
        }
        else{
            $this->paypal->toggle_modern_method(false);
        }
        if($this->paypal_client_id != '' && $this->paypal_modern_method == 'yes'){
            $this->paypal->toggle_client_id($this->paypal_client_id);
        }
        $this->paypal->admin_mail = get_option('admin_email');
    }

    function getPaypal() {
        return $this->paypal;
    }

    function getOptions() {
        return $this->options;
    }

    private function has_positive_priced_billing_item($pricing_details) {
        if (empty($pricing_details->billing) || !is_array($pricing_details->billing))
            return false;

        foreach ($pricing_details->billing as $item) {
            if (isset($item->price) && floatval($item->price) > 0.0 && empty($item->zero_quantity_checkout))
                return true;
        }

        return false;
    }

    private function sanitize_payment_log_data($data) {
        if (is_array($data))
            return array_map(array($this, 'sanitize_payment_log_data'), $data);

        if (is_object($data))
            return $this->sanitize_payment_log_data(get_object_vars($data));

        return sanitize_text_field((string)$data);
    }

    private function normalize_amount($amount) {
        return number_format((float)$amount, 2, '.', '');
    }

    private function is_sdk_capture_replayed($transaction_id, $current_log_id) {
        global $wpdb;
        $table_name = RM_Table_Tech::get_table_name_for('PAYPAL_LOGS');

        $existing_log_id = $wpdb->get_var($wpdb->prepare("SELECT id FROM `$table_name` WHERE txn_id = %s AND id <> %d LIMIT 1", $transaction_id, $current_log_id));
        return !empty($existing_log_id);
    }

    function setPaypal($paypal) {
        $this->paypal = $paypal;
    }

    function setOptions($options) {
        $this->options = $options;
    }

    public function callback($payment_status,$rm_pproc_id, $sec_hash)
    {
        switch ($payment_status)
            {
                case 'success':
                    if ($rm_pproc_id)
                    {
                        $log_id = $rm_pproc_id;
                        $log = RM_DBManager::get_row('PAYPAL_LOGS', $log_id);
                        if ($log)
                        {
                            $exdata = maybe_unserialize($log->ex_data);
                            if(isset($exdata['sec_hash']))
                            {
                                if($sec_hash != $exdata['sec_hash'])
                                    return 'invalid_hash';
                            }
                            else
                            {
                                return 'invalid_hash';
                            }
                            
                            if ($log->log)
                            {
                                $paypal_log = maybe_unserialize($log->log);
                                $payment_status = isset($paypal_log['payment_status']) ? $paypal_log['payment_status'] : $log->status;
                                $user_id = isset($exdata['user_id']) ? absint($exdata['user_id']) : 0;
                                $form_id = $log->form_id;

                                if ($payment_status == 'Completed')
                                {
                                    $ffact = defined('REGMAGIC_ADDON') ? new RM_Form_Factory_Addon() : new RM_Form_Factory();
                                    $fef = $ffact->create_form($form_id);
                                    $fopt = $fef->get_form_options();
                                    if($fopt->auto_login)
                                         $_SESSION['RM_SLI_UID'] = $user_id;
                                    
                                    echo '<div id="rmform">';
                                    echo "<div class='rminfotextfront'>" . wp_kses_post((string)RM_UI_Strings::get("MSG_PAYMENT_SUCCESS")) . "</br>";
                                    echo '</div></div>';
                                    return 'success';
                                } else if ($payment_status == 'Denied' || $payment_status == 'Failed' || $payment_status == 'Refunded' || $payment_status == 'Reversed' || $payment_status == 'Voided')
                                {
                                    echo '<div id="rmform">';
                                    echo "<div class='rminfotextfront'>" . wp_kses_post((string)RM_UI_Strings::get("MSG_PAYMENT_FAILED")) . "</br>";
                                    echo '</div></div>';
                                    return 'failed';
                                } else if ($payment_status == 'In-Progress' || $payment_status == 'Pending' || $payment_status == 'Processed')
                                {
                                    echo '<div id="rmform">';
                                    echo "<div class='rminfotextfront'>" . wp_kses_post((string)RM_UI_Strings::get("MSG_PAYMENT_PENDING")) . "</br>";
                                    echo '</div></div>';
                                    return 'pending';
                                } else if ($payment_status == 'Canceled_Reversal')
                                {
                                    return 'canceled_reversal';
                                }
                            }
                        }
                    }
                    return false;

                case 'cancel':
                    echo '<div id="rmform">';
                    echo "<div class='rminfotextfront'>" . wp_kses_post((string)RM_UI_Strings::get("MSG_PAYMENT_CANCEL")) . "</br>";
                    echo '</div></div>';
                    return;

                case 'ipn':
                    if (!$this->paypal->validate_ipn())
                    {
                        return 'invalid_ipn';
                    }

                    $trasaction_id = isset($_POST["txn_id"]) ? sanitize_text_field(wp_unslash($_POST["txn_id"])) : '';
                    $payment_status = isset($_POST["payment_status"]) ? sanitize_text_field(wp_unslash($_POST["payment_status"])) : '';
                    $cstm = isset($_POST["custom"]) ? sanitize_text_field(wp_unslash($_POST["custom"])) : '';
                    $acbd = explode("|", (string)$cstm);
                    $log_entry_id = isset($acbd[0]) ? absint($acbd[0]) : 0; //$_POST["custom"];

                    if (!$log_entry_id)
                    {
                        return 'invalid_log';
                    }

                    $log = RM_DBManager::get_row('PAYPAL_LOGS', $log_entry_id);
                    if (!$log)
                    {
                        return 'invalid_log';
                    }

                    $exdata = maybe_unserialize($log->ex_data);
                    $user_id = isset($exdata['user_id']) ? absint($exdata['user_id']) : 0;
                    $log_array = maybe_serialize(array_map('sanitize_text_field', wp_unslash($_POST)));

                    $curr_date = RM_Utilities::get_current_time(); // date_i18n(get_option('date_format'));

                    RM_DBManager::update_row('PAYPAL_LOGS', $log_entry_id, array(
                        'status' => $payment_status,
                        'txn_id' => $trasaction_id,
                        'posted_date' => $curr_date,
                        'log' => $log_array), array('%s', '%s', '%s', '%s'));
                
                    if(defined('REGMAGIC_ADDON')) {
                        //$check_setting = apply_filters('rm_addon_paypal_callback',$trasaction_id);
                        $addon_service = new RM_Paypal_Service_Addon;
                        $check_setting = $addon_service->check_approval_settings($trasaction_id);
                    } else {
                        //$check_setting = $gopt->get_value_of('user_auto_approval');
                        $check_setting = "yes";
                    }

                    //IPN is valid, check payment status and process logic
                    if ($payment_status == 'Completed')
                    {
                        if ($user_id)
                        {
                            $gopt = new RM_Options;
                            if ($check_setting == "yes")
                            {
                                $user_service = new RM_User_Services();
                                $user_service->activate_user_by_id($user_id);
                            }
                        }
                        $form = new RM_Forms();
                        $form->load_from_db($log->form_id);
                        $user = $user_id ? get_user_by('ID', $user_id) : false;
                        $user_email = !empty($user) ? $user->user_email : (isset($_GET["rm_uemail"]) ? sanitize_email(wp_unslash($_GET["rm_uemail"])) : '');
                        $sub_id = !empty($log->submission_id) ? $log->submission_id : (isset($_GET["rm_subid"]) ? sanitize_text_field(wp_unslash($_GET["rm_subid"])) : '');
                        do_action('rm_payment_completed', $user_email, $form, $sub_id);
                        return 'success';
                    }
                    else if ($payment_status == 'Denied' || $payment_status == 'Failed' || $payment_status == 'Refunded' || $payment_status == 'Reversed' || $payment_status == 'Voided')
                    {
                        return 'failed';
                    } else if ($payment_status == 'In-Progress' || $payment_status == 'Pending' || $payment_status == 'Processed')
                    {
                        return 'pending';
                    } else if ($payment_status == 'Canceled_Reversal')
                    {
                        return 'canceled_reversal';
                    }

                    return 'unknown';
            }
    }

    public function cancel() {

    }

    public function charge($data,$pricing_details) {
        if($this->paypal_modern_method == 'yes'){
            return $this->charge_popup($data, $pricing_details);
        }
        $form_id= $data->form_id;
        $this_script = get_permalink();
        global $rm_form_diary;
        $form_no = $rm_form_diary[$form_id];
        $sec_hash = wp_generate_password(12, false);        
        $ex_data = array(); //Store additional data to pick up payment at a later point.
        $ex_data['user_id'] = isset($data->user_id) ? $data->user_id : null;
        $ex_data['sec_hash'] = $sec_hash;
        $gopts = new RM_Options;
        if(false == $this_script){
            $this_script = admin_url('admin-ajax.php?action=registrationmagic_embedform&form_id='.$data->form_id);
        }
        $sign = strpos($this_script, '?') ? '&' : '?';

        $i = 1;
        foreach ($pricing_details->billing as $item)
        {
            $this->paypal->add_field('item_name_' . $i, $item->label);
            $i++;
        }
        $this->paypal->add_field('item_name_' . $i, $gopts->get_value_of('tax_rename'));
        
        $i = 1;
        foreach ($pricing_details->billing as $item)
        {
            $this->paypal->add_field('amount_' . $i, $item->price);
            $i++;
        }
        $this->paypal->add_field('amount_' . $i, $pricing_details->tax);
                
        $i = 1;
        foreach ($pricing_details->billing as $item)
        {
            $qty = isset($item->qty) ? $item->qty : 1;
            $this->paypal->add_field('quantity_' . $i, $qty);
            $i++;
        }
        $this->paypal->add_field('quantity_' . $i, 1);
        
        $total_amount = $pricing_details->total_price;
        $invoice = (string) date("His") . rand(1234, 9632);

        $this->paypal->add_field('business', $this->paypal_email); // Call the facilitator eaccount
        $this->paypal->add_field('cmd', '_cart'); // cmd should be _cart for cart checkout
        $this->paypal->add_field('upload', '1');
        $this->paypal->add_field('return', $this_script . $sign . 'rm_pproc=success&rm_pproc_id=0'.'&rm_fid='.$form_id.'&rm_fno='.$form_no.'&sh='.$sec_hash.'&rm_subid='.$data->submission_id); // return URL after the transaction got over
        $this->paypal->add_field('cancel_return', $this_script . $sign . 'rm_pproc=cancel&rm_pproc_id=0'.'&rm_fid='.$form_id.'&rm_fno='.$form_no.'&sh='.$sec_hash.'&rm_subid='.$data->submission_id); // cancel URL if the trasaction was cancelled during half of the transaction
        $notify_url = add_query_arg(array('action'=>'rm_paypal_ipn','rm_fid'=>$form_id,'rm_fno'=>$form_no,'rm_uemail'=>isset($data->user_email) ? $data->user_email : '' ,'rm_subid'=>$data->submission_id),admin_url('admin-ajax.php'));
        //$this->paypal->add_field('notify_url', $this_script . $sign . 'rm_pproc=ipn&rm_pproc_id=0'.'&rm_fid='.$form_id.'&rm_fno='.$form_no.'&sh='.$sec_hash); // Notify URL which received IPN (Instant Payment Notification)
        $this->paypal->add_field('notify_url', $notify_url); 
        $this->paypal->add_field('currency_code', $this->currency);
        $this->paypal->add_field('invoice', $invoice);

        $this->paypal->add_field('page_style', $this->paypal_page_style);

        //Insert into PayPal log table

        //$curr_date = RM_Utilities::get_current_time(); //date_i18n(get_option('date_format'));
        $curr_date = gmdate('Y-m-d H:i:s');

        if ($total_amount <= 0.0 && !$this->has_positive_priced_billing_item($pricing_details))
        {
            $log_entry_id = RM_DBManager::insert_row('PAYPAL_LOGS', array('submission_id' => $data->submission_id,
                        'form_id' => $form_id,
                        'invoice' => $invoice,
                        'status' => 'Completed',
                        'total_amount' => $total_amount,
                        'currency' => $this->currency,
                        'posted_date' => $curr_date,
                        'pay_proc' => 'paypal',
                        'bill' => maybe_serialize($pricing_details),
                        'ex_data' => maybe_serialize($ex_data)), array('%d', '%d', '%s', '%s', '%f', '%s', '%s', '%s', '%s', '%s'));

            return true;
        } else {
            $log_entry_id = RM_DBManager::insert_row('PAYPAL_LOGS', array('submission_id' => $data->submission_id,
                        'form_id' => $form_id,
                        'invoice' => $invoice,
                        'status' => 'Pending',
                        'total_amount' => $total_amount,
                        'currency' => $this->currency,
                        'posted_date' => $curr_date,
                        'pay_proc' => 'paypal',
                        'bill' => maybe_serialize($pricing_details),
                        'ex_data' => maybe_serialize($ex_data)), array('%d', '%d', '%s', '%s', '%f', '%s', '%s', '%s', '%s', '%s'));
        }
        
        if(isset($data->user_id))
            $cstm_data = $log_entry_id."|".$data->user_id;
        else
            $cstm_data = $log_entry_id."|0";
        
        $this->paypal->add_field('custom', $cstm_data);
        $this->paypal->add_field('bn', 'CMSHelp_SP');
        $this->paypal->add_field('return', $this_script . $sign . 'rm_pproc=success&rm_pproc_id='.$log_entry_id.'&rm_fid='.$form_id.'&rm_fno='.$form_no.'&sh='.$sec_hash.'&rm_subid='.$data->submission_id); // return URL after the transaction got over
        $this->paypal->add_field('cancel_return', $this_script . $sign . 'rm_pproc=cancel&rm_pproc_id='.$log_entry_id.'&rm_fid='.$form_id.'&rm_fno='.$form_no.'&sh='.$sec_hash.'&rm_subid='.$data->submission_id); // cancel URL if the trasaction was cancelled during half of the transaction
        //$this->paypal->add_field('notify_url', $this_script . $sign . 'rm_pproc=ipn&rm_pproc_id='.$log_entry_id.'&rm_fid='.$form_id.'&rm_fno='.$form_no.'&sh='.$sec_hash); // Notify URL which received IPN (Instant Payment Notification)
        $this->paypal->add_field('notify_url', $notify_url);                 
          $data=array();
       
         // POST it to paypal
        $data['html']= $this->paypal->submit_paypal_post();
        $data['status']='do_not_redirect';
        ob_end_clean();
        return $data; //We do not want form redirect to work in case paypal processing is going on.
    }
    
    public function process_paypal_sdk_payment() {
        if(check_ajax_referer('rm_ajax_secure','rm_sec_nonce')) {
            if(!isset($_POST['transaction']) || !is_array($_POST['transaction']) ) {
                wp_send_json_error(array('msg'=>esc_html__('Transaction not valid.','custom-registration-form-builder-with-submission-manager')));
            }
            $submission_id= isset($_POST['submission_id']) ? absint($_POST['submission_id']) : 0;
            empty($submission_id) ? wp_send_json_error(array('msg'=>esc_html__('Submission not valid.','custom-registration-form-builder-with-submission-manager'))) : '';
            $submission = new RM_Submissions();
            if(!$submission->load_from_db($submission_id)) {
                wp_send_json_error(array('msg'=>esc_html__('Submission not valid.','custom-registration-form-builder-with-submission-manager')));
            }
            $transaction = $_POST['transaction'];
            $log_id = isset($_POST['payment_id']) ? absint($_POST['payment_id']) : 0;
            $log = $log_id ? RM_DBManager::get_row('PAYPAL_LOGS', $log_id) : false;
            if(!$log || (int)$log->submission_id !== (int)$submission_id) {
                wp_send_json_error(array('msg'=>esc_html__('Submission not valid.','custom-registration-form-builder-with-submission-manager')));
            }
            if (strtolower((string)$log->status) === 'completed' || !empty($log->txn_id)) {
                wp_send_json_error(array('msg'=>esc_html__('Transaction not valid.','custom-registration-form-builder-with-submission-manager')));
            }
            $exdata = maybe_unserialize($log->ex_data);
            $user_id = isset($exdata['user_id']) ? absint($exdata['user_id']) : 0;
            //$status = isset($transaction['status']) ? strtolower($transaction['status']) : 'Pending';
            //$status = ucfirst($status);
            $txn_id = isset($transaction['id']) ? sanitize_text_field(wp_unslash($transaction['id'])) : '';
            $validation = $this->validate_sdk_payment($txn_id, $log);
            $status = $validation['status'];
            $log_data = array('browser_transaction' => $this->sanitize_payment_log_data(wp_unslash($transaction)));
            if (!empty($validation['payment_data'])) {
                $log_data['paypal_capture'] = $this->sanitize_payment_log_data($validation['payment_data']);
            }
            if (!empty($validation['reason'])) {
                $log_data['validation_reason'] = sanitize_text_field($validation['reason']);
            }

            $update_data = array(
                'status' => $status,
                'posted_date' => RM_Utilities::get_current_time(),
                'log' => maybe_serialize($log_data)
            );
            $update_format = array('%s', '%s', '%s');
            if ($status === 'Completed') {
                $update_data['txn_id'] = $txn_id;
                $update_format[] = '%s';
            }

            $log_entry_id = RM_DBManager::update_row('PAYPAL_LOGS', $log_id, $update_data, $update_format);
            if(defined('REGMAGIC_ADDON')) {
                $addon_service = new RM_Paypal_Service_Addon;
                $check_setting = $addon_service->check_approval_settings($txn_id);
            } else {
                $check_setting = "yes";
            }
            if($status == 'Completed') {
                if ($user_id){
                    if ($check_setting == "yes"){
                        $user_service = new RM_User_Services();
                        $user_service->activate_user_by_id($user_id);
                    }
                }
                $form_id = $submission->form_id;
                $form = new RM_Forms();
                $form->load_from_db($form_id);
                do_action('rm_payment_completed', $submission->user_email, $form, $submission->submission_id);
            }
            $payment_status = $status == 'Completed' ? true : false;
            $response= apply_filters('rm_payment_completed_response', array('msg'=>'','redirect'=>''), $submission, $submission->get_form_id(), $payment_status);
            if(!empty($log_id)){
                $response['log_id']= $log_id;
            }
            wp_send_json_success($response);
        } else {
            wp_send_json_error(array('msg'=>esc_html__('Submission not valid.','custom-registration-form-builder-with-submission-manager')));
        }
    }

    public function validate_sdk_payment( $transaction_id, $log ) {
        $validation = array('status' => 'Pending', 'reason' => '', 'payment_data' => array());

        $transaction_id = sanitize_text_field((string)$transaction_id);
        if (empty($transaction_id)) {
            $validation['reason'] = 'missing_capture_id';
            return $validation;
        }

        if (!$log || empty($log->id)) {
            $validation['reason'] = 'missing_local_log';
            return $validation;
        }

        if ($this->is_sdk_capture_replayed($transaction_id, absint($log->id))) {
            $validation['reason'] = 'replayed_capture';
            return $validation;
        }

        $gopts = new RM_Options;
        $sandbox =  $gopts->get_value_of('paypal_test_mode') === 'yes' ? true : false;

        // PayPal API keys
        $client_id = $gopts->get_value_of('paypal_client_id');
        $secret    = $gopts->get_value_of('paypal_secret_key');

        // PayPal REST API endpoint
        $paypal_api = $sandbox
            ? 'https://api.sandbox.paypal.com'
            : 'https://api.paypal.com';

        /*
        * 1. Get OAuth Access Token
        */
        $token_response = wp_remote_post( "$paypal_api/v1/oauth2/token", [
            'method'      => 'POST',
            'timeout'     => 60,
            'headers'     => [
                'Authorization' => 'Basic ' . base64_encode( "$client_id:$secret" ),
            ],
            'body'        => 'grant_type=client_credentials',
        ]);

        if ( is_wp_error( $token_response ) ) {
            $validation['reason'] = 'token_request_failed';
            return $validation;
        }

        $token_body = json_decode( wp_remote_retrieve_body( $token_response ), true );

        if ( empty( $token_body['access_token'] ) ) {
            $validation['reason'] = 'missing_access_token';
            return $validation;
        }

        $access_token = $token_body['access_token'];

        /*
        * 2. Fetch capture details from PayPal and validate them against the local log.
        */
        $payment_response = wp_remote_get( "$paypal_api/v2/payments/captures/" . rawurlencode($transaction_id), [
            'timeout' => 60,
            'headers' => [
                'Authorization' => "Bearer $access_token",
                'Content-Type'  => 'application/json',
            ],
        ]);
        
        if ( is_wp_error( $payment_response ) ) {
            $validation['reason'] = 'capture_request_failed';
            return $validation;
        }

        $payment_data = json_decode( wp_remote_retrieve_body( $payment_response ), true );
        $validation['payment_data'] = is_array($payment_data) ? $payment_data : array();

        if ( empty( $payment_data['status'] ) ) {
            $validation['reason'] = 'missing_capture_status';
            return $validation;
        }

        /*
        * 3. Fail closed unless the capture is complete and bound to this local payment.
        */
        if ( $payment_data['status'] !== 'COMPLETED' ) {
            $validation['reason'] = 'capture_not_completed';
            return $validation;
        }

        if (!isset($payment_data['amount']['value']) || $payment_data['amount']['value'] === '' || empty($payment_data['amount']['currency_code'])) {
            $validation['reason'] = 'missing_capture_amount';
            return $validation;
        }

        if ($this->normalize_amount($payment_data['amount']['value']) !== $this->normalize_amount($log->total_amount)) {
            $validation['reason'] = 'amount_mismatch';
            return $validation;
        }

        if (strtoupper((string)$payment_data['amount']['currency_code']) !== strtoupper((string)$log->currency)) {
            $validation['reason'] = 'currency_mismatch';
            return $validation;
        }

        $exdata = maybe_unserialize($log->ex_data);
        $expected_payment_key = is_array($exdata) && !empty($exdata['sdk_payment_key']) ? (string)$exdata['sdk_payment_key'] : '';
        $capture_custom_id = isset($payment_data['custom_id']) ? (string)$payment_data['custom_id'] : '';
        if (empty($expected_payment_key) || empty($capture_custom_id) || !hash_equals($expected_payment_key, $capture_custom_id)) {
            $validation['reason'] = 'custom_id_mismatch';
            return $validation;
        }

        $expected_invoice_id = !empty($log->invoice) ? (string)$log->invoice : '';
        $capture_invoice_id = isset($payment_data['invoice_id']) ? (string)$payment_data['invoice_id'] : '';
        if (empty($expected_invoice_id) || empty($capture_invoice_id) || !hash_equals($expected_invoice_id, $capture_invoice_id)) {
            $validation['reason'] = 'invoice_id_mismatch';
            return $validation;
        }

        /*
        * SUCCESS
        */
        $validation['status'] = 'Completed';
        $validation['reason'] = 'validated';
        return $validation;
    }

    public function demo(){
        $response['msg'] .= '<div id="rmform">';
        $response['msg'] .= "<br><br><div class='rm-post-sub-msg'>";
        $response['msg'] .= $form->form_options->form_success_message != "" ? apply_filters('rm_form_success_msg',$form->form_options->form_success_message,$form_id,$sub_id) : $form->get_form_name() . " ". esc_html__('Submitted','custom-registration-form-builder-with-submission-manager');
        $response['msg'] .= '</div>';
        
            
        // After submission redirection
        $response['redirect']= RM_Utilities::get_form_redirection_url($form);
        $redirection_page='';
        if(!empty($response['redirect'])){
            $redirection_type = $form->get_form_redirect();
            if ($redirection_type=== "page") {
                $page_id = $form->get_form_redirect_to_page();
                $page = get_post($page_id);
                if($page instanceof WP_Post)
                    $redirection_page = $page->post_title ? $page->post_title : '#' . $page_id . ' '.esc_html__('(No Title)','custom-registration-form-builder-with-submission-manager');
            } else if($redirection_type==='url') {
                    $redirection_page = $form->get_form_redirect_to_url();
            }
            if(!empty($redirection_page)){
                $response['msg'] .= '<br><span>'.RM_UI_Strings::get("MSG_REDIRECTING_TO").' '.$redirection_page.'</span>';
            }
        }
        
        if($is_logging_in && empty($redirection_page)){
            $response['msg'] .= '<br><span>'.RM_UI_Strings::get("MSG_ASYNC_LOGIN").'</span>';
            if(empty($response['redirect'])){
                $response['reload_params'] = "?rm_success=1&rm_form_id=$form_id&rm_sub_id=".$submission->id;
            }
        }
        $response['msg'] .= '</div>';
    }

    public function charge_popup($data, $pricing_details){
        $submission_id = $data->submission_id;
        $form_id= $data->form_id;
        $this_script = get_permalink();
        global $rm_form_diary;
        $form_no = $rm_form_diary[$form_id];
        $sec_hash = wp_generate_password(12, false);        
        $ex_data = array(); //Store additional data to pick up payment at a later point.
        $ex_data['user_id'] = isset($data->user_id) ? $data->user_id : null;
        $ex_data['sec_hash'] = $sec_hash;
        $gopts = new RM_Options;
        if(false == $this_script){
            $this_script = admin_url('admin-ajax.php?action=registrationmagic_embedform&form_id='.$data->form_id);
        }
        $sign = strpos($this_script, '?') ? '&' : '?';
        $total_amount = $pricing_details->total_price;
        $invoice = (string) date("His") . rand(1234, 9632);
        $ex_data['sdk_payment_key'] = wp_generate_password(24, false);

        $curr_date = RM_Utilities::get_current_time(); //date_i18n(get_option('date_format'));

        if ($total_amount <= 0.0 && !$this->has_positive_priced_billing_item($pricing_details))
        {
            $log_entry_id = RM_DBManager::insert_row('PAYPAL_LOGS', array('submission_id' => $data->submission_id,
                        'form_id' => $form_id,
                        'invoice' => $invoice,
                        'status' => 'Completed',
                        'total_amount' => $total_amount,
                        'currency' => $this->currency,
                        'posted_date' => $curr_date,
                        'pay_proc' => 'paypal',
                        'bill' => maybe_serialize($pricing_details),
                        'ex_data' => maybe_serialize($ex_data)), array('%d', '%d', '%s', '%s', '%f', '%s', '%s', '%s', '%s', '%s'));

            return true;
        } else {
            $log_entry_id = RM_DBManager::insert_row('PAYPAL_LOGS', array('submission_id' => $data->submission_id,
                        'form_id' => $form_id,
                        'invoice' => $invoice,
                        'status' => 'Pending',
                        'total_amount' => $total_amount,
                        'currency' => $this->currency,
                        'posted_date' => $curr_date,
                        'pay_proc' => 'paypal',
                        'bill' => maybe_serialize($pricing_details),
                        'ex_data' => maybe_serialize($ex_data)), array('%d', '%d', '%s', '%s', '%f', '%s', '%s', '%s', '%s', '%s'));
        }

        if (empty($log_entry_id))
            return false;

        $order_items = array();
        foreach( $pricing_details->billing as $item){
            $items = array();
            $items['name'] = $item->label;
            $items['unit_amount'] = array('currency_code'=>$this->currency,'value'=>$item->price);
            $items['quantity'] = $item->qty;
            $order_items[] = $items;
        }
        if($pricing_details->tax > 0){
            $items = array();
            $items['name'] = $gopts->get_value_of('tax_rename');
            $items['quantity'] = 1;
            $items['unit_amount'] = array('currency_code'=>$this->currency,'value'=>$pricing_details->tax);
            $order_items[] = $items;
        }
        // For number precision = number_format((float)$pricing_details->total_price, 2, '.', '')
        $purchase_units = array(
            'amount'=> array(
                'currency_code'=>$this->currency,
                'value'=> $pricing_details->total_price,
                'breakdown'=>array(
                    'item_total'=>array(
                        'currency_code' => $this->currency,
                        'value'=> $pricing_details->total_price
                    )
                )
            ),
            'items'=>$order_items,
            'custom_id'=>$ex_data['sdk_payment_key'],
            'invoice_id'=>$invoice
        );
        
        $order_details = json_encode(array('purchase_units'=>array($purchase_units)));
        
        $user_id = isset($data->user_id) ? $data->user_id : 0;
        $data=array();
        // POST it to paypal
        $btn_color = $gopts->get_value_of('paypal_btn_color') ? $gopts->get_value_of('paypal_btn_color') : 'gold';
        $data['html']= $this->paypal->popup_modal_paypal_post($order_details, $pricing_details, $submission_id, $log_entry_id ,$this->currency, $user_id, $btn_color);
        $data['status']='do_not_redirect';
        ob_end_clean();
        return $data;
    }

    public function refund() {
        
    }

    public function subscribe() {
        
    }

}
