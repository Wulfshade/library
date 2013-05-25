<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to sales@vehiclefits.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class VF_Schema_CLITest extends VF_TestCase
{
    function setUp()
    {
        VF_Singleton::getInstance()->setReadAdapter(new VF_TestDbAdapter(array(
            'dbname' => VAF_DB_NAME,
            'username' => VAF_DB_USERNAME,
            'password' => VAF_DB_PASSWORD
        )));
        $schemaGenerator = new VF_Schema_Generator();
        $schemaGenerator->dropExistingTables();
        VF_Schema::$levels = null;
    }

    function tearDown()
    {

    }

    /**
     * @expectedException Zend_Db_Statement_Exception
     */
    function testShouldStartWithEmptyDatabase()
    {
        $schema = new VF_Schema;
        $schema->getLevels();
    }

    function testShouldCreateSchemaOverCommandLine()
    {
        $command = __DIR__.'/vf schema --config=cli/config.default.php --force --levels="year,make,model"';
        exec($command);
        $schema = new VF_Schema;
        $this->assertEquals(array('year','make','model'), $schema->getLevels(), 'should create default schema of MMY');
    }

    function testShouldCreateLevelTable()
    {
        $command = __DIR__.'/vf schema --config=cli/config.default.php --force --levels="year,make,model"';
        exec($command);
        $expectedTable = 'elite_level_1_make';
        $tables = $this->getReadAdapter()->listTables();
        $this->assertTrue(in_array($expectedTable, $tables), "master schema should create make with '1' in it's name");
    }

    function testShouldAddSecondSchema()
    {
        $command = __DIR__.'/vf schema --config=cli/config.default.php --force --levels="year,make,model"';
        exec($command);
        $command = __DIR__.'/vf schema --config=cli/config.default.php --add --levels="foo,bar"';
        exec($command);
        $schema = new VF_Schema(2);
        $this->assertEquals(array('foo','bar'), $schema->getLevels(), 'should create second schema');
    }
}