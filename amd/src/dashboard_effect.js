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

import {Effect} from './local/dashboard_effect/effect';
import {SnowParticle} from './local/dashboard_effect/particle/snow_particle';
import {ImageParticle} from './local/dashboard_effect/particle/image_particle';

let pluginConfigs = {};

export const getPluginConfigs = () => pluginConfigs;

export const init = async(configs = {}) => {
    pluginConfigs = configs;

    if (!customElements.get('image-particle')) {
        customElements.define('image-particle', ImageParticle);
    }

    if (!customElements.get('snow-particle')) {
        customElements.define('snow-particle', SnowParticle);
    }

    if (!customElements.get('snow-effect')) {
        customElements.define('snow-effect', Effect);
    }
};
