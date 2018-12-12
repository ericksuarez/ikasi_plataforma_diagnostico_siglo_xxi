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
var course_service_1 = require("../../services/course.service");
var router_1 = require("@angular/router");
var auth_service_1 = require("../../services/auth.service");
var app_config_1 = require("../../app.config");
var upload_service_1 = require("../../services/upload.service");
var location_1 = require('@angular/common')
var AdminCourseViewComponent = (function () {
    function AdminCourseViewComponent(_courseService, _activatedRoute, authService, _uploadService, config, location) {
        this._courseService = _courseService;
        this._activatedRoute = _activatedRoute;
        this.authService = authService;
        this._uploadService = _uploadService;
        this.config = config;
        this.course = {
            name: null,
            description: null,
            educationLevel: {
                name: null
            },
            speciality: {
                name: null
            },
            teacherFunction: {
                name: null
            },
            link: null,
            image: null
        };
        this.ready = false;
        this.controller = "/course";
        this.url = config.apiEndPoint + this.controller;
        this.token = authService.getToken();
        this.urlResource = config.apiEndPointUploads;
        this.location = location;
    }
    AdminCourseViewComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.loading = true;
        //noinspection TypeScriptUnresolvedFunction
        jQuery("body").tooltip({
            selector: '[data-toggle="tooltip"]'
        });
        this._activatedRoute.params.subscribe(function (params) {
            _this.courseId = params['id'];
            _this._courseService.view(_this.courseId).subscribe(function (response) {
                _this.course = response;
                _this.loading = false;
            });
        });
    };
    AdminCourseViewComponent.prototype.loadFile = function (event) {
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
    AdminCourseViewComponent.prototype.upload = function () {
        var _this = this;
        var _url = this.url + "/upload-image/" + this.courseId;
        this._uploadService.makeFileRequest(this.token, _url, ['image'], this.filesToUpload).then(function (result) {
            _this.resultUpload = result;
        }, function (error) {
            console.log(error);
        });
    };
    AdminCourseViewComponent.prototype.toGoBack = function () {
        var _this = this;
        _this.location.back();
    };    
    AdminCourseViewComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/course/view.html',
            providers: [course_service_1.CourseService, upload_service_1.UploadService, location_1.Location]
        }),
        __param(4, core_1.Inject(app_config_1.APP_CONFIG)),
        __metadata("design:paramtypes", [course_service_1.CourseService,
            router_1.ActivatedRoute,
            auth_service_1.AuthService,
            upload_service_1.UploadService, 
            Object,
            location_1.Location])
    ], AdminCourseViewComponent);
    return AdminCourseViewComponent;
}());
exports.AdminCourseViewComponent = AdminCourseViewComponent;
//# sourceMappingURL=admin-course-view.component.js.map