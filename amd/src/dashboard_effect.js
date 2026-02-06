import {Effect} from './dashboard_effect/local/effect';
import {SnowParticle} from './dashboard_effect/local/particle/snow_particle';
import {ImageParticle} from './dashboard_effect/local/particle/image_particle';

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
