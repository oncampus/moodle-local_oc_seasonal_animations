@local @local_oc_seasonal_animations @oncampus @javascript
Feature: Test if preview can be opened

  Background:
    Given I log in as "admin"
    And the following config values are set as admin:
      | config                           | value     | plugin                       |
      | autumn_particle_image_image_file |           | local_oc_seasonal_animations |
    And I navigate to "Plugins > Local plugins > Seasonal Effects" in site administration
    And I click on "#admin-winter_enabled a" "css_element"
    And I click on "[data-testid='seasonal-animation-open-preview']" "css_element"

  Scenario: Test if there are snow-particles exist
    Then "snow-particle" "css_element" should exist
