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
        require_once('modules/tag_Tags/TagSettings.php');

        if(isset($_POST['saveConfig']) && !empty($_POST['saveConfig']))
        {
            $installedModules = $tagObj->getInstalledModules();

            foreach ($installedModules as $key => $moduleName)
            {
                require_once('modules/tag_Tags/TagSettings.php');
                $settings = new TagSettings($key);
                $settings->saveFromRequest();
            }

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

        $installedModules = $tagObj->getInstalledModules();
        $uninstalledModules = $tagObj->getUninstalledModules();

        $LBL_TAGGER_SETTINGS = translate('LBL_TAGGER_SETTINGS', 'tag_Taggers');
        $LBL_TAG_SETTINGS = translate('LBL_TAG_SETTINGS', 'tag_Tags');
        $LBL_AVAILABLE_MODULES = translate('LBL_AVAILABLE_MODULES', 'tag_Tags');
        $LBL_CANCEL_BUTTON_TITLE = translate('LBL_CANCEL_BUTTON_TITLE');
        $LBL_CANCEL_BUTTON_LABEL =translate('LBL_CANCEL_BUTTON_LABEL');

        $LBL_SAVE_BUTTON_TITLE = translate('LBL_SAVE_BUTTON_TITLE');
        $LBL_SAVE_BUTTON_KEY = translate('LBL_SAVE_BUTTON_KEY');
        $LBL_SAVE_BUTTON_LABEL = translate('LBL_SAVE_BUTTON_LABEL');

        $html = "";

        $html .=<<<HTML
        <div class="moduleTitle">
            <h2> {$LBL_TAG_SETTINGS} </h2>
            <div class="clear"></div>
        </div>

        <form name="Settings" method="POST" action="index.php" >
        <input type='hidden' name='action' value='Settings'/>
        <input type='hidden' name='module' value='tag_Tags'/>
        <input type='hidden' name='saveConfig' value='1'/>

        <style>
            ul li { list-style-type: none;}
        </style>

        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="actionsContainer">
            <tr>
                <td style="padding-bottom: 2px;" >
                    <input title="{$LBL_SAVE_BUTTON_TITLE}" accessKey="{$LBL_SAVE_BUTTON_KEY}" class="button primary" id="btn_save" type="submit" name="save" value="{$LBL_SAVE_BUTTON_LABEL}" >
                    &nbsp;<input title="{$LBL_CANCEL_BUTTON_TITLE}" id="btn_cancel" onclick="document.location.href='index.php?module=Administration&action=index'" class="button"  type="button" name="cancel" value="{$LBL_CANCEL_BUTTON_LABEL}" >
                </td>
            </tr>
        </table>
HTML;

        $html .=<<<HTML

        <table width="100%" cellpadding="0" cellspacing="10" border="0" class="actionsContainer">
            <tr>
                <td style="vertical-align: top;">
                    <table width="100%" cellpadding="5" cellspacing="5" border="0" class="edit view">
                        <tr>
                            <th align="left" scope="row" colspan="4">
                                <h4>
                                {$LBL_AVAILABLE_MODULES}
                                </h4>
                            </th>
                        </tr>
HTML;
        foreach ($uninstalledModules as $key=>$moduleName)
        {
            $html .=<<<HTML
                <tr>
                <td style="padding-bottom: 2px;" >
                <input type="checkbox" name="install_{$key}">&nbsp;{$moduleName}
                </td>
                </tr>
HTML;
        }

        $html .= '</table></td><td style="vertical-align: top;">';

        foreach ($installedModules as $key => $moduleName)
        {
            require_once('modules/tag_Tags/TagSettings.php');
            $settings = new TagSettings($key);

            $status = $settings->status->getEditView();
            $behavior = $settings->behavior->getEditView();
            $limit = $settings->limit->getEditView();
            $days = $settings->days->getEditView();
            $session = $settings->session->getEditView();
            $acl = $settings->acl->getEditView();

            $html .=<<<HTML
            <table width="100%" border="0" cellspacing="5" cellpadding="0" class="edit view">
                <tr>
                    <th align="left" scope="row" colspan="4">
                        <h4>
                        {$moduleName}
                        </h4>
                    </th>
                </tr>
                <tr>
                    <td>
                        <table id="taggerSettings" name="taggerSettings" width="100%" border="0" cellspacing="0" cellpadding="0" class="edit view">
                            <tr>
                                <th align="left" scope="row" colspan="4">
                                    <h4>
                                    {$LBL_TAGGER_SETTINGS}
                                    </h4>
                                </th>
                            </tr>
                            <tr>
                                {$status}
                                {$behavior}
                            </tr>
                            <tr>
                                {$limit}
                                {$days}
                            </tr>
                            <tr>
                                {$session}
                                <td></td>
                                <td></td>
                            </tr>
                        </table>

                        <table id="tagSettings" name="tagSettings" width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
                            <tr>
                                <th align="left" scope="row" colspan="4">
                                    <h4>
                                    {$LBL_TAG_SETTINGS}
                                    </h4>
                                </th>
                            </tr>
                            <tr>
                                {$acl}
                                <td width='25%'>
                                    &nbsp;
                                </td>
                                <td width='25%' >
                                    &nbsp;
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
HTML;
        }

        $html .= "</td></tr></table>";

        $html .=<<<HTML

        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="actionsContainer">
            <tr>

                <td style="padding-bottom: 2px;" >
                    <input title="{$LBL_SAVE_BUTTON_TITLE}" accessKey="{$LBL_SAVE_BUTTON_KEY}" class="button primary" id="btn_save" type="submit" name="save" value="{$LBL_SAVE_BUTTON_LABEL}" >
                    &nbsp;<input title="{$LBL_CANCEL_BUTTON_TITLE}" id="btn_cancel" onclick="document.location.href='index.php?module=Administration&action=index'" class="button"  type="button" name="cancel" value="{$LBL_CANCEL_BUTTON_LABEL}" >
                </td>
            </tr>
        </table>

        </form>
HTML;

        foreach ($installedModules as $key => $moduleName)
        {
            require_once('modules/tag_Tags/TagSettings.php');
            $settings = new TagSettings($key);

            $behavior_id = $settings->behavior->getId();
            $status_id = $settings->status->getId();
            $acl_id = $settings->acl->getId();

            $html .=<<<HTML

            <script language="javascript" type="text/javascript">

            function {$key}_checkTagger()
            {
                if ($('#{$behavior_id}').val() == 'Reevaluate' && $('#{$status_id}').val() == 'Active')
                {
                    $('#{$acl_id}').val('Restricted');
                    $('#{$acl_id}').attr('disabled', true);
                }
                else
                {
                    $('#{$acl_id}').attr('disabled', false);
                }
            }

            SUGAR.util.doWhen("typeof $ != 'undefined'", function(){

                $("#{$behavior_id}").change(function(e) {
                    {$key}_checkTagger();
                });

                $("#{$status_id}").change(function(e) {
                    {$key}_checkTagger();
                });

                {$key}_checkTagger();

            });

            </script>
HTML;
        }

        echo $html;
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
