@local @local_oc_seasonal_animations @oncampus @javascript
Feature: The seasonal effects can be toggled by a button

  Background:
    Given I log in as "user"
    And the following config values are set as admin:
      | config                | value | plugin                       |
      | season_change_enabled | 0     | local_oc_seasonal_animations |
      | seasonless_enabled    | 1     | local_oc_seasonal_animations |

  Scenario: The effect is active by default on frontpage and homepage
    Given I am on front page
    Then "image-particle" "css_element" should exist
    And I am on homepage
    And "image-particle" "css_element" should exist

  Scenario: The effect can be disabled and enabled with a button
    Given I am on front page
    When I press "Animations off"
    Then "image-particle" "css_element" should not exist
    And I press "Animations on"
    And "image-particle" "css_element" should exist

  Scenario: The effect stays disabled even if the page gets reloaded
    Given I am on front page
    When I press "Animations off"
    And I am on front page
    Then "image-particle" "css_element" should not exist
