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
 * Serves image files used for particle effects from the plugin's file area.
 *
 * This function handles access and delivery of uploaded particle images,
 * ensuring they are only accessible from system context and a valid filearea.
 *
 * @param null|stdClass $course Not used.
 * @param null|stdClass $cm Not used.
 * @param context $context The context of the file request (must be system).
 * @param string $filearea The specific file area to serve from.
 * @param array $args File path arguments (last entry is the filename).
 * @param bool $forcedownload Whether to force download or display inline.
 * @param array $options Additional options passed to file delivery.
 * @return bool True if file is successfully served, false otherwise.
 *
 * @package    local_oc_seasonal_animations
 * @author     Konrad Ebel <konrad.ebel@oncampus.de>
 * @copyright  2025, onCampus GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
function local_oc_seasonal_animations_pluginfile(
    ?stdClass $course,
    ?stdClass $cm,
    context $context,
    string $filearea,
    array $args,
    bool $forcedownload,
    array $options = []
): bool {
    if ($context->contextlevel != CONTEXT_SYSTEM) {
        return false;
    }

    if (
        !str_ends_with($filearea, 'particle_image_image_file')
        || (
            !str_starts_with($filearea, 'seasonless_')
            && !str_starts_with($filearea, 'spring_')
            && !str_starts_with($filearea, 'summer_')
            && !str_starts_with($filearea, 'autumn_')
            && !str_starts_with($filearea, 'winter_')
        )
    ) {
        return false;
    }

    $filename = array_pop($args);
    $fullpath = "/$context->id/local_oc_seasonal_animations/$filearea/0/$filename";

    $fs = get_file_storage();
    $file = $fs->get_file_by_hash(sha1($fullpath));

    if (!$file || $file->is_directory()) {
        return false;
    }

    send_stored_file($file, 0, 0, $forcedownload, $options);
    return true;
}
