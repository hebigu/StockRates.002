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
define( '_JEXEC', 1 );
defined('_JEXEC') or die('Restircted access');
error_reporting(0);

//check captcha  
session_start();
$captcha_tested = true;
if(isset($_POST['creativecontactform_captcha'])) {
	foreach($_POST['creativecontactform_captcha'] as $captcha_key => $val) {
		$session_keeper = 'creative_captcha_'.$captcha_key;
		if(trim(strtolower($val)) != $_SESSION[$session_keeper]) {
			$captcha_tested = false;
			break;
		}
	}
}

define( 'DS', DIRECTORY_SEPARATOR );
define( 'CAPTCHA_TESTED', $captcha_tested );
define('JPATH_BASE', dirname(__FILE__).DS.'..'.DS.'..' );

require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );

$app = JFactory::getApplication('site');
$app->initialise();

$module_id = JRequest::getInt('creativecontactform_module_id', 0, 'post');
$form_id = JRequest::getInt('creativecontactform_form_id', 0, 'post');
$get_token = JRequest::getInt('get_token', 0, 'get');

$comparams = JComponentHelper::getParams( 'com_creativecontactform' );

$db = JFactory::getDBO();
//get form configuration
$query = "
			SELECT
				sp.`email_to`,
				sp.`email_bcc`,
				sp.`email_subject`,
				sp.`email_from`,
				sp.`email_from_name`,
				sp.`email_replyto`,
				sp.`email_replyto_name`
			FROM
				`#__creative_forms` sp
			WHERE sp.published = '1'
			AND sp.id = '".$form_id."'";
$db->setQuery($query);
$form_data = $db->loadAssoc();

//check if captcha exists
$query_captcha = "
			SELECT 
				sp.id 
			FROM 
			`#__creative_fields` sp 
			WHERE sp.published = '1' 
			AND sp.id_type = '13' 
			AND sp.id_form = '".$form_id."'";
$db->setQuery($query_captcha);
$db->query();
$count_captcha = $db->getNumRows();
$count_captcha = (int) $count_captcha;
$captcha_error = false;
if( $count_captcha > 0 && !isset($_POST['creativecontactform_captcha']))
	$captcha_error = true;

//get field types array
$query = "
			SELECT
				sp.id,
				st.name as type
			FROM
				`#__creative_fields` sp
			JOIN `#__creative_field_types` st ON st.id = sp.id_type AND st.id NOT IN ('13','14') 
			WHERE sp.published = '1'
			AND sp.id_form = '".$form_id."'
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

JResponse::allowCache( false );
JResponse::setHeader( 'Content-Type', 'text/plain' );

if($get_token == 0) {
	if (!JRequest::checkToken()) {
		echo '[{"invalid":"invalid_token"}]';
	}
	else if (!CAPTCHA_TESTED || $captcha_error) {
		echo '[{"invalid":"invalid_captcha"}]';
	}
	else {
		
		$info = Array();
		
		//get from
		$fromname = $app->getCfg('fromname', $app->getCfg('sitename'));
		$mailfrom = $app->getCfg('mailfrom');
		if (!$mailfrom ) {
			$info[] = 'Mail from not set in Joomla Global Configuration';
		}
		
		//get email to
		$email_to = array();
		if ( $form_data['email_to'] != '' ) {
			$email_to = explode(',', $form_data['email_to']);
		}
		if (count($email_to) == 0) {
			$email_to = $mailfrom;
		}
		
		// Email subject
		$creativecontactform_subject = $form_data['email_subject'] == '' ? 'Message sent from '.$app->getCfg('sitename') : $form_data['email_subject'];
		
		$creativecontactform_ip 		= strip_tags( JRequest::getVar( 'creativecontactform_ip', '', 'post' ));
		$creativecontactform_referrer 		= strip_tags( JRequest::getVar( 'creativecontactform_referrer', '', 'post' ));
		
		$mail = JFactory::getMailer();
		
		//generate the body
		$body = '';
		$sender_email = '';
		$sender_name = '';
		$current_index = 1;
		if(isset($_POST['creativecontactform_fields'])) {
			foreach($_POST['creativecontactform_fields'] as $field_data) {
				$field_label = strip_tags(trim($field_data[1]));
				if(isset($field_data[0])) {
					if(is_array($field_data[0])) {
						$field_value = implode(', ',$field_data[0]);
						$field_value = strip_tags(trim($field_value));
					}
					else
						$field_value = strip_tags(trim($field_data[0]));
				}
				else {
					$field_value = '';
				}
				if($types_array[$current_index] == 'text-area')
					$fields_seperator = ":\n";
				else
					$fields_seperator = ": ";
				if($types_array[$current_index] == 'text-area')
					$fields_end_seperator = "\r\n\n";
				else
					$fields_end_seperator = "\r\n";
				$body .= $field_label.$fields_seperator.$field_value.$fields_end_seperator;
				
				if($types_array[$current_index] == 'email')
					$sender_email = $field_value;
				if($types_array[$current_index] == 'name')
					$sender_name = $field_value;
				
				$current_index ++;
			}
		}
		
		$body .= 'Referrer: '.$creativecontactform_referrer."\r\n";
		$body .= 'Ip: '.$creativecontactform_ip."\r\n";
		
		//Set the body
		$mail->setBody( $body );
		$info[] = 'Body set successfully!';
		
		//Set subject
		$mail->setSubject( $creativecontactform_subject );
		$info[] = 'Subject set successfully!';
		
		//send me a copy check
		if(isset($_POST['creativecontactform_send_copy_enable'])) {
			if((int) $_POST['creativecontactform_send_copy_enable'] == 1 && $sender_email != '') {
				if(is_array($email_to)) {
					$email_to[] = $sender_email;
				}
				else {
					$email_to_final = array($email_to, $sender_email);
					$email_to = $email_to_final;
				}
			}
		}
		
		//Set Recipient
		$mail->addRecipient( $email_to );
		//$info[] = 'Recipient set: '.$email_to;
		
		//Set Sender
		$sender_email = $form_data['email_from'] == '' ? ($sender_email == '' ?  $mailfrom : $sender_email) : $form_data['email_from'];
		$sender_name = $form_data['email_from_name'] == '' ? ($sender_name == '' ?  $fromname : $sender_name) : $form_data['email_from_name'];
		$mail->setSender( array( $sender_email, $sender_name ) );
		$info[] = 'Sender set successfully!';
		
		// set reply to
		$replyto_email = $form_data['email_replyto'] == '' ? ($sender_email == '' ?  $mailfrom : $sender_email) : $form_data['email_replyto'];
		$mail->ClearReplyTos();
		$email_replyto_name = $form_data['email_replyto_name'] == '' ? ($sender_name == '' ? $fromname : $sender_name) : $form_data['email_replyto_name'];
		$mail->addReplyTo( array( $replyto_email, $email_replyto_name) );
		$info[] = 'Reply to set successfully!';
		
		// add blind carbon recipient
		if ($form_data['email_bcc'] != '') {
			$email_bcc = explode(',', $form_data['email_bcc']);
			$mail->addBCC($email_bcc);
			$info[] = 'BCC recipients added successfully!';
		}
		
		//attach files
		$attach_files = array();
		if(isset($_POST['creativecontactform_upload'])) {
			if(is_array($_POST['creativecontactform_upload'])) {
				foreach($_POST['creativecontactform_upload'] as $file) {
					$file_path = 'fileupload/files/'.$file;
					$attach_files[] = $file_path;
				}
			}
		}
		if(sizeof($attach_files) > 0) {
			$mail->addAttachment($attach_files);
		}
		
		if ( $mail->Send() === true ) {
			JSession::getFormToken(true);
			$info[] = 'Email sent successful';
		}
		else $info[] = 'There are problems sending email';
		
		//delete attached files
		if(sizeof($attach_files) > 0) {
			foreach($attach_files as $file) {
				unlink($file);
			}
		}
		//delete uploaded, but deleted files
		if(isset($_POST['creativecontactform_removed_upload'])) {
			if(is_array($_POST['creativecontactform_removed_upload'])) {
				foreach($_POST['creativecontactform_removed_upload'] as $file) {
					$file_path = 'fileupload/files/'.$file;
					@unlink($file_path);
				}
			}
		}
		
		//generates json output
		echo '[{';
		if(sizeof($info) > 0) {
			echo '"info": ';
			echo '[';
			foreach ($info as $k => $data) {
				echo '"'.$data.'"';
				if ($k != sizeof($info) - 1)
					echo ',';
			}
			echo ']';
		}
			
		echo '}]';
	}
}
else {
	echo JSession::getFormToken();
}
jexit();