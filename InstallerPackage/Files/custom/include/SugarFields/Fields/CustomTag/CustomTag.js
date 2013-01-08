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