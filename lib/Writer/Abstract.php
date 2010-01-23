<?php

/**
 * Abstract class for SLog writers.
 *
 * @package SLog
 * @subpackage Writer
 * @author Mattijs Hoitink <mattijshoitink@gmail.com>
 * @license Modified BSD License
 * @copyright Copyright (C) 2010 Mattijs Hoitink. All rights reserved.
 */
abstract class SLog_Writer_Abstract
{

    /**
     * Write a log message.
     * @param string $message
     * @param string $level
     * @return boolean
     */
    public abstract function write($message, $level = SLog::INFO);
}
