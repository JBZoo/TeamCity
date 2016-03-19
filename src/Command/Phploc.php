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

namespace JBZoo\Console\Command;

use JBZoo\Console\Command;
use JBZoo\Console\Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Example
 * @package JBZoo/Console
 * @codeCoverageIgnore
 */
class Phploc extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure() // @codingStandardsIgnoreLine
    {
        $this
            ->setName('phploc')
            ->setDescription('Parse phploc file and send it to TeamCity report!')
            ->addOption('xml', null, InputOption::VALUE_REQUIRED, 'Path to phploc xml file', null);
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output) // @codingStandardsIgnoreLine
    {
        $this->_executePrepare($input, $output);

        $xmlPath = $this->_getOpt('xml');

        if (!file_exists($xmlPath)) {
            throw new Exception('phploc xml file not found!');
        }

        $xml    = new \SimpleXMLElement($xmlPath, null, true);
        $fields = (array)$xml;

        foreach ($fields as $key => $value) {
            echo "##teamcity[buildStatisticValue key='phploc_{$key}' value='{$value}']" . PHP_EOL;
        }
    }
}
