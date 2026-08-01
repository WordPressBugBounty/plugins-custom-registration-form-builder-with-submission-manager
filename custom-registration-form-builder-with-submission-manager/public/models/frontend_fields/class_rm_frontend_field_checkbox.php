<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RM_Frontend_Field_Checkbox extends RM_Frontend_Field_Multivalue
{
    public function __construct($id, $label, $name, $options, $value, $page_no = 1, $is_primary = false, $extra_opts = null)
    {
        $name = ($name == '') ? 'Checkbox_' . $id : $name;
        parent::__construct($id, 'Checkbox', $name, $label, $options, $value, $page_no, $is_primary, $extra_opts);
        $this->field_value = RM_Utilities::process_field_options($value);
    }

    public function get_prepared_data($request)
    {
        $data = new stdClass;
        $data->field_id = $this->get_field_id();
        $data->type = $this->get_field_type();
        $data->label = $this->get_field_label();

        if (!isset($request[$this->field_name])) {
            $data->value = null;
            return $data;
        }

        if (!is_array($request[$this->field_name])) {
            $data->value = null;
            return $data;
        }

        $data->value = array();
        foreach ($request[$this->field_name] as $val) {
            if (is_array($val)) {
                continue;
            }

            $data->value[] = sanitize_textarea_field($val);
        }

        return $data;
    }

}
