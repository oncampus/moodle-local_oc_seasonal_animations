@local @local_oc_seasonal_animations @oncampus @javascript
Feature: There should be different start position types, which can
  be configured

  Background:
    Given I log in as "admin"
    And the following config values are set as admin:
      | config                        | value  | plugin                       |
      | season_change_enabled         | 0      | local_oc_seasonal_animations |
      | seasonless_enabled            | 1      | local_oc_seasonal_animations |
      | seasonless_behavior           | fade   | local_oc_seasonal_animations |
      | seasonless_start_position     | anchor | local_oc_seasonal_animations |
      | seasonless_start_random       | 0      | local_oc_seasonal_animations |

  Scenario: The anchor start type can let the particles start at the right screen side
    Given the following config values are set as admin:
      | config                                | value  | plugin                       |
      | seasonless_startpos_anchor_bordersite | t      | local_oc_seasonal_animations |
      | seasonless_startpos_anchor_distance   | -100;0 | local_oc_seasonal_animations |
    And I am on homepage
    Then "image-particle" "css_element" should exist
    And the "style" attribute of "image-particle" "css_element" should contain "top: -100px"

  Scenario:  The anchor start type can let the particles start at the left screen side
    Given the following config values are set as admin:
      | config                                | value  | plugin                       |
      | seasonless_startpos_anchor_bordersite | l      | local_oc_seasonal_animations |
      | seasonless_startpos_anchor_distance   | 100;0  | local_oc_seasonal_animations |
    And I am on homepage
    Then "image-particle" "css_element" should exist
    And the "style" attribute of "image-particle" "css_element" should contain "left: 100px"
