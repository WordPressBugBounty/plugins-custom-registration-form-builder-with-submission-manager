<?php

class Validation_UserEmail extends Validation{
	public $message;
        public $handler;
        
	public function __construct($message = "",$handler=null) {
                $this->handler= $handler;
		$this->message = empty($message) ? __('User email already exists.','custom-registration-form-builder-with-submission-manager') : $message;
	}
        
    public function getMessage() {
		return $this->message;
	}
	public function isNotApplicable($value) {
		if(is_null($value) || is_array($value) || $value === "")
			return true;
		return false;
	}
	public function isValid($value)
	{
		if($this->handler==null)
			return true;
		$is_valid = $this->handler->is_valid($value);
		if(!$is_valid) {
			$field_options = new stdClass();
			$field_options->email_exists_error = $this->message;
			$this->message = RM_Utilities::get_email_exists_error($field_options, get_user_by('email', $value), $this->message);
		}
		return $is_valid;
	}
}
