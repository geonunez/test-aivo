<?php

namespace Tests\Functional;

/**
 * Tests for the web functionalities
 */
class WebTest extends BaseTestCase
{

    /**
     * Tests that the index route returns a json with a description
     */
    public function testIndex()
    {
        $response = $this->runApp('GET', '/');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('description', (string)$response->getBody());
    }
}
