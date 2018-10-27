<?php
/*
 * @package   EK Rishta
 * @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.
 * @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
 * Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
 * Visit : http://www.joomlaextensions.co.in/
 */


// no direct access
defined('_JEXEC') or die ;

if (version_compare(JVERSION, '1.6.0', '<'))
{
    jimport('joomla.installer.installer');

    // Load K2 language file
    $lang = JFactory::getLanguage();
    $lang->load('com_jeeventcalendar');

    $status = new stdClass;
    $status->modules = array();
    $status->plugins = array();

    $modules = $this->manifest->getElementByPath('modules');
    $plugins = $this->manifest->getElementByPath('plugins');

    if (is_a($modules, 'JSimpleXMLElement') && count($modules->children()))
    {
        foreach ($modules->children() as $module)
        {
            $mname = $module->attributes('module');
            $client = $module->attributes('client');
            $db = JFactory::getDBO();
            $query = "SELECT `id` FROM `#__modules` WHERE module = ".$db->Quote($mname)."";
            $db->setQuery($query);
            $modules = $db->loadResultArray();
            if (count($modules))
            {
                foreach ($modules as $module)
                {
                    $installer = new JInstaller;
                    $result = $installer->uninstall('module', $module, 0);
                }
            }
            $status->modules[] = array('name' => $mname, 'client' => $client, 'result' => $result);
        }
    }
    if (is_a($plugins, 'JSimpleXMLElement') && count($plugins->children()))
    {
        foreach ($plugins->children() as $plugin)
        {
            $pname = $plugin->attributes('plugin');
            $pgroup = $plugin->attributes('group');
            if ($pgroup == 'finder' || $pgroup == 'josetta_ext')
            {
                continue;
            }
            $db = JFactory::getDBO();
            $query = 'SELECT `id` FROM #__plugins WHERE element = '.$db->Quote($pname).' AND folder = '.$db->Quote($pgroup);
            $db->setQuery($query);
            $plugins = $db->loadResultArray();
            if (count($plugins))
            {
                foreach ($plugins as $plugin)
                {
                    $installer = new JInstaller;
                    $result = $installer->uninstall('plugin', $plugin, 0);
                }
            }
            $status->plugins[] = array('name' => $pname, 'group' => $pgroup, 'result' => $result);
        }
    }

}
?>
<?php if (version_compare(JVERSION, '1.6.0', '<')): ?>
<?php $rows = 0; ?>
<h2><?php echo JText::_('Ekrishta Removed Successfully'); ?></h2>
<table class="adminlist">
	<thead>
		<tr>
			<th class="title" colspan="2"><?php echo JText::_('Component'); ?></th>
			<th width="30%"><?php echo JText::_('Status'); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="3"></td>
		</tr>
	</tfoot>
	<tbody>
		<tr class="row0">
			<td class="key" colspan="2"><?php echo JText::_('Ekrishta Component'); ?></td>
			<td><strong><?php echo JText::_('Removed'); ?></strong></td>
		</tr>
		<?php if (count($status->modules)): ?>
		<tr>
			<th><?php echo JText::_('Module'); ?></th>
			<th><?php echo JText::_('Client'); ?></th>
			<th></th>
		</tr>
		<?php foreach ($status->modules as $module): ?>
		<tr class="row<?php echo(++$rows % 2); ?>">
			<td class="key"><?php echo $module['name']; ?></td>
			<td class="key"><?php echo ucfirst($module['client']); ?></td>
			<td><strong><?php echo ($module['result'])?JText::_('Removed'):JText::_('Not Removed'); ?></strong></td>
		</tr>
		<?php endforeach; ?>
		<?php endif; ?>

		<?php if (count($status->plugins)): ?>
		<tr>
			<th><?php echo JText::_('Plugin'); ?></th>
			<th><?php echo JText::_('Group'); ?></th>
			<th></th>
		</tr>
		<?php foreach ($status->plugins as $plugin): ?>
		<tr class="row<?php echo(++$rows % 2); ?>">
			<td class="key"><?php echo ucfirst($plugin['name']); ?></td>
			<td class="key"><?php echo ucfirst($plugin['group']); ?></td>
			<td><strong><?php echo ($plugin['result'])?JText::_('Removed'):JText::_('Not Removed'); ?></strong></td>
		</tr>
		<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>
<?php endif; ?>