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

require_once('modules/tag_Taggers/tag_Taggers_sugar.php');

class tag_Taggers extends tag_Taggers_sugar
{
    var $decoded_monitored_fields;
    var $log_prefix = 'Tagger :: ';

	function tag_Taggers()
    {
		parent::tag_Taggers_sugar();
	}

    /**
    * Function fetches a single row of data given the primary key value.
    *
    * @param string $id Optional, default -1, is set to -1 id value from the bean is used, else, passed value is used
    * @param boolean $encode Optional, default true, encodes the values fetched from the database.
    * @param boolean $deleted Optional, default true, if set to false deleted filter will not be added.
    */
    function retrieve($id = -1, $encode=true, $deleted=true)
    {
        $bean = parent::retrieve($id, $encode, $deleted);

        //set decoded fields
        $this->setDecodedFields();

        return $bean;
    }

    /**
    * Saves the Tagger
    *
    * @param boolean $check_notify Optional, default false, if set to true assignee of the record is notified via email.
    */
    function save($check_notify = FALSE)
    {
        $this->checkHooks();
        $this->setMonitoredFields();
        $id = parent::save($check_notify);
        return $id;
    }

    /**
     * Checks if auto-tag is enabled
     *
     * @return boolean - true if active
     */
    public function isTaggerEnabled($module)
    {
        require_once('modules/tag_Tags/TagSettings.php');
        $settings = new TagSettings($module, false);

        if ($settings->status->value == 'Active')
        {
            return true;
        }

        return false;
    }

    /**
     * Retrieves the selected tagger behavior
     *
     * @return string - possible values are 'Append' and 'Reevaluate'
     */
    public function getTaggerBehavior($module)
    {
        require_once('modules/tag_Tags/TagSettings.php');
        $settings = new TagSettings($module, false);

        return $settings->behavior->value;
    }

    /**
     * Checks if the use of sessions is enabled
     *   - If tagged is disabled, this is disabled
     *
     * @return boolean - true if active
     */
    public function isTaggerSessionEnabled($module)
    {
        require_once('modules/tag_Tags/TagSettings.php');
        $settings = new TagSettings($module, false);

        if ($this->isTaggerEnabled($module) && $settings->session->value == 'Active')
        {
            return true;
        }

        return false;
    }

    /**
     * Checks to make sure that the needed logic hooks are in place
     *  - after_relationship_add - makes sure that the tag module matches the tagger module
     */
    function checkHooks()
    {
            require_once("include/utils.php");

            //handle tag save logic
            $hook = Array(99999, 'Force relationship policy between taggers and tags', 'modules/tag_Taggers/Hooks/TaggerHooks.php', 'TaggerHooks', 'ForceRelationshipRestrictions');
            check_logic_hook_file('tag_Taggers', "after_relationship_add", $hook);
            //as of 6.5.5, it doesn't seem we need to handle from both sides
            //check_logic_hook_file('tag_Tags', "after_relationship_add", $hook);
    }

    /**
     * Decodes encoded monitored fields
     */
    function setDecodedFields()
    {
        $this->decoded_monitored_fields = unserialize(base64_decode($this->encoded_monitored_fields));
    }

    /**
     * Updates the monitored fields from a CSV string
     */
    function setMonitoredFields()
    {
        $fields = explode(",", $this->monitored_fields);

        $fieldSet = array();
        foreach ($fields as $key=>$field)
        {
            if (!empty($field))
            {
                $field = trim($field);
                $fieldSet[$field] = $field;
            }
        }

        ksort($fieldSet);

        $this->monitored_fields = implode(", ", $fieldSet);
        $this->encoded_monitored_fields = base64_encode(serialize($fieldSet));
        $this->setDecodedFields();
    }

    /**
     * Finds filters valid fields that we can search for tag matches on
     *
     * @param string $module - module to retrieve fields for
     * @return array $filteredFields - array of valid fields
     */
    function getFilteredFields($module)
    {
        $focus = BeanFactory::newBean($module);
        $fields = $focus->field_defs;
        $filteredFields = array();

        if (is_array($fields))
        {
            foreach ($fields as $field)
            {
                if (
                    isset($field['vname'])
                    && !empty($field['vname'])
                    && isset($field['type'])
                    && in_array($field['type'], array('name', 'varchar', 'text', 'enum', 'multienum', 'phone', 'worklog'))
                   )
                {
                    $label = trim(translate($field['vname'], $module));
                    $filteredFields[$field['name']] = $label;
                }
            }
        }

        ksort($filteredFields);
        return $filteredFields;
    }

    /**
     * Builds the tag-phrases array that we do all matching with
     *
     * @return array $tagsPhrases - compiled array of tags to phrases
     */
    public function getTagArray()
    {
        $specialChars = array(
            '[',
            '|',
            '\\',
            '^',
            '?',
            '.',
            '(',
            ')',
            '*',
            '+',
            '$',
            ' ',
        );

        $specialReplaceChars = array(
            '\\[',
            '\\|',
            '\\\\',
            '\\^',
            '\\?',
            '\\.',
            '\\(',
            '\\)',
            '\\*',
            '\\+',
            '\\$',
            ')(\\s*)(',
        );

        if (!empty($this->monitored_module) && $this->isTaggerSessionEnabled($this->monitored_module))
        {
            if (isset($_SESSION['customTagSettings']['tagger'][$this->monitored_module][$this->id]))
            {
                $GLOBALS['log']->info($this->log_prefix . "Found tagger settings cached in session for '{$this->monitored_module}'.");
                return $_SESSION['customTagSettings']['tagger'][$this->monitored_module][$this->id];
            }
        }

        $GLOBALS['log']->info($this->log_prefix . "Updating tag phrase array");

        //get related tags
        $this->load_relationship("tag_taggers_tag_tags");

        $filter=array(
            'where' => array(
                'lhs_field' => 'status',
                'operator' => '=',
                'rhs_value' => 'Active',
            ),
        );

        $relatedTags = $this->tag_taggers_tag_tags->getBeans($filter);

        $this->decoded_tags = array();

        $tagsPhrases = array();
        if (!empty($relatedTags))
        {
            foreach ($relatedTags as $relatedTag)
            {
                if ($relatedTag->target_module != $this->monitored_module)
                {
                    //this shouldn't be here.
                    $GLOBALS['log']->fatal($this->log_prefix . "Removing association :: Tag '$relatedTag->id' does not belong to tagger '{$this->id}'. Module mismatch {$relatedTag->target_module} / {$this->monitored_module}.");
                    $this->tag_taggers_tag_tags->delete($this->id, $relatedTag->id);
                    continue;
                }

                $plainPhrases = array();

                //get related phrases
                $relatedTag->load_relationship("tag_tags_tag_phrases");
                $relatedPhrases = $relatedTag->tag_tags_tag_phrases->getBeans();

                foreach ($relatedPhrases as $relatedPhrase)
                {
                    if ($relatedPhrase->regex == 1 || $relatedPhrase->regex == true || $relatedPhrase->regex == '1')
                    {
                        if (!isset($tagsPhrases[$relatedTag->id]))
                        {
                           $tagsPhrases[$relatedTag->id] = array();
                        }

                        $tagsPhrases[$relatedTag->id][] = $relatedPhrase->phrase;
                    }
                    else
                    {
                        $updatedPhrase = str_replace($specialChars, $specialReplaceChars, $relatedPhrase->phrase);
                        $plainPhrases[] = "(.*?)(" . $updatedPhrase . ")(.*?)";
                    }
                }

                if (!empty($plainPhrases))
                {
                    $tagsPhrases[$relatedTag->id][] = '/' . implode("|", $plainPhrases) . '/im';
                }
            }
        }

        if (!empty($this->monitored_module) && $this->isTaggerSessionEnabled($this->monitored_module))
        {
            $GLOBALS['log']->info($this->log_prefix . "Caching tagger settings in session for '{$this->monitored_module}'.");
            return $_SESSION['customTagSettings']['tagger'][$this->monitored_module][$this->id] = $tagsPhrases;
        }
        else
        {
            $GLOBALS['log']->info($this->log_prefix . "Skipping tagger cache check in session for '{$this->monitored_module}'.");
        }

        return $tagsPhrases;
    }

    /**
     * Finds the tag matches on a bean
     *
     * @param object $bean - bean to match against
     * @param array $searchTags - array containing tags and phrases to search
     * @param array $selectedTags - Used to pass in tag ids that we don't need to match on again
     * @return array|bool - List of matched tags
     */
    public function findMatches($bean, $selectedTags = array())
    {
        if (empty($this->id))
        {
            return false;
        }

        $this->setDecodedFields();
        $searchTags = $this->getTagArray();

        foreach ($this->decoded_monitored_fields as $field)
        {
            if (isset($bean->$field) && !empty($bean->$field))
            {
                foreach ($searchTags as $tag=>$patterns)
                {
                    //skip if we've already found this tag for another field
                    if (in_array($tag, $selectedTags))
                    {
                        $GLOBALS['log']->info($this->log_prefix . "Tag '{$tag}' has already been found. Skipping tagger logic for field '{$field}.'");
                        continue;
                    }

                    $match = false;

                    foreach ($patterns as $pattern)
                    {
                        if(preg_match($pattern, $bean->$field))
                        {
                            $selectedTags[$tag] = $tag;
                            $match = true;
                        }

                        $GLOBALS['log']->info($this->log_prefix . "Matching\r\nTagger: {$this->id} / {$this->name}\r\nTag: {$tag}\r\nModule: {$bean->module_name}\r\nField: {$field}\r\nPattern: '{$pattern}'\r\nString: '".preg_replace('/\s\s+/', ' ', $bean->$field) . "'\r\nMatch: " . ($match == true ? 'True' : 'False') . "\r\n");

                        if ($match)
                        {
                            break;
                        }
                    }
                }
            }
            else
            {
                $GLOBALS['log']->info($this->log_prefix . "field '{$field}' was not found on {$bean->module_name}.");
            }
        }



        return (!empty($selectedTags)) ? $selectedTags : false;
    }
}

?>