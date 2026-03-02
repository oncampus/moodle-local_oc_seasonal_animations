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
 * Determines particle starting positions relative to screen edges (anchors).
 *
 * Uses plugin configuration to decide which screen borders to use and places
 * particles near the specified edge with randomized offsets.
 *
 * @author     Konrad Ebel <konrad.ebel@oncampus.de>
 * @copyright  2025, onCampus GmbH
 */

import {getPluginConfigs} from "../../../dashboard_effect";
import {readRandomValue} from "../config/config_helper";


export class AnchorStart {
    /**
     * Array of border identifiers ('t', 'b', 'l', 'r') from config indicating possible start edges.
     *
     * @type {string[]}
     */
    borderSites = [];

    constructor() {
        const configs = getPluginConfigs();
        this.borderSites = (configs.startpos_anchor_bordersite || 't').split(',');
    }

    /**
     * Places the particle near a randomly selected screen border with an offset.
     *
     * The position is calculated based on screen dimensions and a configurable distance.
     *
     * @param {HTMLElement} particle - The particle element to position.
     */
    setStartPosition(particle) {
        const borderSite = this.borderSites[Math.floor(Math.random() * this.borderSites.length)];
        const configs = getPluginConfigs();
        const distanceBorder = readRandomValue(configs.startpos_anchor_distance || "-100;100");

        if (borderSite === 't') {
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = distanceBorder + 'px';
        } else if (borderSite === 'b') {
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = (window.innerHeight - distanceBorder) + 'px';
        } else if (borderSite === 'l') {
            particle.style.left = distanceBorder + 'px';
            particle.style.top = Math.random() * 100 + '%';
        } else if (borderSite === 'r') {
            particle.style.left = (window.innerWidth - distanceBorder) + 'px';
            particle.style.top = Math.random() * 100 + '%';
        }
    }
}
