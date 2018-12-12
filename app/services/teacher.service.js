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
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = require("@angular/core");
var http_1 = require("@angular/http");
require("rxjs/add/operator/map");
var auth_service_1 = require("./auth.service");
var app_config_1 = require("../app.config");
var TeacherService = /** @class */ (function () {
    function TeacherService(_http, authService, config) {
        this._http = _http;
        this.authService = authService;
        this.config = config;
        this.controller = "/teacher";
        this.url = config.apiEndPoint + this.controller;
        this.token = authService.getToken();
    }
    /**
     * Listado de profesores para el index
     * @param page
     * @returns {Observable<R>}
     */
    TeacherService.prototype.findAll = function (page) {
        if (page === void 0) { page = 1; }
        var headers = new http_1.Headers({ 'Accept': 'application/json' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.get(this.url + "/all?page=" + page, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    /**
     * Listado de profesores para el index
     * @param page
     * @returns {Observable<R>}
     */
    TeacherService.prototype.findAllFullText = function (page, fullname) {
        var json = JSON.stringify({fullname: fullname});
        var params = "json=" + json;
        page = 1;
        var headers = new http_1.Headers({ 'Accept': 'application/json' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.post(this.url + "/allfullname?page=" + page + "&fullname=" + fullname, params, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    /**
     * Devuelve los datos de perfil de un profesor
     * @param id
     * @returns {Observable<R>}
     */
    TeacherService.prototype.getProfile = function (id) {
        var headers = new http_1.Headers({ 'Accept': 'application/json' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.get(this.url + "/profile?id=" + id, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    TeacherService.prototype.updateUser = function (user) {
        var json = JSON.stringify(user);
        var params = "json=" + json;
        var headers = new http_1.Headers({ 'Content-Type': 'application/x-www-form-urlencoded' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.post(this.url + "/update-user", params, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    /**
     * Listado de usuarios pre-registrados
     * @param page
     * @returns {Observable<R>}
     */
    TeacherService.prototype.findAllPreRegister = function (page) {
        if (page === void 0) { page = 1; }
        var headers = new http_1.Headers({ 'Accept': 'application/json' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.get(this.url + "/list-preregister?page=" + page, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    
    TeacherService.prototype.delete = function (id,opcion) {
//        console.log("Delete Function " + id);
console.log("TeacherService " + id + "-" + opcion);
        var headers = new http_1.Headers({'Content-Type': 'application/x-www-form-urlencoded'});
        headers.append('X-API-KEY', this.token);
        return this._http.get(this.url + "/delete/" + id + "/" + opcion)
                .map(function (response) {
                    return response.json();
                })
                .map(function (response) {
                    if (response.code == 401) {
                        location.href = "/unauthorized";
                    }
                    return response;
                });
    };
    
    TeacherService = __decorate([
        core_1.Injectable(),
        __param(2, core_1.Inject(app_config_1.APP_CONFIG)),
        __metadata("design:paramtypes", [http_1.Http,
            auth_service_1.AuthService, Object])
    ], TeacherService);
    return TeacherService;
}());
exports.TeacherService = TeacherService;
//# sourceMappingURL=teacher.service.js.map