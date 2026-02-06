@local @local_eledia_snow_effect @oncampus @javascript
Feature: There should be different start position types, which can
  be configured

  Background:
    Given I log in as "user"
    And the following config values are set as admin:
      | config                        | value  | plugin                   |
      | season_change_enabled         | 0      | local_eledia_snow_effect |
      | seasonless_enabled            | 1      | local_eledia_snow_effect |
      | seasonless_behavior           | fade   | local_eledia_snow_effect |
      | seasonless_start_position     | anchor | local_eledia_snow_effect |
      | seasonless_start_random       | 0      | local_eledia_snow_effect |

  Scenario: The anchor start type can let the particles start at the right screen side
    Given the following config values are set as admin:
      | config                                | value  | plugin                   |
      | seasonless_startpos_anchor_bordersite | t      | local_eledia_snow_effect |
      | seasonless_startpos_anchor_distance   | -100;0 | local_eledia_snow_effect |
    When I am on front page
    Then "image-particle" "css_element" should exist
    And the "style" attribute of "image-particle" "css_element" should contain "top: -100px"

  Scenario:  The anchor start type can let the particles start at the left screen side
    Given the following config values are set as admin:
      | config                                | value  | plugin                   |
      | seasonless_startpos_anchor_bordersite | l      | local_eledia_snow_effect |
      | seasonless_startpos_anchor_distance   | 100;0  | local_eledia_snow_effect |
    When I am on front page
    Then "image-particle" "css_element" should exist
    And the "style" attribute of "image-particle" "css_element" should contain "left: 100px"
