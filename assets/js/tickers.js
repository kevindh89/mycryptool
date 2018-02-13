NavbarTicker = function (event, navbarTicker) {
    if (isNaN(parseFloat(JSON.parse(event.data).price))) {
        return;
    }
    navbarTicker.html(parseFloat(JSON.parse(event.data).price).toFixed(2));
};

WindowTitleTicker = function (event, activeProduct) {
    if (isNaN(parseFloat(JSON.parse(event.data).price))) {
        return;
    }
    document.title = '€' + parseFloat(JSON.parse(event.data).price).toFixed(2) +
        ' · ' + activeProduct +
        ' - MyCryptool';
};

TradeListTicker = function (event, tradeListPossibleTradePrice, tradeListPossibleTotalTradePrice, tradeListPossibleTradeSize) {
    if (isNaN(parseFloat(JSON.parse(event.data).price))) {
        return;
    }
    tradeListPossibleTradePrice.html(parseFloat(JSON.parse(event.data).price).toFixed(2));
    tradeListPossibleTotalTradePrice.html((parseFloat(JSON.parse(event.data).price) * parseFloat(tradeListPossibleTradeSize.html())).toFixed(2));
};
