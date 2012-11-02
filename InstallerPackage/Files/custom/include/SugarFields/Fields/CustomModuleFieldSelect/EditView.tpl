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


{tag_get_modules_fields module={{sugarvar key='value' string=true}} fields=$fields.{{$displayParams.encodedTargetField}}.value}

{literal}
<script>

    SUGAR.util.doWhen("typeof $ != 'undefined'", function(){
        $(function(){
            $("#{/literal}{{sugarvar key='name'}}{literal}_selected, #{/literal}{{sugarvar key='name'}}{literal}_available").droppable({
                drop: function(e, ui){

                    fields = "";
                    droppedField = ui.draggable.html().match(/<small>\[(.*?)\]<\/small>/)[1];

                    if ($(this).attr('id') == "{/literal}{{sugarvar key='name'}}{literal}_selected")
                    {
                        fields = droppedField;
                        $("#{/literal}{{sugarvar key='name'}}{literal}_selected li").each(function(i,e){
                            fields = fields + "," + e.id;
                        });
                    }
                    else
                    {
                        $("#{/literal}{{sugarvar key='name'}}{literal}_selected li").each(function(i,e){
                            if (e.id != droppedField)
                            {
                                if (fields == "")
                                {
                                    fields = e.id;
                                }
                                else
                                {
                                   fields = fields + "," + e.id;
                                }
                            }
                        });
                    }

                    $("#{/literal}{{$displayParams.targetField}}{literal}").val(fields);
                }
            }).sortable({
                connectWith: ".{/literal}{{sugarvar key='name'}}{literal}_connectedSortable"
            }).disableSelection();
        });

        {/literal}{$selectFields}{literal}
    });

    function updateFields(selectedModule, selected)
    {
        var moduleFields = {/literal}{$modulesFields}{literal}

        if (selected == null)
        {
            $("#{/literal}{{$displayParams.targetField}}{literal}").val('');
        }

        $("#{/literal}{{sugarvar key='name'}}{literal}_selected li").each(function(i,e){
           $(e).closest('li').remove();
        });
        $("#{/literal}{{sugarvar key='name'}}{literal}_available li").each(function(i,e){
               $(e).closest('li').remove();
        });

        if (selectedModule != '')
        {
            for (var i in moduleFields[selectedModule]['fields'])
            {
                if (selected == null || selected[i] === undefined)
                {
                    $("#{/literal}{{sugarvar key='name'}}{literal}_available").append('<li id="'+i+'"><strong>'+moduleFields[selectedModule]['fields'][i]+'</strong><br><small>['+i+']</small></li>');
                }
                else
                {
                    $("#{/literal}{{sugarvar key='name'}}{literal}_selected").append('<li id="'+i+'"><strong>'+moduleFields[selectedModule]['fields'][i]+'</strong><br><small>['+i+']</small></li>');
                }
            }
        }
    }

</script>

<style>
    .{/literal}{{sugarvar key='name'}}{literal}_scroll
    {
        width: 350px;
        border: 1px solid back;
        float: left;
        height: 250px;
        overflow: auto;
        border: 1px solid #666;
        padding: 10px;
    }

    #{/literal}{{sugarvar key='name'}}{literal}_available, #{/literal}{{sugarvar key='name'}}{literal}_selected
    {
        list-style-type: none;
        margin: 0;
        padding: 0 0 2.5em;
        margin-right: 10px;
        width:100%;
        height:100%;
    }

    #{/literal}{{sugarvar key='name'}}{literal}_selected li, #{/literal}{{sugarvar key='name'}}{literal}_available li
    {
        list-style-type: none;
        margin: 5px 5px 5px 5px;
        padding: 5px;
        font-size: 1.2em;
        border: 1px solid #000000;
    }
</style>
{/literal}

<table>
    <tr>
        <td>
            <select name="{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}"
            id="{{if empty($displayParams.idName)}}{{sugarvar key='name'}}{{else}}{{$displayParams.idName}}{{/if}}"
            title='{{$vardef.help}}' {{if !empty($tabindex)}} tabindex="{{$tabindex}}" {{/if}}
            {{if !empty($displayParams.accesskey)}} accesskey='{{$displayParams.accesskey}}' {{/if}} {{$displayParams.field}}
            onChange="updateFields(this.options[this.selectedIndex].value, null);">
                {if isset({{sugarvar key='value' string=true}}) && {{sugarvar key='value' string=true}} != ''}
                    {html_options options=$modules selected={{sugarvar key='value' string=true}}}
                {else}
                    {html_options options=$modules selected={{sugarvar key='default' string=true}}}
                {/if}
            </select>
        </td>
        <td>
            &nbsp;
        </td>
    </tr>
    <tr>
        <td>
            {sugar_translate label='LBL_SELECTED_FIELDS' module='{{$module}}'}:
        </td>
        <td>
            {sugar_translate label='LBL_AVAILABLE_FIELDS' module='{{$module}}'}:
        </td>
    </tr>
    <tr>
        <td>
            <div class="{{sugarvar key='name'}}_scroll">
                <ul id="{{sugarvar key='name'}}_selected" class="{{sugarvar key='name'}}_connectedSortable">

                </ul>
            </div>
        </td>
        <td>
            <div class="{{sugarvar key='name'}}_scroll">
                <ul id="{{sugarvar key='name'}}_available" class="{{sugarvar key='name'}}_connectedSortable">

                </ul>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <input type="hidden" id="{{$displayParams.targetField}}" name="{{$displayParams.targetField}}" value="{$selectedFieldString}"/>
        </td>
    </tr>
</table>
