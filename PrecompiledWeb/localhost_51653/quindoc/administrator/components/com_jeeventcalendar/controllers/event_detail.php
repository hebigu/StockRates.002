<?php

defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.application.component.controller' );
 
class event_detailController extends JControllerForm {
	function __construct($default = array()) {
		parent::__construct ( $default );
		$this->registerTask ( 'add', 'edit' );
	}
	function edit() {
		JRequest::setVar ( 'view', 'event_detail' );
		JRequest::setVar ( 'layout', 'default' );
		JRequest::setVar ( 'hidemainmenu', 1 );
		parent::display ();
	
	}
	function save() { 
		$post = JRequest::get ( 'post' );
		
		$cnt=implode('`',$post['usr']);
  $post['usr']=$cnt;
		$post = JRequest::get ( 'post' );
		$desc = JRequest::getVar( 'desc', '', 'post', 'string', JREQUEST_ALLOWRAW );
		
		$post["desc"]=$desc;
		
		
	
		$option = JRequest::getVar('option','','request','string');
		
		$cid = JRequest::getVar ( 'cid', array (0 ), 'post', 'array' );
		
		$post ['id'] = $cid [0];
		
		$model = $this->getModel ( 'event_detail' );
		
		if ($model->store ( $post )) {
			
			$msg = JText::_ ( 'EVENT_DETAIL_SAVED' );
		
		} else {
			
			$msg = JText::_ ( 'ERROR_SAVING_EVENT_DETAIL' );
		}
		
		$db= & JFactory :: getDBO();
		$sql="SELECT id FROM #__jevent_event where title='".$post['title']."' and category='".$post['category']."'";;
		$db->setQuery($sql);
		//return $db->loadObjectlist();
		$rr=$db->loadObject();

		 $sql="UPDATE #__jevent_event SET usr='".$cnt."' where id=".$rr->id;
		$db->setQuery($sql);
		$db->Query();
		//return $db->loadObjectlist();
	
		$this->setRedirect ( 'index.php?option=' . $option . '&view=event', $msg );
	}
	function remove() {
		
		$option = JRequest::getVar('option','','request','string');
		
		$cid = JRequest::getVar ( 'cid', array (0 ), 'post', 'array' );
		
		if (! is_array ( $cid ) || count ( $cid ) < 1) {
			JError::raiseError ( 500, JText::_ ( 'SELECT_AN_ITEM_TO_DELETE' ) );
		}
		
		$model = $this->getModel ( 'event_detail' );
		if (! $model->delete ( $cid )) {
			echo "<script> alert('" . $model->getError ( true ) . "'); window.history.go(-1); </script>\n";
		}
		$msg = JText::_ ( 'EVENT_DETAIL_DELETED_SUCCESSFULLY' );
		$this->setRedirect ( 'index.php?option='.$option.'&view=event',$msg );
	}
	function publish() {
		
		$option = JRequest::getVar('option','','request','string');
		
		$cid = JRequest::getVar ( 'cid', array (0 ), 'post', 'array' );
		
		if (! is_array ( $cid ) || count ( $cid ) < 1) {
			JError::raiseError ( 500, JText::_ ( 'SELECT_AN_ITEM_TO_PUBLISH' ) );
		}
		
		$model = $this->getModel ( 'event_detail' );
		if (! $model->publish ( $cid, 1 )) {
			echo "<script> alert('" . $model->getError ( true ) . "'); window.history.go(-1); </script>\n";
		}
		$msg = JText::_ ( 'EVENT_DETAIL_PUBLISHED_SUCCESSFULLY' );
		$this->setRedirect ( 'index.php?option='.$option.'&view=event',$msg );
	}
	function unpublish() {
		
		$option = JRequest::getVar('option','','request','string');
		
		$cid = JRequest::getVar ( 'cid', array (0 ), 'post', 'array' );
		
		if (! is_array ( $cid ) || count ( $cid ) < 1) {
			JError::raiseError ( 500, JText::_ ( 'SELECT_AN_ITEM_TO_UNPUBLISH' ) );
		}
		
		$model = $this->getModel ( 'event_detail' );
		if (! $model->publish ( $cid, 0 )) {
			echo "<script> alert('" . $model->getError ( true ) . "'); window.history.go(-1); </script>\n";
		}
		$msg = JText::_ ( 'EVENT_DETAIL_UNPUBLISHED_SUCCESSFULLY' );
		$this->setRedirect ( 'index.php?option='.$option.'&view=event',$msg );
	}
	function cancel() {
		
		$option = JRequest::getVar('option','','request','string');
		$msg = JText::_ ( 'EVENT_DETAIL_EDITING_CANCELLED' );
		$this->setRedirect ( 'index.php?option='.$option.'&view=event',$msg );
	}	 

}
