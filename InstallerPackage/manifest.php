<?php
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

$manifest = array (
    'acceptable_sugar_flavors' => array ('CE','PRO','CORP','ENT','ULT'),
    'acceptable_sugar_versions' => array(
        'exact_matches' => array (),
        'regex_matches' => array ('6\\.[5-9]\\.[0-9]$'),
    ),
    'readme' => '',
    'key' => 'tag',
    'author' => 'jclark',
    'description' => 'Tagging Management System',
    'icon' => '',
    'is_uninstallable' => true,
    'name' => 'Tags',
    'published_date' => '2012-11-02 2012 05:28:52',
    'type' => 'module',
    'version' => '1.0',
    'remove_tables' => 'prompt',
);

$installdefs = array (
  'id' => 'Tags',
  'beans' =>
  array (
    0 =>
    array (
      'module' => 'tag_Phrases',
      'class' => 'tag_Phrases',
      'path' => 'modules/tag_Phrases/tag_Phrases.php',
      'tab' => true,
    ),
    1 =>
    array (
      'module' => 'tag_Taggers',
      'class' => 'tag_Taggers',
      'path' => 'modules/tag_Taggers/tag_Taggers.php',
      'tab' => true,
    ),
    2 =>
    array (
      'module' => 'tag_Tags',
      'class' => 'tag_Tags',
      'path' => 'modules/tag_Tags/tag_Tags.php',
      'tab' => true,
    ),
  ),
  'layoutdefs' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/layoutdefs/tag_taggers_tag_tags_tag_Tags.php',
      'to_module' => 'tag_Tags',
    ),
    1 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/layoutdefs/tag_taggers_tag_tags_tag_Taggers.php',
      'to_module' => 'tag_Taggers',
    ),
    2 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/layoutdefs/tag_tags_tag_phrases_tag_Phrases.php',
      'to_module' => 'tag_Phrases',
    ),
    3 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/layoutdefs/tag_tags_tag_phrases_tag_Tags.php',
      'to_module' => 'tag_Tags',
    ),
  ),
  'relationships' => 
  array (
    0 => 
    array (
      'meta_data' => '<basepath>/SugarModules/relationships/relationships/tag_taggers_tag_tagsMetaData.php',
    ),
    1 => 
    array (
      'meta_data' => '<basepath>/SugarModules/relationships/relationships/tag_tags_tag_phrasesMetaData.php',
    ),
  ),
  'image_dir' => '<basepath>/icons',
  'copy' => 
  array (

      0 => array(
          'from' => '<basepath>/Files/custom/Extension/application/Ext/Utils/tag_getInstalledModules.php',
          'to' => 'custom/Extension/application/Ext/Utils/tag_getInstalledModules.php',
      ),
      1 => array(
          'from' => '<basepath>/Files/custom/Extension/modules/Administration/Ext/Administration/tag_Tags.php',
          'to' => 'custom/Extension/modules/Administration/Ext/Administration/tag_Tags.php',
      ),
      2 => array(
          'from' => '<basepath>/Files/custom/Extension/modules/Schedulers/Ext/ScheduledTasks/tag_autotag.php',
          'to' => 'custom/Extension/modules/Schedulers/Ext/ScheduledTasks/tag_autotag.php',
      ),
      3 => array(
          'from' => '<basepath>/Files/custom/include/Smarty/plugins/block.tag_acl.php',
          'to' => 'custom/include/Smarty/plugins/block.tag_acl.php',
      ),
      4 => array(
          'from' => '<basepath>/Files/custom/include/Smarty/plugins/function.tag_get_id.php',
          'to' => 'custom/include/Smarty/plugins/function.tag_get_id.php',
      ),
      5 => array(
          'from' => '<basepath>/Files/custom/include/Smarty/plugins/function.tag_get_modules_fields.php',
          'to' => 'custom/include/Smarty/plugins/function.tag_get_modules_fields.php',
      ),
      6 => array(
          'from' => '<basepath>/Files/custom/include/Smarty/plugins/function.tag_get_search_layout.php',
          'to' => 'custom/include/Smarty/plugins/function.tag_get_search_layout.php',
      ),
      7 => array(
          'from' => '<basepath>/Files/custom/include/Smarty/plugins/function.tag_get_tags.php',
          'to' => 'custom/include/Smarty/plugins/function.tag_get_tags.php',
      ),
      8 => array(
          'from' => '<basepath>/Files/custom/include/Smarty/plugins/function.tag_get_view.php',
          'to' => 'custom/include/Smarty/plugins/function.tag_get_view.php',
      ),
      9 => array(
          'from' => '<basepath>/Files/custom/include/SugarFields/Fields/CustomModuleFieldSelect/DetailView.tpl',
          'to' => 'custom/include/SugarFields/Fields/CustomModuleFieldSelect/DetailView.tpl',
      ),
      10 => array(
          'from' => '<basepath>/Files/custom/include/SugarFields/Fields/CustomModuleFieldSelect/EditView.tpl',
          'to' => 'custom/include/SugarFields/Fields/CustomModuleFieldSelect/EditView.tpl',
      ),
      11 => array(
          'from' => '<basepath>/Files/custom/include/SugarFields/Fields/CustomModuleFieldSelect/SearchView.tpl',
          'to' => 'custom/include/SugarFields/Fields/CustomModuleFieldSelect/SearchView.tpl',
      ),
      12 => array(
          'from' => '<basepath>/Files/custom/include/SugarFields/Fields/CustomModuleFieldSelect/SugarFieldCustomModuleFieldSelect.php',
          'to' => 'custom/include/SugarFields/Fields/CustomModuleFieldSelect/SugarFieldCustomModuleFieldSelect.php',
      ),
      13 => array(
          'from' => '<basepath>/Files/custom/include/SugarFields/Fields/CustomModuleFieldSelect/WirelessDetailView.tpl',
          'to' => 'custom/include/SugarFields/Fields/CustomModuleFieldSelect/WirelessDetailView.tpl',
      ),
      14 => array(
          'from' => '<basepath>/Files/custom/include/SugarFields/Fields/CustomModuleFieldSelect/WirelessEditView.tpl',
          'to' => 'custom/include/SugarFields/Fields/CustomModuleFieldSelect/WirelessEditView.tpl',
      ),
      15 => array(
          'from' => '<basepath>/Files/custom/include/SugarFields/Fields/CustomTag/CustomTag.css',
          'to' => 'custom/include/SugarFields/Fields/CustomTag/CustomTag.css',
      ),
      16 => array(
          'from' => '<basepath>/Files/custom/include/SugarFields/Fields/CustomTag/CustomTag.js',
          'to' => 'custom/include/SugarFields/Fields/CustomTag/CustomTag.js',
      ),
      17 => array(
          'from' => '<basepath>/Files/custom/include/SugarFields/Fields/CustomTag/DetailView.tpl',
          'to' => 'custom/include/SugarFields/Fields/CustomTag/DetailView.tpl',
      ),
      18 => array(
          'from' => '<basepath>/Files/custom/include/SugarFields/Fields/CustomTag/EditView.tpl',
          'to' => 'custom/include/SugarFields/Fields/CustomTag/EditView.tpl',
      ),
      19 => array(
          'from' => '<basepath>/Files/custom/include/SugarFields/Fields/CustomTag/ListView.tpl',
          'to' => 'custom/include/SugarFields/Fields/CustomTag/ListView.tpl',
      ),
      20 => array(
          'from' => '<basepath>/Files/custom/include/SugarFields/Fields/CustomTag/SearchView.tpl',
          'to' => 'custom/include/SugarFields/Fields/CustomTag/SearchView.tpl',
      ),
      21 => array(
          'from' => '<basepath>/Files/custom/include/SugarFields/Fields/CustomTag/StandardView.tpl',
          'to' => 'custom/include/SugarFields/Fields/CustomTag/StandardView.tpl',
      ),
      22 => array(
          'from' => '<basepath>/Files/custom/include/SugarFields/Fields/CustomTag/SugarFieldCustomTag.php',
          'to' => 'custom/include/SugarFields/Fields/CustomTag/SugarFieldCustomTag.php',
      ),
      23 => array(
          'from' => '<basepath>/Files/custom/include/SugarFields/Fields/CustomTag/WirelessDetailView.tpl',
          'to' => 'custom/include/SugarFields/Fields/CustomTag/WirelessDetailView.tpl',
      ),
      24 => array(
          'from' => '<basepath>/Files/custom/include/SugarFields/Fields/CustomTag/WirelessEditView.tpl',
          'to' => 'custom/include/SugarFields/Fields/CustomTag/WirelessEditView.tpl',
      ),
      25 => array (
          'from' => '<basepath>/SugarModules/modules/tag_Phrases',
          'to' => 'modules/tag_Phrases',
      ),
      26 => array (
          'from' => '<basepath>/SugarModules/modules/tag_Taggers',
          'to' => 'modules/tag_Taggers',
      ),
      27 => array (
          'from' => '<basepath>/SugarModules/modules/tag_Tags',
          'to' => 'modules/tag_Tags',
      ),
      28 => array(
          'from' => '<basepath>/Files/custom/include/Smarty/plugins/function.tag_multienum_to_array.php',
          'to' => 'custom/include/Smarty/plugins/function.tag_multienum_to_array.php',
      ),
  ),
  'language' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'en_us',
    ),
    1 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'bg_BG',
    ),
    2 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'cs_CZ',
    ),
    3 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'da_DK',
    ),
    4 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'de_DE',
    ),
    5 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'es_ES',
    ),
    6 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'fr_FR',
    ),
    7 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'he_IL',
    ),
    8 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'hu_HU',
    ),
    9 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'it_it',
    ),
    10 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'lt_LT',
    ),
    11 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'ja_JP',
    ),
    12 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'lv_LV',
    ),
    13 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'nb_NO',
    ),
    14 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'nl_NL',
    ),
    15 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'pl_PL',
    ),
    16 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'pt_PT',
    ),
    17 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'ro_RO',
    ),
    18 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'ru_RU',
    ),
    19 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'sv_SE',
    ),
    20 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'tr_TR',
    ),
    21 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'zh_CN',
    ),
    22 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'pt_BR',
    ),
    23 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'ca_ES',
    ),
    24 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'en_UK',
    ),
    25 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'sr_RS',
    ),
    26 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Taggers.php',
      'to_module' => 'tag_Taggers',
      'language' => 'en_us',
    ),
    27 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Taggers.php',
      'to_module' => 'tag_Taggers',
      'language' => 'bg_BG',
    ),
    28 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Taggers.php',
      'to_module' => 'tag_Taggers',
      'language' => 'cs_CZ',
    ),
    29 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Taggers.php',
      'to_module' => 'tag_Taggers',
      'language' => 'da_DK',
    ),
    30 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Taggers.php',
      'to_module' => 'tag_Taggers',
      'language' => 'de_DE',
    ),
    31 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Taggers.php',
      'to_module' => 'tag_Taggers',
      'language' => 'es_ES',
    ),
    32 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Taggers.php',
      'to_module' => 'tag_Taggers',
      'language' => 'fr_FR',
    ),
    33 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Taggers.php',
      'to_module' => 'tag_Taggers',
      'language' => 'he_IL',
    ),
    34 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Taggers.php',
      'to_module' => 'tag_Taggers',
      'language' => 'hu_HU',
    ),
    35 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Taggers.php',
      'to_module' => 'tag_Taggers',
      'language' => 'it_it',
    ),
    36 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Taggers.php',
      'to_module' => 'tag_Taggers',
      'language' => 'lt_LT',
    ),
    37 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Taggers.php',
      'to_module' => 'tag_Taggers',
      'language' => 'ja_JP',
    ),
    38 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Taggers.php',
      'to_module' => 'tag_Taggers',
      'language' => 'lv_LV',
    ),
    39 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Taggers.php',
      'to_module' => 'tag_Taggers',
      'language' => 'nb_NO',
    ),
    40 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Taggers.php',
      'to_module' => 'tag_Taggers',
      'language' => 'nl_NL',
    ),
    41 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Taggers.php',
      'to_module' => 'tag_Taggers',
      'language' => 'pl_PL',
    ),
    42 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Taggers.php',
      'to_module' => 'tag_Taggers',
      'language' => 'pt_PT',
    ),
    43 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Taggers.php',
      'to_module' => 'tag_Taggers',
      'language' => 'ro_RO',
    ),
    44 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Taggers.php',
      'to_module' => 'tag_Taggers',
      'language' => 'ru_RU',
    ),
    45 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Taggers.php',
      'to_module' => 'tag_Taggers',
      'language' => 'sv_SE',
    ),
    46 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Taggers.php',
      'to_module' => 'tag_Taggers',
      'language' => 'tr_TR',
    ),
    47 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Taggers.php',
      'to_module' => 'tag_Taggers',
      'language' => 'zh_CN',
    ),
    48 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Taggers.php',
      'to_module' => 'tag_Taggers',
      'language' => 'pt_BR',
    ),
    49 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Taggers.php',
      'to_module' => 'tag_Taggers',
      'language' => 'ca_ES',
    ),
    50 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Taggers.php',
      'to_module' => 'tag_Taggers',
      'language' => 'en_UK',
    ),
    51 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Taggers.php',
      'to_module' => 'tag_Taggers',
      'language' => 'sr_RS',
    ),
    52 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Phrases.php',
      'to_module' => 'tag_Phrases',
      'language' => 'en_us',
    ),
    53 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Phrases.php',
      'to_module' => 'tag_Phrases',
      'language' => 'bg_BG',
    ),
    54 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Phrases.php',
      'to_module' => 'tag_Phrases',
      'language' => 'cs_CZ',
    ),
    55 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Phrases.php',
      'to_module' => 'tag_Phrases',
      'language' => 'da_DK',
    ),
    56 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Phrases.php',
      'to_module' => 'tag_Phrases',
      'language' => 'de_DE',
    ),
    57 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Phrases.php',
      'to_module' => 'tag_Phrases',
      'language' => 'es_ES',
    ),
    58 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Phrases.php',
      'to_module' => 'tag_Phrases',
      'language' => 'fr_FR',
    ),
    59 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Phrases.php',
      'to_module' => 'tag_Phrases',
      'language' => 'he_IL',
    ),
    60 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Phrases.php',
      'to_module' => 'tag_Phrases',
      'language' => 'hu_HU',
    ),
    61 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Phrases.php',
      'to_module' => 'tag_Phrases',
      'language' => 'it_it',
    ),
    62 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Phrases.php',
      'to_module' => 'tag_Phrases',
      'language' => 'lt_LT',
    ),
    63 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Phrases.php',
      'to_module' => 'tag_Phrases',
      'language' => 'ja_JP',
    ),
    64 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Phrases.php',
      'to_module' => 'tag_Phrases',
      'language' => 'lv_LV',
    ),
    65 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Phrases.php',
      'to_module' => 'tag_Phrases',
      'language' => 'nb_NO',
    ),
    66 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Phrases.php',
      'to_module' => 'tag_Phrases',
      'language' => 'nl_NL',
    ),
    67 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Phrases.php',
      'to_module' => 'tag_Phrases',
      'language' => 'pl_PL',
    ),
    68 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Phrases.php',
      'to_module' => 'tag_Phrases',
      'language' => 'pt_PT',
    ),
    69 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Phrases.php',
      'to_module' => 'tag_Phrases',
      'language' => 'ro_RO',
    ),
    70 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Phrases.php',
      'to_module' => 'tag_Phrases',
      'language' => 'ru_RU',
    ),
    71 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Phrases.php',
      'to_module' => 'tag_Phrases',
      'language' => 'sv_SE',
    ),
    72 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Phrases.php',
      'to_module' => 'tag_Phrases',
      'language' => 'tr_TR',
    ),
    73 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Phrases.php',
      'to_module' => 'tag_Phrases',
      'language' => 'zh_CN',
    ),
    74 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Phrases.php',
      'to_module' => 'tag_Phrases',
      'language' => 'pt_BR',
    ),
    75 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Phrases.php',
      'to_module' => 'tag_Phrases',
      'language' => 'ca_ES',
    ),
    76 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Phrases.php',
      'to_module' => 'tag_Phrases',
      'language' => 'en_UK',
    ),
    77 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Phrases.php',
      'to_module' => 'tag_Phrases',
      'language' => 'sr_RS',
    ),
    78 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'en_us',
    ),
    79 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'bg_BG',
    ),
    80 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'cs_CZ',
    ),
    81 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'da_DK',
    ),
    82 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'de_DE',
    ),
    83 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'es_ES',
    ),
    84 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'fr_FR',
    ),
    85 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'he_IL',
    ),
    86 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'hu_HU',
    ),
    87 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'it_it',
    ),
    88 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'lt_LT',
    ),
    89 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'ja_JP',
    ),
    90 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'lv_LV',
    ),
    91 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'nb_NO',
    ),
    92 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'nl_NL',
    ),
    93 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'pl_PL',
    ),
    94 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'pt_PT',
    ),
    95 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'ro_RO',
    ),
    96 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'ru_RU',
    ),
    97 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'sv_SE',
    ),
    98 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'tr_TR',
    ),
    99 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'zh_CN',
    ),
    100 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'pt_BR',
    ),
    101 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'ca_ES',
    ),
    102 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'en_UK',
    ),
    103 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/tag_Tags.php',
      'to_module' => 'tag_Tags',
      'language' => 'sr_RS',
    ),
    104 => 
    array (
      'from' => '<basepath>/SugarModules/language/application/en_us.lang.php',
      'to_module' => 'application',
      'language' => 'en_us',
    ),
    105 => array(
      'from' => '<basepath>/Files/custom/Extension/modules/Administration/Ext/Language/en_us.tag_Tags.php',
      'to_module' => 'Administration',
      'language' => 'en_us',
    ),
    106 => array(
      'from' => '<basepath>/Files/custom/Extension/modules/Schedulers/Ext/Language/en_us.tag_autotag.php',
      'to_module' => 'Schedulers',
      'language' => 'en_us',
    ),
  ),
  'vardefs' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/tag_taggers_tag_tags_tag_Tags.php',
      'to_module' => 'tag_Tags',
    ),
    1 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/tag_taggers_tag_tags_tag_Taggers.php',
      'to_module' => 'tag_Taggers',
    ),
    2 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/tag_tags_tag_phrases_tag_Phrases.php',
      'to_module' => 'tag_Phrases',
    ),
    3 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/tag_tags_tag_phrases_tag_Tags.php',
      'to_module' => 'tag_Tags',
    ),
  ),
  'wireless_subpanels' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/wirelesslayoutdefs/tag_taggers_tag_tags_tag_Tags.php',
      'to_module' => 'tag_Tags',
    ),
    1 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/wirelesslayoutdefs/tag_taggers_tag_tags_tag_Taggers.php',
      'to_module' => 'tag_Taggers',
    ),
    2 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/wirelesslayoutdefs/tag_tags_tag_phrases_tag_Phrases.php',
      'to_module' => 'tag_Phrases',
    ),
    3 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/wirelesslayoutdefs/tag_tags_tag_phrases_tag_Tags.php',
      'to_module' => 'tag_Tags',
    ),
  ),
);