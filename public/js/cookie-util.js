var cookieUtil = {
    _params: {
        name: '', value: '', path: '', expires: ''
    },

    init: function(params) {
        if( typeof params != "object" ) {
            return;
        }
        this._params.name  = params.name;
        this._params.value = params.value;
        this._params.expires = this.time(new Date(), params.days);
        this._params.path  = params.path;
    },

    toString: function() {
        return this._params.name + "=" + this._params.value + ";" + "expires=" + this._params.expires + ";path=" + this._params.path;
    },

    create: function(params) {
        this.init(params);
        //console.log(this.toString());
        document.cookie = this.toString();
    },

    get: function(name) {
        var dc = decodeURIComponent( document.cookie ).split(';');
        for ( var i = 0 ; i < dc.length ; i++ ) {
            var idx = dc[i].indexOf(name);
            if ( idx >= 0 ) {
                return dc[i].split('=')[1];
            }
        } return false;
    },

    time: function(dd, days) {
        dd.setTime(dd.getTime() + (days * 24 * 60 * 60 * 1000));
        return dd.toUTCString();
    }
};