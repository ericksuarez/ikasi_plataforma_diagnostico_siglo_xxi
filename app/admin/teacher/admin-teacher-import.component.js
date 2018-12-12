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
var upload_service_1 = require("../../services/upload.service");
var app_config_1 = require("../../app.config");
var auth_service_1 = require("../../services/auth.service");
var AdminTeacherImportComponent = (function () {
    function AdminTeacherImportComponent(_uploadService, authService, config) {
        this._uploadService = _uploadService;
        this.authService = authService;
        this.config = config;
        this.ready = false;
        this.controller = "/teacher";
        this.url = config.apiEndPoint + this.controller;
        this.token = authService.getToken();
    }
    AdminTeacherImportComponent.prototype.ngOnInit = function () {
        jQuery("#main-navigation").find(">ul>li.active").removeClass("active");
        jQuery("#menu-teacher").addClass("active");
    };
    AdminTeacherImportComponent.prototype.loadFile = function (event) {
        var input = event.target;
        if (input.files.length == 0) {
            return;
        }
        this.filesToUpload = input.files;
        var reader = new FileReader();
        reader.onload = function () {
            var dataURL = reader.result;
            jQuery('.preview').attr('src', dataURL);
        };
        reader.readAsDataURL(input.files[0]);
        this.ready = true;
    };
    AdminTeacherImportComponent.prototype.upload = function () {
        var _this = this;
        var _url = this.url + "/import";
        this._uploadService.makeFileRequest(this.token, _url, ['file'], this.filesToUpload).then(function (result) {
            _this.resultUpload = result;
        }, function (error) {
            console.log(error);
        });
    };
    AdminTeacherImportComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/teacher/import.html',
            providers: [upload_service_1.UploadService]
        }),
        __param(2, core_1.Inject(app_config_1.APP_CONFIG)),
        __metadata("design:paramtypes", [upload_service_1.UploadService,
            auth_service_1.AuthService, Object])
    ], AdminTeacherImportComponent);
    return AdminTeacherImportComponent;
}());
exports.AdminTeacherImportComponent = AdminTeacherImportComponent;
//# sourceMappingURL=admin-teacher-import.component.js.map