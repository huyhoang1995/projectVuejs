const uniqueId = require('lodash.uniqueid');
const myFunc = {
    isEmpty: function (val) {
        if (!val)
            return true;
        var typeOfVal = typeof val;
        var retVal = false;
        switch (typeOfVal) {
            case 'array':
                retVal = (val.length < 1) ? true : false;
                break;
            case 'object':
                var arrKey = Object.keys(val);
                retVal = (arrKey.length < 1) ? true : false;
                break;
            case 'string':
                retVal = (val.length < 1) ? true : false;
                break;
        }

        return retVal;
    },
    radId: function () {
        return '_' + Math.random().toString(36).substr(2, 9);
    },
    isBottom: function (dom) {
        return (dom.scrollTop + + $(dom).innerHeight() >= dom.scrollHeight);
    },
    isTop: function (dom) {
        return (dom.scrollTop == 0);
    },
    scrollToBottom: function (dom) {
        $(dom).stop().animate({
            scrollTop: dom.scrollHeight
        }, 0);
    },
    queryStringToHash: function (query) {
        var query_string = {};
        var vars = query.split("&");
        for (var i = 0; i < vars.length; i++) {
            var pair = vars[i].split("=");
            pair[0] = decodeURIComponent(pair[0]);
            pair[1] = decodeURIComponent(pair[1]);
            // If first entry with this name
            if (typeof query_string[pair[0]] === "undefined") {
                query_string[pair[0]] = pair[1];
                // If second entry with this name
            } else if (typeof query_string[pair[0]] === "string") {
                var arr = [query_string[pair[0]], pair[1]];
                query_string[pair[0]] = arr;
                // If third or later entry with this name
            } else {
                query_string[pair[0]].push(pair[1]);
            }
        }
        return query_string;
    },
    getURLParameter: function (sParam) {
        var query = window.location.search.substring(1) || window.location.hash.substr(1);
        query = query.replace('/', '');
        query = query.replace('?', '');
        var params = myFunc.queryStringToHash(query.replace('/', ''));
        return params[sParam] || false;
    },
    uniqueId: function(prefix){
        prefix = prefix || '';
        return uniqueId(prefix);
    }
};

export default myFunc;