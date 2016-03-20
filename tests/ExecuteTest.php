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
 * @link      https://github.com/JBZoo/TeamCity
 */

namespace JBZoo\PHPUnit;

use JBZoo\Utils\Cli;

/**
 * Class ExecuteTest
 * @package JBZoo\PHPUnit
 */
class ExecuteTest extends PHPUnit
{
    protected $_binpath = 'php ./vendor/jbzoo/console/bin/jbzoo';

    public function testClover()
    {
        $actual = Cli::exec($this->_binpath . ' teamcity:clover ./tests/fixtures/clover.xml');

        $expected = implode(PHP_EOL, [
            "##teamcity[buildStatisticValue key='CodeCoverageAbsLTotal' value='396']",
            "##teamcity[buildStatisticValue key='CodeCoverageAbsLCovered' value='260']",
            "##teamcity[buildStatisticValue key='CodeCoverageAbsBTotal' value='342']",
            "##teamcity[buildStatisticValue key='CodeCoverageAbsBCovered' value='231']",
            "##teamcity[buildStatisticValue key='CodeCoverageAbsMTotal' value='54']",
            "##teamcity[buildStatisticValue key='CodeCoverageAbsMCovered' value='29']",
            "##teamcity[buildStatisticValue key='CodeCoverageAbsCTotal' value='17']",
            "##teamcity[buildStatisticValue key='CodeCoverageAbsCCovered' value='9']",
            "##teamcity[buildStatisticValue key='CodeCoverageL' value='65.656566']",
            "##teamcity[buildStatisticValue key='CodeCoverageM' value='53.703704']",
            "##teamcity[buildStatisticValue key='CodeCoverageC' value='52.941176']",
            "##teamcity[buildStatisticValue key='Files' value='26']",
            "##teamcity[buildStatisticValue key='LinesOfCode' value='1827']",
            "##teamcity[buildStatisticValue key='NonCommentLinesOfCode' value='1035']",
            "##teamcity[buildStatisticValue key='CodeCoverageB' value='67.54386']",
            "##teamcity[buildStatisticValue key='CRAPAmount' value='5']",
            "##teamcity[buildStatisticValue key='CRAPPercent' value='9.259259']",
            "##teamcity[buildStatisticValue key='CRAPTotal' value='417.28']",
            "##teamcity[buildStatisticValue key='CRAPAverage' value='7.727407']",
            "##teamcity[buildStatisticValue key='CRAPMaximum' value='132']",
            "",
        ]);

        isSame($expected, $actual);
    }

    public function testPHPDepend()
    {
        $actual = Cli::exec($this->_binpath . ' teamcity:pdepend ./tests/fixtures/pdepend.xml');

        $expected = implode(PHP_EOL, [
            "##teamcity[buildStatisticValue key='PHP Depend: Average Hierarchy Height' value='2.5']",
            "##teamcity[buildStatisticValue key='PHP Depend: Average Number of Derived Classes' value='0.631579']",
            "##teamcity[buildStatisticValue key='PHP Depend: Number of Method or Function Calls' value='167']",
            "##teamcity[buildStatisticValue key='PHP Depend: Cyclomatic Complexity Number' value='110']",
            "##teamcity[buildStatisticValue key='PHP Depend: Extended Cyclomatic Complexity Number' value='130']",
            "##teamcity[buildStatisticValue key='PHP Depend: Comment Lines fo Code' value='630']",
            "##teamcity[buildStatisticValue key='PHP Depend: Number of Abstract Classes' value='3']",
            "##teamcity[buildStatisticValue key='PHP Depend: Number of Concrete Classes' value='13']",
            "##teamcity[buildStatisticValue key='PHP Depend: Executable Lines of Code' value='688']",
            "##teamcity[buildStatisticValue key='PHP Depend: Number of Fanouts' value='42']",
            "##teamcity[buildStatisticValue key='PHP Depend: Number of Leaf Classes' value='8']",
            "##teamcity[buildStatisticValue key='PHP Depend: Logical Lines Of Code' value='429']",
            "##teamcity[buildStatisticValue key='PHP Depend: Lines Of Code' value='1553']",
            "##teamcity[buildStatisticValue key='PHP Depend: Max Depth of Inheritance Tree' value='4']",
            "##teamcity[buildStatisticValue key='PHP Depend: Non Comment Lines Of Code' value='923']",
            "##teamcity[buildStatisticValue key='PHP Depend: Number Of Classes' value='16']",
            "##teamcity[buildStatisticValue key='PHP Depend: Number Of Functions' value='5']",
            "##teamcity[buildStatisticValue key='PHP Depend: Number Of Interfaces' value='0']",
            "##teamcity[buildStatisticValue key='PHP Depend: Number Of Methods' value='51']",
            "##teamcity[buildStatisticValue key='PHP Depend: Number of Packages' value='10']",
            "##teamcity[buildStatisticValue key='PHP Depend: Number of Root Classes' value='4']",
            "",
        ]);

        isSame($expected, $actual);
    }

    public function testPHPloc()
    {
        $actual = Cli::exec($this->_binpath . ' teamcity:phploc ./tests/fixtures/phploc.xml');

        $expected = implode(PHP_EOL, [
            "##teamcity[buildStatisticValue key='PHPloc: Directories' value='559']",
            "##teamcity[buildStatisticValue key='PHPloc: Files' value='2617']",
            "##teamcity[buildStatisticValue key='PHPloc: Lines of Code (LOC)' value='360990']",
            "##teamcity[buildStatisticValue key='PHPloc: Logical Lines of Code (LLOC)' value='75183']",
            "##teamcity[buildStatisticValue key='PHPloc: Classes Length (LLOC)' value='65226']",
            "##teamcity[buildStatisticValue key='PHPloc: Functions Length (LLOC)' value='3909']",
            "##teamcity[buildStatisticValue key='PHPloc: LLOC outside functions or classes' value='6048']",
            "##teamcity[buildStatisticValue key='PHPloc: Comment Lines of Code (CLOC)' value='119833']",
            "##teamcity[buildStatisticValue key='PHPloc: Cyclomatic Complexity ???' value='19373']",
            "##teamcity[buildStatisticValue key='PHPloc: Cyclomatic Complexity Methods ???' value='18563']",
            "##teamcity[buildStatisticValue key='PHPloc: Interfaces' value='206']",
            "##teamcity[buildStatisticValue key='PHPloc: Traits' value='8']",
            "##teamcity[buildStatisticValue key='PHPloc: Classes' value='2611']",
            "##teamcity[buildStatisticValue key='PHPloc: Abstract Classes' value='113']",
            "##teamcity[buildStatisticValue key='PHPloc: Concrete Classes' value='2498']",
            "##teamcity[buildStatisticValue key='PHPloc: Functions' value='1358']",
            "##teamcity[buildStatisticValue key='PHPloc: Named Functions' value='893']",
            "##teamcity[buildStatisticValue key='PHPloc: Anonymous Functions' value='465']",
            "##teamcity[buildStatisticValue key='PHPloc: Methods' value='14537']",
            "##teamcity[buildStatisticValue key='PHPloc: Public Methods' value='12358']",
            "##teamcity[buildStatisticValue key='PHPloc: Non-Public Methods' value='2179']",
            "##teamcity[buildStatisticValue key='PHPloc: Non-Static Methods' value='13666']",
            "##teamcity[buildStatisticValue key='PHPloc: Static Methods' value='871']",
            "##teamcity[buildStatisticValue key='PHPloc: Constants' value='712']",
            "##teamcity[buildStatisticValue key='PHPloc: Class Constants' value='572']",
            "##teamcity[buildStatisticValue key='PHPloc: Global Constants' value='140']",
            "##teamcity[buildStatisticValue key='PHPloc: Test Classes' value='0']",
            "##teamcity[buildStatisticValue key='PHPloc: Test Methods' value='0']",
            "##teamcity[buildStatisticValue key='PHPloc: Average Complexity per LLOC' value='0.257678']",
            "##teamcity[buildStatisticValue key='PHPloc: Average Function Length (LLOC)' value='2.878498']",
            "##teamcity[buildStatisticValue key='PHPloc: Method Calls' value='47319']",
            "##teamcity[buildStatisticValue key='PHPloc: Static Method Calls' value='3568']",
            "##teamcity[buildStatisticValue key='PHPloc: Non-Static Method Calls' value='43751']",
            "##teamcity[buildStatisticValue key='PHPloc: Attribute Accesses' value='17768']",
            "##teamcity[buildStatisticValue key='PHPloc: Static Attribute Accesses' value='1036']",
            "##teamcity[buildStatisticValue key='PHPloc: Non-Static Attribute Accesses' value='16732']",
            "##teamcity[buildStatisticValue key='PHPloc: Global Accesses' value='2142']",
            "##teamcity[buildStatisticValue key='PHPloc: Global Variable Accesses' value='92']",
            "##teamcity[buildStatisticValue key='PHPloc: Super-Global Variable Accesses' value='199']",
            "##teamcity[buildStatisticValue key='PHPloc: Global Constant Accesses' value='1851']",
            "##teamcity[buildStatisticValue key='PHPloc: Minimum Class Complexity' value='1']",
            "##teamcity[buildStatisticValue key='PHPloc: Average Complexity per Class' value='7.526036']",
            "##teamcity[buildStatisticValue key='PHPloc: Maximum Class Complexity' value='536']",
            "##teamcity[buildStatisticValue key='PHPloc: Minimum Class Length' value='0']",
            "##teamcity[buildStatisticValue key='PHPloc: Average Class Length' value='23.105207']",
            "##teamcity[buildStatisticValue key='PHPloc: Maximum Class Length' value='1631']",
            "##teamcity[buildStatisticValue key='PHPloc: Minimum Method Complexity' value='1']",
            "##teamcity[buildStatisticValue key='PHPloc: Average Complexity per Method' value='2.343962']",
            "##teamcity[buildStatisticValue key='PHPloc: Maximum Method Complexity' value='242']",
            "##teamcity[buildStatisticValue key='PHPloc: Minimum Method Length' value='0']",
            "##teamcity[buildStatisticValue key='PHPloc: Average Method Length' value='4.388471']",
            "##teamcity[buildStatisticValue key='PHPloc: Maximum Method Length' value='338']",
            "##teamcity[buildStatisticValue key='PHPloc: Namespaces' value='354']",
            "##teamcity[buildStatisticValue key='PHPloc: Non-Comment Lines of Code (NCLOC)' value='241157']",
            "",
        ]);

        isSame($expected, $actual);
    }

    public function testPHPMetrics()
    {
        $actual = Cli::exec($this->_binpath . ' teamcity:phpmetrics ./tests/fixtures/phpmetrics.xml');

        $expected = implode(PHP_EOL, [
            "##teamcity[buildStatisticValue key='PHP Metrics: Number of lines of code' value='1790']",
            "##teamcity[buildStatisticValue key='PHP Metrics: Number of logical lines of code' value='363']",
            "##teamcity[buildStatisticValue key='PHP Metrics: Cyclomatic complexity' value='4.76']",
            "##teamcity[buildStatisticValue key='PHP Metrics: Maintainability index' value='117.48']",
            "##teamcity[buildStatisticValue key='PHP Metrics: Volume' value='660.36']",
            "##teamcity[buildStatisticValue key='PHP Metrics: Used vocabulary' value='27.28']",
            "##teamcity[buildStatisticValue key='PHP Metrics: Difficulty index' value='8.15']",
            "##teamcity[buildStatisticValue key='PHP Metrics: Effort to understand' value='15348.57']",
            "##teamcity[buildStatisticValue key='PHP Metrics: Number of estimated bugs' value='0.22']",
            "##teamcity[buildStatisticValue key='PHP Metrics: Time to understand' value='852.64']",
            "##teamcity[buildStatisticValue key='PHP Metrics: Intelligent content' value='43.46']",
            "##teamcity[buildStatisticValue key='PHP Metrics: Comment weight' value='43.64']",
            "##teamcity[buildStatisticValue key='PHP Metrics: Length' value='109.52']",
            "##teamcity[buildStatisticValue key='PHP Metrics: Lack of cohesion' value='1.04']",
            "##teamcity[buildStatisticValue key='PHP Metrics: Class resilience to change' value='0.34']",
            "##teamcity[buildStatisticValue key='PHP Metrics: Efferent coupling' value='1.48']",
            "##teamcity[buildStatisticValue key='PHP Metrics: Afferent coupling' value='0.24']",
            "##teamcity[buildStatisticValue key='PHP Metrics: Total System complexity' value='6.08']",
            "##teamcity[buildStatisticValue key='PHP Metrics: Relative System complexity' value='1.09']",
            "##teamcity[buildStatisticValue key='PHP Metrics: Data Complexity' value='2']",
            "##teamcity[buildStatisticValue key='PHP Metrics: Relative data complexity' value='0.41']",
            "##teamcity[buildStatisticValue key='PHP Metrics: System complexity' value='4.08']",
            "##teamcity[buildStatisticValue key='PHP Metrics: Relative structural complexity' value='0.68']",
            "##teamcity[buildStatisticValue key='PHP Metrics: Number of classes' value='16']",
            "##teamcity[buildStatisticValue key='PHP Metrics: Number of abstract classes' value='3']",
            "##teamcity[buildStatisticValue key='PHP Metrics: Number of concrete classes' value='13']",
            "##teamcity[buildStatisticValue key='PHP Metrics: Number Of Interfaces' value='0']",
            "##teamcity[buildStatisticValue key='PHP Metrics: Number Of Methods' value='55']",
            "",
        ]);

        isSame($expected, $actual);
    }
}
