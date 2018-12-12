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
var core_1 = require("@angular/core");
var http_1 = require("@angular/http");
require("rxjs/add/operator/map");
var auth_service_1 = require("./auth.service");
var app_config_1 = require("../app.config");
var TeacherFunctionService = (function () {
    function TeacherFunctionService(_http, authService, config) {
        this._http = _http;
        this.authService = authService;
        this.config = config;
        this.controller = "/teacher-function";
        this.url = config.apiEndPoint + this.controller;
        this.token = authService.getToken();
    }
    /**
     * Listado para selector HTML
     * @returns {Observable<R>}
     */
    TeacherFunctionService.prototype.getList = function () {
        return this._http.get(this.url + "/list").map(function (response) {
            return response.json();
        });
    };
    /**
     * Listado para el index de funciones
     * @param page
     * @returns {Observable<R>}
     */
    TeacherFunctionService.prototype.findAll = function (page) {
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
     * Método para crear una nueva función
     * @param teacherFunction
     * @returns {Observable<R>}
     */
    TeacherFunctionService.prototype.create = function (teacherFunction) {
        var json = JSON.stringify(teacherFunction);
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
     * Update teacher function
     * @param teacherFunction
     * @param id
     * @returns {Observable<any>}
     */
    TeacherFunctionService.prototype.update = function (teacherFunction, id) {
        var json = JSON.stringify(teacherFunction);
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
     * Delete teacher function
     * @param id
     * @returns {Observable<any>}
     */
    TeacherFunctionService.prototype.delete = function (id) {
        var headers = new http_1.Headers({'Content-Type': 'application/x-www-form-urlencoded'});
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({headers: headers});
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
    TeacherFunctionService.prototype.codeAccess = function (code,domain) {
        var params = "client_id=6b842f8a-cfcc-43f4-a82c-3ca79e485cd1&client_secret=gN3sWzysShSjnv4Sy4xnD18kSsuXHTdMKXfkbQ81Wos=&code=" + code + "&grant_type=authorization_code&resource=https://sinadep.org.mx/Sinadep.Api&redirect_uri=" + domain + "/register";
		//var params = "client_id=6b842f8a-cfcc-43f4-a82c-3ca79e485cd1&client_secret=gN3sWzysShSjnv4Sy4xnD18kSsuXHTdMKXfkbQ81Wos=&code=AQABAAIAAADXzZ3ifr-GRbDT45zNSEFEjTwZl0qfnm1uR0KrKXFn4ib7cmpi7yeiKQl66URxqWL7DL6al1F6V9IwvrXGxDJBVYq9muTDxvJ8p4kFw7skK0R7diVafHbzBsnSOzr6JJ4NXylfDo5ROAfMxe8b6HwdnyYKVFM79TftwQudmq1B0eQdtsOpfKANAGBboLpaQdYZP21LAFBzwk6H1IksnrMzDL__gzl4iPbH4yMvrOfFQjgo-ezU_hnXrGXbcSQrHEcDeXB9tA91XfWtIS3GsUsiuXv7A9vG1a3GOVcEcWmWwQ0vNfljlZK1XEuahiahT04h3sPL0bK6dTSAKq6erbBr4eU0NEYHk07GdrkzCnZWbQ8C4uKYaE0YsTzLz9N2UlK5uH1E9mFq2q0MdLpXm3SVAacpHW-12TciCNFT1SHROqTbg8fYPVXBAaYM0UdjM7XWzaAuBSg88YEDfo1n61kXJ4CqIWXsRdsF9nuWVljBBTEeNS216JbJJgfU93OwRGRi80Kd-uVmx_YYuKvKifVIwIiPNXGLkEXNsyxH0XL0t8XzbSXfd_I1sNGI1MK4pYUc17PkpA7ZcMlagBZRldCNFvQz9BtA06c8XJrKMrhVJiAA&grant_type=authorization_code&redirect_uri=https://test.diagnosticosxxi.org/register&resource=https://sinadep.org.mx/Sinadep.Api";
		console.log(params);
		var headers = new http_1.Headers({'Content-Type': 'application/json'});
        var options = new http_1.RequestOptions({headers: headers});
        return this._http.post("https://login.microsoftonline.com/695b89f7-1e43-4e1b-a64b-eb702d7b4c26/oauth2/token", params, options)
                .map(function (response) {
					console.log(response);
                    return response.json();
                })
                .map(function (response) {
                    if (response.code == 401) {
                        location.href = "/unauthorized";
                    }
					console.log(response);
                    return response;
                });
    };
    TeacherFunctionService.prototype.userInfo = function (access_token) {
        var headers = new http_1.Headers({'Content-Type': 'application/x-www-form-urlencoded'});
        headers.append('COM-Subscription-Key', '0ef8f9273dd44ebdbb64a2c34a11d7a7');
        headers.append('Authorization', 'Bearer ' + access_token);
        var options = new http_1.RequestOptions({headers: headers});
        return this._http.get("https://api.sinadep.org.mx/lms/users/me", options)
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
    TeacherFunctionService = __decorate([
        core_1.Injectable(),
        __param(2, core_1.Inject(app_config_1.APP_CONFIG)),
        __metadata('design:paramtypes', [http_1.Http, auth_service_1.AuthService, Object])
    ], TeacherFunctionService);
    return TeacherFunctionService;
}());
exports.TeacherFunctionService = TeacherFunctionService;
//# sourceMappingURL=teacher-function.service.js.map