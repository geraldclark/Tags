<?php

class Setting
{
    protected $category;
    protected $section;
    protected $database;
    protected $default_value;
    protected $fetched_value;
    protected $name;
    protected $possible_values;
    protected $auto_create;
    protected $label;
    public $value;

    /**
     * Initializes a setting object
     * @param $category - category of the setting
     * @param $name - name of the setting
     * @param $default_value - the default value
     * @param bool $database - whether or not this will be stored in the database config table or config_override.php
     */
    public function __construct($auto_create, $label, $category, $section, $name, $default_value, $possible_values = null, $database = false)
    {
        $this->name = $name;
        $this->default_value = $default_value;
        $this->possible_values = $possible_values;
        $this->category = $category;
        $this->section = $section;
        $this->database = $database;
        $this->auto_create = $auto_create;
        $this->label = $label;
        $this->retrieve();
    }

    /**
     * Returns the name of the setting for use.
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the control ID of the setting for use.
     * @return String
     */
    public function getId()
    {
        return $this->section . '_' . $this->category . '_' . $this->name;
    }

    /**
     * Retrieves the settings value
     */
    protected function retrieve()
    {
        if ($this->database)
        {
            require_once('modules/Administration/Administration.php');
            $administrationObj = new Administration();
            $administrationObj->retrieveSettings($this->category . '_' . $this->section);

            if (!isset($administrationObj->settings["{$this->category}_{$this->section}_{$this->name}"]))
            {
                $value = $this->retrieveFormat($this->default_value);
                if ($this->auto_create)
                {
                    $administrationObj->saveSetting($this->category . '_' . $this->section, $this->name, $this->saveFormat($value));
                }
                $this->value = $value;
            }
            else
            {
                $this->value = $this->retrieveFormat($administrationObj->settings["{$this->category}_{$this->section}_{$this->name}"]);
            }
        }
        else
        {
            require_once 'modules/Configurator/Configurator.php';
            $configuratorObj = new Configurator();
            $configuratorObj->loadConfig();

            if (!isset($configuratorObj->config['custom_settings'][$this->category][$this->section][$this->name]))
            {
                $value = $this->retrieveFormat($this->default_value);
                $configuratorObj->config['custom_settings'][$this->category][$this->section][$this->name] = $this->saveFormat($value);

                if ($this->auto_create)
                {
                    $configuratorObj->saveConfig();
                }

                $this->value = $value;
            }
            else
            {
                $this->value = $this->retrieveFormat($configuratorObj->config['custom_settings'][$this->category][$this->section][$this->name]);
            }
        }

        $this->checkPossibleValues();

        $this->fetched_value = $this->value;
    }

    /**
     * Saves the updated value to the database
     * @return bool|resource|void
     */
    public function save()
    {
        $this->checkPossibleValues();

        if ($this->value === $this->fetched_value)
        {
            return false;
        }

        if ($this->database)
        {
            require_once('modules/Administration/Administration.php');
            $administrationObj = new Administration();
            $result = $administrationObj->saveSetting($this->category . '_' . $this->section, $this->name, $this->saveFormat($this->value));
        }
        else
        {
            require_once 'modules/Configurator/Configurator.php';
            $configuratorObj = new Configurator();
            $configuratorObj->loadConfig();

            $configuratorObj->config['custom_settings'][$this->category][$this->section][$this->name] = $this->saveFormat($this->value);
            $configuratorObj->saveConfig();
            $result = true;
        }

        return $result;
    }

    /**
     * Checks if the value is an acceptable value
     */
    protected function checkPossibleValues()
    {
        if ($this->possible_values !== null)
        {
            if (is_array($this->possible_values) && !is_array($this->value))
            {
                if (!in_array($this->value, $this->possible_values))
                {
                    $GLOBALS['log']->fatal("Settings :: The setting '{$this->name}' was restored to its default value of '{$this->default_value}' after having an invalid value of '{$this->value}'.");
                    $this->value = $this->default_value;
                    $this->save();
                }
            }
            elseif (is_array($this->possible_values) && is_array($this->value))
            {
                $save = false;


                foreach ($this->value as $key=>$value)
                {
                    if (!in_array($value, array_keys($this->possible_values)))
                    {
                        unset($this->value[$key]);

                        $GLOBALS['log']->fatal("Settings :: The setting '{$this->name}' was had '$value' removed because it is an invalid selection.");
                        $save = true;
                    }
                }

                if ($save)
                {
                    $this->value = $this->default_value;
                    $this->save();
                }
            }
        }
    }

    /**
     * Formats a value when being retrieved
     * @param $value
     * @return mixed
     */
    protected function retrieveFormat($value)
    {
        //override this function
        return $value;
    }

    /**
     * Formats a value when being saved
     * @param $value
     * @return mixed
     */
    protected function saveFormat($value)
    {
        //override this function
        return $value;
    }

    public function getEditView()
    {
        $html = "";
        $id = $this->getId();

        if ($this->possible_values !== null)
        {
            if (is_array($this->possible_values) && !is_array($this->value))
            {
                $html = "<SELECT  ID=\"{$id}\" NAME=\"{$id}\">";

                foreach ($this->possible_values as $key=>$value)
                {
                    $label = translate($key, $this->category);
                    if ($this->value == $value)
                    {
                        $html .= "<OPTION VALUE=\"{$value}\" SELECTED>{$label}</OPTION>";
                    }
                    else
                    {
                        $html .= "<OPTION VALUE=\"{$value}\">{$label}</OPTION>";
                    }
                }

                $html .= "</SELECT>";
            }
            elseif (is_array($this->possible_values) && is_array($this->value))
            {
                $count = count($this->possible_values);

                if ($count > 10)
                {
                    $count = 10;
                }

                $html = "<SELECT  ID=\"{$id}\" NAME=\"{$id}[]\" MULTIPLE size=\"$count\">";

                foreach ($this->possible_values as $key=>$value)
                {
                    if (in_array($key, $this->value))
                    {
                        $html .= "<OPTION VALUE=\"{$key}\" SELECTED>{$value}</OPTION>";
                    }
                    else
                    {
                        $html .= "<OPTION VALUE=\"{$key}\">{$value}</OPTION>";
                    }
                }

                $html .= "</SELECT>";
            }
            else
            {
                $html = "<input type=\"text\" name=\"{$id}\" value=\"{$this->value}\">";
            }
        }
        else
        {
            $html = "<input type=\"text\" name=\"{$id}\" value=\"{$this->value}\">";
        }

        return $this->getEditViewContainer($html);
    }

    public function getEditViewContainer($innerHTML)
    {
        $label = translate($this->label, $this->category);
        $html =<<<HTML

        <td scope="row" width='25%'>
            {$label}:
        </td>
        <td width='25%' >
            {$innerHTML}
        </td>

HTML;

        return $html;
    }
}

?>
