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
    protected $dir = null; /// Dir to the templates

    /**
     * Constructor
     * @param string
     */
    public function __construct($dir = null)
    {
        $this->vars = array();

        if ($dir !== null) {
            if (!is_dir($dir))
                throw new Exception("The specified template directory is not a directory.");
            $this->dir = $dir;
        }
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
     * Set template directory
     * @param string
     * @return Hups\Util\PHPTemplate
     */
    public function setDir($dir = null)
    {
        if ($dir !== null) {
            if (!is_dir($dir))
                throw new Exception("The specified template directory is not a directory.");
            $this->dir = $dir;
        }
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
        if (!empty($this->dir)) {
            $file = rtrim($this->dir, '/ ') . '/' . $file;
        }

        extract($this->vars);
        ob_start();
        include $file;
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

