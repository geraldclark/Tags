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

class tag_PhrasesViewDetail extends ViewDetail
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

    public function display()
    {
        parent::display();
        $bean = $GLOBALS['app']->controller->bean;

        if ( ($bean->regex === 1 || $bean->regex === '1') && !$bean->isValidRegexPattern($bean->phrase) )
        {
            require_once('include/SugarTheme/SidecarTheme.php');
            $theme = new SidecarTheme();

            $bootstrap_css = $theme->getCSSURL();

            if (is_array($bootstrap_css))
            {
                foreach($bootstrap_css as $css)
                {
                    echo '<link rel="stylesheet" href="' . $css . '">';
                }
            }
            else
            {
                echo '<link rel="stylesheet" href="' . $bootstrap_css . '">';
            }

            echo '<script type="text/javascript" src="cache/include/javascript/sugar_grp1_jquery.js"></script>';
            echo '<script type="text/javascript" src="cache/include/javascript/sugar_grp1_bootstrap_core.js"></script>';
            echo '<div class="well well-small alert-error pagination-centered"><span><strong>Invalid Regex:</strong> The regex pattern \'' . $bean->phrase . '\' does not appear to be valid.</span></div>';
        }

    }
}