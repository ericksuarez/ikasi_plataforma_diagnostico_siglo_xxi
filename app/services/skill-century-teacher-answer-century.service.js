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
var auth_service_1 = require("./auth.service");
var app_config_1 = require("../app.config");
var SkillCenturyTeacherAnswerCenturyService = (function () {
    function SkillCenturyTeacherAnswerCenturyService(_http, authService, config) {
        this._http = _http;
        this.authService = authService;
        this.config = config;
        this.controller = "/answer-teacher-century";
        this.teacherId = 0;
        this.url = config.apiEndPoint + this.controller;
        this.token = authService.getToken();
        this.apiEndPoint = config.apiEndPointUploads;
    }
    SkillCenturyTeacherAnswerCenturyService.prototype.saveAnswer = function (answers, userId) {
        var params = "json=" + answers + "&teacherId=" + userId;
        var headers = new http_1.Headers({ 'Content-Type': 'application/x-www-form-urlencoded' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.post(this.url + "/saveAnswer", params, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    SkillCenturyTeacherAnswerCenturyService.prototype.getResults = function () {
        var userId = this.authService.getProfile().teacher_id;
        var headers = new http_1.Headers({ 'Accept': 'application/json' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.get(this.url + "/getResult/" + userId, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    SkillCenturyTeacherAnswerCenturyService.prototype.saveImage = function (image, userId) {
        var params = "image=" + image + "&teacherId=" + userId;
        var headers = new http_1.Headers({ 'Content-Type': 'application/x-www-form-urlencoded' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.post(this.url + "/saveImage", params, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    SkillCenturyTeacherAnswerCenturyService.prototype.exportResultToPDF = function () {
        var userId = 0;
        if (this.teacherId == 0) {
            userId = this.authService.getProfile().teacher_id;
        }
        else {
            userId = this.teacherId;
        }
        var headers = new http_1.Headers({ 'Accept': 'application/json' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.get(this.url + "/export-result/" + userId, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    SkillCenturyTeacherAnswerCenturyService.prototype.exportResultToExcel = function (userId) {
        var headers = new http_1.Headers({ 'Accept': 'application/json' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.get(this.url + "/export-result-to-excel/" + userId, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    SkillCenturyTeacherAnswerCenturyService = __decorate([
        core_1.Injectable(),
        __param(2, core_1.Inject(app_config_1.APP_CONFIG)), 
        __metadata('design:paramtypes', [http_1.Http, auth_service_1.AuthService, Object])
    ], SkillCenturyTeacherAnswerCenturyService);
    return SkillCenturyTeacherAnswerCenturyService;
}());
exports.SkillCenturyTeacherAnswerCenturyService = SkillCenturyTeacherAnswerCenturyService;
//# sourceMappingURL=skill-century-teacher-answer-century.service.js.map