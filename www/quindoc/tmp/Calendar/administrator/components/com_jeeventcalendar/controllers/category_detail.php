<?php

defined( '_JEXEC' ) or die( 'Restricted access' );


jimport( 'joomla.application.component.controller' );
 
class category_detailController extends JControllerForm
{
	function __construct( $default = array())
	{
		parent::__construct( $default );
		$this->registerTask ( 'add', 'edit' );
	 
	}	
	function edit() {
		JRequest::setVar ( 'view', 'category_detail' );
		JRequest::setVar ( 'layout', 'default' );
		JRequest::setVar ( 'hidemainmenu', 1 );
		parent::display ();
	}
	
	function display() {
		 
		parent::display();
	}
	function save() {
		$post = JRequest::get ( 'post' );

		$post = JRequest::get ( 'post' );
		$desc = JRequest::getVar( 'edesc', '', 'post', 'string', JREQUEST_ALLOWRAW );
		
		$post["edesc"]=$desc;
		
		
	
		$option = JRequest::getVar('option','','request','string');
		
		$cid = JRequest::getVar ( 'cid', array (0 ), 'post', 'array' );
		
		$post ['id'] = $cid [0];
		
		$model = $this->getModel ( 'category_detail' );
		
		if ($model->store ( $post )) {
			
			$msg = JText::_ ( 'EVENT_DETAIL_SAVED' );
		
		} else {
			
			$msg = JText::_ ( 'ERROR_SAVING_EVENT_DETAIL' );
		}
		 
		$this->setRedirect ( 'index.php?option=' . $option . '&view=category', $msg );
	}
	
	function remove() {
		
		$option = JRequest::getVar ('option');
		
		$cid = JRequest::getVar ( 'cid', array (0 ), 'post', 'array' );
		
		if (! is_array ( $cid ) || count ( $cid ) < 1) {
			JError::raiseError ( 500, JText::_ ( 'SELECT_AN_ITEM_TO_DELETE' ) );
		}
		
		$model = $this->getModel ( 'category_detail' );
		if (! $model->delete ( $cid )) {
			echo "<script> alert('" . $model->getError ( true ) . "'); window.history.go(-1); </script>\n";
		}
		$msg = JText::_ ( 'FIELD_DELETED_SUCCESSFULLY' );
		$this->setRedirect ( 'index.php?option='.$option.'&view=category',$msg );
	}
	
	function publish() {
		
		$option = JRequest::getVar ('option');
		
		$cid = JRequest::getVar ( 'cid', array (0 ), 'post', 'array' );
		
		if (! is_array ( $cid ) || count ( $cid ) < 1) {
			JError::raiseError ( 500, JText::_ ( 'SELECT_AN_ITEM_TO_PUBLISH' ) );
		}
		
		$model = $this->getModel ( 'category_detail' );
		if (! $model->publish ( $cid, 1 )) {
			echo "<script> alert('" . $model->getError ( true ) . "'); window.history.go(-1); </script>\n";
		}
		$msg = JText::_ ( 'FIELD_PUBLISHED_SUCCESSFULLY' );
		$this->setRedirect ( 'index.php?option='.$option.'&view=category',$msg );
	}
	function unpublish() {
		
		$option = JRequest::getVar ('option');
		
		$cid = JRequest::getVar ( 'cid', array (0 ), 'post', 'array' );
		
		if (! is_array ( $cid ) || count ( $cid ) < 1) {
			JError::raiseError ( 500, JText::_ ( 'SELECT_AN_ITEM_TO_UNPUBLISH' ) );
		}
		
		$model = $this->getModel ( 'category_detail' );
		if (! $model->publish ( $cid, 0 )) {
			echo "<script> alert('" . $model->getError ( true ) . "'); window.history.go(-1); </script>\n";
		}
		$msg = JText::_ ( 'FIELD_UNPUBLISHED_SUCCESSFULLY' );
		$this->setRedirect ( 'index.php?option='.$option.'&view=category',$msg );
	}
	
	function cancel() {
		
		$option = JRequest::getVar('option','','request','string');
		$msg = JText::_ ( 'CATEGORY_DETAIL_EDITING_CANCELLED' );
		$this->setRedirect ( 'index.php?option='.$option.'&view=category',$msg );
	}	 
	
	
	}	

