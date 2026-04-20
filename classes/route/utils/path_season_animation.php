<?php

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
class path_season_animation extends path_parameter implements referenced_object, mapped_property_parameter {
    /**
     * Create a new path_season_animation parameter.
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
