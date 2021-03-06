<?php

namespace Nanozen\Utilities\Html;

use Nanozen\Utilities\Csrf;

/**
 * Class Form
 *
 * @author brslv
 * @package Nanozen\Utilities\Html
 */
class Form
{

	use PutsAttributes;
	use CanGenerateHiddenField;
	use GeneratesCsrfTokenSignature;
	use GeneratesHttpMethodSignature;

	public static function radio($name, $value, array $attributes = null, $text = null) 
	{
		if (is_null($text)) {
			$text = ucfirst($name);
		}
		
		return 
			InputBuilder::build('radio', $name, $value, $attributes, $text);
	}

	public static function checkbox($name, $value, array $attributes = null, $text = null)
	{
		if (is_null($text)) {
			$text = ucfirst($name);
		}

		return 
			InputBuilder::build('checkbox', $name, $value, $attributes, $text);
	}

	public static function text($name, array $attributes = null)
	{
		return InputBuilder::build('text', $name, null, $attributes);
	}

	public static function email($name, array $attributes = null)
	{
		return InputBuilder::build('email', $name, null, $attributes);
	}

	public static function input($name, array $attributes = null)
	{
		return InputBuilder::build($name, null, $attributes);
	}

	public static function submit($name, array $attributes = null)
	{
		return InputBuilder::build('submit', $name, null, $attributes);
	}	

	public static function password($name, array $attributes = null)
	{
		return InputBuilder::build('password', $name, null, $attributes);
	}

	public static function dropdown($name, array $options, array $attributes = null, $selected = null)
	{
		$dropdown = sprintf('<select name="' . $name . '" ');

		static::putAttributes($attributes, $dropdown);

		$dropdown .= '>';

		if (empty($options)) {
			return false;
		}

		foreach ($options as $optionValue => $optionText) {
            $option = sprintf('<option value="%s"> %s ', $optionValue, $optionText);
            
            if ( ! is_null($selected) && trim($selected) != "" && $optionValue == $selected) {
                $option = sprintf('<option value="%s" selected="selected"> %s ', $optionValue, $optionText);
            }
            
			$dropdown .= $option;
		}

		$dropdown .= "</select>";

		return $dropdown;	
	}

	public static function textarea($name, array $attributes = null)
	{
		$textarea = sprintf('<textarea name="%s"', $name);

		static::putAttributes($attributes, $textarea);

		$textarea .= '></textarea>';

		return $textarea;
	}

	public static function csrfToken()
	{
		return Csrf::generate();
	}

	public static function start($action, $method = null, array $attributes = null)
	{
		return FormBuilder::build($action, $method, $attributes);
	}

	public static function stop()
	{
		return '</form>';
	}

	public static function ajaxScript($button, $url, $method, $loadOn, $params = []) 
    {
        $ajax = '<script>';
        $ajax .= '$("' . $button . '").click(function (e) {'
                . 'e.preventDefault();';
        $ajax .= '$.ajax({';
        $ajax .= 'url: "' . $url . '",';
        $ajax .= 'method: "' . $method . '",';
        $ajax .= 'data: {';
        
        foreach ($params as $d) {
            $ajax .= substr($d, 1) . ': $("' . $d . '").val(),';
        }
        
        $ajax .= '}';
        $ajax .= '}).done(function (data) {';
        $ajax .= '$("' . $loadOn . '").text(data);';
        $ajax .= '})});</script>';
        
        return $ajax;
    }

}