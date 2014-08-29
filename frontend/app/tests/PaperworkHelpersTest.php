<?php

class PaperworkHelpersTest extends TestCase {

	public function testApiResponseSuccess()
	{
		$json = PaperworkHelpers::apiResponse(200, array('test' => 'test'));
		$this->assertEquals(Response::json(array('success' => true, 'response' => array('test' => 'test')), 200), $json);
	}

}
