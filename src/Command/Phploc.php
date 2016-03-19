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
    private $_colmap = [
        'directories'                 => 'Directories',
        'files'                       => 'Files',
        'loc'                         => 'Lines of Code (LOC)',
        'ccnByLloc'                   => 'Cyclomatic Complexity / Lines of Code',
        'cloc'                        => 'Comment Lines of Code (CLOC)',
        'ncloc'                       => 'Non-Comment Lines of Code (NCLOC)',
        'lloc'                        => 'Logical Lines of Code (LLOC)',
        'llocGlobal'                  => 'LLOC outside functions or classes',
        'namespaces'                  => 'Namespaces',
        'interfaces'                  => 'Interfaces',
        'traits'                      => 'Traits',
        'classes'                     => 'Classes',
        'abstractClasses'             => 'Abstract Classes',
        'concreteClasses'             => 'Concrete Classes',
        'llocClasses'                 => 'Classes Length (LLOC)',
        'methods'                     => 'Methods',
        'nonStaticMethods'            => 'Non-Static Methods',
        'staticMethods'               => 'Static Methods',
        'publicMethods'               => 'Public Methods',
        'nonPublicMethods'            => 'Non-Public Methods',
        'methodCcnAvg'                => 'Cyclomatic Complexity / Number of Methods',
        'functions'                   => 'Functions',
        'namedFunctions'              => 'Named Functions',
        'anonymousFunctions'          => 'Anonymous Functions',
        'llocFunctions'               => 'Functions Length (LLOC)',
        'llocByNof'                   => 'Average Function Length (LLOC)',
        'constants'                   => 'Constants',
        'globalConstants'             => 'Global Constants',
        'classConstants'              => 'Class Constants',
        'attributeAccesses'           => 'Attribute Accesses',
        'instanceAttributeAccesses'   => 'Non-Static Attribute Accesses',
        'staticAttributeAccesses'     => 'Static Attribute Accesses',
        'methodCalls'                 => 'Method Calls',
        'instanceMethodCalls'         => 'Non-Static Method Calls',
        'staticMethodCalls'           => 'Static Method Calls',
        'globalAccesses'              => 'Global Accesses',
        'globalVariableAccesses'      => 'Global Variable Accesses',
        'superGlobalVariableAccesses' => 'Super-Global Variable Accesses',
        'globalConstantAccesses'      => 'Global Constant Accesses',
        'testClasses'                 => 'Test Classes',
        'testMethods'                 => 'Test Methods',
    ];

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

            if (isset($this->_colmap[$key])) {
                $name = $this->_colmap[$key];
                $this->_tcEcho('(PHPloc) ' . $name, $value);
            }

            $this->_tcEcho('phploc_' . $key, $value);
        }
    }

    /**
     * @param $key
     * @param $value
     */
    protected function _tcEcho($key, $value)
    {
        echo "##teamcity[buildStatisticValue key='{$key}' value='{$value}']" . PHP_EOL;
    }
}
