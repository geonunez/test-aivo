<?php

namespace Tests\Functional;

/**
 * Tests for the profile functionalities
 */
class ProfileTest extends BaseTestCase
{
    /**
     * Tests a correct call to the API to get the Facebook user
     */
    public function testCorrectFacebookUser()
    {
        $response = $this->runApp('GET', '/profile/facebook/1000');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('name', (string)$response->getBody());
        $this->assertContains('Nisha Nagarkatti-Gude', (string)$response->getBody());
        $this->assertContains('id', (string)$response->getBody());
        $this->assertContains('1000', (string)$response->getBody());
    }

    /**
     * Tests an incorrect call to the API to get the Facebook user.
     *
     * Note: This test needs write permission over the logs folders
     */
    public function testIncorrectFacebookUser()
    {
        $response = $this->runApp('GET', '/profile/facebook/123456');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertContains('description', (string)$response->getBody());
    }
}
