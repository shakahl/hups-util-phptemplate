<?php

namespace Hups\Util;

/**
 * PHP Template engine
 *
 * Implements the same interface as Savant3 and Smarty.
 * Forked from: https://github.com/lsolesen/php-template/
 *
 * PHP version 5.5
 *
 * Usage
 * <code>
 * $tpl = new \Hups\Util\PHPTemplate('/dir/to/template_file.php');
 * $tpl->some_variable = 'some value';
 * $tpl->set('another_variable', 'some value');
 * $tpl->assign('another_variable2', 'some value');
 * $renderedOutput = $tpl->fetch('template-tpl.php');
 * $tpl->display('template-tpl.php');
 * </code>
 *
 * @category  Template
 * @package   Hups\Util\PHPTemplate
 * @author    Szélpál Soma <szelpalsoma+hups@gmail.com>
 * @license   MIT Open Source License http://opensource.org/osi3.0/licenses/mit-license.php
 * @version   @package-version@
 */
class PHPTemplate
{
	/**
	 * TStorage for template variables
	 * @var array
	 */
    protected $vars = array(); /// Holds all the template variables

    /**
     * Dir to the template file
     * @var string
     */
    protected $dir = []; /// Dir to the templates

    /**
     * Constructor
     * @param string
     */
    public function __construct($templateDir = null)
    {
        $this->vars = array();

        if ($templateDir && is_array($templateDir))
        {
            foreach ($templateDir as $d)
            {
                $this->addDirectory($d);
            }
        }
        elseif ($templateDir)
        {
            $this->addDirectory($templateDir);
        }
    }

    /**
     * Find a file in the template directories
     * @param  string $filename
     * @return string|null
     */
    public function findTemplateFile($filename)
    {
        foreach ($this->dir as $index => $dirname)
        {
            if (is_dir($dirname) && file_exists($dirname . '/' . $filename)) {
                return $dirname . '/' . $filename;
            }
        }

        return null;
    }

    /**
     * Static instance creator
     * @param  string
     * @return Hups\Util\PHPTemplate
     */
    public static function create($dir = null)
    {
        return new self($dir);
    }

    /**
     * Ads a template directory 
     * @param string
     * @return Hups\Util\PHPTemplate
     */
    public function addDirectory($dirname)
    {        
        if (!is_dir($dirname))
            throw new Exception("Invalid directory: $dirname");

        $this->dir[] = $dirname;
        
        return $this;
    }

    /**
     * Sets a template variable.
     * @param string $name  name of the variable to set
     * @param mixed  $value the value of the variable
     * @return Hups\Util\PHPTemplate
     */
    public function assign($name, $value = null)
    {
        $this->vars[$name] = $value;
        return $this;
    }

    /**
     * An alias of "assign"
     * @param string $name
     * @param mixed  $value
     * @return Hups\Util\PHPTemplate
     */
    public function set($name, $value = null)
    {
        return $this->assign($name, $value);
    }

    /**
     * Get previously set variable
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (array_key_exists($key, $this->vars)) {
            return $this->vars[$key];
        }

        return $default;
    }

    /**
     * Set a bunch of variables at once using an associative array.
     * @param array $vars  array of vars to set
     * @param bool  $clear whether to completely overwrite the existing vars
     * @return Hups\Util\PHPTemplate
     */
    public function setVars($vars, $clear = false)
    {
        if ($clear) {
            $this->vars = $vars;
        } else {
            if (is_array($vars)) $this->vars = array_merge($this->vars, $vars);
        }
        return $this;
    }

    /**
     * Open, parse, and return the template file.
     * @param string $file the template file name
     * @return string
     */
    public function fetch($file)
    {
        $templateFile = $this->findTemplateFile($file);

        if (empty($templateFile)) {
            throw new Exception("Template file does not exists: $file");            
        }

        extract($this->vars);
        ob_start();
        include $templateFile;
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }

    /**
     * Displays (echo) the template directly
     * @param string $file the template file name
     * @return string
     */
    public function display($file)
    {
        echo $this->fetch($file);
    }

    /**
     * __set magic method
     */
    public function __set($name, $value)
    {
        return $this->assign($name, $value);
    }

    /**
     * __get magic method
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->vars)) {
            return $this->vars[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }

    /**
     * As of PHP 5.1.0
     */
    public function __isset($name)
    {
        return isset($this->vars[$name]);
    }

    /**
     * As of PHP 5.1.0
     */
    public function __unset($name)
    {
        echo "Unsetting '$name'\n";
        unset($this->vars[$name]);
    }
}

