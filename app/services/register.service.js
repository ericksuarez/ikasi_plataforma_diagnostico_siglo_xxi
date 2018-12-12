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
var RegisterService = (function () {
    function RegisterService(_http, config) {
        this._http = _http;
        this.config = config;
        this.controller = "/user";
        this.url = config.apiEndPoint + this.controller;
    }
    /**
     * Método para registrar un nuevo usuario en la plataforma
     * @param new_user
     * @returns {Observable<R>}
     */
    RegisterService.prototype.register = function (new_user) {
        var json = JSON.stringify(new_user);
        var params = "json=" + json;
        var headers = new http_1.Headers({ 'Content-Type': 'application/x-www-form-urlencoded' });
        return this._http.post(this.url + "/register", params, { headers: headers }).map(function (response) { return response.json(); });
    };
    /**
     * Método para activación de cuenta
     * @param id
     * @param authKey
     * @returns {Observable<R>}
     */
    RegisterService.prototype.activate = function (id, authKey) {
        var params = "id=" + id + "&authKey=" + authKey;
        var headers = new http_1.Headers({ 'Content-Type': 'application/x-www-form-urlencoded' });
        return this._http.post(this.url + '/activate', params, { headers: headers }).map(function (response) { return response.json(); });
    };
    /**
     * Recuperación de contraseña
     * @param email
     * @returns {Observable<R>}
     */
    RegisterService.prototype.passwordRecovery = function (email) {
        var params = "email=" + email;
        var headers = new http_1.Headers({ 'Content-Type': 'application/x-www-form-urlencoded' });
        return this._http.post(this.url + '/password-recovery', params, { headers: headers }).map(function (response) { return response.json(); });
    };
    /**
     * Cambia la contrasñea del usuario
     * @param model
     * @returns {Observable<R>}
     */
    RegisterService.prototype.changePasswordWithtoken = function (model) {
        var json = JSON.stringify(model);
        var params = "json=" + json;
        var headers = new http_1.Headers({ 'Content-Type': 'application/x-www-form-urlencoded' });
        return this._http.post(this.url + "/change-password-token", params, { headers: headers }).map(function (response) { return response.json(); });
    };
    RegisterService = __decorate([
        core_1.Injectable(),
        __param(1, core_1.Inject(app_config_1.APP_CONFIG)), 
        __metadata('design:paramtypes', [http_1.Http, Object])
    ], RegisterService);
    return RegisterService;
}());
exports.RegisterService = RegisterService;
//# sourceMappingURL=register.service.js.map