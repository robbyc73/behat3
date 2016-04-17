Feature: Events Admin
  In order to manage my events shown on the site
  As a admin user
  I need to be able to add, edit, and delete events

  Background:
    Given there is an admin user "robbie3" with password "pwd3"
    And I am on "http://localhost/starwarsevents/web/app_dev.php/"
    When I follow "loginLink"
    And I fill in "username" with "robbie3"
    And I fill in "password" with "pwd3"
    And I press "loginButton"

  @javascript
  Scenario: Create Event
    #Then I should see "http://localhost/starwarsevents/web/app_dev.php/"
    And I follow "newLink"
    Then I should see "New Event"
    And I fill in "event_name" with "some random event 5"
    And I fill in "event_time_date_month" with "1"
    And I fill in "event_time_date_day" with "3"
    And I fill in "event_time_date_year" with "2018"
    And I fill in "event_time_time_hour" with "10"
    And I fill in "event_time_time_minute" with "30"
    And I fill in "event_location" with "Coruscant"
    And I fill in "event_details" with "Trash the emperors palace 5"
    And I press "create"
    Then I should see "Event"


  #Scenario Outline: Create Event
   # Then I should see "/"
    #And I follow "newLink"
    #Then I should see "New Event"
    #And I fill in event name with "<name>"
    #And I fill in event month with "<month>"
    #And I fill in event day with "<day>"
    #And I fill in event year with "<year>"
    #And I fill in event hour with "<hour>"
    #And I fill in event minute with "<minute>"
    #And I fill in event location with "<location>"
    #And I fill in event details with "<details>"
    #And I press Create
    #Then I should see Event

  #Examples:
  #| name               | month | day | year | hour | minute | location   | details            |
  #| Brachiosaurus     | 3     | 23  | 2020 | 17   | 12     | Isla nubar | Eatthe park     |
  #| Mammoth | 8     | 14  | 2017 | 19   | 17     | Mainland   | Gore the mainland |