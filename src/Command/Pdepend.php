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
 * Class Pdepend
 * @package JBZoo\Console
 */
class Pdepend extends TeamCityCommand
{
    protected $_prefix = 'PHP Depend';

    protected $_exclude = [
        'generated',
        'pdepend',
    ];

    protected $_colmap = [
        'ahh'    => 'Average Hierarchy Height',
        'andc'   => 'Average Number of Derived Classes',
        'ca'     => 'Afferent Coupling',
        'calls'  => 'Number of Method or Function Calls',
        'cbo'    => 'Coupling Between Objects',
        'ccn'    => 'Cyclomatic Complexity Number',
        'ccn2'   => 'Extended Cyclomatic Complexity Number',
        'ce'     => 'Efferent Coupling',
        'cis'    => 'Class Interface Size',
        'cloc'   => 'Comment Lines fo Code',
        'clsa'   => 'Number of Abstract Classes',
        'clsc'   => 'Number of Concrete Classes',
        'cr'     => 'Code Rank',
        'csz'    => 'Class Size',
        'dit'    => 'Depth of Inheritance Tree',
        'eloc'   => 'Executable Lines of Code',
        'fanout' => 'Number of Fanouts',
        'leafs'  => 'Number of Leaf Classes',
        'lloc'   => 'Logical Lines Of Code',
        'loc'    => 'Lines Of Code',
        'maxDIT' => 'Max Depth of Inheritance Tree',
        'noam'   => 'Number Of Added Methods',
        'nocc'   => 'Number Of Child Classes',
        'noom'   => 'Number Of Overwritten Methods',
        'ncloc'  => 'Non Comment Lines Of Code',
        'noc'    => 'Number Of Classes',
        'nof'    => 'Number Of Functions',
        'noi'    => 'Number Of Interfaces',
        'nom'    => 'Number Of Methods',
        'npm'    => 'Number of Public Methods',
        'npath'  => 'NPath Complexity',
        'nop'    => 'Number of Packages',
        'rcr'    => 'Reverse Code Rank',
        'roots'  => 'Number of Root Classes',
        'vars'   => 'Properties',
        'varsi'  => 'Inherited Properties',
        'varsnp' => 'Non Private Properties',
        'wmc'    => 'Weighted Method Count',
        'wmci'   => 'Inherited Weighted Method Count',
        'wmcnp'  => 'Non Private Weighted Method Count',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configure() // @codingStandardsIgnoreLine
    {
        $this
            ->setName('teamcity:pdepend')
            ->setDescription('Parse pdepend summary.xml and send it to TeamCity report!')
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
