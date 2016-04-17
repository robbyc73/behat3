Feature: Events Login
  In order to gain access to the management area
  As an admin user
  I need to be able to login and logout

  Background:
    Given there is an admin user "robbie3" with password "pwd3"
    And I am on "http://localhost/starwarsevents/web/app_dev.php/"

  @javascript
  Scenario: Login
    When I follow "loginLink"
    And I fill in "username" with "robbie3"
    And I fill in "password" with "pwd3"
    And I press "loginButton"
    #Then I should see "logoutLink"
    Then I should see "New Event"
    #Then show last response