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
var course_service_1 = require("../services/course.service");
var app_config_1 = require("../app.config");
var SuggestedCourseComponent = (function () {
    function SuggestedCourseComponent(_courseService, config) {
        this._courseService = _courseService;
        this.config = config;
        this.courses = [];
        this.urlResource = config.apiEndPointUploads;
    }
    SuggestedCourseComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.loading = true;
        jQuery("#main-navigation").find(">ul>li.active").removeClass("active");
        jQuery("#menu-suggested-courses").addClass("active");
        this._courseService.suggestions().subscribe(function (response) {
            _this.courses = response;
            _this.loading = false;
        }, function (error) {
            _this.loading = false;
            console.log("Error al cargar cursos");
        });
    };
    SuggestedCourseComponent = __decorate([
        core_1.Component({
            selector: 'suggested-course',
            templateUrl: 'app/views/suggested-course.html',
            providers: [course_service_1.CourseService]
        }),
        __param(1, core_1.Inject(app_config_1.APP_CONFIG)), 
        __metadata('design:paramtypes', [course_service_1.CourseService, Object])
    ], SuggestedCourseComponent);
    return SuggestedCourseComponent;
}());
exports.SuggestedCourseComponent = SuggestedCourseComponent;
//# sourceMappingURL=suggested-course.component.js.map