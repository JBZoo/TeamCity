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
 * Class Clover
 * @package JBZoo\Console
 */
class Clover extends TeamCityCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure() // @codingStandardsIgnoreLine
    {
        $this
            ->setName('teamcity:clover')
            ->setDescription('Parse phpunit clover.xml file and send it to TeamCity report!')
            ->addArgument('xml', InputOption::VALUE_REQUIRED, 'Path to phploc xml file')
            ->addOption('crap-threshold', null, InputOption::VALUE_OPTIONAL, 'Path to phploc xml file', 30);
    }


    /**
     * {@inheritdoc}
     * @throws Exception
     *
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function execute(InputInterface $input, OutputInterface $output) // @codingStandardsIgnoreLine
    {
        $this->_executePrepare($input, $output);

        $crapThreshold = $this->_getOpt('crap-threshold');
        $xmlPath       = $input->getArgument('xml');
        if (!file_exists($xmlPath)) {
            throw new Exception('XML file not found: ' . $xmlPath);
        }

        $cloverXml = new \SimpleXMLElement($xmlPath, null, true);
        $info      = $cloverXml->project->metrics;

        $coveredClasses = 0;
        foreach ($cloverXml->xpath('//class') as $class) {
            if ((int)$class->metrics['coveredmethods'] === (int)$class->metrics['methods']) {
                $coveredClasses++;
            }
        }

        $data = array(
            'CodeCoverageAbsLTotal'   => (int)$info['elements'],
            'CodeCoverageAbsLCovered' => (int)$info['coveredelements'],
            'CodeCoverageAbsBTotal'   => (int)$info['statements'],
            'CodeCoverageAbsBCovered' => (int)$info['coveredstatements'],
            'CodeCoverageAbsMTotal'   => (int)$info['methods'],
            'CodeCoverageAbsMCovered' => (int)$info['coveredmethods'],
            'CodeCoverageAbsCTotal'   => (int)$info['classes'],
            'CodeCoverageAbsCCovered' => $coveredClasses,
            'CodeCoverageL'           => $info['elements'] ? $info['coveredelements'] / $info['elements'] * 100 : 0,
            'CodeCoverageM'           => $info['methods'] ? $info['coveredmethods'] / $info['methods'] * 100 : 0,
            'CodeCoverageC'           => $info['classes'] ? $coveredClasses / $info['classes'] * 100 : 0,
            'Files'                   => (int)$info['files'],
            'LinesOfCode'             => (int)$info['loc'],
            'NonCommentLinesOfCode'   => (int)$info['ncloc'],
        );

        $data['CodeCoverageB'] = $info['statements'] ? $info['coveredstatements'] / $info['statements'] * 100 : 0;

        if ($crapThreshold) {
            $crapValues = array();
            $crapAmount = 0;

            foreach ($cloverXml->xpath('//@crap') as $crap) {
                $crap         = (float)$crap;
                $crapValues[] = $crap;
                if ($crap >= $crapThreshold) {
                    $crapAmount++;
                }
            }

            $crapValuesCount = count($crapValues);
            $crapTotal       = array_sum($crapValues);

            $data['CRAPAmount']  = $crapAmount;
            $data['CRAPPercent'] = $crapValuesCount ? $crapAmount / $crapValuesCount * 100 : 0;
            $data['CRAPTotal']   = $crapTotal;
            $data['CRAPAverage'] = $crapValuesCount ? $crapTotal / $crapValuesCount : 0;
            $data['CRAPMaximum'] = max($crapValues);
        }

        $this->_printFields($data, false);
    }
}
