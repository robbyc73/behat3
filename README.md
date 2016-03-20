// testing with Behat 3
//install symfony project
composer create-project symfony/framework-standard-edition /var/www/html/behat 2.4.10 

//dependencies
composer require --dev behat/mink-extension behat/mink-goutte-driver
composer require --dev behat/mink-selenium2-driver behat/symfony2-extension 
composer require --dev phpunit/phpunit

// initialize behat(Symfony2)
bin/behat --init

// modify FeatureContext class to extend MinkContext

//add Php Unit to FeatureContext class
require_once __DIR__.'/../../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

//add missing steps to feature context if required or use builtin,  see output /bin/behat -dl
bin/behat --append-snippets


//create behat.yml in project root
default:
    extensions:
        Behat\MinkExtension:
            base_url: https://en.wikipedia.org
            goutte: ~
            selenium2: ~

//create feature file in features directory(example uses built in features(hacky!) )
Feature: Search
  In order to find a word definition
  As a website user
  I am able to search for a word

  Background:
    Given I am on "/wiki/Main_Page"

  @javascript
  Scenario Outline: Search for a word that exists
    When I fill in "searchInput" with "<search>"
    And I press "searchButton"
    Then I should see "<expectation>"

  Examples:
    | search             | expectation                      |
    | Velociraptor       | an enlarged sickle-shaped claw   |
    | Tyrannosaurus Bill | Search results                   |



//run selenium server
java -jar  ~/Downloads/selenium-server-standalone-2.52.0.jar

//run test
bin/behat features/search.feature


//run ls cmd, create feature file with following, then run bin/behat --append-snippets
Feature:
  In order to see the directory structure
  As a UNIX user
  I need to be able to list the current directories contents

  #will apply to both Scenarios
  Background:
    Given I have a file named "john"

  Scenario: List 2 files in a directory
    And I have a file named "hammond"
    When I run "ls"
    Then I should see "john" in the output
    And I should see "hammond" in the output

  Scenario: List 1 file and 1 directory
    And a directory named "ingen"
    When I run "ls"
    Then I should see "john" in the output
    And I should see "ingen" in the output

//then add commands to snippets
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
        if(strpos($this->output,$string) === false)
            throw new \Exception(sprintf('Did not see "%s" in output "%s"', $string, $this->output));

    }


//before and after scenario in feature context runs on start and completion respectively, part of hook system
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
            shell_exec("rm test/*");
    }


//use assertContains in iShouldSeeInTheOutput() to throw an exception
       assertContains(
            $string,
            $this->output,
            sprintf('Did not see "%s" in the output "%s"', $string, $this->output)
        );

//always use background statement to avoid duplication of steps


//run a function after the completion of each step
    /**
     * @AfterStep
     */
    public function afterStepHook() {
        var_dump('After step!');
    }


// see mink.php for example of page searching, clicking links etc

// add following to behat.yml, gives a bunch of other built in options for navigating web pages, viewable by bin/behat -dl,expand on this later!
    suites:
        default:
            contexts:
                - FeatureContext
                - Behat\MinkExtension\Context\MinkContext











