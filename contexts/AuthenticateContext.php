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
class AuthenticateContext extends RawMinkContext implements Context, SnippetAcceptingContext
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
     * @BeforeScenario
     */
    public function clearData() {

        $purger = new ORMPurger($this->getContainer()->get('doctrine')->getManager());
        $purger->purge();
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

        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($user);
        $em->flush();
    }

    private function encodePassword(\Acme\DemoBundle\Entity\YodaUser $user, $plainPassword)
    {
        $encoder = $this->getContainer()->get('security.encoder_factory')
            ->getEncoder($user);
        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }
}
