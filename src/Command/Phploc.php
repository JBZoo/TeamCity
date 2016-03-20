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
 * Class Phploc
 * @package JBZoo\Console
 */
class Phploc extends TeamCityCommand
{
    protected $_prefix = 'PHPloc';

    protected $_colmap = [
        // Filesystem
        'directories'                 => 'Directories',
        'files'                       => 'Files',

        // Size
        'loc'                         => 'Lines of Code (LOC)',
        'cloc'                        => 'Comment Lines of Code (CLOC)',
        'ncloc'                       => 'Non-Comment Lines of Code (NCLOC)',
        'lloc'                        => 'Logical Lines of Code (LLOC)',
        'llocClasses'                 => 'Classes Length (LLOC)',
        'classLlocAvg'                => 'Average Class Length',
        'classLlocMin'                => 'Minimum Class Length',
        'classLlocMax'                => 'Maximum Class Length',
        'methodLlocAvg'               => 'Average Method Length',
        'methodLlocMin'               => 'Minimum Method Length',
        'methodLlocMax'               => 'Maximum Method Length',
        'llocFunctions'               => 'Functions Length (LLOC)',
        'llocByNof'                   => 'Average Function Length (LLOC)',
        'llocGlobal'                  => 'LLOC outside functions or classes',

        // Cyclomatic Complexity
        'ccnByLloc'                   => 'Average Complexity per LLOC',
        'classCcnAvg'                 => 'Average Complexity per Class',
        'classCcnMin'                 => 'Minimum Class Complexity',
        'classCcnMax'                 => 'Maximum Class Complexity',
        'methodCcnAvg'                => 'Average Complexity per Method',
        'methodCcnMin'                => 'Minimum Method Complexity',
        'methodCcnMax'                => 'Maximum Method Complexity',

        // Dependencies
        'globalAccesses'              => 'Global Accesses',
        'globalConstantAccesses'      => 'Global Constant Accesses',
        'globalVariableAccesses'      => 'Global Variable Accesses',
        'superGlobalVariableAccesses' => 'Super-Global Variable Accesses',
        'attributeAccesses'           => 'Attribute Accesses',
        'instanceAttributeAccesses'   => 'Non-Static Attribute Accesses',
        'staticAttributeAccesses'     => 'Static Attribute Accesses',
        'methodCalls'                 => 'Method Calls',
        'instanceMethodCalls'         => 'Non-Static Method Calls',
        'staticMethodCalls'           => 'Static Method Calls',

        // Structure
        'namespaces'                  => 'Namespaces',
        'interfaces'                  => 'Interfaces',
        'traits'                      => 'Traits',
        'classes'                     => 'Classes',
        'abstractClasses'             => 'Abstract Classes',
        'concreteClasses'             => 'Concrete Classes',
        'methods'                     => 'Methods',
        'nonStaticMethods'            => 'Non-Static Methods',
        'staticMethods'               => 'Static Methods',
        'publicMethods'               => 'Public Methods',
        'nonPublicMethods'            => 'Non-Public Methods',
        'functions'                   => 'Functions',
        'namedFunctions'              => 'Named Functions',
        'anonymousFunctions'          => 'Anonymous Functions',
        'constants'                   => 'Constants',
        'globalConstants'             => 'Global Constants',
        'classConstants'              => 'Class Constants',

        // Tests
        'testClasses'                 => 'Test Classes',
        'testMethods'                 => 'Test Methods',

        // ???
        'ccn'                         => 'Cyclomatic Complexity ???',
        'ccnMethods'                  => 'Cyclomatic Complexity Methods ???',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configure() // @codingStandardsIgnoreLine
    {
        $this
            ->setName('teamcity:phploc')
            ->setDescription('Parse phploc file and send it to TeamCity report!')
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

        $xml = new \SimpleXMLElement($xmlPath, null, true);

        $this->_printFields((array)$xml);
    }
}
