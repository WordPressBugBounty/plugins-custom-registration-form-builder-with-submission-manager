<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class RM_Frontend_Form_Base
{

    public $form_id;
    public $form_type;
    public $form_name;
    public $form_options;
    public $rows;
    public $fields;
    public $pfbc_form;
    public $custom_pre_str;
    public $custom_post_str;
    public $service;
    public $contains_price_fields;
    public $form_number;//Keeps track of the how many of the same forms have been rendered
    public $ignore_expiration;
    public $primary_field_indices;
    public $preview= false;

    //Submission related function, must be implemented by child class
    abstract function pre_sub_proc($request, $params);

    abstract function post_sub_proc($request, $params);

    public function __construct(RM_Forms $be_form, $ignore_expiration=false)
    {
        $this->rows = array();
        $this->fields = array();
        $this->form_type = RM_BASE_FORM;
        $this->custom_pre_str = '';
        $this->custom_post_str = '';
        $this->form_id = $be_form->get_form_id();
        $this->form_name = $be_form->get_form_name();
        $this->form_options = $be_form->get_form_options();
        $this->form_options->form_should_auto_expire = $be_form->get_form_should_auto_expire();
        $this->form_options->form_should_send_email = $be_form->get_form_should_send_email();
        $this->ignore_expiration = $ignore_expiration;

        if (isset($be_form->form_redirect) && $be_form->form_redirect != "none" && $be_form->form_redirect != "")
            $this->form_options->redirection_type = $be_form->form_redirect;
        else
            $this->form_options->redirection_type = null;

        $this->form_options->redirect_page = $be_form->get_form_redirect_to_page();
        $this->form_options->redirect_url = $be_form->get_form_redirect_to_url();        
        $this->primary_field_indices = array();
        $this->service = new RM_Front_Form_Service;
    }
    
    public function set_primary_field_index($pfields)
    {
        foreach($pfields as $pfield=>$pfield_index)
        {
            $this->primary_field_indices[$pfield] = $pfield_index;
        }
    }
    
    public function get_primary_field_index($pfields)
    {
        return $this->primary_field_indices;
    }

    public function get_form_id()
    {
        return $this->form_id;
    }

    public function get_form_name()
    {
        return $this->form_name;
    }

    public function get_form_options()
    {
        return $this->form_options;
    }
    
    public function get_form_number()
    {
        return $this->form_number;
    }

    public function get_form_should_auto_expire()
    {
        return $this->form_options->form_should_auto_expire;
    }

    public function is_expired()
    {
        if($this->ignore_expiration)
            return false;
        
        if (!$this->form_options->form_should_auto_expire)
            return false;
        else
        {
            $criterian = $this->form_options->form_expired_by;
            if($criterian=='status')
                return false;
            $submission_limit = $this->form_options->form_submissions_limit;
            return $this->service->is_form_expired_core($this->form_id, $criterian, $submission_limit);
        }
    }

    public function set_form_type($form_type)
    {
        $this->form_type = $form_type;
    }

    public function get_form_type()
    {
        return $this->form_type;
    }
    
    public function set_form_number( $form_number)
    {
        $this->form_number = $form_number;
    }

    public function get_custom_pre_str()
    {
        return $this->custom_pre_str;
    }

    public function get_custom_post_str()
    {
        return $this->custom_post_str;
    }

    public function add_field(RM_Frontend_Field_Base $fe_field)
    {
        $this->fields[$fe_field->get_field_name()] = $fe_field;
    }

    //Add/append fields in batch in existing array of fields
    // Array must be assosiative with field name as index.
    public function add_fields_array($fe_fields_arr)
    {
        if (count($this->fields) === 0)
            $this->fields = $fe_fields_arr;
        else
            $this->fields = $this->fields + $fe_fields_arr;
    }
    
    public function add_rows_array($fe_rows_arr)
    {
        if (count($this->rows) === 0)
            $this->rows = $fe_rows_arr;
        else
            $this->rows = $this->rows + $fe_rows_arr;
    }
    
    public function get_fields()
    {
        return $this->fields;
    }
    
    //Add custom msg strings to be shown above form like alerts.
    public function add_content_above_form($string)
    {
        $this->custom_pre_str = $string;
    }

    public function add_content_below_form($string)
    {
        $this->custom_post_str = $string;
    }

    public function pre_render()
    {
        $row_class = empty($this->rows) ? '.rmrow' : '.rmagic-row';
        $important = ' !important';
        $p_css = str_replace("::-", ' #form_' . $this->form_id . "_" . $this->form_number .' ::-', (string)$this->form_options->placeholder_css);
        echo '<style>'.str_replace("}:-", '} #form_' . wp_kses_post((string)$this->form_id) . "_" . wp_kses_post((string)$this->form_number) .' ::-', wp_kses_post((string)$p_css)).'</style>';
        echo '<style>';
        if($this->form_options->style_btnfield)
            echo '.rmagic #form_' . wp_kses_post((string)$this->form_id) . "_" . wp_kses_post((string)$this->form_number) .' .buttonarea input[type="submit"] {'.wp_kses_post((string)$this->form_options->style_btnfield).wp_kses_post((string)$important).'}';
        if($this->form_options->btn_hover_color)
            echo '.rmagic #form_' . wp_kses_post((string)$this->form_id) . "_" . wp_kses_post((string)$this->form_number) .' .buttonarea input[type="submit"]:hover{ background-color:'.wp_kses_post((string)$this->form_options->btn_hover_color).wp_kses_post((string)$important).';}';
        if($this->form_options->field_bg_focus_color || $this->form_options->text_focus_color){
            echo '.rmagic #form_' . wp_kses_post((string)$this->form_id) . "_" . wp_kses_post((string)$this->form_number) .' ' . wp_kses_post((string)$row_class) . ' input:focus,.rmagic #form_'.wp_kses_post((string)$this->form_id).'_'.wp_kses_post((string)$this->form_number).' ' . wp_kses_post((string)$row_class) . ' select:focus,.rmagic #form_'.wp_kses_post((string)$this->form_id).'_'.wp_kses_post((string)$this->form_number).' ' . wp_kses_post((string)$row_class) . ' textarea:focus{';
            if($this->form_options->field_bg_focus_color)
                echo 'background-color:'.wp_kses_post((string)$this->form_options->field_bg_focus_color).wp_kses_post((string)$important).';';
            if($this->form_options->text_focus_color)
                echo 'color:'.wp_kses_post((string)$this->form_options->text_focus_color).wp_kses_post((string)$important).';';
            echo '}';
        }
        echo '</style>';
        $expiry_details = $this->service->get_form_expiry_stats($this);
        if (!$this->is_expired() && !empty($expiry_details))
        {
            $check_setting=null;
            $exp_str = '<div class="rm_expiry_stat_container">';
            if($this->form_options->display_progress_bar=='default')
            {
                $check_setting=$this->service->get_setting('display_progress_bar');
            }
            else
            {
                $check_setting=$this->form_options->display_progress_bar;
            }
          
            if ($expiry_details->state !== 'perpetual' && $check_setting == 'yes')
                {
                if ($expiry_details->state === 'expired')
                    $exp_str .= '<div class="rm-formcard-expired">' . 'Expired' . '</div>';
                else
                {
                    switch ($expiry_details->criteria)
                    {
                        case 'both':
                            $message = sprintf(RM_UI_Strings::get('EXPIRY_DETAIL_BOTH'), ($expiry_details->sub_limit - $expiry_details->remaining_subs), $expiry_details->sub_limit, $expiry_details->remaining_days);
                            $exp_str .= '<div class="rm-formcard-expired"><span class="rm_sandclock"></span>' . $message . '</div>';
                            break;
                        case 'subs':
                            $total = $expiry_details->sub_limit;
                            $rem = $expiry_details->remaining_subs;
                            $wtot = 100;
                            $rem = ($rem * 100) / $total;
                            $done = 100 - $rem;
                            $message = sprintf(RM_UI_Strings::get('EXPIRY_DETAIL_SUBS'), ($expiry_details->sub_limit - $expiry_details->remaining_subs), $expiry_details->sub_limit);
                            $exp_str .= '<div class="rm-formcard-expired"><span class="rm_sandclock"></span>' . $message . '</div>';
                            break;

                        case 'date':
                            $message = sprintf(RM_UI_Strings::get('EXPIRY_DETAIL_DATE'), $expiry_details->remaining_days);
                            $exp_str .= '<div class="rm-formcard-expired"><span class="rm_sandclock"></span>' . $message . '</div>';
                            break;
                    }
                }

                $exp_str .= '</div>';
                echo wp_kses_post((string)$exp_str);
            }
        }
        echo('<div class="rmcontent">');
        if ($this->custom_pre_str !== '' || $this->custom_pre_str)
            echo wp_kses_post((string)$this->custom_pre_str);
    }

    public function prepare_fields_for_render($form)
    {
        foreach ($this->fields as $field)
        {
            $pf = $field->get_pfbc_field();

            if ($pf === null)
                continue;

            if (is_array($pf))
            {
                foreach ($pf as $f)
                {
                    if (!$f)
                        continue;
                    $form->addElement($f);
                }
            } else
                $form->addElement($pf);
        }
        
      
    }

    public function prepare_button_for_render($form)
    {
        if ($this->service->get_setting('theme') != 'matchmytheme')
        {
            if(isset($this->form_options->style_btnfield))
                unset($this->form_options->style_btnfield);
        }
        $btn_label = $this->form_options->form_submit_btn_label;
        $form->addElement(new Element_Button($btn_label != "" ? $btn_label : "Submit", "submit", array("style" => isset($this->form_options->style_btnfield)?$this->form_options->style_btnfield:null)));
    }

    public function base_render($form,$editing_sub=null)
    {
        $this->prepare_fields_for_render($form);

        if (get_option('rm_option_enable_captcha') == "yes" && $this->form_options->enable_captcha[0]=='yes')
            $form->addElement(new Element_Captcha());


        $this->prepare_button_for_render($form);

        if (count($this->fields) !== 0)
            $form->render();
        else
            echo wp_kses_post((string)RM_UI_Strings::get('MSG_NO_FIELDS'));
    }

    public function post_render()
    {
        if ($this->custom_post_str !== '' || $this->custom_post_str)
            echo wp_kses_post((string)$this->custom_post_str);

        echo "</div>";
    }

    public function render($extra_data_may_needed_in_child_class = null)
    {
        global $rm_form_diary;
        echo '<div class="rmagic">';
        
        //$this->form_number = $rm_form_diary[$this->form_id];
        $form = new RM_PFBC_Form('form_' . $this->form_id . "_" . $this->form_number);

        $form->configure(array(
            "prevent" => array("bootstrap", "jQuery", "focus"),
            "action" => "",
            "class" => "rmagic-form",
            "name" => "rm_form",
            "view" => ($layout == 'two_columns')? new View_UserFormTwoCols: new View_UserForm,
            "number" => $this->form_number,
            "style" => isset($this->form_options->style_form)?$this->form_options->style_form:null
        ));
        
        //Render content above the form
        if (!empty($this->form_options->form_custom_text))
                $form->addElement(new Element_HTML('<div class="rmheader">' . $this->form_options->form_custom_text . '</div>'));
        
        if (!$this->is_expired())
        {
            $this->pre_render();
            $this->base_render($form);
            $this->post_render();
        } else
        {
            if ($this->form_options->form_message_after_expiry)
                echo wp_kses_post((string)$this->form_options->form_message_after_expiry);
            else
                echo wp_kses_post((string)RM_UI_Strings::get('MSG_FORM_EXPIRY'));
        }


        echo '</div>';
    }

    //Get prepared data, depending upon flag 'data_type'.
    // - all = data of all fields.
    // - primary = data of primary fields only.
    // - dbonly = excludes the data of the fields which are not to be saved in db.
    // 
    //Depending upon the flag a different internal function is called.
    //Individual form classes must override these functions in order to customize the data as per the form specifications.

    public function get_prepared_data($request, $data_type = 'all', $fields=null)
    {
        switch ($data_type)
        {
            case 'all': return $this->get_prepared_data_all($request);
            case 'primary': return $this->get_prepared_data_primary($request);
            case 'dbonly': return $this->get_prepared_data_dbonly($request,$fields);
        }
    }

    public function get_prepared_data_all($request)
    {
        $data = array();

        foreach ($this->fields as $field)
        {
            $field_data = $field->get_prepared_data($request);

            if ($field_data === null)
                continue;

            $data[$field_data->field_id] = (object) array('label' => $field_data->label,
                        'value' => $field_data->value,
                        'type' => $field_data->type,
                        'meta' => isset($field_data->meta) ? $field_data->meta : null
                        );
        }

        return $data;
    }

    //in the base class there is no primary fields.
    public function get_prepared_data_primary($request)
    {
        return array();
    }

    //in the base class there is no db-excluded field.
    public function get_prepared_data_dbonly($request)
    {
        return $this->get_prepared_data_all($request);
    }

    //Get pricing detail for all the pricing fields.
    public function get_pricing_detail($request)
    {
        $data = new stdClass;

        //To return null in case there is no price field in the form
        $price_flag = false;
        $data->billing = array();
        $data->total_price = 0.0;
        $data->tax = 0.0;
        foreach ($this->fields as $field)
        {
            if (!is_array($field) && $field->get_field_type() === 'Price')
            {
                $price_flag = true;
                $field_pricing_detail = $field->get_pricing_detail($request);

                if ($field_pricing_detail !== null)
                {
                    foreach ($field_pricing_detail->billing as $individual_item)
                        $data->billing[] = $individual_item;

                    $data->total_price += $field_pricing_detail->total_price;
                }
            }
        }
        
        /*
        $tax_enabled = get_site_option('rm_option_enable_tax', null);
        if($tax_enabled == 'yes' && $data->total_price > 0) {
            $tax_type = get_site_option('rm_option_tax_type', null);
            if($tax_type == 'fixed') {
                $data->tax = round(floatval(get_site_option('rm_option_tax_fixed', null)),2);
                $data->total_price = round($data->total_price + $data->tax, 2);
            } elseif($tax_type == 'percentage') {
                $tax_per = round(floatval(get_site_option('rm_option_tax_percentage', null)),2);
                $data->tax = round(($data->total_price * $tax_per)/100, 2);
                $data->total_price = round($data->total_price + $data->tax, 2);
            }
        } else {
            $data->tax = 0.0;
        }
        */

        return $price_flag ? $data : null;
    }

    /**
     * Replace the client-supplied conditional-field list with the state derived
     * from the trusted form definition. Hidden submitted values are discarded so
     * they cannot influence another condition or the calculated price.
     */
    public function secure_conditional_price_validation(&$request)
    {
        $field_map = array();
        foreach ($this->fields as $field_group) {
            $fields = is_array($field_group) ? $field_group : array($field_group);
            foreach ($fields as $field) {
                if ($field instanceof RM_Frontend_Field_Base) {
                    $field_map[(int) $field->get_field_id()] = $field;
                }
            }
        }

        $controllers_valid = $this->sanitize_conditional_controller_values($request, $field_map);

        $states = array();
        $resolving = array();
        $forced_visible = array();
        foreach ($field_map as $field) {
            $this->resolve_server_field_visibility($field, $request, $field_map, $states, $resolving, $forced_visible);
        }

        // Circular condition graphs are invalid. Keep every participant visible
        // so a cycle can never be used to suppress validation or payment.
        foreach ($forced_visible as $field_id => $unused) {
            $states[$field_id] = true;
        }

        $hidden_fields = array();
        foreach ($field_map as $field_id => $field) {
            if (!isset($states[$field_id]) || $states[$field_id]) {
                continue;
            }

            $field_name = $field->get_field_name();
            $hidden_fields[] = $field_name;
            $hidden_fields[] = $field_name . '[]';
            unset($request[$field_name], $request[$field_name . '[]']);
            unset($_POST[$field_name], $_POST[$field_name . '[]']);
        }

        $request['rm_cond_hidden_fields'] = implode(',', array_values(array_unique($hidden_fields)));
        if ((isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') || !empty($_POST)) {
            $_POST['rm_cond_hidden_fields'] = $request['rm_cond_hidden_fields'];
        }

        return $controllers_valid;
    }

    /**
     * Reject forged values for option fields used as condition controllers.
     * PFBC's required validator only checks for a non-empty value; without this
     * allow-list an attacker could submit a nonexistent radio/select option to
     * make every paid branch false.
     */
    private function sanitize_conditional_controller_values(&$request, $field_map)
    {
        $controller_ids = array();
        $required_price_controller_ids = array();
        foreach ($field_map as $field) {
            if ($field instanceof RM_Frontend_Field_Price) {
                $controller_ids[(int) $field->get_field_id()] = true;
            }
            $conditions = $field->field_model->get_field_conditions();
            if (empty($conditions['rules']) || !is_array($conditions['rules'])) {
                continue;
            }
            foreach ($conditions['rules'] as $rule) {
                if (isset($rule['controlling_field'])) {
                    $controller_id = absint($rule['controlling_field']);
                    $controller_ids[$controller_id] = true;
                    if ($field instanceof RM_Frontend_Field_Price && (!isset($rule['op']) || $rule['op'] !== '_blank')) {
                        $required_price_controller_ids[$controller_id] = true;
                    }
                }
            }
        }

        $controllers_valid = true;
        foreach ($controller_ids as $controller_id => $unused) {
            if (!isset($field_map[$controller_id])) {
                if (isset($required_price_controller_ids[$controller_id])) {
                    $controllers_valid = false;
                }
                continue;
            }

            $controller = $field_map[$controller_id];
            $field_name = $controller->get_field_name();
            $is_required_price_controller = isset($required_price_controller_ids[$controller_id]);
            if ($is_required_price_controller && !$this->has_condition_controller_value($request, $field_name)) {
                $controllers_valid = false;
            }

            if ($controller instanceof RM_Frontend_Field_Price) {
                $product = new RM_PayPal_Fields();
                if (!$product->load_from_db($controller->pp_field_id)) {
                    if ($is_required_price_controller) {
                        $controllers_valid = false;
                    }
                    unset($request[$field_name], $request[$field_name . '[]']);
                    unset($_POST[$field_name], $_POST[$field_name . '[]']);
                    continue;
                }

                $product_type = $product->get_type();
                if ($product_type === 'userdef') {
                    $amount = array_key_exists($field_name, $request) && is_scalar($request[$field_name]) && is_numeric($request[$field_name])
                        ? (float) $request[$field_name] : 0.0;
                    if (!is_finite($amount) || $amount <= 0.0) {
                        if ($is_required_price_controller) {
                            $controllers_valid = false;
                        }
                        unset($request[$field_name], $request[$field_name . '[]']);
                        unset($_POST[$field_name], $_POST[$field_name . '[]']);
                    }
                    continue;
                }

                if (($product_type === 'multisel' && array_key_exists($field_name, $request) && !is_array($request[$field_name])) ||
                    ($product_type === 'dropdown' && array_key_exists($field_name, $request) && !is_scalar($request[$field_name]))) {
                    if ($is_required_price_controller) {
                        $controllers_valid = false;
                    }
                    unset($request[$field_name], $request[$field_name . '[]']);
                    unset($_POST[$field_name], $_POST[$field_name . '[]']);
                    continue;
                }
            }

            $allow_other = !empty($controller->field_options['rm_is_other_option']) ||
                (!empty($controller->field_model->field_options->field_is_other_option));

            $element = $controller->get_pfbc_field();
            $elements = is_array($element) ? $element : array($element);
            $option_element = null;
            foreach ($elements as $candidate) {
                if (!is_object($candidate)) {
                    continue;
                }

                if (method_exists($candidate, 'getAttribute') && $candidate->getAttribute('readonly')) {
                    $request[$field_name] = $candidate->getAttribute('value');
                    if ((isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') || !empty($_POST)) {
                        $_POST[$field_name] = $request[$field_name];
                    }
                    continue 2;
                }

                if (isset($candidate->options) && is_array($candidate->options)) {
                    $option_element = $candidate;
                    break;
                }
            }

            if ($allow_other || !array_key_exists($field_name, $request) || $option_element === null) {
                continue;
            }

            $allowed_values = array();
            foreach (array_keys($option_element->options) as $option_value) {
                if (method_exists($option_element, 'getOptionValue')) {
                    $option_value = $option_element->getOptionValue($option_value);
                }
                $allowed_values[] = (string) $option_value;
            }

            $submitted_values = is_array($request[$field_name]) ? $request[$field_name] : array($request[$field_name]);
            $valid = true;
            foreach ($submitted_values as $submitted_value) {
                if (!is_scalar($submitted_value) || !in_array((string) $submitted_value, $allowed_values, true)) {
                    $valid = false;
                    break;
                }
            }

            if (!$valid) {
                if ($is_required_price_controller) {
                    $controllers_valid = false;
                }
                unset($request[$field_name], $request[$field_name . '[]']);
                unset($_POST[$field_name], $_POST[$field_name . '[]']);
            }
        }

        return $controllers_valid;
    }

    private function has_condition_controller_value($request, $field_name)
    {
        if (!array_key_exists($field_name, $request)) {
            return false;
        }

        $values = is_array($request[$field_name]) ? $request[$field_name] : array($request[$field_name]);
        foreach ($values as $value) {
            if (!is_scalar($value) || trim((string) $value) === '') {
                continue;
            }
            return true;
        }

        return false;
    }

    private function resolve_server_field_visibility($field, $request, $field_map, &$states, &$resolving, &$forced_visible)
    {
        $field_id = (int) $field->get_field_id();
        if (array_key_exists($field_id, $states)) {
            return $states[$field_id];
        }

        if (isset($resolving[$field_id])) {
            foreach ($resolving as $cycle_field_id => $unused) {
                $forced_visible[$cycle_field_id] = true;
            }
            $forced_visible[$field_id] = true;
            return true;
        }

        $resolving[$field_id] = true;
        $condition_request = $request;
        $conditions = $field->field_model->get_field_conditions();
        if (!empty($conditions['rules']) && is_array($conditions['rules'])) {
            foreach ($conditions['rules'] as $rule) {
                if (!isset($rule['controlling_field'])) {
                    unset($resolving[$field_id]);
                    $states[$field_id] = true;
                    return true;
                }

                $controller_id = absint($rule['controlling_field']);
                if (!isset($field_map[$controller_id])) {
                    unset($resolving[$field_id]);
                    $states[$field_id] = true;
                    return true;
                }

                $controller = $field_map[$controller_id];
                if (!$this->resolve_server_field_visibility($controller, $request, $field_map, $states, $resolving, $forced_visible)) {
                    $controller_name = $controller->get_field_name();
                    unset($condition_request[$controller_name], $condition_request[$controller_name . '[]']);
                }
            }
        }

        unset($resolving[$field_id]);
        $states[$field_id] = isset($forced_visible[$field_id]) ? true : $field->is_active_for_submission($condition_request);
        return $states[$field_id];
    }

    public function has_price_field()
    {
        foreach ($this->fields as $field)
        {
            if(is_array($field)){
                foreach($field as $f){
                    if ($f->get_field_type() === 'Price')
                    return true;
                }
                continue;
            }
            if ($field->get_field_type() === 'Price')
                return true;
        }

        return false;
    }

    public function add_payment_fields($form)
    {
        global  $rm_env_requirements;
        $form->addElement(new Element_HTML('<div class="rmagic-row rm_payment_options">'));
        $payment_gateways = $this->service->get_setting('payment_gateway');
        $default_payment_gateway = $this->service->get_setting('default_payment_method');
        
        if(!$this->form_number)
            $f_no = 1;
        else
            $f_no = $this->form_number;
        
        $f_id = $this->form_id;
        
        if (!$payment_gateways || count($payment_gateways) == 0)
            return;

        if (!is_array($payment_gateways))
            $payment_gateways = array($payment_gateways);

        $radio_array = array();
        $gopts = new RM_Options;
        $pgws = $gopts->get_value_of('payment_gateway');
        $include_stripe = defined('REGMAGIC_ADDON') ? $gopts->get_value_of('include_stripe') : 'no';
        foreach ($payment_gateways as $payment_gw)
        {
            if ($payment_gw === 'stripe' && ($rm_env_requirements & RM_REQ_EXT_CURL))
            {
                if (!RM_Utilities::is_ssl() || $include_stripe!='yes')
                    continue;
                
                $stripe_pub_key = $this->service->get_setting('stripe_publish_key');

                if ($stripe_pub_key == null)
                    continue;

                $radio_array['stripe'] = "<img src='" . RM_IMG_URL . "/stripe-logo.png" . "'></img>"; //'Stripe';
            }
            if ($payment_gw === 'paypal')
            {
                $radio_array['paypal'] = "<img src='" . RM_IMG_URL . "/paypal-logo.png" . "'></img>"; //'PayPal';
            }
            
        }
        
        $radio_array = apply_filters("rm_payment_procs_options_frontend", $radio_array);
        
        $active_payment_method = 'paypal';
        
        if (count($radio_array) == 1 && isset($radio_array['stripe']))
            $active_payment_method = 'stripe';
        
        if($default_payment_gateway != ''){
            if(in_array($default_payment_gateway,$pgws)){
                $active_payment_method = $default_payment_gateway;
            }else{
                if(count($pgws) > 1){
                    $active_payment_method = $pgws[0];
                }
            }
        }
        /*
        if (count($radio_array) > 1)
            $form->addElement(new Element_Radio(RM_UI_Strings::get('LABEL_SELECT_PAYMENT_METHOD'), "rm_payment_method", $radio_array, array('required' => 1, "value" => $active_payment_method, "class" => "rm_payment_method_select", "id" => "id_rm_payment_method_select", "style" => $this->form_options->style_textfield,"labelStyle" => $this->form_options->style_label)));
        elseif(count($radio_array) == 1)
        {
            $pgw = array_keys($radio_array);
            $form->addElement(new Element_Hidden("rm_payment_method", $pgw[0]));
        }
        */
        if($gopts->get_value_of('hide_pay_selector') != 'yes') {
            $form->addElement(new Element_Radio(RM_UI_Strings::get('LABEL_SELECT_PAYMENT_METHOD'), "rm_payment_method", $radio_array, array('required' => 1, "value" => $active_payment_method, "class" => "rm_payment_method_select", "id" => "id_rm_payment_method_select", "style" => $this->form_options->style_textfield,"labelStyle" => $this->form_options->style_label)));
        } else {
            $def_proc = get_option('rm_option_default_payment_method');
            $pgw = array_keys($radio_array);
            if(!empty($def_proc) && in_array($def_proc, $pgw)) {
                $form->addElement(new Element_Hidden("rm_payment_method", $def_proc));
            } else {
                $pgw = array_keys($radio_array);
                $form->addElement(new Element_Hidden("rm_payment_method", $pgw[0]));
            }
        }
        $form->addElement(new Element_HTML('</div>'));
        return $form;
    }
    
    public function set_preview($prev)
    {
         $this->preview= $prev;
    }

}
