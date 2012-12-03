<?php

class Setting
{

    protected $category;
    protected $database;
    protected $default_value;
    protected $fetched_value;
    protected $name;
    protected $possible_values;
    public $value;

    /**
     * Initializes a setting object
     * @param $category - category of the setting
     * @param $name - name of the setting
     * @param $default_value - the default value
     * @param bool $database - whether or not this will be stored in the database config table or config_override.php
     */
    public function __construct($category, $name, $default_value, $possible_values = null, $database = false)
    {
        $this->name = $name;
        $this->default_value = $default_value;
        $this->possible_values = $possible_values;
        $this->category = $category;
        $this->database = $database;
        $this->retrieve();
    }

    /**
     * Returns the name of the setting for use.
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
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
            $administrationObj->retrieveSettings($this->category);

            if (!isset($administrationObj->settings["{$this->category}_{$this->name}"]))
            {
                $value = $this->retrieveFormat($this->default_value);
                $administrationObj->saveSetting($this->category, $this->name, $value);
                $this->value = $value;
            }
            else
            {
                $this->value = $this->retrieveFormat($administrationObj->settings["{$this->category}_{$this->name}"]);
            }
        }
        else
        {
            require_once 'modules/Configurator/Configurator.php';
            $configuratorObj = new Configurator();
            $configuratorObj->loadConfig();

            if (!isset($configuratorObj->config['custom_settings'][$this->category][$this->name]))
            {
                $value = $this->retrieveFormat($this->default_value);
                $configuratorObj->config['custom_settings'][$this->category][$this->name] = $value;
                $configuratorObj->saveConfig();

                $this->value = $value;
            }
            else
            {
                $this->value = $this->retrieveFormat($configuratorObj->config['custom_settings'][$this->category][$this->name]);
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
            $result = $administrationObj->saveSetting($this->category, $this->name, $this->saveFormat($this->value));
        }
        else
        {
            require_once 'modules/Configurator/Configurator.php';
            $configuratorObj = new Configurator();
            $configuratorObj->loadConfig();

            $configuratorObj->config['custom_settings'][$this->category][$this->name] = $this->saveFormat($this->value);
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
            if (is_array($this->possible_values))
            {
                if (!in_array($this->value, $this->possible_values))
                {
                    $GLOBALS['log']->fatal("Settings :: The setting '{$this->name}' was restored to its default value of '{$this->default_value}' after having an invalid value of '{$this->value}'.");
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
}

?>
