<?php
class Element_Textbox extends Element {
	public $_attributes = array("type" => "text");
	public $prepend;
	public $append;

	public function render() {
		$addons = array();
		if(!empty($this->prepend))
			$addons[] = "input-prepend";
		if(!empty($this->append))
			$addons[] = "input-append";
		if(!empty($addons))
			echo '<div class="', wp_kses_post((string)implode(" ", $addons)), '">';

		$this->renderAddOn("prepend");
		parent::render();
		$this->renderAddOn("append");

		if(!empty($addons))
			echo '</div>';
	}

	public function renderAddOn($type = "prepend") {
		if(!empty($this->$type)) {
			$span = true;
			if(strpos($this->$type, "<button") !== false)
				$span = false;

			if($span)
				echo '<span class="add-on">';

			echo wp_kses_post((string)$this->$type);

			if($span)
				echo '</span>';
		}
	}
}
