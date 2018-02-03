require('../css/app.scss');

var $ = require('jquery');
window.$ = $;
require('bootstrap');

window.MyCryptool = {
    loadTradeList(destinationElement) {
        return $.get('/trade-list', response => {
            destinationElement.html(response);
        });
    },

    updateTrades() {
        return $.get('/api/trades', response => {
            return response;
        });
    }
};
