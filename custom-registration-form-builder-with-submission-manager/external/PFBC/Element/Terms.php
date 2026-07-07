<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Terms
 *
 * @author CMSHelplive
 */
class Element_Terms extends Element {
    public $terms;
    public $_attributes = array("rows" => "5");
    public $required_scroll;

    public function __construct($label, $name, $terms_text, $properties = null) {
        $configuration = array(
            "label" => $label,
            "name" => $name
        );

        /* Merge any properties provided with an associative array containing the label
          and name properties. */
        if (is_array($properties))
            $configuration = array_merge($configuration, $properties);

        $this->configure($configuration);
        $this->_attributes["default_value"] = $terms_text;
        $this->required_scroll = isset($properties['required_scroll']) ? $properties['required_scroll'] : null;
    }

   public function render()
    {       
       if(isset($this->_attributes["style"])){
           $style = "style='".$this->_attributes["style"]."'";
           unset($this->_attributes["style"]);
       }else
           $style = '';
          
       if(isset($this->_attributes['cb_label'])){
             $cb_label = $this->_attributes["cb_label"];
            unset($this->_attributes["cb_label"]);
         }
         else
             $cb_label = '';
         
       $scroll = '';
       if($this->required_scroll==1){
           $scroll = "scroll_down_end(this);";
       }
       
       $checked = '';
        if($this->getAttribute('value') == 'on')
            $checked = "checked";
       
       if(isset($this->_attributes["check_above_tc"]) && $this->_attributes["check_above_tc"] == 1)
           $this->render_checkbox($checked, $cb_label);
       
       echo "<div id='rm_terms_textarea' class='rm_terms_textarea'><textarea ", wp_kses_post((string)$style) ," onscroll='",esc_js($scroll),"' readonly  id='rm_terms_area_", esc_attr($this->_attributes['name']), "' class='rm_terms_area'>";
       
       if (!empty($this->_attributes["default_value"]))
           echo esc_html($this->filter(html_entity_decode($this->_attributes["default_value"])));
       echo "</textarea></div>";
       
       if(!isset($this->_attributes["check_above_tc"]) || $this->_attributes["check_above_tc"] == 0)
           $this->render_checkbox($checked, $cb_label);
   }

    protected function render_checkbox($checked, $cb_label)
    {
        $classes = 'rm_check_box';
        if ($this->required_scroll == 1) {
            $classes .= ' rm_terms_scroll_required';
        }
        if (!empty($this->_attributes['class'])) {
            $classes .= ' ' . $this->_attributes['class'];
        }

        $scroll_attrs = '';
        if ($this->required_scroll == 1) {
            $scroll_complete = $checked === 'checked' ? '1' : '0';
            $aria_disabled = $checked === 'checked' ? 'false' : 'true';
            $scroll_attrs = " data-rm-terms-scroll-required='1' data-rm-terms-scroll-complete='" . esc_attr($scroll_complete) . "' aria-disabled='" . esc_attr($aria_disabled) . "'";
        }

        echo "<div class='rm_terms_checkbox'><input ", esc_attr($checked), " value='on' type='checkbox'", wp_kses_post((string)$this->getAttributes(array("default_value", "value", "class"))), " class='", esc_attr($classes), "'", wp_kses_post((string)$scroll_attrs), ">".wp_kses_post((string)$cb_label)."</div>";
    }

    public function isValid($value, $form_id)
    {
        if ($this->is_terms_required() && $value !== 'on') {
            $element = !empty($this->label) ? $this->label : $this->_attributes["name"];
            if(substr($element, -1) == ":")
                $element = substr($element, 0, -1);
            $this->_errors[] = " <b>'" . $element . "'</b> " . RM_UI_Strings::get("ERROR_REQUIRED");
            return false;
        }

        return parent::isValid($value, $form_id);
    }

    protected function is_terms_required()
    {
        return $this->isRequired() || array_key_exists('required', $this->_attributes);
    }


    public function getAttributes($ignore = "") {

        $str = "";
        if (!empty($this->_attributes)) {
            if (!is_array($ignore))
                $ignore = array($ignore);
            $attributes = array_diff(array_keys($this->_attributes), $ignore);
            foreach ($attributes as $attribute) {
                $str .= ' ' . $attribute;
                if ($this->_attributes[$attribute] !== "" && !is_array($this->_attributes[$attribute] && $attribute === "default_value"))
                    $str .= '="' . $this->filter($this->_attributes[$attribute]) . '"';
            }
        }
        return $str;
    }

}
