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
var auth_service_1 = require("./auth.service");
var app_config_1 = require("../app.config");
var CourseService = /** @class */ (function () {
    function CourseService(_http, _authService, config) {
        this._http = _http;
        this._authService = _authService;
        this.config = config;
        this.controller = "/course";
        this.url = config.apiEndPoint + this.controller;
        this.token = _authService.getToken();
    }
    CourseService.prototype.index = function (page) {
        if (page === void 0) {
            page = 1;
        }
        var headers = new http_1.Headers({'Accept': 'application/json'});
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({headers: headers});
        return this._http.get(this.url + "/index?page=" + page, options)
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
     * Método para crear un nuevo curso
     * @param course
     * @returns {Observable<R>}
     */
    CourseService.prototype.create = function (course) {
        var json = JSON.stringify(course);
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
     * Vista detallada de curso
     * @param id
     * @returns {Observable<R>}
     */
    CourseService.prototype.view = function (id) {
        var headers = new http_1.Headers({'Accept': 'application/json'});
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({headers: headers});
        return this._http.get(this.url + "/view/" + id, options)
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
     * Actualiza la información de un curso
     * @param course
     * @param id
     * @returns {Observable<R>}
     */
    CourseService.prototype.update = function (course, id) {
        var json = JSON.stringify(course);
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
     * Sugerencia de cursos
     * @returns {Observable<R>}
     */
    CourseService.prototype.suggestions = function () {
        var headers = new http_1.Headers({'Accept': 'application/json'});
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({headers: headers});
        return this._http.get(this.url + "/suggestions", options)
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
     * Método para crear un nuevo curso en BATCH
     * @param course
     * @returns {Observable<R>}
     */
    CourseService.prototype.createBulk = function (course) {
        var headers = new http_1.Headers({'Content-Type': 'application/json; charset=UTF-8'});
        var options = new http_1.RequestOptions({headers: headers});
        return this._http.post(this.url + "/createBulk", course, options)
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
     * Actualiza el estatus de un curso
     * @param course
     * @param id
     * @returns {Observable<R>}
     */
    CourseService.prototype.deactivated = function (id) {
        var headers = new http_1.Headers({'Content-Type': 'application/x-www-form-urlencoded'});
        headers.append('X-API-KEY', this.token);
        return this._http.get(this.url + "/deactivated/" + id)
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
     * Método para listar los cursos por estatus
     * @param page
     * @param status
     * @returns {Observable<R>}
     */
    CourseService.prototype.searchByStatus = function (page, status) {
        if (page === void 0) {
            page = 1;
        }
        var headers = new http_1.Headers({'Accept': 'application/json'});
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({headers: headers});
        return this._http.get(this.url + "/search/" + status + "?page=" + page, options)
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
    CourseService = __decorate([
        core_1.Injectable(),
        __param(2, core_1.Inject(app_config_1.APP_CONFIG)),
        __metadata("design:paramtypes", [http_1.Http,
            auth_service_1.AuthService, Object])
    ], CourseService);
    return CourseService;
}());
exports.CourseService = CourseService;
//# sourceMappingURL=course.service.js.map