<?php
if (!defined('WPINC')) {
    die('Closed');
}
if(defined('REGMAGIC_ADDON')) include_once(RM_ADDON_ADMIN_DIR . 'views/template_rm_form_email_templates.php'); else {
    
wp_enqueue_style( 'rm_material_icons', RM_BASE_URL . 'admin/css/material-icons.css' );
?>
<div class="rmagic">

    <!--Dialogue Box Starts-->
    <div class="rmcontent">


        <?php
        $form = new RM_PFBC_Form("form_sett_email_templates");
        $form->configure(array(
            "prevent" => array("bootstrap", "jQuery"),
            "action" => ""
        ));

        if (isset($data->model->form_id)) {
            $form->addElement(new Element_HTML('<div class="rmheader">' . $data->model->form_name . '</div>'));
            $form->addElement(new Element_HTML('<div class="rmsettingtitle">' . RM_UI_Strings::get('LABEL_F_EMAIL_TEMP_SETT') . '</div>'));
            $form->addElement(new Element_HTML('<div class="rmrow"><div class="rmnotice">More email configuration settings are available in <a target="_blank" href="admin.php?page=rm_options_autoresponder">Global Settings</a>.</div></div>'));
            $form->addElement(new Element_Hidden("form_id", $data->model->form_id));
        }
        
        $form->addElement(new Element_HTML('<div class="rmrow"><h3>'.__('Notification Templates for User', 'custom-registration-form-builder-with-submission-manager').'</h3></div>'));
        
        $form->addElement(new Element_Textbox("<b>" . RM_UI_Strings::get('LABEL_NEW_USER_EMAIL_SUB') . "</b>", "form_nu_notification_sub", array("class" => "rm_static_field", "value" =>  $data->model->form_options->form_nu_notification_sub, "longDesc"=>RM_UI_Strings::get('HELP_ADD_FORM_NU_EMAIL_SUB'))));
        $form->addElement(new Element_TinyMCEWP("<b>" . RM_UI_Strings::get('LABEL_NEW_USER_EMAIL') . "</b>(".__('Mail Merge and HTML Supported', 'custom-registration-form-builder-with-submission-manager')."):", $data->model->get_notification_messages('form_nu_notification'), "form_nu_notification", array('editor_class' => 'rm_TinydMCE', 'editor_height' => '100px'), array("longDesc" => RM_UI_Strings::get('HELP_ADD_FORM_NU_EMAIL_MSG'))));
        
        $form->addElement(new Element_Textbox("<b>" . RM_UI_Strings::get('LABEL_USER_ACTIVATION_EMAIL_SUB') . "</b>", "form_user_activated_notification_sub", array("class" => "rm_static_field", "value" =>  $data->model->form_options->form_user_activated_notification_sub, "longDesc"=>RM_UI_Strings::get('HELP_ADD_FORM_USER_ACTIVATED_SUB'))));
        $form->addElement(new Element_TinyMCEWP("<b>" . RM_UI_Strings::get('LABEL_USER_ACTIVATION_EMAIL') . "</b>(".__('Mail Merge and HTML Supported', 'custom-registration-form-builder-with-submission-manager')."):", $data->model->get_notification_messages('form_user_activated_notification'), "form_user_activated_notification", array('editor_class' => 'rm_TinydMCE', 'editor_height' => '100px'), array("longDesc" => RM_UI_Strings::get('HELP_ADD_FORM_USER_ACTIVATED_MSG'))));
        
        $form->addElement(new Element_Textbox("<b>" . RM_UI_Strings::get('LABEL_USER_PAYMENT_INVOICE_EMAIL_SUB') . "</b>", "form_user_payment_invoice_sub", array("class" => "rm_static_field", "value" =>  $data->model->form_options->form_user_payment_invoice_sub, "longDesc"=>RM_UI_Strings::get('HELP_ADD_FORM_USER_PI_SUB'))));
        $form->addElement(new Element_TinyMCEWP("<b>" . RM_UI_Strings::get('LABEL_USER_PAYMENT_INVOICE_EMAIL') . "</b>(".__('Mail Merge and HTML Supported', 'custom-registration-form-builder-with-submission-manager')."):", $data->model->get_notification_messages('form_user_payment_invoice'), "form_user_payment_invoice", array('editor_class' => 'rm_TinydMCE', 'editor_height' => '100px'), array("longDesc" => RM_UI_Strings::get('HELP_ADD_FORM_USER_PI_MSG'))));
    
        $form->addElement(new Element_HTML('<div class="rmrow"><h3>Notification Templates for Admin</h3></div>'));
        
        //$form->addElement(new Element_TinyMCEWP("<b>" . RM_UI_Strings::get('LABEL_ACTIVATE_USER_EMAIL') . "</b>(Mail Merge and HTML Supported):", $data->model->get_notification_messages('form_activate_user_notification'), "form_activate_user_notification", array('editor_class' => 'rm_TinydMCE', 'editor_height' => '100px'), array("longDesc" => RM_UI_Strings::get('HELP_ADD_FORM_ACTIVATE_USER_MSG'))));
        $admin_ns_subject_field_service = new RM_Editor_Actions_Service();
        $admin_ns_subject_fields = $admin_ns_subject_field_service->add_email($data->model->form_id);
        $admin_ns_subject_field_select = '';
        if (!empty($admin_ns_subject_fields)) {
            $admin_ns_subject_field_options = '<option value="0">' . esc_html(RM_UI_Strings::get("LABEL_ADD_EMAIL")) . '</option>';
            foreach ($admin_ns_subject_fields as $admin_ns_subject_field) {
                $admin_ns_subject_field_value = $admin_ns_subject_field->field_type . '_' . $admin_ns_subject_field->field_id;
                $admin_ns_subject_field_type = strtolower($admin_ns_subject_field->field_type);
                if ($admin_ns_subject_field_type == 'username') {
                    $admin_ns_subject_field_value = 'Username';
                } else if ($admin_ns_subject_field_type == 'userpassword') {
                    $admin_ns_subject_field_value = 'UserPassword';
                }
                $admin_ns_subject_field_options .= '<option value="' . esc_attr($admin_ns_subject_field_value) . '">' . esc_html($admin_ns_subject_field->field_label) . '</option>';
            }
            $admin_ns_subject_field_select = '<select id="rm_editor_add_admin_ns_email_subject">' . $admin_ns_subject_field_options . '</select>';
        }
        $form->addElement(new Element_HTML(
            '<div class="rmrow"><div class="rmfield" for="form_admin_ns_notification_sub"><label><b>' . RM_UI_Strings::get('LABEL_ADMIN_NEW_SUBMISSION_EMAIL_SUB') . '</b></label></div><div class="rminput"><div class="rm-notification-sb-wrap"><input type="text" name="form_admin_ns_notification_sub" id="form_admin_ns_notification_sub" class="rm_static_field" value="' . esc_attr($data->model->form_options->form_admin_ns_notification_sub) . '">' . $admin_ns_subject_field_select . '</div></div><div class="rmnote"><div class="rmprenote"></div><div class="rmnotecontent">' . RM_UI_Strings::get('HELP_ADD_FORM_ADMIN_NS_SUB') . '</div></div></div>'
        ));
        $form->addElement(new Element_TinyMCEWP("<b>" . RM_UI_Strings::get('LABEL_ADMIN_NEW_SUBMISSION_EMAIL') . "</b>(".__('Mail Merge and HTML Supported', 'custom-registration-form-builder-with-submission-manager')."):", $data->model->get_notification_messages('form_admin_ns_notification'), "form_admin_ns_notification", array('editor_class' => 'rm_TinydMCE', 'editor_height' => '100px'), array("longDesc" => RM_UI_Strings::get('HELP_ADD_FORM_ADMIN_NS_MSG').RM_UI_Strings::get('MSG_BUY_PRO_INLINE'))));
        
        $form->addElement(new Element_HTMLL('&#8592; &nbsp; '.__('Cancel','custom-registration-form-builder-with-submission-manager'), '?page='.$data->next_page.'&rm_form_id=' . $data->model->form_id, array('class' => 'cancel')));
        $form->addElement(new Element_Button(RM_UI_Strings::get('LABEL_SAVE'), "submit", array("id" => "rm_submit_btn", "class" => "rm_btn", "name" => "submit", "onClick" => "jQuery.prevent_field_add(event,'".__('This is a required field.','custom-registration-form-builder-with-submission-manager')."')")));
        $form->render();
        ?>
    </div>
</div>


<?php } ?>
