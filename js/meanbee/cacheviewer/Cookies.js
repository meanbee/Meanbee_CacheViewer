/**
 * A class for setting, retrieving and clearing document cookie values.
 */
;'use strict';

(function () {
    var Cookies = Class.create({
        /**
         * @constructor
         * @param {object} options Default cookie values for the "expires",
         *                         "path", "domain" and "secure" properties.
         */
        initialize: function (options) {
            this.config = Object.extend({
                expires: null,
                path: '/',
                domain: null,
                secure: false
            }, options || {});
        },

        /**
         * Set a cookie with the given name and value.
         *
         * @param {string}    name
         * @param {string}    value
         * @param {string}    expires (optional) Expiry date of the cookie.
         * @param {string}    path    (optional) The path of the cookie.
         * @param {string}    domain  (optional) The domain of the cookie.
         * @param {boolean}   secure  (optional) Mark the cookie as secure.
         */
        set: function (name, value, expires, path, domain, secure) {
            expires = (typeof expires !== 'undefined') ? expires : this.config.expires;
            path = (typeof path !== 'undefined') ? path : this.config.path;
            domain = (typeof domain !== 'undefined') ? domain : this.config.domain;
            secure = (typeof secure !== 'undefined') ? secure : this.config.secure;

            document.cookie = name + "=" + encodeURIComponent(value) +
                ((expires == null) ? "" : ("; expires=" + expires.toUTCString())) +
                ((path == null) ? "" : ("; path=" + path)) +
                ((domain == null) ? "" : ("; domain=" + domain)) +
                ((secure == true) ? "; secure" : "");
        },

        /**
         * Get the value of the cookie with the given name, if it exists.
         *
         * @param {string} name
         * @returns {string}
         */
        get: function (name) {
            var name_start = 0;
            var value_start = 0;
            while (name_start < document.cookie.length) {
                value_start = name_start + name.length + 1;
                if (document.cookie.substring(name_start, value_start) == name + "=") {
                    var value_end = document.cookie.indexOf(";", value_start);
                    if (value_end == -1) {
                        value_end = document.cookie.length;
                    }
                    return decodeURIComponent(document.cookie.substring(value_start, value_end));
                }
                name_start = document.cookie.indexOf(" ", name_start) + 1;
                if (name_start == 0) {
                    break;
                }
            }
            return null;
        },

        /**
         * Mark the cookie with the given name to be cleared by setting
         * its expiry date in the past.
         *
         * @param {string} name
         */
        clear: function (name) {
            if (this.get(name)) {
                document.cookie = name + "=" + "; expires=Thu, 01-Jan-70 00:00:01 GMT";
            }
        }
    });

    if (!window.Meanbee) window.Meanbee = {};
    if (!window.Meanbee.Cacheviewer) window.Meanbee.Cacheviewer = {};
    window.Meanbee.Cacheviewer.Cookies = Cookies;
})();
