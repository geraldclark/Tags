<?php

	class tag_TaggersController extends SugarController
	{
		function action_RunAutoTag()
		{
			$this->view = 'runautotag';
		}

        function action_EditView()
        {
            if (BeanFactory::newBean('tag_Tags')->hasInstalledModules())
            {
                $this->view = 'edit';
            }
            else
            {
                $this->view = "error";
            }
        }
	}

?>