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
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = require("@angular/core");
var location_1 = require('@angular/common')
var course_service_1 = require("../../services/course.service");
var course_1 = require("../../models/course");
var specialty_service_1 = require("../../services/specialty.service");
var education_level_service_1 = require("../../services/education-level.service");
var teacher_function_service_1 = require("../../services/teacher-function.service");
var angular2_notifications_1 = require("angular2-notifications");
var router_1 = require("@angular/router");
var skill_century_service_1 = require("../../services/skill-century.service");
var skill_century_area_service_1 = require("../../services/skill-century-area.service");
var inee_service_1 = require("../../services/inee.service");
var AdminCourseCreateComponent = (function () {
    function AdminCourseCreateComponent(_courseService, _specialtyService, _educationLevelService, _teacherFunctionService, _notificationsService, _router, _skillCenturyService, _skillCenturyAreaService, _ineeService ,location) {
        this._courseService = _courseService;
        this._specialtyService = _specialtyService;
        this._educationLevelService = _educationLevelService;
        this._teacherFunctionService = _teacherFunctionService;
        this._notificationsService = _notificationsService;
        this._router = _router;
        this._skillCenturyService = _skillCenturyService;
        this._skillCenturyAreaService = _skillCenturyAreaService;
        this._ineeService = _ineeService;
        this.model = new course_1.Course();
        this.title = 'Nuevo';
        this.suggestion_century = 1;
        this.suggestion_inee = 2;
        this.areas = [];
        this.optionsChecked = [];
		this.updStateOptionsChecked = [];
        this.dimension_list = [];
        this.location = location;
    }
    AdminCourseCreateComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.selector = jQuery("#validator-dimension-ckeditor");
        this._specialtyService.getList().subscribe(function (response) {
            _this.specialty_list = response;
        }, function (error) {
            console.log("Error al cargar las especialidades");
        });
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
        this._skillCenturyService.findAll(-1).subscribe(function (response) {
            _this.skills = response.data;
        }, function (error) {
            console.log(error);
        });
    };
    AdminCourseCreateComponent.prototype.onSubmit = function () {
        var _this = this;
        //noinspection TypeScriptValidateJSTypes
        jQuery("#courseFormButton").button('loading');
        this.model.area_century = this.optionsChecked;
		this.model.eva_states = this.updStateOptionsChecked;
		console.log(this.model);
        this._courseService.create(this.model).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#courseFormButton").button('reset');
            if (response.status == 'success') {
                _this._router.navigate(['/admin/course/view', response.id]);
            }
            else {
                _this._notificationsService.error(response.title, response.message);
            }
        }, function (error) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#courseFormButton").button('reset');
            _this._notificationsService.error("Error", "Ocurrió un error al guardar los datos");
        });
    };
    //noinspection JSUnusedGlobalSymbols
    AdminCourseCreateComponent.prototype.onChange = function (event) {
        if (event.length > 0) {
            this.selector.removeClass('custom-ckeditor-invalid');
            this.selector.addClass('custom-ckeditor-valid');
        }
        else {
            this.selector.removeClass('custom-ckeditor-valid');
            this.selector.addClass('custom-ckeditor-invalid');
        }
    };
    AdminCourseCreateComponent.prototype.showAreas = function (skillId) {
        var _this = this;
        this.areas = [];
        this.optionsChecked = [];
        this._skillCenturyAreaService.findAll(skillId, -1).subscribe(function (response) {
            _this.areas = response.data;
        }, function (error) {
            console.log(error);
        });
    };
    AdminCourseCreateComponent.prototype.updateSelectedOptions = function (area, event) {
        if (event.target.checked) {
            this.optionsChecked.push(area.id);
        }
        else if (!event.target.checked) {
            var index = this.optionsChecked.indexOf(area.id);
            this.optionsChecked.splice(index, 1);
        }
    };
    /**
     * Fill select dimensions
     * @param teacher_function
     */
    AdminCourseCreateComponent.prototype.showDimensions = function (teacher_function) {
        var _this = this;
        if (!teacher_function) {
            return;
        }
        this.dimension_list = [];
        this._ineeService.getList(this.model.education_level, teacher_function).subscribe(function (response) {
            _this.dimension_list = response;
            console.log(response);
        });
    };
    
	AdminCourseCreateComponent.prototype.updStateSelectedOptions = function (state, event) {
		//console.log(state);
        if (event.target.checked) {
            this.updStateOptionsChecked.push(state);
        }
        else if (!event.target.checked) {
            var index = this.updStateOptionsChecked.indexOf(state);
            this.updStateOptionsChecked.splice(index, 1);
        }
    };
	AdminCourseCreateComponent.prototype.toGoBack = function () {
        var _this = this;
        _this.location.back();
    };
    AdminCourseCreateComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/course/create.html',
            providers: [course_service_1.CourseService, 
                        specialty_service_1.SpecialtyService, 
                        education_level_service_1.EducationLevelService, 
                        teacher_function_service_1.TeacherFunctionService, 
                        skill_century_service_1.SkillCenturyService, 
                        skill_century_area_service_1.SkillCenturyAreaService, 
                        angular2_notifications_1.NotificationsService, 
                        inee_service_1.IneeService, 
                        location_1.Location]
        }),
        __metadata("design:paramtypes", [course_service_1.CourseService,
            specialty_service_1.SpecialtyService,
            education_level_service_1.EducationLevelService,
            teacher_function_service_1.TeacherFunctionService,
            angular2_notifications_1.NotificationsService,
            router_1.Router,
            skill_century_service_1.SkillCenturyService,
            skill_century_area_service_1.SkillCenturyAreaService,
            inee_service_1.IneeService,
            location_1.Location])
    ], AdminCourseCreateComponent);
    return AdminCourseCreateComponent;
}());
exports.AdminCourseCreateComponent = AdminCourseCreateComponent;
//# sourceMappingURL=admin-course-create.component.js.map