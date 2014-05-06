<?php
/**
 * mm_default
 * @version 1.1.1 (2014-02-13)
 * 
 * @desc A widget for ManagerManager plugin that allows field (or TV) default value for a new document/folder to be set.
 * 
 * @uses ManagerManager plugin 0.4.
 * @uses ManagerManager.mm_ddSetFieldValue 1.1.
 * 
 * @param $field {string} - The name of the document field (or TV) this should apply to. @required
 * @param $value {string} - The default value for the field. The current date/time will be used for the fields equals 'pub_date' or 'unpup_date' with empty value. A static value can be supplied as a string, or PHP code (to calculate something) can be supplied if the eval parameter is set as true. Default: ''.
 * @param $roles {comma separated string} - The roles that the widget is applied to (when this parameter is empty then widget is applied to the all roles). Default: ''.
 * @param $templates {comma separated string} - Id of the templates to which this widget is applied (when this parameter is empty then widget is applied to the all templates). Default: ''.
 * @param $eval {bollean} - Should the value be evaluated as PHP code? Default: false.
 * 
 * @event OnDocFormRender
 * 
 * @link http://code.divandesign.biz/modx/mm_default/1.1.1
 * 
 * @copyright 2014
 */

function mm_default($field, $value = '', $roles = '', $templates = '', $eval = false){
	global $modx;
	$e = &$modx->Event;
	
	// if we aren't creating a new document or folder, we don't want to do this
	// Which action IDs so we want to do this for?
	// 85 =
	// 4 =
	// 72 = Create new weblink
	
	$allowed_actions = array('85', '4', '72');
	
	if (!in_array($modx->manager->action, $allowed_actions)){
		return;
	}
	
	if ($e->name == 'OnDocFormRender' && useThisRule($roles, $templates)){
		// What's the new value, and does it include PHP?
		$value = ($eval) ? eval($value) : $value;
		
		$e->output("//---------- mm_default :: Begin -----\n");
		
		mm_ddSetFieldValue($field, $value, $roles, $templates);
		
		$e->output("//---------- mm_default :: End -----\n");
	}
}
?>