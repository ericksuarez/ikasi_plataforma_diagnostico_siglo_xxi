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
var SkillCenturyQuestionCenturyService = (function () {
    function SkillCenturyQuestionCenturyService(_http, authService, config) {
        this._http = _http;
        this.authService = authService;
        this.config = config;
        this.controller = "/questionary-century";
        this.url = config.apiEndPoint + this.controller;
        this.token = authService.getToken();
    }
    SkillCenturyQuestionCenturyService.prototype.create = function (area) {
        var json = JSON.stringify(area);
        var params = "json=" + json;
        var headers = new http_1.Headers({ 'Content-Type': 'application/x-www-form-urlencoded' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.post(this.url + "/new", params, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    SkillCenturyQuestionCenturyService.prototype.findAll = function (areaId, categoryId) {
        if (areaId === void 0) { areaId = 0; }
        if (categoryId === void 0) { categoryId = 0; }
        var headers = new http_1.Headers({ 'Accept': 'application/json' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.get(this.url + "/list/" + areaId + "/" + categoryId, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    SkillCenturyQuestionCenturyService.prototype.findByArea = function (areaId, userId) {
        if (areaId === void 0) { areaId = 0; }
        if (userId === void 0) { userId = 0; }
        var headers = new http_1.Headers({ 'Accept': 'application/json' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.get(this.url + "/list-by-area/" + areaId + "/" + userId, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    SkillCenturyQuestionCenturyService.prototype.areaDetail = function (areaId) {
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
    SkillCenturyQuestionCenturyService.prototype.edit = function (area) {
        var json = JSON.stringify(area);
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
    SkillCenturyQuestionCenturyService.prototype.makeFileRequest = function (params, files, model, replace) {
        var _this = this;
        return new Promise(function (resolve, reject) {
            var formData = new FormData();
            var xhr = new XMLHttpRequest();
            formData.append("X-API-KEY", _this.token);
            var name_file_input = params[0];
            for (var i = 0; i < files.length; i++) {
                formData.append(name_file_input, files[i], files[i].name);
            }
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        resolve(JSON.parse(xhr.response));
                    }
                    else {
                        reject(xhr.response);
                    }
                }
            };
            document.getElementById('upload-progress-bar').setAttribute('value', "0");
            document.getElementById('upload-progress-bar').style.width = "0%";
            xhr.upload.addEventListener("progress", function (event) {
                document.getElementById('upload-progress-bar').setAttribute('value', "0");
                document.getElementById('upload-progress-bar').style.width = "0%";
                var percent = (event.loaded / event.total) * 100;
                var prc = Math.round(percent).toString();
                document.getElementById('upload-progress-bar').setAttribute('value', prc);
                document.getElementById('upload-progress-bar').style.width = prc + "%";
                document.getElementById('status').innerHTML = Math.round(percent) + " % subido... por favor espera a que termine";
            }, false);
            xhr.addEventListener("load", function () {
                document.getElementById('status').innerHTML = "Carga terminada";
                var prc = "100";
                document.getElementById('upload-progress-bar').setAttribute('value', prc);
                document.getElementById('upload-progress-bar').setAttribute('aria-valuerow', prc);
                document.getElementById('upload-progress-bar').style.width = prc + "%";
            }, false);
            xhr.addEventListener("error", function () {
                document.getElementById('status').innerHTML = "Error en la carga";
            }, false);
            xhr.addEventListener("abort", function () {
                document.getElementById('status').innerHTML = "Carga cancelada";
            }, false);
            xhr.open("POST", _this.url + "/import-csv/" + model.area_id + "/" + model.category_id + "/" + replace, true);
            xhr.send(formData);
        });
    };
    SkillCenturyQuestionCenturyService = __decorate([
        core_1.Injectable(),
        __param(2, core_1.Inject(app_config_1.APP_CONFIG)), 
        __metadata('design:paramtypes', [http_1.Http, auth_service_1.AuthService, Object])
    ], SkillCenturyQuestionCenturyService);
    return SkillCenturyQuestionCenturyService;
}());
exports.SkillCenturyQuestionCenturyService = SkillCenturyQuestionCenturyService;
//# sourceMappingURL=skill-century-question-century.service.js.map