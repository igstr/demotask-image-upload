<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Image;
use AppBundle\Form\ImageType;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ImageControllerTest extends WebTestCase
{
    public function testCreateActionEmptyForm()
    {
        $client = static::createClient();

        // Get form object for submission
        $crawler = $client->request('GET', '/');
        $form = $crawler->filter('form.form-image')->form();

        // Submit form
        $crawler = $client->submit($form);
        $res = $client->getResponse();

        // Assert that request was invalid
        $this->assertEquals(400, $res->getStatusCode());

        // Assert that response type is JSON
        $this->assertTrue($res->headers->has('Content-Type'));
        $this->assertEquals('application/json', $res->headers->get('Content-Type'));

        // Check if content JSON is valid
        $content = $res->getContent();
        $jsonContent = json_decode($content);
        $this->assertFalse(is_null($jsonContent));

        // Assert success value to be false
        $this->assertTrue(isset($jsonContent->success));
        $this->assertFalse($jsonContent->success);
    }
}
