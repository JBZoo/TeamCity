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

use JBZoo\TeamCity\Command as TeamCityCommand;
use JBZoo\Console\Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Phpmetrics
 * @package JBZoo\Console
 */
class Phpmetrics extends TeamCityCommand
{
    protected $_prefix = 'PHP Metrics';

    /**
     * @see http://www.phpmetrics.org/documentation/index.html
     * @see http://en.wikipedia.org/wiki/Halstead_complexity_measures
     * @see http://en.wikipedia.org/wiki/Maintainability
     * @see http://en.wikipedia.org/wiki/Cyclomatic_complexity
     *
     * @var array
     */
    protected $_colmap = [
        'ca'          => 'Afferent coupling',
        'bugs'        => 'Number of estimated bugs',
        'commw'       => 'Comment weight',
        'cc'          => 'Cyclomatic complexity',
        'dc'          => 'Data Complexity',
        'diff'        => 'Difficulty of the code',
        'ce'          => 'Efferent coupling',
        'effort'      => 'Effort to understand',
        'instability' => 'Class resilience to change',
        'IC'          => 'Intelligent content',
        'lcom'        => 'Lack of cohesion',
        'length'      => 'Length',
        'loc'         => 'Number of lines of code',
        'lloc'        => 'Number of logical lines of code',
        'MI'          => 'Maintenability index',
        'MIwC'        => 'Maintenability Index without comments',
        'distance'    => 'Myers distance',
        'interval'    => 'Myers interval',
        'noc'         => 'Number of classes',
        'noca'        => 'Number of abstract classes',
        'nocc'        => 'Number of concrete classes',
        'operators'   => 'Number of operators',
        'rdc'         => 'Relative data complexity',
        'rsc'         => 'Relative structural complexity',
        'rsysc'       => 'Relative System complexity',
        'sc'          => 'System complexity',
        'sysc'        => 'Total System complexity',
        'time'        => 'Time to understand',
        'vocabulary'  => 'Used vocabulary',
        'volume'      => 'Volume',
        'noi'         => 'Number Of Interfaces',
        'nom'         => 'Number Of Methods',

        'cyclomaticComplexity' => 'Cyclomatic complexity',
        'maintainabilityIndex' => 'Maintainability index',
        'difficulty'           => 'Difficulty index',
        'intelligentContent'   => 'Intelligent content',
        'commentWeight'        => 'Comment weight',
        'efferentCoupling'     => 'Efferent coupling',
        'afferentCoupling'     => 'Afferent coupling',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configure() // @codingStandardsIgnoreLine
    {
        $this
            ->setName('teamcity:phpmetrics')
            ->setDescription('Parse phpmetrics xml file and send it to TeamCity report!')
            ->addArgument('xml', InputOption::VALUE_REQUIRED, 'Path to phploc xml file');
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output) // @codingStandardsIgnoreLine
    {
        $this->_executePrepare($input, $output);

        $xmlPath = $input->getArgument('xml');

        if (!file_exists($xmlPath)) {
            throw new Exception('XML file not found: ' . $xmlPath);
        }

        $cloverXml = new \SimpleXMLElement($xmlPath, null, true);
        $fields    = current($cloverXml->attributes());

        $this->_printFields($fields);
    }
}
