<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('This is test!', $crawler->filter('.container h1')->text());
    }

    public function testHello()
    {
        $client = static::createClient();
        $client->request('GET', '/hello');

        // check response is JSON;
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        $content = json_decode($client->getResponse()->getContent(), true);

        // check if content in response is good ['hello'=>'world']
        $this->assertIsArray($content);
        $this->assertArrayHasKey('hello', $content);
        $this->assertEquals(['hello' => 'world'], $content);
    }
}