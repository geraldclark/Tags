<?php

class tag_TagsController extends SugarController
{
    function action_AddTags()
    {
        $this->view = 'addtags';
    }

    function action_LoadTags()
    {
        $this->view = 'loadtags';
    }

    function action_GetTags()
    {
        $this->view = 'gettags';
    }

    function action_RemoveTags()
    {
        $this->view = 'removetags';
    }

    function action_Settings()
    {
        $this->view = 'settings';
    }

    function action_EditView()
    {
        if (BeanFactory::newBean('tag_Tags')->hasInstalledModules())
        {
            $this->view = 'edit';
        }
        else
        {
            $this->view = 'error';
        }
    }

    function action_Error()
    {
        $this->view = 'error';
    }

    function action_DuplicateFound()
    {
        $this->view = 'duplicatefound';
    }
}

?>