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

class com_creativecontactformInstallerScript {

    /**
     * method to install the component
     *
     * @return void
     */
    function install($parent) {
        // installing module
        $module_installer = new JInstaller;
        if(@$module_installer->install(dirname(__FILE__).DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'module'))
            echo '<p>'.JText::_('COM_CREATIVECONTACTFORM_MODULE_INSTALL_SUCCESS').'</p>';
        else
           echo '<p>'.JText::_('COM_CREATIVECONTACTFORM_MODULE_INSTALL_FAILED').'</p>';

       // installing plugin
        $plugin_installer = new JInstaller;
        if($plugin_installer->install(dirname(__FILE__).DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'plugin'))
             echo '<p>'.JText::_('COM_CREATIVECONTACTFORM_PLUGIN_INSTALL_SUCCESS').'</p>';
        else
            echo '<p>'.JText::_('COM_CREATIVECONTACTFORM_PLUGIN_INSTALL_FAILED').'</p>';
        
        // enabling plugin
        $db = JFactory::getDBO();
        $db->setQuery('UPDATE #__extensions SET enabled = 1 WHERE element = "creativecontactform" AND folder = "system"');
        $db->query();
    }

    /**
     * method to uninstall the component
     *
     * @return void
     */
    function uninstall($parent) {
        // $parent is the class calling this method
        //echo '<p>' . JText::_('COM_HELLOWORLD_UNINSTALL_TEXT') . '</p>';

        $db = JFactory::getDBO();
        
        
        
        $sql = 'SELECT `extension_id` AS id, `name`, `element`, `folder` FROM #__extensions WHERE `type` = "module" AND ( (`element` = "mod_creativecontactform") ) ';
        $db->setQuery($sql);
        $creative_polling_module = $db->loadObject();
        $module_uninstaller = new JInstaller;
        if($module_uninstaller->uninstall('module', $creative_polling_module->id))
        	 echo '<p>'.JText::_('COM_CREATIVECONTACTFORM_MODULE_UNINSTALL_SUCCESS').'</p>';
        else
        	echo '<p>'.JText::_('COM_CREATIVECONTACTFORM_MODULE_UNINSTALL_FAILED').'</p>';

         // uninstalling creative image slider plugin
        $db->setQuery("select extension_id from #__extensions where name = 'System - Creative Image Slider' and type = 'plugin' and element = 'creativecontactform'");
        $cis_plugin = $db->loadObject();
        $plugin_uninstaller = new JInstaller;
        if($plugin_uninstaller->uninstall('plugin', $cis_plugin->extension_id))
            echo '<p>'.JText::_('COM_CREATIVECONTACTFORM_PLUGIN_UNINSTALL_SUCCESS').'</p>';
        else
            echo '<p>'.JText::_('COM_CREATIVECONTACTFORM_PLUGIN_UNINSTALL_FAILED').'</p>';
    }

    /**
     * method to update the component
     *
     * @return void
     */
    function update($parent) {
        $module_installer = new JInstaller;
        if(@$module_installer->install(dirname(__FILE__).DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'module'))
            echo '<p>'.JText::_('COM_CREATIVECONTACTFORM_MODULE_INSTALL_SUCCESS').'</p>';
        else
           echo '<p>'.JText::_('COM_CREATIVECONTACTFORM_MODULE_INSTALL_FAILED').'</p>';

        $plugin_uninstaller = new JInstaller;
        if(@$plugin_uninstaller->install(dirname(__FILE__).DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'plugin'))
            echo '<p>'.JText::_('COM_CREATIVECONTACTFORM_PLUGIN_INSTALL_SUCCESS').'</p>';
        else
           echo '<p>'.JText::_('COM_CREATIVECONTACTFORM_PLUGIN_INSTALL_FAILED').'</p>';
    }

    /**
     * method to run before an install/update/uninstall method
     *
     * @return void
     */
    function preflight($type, $parent) {
        // $parent is the class calling this method
        // $type is the type of change (install, update or discover_install)
        //echo '<p>' . JText::_('COM_HELLOWORLD_PREFLIGHT_' . $type . '_TEXT') . '</p>';
    }

    /**
     * method to run after an install/update/uninstall method
     *
     * @return void
     */
    function postflight($type, $parent) {
        // $parent is the class calling this method
        // $type is the type of change (install, update or discover_install)
        //echo '<p>' . JText::_('COM_HELLOWORLD_POSTFLIGHT_' . $type . '_TEXT') . '</p>';
    }
}