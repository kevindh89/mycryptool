require('../css/app.scss');

var $ = require('jquery');
window.$ = $;
require('bootstrap');

MyCryptool = {
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
        MyCryptool.tickerWebsocket.websocket = new WebSocket('wss://ws-feed.gdax.com');

        MyCryptool.tickerWebsocket.websocket.onopen = () => {
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
            MyCryptool.tickerWebsocket.websocket.send(JSON.stringify(subscribeMessage));
        };

        MyCryptool.tickerWebsocket.websocket.onmessage = (event) => {
            MyCryptool.tickerWebsocket.subscribers.forEach(subscriber => {
                subscriber.callback(event, ...subscriber.args);
            });
        };
    },

    subscribeToTickerWebsocket(callback, ...args) {
        MyCryptool.tickerWebsocket.subscribers.push({
            callback: callback,
            args: args
        });
    }
};

window.MyCryptool = MyCryptool;
