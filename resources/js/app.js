import Chart from 'chart.js/auto';
window.Chart = Chart;

import { createIcons, icons } from 'lucide';
window.lucide = {
    createIcons: (options = {}) => {
        if (!options.icons) {
            options.icons = icons;
        }
        return createIcons(options);
    },
    icons: icons
};
