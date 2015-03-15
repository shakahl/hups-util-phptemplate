<?php

use Hups\Util\PHPTemplate;

class ViewTest extends PHPUnit_Framework_TestCase
{
	/*
	public function tearDown()
	{
	}
	*/

	public function testDataCanBeSet()
	{
		$tpl = new PHPTemplate();
		
		$tpl->set('test_var_1', 1);
		$this->assertEquals(1, $tpl->get('test_var_1'));

		$tpl->test_var_2 = 2;
		$this->assertEquals(2, $tpl->test_var_2);

		$tpl->assign('test_var_3', 3);
		$this->assertEquals(3, $tpl->test_var_3);
	}

	public function testInvalidTemplateDirectorySet()
	{
		$this->setExpectedException('Exception');

		$tpl = new PHPTemplate(__DIR__ . '/nonexistent_directory');
	}
}

