<?php
/**
 * JBZoo TeamCity
 *
 * This file is part of the JBZoo CCK package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package   TeamCity
 * @license   MIT
 * @copyright Copyright (C) JBZoo.com,  All rights reserved.
 * @link      https://github.com/JBZoo/TeamCity".
 */

namespace JBZoo\TeamCity;

use JBZoo\Console\Command as ConsoleCommand;
use JBZoo\Utils\Cli;

/**
 * Class Clover
 * @package JBZoo\TeamCity
 */
abstract class Command extends ConsoleCommand
{
    protected $_prefix = '';
    protected $_exclude = [];
    protected $_colmap = [];

    /**
     * @param array $fields
     * @param bool  $translate
     * @throws Exception
     */
    protected function _printFields(array $fields, $translate = true)
    {
        foreach ($fields as $key => $value) {

            if (in_array($key, $this->_exclude, true)) {
                continue;
            }

            if (!$translate) {
                $this->_tcEcho($key, $value);

            } elseif (isset($this->_colmap[$key]) && $this->_colmap[$key]) {
                $this->_tcEcho($this->_colmap[$key], $value);

            } else {
                throw new Exception("{$key}=>{$value} not found in column map");
            }
        }
    }

    /**
     * @param $key
     * @param $value
     */
    protected function _tcEcho($key, $value)
    {
        $key = str_replace("'", "\\'", $key);
        $key = $this->_prefix ? $this->_prefix . ': ' . $key : $key;

        if (strpos($value, '.') || is_float($value)) {
            $value = round($value, 6);
        } else {
            $value = str_replace("'", "\\'", $value);
        }

        Cli::out("##teamcity[buildStatisticValue key='{$key}' value='{$value}']");
    }
}
