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

require_once('modules/tag_Tags/tag_Tags_sugar.php');

class tag_Tags extends tag_Tags_sugar
{
    var $log_prefix = 'Tag :: ';
    var $tag_field = 'tag_tags_c';
    var $tag_modified_field = 'tag_update_c';
    var $tag_count_field = 'tag_count_c';
    var $tag_search_field = 'tag_search_c';

    function tag_Tags()
    {
        parent::tag_Tags_sugar();
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
        return $bean;
    }

    /**
     * Saves the tag record
     *
     * @param boolean $check_notify Optional, default false, if set to true assignee of the record is notified via email.
     */
    function save($check_notify = FALSE)
    {
        $this->checkHooks($this->target_module);

        //replace double quotes
        $this->name = str_replace('"', '', $this->name);
        $this->name = str_replace('&quot;', '', $this->name);

        //format name
        $this->name = trim($this->name);
        $this->name_upper = strtoupper($this->name);

        $id = parent::save($check_notify);
        return $id;
    }

    /**
     * Retrieves the list of modules that have had relationships installed
     */
    public function getUninstalledModules()
    {
        $availableModules = $this->getAvailableModules();
        $installedModules = $this->getInstalledModules();

        foreach ($installedModules as $key=>$module)
        {
            if (isset($availableModules[$key]))
            {
                unset($availableModules[$key]);
            }
        }

        asort($availableModules);
        return $availableModules;
    }

    /**
     * Checks to see if there are available installed modules
     */
    public function hasInstalledModules()
    {
        if ( count($this->getInstalledModules()) > 0 )
        {
            return true;
        }

        return false;
    }

    /**
     * Retrieves the list of modules that have had relationships installed
     */
    public function getInstalledModules()
    {
        $availableModules = $this->getAvailableModules();

        require_once('modules/tag_Tags/TagSettings.php');
        $installedModules = array();
        foreach ($availableModules  as $key=>$module)
        {
            $settings = new TagSettings($key, false);

            if (!empty($settings->relationship->value))
            {
                $installedModules[$key] = $availableModules[$key];
            }
        }

        asort($installedModules);
        return $installedModules;
    }

    /**
     * Retrieve the available modules that tags can be associated to
     */
    public function getAvailableModules()
    {
        global $app_list_strings;

        $invalidModules = array(
            'tag_Taggers',
            'tag_Tagger',
            'tag_Phrases',
            'tag_Tags',
            'Home',
            'Emails',
            'Calendar',
            'Currencies',
            'Contracts',
            'ProductCategories',
            'ProductTypes',
            'ProductTemplates',
            'Reports',
            'Reports_1',
            'Forecasts',
            'ForecastSchedule',
            'MergeRecords',
            'Quotas',
            'Teams',
            'TeamNotices',
            'Manufacturers',
            'Activities',
            'Feeds',
            'iFrames',
            'TimePeriods',
            'TaxRates',
            'ContractTypes',
            'Schedulers',
            'CampaignLog',
            'DocumentRevisions',
            'Connectors',
            'Roles',
            'Notifications',
            'Sync',
            'ReportMaker',
            'DataSets',
            'CustomQueries',
            'WorkFlow',
            'EAPM',
            'Employees',
            'Administration',
            'ACLRoles',
            'InboundEmail',
            'Releases',
            'Prospects',
            'Queues',
            'EmailMarketing',
            'EmailTemplates',
            'SNIP',
            'ProspectLists',
            'SavedSearch',
            'UpgradeWizard',
            'Trackers',
            'TrackerPerfs',
            'TrackerSessions',
            'TrackerQueries',
            'FAQ',
            'Newsletters',
            'SugarFeed',
            'SugarFavorites',
            'OAuthKeys',
            'OAuthTokens',
            'Library',
            'EmailAddresses',
            'Sugar_Favorites',
        );

        $modules = array();

        //build list
        foreach($app_list_strings['moduleList'] as $key=>$module)
        {
            $modules[$key] = $module;
        }

        //remove invalid modules
        foreach ($invalidModules as $invalidModule)
        {
            if (isset($modules[$invalidModule]))
            {
                unset($modules[$invalidModule]);
            }
        }

        asort($modules);
        return $modules;
    }

    /**
     * Retrieves the user ACL for tags
     *
     * @return string - possible values are 'Editable', 'Limited' and 'Restricted'
     */
    public function getTagUserACL($module)
    {
        $taggerObj = BeanFactory::newBean('tag_Taggers');
        if ($taggerObj->getTaggerBehavior($module) == 'Reevaluate' && $taggerObj->isTaggerEnabled($module))
        {
            return 'Restricted';
        }
        else
        {
            require_once('modules/tag_Tags/TagSettings.php');
            $settings = new TagSettings($module);
            return $settings->acl->value;
        }
    }

    /**
     * Checks to make sure the tag field has a definition in custom/modules/module/metadata/SearchFields.php. If not, one is added.
     */
    function addSearchField($module, $inclusive = true)
    {
        if (empty($module))
        {
            return;
        }

        require_once('modules/tag_Tags/Helpers/FieldHelper.php');
        $fieldHelp = new FieldHelper();

        if ($fieldHelp->checkForSearchField($module, $this->tag_field))
        {
            return;
        }

        $moduleObj = BeanFactory::newBean($module);

        //handle broken modules
        if (!is_object($moduleObj))
        {
            return;
        }

        $relationshipName = $this->loadBeanRelationshipToTags($moduleObj);

        if ($relationshipName === false)
        {
            $GLOBALS['log']->fatal($this->log_prefix . "Check search field for '{$module}' did not find a relationship.");
            return;
        }

        $relationshipObject = $moduleObj->$relationshipName->getRelationshipObject();

        $joinTable = $relationshipObject->getRelationshipTable();
        $join_key_lhs = $relationshipObject->__get('join_key_lhs');
        $join_key_rhs = $relationshipObject->__get('join_key_rhs');

        $subquery = "SELECT {$joinTable}.{$join_key_rhs} FROM {$joinTable} WHERE {$joinTable}.deleted = 0 AND {$joinTable}.{$join_key_lhs} in ({0})";

        if ($inclusive)
        {
            $subquery .= " GROUP BY {$joinTable}.{$join_key_rhs} HAVING count({$joinTable}.{$join_key_rhs}) IN (SELECT count(tag_tags.id) from tag_tags where tag_tags.deleted = 0 and tag_tags.id in ({0}))";
        }

        /*
        //removed for performance reasons
        $join = $moduleObj->$relationshipName->getJoin(array());

        $subquery = "SELECT {$moduleObj->table_name}.id FROM {$moduleObj->table_name} {$join} WHERE {$moduleObj->table_name}.deleted = 0 AND tag_tags.name_upper in ({0})";

        if ($inclusive)
        {
            $subquery .= " GROUP BY {$moduleObj->table_name}.id HAVING count({$moduleObj->table_name}.id) IN (SELECT count(*) from tag_tags where tag_tags.deleted = 0 and tag_tags.name_upper in ({0}))";
        }
        */

        $subquery = str_replace("\n", " ", $subquery);
        $subquery = preg_replace('/\s+/', ' ', $subquery);

        //add search defs
        $definition = array (
            'query_type' => 'format',
            'operator' => 'subquery',
            'subquery' => $subquery,
            'db_field' => array (
                'id',
            ),
        );

        $fieldHelp->addSearchField($module, $this->tag_field, $definition);
    }

    /**
     * Runs all repairs needed after a relationship is installed.
     *   -Used so we can install multiple relationships and only run 1 repair.
     */
    function runRepairs()
    {
        require_once('modules/tag_Tags/Helpers/RelationshipHelper.php');
        $relHelper = new RelationshipHelper('tag_Tags');
        $relHelper->runRepairs();
    }

    /**
     * Make sure all relationships are setup correctly
     */
    function runRelationshipChecks()
    {
        //go through all uninstalled modules and make sure the rels werent taken out of the config.
        $uninstalledModules = $this->getAvailableModules();

        foreach ($uninstalledModules as $uninstalledModule)
        {
            $this->checkRelationships($uninstalledModule);
        }

        //go through all installed modules and make sure the field was added to search fields.
        $installedModules = $this->getInstalledModules();

        foreach ($installedModules as $installedModule)
        {
            //removed for redesign of search
            //$this->addSearchField($installedModule);
            $this->checkHooks($installedModule);
        }
    }

    /**
     * @param string $module - module to install relationship to
     * @param bool $runRepair - if we are installing multiple relationships, set to false so we only run 1 repair afterward.
     */
    function installRelationship($module, $runRepair = true)
    {
        $GLOBALS['log']->info($this->log_prefix . "Creating relationship between {$module} and tag_Tags.");

        //create modified field
        require_once('modules/tag_Tags/Helpers/FieldHelper.php');
        require_once('modules/tag_Tags/Helpers/StringHelper.php');

        $fields = array (
            //DateTime for modified
            array(
                'name' => StringHelper::str_last_replace('_c', '',  $this->tag_modified_field),
                'label' => 'LBL_' . strtoupper($this->tag_modified_field),
                'type' => 'datetime',
                'module' => $module,
                'default_value' => '',
                'help' => '',
                'comment' => 'This field should remain hidden.',
                'mass_update' => false, // true or false
                'enable_range_search' => false, // true or false
                'required' => false, // true or false
                'reportable' => true, // true or false
                'audited' => false, // true or false
                'duplicate_merge' => false, // true or false
                'importable' => 'true', // 'true', 'false' or 'required'
            ),
            //Integer for related tag count
            array(
                'name' => StringHelper::str_last_replace('_c', '',  $this->tag_count_field),
                'label' => 'LBL_' . strtoupper($this->tag_count_field),
                'type' => 'int',
                'module' => $module,
                'default_value' => '0',
                'help' => '',
                'comment' => 'This field should remain hidden.',
                'mass_update' => false, // true or false
                'enable_range_search' => false, // true or false
                'required' => false, // true or false
                'reportable' => true, // true or false
                'audited' => false, // true or false
                'duplicate_merge' => false, // true or false
                'importable' => 'true', // 'true', 'false' or 'required'
            ),
            //Multiselect for searching tags
            array(
                'name' => StringHelper::str_last_replace('_c', '',  $this->tag_search_field),
                'label' => 'LBL_' . strtoupper($this->tag_search_field),
                'type' => 'multienum',
                'module' => $module,
                'help' => '',
                'comment' => 'Add this field to your search views.',
                //'ext1' => $module . '_tag_search_dom', //maps to options - specify list name
                'default_value' => '', //key of entry in specified list
                'mass_update' => false, // true or false
                'required' => false, // true or false
                'reportable' => true, // true or false
                'audited' => false, // true or false
                'importable' => 'true', // 'true', 'false' or 'required'
                'duplicate_merge' => false, // true or false
            ),
        );

        $fieldHelper = new FieldHelper($module);
        $fieldHelper->installCustomFields($fields);
        $fieldHelper->writeVardefExtension($this->tag_search_field, array('function'=>'tag_getModuleTags'));

        //create relationship
        require_once('modules/tag_Tags/Helpers/RelationshipHelper.php');
        $relHelper = new RelationshipHelper('tag_Tags');

        $savePath = 'custom/modules/tag_Tags/builds';
        $relDef = $relHelper->setupRelationshipDefinition($module, 'many-to-many');
        $relName = $relHelper->setupRelationshipName($relDef);

        $installDefs = array();
        $installDefs['relationships'] = $relHelper->createRelationshipMetaData($relDef, $relName, $savePath);

        //create tagger field
        $vardefs = array();
        $vardefs[$module][] = array(
            'name' => $this->tag_field,
            'type' => 'CustomTag',
            'comment' => 'Add this field to your EditView and DetailView.',
            'source' => 'custom_fields',
            'dbType' => 'non-db',
            'studio' => 'visible',
            'vname' => 'LBL_' . strtoupper($this->tag_field),
            'module' => $module,
            'audited' => false,
            'sortable' => false,
        );

        //add fields for M-M
        $vardefs = $relHelper->setupVardefManyToMany($module, $relName, $vardefs);

        //create vardefs
        $installDefs['vardefs'] = $relHelper->createVardefs($vardefs, $relName, $savePath);

        $labels = array();
        $labels[]= $relHelper->setupLabel('LBL_' . strtoupper($this->tag_field), 'Tags', $module);
        $labels[]= $relHelper->setupLabel('LBL_' . strtoupper($this->tag_modified_field), 'Tags Modified', $module);
        $labels[]= $relHelper->setupLabel('LBL_' . strtoupper($this->tag_count_field), 'Tag Count', $module);
        $labels[]= $relHelper->setupLabel('LBL_' . strtoupper($this->tag_search_field), 'Tag Search', $module);
        $labels[]= $relHelper->setupLabel(strtolower($module . '_tag_search_dom'), array(''), 'application');

        $labels = $relHelper->setupLabelsForManyToMany($module, $relName, $labels);

        $installDefs['language'] = $relHelper->createLabels($labels, $relName , $savePath);

        //add tags field
        $installDefs['layoutfields'] = array(
            array(
                'additional_fields' => array(
                    $module => $this->tag_field,
                ),
            ),
        );

        //install everything
        $relHelper->installRelationship($relName, $installDefs, $savePath, $runRepair);

        //set relationship name in config
        require_once('modules/tag_Tags/TagSettings.php');
        $settings = new TagSettings($module);

        $settings->relationship->value = $relName;
        $settings->save();

        //removed for redesign
        /*
        if ($runRepair)
        {

            $this->addSearchField($module);
        }
        */

        $GLOBALS['log']->info($this->log_prefix . "Relationship '{$relName}' created.");
    }

    /**
     * Checks to make sure a relationship exists between the tag and selected bean.
     */
    function checkRelationships($module)
    {
        if (empty($module))
        {
            return;
        }

        require_once('modules/tag_Tags/TagSettings.php');
        $settings = new TagSettings($module, false);

        $db = DBManagerFactory::getInstance();

        require_once('modules/Relationships/Relationship.php');
        $relationshipObj = new Relationship();

        $relationshipExists = false;

        if (
            !empty($module)
            && !empty($settings->relationship->value)
        )
        {
            $relationshipExists = $relationshipObj->exists($settings->relationship->value[$module], $db);
        }

        if (!$relationshipExists)
        {
            $potentialRelationship = $relationshipObj->retrieve_by_modules('tag_Tags', $module, $db, 'many-to-many');

            if ($potentialRelationship === null)
            {
                $settings->relationship->value = "";
                $settings->save();
                return false;
            }
            else
            {
                $GLOBALS['log']->info($this->log_prefix . "Updating config settings to use potential relationship '{$potentialRelationship}'.");

                //update the config to use the found relationship
                $settings->relationship->value = $potentialRelationship;
                $settings->save();
                return true;
            }
        }
        else
        {
            return true;
        }

    }

    /**
     * Checks to make sure that the needed logic hooks are in place
     *  - after_save - for saving tags to beans
     *  - after_retrieve - for populating on EditView and DetailView
     *  - process_record - for populating ListView and Subpanels
     */
    function checkHooks($module)
    {
        if (!empty($module))
        {
            require_once("include/utils.php");

            //handle tag save logic
            $hook = Array(99999, 'Add Selected Tags For New Records', 'modules/tag_Tags/Hooks/TagHooks.php', 'TagHooks', 'SaveTags');
            check_logic_hook_file($module, "after_save", $hook);

            //add tags to editview and detailview
            $hook = Array(99999, 'Populate Tags Field', 'modules/tag_Tags/Hooks/TagHooks.php', 'TagHooks', 'PopulateTags');
            check_logic_hook_file($module, "after_retrieve", $hook);

            //add tags to listview
            $hook = Array(99999, 'Populate Tags Field with Count', 'modules/tag_Tags/Hooks/TagHooks.php', 'TagHooks', 'PopulateTagsCount');
            check_logic_hook_file($module, "process_record", $hook);
        }
    }

    /**
     * Converts a string of tags into an array
     *
     * @param string $tagString - csv string or multiselect string
     * @return array $tagArray - array containing the tag ids
     */
    function tagStringToArray($tagString)
    {
        if (is_array($tagString))
        {
            return $tagString;
        }
        //try to determine is multiselect string
        elseif ((substr($tagString, 0 ,1) == "^" && substr($tagString, -1) == "^"))
        {
            require_once('include/utils.php');
            $tagArray = unencodeMultienum($tagString);
        }
        //else assume a csv string
        else
        {
            $tagArray = explode(",", $tagString);
        }

        foreach ($tagArray as $id=>$tag)
        {
            if (empty($tag))
            {
                unset($tagArray[$id]);
            }
            else
            {
                $tagArray[$id] = trim($tag);
            }
        }

        return $tagArray;
    }

    /**
     * Checks tag ACL when adding tags so we can prevent adding tags when needed
     *
     * @param array $tagNames - array of tag names
     * @param string $module - module to filter search by
     * @return array $tagIds - array of found ids
     */
    function getTagIdsFromNamesACL($tagNames, $module)
    {
        $tagIds = array();

        if ($this->getTagUserACL($module) == 'Editable')
        {
            $tagIds = $this->getTagIdsFromNames($tagNames, $module);
        }
        else
        {
            $tagIds = $this->getTagIdsFromNames($tagNames, $module, false);
        }

        return $tagIds;
    }

    /**
     * Finds the difference between two arrays so we can figure out which tags to add
     *
     * @param array $selectedTagIds - array of selected tag id
     * @param array $currentTagIds - array of current tags to get diff from
     * @param object $bean - Bean to add tags to
     */
    function addTagDifference($selectedTagIds, $currentTagIds, $bean)
    {
        //figure out which keys to add
        $addTags = array();
        foreach($selectedTagIds as $id=>$name)
        {
            if (!isset($currentTagIds[$id]))
            {
                $addTags[]=$id;
            }
        }

        $this->addTagsToBean($bean, $addTags);
    }

    /**
     * Finds the difference between two arrays so we can figure out which tags to remove
     *
     * @param array $selectedTagIds - array of selected tag id
     * @param array $currentTagIds - array of current tags to get diff from
     * @param object $bean - Bean to add tags to
     */
    function removeTagDifference($selectedTagIds, $currentTagIds, $bean)
    {
        $removeTags = array();
        foreach($currentTagIds as $id=>$name)
        {
            if (!isset($selectedTagIds[$id]))
            {
                $removeTags[]=$id;
            }
        }

        $this->removeTagsFromBean($bean, $removeTags);
    }

    /**
     * Takes the current tag values from user input and updates the current selection
     *   - disabled tags are excluded from modification if the user ACL is 'Limited'
     *
     * @param $bean - bean to update tags for
     */
    public function saveBeanTags($bean)
    {
        $GLOBALS['log']->info($this->log_prefix . "Start tag save logic.'");

        if ($this->getTagUserACL($bean->module_name) != 'Restricted')
        {
            $tags = $this->tagStringToArray($bean->{$this->tag_field});

            $tagIds = array();
            $tagNames = array();

            require_once('modules/tag_Tags/Helpers/StringHelper.php');

            foreach($tags as $tag)
            {
                if (StringHelper::isGUID($tag))
                {
                    $tagIds[] = $tag;
                }
                else
                {
                    $tagNames[] = $tag;
                }
            }

            $selectedTagIds = $this->getTagIdsFromNamesACL($tagNames, $bean->module_name);

            foreach ($tagIds as $tagId)
            {
                $selectedTagIds[$tagId] = $tagId;
            }

            //get current tags
            $currentTagIds = $this->getBeanTagIds($bean);

            //add tag difference
            $this->addTagDifference($selectedTagIds, $currentTagIds, $bean);

            //remove tag difference
            $this->removeTagDifference($selectedTagIds, $currentTagIds, $bean);
        }

        $GLOBALS['log']->info($this->log_prefix . "End tag save logic.'");
    }

    /**
     * For performance, we can run the tagger process from the job queue instead of after_save
     * @param $bean
     */
    public function queueTaggerJob($bean)
    {
        $GLOBALS['log']->info($this->log_prefix . "Sending tagger save to job queue.'");
        require_once('include/SugarQueue/SugarJobQueue.php');

        // First, let's create the new job
        $job = new SchedulersJob();
        $job->name = "Tagger Job - {$bean->module_name} / {$bean->id}";
        // key piece, this is data we are passing to the job that it can use to run it.
        $job->data = array('module' => $bean->module_name, 'id' => $bean->id);
        //function to call
        $job->target = "function::taggerJob";

        global $current_user;
        $job->assigned_user_id = $current_user->id; //user the job runs as

        // Now push into the queue to run
        $jq = new SugarJobQueue();
        $jobid = $jq->submitJob($job);

        $GLOBALS['log']->info($this->log_prefix . "Tagger job queued as job #{$jobid}");
    }

    /**
     * Matches tag criteria from a tagger setup
     *
     * @param $bean - bean to update tags for
     */
    public function saveTaggerTags($bean)
    {
        $GLOBALS['log']->info($this->log_prefix . "Start tagger save logic.'");

        $taggerObj = BeanFactory::newBean('tag_Taggers');

        //if tagger is enabled
        if ($taggerObj->isTaggerEnabled($bean->module_name))
        {
            $GLOBALS['log']->info($this->log_prefix . "Finding matches for {$bean->module_name}.");

            $results = $taggerObj->get_full_list('', " tag_taggers.status = 'Active' AND tag_taggers.monitored_module = '{$bean->module_name}' ");

            if ($taggerObj->getTaggerBehavior($bean->module_name) == 'Reevaluate')
            {
                //get current tags unfiltered
                $currentTagIds = $this->getBeanTagIds($bean);
                //start with nothing
                $selectedTagIds = array();
            }
            else
            {
                //get current tags filtered
                $currentTagIds = $this->getBeanTagIds($bean, true);
                //start with all current tags
                $selectedTagIds = $currentTagIds;
            }

            if (!empty($results))
            {
                foreach ($results as $taggerObj)
                {
                    $GLOBALS['log']->info($this->log_prefix . "Checking matches for {$taggerObj->id} / {$taggerObj->name}.");

                    $matches = $taggerObj->findMatches($bean, $selectedTagIds);

                    if ($matches !== false)
                    {
                        foreach ($matches as $tagIdKey=>$tagIdValue)
                        {
                            $selectedTagIds[$tagIdKey] = $tagIdValue;
                        }
                    }
                }
            }

            //add tag difference
            $this->addTagDifference($selectedTagIds, $currentTagIds, $bean);

            if (BeanFactory::newBean('tag_Taggers')->getTaggerBehavior($bean->module_name) == 'Reevaluate')
            {
                //remove tag difference
                $this->removeTagDifference($selectedTagIds, $currentTagIds, $bean);
            }
        }

        $GLOBALS['log']->info($this->log_prefix . "End tagger save logic.'");
    }

    /**
     * Adds tags to a bean by tag name instead of ID
     *
     * @param object $bean - bean to update tags for
     * @param string/array $tags - csv string or multiselect string will be converted to an array
     * @return array $tagIds - array containing the tag ids
     */
    public function addTagsToBeanByName($bean, $tags)
    {
        if (is_array($tags))
        {
            $tagArray = $tags;
        }
        elseif(is_string($tags))
        {
            $tagArray = $this->tagStringToArray($tags);
        }
        else
        {
            return false;
        }

        $tagIds = array();

        if ($this->getTagUserACL($bean->module_name) == 'Editable')
        {
            $tagIds = $this->getTagIdsFromNames($tagArray, $bean->module_name);
        }
        else
        {
            $tagIds = $this->getTagIdsFromNames($tagArray, $bean->module_name, false);
        }

        //remove tag names
        $tagIds = array_keys($tagIds);

        if (!empty($tagIds))
        {
            $this->addTagsToBean($bean, $tagIds);
        }

        return $tagIds;
    }

    /**
     * Looks up a tag ID by module and name
     *
     * @param array $tagNames - array of tag names
     * @param string $module - target module of tags
     * @opt_param boolean $createNew - creates a new tag if one doesnt exist. Defaults to true
     * @return array $tagIds - array containing the added tag ids
     */
    function getTagIdsFromNames($tagNames, $module, $createNew = true)
    {
        $tagIds = array();

        $tagNames = $this->tagStringToArray($tagNames);
        $tagNamesOriginal = $tagNames;

        $db = DBManagerFactory::getInstance();

        $searchTags = array();

        foreach ($tagNames as $key=>$value)
        {
            $searchTags[] = $db->quoted(strtoupper($value));
            $tagNames[$key] = strtoupper($value);
        }

        if (count($searchTags) == 0)
        {
            return array();
        }

        $searchString = "(" . implode(",", $searchTags) . ")";

        $results = $this->get_full_list('', " tag_tags.target_module = '{$module}' AND tag_tags.name_upper in {$searchString} ");

        if (!empty($results))
        {
            foreach ($results as $tagObj)
            {
                $tagIds[$tagObj->id] = $tagObj->name;

                if ($createNew)
                {
                    $key = array_search(strtoupper($tagObj->name), $tagNames);
                    unset($tagNamesOriginal[$key]);
                }
            }
        }

        if ($createNew)
        {
            foreach ($tagNamesOriginal as $tag)
            {
                if (!empty($module) && !empty($tag))
                {
                    $GLOBALS['log']->info($this->log_prefix . "Creating  tag '{$tag}'.");
                    $newTag = BeanFactory::newBean($this->module_name);
                    $newTag->name = $tag;
                    $newTag->target_module = $module;
                    $newTag->save();
                    $tagIds[$newTag->id] = $newTag->name;
                }
            }
        }

        asort($tagIds, SORT_STRING);
        return $tagIds;
    }

    /**
     * Retrieves all current tags for a selected module
     *   - disabled tags are excluded from results if user ACL is 'Restricted' or 'Limited'
     *
     * @param string $module - key of module to retrieve tags for
     */
    function getModuleTags($module)
    {
        $GLOBALS['log']->info($this->log_prefix . "Retrieving tags for module '{$module}'.");

        $filterActive = "";
        if (in_array($this->getTagUserACL($module), array("Restricted", "Limited")))
        {
            $filterActive = "AND tag_tags.status = 'Active'";
        }

        $results = $this->get_full_list('tag_tags.name_upper ASC', "tag_tags.target_module = '{$module}' {$filterActive}");

        $tags = array();

        if (!empty($results))
        {
            foreach ($results as $tagObj)
            {
                $tags[$tagObj->id] = $tagObj->name;
            }
        }

        return $tags;
    }

    /* -- The functions below are designed to be generic between beans -- */

    /**
     * Retrieves related tag ids from a selected bean
     *
     * @param object $bean - bean to retrieve related tags from
     * @param bool $filterActive - filters by active status if 'true'
     * @return array $tagIds - list of related tag ids
     */
    public function getBeanTagIds($bean, $filterActive = false)
    {
        $tagObjs = $this->getBeanTags($bean, $filterActive);

        $tagIds = array();
        foreach ($tagObjs as $tagObj)
        {
            $tagIds[$tagObj->id] = $tagObj->id;
        }

        $GLOBALS['log']->info($this->log_prefix . "Current Tags: " . implode(", ", $tagIds));

        return $tagIds;
    }

    /**
     * Retrieves related tag beans from a selected bean
     *
     * @param object $bean - bean to retrieve related tags from
     * @param bool $filterActive - filters by active status if 'true'
     * @return array $tagIds - list of related tag objects
     */
    public function getBeanTagsCount($bean, $filterActive = false)
    {
        $GLOBALS['log']->info($this->log_prefix . "Retrieving tag count for {$bean->module_name} / {$bean->id}");

        $relationshipName = $this->loadBeanRelationshipToTags($bean);
        // $relationshipObject = $bean->$relationshipName->getRelationshipObject();
        //$joinTable = $relationshipObject->getRelationshipTable();

        //$join_key_lhs = $relationshipObject->__get('join_key_lhs');
        //$join_key_rhs = $relationshipObject->__get('join_key_rhs');
        $join = $bean->$relationshipName->getJoin(array());

        $sql = "SELECT count(*) FROM {$bean->table_name} {$join} WHERE {$bean->table_name}.deleted = 0 AND {$bean->table_name}.id = '{$bean->id}'";

        if ($filterActive)
        {
            $GLOBALS['log']->info($this->log_prefix . "Filtering tag count by 'Active' status");
            $sql .= " AND tag_tags.status = 'Active'";
        }

        $db = DBManagerFactory::getInstance();
        $count = $db->getOne($sql);
        return $count;
    }

    /**
     * Retrieves related tag beans from a selected bean
     *
     * @param object $bean - bean to retrieve related tags from
     * @param bool $filterActive - filters by active status if 'true'
     * @return array $tagIds - list of related tag objects
     */
    public function getBeanTags($bean, $filterActive = false)
    {
        $GLOBALS['log']->info($this->log_prefix . "Retrieving tags for {$bean->module_name} / {$bean->id}");

        $filter=array();
        if ($filterActive)
        {
            $GLOBALS['log']->info($this->log_prefix . "Filtering tags by 'Active' status");
            $filter=array(
                'where' => array(
                    'lhs_field' => 'status',
                    'operator' => '=',
                    'rhs_value' => 'Active',
                ),
            );
        }

        $relationshipName = $this->loadBeanRelationshipToTags($bean);

        if (!empty($relationshipName))
        {
            return $bean->$relationshipName->getBeans($filter);
        }
        else
        {
            return array();
        }
    }

    /**
     * Retrieves and sets related tags count to the tag field on the bean - for use on subpanels
     *
     * @param object $bean - bean to retrieve retrieve and set tags count for display
     */
    public function setBeanTagsCount($bean)
    {
        $GLOBALS['log']->info($this->log_prefix . "Populating Tag count for {$bean->module_name} / {$bean->id}");

        //fetch value
        if (($bean->{$this->tag_field} != '0' && $bean->{$this->tag_field} !== 0) && empty($bean->{$this->tag_count_field}))
        {
            $count = $this->getBeanTagsCount($bean, true);
            $bean->{$this->tag_field} = $count;
        }
        else
        {
            $bean->{$this->tag_field} = $bean->{$this->tag_count_field};
        }

        if (!empty($bean->{$this->tag_field}))
        {
            if ($bean->{$this->tag_field} == '1')
            {
                $bean->{$this->tag_field} .= " Tag";
            }
            else
            {
                $bean->{$this->tag_field} .= " Tags";
            }
        }
        else
        {
            $bean->{$this->tag_field} = '';
        }
    }

    /**
     * Retrieves and sets related tags to the tag field on the bean
     *
     * @param object $bean - bean to retrieve retrieve and set tags for display
     */
    public function setBeanTags($bean)
    {
        $GLOBALS['log']->info($this->log_prefix . "Populating Tags for {$bean->module_name} / {$bean->id}");

        require_once('include/utils.php');

        $relatedTags = array();
        if (in_array($this->getTagUserACL($bean->module_name), array("Restricted", "Limited")))
        {
            $relatedTags = $this->getBeanTags($bean, true);
        }
        else
        {
            $relatedTags = $this->getBeanTags($bean);
        }

        $tags = array();
        foreach ($relatedTags as $relatedTag)
        {
            $tags[strtolower($relatedTag->name)] = $relatedTag->name;
        }

        asort($tags);
        $bean->{$this->tag_field} = encodeMultienumValue($tags);
    }

    /**
     * Removes tags from a bean by name
     *
     * @param object $bean - bean to retrieve tags from
     * @param array $tagNames - array of tag names
     */
    public function removeTagsFromBeanByName($bean, $tagNames)
    {
        $tagNames = $this->tagStringToArray($tagNames);

        $tagIds = $this->getTagIdsFromNames($tagNames, $bean->module_name, false);

        if (!empty($tagIds))
        {
            $this->removeTagsFromBean($bean, $tagIds);
        }
    }

    /**
     * Removes tags from a bean by id
     *
     * @param object $bean - bean to retrieve tags from
     * @param array $tagIds - array of tag ids
     */
    public function removeTagsFromBean($bean, $tagIds)
    {
        if (!is_array($tagIds))
        {
            $tagIds = array($tagIds);
        }

        $relationshipName = $this->loadBeanRelationshipToTags($bean);

        $GLOBALS['log']->info($this->log_prefix . "Removing Tags: " . implode(", ", $tagIds));

        foreach($tagIds as $tagId)
        {
            $bean->$relationshipName->delete($bean->id, $tagId);
        }
    }

    /**
     * Adds tags from a bean by id
     *
     * @param object $bean - bean to retrieve tags from
     * @param array $tagIds - array of tag ids
     */
    public function addTagsToBean($bean, $tagIds)
    {
        $GLOBALS['log']->info($this->log_prefix . "Adding Tags: " . implode(", ", $tagIds));

        $relationshipName = $this->loadBeanRelationshipToTags($bean);
        $bean->$relationshipName->add($tagIds);
    }

    /**
     * Loads the tag relationship to a bean
     *
     * @param object $bean - bean to load relationship for
     */
    function loadBeanRelationshipToTags($bean)
    {
        require_once('modules/tag_Tags/TagSettings.php');
        $settings = new TagSettings($bean->module_name);

        if (isset($settings->relationship->value) && !empty($settings->relationship->value))
        {
            //relate tags to record
            $relationshipName = $settings->relationship->value;

            if(empty($bean->$relationshipName) && !$bean->load_relationship($relationshipName))
            {
                $GLOBALS['log']->fatal($this->log_prefix . "Could not load the relationship '{$relationshipName}' for {$bean->module_name}.");
                return false;
            }

            return $relationshipName;
        }

        //log error
        $GLOBALS['log']->fatal($this->log_prefix . "The relationship config setting for {$bean->module_name} is missing! To correct this issue, open and save a tag record for this module.");
        return false;
    }

    /**
     * Processes the tags for a record.
     *
     * @param $bean - bean to modify tags for
     */
    function processTags($bean)
    {
        $taggerObj = BeanFactory::newBean('tag_Taggers');

        if ($taggerObj->isTaggerEnabled($bean->module_name) && $taggerObj->getTaggerBehavior($bean->module_name) == 'Reevaluate')
        {
            //only run the tagger since it'll remove any non-matching tags anyway
            $this->saveTaggerTags($bean);
        }
        else
        {
            //run both
            $this->saveBeanTags($bean);
            $this->saveTaggerTags($bean);
        }

        $this->syncBean($bean);
    }

    /**
     * Updates the tag modified date for the bean
     * @param $bean
     */
    function syncBean($bean)
    {
        //get active count
        $count = $this->getBeanTagsCount($bean, true);

        //get all bean tags for search
        require_once('include/utils.php');
        $tagIds = encodeMultienumValue($this->getBeanTagIds($bean));

        //get current time for modified
        $stamp = $GLOBALS['timedate']->getNow(false)->asDb();

        $cstmTable = $bean->get_custom_table_name();

        $SQL = "UPDATE {$cstmTable} SET {$cstmTable}.{$this->tag_modified_field} = '{$stamp}', {$cstmTable}.{$this->tag_count_field} = '{$count}', {$cstmTable}.{$this->tag_search_field} = '{$tagIds}' where {$cstmTable}.id_c = '{$bean->id}'";

        $db = DBManagerFactory::getInstance();
        $db->query($SQL);
    }
}

?>