/**
 * Redirects user to search form when a tag is clicked
 * @param field
 * @param module
 * @param searchForm
 * @param searchFormShort
 * @param tag
 */
function searchTag(field, module, searchForm, searchFormShort, tag)
{
    var form = $(
        '<form action="index.php?module='+module+'&action=index" method="post">' +
        '<input type="hidden" name="searchFormTab" value="'+searchForm+'" />' +
        '<input type="hidden" name="modules" value="'+module+'" />' +
        '<input type="hidden" name="action" value="index" />' +
        '<input type="hidden" name="'+field.toLowerCase()+"_"+searchFormShort+'[]" value="'+tag.trim()+'" />' +
        '<input type="hidden" value="true" name="query"/>' +
        '</form>'
    );

    $('body').append(form);
    $(form).submit();
}

/**
 * Shows message to user if the response is not 'Success'
 * @param response
 */
function handleResult(element, response)
{
    regex = /<message>(.*?)<\/message>/;
    m = response.match(regex);

    if (m != null)
    {
        if (m[1].indexOf("Success: ") == -1)
        {
            //show message
            alert(m[1]);
        }
        else
        {
            //add id a tagvalue
            $(element).attr('tagvalue', m[1].replace("Success: ","").trim());
        }
    }
}

/**
 * Populates the tags for a record
 * @param module
 * @param record_id
 * @param control_id
 */
function populateTags(module, record_id, control_id)
{

    $('#'+control_id+'_loader').hide();
    $('#'+control_id+'_content_loader').html('<img src="themes/default/images/img_loading.gif" align="absmiddle">');

    url = 'index.php?to_pdf=1&module=tag_Tags&action=LoadTags&record_module='+module+'&record_id='+record_id;

    $.getJSON(url, function(json){
        $('#'+control_id+'_list').hide();
        $('#'+control_id+'_list').find(".tagit-choice").remove();

        $.each( json, function( key, value ) {
            $('#'+control_id+'_list').tagit("add", {label: value, value: key});
        });

        $('#'+control_id+'_content_loader').hide();

        $('#'+control_id+'_list').removeClass('prevent');
        $('#'+control_id+'_list').show();


    });
}
