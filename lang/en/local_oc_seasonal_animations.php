<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin language strings are defined here.
 *
 * @package     local_oc_seasonal_animations
 * @copyright   2026 oncampus GmbH
 * @author      Konrad Ebel <konrad.ebel@oncampus.de>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @category    string
 */

defined('MOODLE_INTERNAL') || die();

$string['disable_snowfall'] = 'Animations off';
$string['enable_snowfall'] = 'Animations on';
$string['max'] = 'max.';
$string['min'] = 'min.';
$string['pluginname'] = 'Seasonal Effects';
$string['preview:heading'] = 'Seasonal Effect Preview: {$a}';
$string['preview:title'] = 'Preview {$a} effect';
$string['privacy:metadata'] = 'Doesnt save personal data about users.';
$string['settings:anchor_start'] = 'Anchor start settings';
$string['settings:autumn'] = 'Autumn';
$string['settings:behavior:fade:speed'] = 'Fade speed';
$string['settings:behavior:fade:speed_desc'] = 'Fade speed as a percentage of visibility per tick.';
$string['settings:behavior:move:border'] = 'Border threshold';
$string['settings:behavior:move:border_desc'] = 'Distance from border at which particles reset (px/Tick).';
$string['settings:behavior:move:horizontal_random_change'] = 'Horizontal speed variation';
$string['settings:behavior:move:horizontal_random_change_desc'] = 'Randomly changes horizontal speed on each tick.';
$string['settings:behavior:move:horizontal_random_span'] = 'Maximum horizontal speed variation';
$string['settings:behavior:move:horizontal_random_span_desc'] = 'Maximum horizontal speed that can be randomly applied.';
$string['settings:behavior:move:horizontal_speed'] = 'Horizontal speed';
$string['settings:behavior:move:horizontal_speed_desc'] = 'Range for particle horizontal speed (px/Tick).';
$string['settings:behavior:move:rotation_speed'] = 'Rotation speed';
$string['settings:behavior:move:rotation_speed_desc'] = 'Range for particle rotation speed (px/Tick).';
$string['settings:behavior:move:vertical_random_change'] = 'Vertical speed variation';
$string['settings:behavior:move:vertical_random_change_desc'] = 'Randomly changes vertical speed on each tick.';
$string['settings:behavior:move:vertical_random_span'] = 'Maximum vertical speed variation';
$string['settings:behavior:move:vertical_random_span_desc'] = 'Maximum vertical speed that can be randomly applied.';
$string['settings:behavior:move:vertical_speed'] = 'Vertical speed';
$string['settings:behavior:move:vertical_speed_desc'] = 'Range for particle vertical speed (px/Tick).';
$string['settings:enable'] = 'Enable seasonal effects.';
$string['settings:fade_behavior'] = 'Fade behavior settings';
$string['settings:general'] = 'General';
$string['settings:general:behavior'] = 'Particle behavior';
$string['settings:general:behavior:fade'] = 'Fade';
$string['settings:general:behavior:move'] = 'Move';
$string['settings:general:behavior_desc'] = 'Select the behavior for particles.';
$string['settings:general:enabled'] = 'Enable effects';
$string['settings:general:enabled_desc'] = 'Enable or disable the seasonal effect.';
$string['settings:general:layer'] = 'Z-index layer';
$string['settings:general:layer_desc'] = 'Z-index CSS layer for the seasonal effect. Use -1 to place behind content. '
    . 'Warning. Using higher numbers can decrease the accessibility.';
$string['settings:general:particle_count'] = 'Particle count';
$string['settings:general:particle_count_desc'] = 'Number of particles to display on screen.';
$string['settings:general:particle_type'] = 'Particle type';
$string['settings:general:particle_type:image'] = 'Custom';
$string['settings:general:particle_type:snow'] = 'Circle';
$string['settings:general:particle_type_desc'] = 'Choose the visual type of particle.';
$string['settings:general:start_position'] = 'Spawn position type';
$string['settings:general:start_position:anchor'] = 'Anchor';
$string['settings:general:start_position:random'] = 'Random';
$string['settings:general:start_position_desc'] = 'Choose how particles should be positioned when created.';
$string['settings:general:start_random'] = 'Spawn random';
$string['settings:general:start_random_desc'] = 'Start particles already spread out. Overwrites the start position on first start.';
$string['settings:image_particle'] = 'Custom particle settings';
$string['settings:move_behavior'] = 'Move behavior settings';
$string['settings:overview:preview'] = 'Preview';
$string['settings:overview:season_change_enabled'] = 'Enable season changes';
$string['settings:overview:season_change_enabled_desc'] = 'Automatically switch effects based on the season. '
    . 'The settings for spring, summer, autumn, and winter will be used.';
$string['settings:particle:image:image'] = 'Particle image';
$string['settings:particle:image:image_desc'] = 'Upload an image to use as the particle.';
$string['settings:particle:opacity'] = 'Opacity';
$string['settings:particle:opacity_desc'] = 'Set the opacity range for particles.';
$string['settings:particle:size'] = 'Size';
$string['settings:particle:size_desc'] = 'Set the size range for particles.';
$string['settings:particle:snow:color'] = 'Circle color';
$string['settings:particle:snow:color_desc'] = 'Choose the color of the circles.';
$string['settings:random_start'] = 'Random start settings';
$string['settings:seasonless'] = 'Entire year';
$string['settings:snow_particle'] = 'Circle particle settings';
$string['settings:spring'] = 'Spring';
$string['settings:startpos:anchor:bordersite'] = 'Sides to emit from';
$string['settings:startpos:anchor:bordersite:b'] = 'Bottom';
$string['settings:startpos:anchor:bordersite:l'] = 'Left';
$string['settings:startpos:anchor:bordersite:r'] = 'Right';
$string['settings:startpos:anchor:bordersite:t'] = 'Top';
$string['settings:startpos:anchor:bordersite_desc'] = 'Select which borders particles should spawn from.';
$string['settings:startpos:anchor:distance'] = 'Anchor distance';
$string['settings:startpos:anchor:distance_desc'] = 'Offset in pixels from the anchor side.';
$string['settings:summer'] = 'Summer';
$string['settings:winter'] = 'Winter';
$string['toggle_snowfall'] = 'Toggle seasonal effects';
$string['validate:max'] = 'Please choose a value lower than {$a}';
$string['validate:min'] = 'Please choose a value higher than {$a}';
