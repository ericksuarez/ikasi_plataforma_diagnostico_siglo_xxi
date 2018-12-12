"use strict";
var moment = require("moment/moment");
require('moment/locale/es');
var Helper = (function () {
    function Helper() {
    }
    /**
     * Convierte una fecha unixtime en formato D MMMM YYYY, h:mm:ss, con la librería Moment.js
     * @param unixtime
     * @returns {any}
     */
    Helper.prototype.getformattedDate = function (unixtime) {
        if (unixtime < 1) {
            return "--";
        }
        var timestamp = moment.unix(unixtime);
        return timestamp.format("D MMMM YYYY, HH:mm:ss");
    };
    /**
     * Devuelve el status del usuario como string
     * @param status
     * @returns {string|string}
     */
    Helper.prototype.getUserStatus = function (status) {
        return (status == 1) ? "Desactivado" : "Activado";
    };
    /**
     * Codifica una cadena en base64
     * @param stringToEncode
     * @returns {string}
     */
    Helper.prototype.base64Encode = function (stringToEncode) {
        return btoa(encodeURIComponent(stringToEncode));
    };
    /**
     * Decodifica una cadena en base64
     * @param stringToDecode
     * @returns {string}
     */
    Helper.prototype.base64Decode = function (stringToDecode) {
        return decodeURIComponent(atob(stringToDecode));
    };
    return Helper;
}());
exports.Helper = Helper;
//# sourceMappingURL=helper.js.map