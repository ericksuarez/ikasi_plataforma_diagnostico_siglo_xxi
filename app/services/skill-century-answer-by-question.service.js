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
var SkillCenturyAnswerByQuestionService = (function () {
    function SkillCenturyAnswerByQuestionService(_http, authService, _authService, config) {
        this._http = _http;
        this.authService = authService;
        this._authService = _authService;
        this.config = config;
        this.controller = "/answer-question-century";
        this.url = config.apiEndPoint + this.controller;
        this.token = authService.getToken();
    }
    SkillCenturyAnswerByQuestionService.prototype.create = function (answer) {
        var json = JSON.stringify(answer);
        var params = "json=" + json;
        var headers = new http_1.Headers({ 'Content-Type': 'application/x-www-form-urlencoded' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.post(this.url + "/new/" + answer.questionId, params, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    SkillCenturyAnswerByQuestionService.prototype.findAll = function (questionId, page) {
        if (questionId === void 0) { questionId = 0; }
        if (page === void 0) { page = 1; }
        var headers = new http_1.Headers({ 'Accept': 'application/json' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.get(this.url + "/list/" + questionId + "?page=" + page, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    SkillCenturyAnswerByQuestionService.prototype.areaDetail = function (areaId) {
        var headers = new http_1.Headers({ 'Accept': 'application/json' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.get(this.url + "/detail/" + areaId, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    SkillCenturyAnswerByQuestionService.prototype.edit = function (area) {
        var json = JSON.stringify(area);
        console.log(json);
        var params = "json=" + json;
        var headers = new http_1.Headers({ 'Content-Type': 'application/x-www-form-urlencoded' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        //area.skill_century_id == areaId
        return this._http.post(this.url + "/edit/" + area.skill_century_id, params, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    SkillCenturyAnswerByQuestionService = __decorate([
        core_1.Injectable(),
        __param(3, core_1.Inject(app_config_1.APP_CONFIG)), 
        __metadata('design:paramtypes', [http_1.Http, auth_service_1.AuthService, auth_service_1.AuthService, Object])
    ], SkillCenturyAnswerByQuestionService);
    return SkillCenturyAnswerByQuestionService;
}());
exports.SkillCenturyAnswerByQuestionService = SkillCenturyAnswerByQuestionService;
//# sourceMappingURL=skill-century-answer-by-question.service.js.map