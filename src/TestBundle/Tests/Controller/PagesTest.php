<?php

namespace TestBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PagesTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        /** Assert the response is 200 */
        $this->assertEquals($client->getResponse()->getStatusCode(), 200);

        /** Has one navbar top */
        $this->assertEquals($crawler->filter('.navbar-fixed-top')->count(), 1);
        $this->assertEquals($crawler->filter('.navbar-right li')->count(), 3);
        /** H2 assert */
        $this->assertEquals($crawler->filter('.main-banner h2')->text(), 'King James Bible');

        /** Search box assert */
        $this->assertEquals($crawler->filter('.search-box')->count(), 1);

        /** Bot icons */
        $this->assertEquals($crawler->filter('.fa.fa-twitter')->count(), 1);
        $this->assertEquals($crawler->filter('.fa.fa-facebook')->count(), 1);

        //$this->assertContains('King James Bible', $client->getResponse()->getContent());
    }

    public function searchAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
    }
}
