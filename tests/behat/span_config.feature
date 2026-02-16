@local @local_oc_seasonal_animations @oncampus
Feature: A config should exist which can define a range

  Background:
    Given I log in as "admin"
    And I navigate to "Plugins > Local plugins > Seasonal Effects" in site administration
    And I click on "#admin-seasonless_enabled a" "css_element"
    And I click on "#admin-seasonless_start_position a" "css_element"

  Scenario: Set the span config manual and test if it get converted
    When I set the field "s_local_oc_seasonal_animations_seasonless_startpos_anchor_distance[min]" to "-33"
    And I set the field "s_local_oc_seasonal_animations_seasonless_startpos_anchor_distance[max]" to "42"
    And I press "Save changes"
    Then the field "s_local_oc_seasonal_animations_seasonless_startpos_anchor_distance[min]" matches value "-33"
    And the field "s_local_oc_seasonal_animations_seasonless_startpos_anchor_distance[max]" matches value "42"
