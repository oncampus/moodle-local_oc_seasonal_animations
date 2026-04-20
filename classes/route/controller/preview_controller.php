<?php

namespace local_oc_seasonal_animations\route\controller;

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
