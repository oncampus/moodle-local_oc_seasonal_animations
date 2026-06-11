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

namespace local_oc_seasonal_animations\route\controller;

use coding_exception;
use context_system;
use core\context;
use core\notification;
use core\param;
use core\router;
use core\router\require_login;
use core\router\route;
use core\router\route_controller;
use local_oc_seasonal_animations\route\utils\path_season_animation;
use local_oc_seasonal_animations\season;
use local_oc_seasonal_animations\seasonal_effect;
use moodle_url;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Plugin routes
 * - Previews for seasonal effects
 *
 * @package    local_oc_seasonal_animations
 * @author     Konrad Ebel <konrad.ebel@oncampus.de>
 * @copyright  2025, onCampus GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class preview_controller {
    use route_controller;

    /**
     * Constructor for the sample controller handler.
     *
     * @param router $router The router.
     */
    public function __construct(
        /** @var router The routing engine */
        private router $router,
    ) {
    }

    /**
     * Preview script for rendering seasonal effects.
     *
     * Preview specific seasonal effects (e.g., spring, summer) by supplying
     * a valid season prefix.
     */
    #[route(
        path: '/preview/{season}',
        method: ['GET'],
        pathtypes: [new path_season_animation()],
        requirelogin: new require_login(
            requirelogin: true,
            courseattributename: 'course',
        ),
    )]
    public function index(
        season $season,
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        require_capability('moodle/site:config', context_system::instance());

        global $OUTPUT;

        $this->init_page(
            new moodle_url('/local/oc_seasonal_animations/pages/' . $season->value),
            context_system::instance(),
            get_string('preview:title', 'local_oc_seasonal_animations', $season->get_label()),
            get_string('preview:heading', 'local_oc_seasonal_animations', $season->get_label()),
        );

        seasonal_effect::render($season);

        $response->getBody()->write(
            $OUTPUT->header() .
            seasonal_effect::get_seasonal_effect_html() .
            $OUTPUT->footer()
        );
        return $response;
    }

    /**
     * Initializes a standard page
     *
     * @param moodle_url $url URL of the page
     * @param context $ctx Context of the page
     * @param string $title Title
     * @param string $heading Heading
     * @return void
     * @throws coding_exception
     */
    private function init_page(
        moodle_url $url,
        context $ctx,
        string $title,
        string $heading,
    ) {
        global $PAGE;
        $PAGE->set_url($url);
        $PAGE->set_context($ctx);
        $PAGE->set_pagelayout('standard');
        $PAGE->set_title($title);
        $PAGE->set_heading($heading);
    }
}
