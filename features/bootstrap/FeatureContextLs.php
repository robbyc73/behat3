<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
require_once __DIR__.'/../../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';
//require_once '/var/www/html/behat-ls/vendor/autoload.php';

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */

    private $output;

    public function __construct()
    {
        $this->output = "";
    }

    /**
     * @BeforeScenario
     */
    public function moveIntoTestDir() {
        if(!is_dir("test"))
            mkdir("test");

        chdir("test");
    }

    /**
     * @AfterScenario
     */
    public function moveOutOftestDir() {
        chdir("..");
        if(is_dir("test"))
            shell_exec("rm -r test/*");
    }

    /**
     * @AfterStep
     */
    public function afterStepHook() {
        var_dump('After step!');
    }

    /**
     * @Given I have a file named :filename
     */
    public function iHaveAFileNamed($filename)
    {
        touch($filename);
    }

    /**
     * @When I run :command
     */
    public function iRun($command)
    {
        $this->output = shell_exec($command);
    }

    /**
     * @Then I should see :string in the output
     */
    public function iShouldSeeInTheOutput($string)
    {
        /*if(strpos($this->output,$string) === false)
            throw new \Exception(sprintf('Did not see "%s" in output "%s"', $string, $this->output));*/

        assertContains(
            $string,
            $this->output,
            sprintf('Did not see "%s" in the output "%s"', $string, $this->output)
        );

    }

    /**
     * @Given there is a dir named :dir
     */
    public function thereIsADirNamed($dir)
    {
        if(!is_dir($dir))mkdir($dir);
    }

}
