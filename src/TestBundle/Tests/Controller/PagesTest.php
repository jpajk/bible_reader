<?php

namespace TestBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * phpunit --exclude-group ignore
 */
class PagesTest extends WebTestCase
{
    private $container; 

    public function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
                                   ->get('doctrine')
                                   ->getManager();
    }

    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        /** Assert the response is 200 */
        $this->assertEquals($client->getResponse()->getStatusCode(), 200);

        /** Has one navbar top */
        $this->assertEquals($crawler->filter('.navbar-fixed-top')->count(), 1, "There should be one navbar");
        $this->assertEquals($crawler->filter('.navbar-right li')->count(), 3, "There should be three items in the navbar");
        /** H2 assert */
        $this->assertEquals($crawler->filter('.main-banner h2')->text(), 'King James Bible', "The title should be 'King James Bible'");

        /** Search box assert */
        $this->assertEquals($crawler->filter('.search-box')->count(), 1, "There should be one search box");

        /** Bot icons */
        $this->assertEquals($crawler->filter('.fa.fa-twitter')->count(), 1, "There should be a twitter icon");
        $this->assertEquals($crawler->filter('.fa.fa-facebook')->count(), 1, "There should be a facebook icon");

        //$this->assertContains('King James Bible', $client->getResponse()->getContent());
    }

    public function testBrowse()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/browse/');

        $this->assertTrue($client->getResponse()->isSuccessful(), 'The response was not successful');
        
        $this->assertEquals($crawler->filter('.book-item')->count(), 66, "There should be 66 books");

        $books = $crawler->filter('.book-item');

        /** Find all books and test their names */
        $db_books = $this->em->getRepository('EntityBundle:Book')->findBy(array());

        foreach ($books as $index => $book) 
        {
            $this->assertEquals(trim($book->textContent), $db_books[$index]->getName(), "Books name fetched from database does not equal the frontend; Book name: " . trim($book->textContent));
        }
    }

    public function testChapter()
    {
        /** Fetch all book shortnames from the database */

        $db_books = $this->em->getRepository('EntityBundle:Book')->findAll();

        foreach ($db_books as $book) 
        {            
            $this->testBookContents($book);
        }        
        
    }

    /**     
     * @group ignore
     */
    public function testBookContents($db_book)
    {
        $client = static::createClient();        

        $crawler = $client->request('GET', '/browse/' . $db_book->getShortname());

        $this->assertEquals($crawler->filter('.book-name-wrap')->count(), 1, "There should be one book title");
        $this->assertEquals($crawler->filter('.book-name-wrap h1')->text(), $db_book->getName(), "The title should be the same as in the database");
        
        $verses_contents = $crawler->filter('.chapter-verse .verse-content');

        $book = $this->em->getRepository('EntityBundle:Book')->getBookVerses($db_book->getShortname());
        $chapters = $book->getChapters();

        $verses_array = [];

        foreach ($chapters as $key => $chapter) 
        {
            foreach ($chapter->getVerses() as $index => $verse) 
            {
                $verses_array[] = $verse->getContent();
            }
        }

        foreach ($verses_contents as $key => $value) 
        {            
            $this->assertEquals($value->textContent, $verses_array[$key], "The title should be the same as in the database");
        }
    }
}
