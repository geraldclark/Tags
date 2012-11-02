<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Master Subscription
 * Agreement ("License") which can be viewed at
 * http://www.sugarcrm.com/crm/master-subscription-agreement
 * By installing or using this file, You have unconditionally agreed to the
 * terms and conditions of the License, and You may not use this file except in
 * compliance with the License.  Under the terms of the license, You shall not,
 * among other things: 1) sublicense, resell, rent, lease, redistribute, assign
 * or otherwise transfer Your rights to the Software, and 2) use the Software
 * for timesharing or service bureau purposes such as hosting the Software for
 * commercial gain and/or for the benefit of a third party.  Use of the Software
 * may be subject to applicable fees and any use of the Software without first
 * paying applicable fees is strictly prohibited.  You do not have the right to
 * remove SugarCRM copyrights from the source code or user interface.
 *
 * All copies of the Covered Code must include on each user interface screen:
 *  (i) the "Powered by SugarCRM" logo and
 *  (ii) the SugarCRM copyright notice
 * in the same form as they appear in the distribution.  See full license for
 * requirements.
 *
 * Your Warranty, Limitations of liability and Indemnity are expressly stated
 * in the License.  Please refer to the License for the specific language
 * governing these rights and limitations under the License.  Portions created
 * by SugarCRM are Copyright (C) 2004-2012 SugarCRM, Inc.; All Rights Reserved.
 ********************************************************************************/

/* Action used to add tags matching search text */

class ViewSettings extends SugarView
{
    public function preDisplay()
    {
        global $current_user;

        if(!$current_user->is_admin)
        {
            sugar_die(translate("LBL_MUST_BE_ADMIN"));
        }

        parent::preDisplay();
    }

    /**
     * @see SugarView::display()
     */
    public function display()
    {
        global $current_user, $sugar_config, $mod_strings, $app_strings;
        if(!is_admin($current_user)) sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);

        $tagObj = BeanFactory::newBean('tag_Tags');

        if(isset($_POST['saveConfig']) && !empty($_POST['saveConfig']))
        {
            $configuratorObj = $tagObj->getConfig();

            //update config
            $configuratorObj->config['customTagSettings']['tagger']['status'] = $_POST['tagger_status'];
            $configuratorObj->config['customTagSettings']['tagger']['behavior'] = $_POST['tagger_behavior'];
            $configuratorObj->config['customTagSettings']['tagger']['session'] = $_POST['tagger_session'];

            $limit = preg_replace ( '/[^0-9]/', '', $_POST['tagger_limit']);

            if (!is_numeric($limit))
            {
                $limit = '200';
            }

            $configuratorObj->config['customTagSettings']['tagger']['limit'] = $limit;

            $days = $_POST['tagger_days'];

            if (trim($days) == '-1' || trim($days) === '')
            {
                $days = '-1';
            }
            else
            {
                $days = preg_replace ( '/[^0-9]/', '', $days);
            }

            $configuratorObj->config['customTagSettings']['tagger']['days'] = $days;


            if (!isset($_POST['tag_acl']))
            {
                $acl = 'Restricted';
            }
            else
            {
                $acl = $_POST['tag_acl'];
            }

            $configuratorObj->config['customTagSettings']['tag']['acl'] = $acl;
            $configuratorObj->saveConfig();

            //check relationships to install
            $installModules = array();
            foreach ($_REQUEST as $key=>$value)
            {
                if ($this->hasString("install_", $key))
                {
                    $installModules[]=str_replace("install_", "", $key);
                }
            }

            foreach ($installModules as $module)
            {
                if (!$tagObj->checkRelationships($module))
                {
                    //install missing
                    $tagObj->installRelationship($module, false);
                }
            }

            if (count($installModules) > 0)
            {
                $tagObj->runRepairs();
            }

            $tagObj->runRelationshipChecks();

            if (count($installModules) > 0)
            {
                header('Location: index.php?module=Administration&action=repair');
                exit;
            }

            header('Location: index.php?module=Administration&action=index');
            exit;
        }

        $tagObj->runRelationshipChecks();

        $sugar_smarty = new Sugar_Smarty();
        $sugar_smarty->assign('MOD', $mod_strings);
        $sugar_smarty->assign('APP', $app_strings);
        $sugar_smarty->assign('config', $sugar_config);
        $sugar_smarty->assign('imodules', $tagObj->getInstalledModules());
        $sugar_smarty->assign('umodules', $tagObj->getUninstalledModules());
        $sugar_smarty->display('modules/tag_Tags/tpls/settings.tpl');
    }

    /**
     * @param string $needle - string to find
     * @param string $haystack - text to search
     * @return bool - whether there is a match or not
     */
    function hasString($needle, $haystack)
    {
        $needle = strtoupper($needle);
        $haystack = strtoupper($haystack);
        $position = strpos($haystack, $needle);

        if($position === false)
        {
            $found = false;
        }
        else
        {
            $found = true;
        }

        return $found;
    }
}
