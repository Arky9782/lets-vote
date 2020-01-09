<?php


use App\Controller\ElectionController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ElectionControllerTest extends WebTestCase
{
    private $hash;

    public function testCreateElection()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            'api/election',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
            "title":"Election",
            "choices": [
                       {"title":"first"},
                       {"title":"second"},
                       {"title":"third"}
                       ]
            }'
            );

        $responseData = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(201, $client->getResponse()->getStatusCode());

        $this->assertIsString($responseData['hash']);
    }
}
