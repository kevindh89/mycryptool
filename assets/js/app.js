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
        return $.get('/api/collect-trades', response => {
            return response;
        });
    },

    loadOrderList(destinationElement) {
        return $.get('/order-list', response => {
            destinationElement.html(response);
        });
    },

    updateOrders() {
        return $.get('/api/refresh-orders', response => {
            return response;
        });
    }
};
