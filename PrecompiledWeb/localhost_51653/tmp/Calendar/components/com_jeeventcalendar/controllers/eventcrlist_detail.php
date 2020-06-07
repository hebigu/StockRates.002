<?php
 /**

* @package   JE Ajax Event Calendar

* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.

* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php

* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com

* Visit : http://www.joomlaextensions.co.in/

**/ 

defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.application.component.controller' );
 
class eventcrlist_detailController extends JControllerForm  {
	function __construct($default = array()) {
		parent::__construct ( $default );
		$this->registerTask ( 'add', 'edit' );
	}
	
	function display() 
	{
		$user = clone(JFactory::getUser());
		if($user->id!='' )
			parent::display();
		else {
			$msg = JText::_ ( 'PLEASE_LOGIN_TO_VIEW_THIS_PAGE' );
			$this->setRedirect ( 'index.php', $msg );
		}
	}
	
	function save() { 
		
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$post = JRequest::get ( 'post' );
		$post ['category'] = $post ['category1'];
		$Itemid = JRequest::getVar('Itemid','','request','int');
		
		$db = JFactory::getDbo();
		$option = JRequest::getVar('option','','request','string');
		// ======= code for comparision of captcha ========================
		$cap = JRequest::getVar('cap','','request','string');
		$cap1 = JRequest::getVar('sid','','request','string');
		$v11 = JRequest::getVar('v11','','request','string');
		$textval = base64_decode($v11);
		// ================================================================
		
		$post["desc"] = JRequest::getVar( 'desc', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$cid = JRequest::getVar ( 'cid', array (0 ), 'post', 'array' );
		$post ['id'] = $cid [0];
		
		//$user = clone(JFactory::getUser());
		
		//if($user->usertype=='Super Administrator') {
			$cnt=implode('`',$post['usr']);
  			$post['usr']=$cnt;
		//}
		//else
			//$post['usr']=$post['usr'];
			
		
			
		$model = $this->getModel ( 'eventcrlist_detail' );
		
		if($cap==$textval)
		{
			if ($model->store ( $post )) {
				$msg = JText::_ ( 'EVENT_DETAIL_SAVED' );
			} else {
				$msg = JText::_ ( 'ERROR_SAVING_EVENT_DETAIL' );
			}
			
			if($post ['id'])
			{
				$count1=$post ['id'];
			} else {
				$sql="SELECT id FROM  #__jevent_event WHERE title= '".$post['title']."' ";
				$db->setQuery($sql);
				$row_data=$db->loadObject();
				$count1=$row_data->id;
			}
		//if($user->usertype=='Super Administrator') {	
		// ========== To inser the empoded user in the event table ================================	
			$sql="UPDATE #__jeajx_event SET usr='".$cnt."' where id=".$count1;
			$db->setQuery($sql);
			$db->Query();
		// ========================================================================================	
		//}
		// =============== Code for Saving dynemic fields value =======================================
			$res11=new extra_field();
			$res11->extra_field_save($post,2,$count1,$count1);
		// ============================================================================================
			 $this->setRedirect ( 'index.php?option=' . $option . '&view=eventcrlist', $msg );
		} else {
			$msg=JText::_( 'PLEASE_ENTER_CORRECT_CODE_GIVEN_IN_IMAGE' );
			$this->setRedirect ( 'index.php?option=' . $option . '&view=eventcrlist_detail&cid[]='.$post ['id'].'&Itemid='.$Itemid.'&err=1', $msg );
		}
	}
	
	
	
}

?>
