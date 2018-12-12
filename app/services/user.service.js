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
var auth_service_1 = require("./auth.service");
var app_config_1 = require("../app.config");
var UserService = (function () {
    function UserService(_http, authService, config) {
        this._http = _http;
        this.authService = authService;
        this.config = config;
        this.controller = "/user";
        this.url = config.apiEndPoint + this.controller;
        this.token = authService.getToken();
    }
    /**
     * Método para cambiar la contraseña
     * @param model
     * @returns {Observable<R>}
     */
    UserService.prototype.changePassword = function (model) {
        var json = JSON.stringify(model);
        var params = "json=" + json;
        return this.buildPostRequest(params, "/change-password");
    };
    /**
     * Método para cambiar el email
     * @param model
     * @returns {Observable<R>}
     */
    UserService.prototype.changeEmail = function (model) {
        var json = JSON.stringify(model);
        var params = "json=" + json;
        return this.buildPostRequest(params, "/change-email");
    };
    /**
     * Actualiza el perfil del usuario
     * @param model
     * @returns {Observable<R>}
     */
    UserService.prototype.updateProfile = function (model) {
        var json = JSON.stringify(model);
        var params = "json=" + json;
        return this.buildPostRequest(params, "/update-profile");
    };
    UserService.prototype.changeHome = function (model) {
        var json = JSON.stringify(model);
        var params = "json=" + json;
        return this.buildPostRequest(params, "/change-home");
    };
    /**
     * Verifica si el curp proporcionado existe en la tabla de pre-registro
     * @param model
     * @returns {Observable<R>}
     */
    UserService.prototype.checkCurp = function (model) {
        var json = JSON.stringify(model);
        var params = "json=" + json;
        var headers = new http_1.Headers({ 'Content-Type': 'application/x-www-form-urlencoded' });
        return this._http.post(this.url + "/check-curp", params, { headers: headers })
            .map(function (response) { return response.json(); })
            .map(function (response) {
            return response;
        });
    };
    /**
     * Prepara el request que será enviado al API
     * @param params
     * @param action
     * @returns {Observable<R>}
     */
    UserService.prototype.buildPostRequest = function (params, action) {
        var headers = new http_1.Headers({ 'Content-Type': 'application/x-www-form-urlencoded' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.post(this.url + action, params, options).map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    UserService.prototype.getHome = function () {
        var headers = new http_1.Headers({ 'Accept': 'application/json' });
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.get(this.url + "/get-home/1", options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
	UserService.prototype.getGraphDashboard = function () {
        var headers = new http_1.Headers({ 'Accept': 'application/json' });
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.get("inne/getGraphDashboard/1", options)
            .map(function (response) { return $.parseJSON(response.json()); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    
    UserService = __decorate([
        core_1.Injectable(),
        __param(2, core_1.Inject(app_config_1.APP_CONFIG)), 
        __metadata('design:paramtypes', [http_1.Http, auth_service_1.AuthService, Object])
    ], UserService);
    return UserService;
}());
exports.UserService = UserService;
//# sourceMappingURL=user.service.js.map