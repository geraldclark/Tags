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

{capture name="tag_field"}{{sugarvar key='name'}}{/capture}
{capture name="tag_id"}{{sugarvar key='name'}}{/capture}
{capture name="tag_value"}{{sugarvar key='value'}}{/capture}
{capture name="tag_record_id"}{$fields.id.value}{/capture}

{assign var="tag_record_id" value=$smarty.capture.tag_record_id|strip:''}
{assign var="tag_value" value=$smarty.capture.tag_value}
{assign var="tag_field" value=$smarty.capture.tag_field|strip:''}
{assign var="tag_id" value=$smarty.capture.tag_id|strip:''}
{assign var="tag_module" value={{$vardef.module}}}
{assign var="save_style" value="Ajax"}

{include file='custom/include/SugarFields/Fields/CustomTag/StandardView.tpl'}