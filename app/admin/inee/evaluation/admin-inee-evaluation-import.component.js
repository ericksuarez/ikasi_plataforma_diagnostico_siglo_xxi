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
var inee_service_1 = require("../../../services/inee.service");
var teacher_function_service_1 = require("../../../services/teacher-function.service");
var education_level_service_1 = require("../../../services/education-level.service");
var inee_evaluation_1 = require("../../../models/inee-evaluation");
var upload_service_1 = require("../../../services/upload.service");
var auth_service_1 = require("../../../services/auth.service");
var app_config_1 = require("../../../app.config");
var AdminIneeEvaluationImportComponent = (function () {
    function AdminIneeEvaluationImportComponent(_educationLevelService, _teacherFunctionService, _ineeService, _uploadService, config, authService) {
        this._educationLevelService = _educationLevelService;
        this._teacherFunctionService = _teacherFunctionService;
        this._ineeService = _ineeService;
        this._uploadService = _uploadService;
        this.config = config;
        this.authService = authService;
        this.model = new inee_evaluation_1.IneeEvaluation();
        this.education_level_list = [];
        this.teacher_function_list = [];
        this.dimension_list = [];
        this.parameter_list = [];
        this.indicator_list = [];
        this.ready = false;
        this.controller = "/evaluation-inee";
        this.url = config.apiEndPoint + this.controller;
        this.token = authService.getToken();
        // Value 4 is default for import evaluation
        this.model.typeImport = 4;
    }
    AdminIneeEvaluationImportComponent.prototype.ngOnInit = function () {
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
    AdminIneeEvaluationImportComponent.prototype.loadFile = function (event) {
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
    AdminIneeEvaluationImportComponent.prototype.upload = function () {
        var _this = this;
        var _url = this.url + "/import";
        this._uploadService.makeFileRequest(this.token, _url, ['file', JSON.stringify(this.model)], this.filesToUpload).then(function (result) {
            _this.resultUpload = result;
        }, function (error) {
            console.log(error);
        });
    };
    /**
     * Reset form values per default
     */
    AdminIneeEvaluationImportComponent.prototype.resetForm = function () {
        this.dimension_list = [];
        this.parameter_list = [];
        this.indicator_list = [];
        this.model.teacher_function = "";
        this.model.dimension = "";
        this.model.parameter = "";
    };
    /**
     * Fill select dimensions
     * @param teacher_function
     */
    AdminIneeEvaluationImportComponent.prototype.showDimensions = function (teacher_function) {
        var _this = this;
        this.dimension_list = [];
        this.parameter_list = [];
        this.indicator_list = [];
        this._ineeService.getList(this.model.education_level, teacher_function).subscribe(function (response) {
            _this.dimension_list = response;
        });
    };
    /**
     * Fill select parameters
     * @param dimensionId
     */
    AdminIneeEvaluationImportComponent.prototype.showParameters = function (dimensionId) {
        var _this = this;
        this.parameter_list = [];
        this._ineeService.getListParameter(dimensionId).subscribe(function (response) {
            _this.parameter_list = response;
        });
    };
    /**
     * Fill select indicators
     * @param parameterId
     */
    AdminIneeEvaluationImportComponent.prototype.showIndicators = function (parameterId) {
        var _this = this;
        this.indicator_list = [];
        this._ineeService.getListIndicator(parameterId).subscribe(function (response) {
            _this.indicator_list = response;
        });
    };
    AdminIneeEvaluationImportComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/inee/evaluation/import.html',
            providers: [education_level_service_1.EducationLevelService, teacher_function_service_1.TeacherFunctionService, inee_service_1.IneeService, upload_service_1.UploadService]
        }),
        __param(4, core_1.Inject(app_config_1.APP_CONFIG)), 
        __metadata('design:paramtypes', [education_level_service_1.EducationLevelService, teacher_function_service_1.TeacherFunctionService, inee_service_1.IneeService, upload_service_1.UploadService, Object, auth_service_1.AuthService])
    ], AdminIneeEvaluationImportComponent);
    return AdminIneeEvaluationImportComponent;
}());
exports.AdminIneeEvaluationImportComponent = AdminIneeEvaluationImportComponent;
//# sourceMappingURL=admin-inee-evaluation-import.component.js.map