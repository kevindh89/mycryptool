require('../css/app.scss');

var $ = require('jquery');
window.$ = $;
require('bootstrap');

window.MyCryptool = {
    tickerWebsocket: {
        websocket: undefined,
        subscribers: []
    },

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
    },

    openTickerWebsocket(productId) {
        window.MyCryptool.tickerWebsocket.websocket = new WebSocket('wss://ws-feed.gdax.com');

        window.MyCryptool.tickerWebsocket.websocket.onopen = () => {
            const subscribeMessage = {
                "type": "subscribe",
                "product_ids": [
                    productId
                ],
                "channels": [
                    {
                        "name": "ticker",
                        "product_ids": [
                            productId
                        ]
                    }
                ]
            };
            window.MyCryptool.tickerWebsocket.websocket.send(JSON.stringify(subscribeMessage));
        };

        window.MyCryptool.tickerWebsocket.websocket.onmessage = (event) => {
            window.MyCryptool.tickerWebsocket.subscribers.forEach(callback => {
                callback(event);
            });
        };
    },

    subscribeToTickerWebsocket(callback) {
        window.MyCryptool.tickerWebsocket.subscribers.push(callback);
    }
};
