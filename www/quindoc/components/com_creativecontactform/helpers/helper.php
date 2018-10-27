<?php
/**
 * Joomla! component Creative Contact Form
 *
 * @version $Id: 2012-04-05 14:30:25 svn $
 * @author creative-solutions.net
 * @package Creative Contact Form
 * @subpackage com_creativecontactform
 * @license GNU/GPL
 *
 */

// no direct access
defined('_JEXEC') or die('Restircted access');

class CreativecontactformHelper
{

	//function to add scripts/styles
	private function add_scripts() {

		$version = '2.0.0';

		$document = JFactory::getDocument();

		$types_array = $this->types_array;
		$form_id = $this->form_id;

		$cssFile = JURI::base(true).'/components/com_creativecontactform/assets/css/main.css?version='.$version;
		$document->addStyleSheet($cssFile, 'text/css', null, array());

		$cssFile = JURI::base(true).'/components/com_creativecontactform/assets/css/creativecss-ui.css';
		$document->addStyleSheet($cssFile, 'text/css', null, array());

		$cssFile = JURI::base(true).'/components/com_creativecontactform/assets/css/creative-scroll.css';
		$document->addStyleSheet($cssFile, 'text/css', null, array());

		$cssFile = JURI::base(true).'/components/com_creativecontactform/generate.css.php?id_form='.$form_id.'&module_id=0';
		$document->addStyleSheet($cssFile, 'text/css', null, array());

		if(in_array('file-upload',$types_array)) {
			$cssFile = JURI::base(true).'/components/com_creativecontactform/assets/css/creative-upload.css';
			$document->addStyleSheet($cssFile, 'text/css', null, array());
		}

		$jsFile = JURI::base(true).'/components/com_creativecontactform/assets/js/creativelib.js';
		$document->addScript($jsFile);

		$jsFile = JURI::base(true).'/components/com_creativecontactform/assets/js/creativelib-ui.js';
		$document->addScript($jsFile);

		$jsFile = JURI::base(true).'/components/com_creativecontactform/assets/js/creative-mousewheel.js';
		$document->addScript($jsFile);

		if(in_array('file-upload',$types_array)) {
			$jsFile = JURI::base(true).'/components/com_creativecontactform/assets/js/jquery.iframe-transport.js';
			$document->addScript($jsFile);
			
			$jsFile = JURI::base(true).'/components/com_creativecontactform/assets/js/jquery.fileupload.js';
			$document->addScript($jsFile);
			
			$jsFile = JURI::base(true).'/components/com_creativecontactform/assets/js/jquery.fileupload-process.js';
			$document->addScript($jsFile);
			
			$jsFile = JURI::base(true).'/components/com_creativecontactform/assets/js/jquery.fileupload-validate.js';
			$document->addScript($jsFile);
		}

		$jsFile = JURI::base(true).'/components/com_creativecontactform/assets/js/creativecontactform.js?version='.$version;
		$document->addScript($jsFile);

	}
	
	private function get_data() {
		$db = JFactory::getDBO();

		//get field types array/////////////////////////////////////////////////////////////////////////////////////////////////
		$query = "
					SELECT
					sp.id,
					st.name as type
					FROM
					`#__creative_fields` sp
					JOIN `#__creative_field_types` st ON st.id = sp.id_type
					WHERE sp.published = '1'
					AND sp.id_form = '".$this->form_id."'
					ORDER BY sp.ordering,sp.id
				";
		$db->setQuery($query);
		$types_array_data = $db->loadAssocList();
		$types_array_index = 1;
		$types_array = array();
		if(is_array($types_array_data)) {
			foreach($types_array_data as $type) {
				$types_array[$types_array_index] = strtolower(str_replace(' ','-',str_replace('-','',$type['type'])));
				$types_array_index ++;
			}
		}
		$this->types_array = $types_array;

		//get form data/////////////////////////////////////////////////////////////////////////////////////////////////
		$query = "
					SELECT
					sp.`id_template`,
					sp.name,
					sp.top_text,
					sp.pre_text,
					sp.thank_you_text,
					sp.send_text,
					sp.send_new_text,
					sp.close_alert_text,
					sp.form_width,
					sp.redirect,
					sp.redirect_itemid,
					sp.redirect_url,
					sp.redirect_delay,
					sp.shake_count,
					sp.shake_distanse,
					sp.send_copy_enable,
					sp.send_copy_text,
					sp.shake_duration
					FROM
					`#__creative_forms` sp
					WHERE sp.published = '1'
					AND sp.id = '".$this->form_id."'";
		$db->setQuery($query);
		$this->form_data = $db->loadAssoc();

		//get fields data/////////////////////////////////////////////////////////////////////////////////////////////////
		$query = "
					SELECT
					sp.id,
					sp.name,
					sp.required,
					sp.ordering_field,
					sp.select_default_text,
					sp.show_parent_label,
					sp.select_no_match_text,
					sp.width,
					sp.select_show_scroll_after,
					sp.select_show_search_after,
					sp.upload_button_text,
					sp.upload_minfilesize,
					sp.upload_maxfilesize,
					sp.upload_acceptfiletypes,
					sp.upload_minfilesize_message,
					sp.upload_maxfilesize_message,
					sp.upload_acceptfiletypes_message,
					sp.captcha_wrong_message,
					st.name as type
				FROM
					`#__creative_fields` sp
				JOIN `#__creative_field_types` st ON st.id = sp.id_type
				WHERE sp.published = '1'
				AND sp.id_form = '".$this->form_id."'
				ORDER BY sp.ordering,sp.id
		";
		$db->setQuery($query);
		$this->field_data = $db->loadAssocList();

		//get fields data/////////////////////////////////////////////////////////////////////////////////////////////////
		$REMOTE_ADDR = null;
		if(isset($_SERVER['REMOTE_ADDR'])) {
			$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
		}
		elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$REMOTE_ADDR = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		elseif(isset($_SERVER['HTTP_CLIENT_IP'])) {
			$REMOTE_ADDR = $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif(isset($_SERVER['HTTP_VIA'])) {
			$REMOTE_ADDR = $_SERVER['HTTP_VIA'];
		}
		else { $REMOTE_ADDR = 'Unknown';
		}
		$this->remote_addr = $REMOTE_ADDR;
	}
	
	public function render_html()
	{
		$db = JFactory::getDBO();
		//get data/////////////////////////////////////////////////////////////////////////////////////////////////////////
		$this->get_data();

		//add scripts/////////////////////////////////////////////////////////////////////////////////////////////////////
		if($this->type != 'plugin')
			$this->add_scripts();
		
		//Get variables////////////////////////////////////////////////////////////////////////////////////////////////////
		$module_id = $this->module_id;
		$form_data = $this->form_data;
		$field_data = $this->field_data;
		$types_array = $this->types_array;
		$form_id = $this->form_id;
		$templateid = $form_data['id_template'];
		$REMOTE_ADDR = $this->remote_addr;
		$user = JFactory::getUser();

		$toptxt = $form_data['top_text'];
		$pretxt = $form_data['pre_text'];
		$form_width = $form_data['form_width'];
		$redirect_enable =  $form_data['redirect'];
		$redirect = '';
		if ($redirect_enable) {
			$redirectItemId = (int) $form_data['redirect_itemid'] == 0 ? 1 : (int) $form_data['redirect_itemid'];
			$redirectUrl = $form_data['redirect_url'];
			if ($redirectUrl != '') {
				$redirect = JRoute::_($redirectUrl, false);
			} else {
				$redirect = JRoute::_('index.php?Itemid='.$redirectItemId);
			}
		}
		$redirect_delay = (int) $form_data['redirect_delay'];
		$thank_you_text = htmlspecialchars($form_data['thank_you_text'],ENT_QUOTES);
		$send_text = htmlspecialchars($form_data['send_text'],ENT_QUOTES);
		$send_new_text = htmlspecialchars($form_data['send_new_text'],ENT_QUOTES);
		$close_alert_text = htmlspecialchars($form_data['close_alert_text'],ENT_QUOTES);

		//validation options
		$shake_count = (int) $form_data['shake_count'];
		$shake_distanse = (int) $form_data['shake_distanse'];
		$shake_duration = (int) $form_data['shake_duration'];

		//send copy options
		$send_copy_enable= (int) $form_data['send_copy_enable'];
		$send_copy_text=htmlspecialchars($form_data['send_copy_text'],ENT_QUOTES);

		//strat rendering html///////////////////////////////////////////////////////////////////////////////////////////////
		ob_start();
		if(sizeof($field_data) > 0) {
			?>
			<div class="creativecontactform_wrapper creative_form_module creative_form_<?php echo $form_id;?>" <?php if($form_width != '') { echo 'style="width: '.$form_width.' !important"'; }?>>
				<div class="creativecontactform_loading_wrapper"><table style="border: none;width: 100%;height: 100%"><tr><td align="center" valign="middle"><img src="<?php echo JURI::base(true).'/components/com_creativecontactform/assets/images/ajax-loader.gif';?>" /></td></tr></table></div>
	 			<div class="creativecontactform_wrapper_inner">
	 				<form class="creativecontactform_form">
			 			<div class="creativecontactform_title"><?php echo $toptxt;?></div>
			 			<?php $pre_hidden = $pretxt == '' ? 'style="display:none"' : '';?><div <?php echo $pre_hidden;?> class="creativecontactform_pre_text"><?php echo $pretxt;?></div>
			 			<div class="creative_title_holder">&nbsp;</div>
			 			
				 		<?php 
		 				if(sizeof($field_data) > 0) {
		 					$field_index = 1;
		 					foreach($field_data as $field) {
		 						$field_width = $field['width'] != '' ? 'style="width: '.$field['width'].' !important"' : '';
		 						$field_width_select = $field['width'] != '' ? $field['width'] : '';
		 						
		 						$field_name = stripslashes($field['name']);
		 						$field_type = strtolower(str_replace(' ','-',str_replace('-','',$field['type'])));
		 						$element_id = $field_type.'_'.$module_id.'_'.$field['id'];
		 						$required_classname = $field['required'] == 1 ? 'creativecontactform_required' : '';
		 						$required_symbol = $field['required'] == 1 ? ' <span class="creativecontactform_field_required">*</span>' : '';
		 						$predefined_value = $field_type == 'name' ? $user->name : ($field_type == 'email' ? $user->email : '');
		 						
		 						//input html
		 						$input_type_text_arrays = array('text-input','name','address','email','phone','number','url');
		 						if(in_array($field_type,$input_type_text_arrays)) {
		 							$input_html = '<div '.$field_width.' class="creativecontactform_input_element '.$required_classname.'"><div class="creative_input_dummy_wrapper"><input class="creative_'.$field_type.' '.$required_classname.' creative_input_reset" pre_value="'.str_replace('"','',$predefined_value).'" value="'.str_replace('"','',$predefined_value).'" type="text" id="'.$element_id.'" name="creativecontactform_fields['.$field_index.'][0]"></div></div>';
		 						}
		 						elseif($field_type == 'text-area') {
		 							$input_html = '<div '.$field_width.' class="creativecontactform_input_element creative_textarea_wrapper '.$required_classname.'"><div class="creative_textarea_dummy_wrapper"><textarea class="creative_textarea creative_'.$field_type.' '.$required_classname.' creative_textarea_reset" value="'.$predefined_value.'" cols="30" rows="15" id="'.$element_id.'" name="creativecontactform_fields['.$field_index.'][0]"></textarea></div></div>';
		 						}
		 						elseif($field_type == 'select' || $field_type == 'multiple-select' || $field_type == 'radio' || $field_type == 'checkbox') {
		 							//get child options
		 							$query = "
					 							SELECT
						 							spo.name,
						 							spo.id,
						 							spo.value,
						 							spo.selected
					 							FROM
					 								`#__creative_form_options` spo
					 							WHERE spo.id_parent = '".$field['id']."'
					 							AND spo.showrow = '1'
					 							ORDER BY ";
					 							if($field['ordering_field'] == 0)
					 								$query .= "spo.ordering";
					 							else
					 								$query .= "spo.name";
		 							$db->setQuery($query);
		 							$childs_array = $db->loadAssocList();
		 							if (sizeof($childs_array) > 0)
		 							{
		 								$childs_length = sizeof($childs_array);
		 								if($field_type == 'select' || $field_type == 'multiple-select') {
		 									$selected_count = 0;
		 									foreach ($childs_array as $key => $value)
		 									{
		 										if($value['selected'] == 1) {
		 											$selected_count= 1;
		 											break;
		 										}
		 									}
		 									$def_selection = $selected_count == 0 ? 'selected="selected"' : '';
		 									
			 								$show_search = $childs_length >= $field["select_show_search_after"] ? 'show' : 'hide';
			 								$scroll_after = (int)$field["select_show_scroll_after"] > 3 ? (int)$field["select_show_scroll_after"] : 3;
			 								
			 								$multile_info = $field_type == 'multiple-select' ? 'multiple="multiple"' : '';
			 								$multile_info_val = $field_type == 'multiple-select' ? '[]' : '';
			 								$input_html = '<select show_search="'.$show_search.'" scroll_after="'.$scroll_after.'" special_width="'.$field_width_select.'" select_no_match_text="'.stripslashes(str_replace('"','',$field["select_no_match_text"])).'" class="will_be_creative_select '.$required_classname.'" '.$multile_info.' name="creativecontactform_fields['.$field_index.'][0]'.$multile_info_val.'">';
			 								$input_html .= '<option '.$def_selection.' class="def_value" value="creative_empty">'.$field["select_default_text"].'</option>';
			 								$selected = '';
		 									$pre_val='';
			 								$seted_value = false;
			 								foreach ($childs_array as $key => $value)
			 								{
			 									if(!$seted_value && $field_type == 'select' && $value['selected'] == '1') {
			 										$selected = 'selected="selected"';
			 										$pre_val = 'pre_val="selected"';
			 										$seted_value = true;
			 									}
				 								elseif($field_type == 'multiple-select'  &&  $value['selected'] == '1') {
			 										$selected = 'selected="selected"';
			 										$pre_val = 'pre_val="selected"';
				 								}
			 									else {
			 										$selected = '';
			 										$pre_val = '';
			 									}
			 									
			 									$input_html .= '<option id="'.$module_id.'_'.$field["id"].'_'.$value["id"].'" value="'.stripslashes(str_replace('"','',$value["value"])).'" '.$selected.' '.$pre_val.'>'.stripslashes($value["name"]).'</option>';
			 								}
			 								$input_html .= '</select>';
		 								}
		 								elseif($field_type == 'radio' || $field_type == 'checkbox') {
		 									$input_html = '';
		 									$colors_array = array("black","blue","red","litegreen","yellow","liteblue","green","crimson","litecrimson");
		 									$selected = '';
		 									$pre_val='';
		 									$seted_value = false;
		 									foreach ($childs_array as $key => $value)
		 									{
		 										if($field_type == 'radio' && !$seted_value && $value['selected'] == '1') {
		 											$selected = 'checked="checked"';
		 											$pre_val = 'pre_val="checked"';
		 											$seted_value = true;
		 										}
		 										elseif($field_type == 'checkbox'  &&  $value['selected'] == '1') {
		 											$selected = 'checked="checked"';
													$pre_val = 'pre_val="checked"';	 											
		 										}
		 										else {
		 											$selected = '';
													$pre_val = '';	 											
		 										}
		 										
		 										$data_color_index = $key % 8;
		 										
		 										$label_class = $field['show_parent_label'] == 0 ? 'without_parent_label' : '';
		 										$req_symbol = ($field['show_parent_label'] == 0 && $key == 0) ? $required_symbol : '';
		 										$input_html .= '<div class="answer_name"><label uniq_index="'.$module_id.'_'.$field["id"].'_'.$value["id"].'" class="twoglux_label '.$label_class.'">'.stripslashes($value["name"]).' '.$req_symbol.'</label></div>';
		 										$input_html .= '<div class="answer_input">';
		 										
		 										if($field_type == 'radio')
		 											$input_html .= '<input '.$selected.' '.$pre_val.' id="'.$module_id.'_'.$field["id"].'_'.$value["id"].'" type="radio" class="creative_ch_r_element creativeform_twoglux_styled elem_'.$module_id.'_'.$field["id"].'" value="'.stripslashes(str_replace('"','',$value["value"])).'" uniq_index="elem_'.$module_id.'_'.$field["id"].'" name="remove_this_partcreativecontactform_fields['.$field_index.'][0]" data-color="'.$colors_array[$data_color_index].'" />';
		 										else
		 											$input_html .= '<input '.$selected.' '.$pre_val.' id="'.$module_id.'_'.$field["id"].'_'.$value["id"].'" type="checkbox" class="creative_ch_r_element creativeform_twoglux_styled" value="'.stripslashes(str_replace('"','',$value["value"])).'" name="creativecontactform_fields['.$field_index.'][0][]" data-color="'.$colors_array[$data_color_index].'" />';
		 										
		 										$input_html .= '</div><div class="creative_clear"></div>';
		 									}
		 								}
		 							}
		 							else {
		 								$input_html = 'There are no options to be shown.';
		 							}
		 						}
		 						elseif($field_type == 'captcha') {
		 							$input_html = '<img id="creative_captcha_'.$module_id.'_'.$field["id"].'" class="creative_captcha" src="components/com_creativecontactform/captcha.php?fid='.$field["id"].'&r='.rand(100000,999999).'" /><div fid="'.$field["id"].'" holder="creative_captcha_'.$module_id.'_'.$field["id"].'" class="reload_creative_captcha"></div><div class="creative_clear"></div>';
		 							$input_html .= '<div style="width: 200px !important;" class="creativecontactform_input_element creativecontactform_required creative_captcha_input_wrapper"><div class="creative_input_dummy_wrapper"><input class="creative_'.$field_type.' creativecontactform_required creative_input_reset" value="" type="text" id="'.$element_id.'" name="creativecontactform_captcha['.$field["id"].']"></div></div><div class="creative_captcha_info" style="display:none">'.stripslashes($field["captcha_wrong_message"]).'</div>';
		 						}
		 						elseif($field_type == 'file-upload') {
		 							$input_html = '
		 											<div class="creative_fileupload_wrapper">
		 												<span class="creative_fileupload">
												        	<i class="icon_creative_plus"></i>
												        	<span>'.$field["upload_button_text"].'</span>
												        	<input class="creative_fileupload_submit" type="file" name="files[]" multiple>
												   		</span>
												   		<div class="creative_progress">
												       		<div class="bar"></div>
												   		</div>
												   		<div class="creative_uploaded_files"></div>
												   		<div class="creative_upload_info" style="display: none" 
			 												upload_maxfilesize="'.$field["upload_maxfilesize"].'" 
			 												upload_minfilesize="'.$field["upload_minfilesize"].'" 
			 												upload_acceptfiletypes="'.$field["upload_acceptfiletypes"].'" 
			 												upload_minfilesize_message="'.str_replace('"','',$field["upload_minfilesize_message"]).'" 
			 												upload_maxfilesize_message="'.str_replace('"','',$field["upload_maxfilesize_message"]).'" 
			 												upload_acceptfiletypes_message="'.str_replace('"','',$field["upload_acceptfiletypes_message"]).'">
			 											</div>
												   		<div class="creative_clear"></div>
		 											</div>';
		 						}
		 						if($field_type != 'file-upload' && $field_type != 'captcha')
		 							$input_html .= '<input type="hidden" name="creativecontactform_fields['.$field_index.'][1]" value="'.stripslashes(str_replace('"','',$field_name)).'" />';
		 						//start printing html
		 						$radio_checkbox_class = ($field_type == 'radio' || $field_type == 'checkbox' || $field_type == 'file-upload') ? 'creative_'.$field_type : '';
		 						$radio_checkbox_req_class = ($field_type == 'radio' || $field_type == 'checkbox'  || $field_type == 'file-upload') ? $required_classname : '';
		 						echo '<div class="creativecontactform_field_box '.$radio_checkbox_class.' '.$radio_checkbox_req_class.'">';
		 							$show_label = $field['show_parent_label'] == 1 ? '' : 'style="display:none !important"';
		 							echo '<label class="creativecontactform_field_name" for="'.$element_id.'" '.$show_label.'>'.$field_name;
		 							if($field_type == 'captcha')
		 								echo ' <span class="creativecontactform_field_required">*</span></label>';
		 							else	
		 								echo $required_symbol.'</label>';
		 							echo $input_html;
		 						echo '</div>';
		 						
		 						$field_index ++;
		 					}
		 				}
		 				
		 				if($send_copy_enable == 1) {
		 					echo '<div class="creativecontactform_field_box">';
			 					echo '
			 							<div class="answer_name"><label uniq_index="'.$module_id.'_0_0" class="twoglux_label without_parent_label">'.$send_copy_text.'</label></div>
			 							<div class="answer_input"><input id="'.$module_id.'_0_0" type="checkbox" class="creativeform_twoglux_styled" value="1" name="creativecontactform_send_copy_enable" data-color="blue" /></div><div class="creative_clear"></div>';
			 				echo '</div>';
		 				}
		 				?>
		 				
			 			<div class="creativecontactform_submit_wrapper">
			 				<input type="button" value="<?php echo $send_text;?>" class="creativecontactform_send" roll="<?php echo $form_id;?>" />
			 				<input type="button" value="<?php echo $send_new_text;?>" class="creativecontactform_send_new creativecontactform_hidden"  roll="<?php echo $form_id;?>"/>
			 				<div class="creativecontactform_clear"></div>
			 			</div>
			 			<div class="creativecontactform_clear"></div>
			 			<input type="hidden" name="<?php echo JSession::getFormToken();?>" class="creativecontactform_token" value="1" />
			 			<input type="hidden" value="<?php echo $REMOTE_ADDR;?>"  name="creativecontactform_ip" />
			 			<input type="hidden" value="<?php echo JURI::current();?>"  name="creativecontactform_referrer" />
			 			<input type="hidden" value="<?php echo $module_id;?>" class="creativecontactform_module_id" name="creativecontactform_module_id" />
			 			<input type="hidden" value="<?php echo $form_id;?>" class="creativecontactform_form_id" name="creativecontactform_form_id" />
		 			</form>
		 			<?php echo '<div class="creative_clear">&nbsp;</div><div class="powered_by powered_by_'.$templateid.'">Powered By <a href="http://creative-solutions.net/joomla/creative-contact-form" target="_blank">Creative Contact Form</a></div><div class="creative_clear">&nbsp;</div>';?>
	 			</div>
	 		</div>

	 		<?php
			//including custom javascript/////////////////////////////////////////////////////////////////////////////////////////////////
			$jsInclude = ' if (typeof creativecontactform_shake_count_array === \'undefined\') { var creativecontactform_shake_count_array = new Array();};';
			$jsInclude .= 'creativecontactform_shake_count_array['.$form_id.'] = "'.$shake_count.'";';

			$jsInclude .= ' if (typeof creativecontactform_shake_distanse_array === \'undefined\') { var creativecontactform_shake_distanse_array = new Array();};';
			$jsInclude .= 'creativecontactform_shake_distanse_array['.$form_id.'] = "'.$shake_distanse.'";';

			$jsInclude .= ' if (typeof creativecontactform_shake_duration_array === \'undefined\') { var creativecontactform_shake_duration_array = new Array();};';
			$jsInclude .= 'creativecontactform_shake_duration_array['.$form_id.'] = "'.$shake_duration.'";';

			$jsInclude .= 'var creativecontactform_path = "'.JURI::base(true).'/components/com_creativecontactform/";';

			$jsInclude .= ' if (typeof creativecontactform_redirect_enable_array === \'undefined\') { var creativecontactform_redirect_enable_array = new Array();};';
			$jsInclude .= 'creativecontactform_redirect_enable_array['.$form_id.'] = "'.$redirect_enable.'";';

			$jsInclude .= ' if (typeof creativecontactform_redirect_array === \'undefined\') { var creativecontactform_redirect_array = new Array();};';
			$jsInclude .= 'creativecontactform_redirect_array['.$form_id.'] = "'.$redirect.'";';

			$jsInclude .= ' if (typeof creativecontactform_redirect_delay_array === \'undefined\') { var creativecontactform_redirect_delay_array = new Array();};';
			$jsInclude .= 'creativecontactform_redirect_delay_array['.$form_id.'] = "'.$redirect_delay.'";';

			$jsInclude .= ' if (typeof creativecontactform_thank_you_text_array === \'undefined\') { var creativecontactform_thank_you_text_array = new Array();};';
			$jsInclude .= 'creativecontactform_thank_you_text_array['.$form_id.'] = "'.$thank_you_text.'";';

			$jsInclude .= ' if (typeof creativecontactform_pre_text_array === \'undefined\') { var creativecontactform_pre_text_array = new Array();};';
			$jsInclude .= 'creativecontactform_pre_text_array['.$form_id.'] = "'.$pretxt.'";';

			$jsInclude .= ' if (typeof close_alert_text === \'undefined\') { var close_alert_text = new Array();};';
			$jsInclude .= 'close_alert_text['.$form_id.'] = "'.$close_alert_text.'";';

			$jsInclude .= 'creativecontactform_juri = "'.JURI::base( true ).'";';

			if($this->type != 'plugin') {
				$document = JFactory::getDocument();
				$document->addScriptDeclaration ( $jsInclude );
			}
			else {
				echo $jstoinclude = '<script type="text/javascript">'.$jsInclude.'</script>';
			}
		}
		else {
			echo 'Creative Contact Form: There is nothing to show!';
		}
 		?>

		<?php
		return $render_html = ob_get_clean();
	}
}