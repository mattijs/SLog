<?php

/**
 * SLog writer for files.
 *
 * @package SLog
 * @subpackage Writer
 * @author Mattijs Hoitink <mattijshoitink@gmail.com>
 * @license Modified BSD License
 * @copyright Copyright (C) 2010 Mattijs Hoitink. All rights reserved.
 */
class SLog_Writer_File extends SLog_Writer_Abstract
{

    /**
     * Filepath to write to.
     * @var string
     */
    protected $_file = null;

    /**
     * File handler resource
     * @var Resource
     */
    protected $_fh = null;

    /** **/

    /**
     * Constructor. Takes an optional file path argument to the output file.
     * @param string $file
     */
    public function __construct($file = null)
    {
        if(null !== $file) {
            $this->setFile($file);
        }
    }

    public function  __destruct()
    {
        $this->close();
    }

    /**
     * Sets the output file.
     * @param string $file
     * @return SLog_Writer_File
     */
    public function setFile($file)
    {
        $this->_file = $file;
        return $this;
    }

    /**
     * Write a message to the log file.
     * @param string $message
     * @param string $level
     * @return boolean
     */
    public function write($message, $level = SLog::INFO)
    {
        if(!$this->_isOpen()) {
            $this->open();
        }

        $message = $this->_format($message, $level);
        $bytes = fwrite($this->_fh, $message);

        if(false === $bytes) {
            return false;
        }

        return true;
    }

    /**
     * Format a message.
     * @todo introduce formatters so message format can be specified.
     * @param string $message
     * @param string $level
     * @return string
     */
    protected function _format($message, $level)
    {
        $formatted = date('d/m/Y G:i:s') . " [{$level}] $message\n";

        return $formatted;
    }
    
    /**
     * Opens a file handle to the output file.
     * @return boolean
     */
    public function open()
    {
        $this->_fh = fopen($this->_file, 'a');
        
        if(false == $this->_fh) {
            $this->_fh = null;
            return false;
        }

        return true;
    }

    /**
     * Check if the filehandle is open.
     * @return boolean
     */
    protected function _isOpen()
    {
        return (!is_null($this->_fh));
    }

    /**
     * Close the file handle to the output file.
     */
    public function close()
    {
        if($this->_isOpen()) {
            fclose($this->_fh);
        }
    }
}
