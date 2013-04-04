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

{tag_get_view id=$tag_record_id}
{tag_get_search_layout module=$tag_module field=$tag_field}


{if (($view_action eq 'DetailView' && $view_module ne $tag_module) || ($is_subpanel eq '1') || $view_action eq 'ListView' || $view_action eq 'index')}

    {if ($tag_value ne '')}
        <a href="javascript:void(0);" id="{$tag_id}_loader" onclick="populateTags('{$tag_module}','{$tag_record_id}', '{$tag_id}');">
            {$tag_value} {sugar_getimage name="moreItems.png" width="10" height="10"}
        </a>
    {/if}

{/if}

{if ($view_action eq 'DetailView' && $view_module ne $tag_module) || ($is_subpanel eq '1') }

    {if $tagSearchForm eq ''}
        {foreach from=$values key=k item=i name=n}
            {$i}{if !$smarty.foreach.n.last}, {/if}
        {/foreach}
        {else}
        <script src="custom/include/SugarFields/Fields/CustomTag/CustomTag.js" type="text/javascript" id="CustomTagFunctions"></script>

        {foreach from=$values key=k item=i name=n}
            <a href="javascript:void(0);" id="{$tag_id}_{$k}" onclick="searchTag('{$tag_field}', '{$tag_module}', '{$tagSearchForm}', '{$tagSearchFormShort}', '{$k}');">{$i}</a>{if !$smarty.foreach.n.last}, {/if}
        {/foreach}

    {/if}

{else}

    <link rel="stylesheet" type="text/css" href="include/javascript/jquery/themes/base/jquery.ui.all.css">
    <link rel="stylesheet" type="text/css" href="custom/include/SugarFields/Fields/CustomTag/CustomTag.css">

    <script src="include/javascript/jquery/jquery-ui-min.js" type="text/javascript" id="jQuery-UI"></script>
    <script src="modules/tag_Tags/JavaScript/hailwood-jQuery-Tagit-3b0f6fa/js/tagit.js" type="text/javascript" charset="utf-8"></script>
    <script src="custom/include/SugarFields/Fields/CustomTag/CustomTag.js" type="text/javascript" id="CustomTagFunctions"></script>

    {literal}
    <style>

    {/literal}
    {if $tagSearchForm ne ''}
        {literal}
        ul.tagit li.tagit-choice:hover {
            cursor: pointer;
            cursor: hand;
        }
        {/literal}
    {/if}
    {literal}

    {/literal}
    {tag_acl required_access="Restricted" module=$tag_module}
        {literal}
        ul.tagit li.tagit-choice {
            padding: 1px 4px 1px 3px;
        }
        {/literal}
    {/tag_acl}
    {tag_acl required_access="Editable, Limited" module=$tag_module}
        {literal}
        ul.tagit li.tagit-choice {
            padding: 1px 13px 1px 3px;
        }
        {/literal}
    {/tag_acl}
    {literal}

    </style>
    <script>

    SUGAR.util.doWhen("typeof $('#{/literal}{$tag_id}{literal}').tagit != 'undefined'", function(){

    $('#{/literal}{$tag_id}_list{literal}').tagit({
    highlightOnExistColor: '#327FC3',
    caseSensitive: false,
    allowSpaces: true,
    allowNewTags: {/literal}{tag_acl required_access="Editable" module=$tag_module}true{/tag_acl}{tag_acl required_access="Restricted, Limited" module=$tag_module}false{/tag_acl}{literal},
    singleFieldDelimiter: ",",
    {/literal}{if $save_style eq 'Submit'}select: true,{/if}{literal}
    triggerKeys: ['enter', 'comma', 'tab'],
tagsChanged: function(tagValue, action, element)
{
    //prevent double quotes
    tagValue = tagValue.replace(/["]/g, "");

        if (action == 'added' && $('#{/literal}{$tag_id}{literal}_list').hasClass('prevent') == false)
{
{/literal}{tag_acl required_access="Editable, Limited" module=$tag_module}{if $save_style eq 'Ajax'}{literal}
        url = 'index.php?to_pdf=1&module=tag_Tags&action=AddTags&record_module={/literal}{$tag_module}{literal}&record_id={/literal}{$tag_record_id}{literal}&tag_name=' + escape(tagValue);

    $.ajax({
        url: url,
        global: false,
        type: "POST",
        dataType: "html",
        success: function(html)
        {
            handleResult(element, html);
        }
    });
{/literal}
    {else}
    $(element).attr('tagvalue', tagValue.trim());
{/if}{/tag_acl}{literal}
}
else if (action == 'popped')
{
{/literal}{tag_acl required_access="Editable, Limited" module=$tag_module}{if $save_style eq 'Ajax'}{literal}
    url = 'index.php?to_pdf=1&module=tag_Tags&action=RemoveTags&record_module={/literal}{$tag_module}{literal}&record_id={/literal}{$tag_record_id}{literal}&tag_id=' + escape(tagValue);

    $.ajax({
        url: url,
        global: false,
        type: "POST",
        dataType: "html",
        success: function(html)
        {
            handleResult(element, html);
        }
    });
{/literal}{/if}{/tag_acl}{literal}
}

{/literal}{if $save_style eq 'Submit'}{literal}
    //populate hidden tag field
    var tagKeys = '';
    $('#{/literal}{$tag_id}{literal}_list li').each(function(i, li) {
        tag = $(li).attr('tagvalue');
        if (tag !== undefined && tag != '' && tag != 'undefined' && tag != null)
        {
            if (tagKeys == '')
            {
                tagKeys = tag
            }
            else
            {
                tagKeys = tagKeys + '^,^' + tag;
            }
        }
    });

        $('#{/literal}{$tag_id}{literal}').val('^'+tagKeys+'^');
{/literal}{/if}{literal}

}{/literal}{tag_acl required_access="Editable, Limited" module=$tag_module}{literal},
tagSource: function(search, showChoices) {
    tagurl = 'index.php?to_pdf=1&module=tag_Tags&action=GetTags&record_module={/literal}{$tag_module}{literal}';
    var that = this;
    $.ajax({
        url: tagurl,
        data: {q: search.term},
        dataType: "json",
        success: function(data) {

            for (var i = 0; i < data.length; i++)
            {
                //hack to fix html entities like single quotes
                data[i] = $("<div/>").html(data[i]).text();
            }

            showChoices(data);
        }
    });
}{/literal}{/tag_acl}{literal}
});

    SUGAR.util.doWhen("$('#{/literal}{$tag_id}_list{literal}').attr('class') == 'tagit'", function(){{/literal}

    {if $tagSearchForm ne ''}
        {literal}$("#{/literal}{$tag_id}_list{literal} .tagit-choice").live('click', function(e) {
        tagvalue = $(this).attr('tagvalue').trim();
            searchTag("{/literal}{$tag_field}{literal}", "{/literal}{$tag_module}{literal}", "{/literal}{$tagSearchForm}{literal}", "{/literal}{$tagSearchFormShort}{literal}", tagvalue);
    });
    {/literal}
        {tag_acl required_access="Editable, Limited" module=$tag_module}
            {literal}$('#{/literal}{$tag_id}_list{literal} .tagit-close').live('click', function(e){
            e.stopPropagation();
        });{/literal}
        {/tag_acl}

    {/if}
    {literal}

    {/literal}
    {tag_acl required_access="Restricted" module=$tag_module}
    {literal}
            $('#{/literal}{$tag_id}_list{literal} .tagit-close').remove();
            $('#{/literal}{$tag_id}_list{literal} .tagit-input').remove();
    {/literal}
    {/tag_acl}
    {literal}
});
});

</script>
{/literal}

    <span id="{$tag_id}_content_loader"></span>
    <span id="{$tag_id}_content" >
        <ul id="{$tag_id}_list" class="prevent"></ul>
    </span>

    {if $save_style eq 'Submit'}
        <input type="hidden" value="{$tag_value}" name="{$tag_id}" id="{$tag_id}"/>
    {/if}
{/if}

{*if ($view_action eq 'DetailView' && $view_module ne $tag_module) || ($is_subpanel eq '1') || $view_action eq 'ListView'}
</span>
{/if*}

{if (($view_action eq 'DetailView' || $view_action eq 'EditView' )&& $view_module eq $tag_module)}
    <script>
        populateTags('{$tag_module}','{$tag_record_id}', '{$tag_id}');
    </script>
{/if}