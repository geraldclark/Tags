{*

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

*}

<form name="Settings" method="POST" action="index.php" >
    <input type='hidden' name='action' value='Settings'/>
    <input type='hidden' name='module' value='tag_Tags'/>
    <input type='hidden' name='saveConfig' value='1'/>
    <span class='error'>{$error.main}</span>

{literal}
    <style>
        ul li { list-style-type: none;}
    </style>
{/literal}

    <div class="moduleTitle">
        <h2> {$MOD.LBL_TAG_SETTINGS} </h2>
        <div class="clear"></div>
    </div>

    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="actionsContainer">
        <tr>

            <td style="padding-bottom: 2px;" >
                <input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button primary" id="btn_save" type="submit" onclick="addcheck(form);return check_form('ConfigurePasswordSettings');"  name="save" value="{$APP.LBL_SAVE_BUTTON_LABEL}" >
                &nbsp;<input title="{$MOD.LBL_CANCEL_BUTTON_TITLE}" id="btn_cancel" onclick="document.location.href='index.php?module=Administration&action=index'" class="button"  type="button" name="cancel" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" >
            </td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <table id="taggerSettings" name="taggerSettings" width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
                    <tr>
                        <th align="left" scope="row" colspan="4">
                            <h4>
                            {$MOD.LBL_TAGGER_SETTINGS}
                            </h4>
                        </th>
                    </tr>
                    <tr>
                        <td scope="row" width='25%'>
                        {$MOD.LBL_TAGGER_STATUS}:
                        </td>
                        <td width='25%' >

                        {if ($config.custom_settings.tag_Taggers.status) == 'Active'}
                            {assign var='active' value='SELECTED'}
                        {/if}
                        {if ($config.custom_settings.tag_Taggers.status) == 'Inactive'}
                            {assign var='inactive' value='SELECTED'}
                        {/if}
                            <SELECT  ID="tagger_status" NAME="tagger_status">
                                <OPTION VALUE='Inactive' {$inactive}>{$MOD.LBL_INACTIVE}</OPTION>
                                <OPTION VALUE='Active' {$active}>{$MOD.LBL_ACTIVE}</OPTION>
                            </SELECT>
                        </td>
                        <td scope="row" width='25%'>
                        {$MOD.LBL_TAGGER_BEHAVIOR}:
                        </td>
                        <td width='25%' >
                        {if ($config.custom_settings.tag_Taggers.behavior) == 'Append'}
                            {assign var='append' value='SELECTED'}
                        {/if}
                        {if ($config.custom_settings.tag_Taggers.behavior) == 'Reevaluate'}
                            {assign var='reevaluate' value='SELECTED'}
                        {/if}
                            <SELECT  ID="tagger_behavior" NAME="tagger_behavior">
                                <OPTION VALUE='Append' {$append}>{$MOD.LBL_TAGGER_APPEND}</OPTION>
                                <OPTION VALUE='Reevaluate' {$reevaluate}>{$MOD.LBL_TAGGER_REEVALUATE}</OPTION>
                            </SELECT>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row" width='25%'>
                        {$MOD.LBL_TAGGER_LIMIT}:
                        </td>
                        <td>
                            <input type="text" name="tagger_limit" value="{$config.custom_settings.tag_Taggers.limit}">
                        </td>
                        <td scope="row" width='25%'>
                        {$MOD.LBL_TAGGER_DAYS}:
                        </td>
                        <td>
                            <input type="text" name="tagger_days" value="{$config.custom_settings.tag_Taggers.days}">
                        </td>
                    </tr>
                    <tr>
                        <td scope="row" width='25%'>
                        {$MOD.LBL_TAGGER_SESSION}:
                        </td>
                        <td>
                        {if ($config.custom_settings.tag_Taggers.session) == 'Active'}
                            {assign var='active_session' value='SELECTED'}
                        {/if}
                        {if ($config.custom_settings.tag_Taggers.session) == 'Inactive'}
                            {assign var='inactive_session' value='SELECTED'}
                        {/if}
                            <SELECT  ID="tagger_session" NAME="tagger_session">
                                <OPTION VALUE='Inactive' {$inactive_session}>{$MOD.LBL_INACTIVE}</OPTION>
                                <OPTION VALUE='Active' {$active_session}>{$MOD.LBL_ACTIVE}</OPTION>
                            </SELECT>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>

                <table id="tagSettings" name="tagSettings" width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
                    <tr>
                        <th align="left" scope="row" colspan="4">
                            <h4>
                            {$MOD.LBL_TAG_SETTINGS}
                            </h4>
                        </th>
                    </tr>
                    <tr>
                        <td  scope="row" width='25%'>
                        {$MOD.LBL_TAG_ACL}:
                        </td>
                        <td width='25%' >
                        {if ($config.custom_settings.tag_Tags.acl) == 'Editable'}
                            {assign var='editable' value='SELECTED'}
                        {/if}
                        {if ($config.custom_settings.tag_Tags.acl) == 'Limited'}
                            {assign var='limited' value='SELECTED'}
                        {/if}
                        {if ($config.custom_settings.tag_Tags.acl) == 'Restricted'}
                            {assign var='restricted' value='SELECTED'}
                        {/if}
                            <SELECT  ID="tag_acl" NAME="tag_acl">
                                <OPTION VALUE='Editable' {$editable}>{$MOD.LBL_EDITABLE}</OPTION>
                                <OPTION VALUE='Limited' {$limited}>{$MOD.LBL_LIMITED}</OPTION>
                                <OPTION VALUE='Restricted' {$restricted}>{$MOD.LBL_RESTRICTED}</OPTION>
                            </SELECT>
                        </td>
                        <td width='25%'>
                            &nbsp;
                        </td>
                        <td width='25%' >
                            &nbsp;
                        </td>
                    </tr>

                </table>

                <table id="moduleSettings" name="moduleSettings" width="100%" border="0" cellspacing="1" cellpadding="0" class="edit view">
                    <tr>
                        <th align="left" scope="row" colspan="4">
                            <h4>
                            {$MOD.LBL_MODULE_SETTINGS}
                            </h4>
                        </th>
                    </tr>
                    <tr>
                        <td  scope="row" width='25%'>
                        {$MOD.LBL_AVAILABLE_MODULES}:
                        </td>
                        <td width='25%' >
                            <ul>
                            {foreach from=$umodules key=k item=i name=n}
                                <li><input type="checkbox" name="install_{$k}">&nbsp;{$i}</li>
                            {/foreach}
                            </ul>
                        </td>
                        <td scope="row" width='25%'>
                        {$MOD.LBL_INSTALLED_MODULES}:
                        </td>
                        <td width='25%'>
                            <ul>
                            {foreach from=$imodules key=k item=i name=n}
                                <li>{$i}</li>
                            {/foreach}
                            </ul>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="actionsContainer">
        <tr>

            <td style="padding-bottom: 2px;" >
                <input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button primary" id="btn_save" type="submit" onclick="addcheck(form);return check_form('ConfigurePasswordSettings');"  name="save" value="{$APP.LBL_SAVE_BUTTON_LABEL}" >
                &nbsp;<input title="{$MOD.LBL_CANCEL_BUTTON_TITLE}" id="btn_cancel" onclick="document.location.href='index.php?module=Administration&action=index'" class="button"  type="button" name="cancel" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" >
            </td>
        </tr>
    </table>

</form>

{literal}
<script>

    function checkTagger()
    {
        if ($('#tagger_behavior').val() == 'Reevaluate' && $('#tagger_status').val() == 'Active')
        {
            $('#tag_acl').val('Restricted');
            $('#tag_acl').attr('disabled', true);
        }
        else
        {
            $('#tag_acl').attr('disabled', false);
        }
    }
    SUGAR.util.doWhen("typeof $ != 'undefined'", function(){

        $("#tagger_behavior").change(function(e) {
            checkTagger();
        });

        $("#tagger_status").change(function(e) {
            checkTagger();
        });

        checkTagger();
    });

</script>
{/literal}