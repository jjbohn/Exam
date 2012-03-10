<?php

namespace Jbohn\Bundle\ExamBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
	private $client;

	protected function setUp()
	{
		$this->client = static::createClient();
	}

	protected function tearDown()
	{
		unset($this->client);
	}

    public function testIndex()
    {
        $crawler = $this->client->request('GET', '/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
