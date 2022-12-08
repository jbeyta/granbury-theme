<?php
	// select
	function cw_select($options = array(), $name = '', $label = '', $attributes = array(), $selected = null) {
		$output = '';

		if(!empty($label)) {
			$output .= '<label for="'.$name.'">'.$label.'</label>';
		}

		$atts = '';

		if(!empty($attributes)) {
			foreach ($attributes as $key => $value) {
				$atts .= ' '.$key.'="'.$value.'" ';
			}
		}

		$output .= '<select id="'.$name.'" name="'.$name.'" '.$atts.'>';
		foreach($options as $option) {

			$thisone = '';
			if(!empty($selected) && $selected == $option['value']) {
				$thisone = 'selected';
			}

			$output .= '<option value="'.$option['value'].'" '.$thisone.'>'.$option['name'].'</option>';
		}
		$output .= '</select>';

		return $output;
	}

	// text inputs, not a textarea
	function cw_input($type = 'text', $name = '', $placeholder = '', $label = '', $value = '') {
		$output = '';

		if(!empty($label)) {
			$output .= '<label for="'.$name.'">'.$label.'</label>';
		}

		$output .= '<input type="'.$type.'" id="'.$name.'" name="'.$name.'" placeholder="'.$placeholder.'" value="'.$value.'" />';

		return $output;
	}

	// textarea
	function cw_textarea($name = '', $placeholder = '', $label = '') {
		$output = '';

		if(!empty($label)) {
			$output .= '<label for="'.$name.'">'.$label.'</label>';
		}

		$output .= '<textarea id="'.$name.'" name="'.$name.'" placeholder="'.$placeholder.'">'.$value.'</textarea>';

		return $output;
	}

	// radio buttons
	function cw_radios($options = array(), $name = '', $checked = null) {
		$output = '';

		foreach($options as $option) {
			if(!empty($option['name'])) {
				$output .= '<label for="'.$name.'">'.$option['name'].'</label>';
			}

			$thisone = '';
			if(!empty($checked) && $checked == $option['value']) {
				$thisone = 'checked';
			}

			$output .= '<input id="'.$name.'" type="radio" value="'.$option['value'].'" name="'.$name.'" '.$thisone.'/>';
		}

		return $output;
	}

	// checkboxes
	function cw_checkboxes($options = array(), $name = '', $checked = null) {
		$output = '';

		foreach($options as $option) {
			if(!empty($option['name'])) {
				$output .= '<label for="'.$name.'">'.$option['name'].'</label>';
			}

			$thisone = '';
			if(!empty($checked) && $checked == $option['value']) {
				$thisone = 'checked';
			}

			$output .= '<input id="'.$name.'" type="checkbox" value="'.$option['value'].'" name="'.$name.'" '.$thisone.'/>';
		}

		return $output;
	}