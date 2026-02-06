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
 * Plugin administration pages are defined here.
 *
 * @package     local_oc_seasonal_animations
 * @copyright   2026, oncampus GmbH
 * @author      Konrad Ebel <konrad.ebel@oncampus.de>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use local_oc_seasonal_animations\settings\admin_setting_confignumber;
use local_oc_seasonal_animations\settings\admin_setting_random_span;

defined('MOODLE_INTERNAL') || die;

if (!$hassiteconfig) {
    return;
}

$set = [
    'local_oc_seasonal_animations' => [get_string('settings:seasonless', 'local_oc_seasonal_animations'), 'seasonless_', [

    ]],
    'local_oc_seasonal_animations_spring' => [get_string('settings:spring', 'local_oc_seasonal_animations'), 'spring_', [
        'behavior_move_horizontal_speed' => ['min' => 1, 'max' => 2],
        'startpos_anchor_bordersite' => ['t', 'l'],
        'behavior_move_rotation_speed' => ['min' => -3, 'max' => 6],
    ]],
    'local_oc_seasonal_animations_summer' => [get_string('settings:summer', 'local_oc_seasonal_animations'), 'summer_', [
        'start_position' => 'random',
        'particle_image_size' => ['min' => 20, 'max' => 60],
        'behavior' => 'fade',
        'behavior_fade_speed' => ['min' => 4, 'max' => 8],
    ]],
    'local_oc_seasonal_animations_autumn' => [get_string('settings:autumn', 'local_oc_seasonal_animations'), 'autumn_', [
        'behavior_move_horizontal_speed' => ['min' => 1, 'max' => 2],
        'startpos_anchor_bordersite' => ['t', 'l'],
        'behavior_move_rotation_speed' => ['min' => -3, 'max' => 3],
        'behavior_move_vertical_random_span' => ['min' => -1, 'max' => 0],
        'behavior_move_vertical_random_change' => 0.5,
    ]],
    'local_oc_seasonal_animations_winter' => [get_string('settings:winter', 'local_oc_seasonal_animations'), 'winter_', [
        'particle_type' => 'snow-particle',
        'behavior_move_horizontal_speed' => ['min' => 0.5, 'max' => 0.5],
        'layer' => 9999,
    ]],
];

$overview = new admin_settingpage(
    "local_oc_seasonal_animations_overview",
    get_string('pluginname', 'local_oc_seasonal_animations'),
);
if ($ADMIN->fulltree) {
    $overview->add(new admin_setting_configcheckbox(
        "local_oc_seasonal_animations/season_change_enabled",
        get_string('settings:overview:season_change_enabled', 'local_oc_seasonal_animations'),
        get_string('settings:overview:season_change_enabled_desc', 'local_oc_seasonal_animations'),
        1
    ));
}
$ADMIN->add('localplugins', $overview);


foreach ($set as $categoryname => $setinfos) {
    $visiblecatname = $setinfos[0];
    $settingpre = $setinfos[1];
    $defaults = $setinfos[2];

    $ADMIN->add(
        'localplugins',
        new admin_category($categoryname, $visiblecatname, true),
    );

    $settings = new admin_settingpage(
        "{$categoryname}_general",
        get_string('settings:general', 'local_oc_seasonal_animations')
    );
    $ADMIN->add($categoryname, $settings);

    $preview = new admin_externalpage(
        "{$categoryname}_preview",
        get_string('settings:overview:preview', 'local_oc_seasonal_animations'),
        new moodle_url('/local/oc_seasonal_animations/pages/preview.php', ['season' => $settingpre])
    );

    $particlesubsettings = [];
    $particlesubsettings['snow-particle'] = new admin_settingpage(
        "{$categoryname}_snow_particle",
        get_string('settings:snow_particle', 'local_oc_seasonal_animations')
    );
    $ADMIN->add($categoryname, $particlesubsettings['snow-particle']);
    $particlesubsettings['image-particle'] = new admin_settingpage(
        "{$categoryname}_image_particle",
        get_string('settings:image_particle', 'local_oc_seasonal_animations')
    );
    $ADMIN->add($categoryname, $particlesubsettings['image-particle']);

    $behaviorsubsettings = [];
    $behaviorsubsettings['move'] = new admin_settingpage(
        "{$categoryname}_move_behavior",
        get_string('settings:move_behavior', 'local_oc_seasonal_animations')
    );
    $ADMIN->add($categoryname, $behaviorsubsettings['move']);
    $behaviorsubsettings['fade'] = new admin_settingpage(
        "{$categoryname}_fade_behavior",
        get_string('settings:fade_behavior', 'local_oc_seasonal_animations')
    );
    $ADMIN->add($categoryname, $behaviorsubsettings['fade']);

    $startpossubsettings = [];
    $startpossubsettings['anchor'] = new admin_settingpage(
        "{$categoryname}_anchor_start",
        get_string('settings:anchor_start', 'local_oc_seasonal_animations')
    );
    $ADMIN->add($categoryname, $startpossubsettings['anchor']);
    $startpossubsettings['random'] = new admin_settingpage(
        "{$categoryname}_random_start",
        get_string('settings:random_start', 'local_oc_seasonal_animations')
    );
    $ADMIN->add($categoryname, $startpossubsettings['random']);

    if (!$ADMIN->fulltree) {
        continue;
    }

    $edit = $OUTPUT->action_icon(
        $settings->get_settings_page_url(),
        new pix_icon('t/edit', get_string('edit'), 'core'),
        null,
        ['title' => get_string('edit')]
    );

    $overview->add(new admin_setting_configcheckbox(
        "local_oc_seasonal_animations/{$settingpre}enabled",
        $visiblecatname . ' ' . $edit,
        get_string('settings:enable', 'local_oc_seasonal_animations'),
        0
    ));

    // 0============ General ============0.
    $generalsettings = [];

    $view = $OUTPUT->action_icon(
        $preview->get_settings_page_url(),
        new pix_icon('t/hide', get_string('settings:overview:preview', 'local_oc_seasonal_animations')),
        null,
        ['title' => get_string('settings:overview:preview', 'local_oc_seasonal_animations')]
    );
    $generalsettings[] = new admin_setting_description(
        "local_oc_seasonal_animations/{$settingpre}preview",
        get_string('settings:overview:preview', 'local_oc_seasonal_animations'),
        $view . "<br><p></p>",
    );

    $edit = '';
    $generalsettings[] = new admin_setting_configcheckbox(
        "local_oc_seasonal_animations/{$settingpre}start_random",
        get_string('settings:general:start_random', 'local_oc_seasonal_animations'),
        get_string('settings:general:start_random_desc', 'local_oc_seasonal_animations'),
        $defaults['start_random'] ?? true
    );
    $selectedstartposition = get_config('local_oc_seasonal_animations', "{$settingpre}start_position");
    if ($selectedstartposition) {
        $site = $startpossubsettings[$selectedstartposition];
        $edit = $OUTPUT->action_icon(
            $site->get_settings_page_url(),
            new pix_icon('t/edit', get_string('edit'), 'core'),
            null,
            ['title' => get_string('edit')]
        );
    }
    $generalsettings[] = new admin_setting_configselect(
        "local_oc_seasonal_animations/{$settingpre}start_position",
        get_string('settings:general:start_position', 'local_oc_seasonal_animations') . ' ' . $edit,
        get_string('settings:general:start_position_desc', 'local_oc_seasonal_animations'),
        $defaults['start_position'] ?? 'anchor',
        [
            'anchor' => get_string('settings:general:start_position:anchor', 'local_oc_seasonal_animations'),
            'random' => get_string('settings:general:start_position:random', 'local_oc_seasonal_animations'),
        ]
    );

    $edit = '';
    $selectedbehavior = get_config('local_oc_seasonal_animations', "{$settingpre}behavior");
    if ($selectedbehavior) {
        $site = $behaviorsubsettings[$selectedbehavior];
        $edit = $OUTPUT->action_icon(
            $site->get_settings_page_url(),
            new pix_icon('t/edit', get_string('edit'), 'core'),
            null,
            ['title' => get_string('edit')]
        );
    }
    $generalsettings[] = new admin_setting_configselect(
        "local_oc_seasonal_animations/{$settingpre}behavior",
        get_string('settings:general:behavior', 'local_oc_seasonal_animations') . ' ' . $edit,
        get_string('settings:general:behavior_desc', 'local_oc_seasonal_animations'),
        $defaults['behavior'] ?? 'move',
        [
            'move' => get_string('settings:general:behavior:move', 'local_oc_seasonal_animations'),
            'fade' => get_string('settings:general:behavior:fade', 'local_oc_seasonal_animations'),
        ]
    );

    $edit = '';
    $selectedparticletype = get_config('local_oc_seasonal_animations', "{$settingpre}particle_type");
    if ($selectedparticletype) {
        $site = $particlesubsettings[$selectedparticletype];
        $edit = $OUTPUT->action_icon(
            $site->get_settings_page_url(),
            new pix_icon('t/edit', get_string('edit'), 'core'),
            null,
            ['title' => get_string('edit')]
        );
    }
    $generalsettings[] = new admin_setting_configselect(
        "local_oc_seasonal_animations/{$settingpre}particle_type",
        get_string('settings:general:particle_type', 'local_oc_seasonal_animations') . ' ' . $edit,
        get_string('settings:general:particle_type_desc', 'local_oc_seasonal_animations'),
        $defaults['particle_type'] ?? 'image-particle',
        [
            'image-particle' => get_string('settings:general:particle_type:image', 'local_oc_seasonal_animations'),
            'snow-particle' => get_string('settings:general:particle_type:snow', 'local_oc_seasonal_animations'),
        ]
    );
    $generalsettings[] = new admin_setting_confignumber(
        "local_oc_seasonal_animations/{$settingpre}particle_count",
        get_string('settings:general:particle_count', 'local_oc_seasonal_animations'),
        get_string('settings:general:particle_count_desc', 'local_oc_seasonal_animations'),
        $defaults['particle_count'] ?? 100,
        1,
        500,
        PARAM_INT,
    );
    $generalsettings[] = new admin_setting_configtext(
        "local_oc_seasonal_animations/{$settingpre}layer",
        get_string('settings:general:layer', 'local_oc_seasonal_animations'),
        get_string('settings:general:layer_desc', 'local_oc_seasonal_animations'),
        $defaults['layer'] ?? -1,
        PARAM_INT
    );

    foreach ($generalsettings as $setting) {
        $settings->add($setting);
    }

    // 0============ Snow ============0.
    $snowparticlesettings = [];
    $snowparticlesettings[] = new admin_setting_configcolourpicker(
        "local_oc_seasonal_animations/{$settingpre}particle_snow_color",
        get_string('settings:particle:snow:color', 'local_oc_seasonal_animations'),
        get_string('settings:particle:snow:color_desc', 'local_oc_seasonal_animations'),
        $defaults['particle_snow_color'] ?? '#dddddd'
    );
    $snowparticlesettings[] = new admin_setting_random_span(
        "local_oc_seasonal_animations/{$settingpre}particle_snow_size",
        get_string('settings:particle:size', 'local_oc_seasonal_animations'),
        get_string('settings:particle:size_desc', 'local_oc_seasonal_animations'),
        $defaults['particle_snow_size'] ?? ['min' => 2, 'max' => 5]
    );
    $snowparticlesettings[] = new admin_setting_random_span(
        "local_oc_seasonal_animations/{$settingpre}particle_snow_opacity",
        get_string('settings:particle:opacity', 'local_oc_seasonal_animations'),
        get_string('settings:particle:opacity_desc', 'local_oc_seasonal_animations'),
        $defaults['particle_snow_opacity'] ?? ['min' => 0, 'max' => 1]
    );
    foreach ($snowparticlesettings as $setting) {
        $particlesubsettings['snow-particle']->add($setting);
    }

    // 0============ Image ============0.
    $imageparticlesettings = [];
    $imageparticlesettings[] = new admin_setting_configstoredfile(
        "local_oc_seasonal_animations/{$settingpre}particle_image_image_file",
        get_string('settings:particle:image:image', 'local_oc_seasonal_animations'),
        get_string('settings:particle:image:image_desc', 'local_oc_seasonal_animations'),
        "{$settingpre}particle_image_image_file",
        0,
        ['maxfiles' => 5, 'accepted_types' => ['image'], 'areamaxbytes' => 1048576 * 10]
    );
    $imageparticlesettings[] = new admin_setting_random_span(
        "local_oc_seasonal_animations/{$settingpre}particle_image_size",
        get_string('settings:particle:size', 'local_oc_seasonal_animations'),
        get_string('settings:particle:size_desc', 'local_oc_seasonal_animations'),
        $defaults['particle_image_size'] ?? ['min' => 10, 'max' => 20]
    );
    $imageparticlesettings[] = new admin_setting_random_span(
        "local_oc_seasonal_animations/{$settingpre}particle_image_opacity",
        get_string('settings:particle:opacity', 'local_oc_seasonal_animations'),
        get_string('settings:particle:opacity_desc', 'local_oc_seasonal_animations'),
        $defaults['particle_image_opacity'] ?? ['min' => 0, 'max' => 1]
    );
    foreach ($imageparticlesettings as $setting) {
        $particlesubsettings['image-particle']->add($setting);
    }

    // 0============ Fade ============0.
    $fadebehaviorsettings = [];
    $fadebehaviorsettings[] = new admin_setting_random_span(
        "local_oc_seasonal_animations/{$settingpre}behavior_fade_speed",
        get_string('settings:behavior:fade:speed', 'local_oc_seasonal_animations'),
        get_string('settings:behavior:fade:speed_desc', 'local_oc_seasonal_animations'),
        $defaults['behavior_fade_speed'] ?? ['min' => 4, 'max' => 4]
    );
    foreach ($fadebehaviorsettings as $setting) {
        $behaviorsubsettings['fade']->add($setting);
    }

    // 0============ Move ============0.
    $movebehaviorsettings = [];
    $movebehaviorsettings[] = new admin_setting_configtext(
        "local_oc_seasonal_animations/{$settingpre}behavior_move_border",
        get_string('settings:behavior:move:border', 'local_oc_seasonal_animations'),
        get_string('settings:behavior:move:border_desc', 'local_oc_seasonal_animations'),
        $defaults['behavior_move_border'] ?? 200,
        PARAM_INT
    );
    $movebehaviorsettings[] = new admin_setting_random_span(
        "local_oc_seasonal_animations/{$settingpre}behavior_move_horizontal_speed",
        get_string('settings:behavior:move:horizontal_speed', 'local_oc_seasonal_animations'),
        get_string('settings:behavior:move:horizontal_speed_desc', 'local_oc_seasonal_animations'),
        $defaults['behavior_move_horizontal_speed'] ?? ['min' => 0, 'max' => 0]
    );
    $movebehaviorsettings[] = new admin_setting_random_span(
        "local_oc_seasonal_animations/{$settingpre}behavior_move_vertical_speed",
        get_string('settings:behavior:move:vertical_speed', 'local_oc_seasonal_animations'),
        get_string('settings:behavior:move:vertical_speed_desc', 'local_oc_seasonal_animations'),
        $defaults['behavior_move_vertical_speed'] ?? ['min' => 2, 'max' => 4]
    );
    $movebehaviorsettings[] = new admin_setting_random_span(
        "local_oc_seasonal_animations/{$settingpre}behavior_move_rotation_speed",
        get_string('settings:behavior:move:rotation_speed', 'local_oc_seasonal_animations'),
        get_string('settings:behavior:move:rotation_speed_desc', 'local_oc_seasonal_animations'),
        $defaults['behavior_move_rotation_speed'] ?? ['min' => 0, 'max' => 0]
    );
    $movebehaviorsettings[] = new admin_setting_configtext(
        "local_oc_seasonal_animations/{$settingpre}behavior_move_horizontal_random_change",
        get_string('settings:behavior:move:horizontal_random_change', 'local_oc_seasonal_animations'),
        get_string('settings:behavior:move:horizontal_random_change_desc', 'local_oc_seasonal_animations'),
        $defaults['behavior_move_horizontal_random_change'] ?? 0,
        PARAM_FLOAT
    );
    $movebehaviorsettings[] = new admin_setting_random_span(
        "local_oc_seasonal_animations/{$settingpre}behavior_move_horizontal_random_span",
        get_string('settings:behavior:move:horizontal_random_span', 'local_oc_seasonal_animations'),
        get_string('settings:behavior:move:horizontal_random_span_desc', 'local_oc_seasonal_animations'),
        $defaults['behavior_move_horizontal_random_span'] ?? ['min' => 0, 'max' => 0]
    );
    $movebehaviorsettings[] = new admin_setting_configtext(
        "local_oc_seasonal_animations/{$settingpre}behavior_move_vertical_random_change",
        get_string('settings:behavior:move:vertical_random_change', 'local_oc_seasonal_animations'),
        get_string('settings:behavior:move:vertical_random_change_desc', 'local_oc_seasonal_animations'),
        $defaults['behavior_move_vertical_random_change'] ?? 0,
        PARAM_FLOAT
    );
    $movebehaviorsettings[] = new admin_setting_random_span(
        "local_oc_seasonal_animations/{$settingpre}behavior_move_vertical_random_span",
        get_string('settings:behavior:move:vertical_random_span', 'local_oc_seasonal_animations'),
        get_string('settings:behavior:move:vertical_random_span_desc', 'local_oc_seasonal_animations'),
        $defaults['behavior_move_vertical_random_span'] ?? ['min' => 0, 'max' => 0]
    );
    foreach ($movebehaviorsettings as $setting) {
        $behaviorsubsettings['move']->add($setting);
    }

    // 0============ Anchor ============0.
    $anchorstartsettings = [];
    $anchorstartsettings[] = new admin_setting_configmultiselect(
        "local_oc_seasonal_animations/{$settingpre}startpos_anchor_bordersite",
        get_string('settings:startpos:anchor:bordersite', 'local_oc_seasonal_animations'),
        get_string('settings:startpos:anchor:bordersite_desc', 'local_oc_seasonal_animations'),
        $defaults['startpos_anchor_bordersite'] ?? ['t'],
        [
            't' => get_string('settings:startpos:anchor:bordersite:t', 'local_oc_seasonal_animations'),
            'b' => get_string('settings:startpos:anchor:bordersite:b', 'local_oc_seasonal_animations'),
            'l' => get_string('settings:startpos:anchor:bordersite:l', 'local_oc_seasonal_animations'),
            'r' => get_string('settings:startpos:anchor:bordersite:r', 'local_oc_seasonal_animations'),
        ]
    );
    $anchorstartsettings[] = new admin_setting_random_span(
        "local_oc_seasonal_animations/{$settingpre}startpos_anchor_distance",
        get_string('settings:startpos:anchor:distance', 'local_oc_seasonal_animations'),
        get_string('settings:startpos:anchor:distance_desc', 'local_oc_seasonal_animations'),
        $defaults['startpos_anchor_distance'] ?? ['min' => -100, 'max' => 0]
    );
    foreach ($anchorstartsettings as $setting) {
        $startpossubsettings['anchor']->add($setting);
    }

    // 0============ Random ============0.
}
