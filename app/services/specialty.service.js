"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function")
        r = Reflect.decorate(decorators, target, key, desc);
    else
        for (var i = decorators.length - 1; i >= 0; i--)
            if (d = decorators[i])
                r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function")
        return Reflect.metadata(k, v);
};
var __param = (this && this.__param) || function (paramIndex, decorator) {
    return function (target, key) {
        decorator(target, key, paramIndex);
    }
};
Object.defineProperty(exports, "__esModule", {value: true});
var core_1 = require("@angular/core");
var http_1 = require("@angular/http");
require("rxjs/add/operator/map");
var auth_service_1 = require("./auth.service");
var app_config_1 = require("../app.config");
var SpecialtyService = /** @class */ (function () {
    function SpecialtyService(_http, authService, config) {
        this._http = _http;
        this.authService = authService;
        this.config = config;
        this.controller = "/specialty";
        this.url = config.apiEndPoint + this.controller;
        this.token = authService.getToken();
    }
    /**
     * Luistado para selector HTML
     * @returns {Observable<R>}
     */
    SpecialtyService.prototype.getList = function () {
        return this._http.get(this.url + "/list").map(function (response) {
            return response.json();
        });
    };
    /**
     * Listado para index de especialidades
     * @param page
     * @returns {Observable<R>}
     */
    SpecialtyService.prototype.findAll = function (page) {
        if (page === void 0) {
            page = 1;
        }
        var headers = new http_1.Headers({'Accept': 'application/json'});
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({headers: headers});
        return this._http.get(this.url + "/all?page=" + page, options)
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
    /**
     * Método para crear una nueva especialidad
     * @param speciality
     * @returns {Observable<R>}
     */
    SpecialtyService.prototype.create = function (speciality) {
        var json = JSON.stringify(speciality);
        var params = "json=" + json;
        var headers = new http_1.Headers({'Content-Type': 'application/x-www-form-urlencoded'});
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({headers: headers});
        return this._http.post(this.url + "/create", params, options)
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
    /**
     * Update speciality
     * @param speciality
     * @param id
     * @returns {Observable<any>}
     */
    SpecialtyService.prototype.update = function (speciality, id) {
        var json = JSON.stringify(speciality);
        var params = "json=" + json;
        var headers = new http_1.Headers({'Content-Type': 'application/x-www-form-urlencoded'});
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({headers: headers});
        return this._http.post(this.url + "/update/" + id, params, options)
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
    /**
     * Delete speciality
     * @param speciality
     * @param id
     * @returns {Observable<any>}
     */
    SpecialtyService.prototype.delete = function (id) {
        var headers = new http_1.Headers({'Content-Type': 'application/x-www-form-urlencoded'});
        headers.append('X-API-KEY', this.token);
        return this._http.get(this.url + "/delete/" + id)
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

    SpecialtyService = __decorate([
        core_1.Injectable(),
        __param(2, core_1.Inject(app_config_1.APP_CONFIG)),
        __metadata("design:paramtypes", [http_1.Http,
            auth_service_1.AuthService, Object])
    ], SpecialtyService);
    return SpecialtyService;
}());
exports.SpecialtyService = SpecialtyService;
//# sourceMappingURL=specialty.service.js.map