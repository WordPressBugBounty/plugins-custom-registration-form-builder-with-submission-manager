<?php
class Element_State extends Element_Select {
	public function __construct($label, $name, $properties = null) {
		$options = array(
                  "" =>__("--Select State--",'custom-registration-form-builder-with-submission-manager'),
                  "AL" =>__("Alabama",'custom-registration-form-builder-with-submission-manager'),
                  "AK" =>__("Alaska",'custom-registration-form-builder-with-submission-manager'),
                  "AZ" =>__("Arizona",'custom-registration-form-builder-with-submission-manager'),
                  "AR" =>__("Arkansas",'custom-registration-form-builder-with-submission-manager'),
                  "CA" =>__("California",'custom-registration-form-builder-with-submission-manager'),
                  "CO" =>__("Colorado",'custom-registration-form-builder-with-submission-manager'),
                  "CT" =>__("Connecticut",'custom-registration-form-builder-with-submission-manager'),
                  "DE" =>__("Delaware",'custom-registration-form-builder-with-submission-manager'),
                  "DC" =>__("District of Columbia",'custom-registration-form-builder-with-submission-manager'),
                  "FL" =>__("Florida",'custom-registration-form-builder-with-submission-manager'),
                  "GA" =>__("Georgia",'custom-registration-form-builder-with-submission-manager'),
                  "HI" =>__("Hawaii",'custom-registration-form-builder-with-submission-manager'),
                  "ID" =>__("Idaho",'custom-registration-form-builder-with-submission-manager'),
                  "IL" =>__("Illinois",'custom-registration-form-builder-with-submission-manager'),
                  "IN" =>__("Indiana",'custom-registration-form-builder-with-submission-manager'),
                  "IA" =>__("Iowa",'custom-registration-form-builder-with-submission-manager'),
                  "KS" =>__("Kansas",'custom-registration-form-builder-with-submission-manager'),
                  "KY" =>__("Kentucky",'custom-registration-form-builder-with-submission-manager'),
                  "LA" =>__("Louisiana",'custom-registration-form-builder-with-submission-manager'),
                  "ME" =>__("Maine",'custom-registration-form-builder-with-submission-manager'),
                  "MD" =>__("Maryland",'custom-registration-form-builder-with-submission-manager'),
                  "MA" =>__("Massachusetts",'custom-registration-form-builder-with-submission-manager'),
                  "MI" =>__("Michigan",'custom-registration-form-builder-with-submission-manager'),
                  "MN" =>__("Minnesota",'custom-registration-form-builder-with-submission-manager'),
                  "MS" =>__("Mississippi",'custom-registration-form-builder-with-submission-manager'),
                  "MO" =>__("Missouri",'custom-registration-form-builder-with-submission-manager'),
                  "MT" =>__("Montana",'custom-registration-form-builder-with-submission-manager'),
                  "NE" =>__("Nebraska",'custom-registration-form-builder-with-submission-manager'),
                  "NV" =>__("Nevada",'custom-registration-form-builder-with-submission-manager'),
                  "NH" =>__("New Hampshire",'custom-registration-form-builder-with-submission-manager'),
                  "NJ" =>__("New Jersey",'custom-registration-form-builder-with-submission-manager'),
                  "NM" =>__("New Mexico",'custom-registration-form-builder-with-submission-manager'),
                  "NY" =>__("New York",'custom-registration-form-builder-with-submission-manager'),
                  "NC" =>__("North Carolina",'custom-registration-form-builder-with-submission-manager'),
                  "ND" =>__("North Dakota",'custom-registration-form-builder-with-submission-manager'),
                  "OH" =>__("Ohio",'custom-registration-form-builder-with-submission-manager'),
                  "OK" =>__("Oklahoma",'custom-registration-form-builder-with-submission-manager'),
                  "OR" =>__("Oregon",'custom-registration-form-builder-with-submission-manager'),
                  "PA" =>__("Pennsylvania",'custom-registration-form-builder-with-submission-manager'),
                  "RI" =>__("Rhode Island",'custom-registration-form-builder-with-submission-manager'),
                  "SC" =>__("South Carolina",'custom-registration-form-builder-with-submission-manager'),
                  "SD" =>__("South Dakota",'custom-registration-form-builder-with-submission-manager'),
                  "TN" =>__("Tennessee",'custom-registration-form-builder-with-submission-manager'),
                  "TX" =>__("Texas",'custom-registration-form-builder-with-submission-manager'),
                  "UT" =>__("Utah",'custom-registration-form-builder-with-submission-manager'),
                  "VT" =>__("Vermont",'custom-registration-form-builder-with-submission-manager'),
                  "VA" =>__("Virginia",'custom-registration-form-builder-with-submission-manager'),
                  "WA" =>__("Washington",'custom-registration-form-builder-with-submission-manager'),
                  "WV" =>__("West Virginia",'custom-registration-form-builder-with-submission-manager'),
                  "WI" =>__("Wisconsin",'custom-registration-form-builder-with-submission-manager'),
                  "WY" =>__("Wyoming",'custom-registration-form-builder-with-submission-manager')
            );
	    parent::__construct($label, $name, $options, $properties);
    }
}
