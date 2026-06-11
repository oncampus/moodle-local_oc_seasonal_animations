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

namespace local_oc_seasonal_animations\route\utils;

use core\param;
use core\router\schema\parameters\mapped_property_parameter;
use core\router\schema\parameters\path_parameter;
use core\router\schema\referenced_object;
use local_oc_seasonal_animations\season;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Animation setting configuration for season path parameter
 *
 * @package    local_oc_seasonal_animations
 * @author     Konrad Ebel <konrad.ebel@oncampus.de>
 * @copyright  2025, onCampus GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class path_season_animation extends path_parameter implements mapped_property_parameter, referenced_object {
    /**
     * Create a new path_season_animation parameter.
     *
     * @param string $name Name of the path parameter
     */
    public function __construct(string $name = 'season') {
        $extra = [];
        $extra['name'] = $name;
        $extra['type'] = param::ALPHAEXT;
        $extra['description'] = <<<EOF
        The animation season.

        This can be seasonless_, spring_, summer_, autumn_ or winter_
        EOF;

        parent::__construct(...$extra);
    }

    #[\Override]
    public function add_attributes_for_parameter_value(
        ServerRequestInterface $request,
        string $value,
    ): ServerRequestInterface {
        $season = season::from($value);

        return $request
            ->withAttribute($this->name, $season);
    }
}
