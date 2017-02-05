<?php

class PaperworkHelpersTest extends TestCase {

	public function testApiResponseSuccess()
	{
		$json = PaperworkHelpers::apiResponse(200, array('test' => 'test'));
		$this->assertEquals(Response::json(array('success' => true, 'response' => array('test' => 'test')), 200), $json);
	}

	public function testApiResponseErrors()
	{
		$json = PaperworkHelpers::apiResponse(400, array('test' => 'test'));
		$this->assertEquals(Response::json(array('success' => false, 'errors' => array('test' => 'test')), 400), $json);
	}

	public function testHasUiLanguage()
	{
		$this->assertEquals(true, PaperworkHelpers::hasUiLanguage("en"));
	}

}
