Feature: Search
  In order to find a word definition
  As a website user
  I am able to search for a word

  Background:
    Given I am on "https://en.wikipedia.org/wiki/Main_Page"

 # @javascript
  Scenario Outline: Search for a word that exists
    When I fill in the search box with "<search>"
    And I press the search button
    Then I should see "<expectation>"

  Examples:
    | search             | expectation                      |
    | Velociraptor       | an enlarged sickle-shaped claw   |
    | Tyrannosaurus Bill | Search results                   |

