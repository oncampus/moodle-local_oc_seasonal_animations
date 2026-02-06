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
 * Preview script for rendering seasonal effects manually via URL parameter.
 *
 * This script allows a logged-in user to preview specific seasonal effects
 * (e.g., spring, summer) by supplying a valid season prefix. It verifies the
 * input and renders the effect forcibly on the current page.
 *
 * @package    local_oc_seasonal_animations
 * @author     Konrad Ebel <konrad.ebel@oncampus.de>
 * @copyright  2025, onCampus GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../../config.php');

use core\notification;
use local_oc_seasonal_animations\seasonal_effect;

require_login();

$season = required_param('season', PARAM_TEXT);
$printableseason = get_string('settings:' . rtrim($season, '_'), 'local_oc_seasonal_animations');
$PAGE->set_url(new moodle_url('/local/oc_seasonal_animations/pages/preview.php', ['season' => $season]));
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('preview:title', 'local_oc_seasonal_animations', $printableseason));
$PAGE->set_heading(get_string('preview:heading', 'local_oc_seasonal_animations', $printableseason));

$seasons = [
    seasonal_effect::SEASONLESS,
    seasonal_effect::SPRING,
    seasonal_effect::SUMMER,
    seasonal_effect::AUTUMN,
    seasonal_effect::WINTER,
];


echo $OUTPUT->header();

if (!in_array($season, $seasons)) {
    notification::error("$season is not a valid season");
} else {
    seasonal_effect::apply_to_page($season, true);
}

echo $OUTPUT->footer();
