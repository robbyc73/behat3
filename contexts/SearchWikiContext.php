<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Behat\MinkExtension\Context\RawMinkContext;
use Symfony\Component\Serializer;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;



require_once __DIR__.'/../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';
//require_once '/var/www/html/behat-ls/vendor/autoload.php';

/**
 * Defines application features from the specific context.
 */
class SearchWikiContext extends RawMinkContext implements Context, SnippetAcceptingContext
{

    use \Behat\Symfony2Extension\Context\KernelDictionary;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {

    }

    /**
     * @return \Behat\Mink\Element\DocumentElement
     */
    private function getPage()
    {
     return $this->getSession()->assertSession();
    }


    /**
     * @When I fill in the search box with :term
     */
    public function iFillInTheSearchBoxWith($term)
    {
        $searchBox = $this->assertSession()
            ->elementExists('css', 'input[name="search"]');

        $searchBox->setValue($term);
    }

    /**
     * @When I press the search button
     */
    public function iPressTheSearchButton()
    {
        $button = $this->assertSession()
            ->elementExists('css', '#searchButton');
        $button->press();
    }

}
