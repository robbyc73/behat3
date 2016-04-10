<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Behat\MinkExtension\Context\RawMinkContext;
use Symfony\Component\Serializer;

require_once __DIR__.'/../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';
//require_once '/var/www/html/behat-ls/vendor/autoload.php';

/**
 * Defines application features from the specific context.
 */
class SearchWikiContext extends RawMinkContext implements Context, SnippetAcceptingContext
{
    private static $container;

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
     * @BeforeSuite
     */
    public static function bootstrapSymfony()
    {
        require_once __DIR__.'/../app/autoload.php';
        require_once __DIR__.'/../app/AppKernel.php';
        $kernel = new AppKernel('test', true);
        $kernel->boot();
        self::$container = $kernel->getContainer();
    }

    /**
     * @return \Behat\Mink\Element\DocumentElement
     */
    private function getPage()
    {
     return $this->getSession()->assertSession();
    }


    /**
     * @Given there is an admin user :username with password :password
     */
    public function thereIsAnAdminUserWithPassword($username, $password)
    {

        $user = new \Acme\DemoBundle\Entity\YodaUser();
        $user->setUsername($username);
        $user->setPassword($this->encodePassword($user,$password));
        $user->setEmail('robcampbell73@gmail.com');
        $user->setIsActive(true);
        $user->setRoles(array("ROLE_ADMIN"));

        $em = self::$container->get('doctrine')->getManager();
        $em->persist($user);
        $em->flush();
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

    private function encodePassword(\Acme\DemoBundle\Entity\YodaUser $user, $plainPassword)
    {
        $encoder = self::$container->get('security.encoder_factory')
            ->getEncoder($user);
        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }
}
