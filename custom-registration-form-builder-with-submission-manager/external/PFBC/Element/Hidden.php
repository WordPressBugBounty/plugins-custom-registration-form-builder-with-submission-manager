<?php
class Element_Hidden extends Element {
	public $_attributes = array("type" => "hidden");

	public function __construct($name, $value = "", $properties = null) {
		if(!is_array($properties))
			$properties = array();

		if(!empty($value))
			$properties["value"] = $value;

		parent::__construct("", $name, $properties);
	}
}
