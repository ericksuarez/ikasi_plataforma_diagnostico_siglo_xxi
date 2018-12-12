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
var skill_inee_1 = require("../../models/skill-inee");
var education_level_service_1 = require("../../services/education-level.service");
var teacher_function_service_1 = require("../../services/teacher-function.service");
var upload_service_1 = require("../../services/upload.service");
var app_config_1 = require("../../app.config");
var auth_service_1 = require("../../services/auth.service");
var inee_service_1 = require("../../services/inee.service");
var AdminImportIneeComponent = (function () {
    function AdminImportIneeComponent(_educationLevelService, _teacherFunctionService, _uploadService, _ineeService, config, authService) {
        this._educationLevelService = _educationLevelService;
        this._teacherFunctionService = _teacherFunctionService;
        this._uploadService = _uploadService;
        this._ineeService = _ineeService;
        this.config = config;
        this.authService = authService;
        this.model = new skill_inee_1.SkillIne();
        this.education_level_list = [];
        this.teacher_function_list = [];
        this.dimension_list = [];
        this.parameter_list = [];
        this.ready = false;
        this.controller = "/inee";
        this.url = config.apiEndPoint + this.controller;
        this.token = authService.getToken();
    }
    AdminImportIneeComponent.prototype.ngOnInit = function () {
        var _this = this;
        jQuery("#main-navigation").find(">ul>li.active").removeClass("active");
        jQuery("#menu-inee").addClass("active");
        this._educationLevelService.getList().subscribe(function (response) {
            _this.education_level_list = response;
        }, function (error) {
            console.log("Error al cargar los niveles");
        });
        this._teacherFunctionService.getList().subscribe(function (response) {
            _this.teacher_function_list = response;
        }, function (error) {
            console.log("Error al cargar las funciones");
        });
    };
    AdminImportIneeComponent.prototype.loadFile = function (event) {
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
    AdminImportIneeComponent.prototype.upload = function () {
        var _this = this;
        var _url = this.url + "/import";
        this._uploadService.makeFileRequest(this.token, _url, ['file', JSON.stringify(this.model)], this.filesToUpload).then(function (result) {
            _this.resultUpload = result;
        }, function (error) {
            console.log(error);
        });
    };
    AdminImportIneeComponent.prototype.resetForm = function () {
        this.model.teacher_function = "";
        this.model.dimension = "";
        this.model.parameter = "";
        this.dimension_list = [];
        this.parameter_list = [];
    };
    AdminImportIneeComponent.prototype.showDimensions = function (teacher_function) {
        var _this = this;
        this.dimension_list = [];
        this.parameter_list = [];
        this._ineeService.getList(this.model.education_level, teacher_function).subscribe(function (response) {
            _this.dimension_list = response;
        });
    };
    AdminImportIneeComponent.prototype.showParameters = function (dimensionId) {
        var _this = this;
        this.parameter_list = [];
        this._ineeService.getListParameter(dimensionId).subscribe(function (response) {
            _this.parameter_list = response;
        });
    };
    AdminImportIneeComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/skill-inee/import.html',
            providers: [education_level_service_1.EducationLevelService, teacher_function_service_1.TeacherFunctionService, upload_service_1.UploadService, inee_service_1.IneeService]
        }),
        __param(4, core_1.Inject(app_config_1.APP_CONFIG)), 
        __metadata('design:paramtypes', [education_level_service_1.EducationLevelService, teacher_function_service_1.TeacherFunctionService, upload_service_1.UploadService, inee_service_1.IneeService, Object, auth_service_1.AuthService])
    ], AdminImportIneeComponent);
    return AdminImportIneeComponent;
}());
exports.AdminImportIneeComponent = AdminImportIneeComponent;
//# sourceMappingURL=admin-import-inee.component.js.map