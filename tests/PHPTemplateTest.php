<?php

use Hups\Util\PHPTemplate;

class PHPTemplateTest extends PHPUnit_Framework_TestCase
{
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

	public function testTemplateRenderedCorrectly()
	{
		$tpl = new PHPTemplate(__DIR__);

		$tpl->set('test_var_1', 'correct');
		$renderedString = trim($tpl->fetch('test1.tpl.phtml'));

		$this->assertEquals('var:correct', $renderedString);
	}

	public function testTemplateDisplayedCorrectly()
	{
		$tpl = new PHPTemplate(__DIR__);

		$tpl->set('test_var_1', 'correct');

		ob_start();
		$tpl->display('test1.tpl.phtml');
		$renderedString = ob_get_contents();
		ob_end_clean();

		$renderedString = trim($renderedString);

		$this->assertEquals('var:correct', $renderedString);
	}
}

