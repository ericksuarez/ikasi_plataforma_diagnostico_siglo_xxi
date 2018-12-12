"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (this && this.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};
var core_1 = require("@angular/core");
var http_1 = require("@angular/http");
require("rxjs/add/operator/map");
var app_config_1 = require("../app.config");
var LoginService = (function () {
    function LoginService(_http, config) {
        this._http = _http;
        this.config = config;
        this.identity = null;
        this.loggedIn = false;
        this.url = config.apiEndPoint;
        this.loggedIn = !!localStorage.getItem('auth_token');
        this.identity = JSON.parse(localStorage.getItem('identity'));
    }
    LoginService.prototype.login = function (user) {
        var _this = this;
        var json = JSON.stringify(user);
        var params = "json=" + json;
        var headers = new http_1.Headers({ 'Content-Type': 'application/x-www-form-urlencoded' });
        return this._http.post(this.url + "/login", params, { headers: headers })
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.hasOwnProperty('sub')) {
                localStorage.setItem('identity', JSON.stringify(response));
                _this.loggedIn = true;
            }
            return response;
        });
    };
    LoginService.prototype.getIdentity = function () {
        return this.identity;
    };
    LoginService.prototype.isLoggedIn = function () {
        return this.loggedIn;
    };
    LoginService.prototype.logout = function () {
        localStorage.removeItem('auth_key');
        localStorage.removeItem('identity');
        this.loggedIn = false;
        this.identity = null;
    };
    LoginService = __decorate([
        core_1.Injectable(),
        __param(1, core_1.Inject(app_config_1.APP_CONFIG)), 
        __metadata('design:paramtypes', [http_1.Http, Object])
    ], LoginService);
    return LoginService;
}());
exports.LoginService = LoginService;
//# sourceMappingURL=login.service.js.map