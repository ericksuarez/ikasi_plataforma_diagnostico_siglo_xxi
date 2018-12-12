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
var core_1 = require("@angular/core");
var UploadService = (function () {
    function UploadService() {
    }
    UploadService.prototype.makeFileRequest = function (token, url, params, files) {
        var _this = this;
        this.progressBar = jQuery("#upload-progress-bar");
        this.status = jQuery("#status");
        return new Promise(function (resolve, reject) {
            var formData = new FormData();
            var xhr = new XMLHttpRequest();
            var nameFileInput = params[0];
            for (var i = 0; i < files.length; i++) {
                formData.append(nameFileInput, files[i], files[i].name);
            }
            if (params[1] != undefined) {
                formData.append("data", params[1]);
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
            xhr.upload.addEventListener("progress", function (event) {
                var percent = (event.loaded / event.total) * 100;
                var _percent = Math.round(percent).toString();
                _this.progressBar.attr("value", _percent);
                _this.progressBar.css("width", _percent + "%");
                _this.status.html("Subiendo " + Math.round(percent) + "%");
            }, false);
            xhr.addEventListener("load", function () {
                var _percent = 0;
                _this.progressBar.attr("value", _percent);
                _this.progressBar.attr("aria-valuenow", _percent);
                _this.progressBar.css("width", _percent + "%");
                _this.status.html("Subida completa");
            }, false);
            xhr.addEventListener("error", function () {
                _this.status.html("Ocurrió un error al subir el archivo");
            }, false);
            xhr.addEventListener("abort", function () {
                _this.status.html("Se ha abortado la subida del archivo");
            }, false);
            xhr.open("POST", url, true);
            xhr.setRequestHeader("Authorization", token);
            xhr.send(formData);
        });
    };
    UploadService = __decorate([
        core_1.Injectable(), 
        __metadata('design:paramtypes', [])
    ], UploadService);
    return UploadService;
}());
exports.UploadService = UploadService;
//# sourceMappingURL=upload.service.js.map