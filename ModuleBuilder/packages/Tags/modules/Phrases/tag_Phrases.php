<?PHP
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

require_once('modules/tag_Phrases/tag_Phrases_sugar.php');

class tag_Phrases extends tag_Phrases_sugar
{
    function tag_Phrases()
    {
        parent::tag_Phrases_sugar();
    }

    /**
     * Saves the phrase number
     * @param boolean $check_notify Optional, default false, if set to true assignee of the record is notified via email.
     */
    function save($check_notify = FALSE)
    {
        //increment phrase number
        if (empty($this->id))
        {
            $db = DBManagerFactory::getInstance();
            $sql = $this->create_new_list_query("phrase_number DESC", "", array('phrase_number'), array(), false);
            $result = $db->limitQuery($sql, 0, 1);

            while($row = $db->fetchByAssoc($result) )
            {
                $count = $row['phrase_number'];
            }

            if ($count === 0 || $count === '' || empty($count))
            {
                $this->phrase_number = 1;
            }
            else
            {
                $this->phrase_number = (int) $count + 1;
            }

            $this->name = $this->phrase_number;
        }

        $id = parent::save($check_notify);

        return $id;
    }

    /**
     * Validates whether a regex pattern is valid
     * @param $pattern
     * @return bool
     */
    function isValidRegexPattern($pattern)
    {
        $result = preg_match($pattern, 'placeholder');

        if ($result !== FALSE)
        {
            return true;
        }

        return false;
    }

    /**
     * Determines if a regex matches a pattern
     * @param $pattern
     * @param $subject
     * @return bool
     */
    function hasMatches($pattern, $subject)
    {
        $result = preg_match($pattern, $subject);

        if ($this->isValidRegexPattern($pattern) && $result !== 0)
        {
            return true;
        }

        return false;
    }

}

?>