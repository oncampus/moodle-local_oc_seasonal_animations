// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Represents a custom HTML element for displaying animated particle effects.
 *
 * The Effect element supports configurable particle count, type, behavior,
 * and start position. It integrates session storage for toggle persistence
 * and uses language strings for toggle button labeling.
 *
 * @author     Konrad Ebel <konrad.ebel@oncampus.de>
 * @copyright  2025, onCampus GmbH
 */

import {EffectToggleButton} from "./effect_toggle_button";
import {getPluginConfigs} from "../../dashboard_effect";
import {MoveBehavior} from "./behavior/move_behavior";
import {FadeBehavior} from "./behavior/fade_behavior";
import {AnchorStart} from "./startposition/anchor_start";
import {RandomScreenStart} from "./startposition/random_screen_start";

export class Effect extends HTMLElement {
    /**
     * An array holding all currently rendered particle elements.
     *
     * @type {HTMLElement[]}
     */
    particles = [];

    /**
     * Language string to show when effect can be disabled.
     *
     * @type {string}
     */
    disable = "Language String Missing";

    /**
     * Language string to show when effect can be enabled.
     *
     * @type {string}
     */
    enable = "Language String Missing";

    /**
     * Total number of particles to generate.
     *
     * @type {number}
     */
    total = undefined;

    /**
     * The tag name for the custom particle element.
     *
     * @type {string}
     */
    particleTag = undefined;

    /**
     * Object handling animation behavior of particles.
     *
     * @type {Object}
     */
    behavior = undefined;

    /**
     * CSS z-index for the snow effect element.
     *
     * @type {number}
     */
    zIndex = undefined;

    constructor() {
        super();
        const configs = getPluginConfigs();
        const startRandom = configs.start_random === '1';
        this.total = configs.particle_count || 100;
        this.particleTag = configs.particle_type || 'snow-particle';
        this.respawnPosition = this.getStartPosition(configs.start_position);
        this.startPosition = startRandom ? this.getStartPosition('random') : this.respawnPosition;
        this.behavior = this.getBehavior(configs.behavior);
        this.zIndex = configs.layer || -1;
    }

    /**
     * Instantiates a start position strategy based on a configuration string.
     *
     * @param {string} startPositionString - The type of start position to use.
     * @returns {Object} An instance of a start position class.
     */
    getStartPosition(startPositionString) {
        window.console.log("Start at position " + startPositionString);

        switch (startPositionString) {
            case 'anchor':
                return new AnchorStart();
            case 'random':
                return new RandomScreenStart();
            default:
                return new RandomScreenStart();
        }
    }

    /**
     * Instantiates a particle behavior based on a configuration string.
     *
     * @param {string} behaviorString - The type of behavior to use.
     * @returns {Object} An instance of a behavior class.
     */
    getBehavior(behaviorString) {
        window.console.log("Start with behavior " + behaviorString);

        switch (behaviorString) {
            case 'move':
                return new MoveBehavior(this.respawnPosition);
            case 'fade':
                return new FadeBehavior(this.respawnPosition);
            default:
                return new MoveBehavior(this.respawnPosition);
        }
    }

    /**
     * Lifecycle method called when the element is inserted into the DOM.
     *
     * Applies style, loads language strings, checks session storage for
     * previous state, and binds the toggle button event.
     */
    connectedCallback() {
        this.style.position = 'fixed';
        this.style.top = '0';
        this.style.left = '0';
        this.style.width = '100%';
        this.style.height = '100%';
        this.style.pointerEvents = 'none';
        this.style.zIndex = this.zIndex;

        const enabled = sessionStorage.getItem('snowEffectEnabled') !== 'false';
        if (enabled) {
            this.enableAnimation();
        } else {
            this.disableAnimation();
        }

        EffectToggleButton.createAnimationToggleButton(
            enabled,
            () => this.enableAnimation(),
            () => this.disableAnimation()
        ).then((btn) => {
            btn.initializeCallbacks();
            return true;
        }).catch(() => {
            return false;
        });
    }

    /**
     * Creates and appends the configured number of particles to the DOM.
     *
     * Each particle is initialized with a start position and behavior.
     */
    createParticles() {
        if (!customElements.get(this.particleTag)) {
            window.console.error(`Custom element '${this.particleTag}' is not defined!`);
        }

        for (let i = 0; i < this.total; i++) {
            const particle = document.createElement(this.particleTag);
            this.behavior.init(particle);
            this.appendChild(particle);
            this.startPosition.setStartPosition(particle);
            this.particles.push(particle);
        }
    }

    /**
     * Applies animation steps to all particles and recursively loops using requestAnimationFrame.
     */
    animateParticles() {
        this.particles.forEach(particle => this.behavior.animationStep(particle));
        this.animationFrame = requestAnimationFrame(() => this.animateParticles());
    }

    /**
     * Removes all particles from the DOM and clears the internal array.
     */
    destroyParticles() {
        this.particles.forEach(particle => this.removeChild(particle));
        this.particles = [];
    }

    /**
     * Activates the snow effect by displaying the element, creating particles,
     * and starting the animation loop.
     */
    enableAnimation() {
        sessionStorage.setItem('snowEffectEnabled', 'true');
        this.style.display = 'block';
        this.createParticles();
        this.animateParticles();
    }

    /**
     * Deactivates the snow effect by hiding the element, stopping the animation,
     * and removing all particles.
     */
    disableAnimation() {
        sessionStorage.setItem('snowEffectEnabled', 'false');
        this.style.display = 'none';
        if (this.animationFrame) {
            cancelAnimationFrame(this.animationFrame);
        }
        this.destroyParticles();
    }
}
