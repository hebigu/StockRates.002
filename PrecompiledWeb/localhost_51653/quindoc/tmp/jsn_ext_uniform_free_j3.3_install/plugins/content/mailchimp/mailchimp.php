<?php

/**
 * @version     $Id: mailchimp.php 19014 2012-11-28 04:48:56Z anhnt $
 * @package     JSNUniform
 * @subpackage  Plugin
 * @author      JoomlaShine Team <support@joomlashine.com>
 * @copyright   Copyright (C) 2012 JoomlaShine.com. All Rights Reserved.
 * @license     GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 */
defined('_JEXEC') or die('Restricted Access');

jimport('joomla.plugin.plugin');
require_once 'class/Mailchimp.php';

class plgContentMailchimp extends JPlugin {

	public $mailchimp;
	public $listID = array();

	/**
	 * Constructor
	 *
	 * @param   object  &$subject  The object to observe
	 *
	 * @param   array   $config    An array that holds the plugin configuration
	 */
	public function __construct(&$subject, $config) {
		parent::__construct($subject, $config);
		JPlugin::loadLanguage('plg_uniform_mailchimp', JPATH_PLUGINS);
	}

	// load comment type layout
	public function loadLayout($tpl, $mailchimp) {
		$path = str_replace('administrator', '', JPATH_BASE) . '/plugins/content/mailchimp/layout/' . $tpl . '.php';
		if (file_exists($path)) {
			ob_start();
			include $path;
			$return = ob_get_contents();
			ob_end_clean();
			return $return;
		}
	}

	/**
	 * Check API key Mailchimp
	 *
	 * @param   string  &$str  API Key string
	 *
	 * @return msg
	 */
	public function checkApiKey($str) {
		// grab an API Key from http://admin.mailchimp.com/account/api/
		$mailchimp = new Mailchimp($str, array('ssl_verifypeer' => false));
		$mergeVars = array('EMAIL' => 'support@joomlashine.com');
		$list_id = '';
		$result = $mailchimp->lists->subscribe($list_id, array('email' => 'support@joomlashine.com'), $mergeVars, false, true, false, false);
		return $result;
	}

	/**
	 * Show All List Mailchimp
	 *
	 * @param   string  &$str  API Key string
	 * mergeVars($id)
	 * @return msg
	 */
	public function showListMailchimp($str) {
		$mailchimp = new Mailchimp($str, array('ssl_verifypeer' => false));
		$result = $mailchimp->lists->getList(array(), 0, 100, 'created', 'DESC');
		return $result;
	}

	/**
	 * Save form field to List Mailchimp
	 *
	 * @param   array  &$arr field array to save
	 *
	 * @return void
	 */
	public function saveFieldToList($str) {
		if (!empty($str)) {
			$arr = json_decode($str);
		}
		if (is_object($arr)) {
			$arr		= (array) $arr;
			$lisId		= (array) $arr['listId'];
			$label		= (array) $arr['label'];
			$uncheck	= (array) $arr['uncheck'];
			$arrLabel	=  array('Name', 'Email', 'Email Address', 'First Name', 'Last Name');
			$mailchimp	= new Mailchimp($arr['keyApi'], array('ssl_verifypeer' => false));
			$Arrmerge	= $mailchimp->lists->mergeVars($lisId);
			foreach ($label as $k=>$lb) {
				if (!in_array($lb, $arrLabel)) {
					foreach ($Arrmerge['data'] as $arrVar) {
						foreach ($arrVar['merge_vars'] as $var) {
							if ($lb !== $var['name']) {
								$array[$lb] = $k;
							}
							if ($uncheck != '') {
								if (in_array($var['name'], $uncheck)) {
									foreach ($lisId as $id) {
										$mailchimp->lists->mergeVarDel($id, $var['tag']);
									}
								}
							}
						}
					}
				}
			}
			if (isset($array) && !empty($array)) {
				$option = array('field_type' => 'text', 'req' => false, 'public' => true);
				foreach ($lisId as $id) {
					foreach ($array as $key=>$vl) {
						$mailchimp->lists->mergeVarAdd($id, 'JSN' . strtoupper($vl), $key, $option);
					}
				}
			}
		}
		return $result;
	}

	/**
	 * Save info form to Mailchimp server
	 *
	 * @param   array  &$arrField field array to save
	 * @param   array  &$post info array from submit form
	 * @return void
	 */
	public function saveInfoToMailchimp($arrField, $post) {
		if (isset($arrField) && !empty($arrField)) {
			$arrField = (array) json_decode($arrField);
			$apiKey = $arrField['keyApi'];
			$mailchimp	= new Mailchimp($apiKey, array('ssl_verifypeer' => false));
			$listId = (array) $arrField['listId'];
			$fieldlabel = (array) $arrField['fieldlabel'];
			if (isset($fieldlabel) && !empty($fieldlabel)) {
				foreach ($fieldlabel as $k => $v) {
					if (array_key_exists($k, $post)) {
						$arr[$v] = $post[$k];
					}else{
						$arr[$v] = $post[$v];
					}
				}
			}
		}
		$mergeVars='';
		if(isset($arr) && !empty($arr)){
			foreach ($arr as $key=>$vl){
				if($key == 'email'){
					$mergeVars['EMAIL']= $vl;
				}
				if($key == 'country'){
					$mergeVars['JSN'.strtoupper($key)]= $vl;
				}
				if($key == 'name'){
					foreach ($vl as $name){
						if($name['first'] !=''){
							$mergeVars['FNAME']= $name['first'];
						}
						if($name['last'] !=''){
							$mergeVars['LNAME']= $name['last'];
						}
					}
				}
				if($key == 'address'){
					foreach ($vl as $adress){
						if($adress['street'] !=''){
							$mergeVars['JSN'.strtoupper($key)].= $adress['street'].',';
						}
						if($adress['city'] !=''){
							$mergeVars['JSN'.strtoupper($key)].= $adress['city'].',';
						}
						if($adress['country'] !=''){
							$mergeVars['JSN'.strtoupper($key)].= $adress['country'];
						}
					}
				}
				if($key == 'phone'){
					foreach ($vl as $phone){
						if(isset($phone['default'])){
							$mergeVars['JSN'.strtoupper($key)]= $phone['default'];
						}
						if(isset($phone['one'])){
							$mergeVars['JSN'.strtoupper($key)]= $phone['one'];
						}
						if(isset($phone['one'])){
							$mergeVars['JSN'.strtoupper($key)].= $phone['two'];
						}
						if(isset($phone['one'])){
							$mergeVars['JSN'.strtoupper($key)].= $phone['three'];
						}
					}
				}
			}
		}
		if(isset($mergeVars) && !empty($mergeVars)){
			foreach ($listId as $id){
				$result = $mailchimp->lists->subscribe($id,array('email'=>$mergeVars['EMAIL']),$mergeVars,false,true,false,false);
			}
		}
	}
	
}
