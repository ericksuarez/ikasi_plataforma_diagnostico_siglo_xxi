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
var EvaluationIneeService = (function () {
    function EvaluationIneeService(_http, _authservice, config) {
        this._http = _http;
        this._authservice = _authservice;
        this.config = config;
        this.controller = "/questionnaire-inee";
        this.url = config.apiEndPoint + this.controller;
        this.token = _authservice.getToken();
    }
    /**
     * Get questionnaire for teacher
     * @returns {Observable<any>}
     */
    EvaluationIneeService.prototype.getQuestionnaire = function (dimension, educationLevel, teacherFunction) {
        var headers = new http_1.Headers({ 'Accept': 'application/json' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.get(this.url + "/get-questions/" + dimension + "/" + educationLevel + "/" + teacherFunction, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    /**
     * Get dimensions to evaluate
     * @returns {Observable<any>}
     */
    EvaluationIneeService.prototype.getDimentionToEvaluate = function () {
        var headers = new http_1.Headers({ 'Accept': 'application/json' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.get(this.url + "/get-dimensions", options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    /**
     * Save questionnaire for teacher
     * @param questionnaire
     * @returns {Observable<any>}
     */
    EvaluationIneeService.prototype.save = function (questionnaire) {
        var json = JSON.stringify(questionnaire);
        var params = "json=" + json;
        var headers = new http_1.Headers({ 'Content-Type': 'application/x-www-form-urlencoded' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.post(this.url + "/save", params, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    /**
     * Save image of result from inee results
     * @param image
     * @returns {Observable<any>}
     */
    EvaluationIneeService.prototype.saveImage = function (image) {
        var params = "image=" + image;
        var headers = new http_1.Headers({ 'Content-Type': 'application/x-www-form-urlencoded' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.post(this.url + "/save-image", params, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    /**
     * Export results to PDF
     * @param teacherId
     * @returns {Observable<any>}
     */
    EvaluationIneeService.prototype.exportToPDF = function (teacherId) {
        var headers = new http_1.Headers({ 'Accept': 'application/json' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.get(this.url + "/export-pdf/" + teacherId, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    /**
     * Export results to Excel
     * @param teacherId
     * @returns {Observable<any>}
     */
    EvaluationIneeService.prototype.exportToExcel = function (teacherId) {
        var headers = new http_1.Headers({ 'Accept': 'application/json' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.get(this.url + "/export-excel/" + teacherId, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
	EvaluationIneeService.prototype.doResetEvaluationInee = function (teacherId) {
        var headers = new http_1.Headers({ 'Accept': 'application/json' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.get(this.url + "/reset-evaluation-inee/" + teacherId, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    EvaluationIneeService = __decorate([
        core_1.Injectable(),
        __param(2, core_1.Inject(app_config_1.APP_CONFIG)), 
        __metadata('design:paramtypes', [http_1.Http, auth_service_1.AuthService, Object])
    ], EvaluationIneeService);
    return EvaluationIneeService;
}());
exports.EvaluationIneeService = EvaluationIneeService;
//# sourceMappingURL=evaluation-inee.service.js.map