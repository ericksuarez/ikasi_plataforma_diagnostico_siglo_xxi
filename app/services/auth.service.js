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
var core_1 = require('@angular/core');
var http_1 = require("@angular/http");
require('rxjs/add/observable/of');
require('rxjs/add/operator/do');
require('rxjs/add/operator/delay');
require('rxjs/add/operator/map');
var app_config_1 = require("../app.config");
var AuthService = (function () {
    function AuthService(_http, config) {
        this._http = _http;
        this.config = config;
        // headers
        this.headers = new http_1.Headers({ 'Content-Type': 'application/x-www-form-urlencoded' });
        // Login por default es false
        this.loggedIn = false;
        // Administrador
        this.manager = false;
        this.url = config.apiEndPoint;
        this.loggedIn = !!localStorage.getItem('auth_key');
        this.manager = !!localStorage.getItem('canManagement');
        this.token = localStorage.getItem('auth_key');
        this.profile = (localStorage.getItem('profile') != null) ? JSON.parse(localStorage.getItem('profile')) : {};
    }
    /**
     * Verifica las credenciales de un usuario, en caso de exito se genera la sesión
     * @param user
     * @returns {Observable<R>}
     */
    AuthService.prototype.login = function (user) {
        var _this = this;
        var json = JSON.stringify(user);
        var params = "json=" + json;
        return this._http.post(this.url + "/login", params, { headers: this.headers })
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.hasOwnProperty('token')) {
                localStorage.setItem('auth_key', response.token);
                _this.loggedIn = true;
                if (response.hasOwnProperty('canManagement')) {
                    //noinspection TypeScriptUnresolvedVariable
                    localStorage.setItem('canManagement', response.canManagement);
                    _this.manager = true;
                }
            }
            return response;
        });
    };
    /**
     * Devuelve el perfil del profesor
     * @returns {Observable<R>}
     */
    AuthService.prototype.getIdentity = function (token) {
        var headers = new http_1.Headers({ 'Accept': 'application/json' });
        headers.append('X-API-KEY', token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.get(this.url + "/profile", options)
            .map(function (response) { return response.json(); });
    };
    /**
     * Devuelve el perfil del usuario
     * @returns {any}
     */
    AuthService.prototype.getProfile = function () {
        return this.profile;
    };
    AuthService.prototype.updateProfile = function (newToken) {
        this.getIdentity(newToken).subscribe(function (response) {
            if (response.hasOwnProperty('sub')) {
                localStorage.removeItem('profile');
                localStorage.setItem('profile', JSON.stringify(response));
                localStorage.removeItem('auth_key');
                localStorage.setItem('auth_key', newToken);
            }
        });
    };
    /**
     * Devuelve el token del usuario
     * @returns {any}
     */
    AuthService.prototype.getToken = function () {
        return this.token;
    };
    /**
     * Verifica si el usuario actual es administrador
     * @returns {boolean}
     */
    AuthService.prototype.isAdmin = function () {
        return this.manager;
    };
    /**
     * Verifica que el usuario tenga una sesión activa
     * @returns {boolean}
     */
    AuthService.prototype.isLoggedIn = function () {
        return this.loggedIn;
    };
    /**
     * Cierra la sesión actual
     */
    AuthService.prototype.logout = function () {
        localStorage.removeItem('auth_key');
        localStorage.removeItem('canManagement');
        localStorage.removeItem('profile');
        this.loggedIn = false;
        this.manager = false;
    };
    AuthService = __decorate([
        core_1.Injectable(),
        __param(1, core_1.Inject(app_config_1.APP_CONFIG)), 
        __metadata('design:paramtypes', [http_1.Http, Object])
    ], AuthService);
    return AuthService;
}());
exports.AuthService = AuthService;
//# sourceMappingURL=auth.service.js.map