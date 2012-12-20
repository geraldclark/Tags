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
{multienum_to_array string=$tag_value assign="values"}

{if (($view_action eq 'DetailView' && $view_module ne $tag_module) || ($is_subpanel eq '1') || $view_action eq 'ListView' || $view_action eq 'index') && ($values|@count gt 0)}
    {if $values|@count == 1 }
        {$values|@count} Tag
        {elseif $values|@count gt 1}
        {$values|@count} Tags
    {/if}

<a href="javascript:void(0);" id="{$tag_id}_less" style="display:none;" onclick="$(this).hide();$('#all_{$tag_id}').hide();$('#{$tag_id}_more').show();">
    <span id="{$tag_id}_less">{sugar_getimage name="lessitems.png" width="10" height="10"}</span>
</a>
<a href="javascript:void(0);" id="{$tag_id}_more" onclick="$(this).hide();$('#all_{$tag_id}').show();$('#{$tag_id}_less').show();">
    <span id="{$tag_id}_more">{sugar_getimage name="moreitems.png" width="10" height="10"}</span>
</a>

<span id="all_{$tag_id}" style="display:none;">
<br>
{/if}

{if ($view_action eq 'DetailView' && $view_module ne $tag_module) || ($is_subpanel eq '1') }

    {if $tagSearchForm eq ''}
        {foreach from=$values key=k item=i name=n}
            {$i}{if !$smarty.foreach.n.last}, {/if}
        {/foreach}
        {else}
    <script src="custom/include/SugarFields/Fields/CustomTag/CustomTag.js" type="text/javascript" id="CustomTagFunctions"></script>

        {foreach from=$values key=k item=i name=n}
        <a href="javascript:void(0);" id="{$tag_id}_{$k}" onclick="searchTag('{$tag_field}', '{$tag_module}', '{$tagSearchForm}', '{$tagSearchFormShort}', '{$i}');">{$i}</a>{if !$smarty.foreach.n.last}, {/if}
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
    {tag_acl required_access="Restricted"}
        {literal}
        ul.tagit li.tagit-choice {
            padding: 1px 4px 1px 3px;
        }
        {/literal}
    {/tag_acl}
    {tag_acl required_access="Editable, Limited"}
        {literal}
        ul.tagit li.tagit-choice {
            padding: 1px 13px 1px 3px;
        }
        {/literal}
    {/tag_acl}
    {literal}

    .hideAtStart
    {
        display: none;
    }

    </style>
    <script>

            SUGAR.util.doWhen("typeof $('#{/literal}{$tag_id}{literal}').tagit != 'undefined'", function(){

        $('#{/literal}{$tag_id}_list{literal}').tagit({
    highlightOnExistColor: '#327FC3',
    caseSensitive: false,
    allowSpaces: true,
allowNewTags: {/literal}{tag_acl required_access="Editable"}true{/tag_acl}{tag_acl required_access="Restricted, Limited"}false{/tag_acl}{literal},
    singleFieldDelimiter: ",",
{/literal}{if $save_style eq 'Submit'}select: true,{/if}{literal}
    triggerKeys: ['enter', 'comma', 'tab'],
tagsChanged: function(tagValue, action, element)
{
    //prevent double quotes
    tagValue = tagValue.replace(/["]/g, "");

        if (action == 'added')
{
{/literal}{tag_acl required_access="Editable, Limited"}{if $save_style eq 'Ajax'}{literal}
        url = 'index.php?to_pdf=1&module=tag_Tags&action=AddTags&record_module={/literal}{$tag_module}{literal}&record_id={/literal}{$tag_record_id}{literal}&&tag_name=' + escape(tagValue);

    $.ajax({
        url: url,
        global: false,
        type: "POST",
        dataType: "html",
        success: function(html)
        {
            showMessage(html);
        }
    });
{/literal}{/if}{/tag_acl}{literal}

    //make sure tag value is set
    $(element).attr('tagvalue', tagValue.trim());
}
else if (action == 'popped')
{
{/literal}{tag_acl required_access="Editable, Limited"}{if $save_style eq 'Ajax'}{literal}
        url = 'index.php?to_pdf=1&module=tag_Tags&action=RemoveTags&record_module={/literal}{$tag_module}{literal}&record_id={/literal}{$tag_record_id}{literal}&&tag_name=' + escape(tagValue);

    $.ajax({
        url: url,
        global: false,
        type: "POST",
        dataType: "html",
        success: function(html)
        {
            showMessage(html);
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

}{/literal}{tag_acl required_access="Editable, Limited"}{literal},
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

        SUGAR.util.doWhen("$('#{/literal}{$tag_id}_list{literal}').attr('class') == 'tagit'", function(){

{/literal}
    {if $tagSearchForm ne ''}
        {literal}
                $(".tagit-choice").live('click', function(e) {
            tagvalue = $(this).attr('tagvalue').trim();
                searchTag("{/literal}{$tag_field}{literal}", "{/literal}{$tag_module}{literal}", "{/literal}{$tagSearchForm}{literal}", "{/literal}{$tagSearchFormShort}{literal}", tagvalue);
    });

        $('.tagit-close').live('click', function(e){
            e.stopPropagation();
        })
    {/literal}
    {/if}
    {literal}

    {/literal}
    {tag_acl required_access="Restricted"}
        {literal}
            $('.tagit-close').remove();
            $('.tagit-input').remove();
        {/literal}
    {/tag_acl}
    {literal}

            $('#{/literal}{$tag_id}{literal}_load').remove();
        $('#{/literal}{$tag_id}{literal}_content').removeClass('hideAtStart');
});
});

</script>
{/literal}
<span id="{$tag_id}_load">
        <img src="themes/default/images/img_loading.gif" align="absmiddle">
    </span>

<span id="{$tag_id}_content" class="hideAtStart">
        <ul id="{$tag_id}_list">
            {foreach from=$values key=k item=i name=n}
                <li>{$i}</li>
            {/foreach}
        </ul>

    {if $save_style eq 'Submit'}
        <input type="hidden" value="{$tag_value}" name="{$tag_id}" id="{$tag_id}"/>
    {/if}

    </span>

{/if}

{if ($view_action eq 'DetailView' && $view_module ne $tag_module) || ($is_subpanel eq '1') || $view_action eq 'ListView'}
    </span>
{/if}
