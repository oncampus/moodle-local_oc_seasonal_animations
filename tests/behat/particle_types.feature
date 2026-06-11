@local @local_oc_seasonal_animations @oncampus @javascript
Feature: There should be different particle types

  Background:
    Given I log in as "admin"
    And the following config values are set as admin:
      | config                | value | plugin                       |
      | season_change_enabled | 0     | local_oc_seasonal_animations |
      | seasonless_enabled    | 1     | local_oc_seasonal_animations |

  Scenario: The image particle type can be configured with size and opacity
      and shows up on the start page after configuration
    Given the following config values are set as admin:
      | config                            | value          | plugin                       |
      | seasonless_particle_type          | image-particle | local_oc_seasonal_animations |
      | seasonless_particle_image_size    | 30;0           | local_oc_seasonal_animations |
      | seasonless_particle_image_opacity | 0.3;0          | local_oc_seasonal_animations |
    And I am on homepage
    Then "image-particle" "css_element" should exist
    And the "style" attribute of "image-particle" "css_element" should contain "width: 30px"
    And the "style" attribute of "image-particle" "css_element" should contain "height: 30px"
    And the "style" attribute of "image-particle" "css_element" should contain "opacity: 0.3"

  Scenario: The snow particle type can be configured with size, opacity and color
      and shows up on the start page after configuration
    Given the following config values are set as admin:
      | config                           | value         | plugin                       |
      | seasonless_particle_type         | snow-particle | local_oc_seasonal_animations |
      | seasonless_particle_snow_size    | 30;0          | local_oc_seasonal_animations |
      | seasonless_particle_snow_opacity | 0.3;0         | local_oc_seasonal_animations |
      | seasonless_particle_snow_color   | #039CC3       | local_oc_seasonal_animations |
    And I am on homepage
    Then "snow-particle" "css_element" should exist
    And the "style" attribute of "snow-particle" "css_element" should contain "width: 30px"
    And the "style" attribute of "snow-particle" "css_element" should contain "height: 30px"
    And the "style" attribute of "snow-particle" "css_element" should contain "opacity: 0.3"
    And the "style" attribute of "snow-particle" "css_element" should contain "background-color: rgb(3, 156, 195)"
