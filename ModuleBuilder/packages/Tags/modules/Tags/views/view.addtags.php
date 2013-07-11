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

class ViewAddTags extends SugarView
{
    /**
	 * @see SugarView::display()
	 */
	public function display()
	{
        if (
            isset($_REQUEST['record_module'])
            && !empty($_REQUEST['record_module'])
            && isset($_REQUEST['record_id'])
            && !empty($_REQUEST['record_id'])
            && isset($_REQUEST['tag_name'])
            && isset($_REQUEST['tag_name'])
            )
        {
            $tag = trim(urldecode($_REQUEST['tag_name']));

            //load bean
            $beanObj = BeanFactory::getBean($_REQUEST['record_module'], $_REQUEST['record_id']);

            //add tags
            $tagObj = BeanFactory::newBean('tag_Tags');

            if ($tagObj->getTagUserACL($_REQUEST['record_module']) != 'Restricted')
            {
                $tags = $tagObj->addTagsToBeanByName($beanObj, $tag);
                $tagObj->syncBean($beanObj);

                if (empty($tags))
                {
                    echo '<message>Failure - No tags were added.</message>';
                }
                else
                {   $ids = implode(", ", $tags);
                    echo "<message>Success: {$ids}</message>";
                }
            }
            else
            {
                echo '<message>Failure - This functionality is currently restricted.</message>';
            }
        }
        else
        {
            echo '<message>Failure - A request parameter is missing.</message>';
        }
	}
}
