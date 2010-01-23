<?php

/**
 * Static logger class.
 *
 * @package SLog
 * @author Mattijs Hoitink <mattijshoitink@gmail.com>
 * @license Modified BSD License
 * @copyright Copyright (C) 2010 Mattijs Hoitink. All rights reserved.
 */
class SLog
{
    CONST ERROR = 'error';
    CONST DEBUG = 'debug';
    CONST WARN = 'warn';
    CONST INFO = 'info';

    /**
     * SLog instance.
     * @var SLog
     */
    protected static $_instance = null;

    /**
     * Log writers registerd with the logger.
     * @var array
     */
    protected $_writers = array();

    /** **/

    /**
     * Private constructor for singleton use.
     */
    private function __construct()
    {}

    /**
     * Returns the active SLog instance.
     * @return SLog
     */
    public function getInstance()
    {
        if(null === self::$_instance) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    /**
     * Adds a writer.
     * @param SLog_Writer_Abstract $writer
     * @return SLog
     */
    public function addWriter(SLog_Writer_Abstract $writer)
    {
        $this->_writers[] = $writer;
        return $this;
    }

    /**
     * Clears all SLog writers.
     * @return SLog
     */
    public function clearWriters()
    {
        $this->_writers = array();
        return $this;
    }

    public function write($message, $level = SLog::INFO)
    {
        foreach($this->_writers as $writer) {
            $writer->write($message, $level);
        }
    }

    public static function log($message, $level = SLog::INFO)
    {
        $instance = self::$_instance;
        $instance->write($message, $level);
    }

    /**
     * Autoloader for SLog classes.
     * @param string $className
     */
    public static function autoload($className)
    {
        if(0 === strpos($className, 'SLog_')) {
            include realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
        }
    }
}
