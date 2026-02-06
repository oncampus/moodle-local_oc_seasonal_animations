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

namespace local_oc_seasonal_animations\settings;

use admin_setting_configtext;
use core\exception\coding_exception;

/**
 * Admin setting for numerical configuration values with optional min/max constraints.
 *
 * Extends a standard text config setting to accept only numbers (int or float),
 * enforcing optional minimum and maximum value boundaries.
 *
 * @author     Konrad Ebel <konrad.ebel@oncampus.de>
 * @copyright  2025, onCampus GmbH
 * @package    local_oc_seasonal_animations
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class admin_setting_confignumber extends admin_setting_configtext {
    /**
     * @var int|null Minimum allowed value for the setting, or null for no minimum.
     */
    public ?int $minvalue = null;

    /**
     * @var int|null Maximum allowed value for the setting, or null for no maximum.
     */
    public ?int $maxvalue = null;

    /**
     * Constructor for the admin_setting_confignumber setting.
     *
     * Initializes the setting with a name, description, default value, parameter type,
     * optional display size, and optional min/max constraints. Ensures only numeric types
     * are accepted.
     *
     * @param string   $name           Unique setting name (config key)
     * @param string   $visiblename    Displayed label for the setting
     * @param string   $description    Description/help text for the setting
     * @param float    $defaultsetting Default value
     * @param int|null $minvalue Optional minimum allowed value
     * @param int|null $maxvalue Optional maximum allowed value
     * @param string   $paramtype      Parameter type (PARAM_FLOAT or PARAM_INT)
     * @param int|null $size           Optional size of input field
     * @throws coding_exception If a non-numeric paramtype is used
     */
    public function __construct(
        string $name,
        string $visiblename,
        string $description,
        float $defaultsetting,
        ?int $minvalue = null,
        ?int $maxvalue = null,
        string $paramtype = PARAM_FLOAT,
        ?int $size = null,
    ) {
        $this->minvalue = $minvalue;
        $this->maxvalue = $maxvalue;

        if (!in_array($paramtype, [PARAM_FLOAT, PARAM_INT])) {
            throw new coding_exception("Only number types are allowed");
        }

        parent::__construct($name, $visiblename, $description, $defaultsetting, $paramtype, $size);
    }

    /**
     * Validates the input value against the setting's requirements.
     *
     * Ensures the value is valid according to parent checks, and then checks
     * against min/max constraints if set. Returns true if valid, or an error string if not.
     *
     * @param mixed $data Value to validate
     * @return bool|string True if valid, or a localized error message
     */
    public function validate(mixed $data): bool|string {
        $errorcode = parent::validate($data);

        if ($errorcode !== true) {
            return $errorcode;
        }

        $floatconvert = floatval($data);

        if ($this->minvalue !== null && $this->minvalue > $floatconvert) {
            return get_string('validate:min', 'local_oc_seasonal_animations', $this->minvalue);
        }

        if ($this->maxvalue !== null && $this->maxvalue < $floatconvert) {
            return get_string('validate:max', 'local_oc_seasonal_animations', $this->maxvalue);
        }

        return true;
    }
}
