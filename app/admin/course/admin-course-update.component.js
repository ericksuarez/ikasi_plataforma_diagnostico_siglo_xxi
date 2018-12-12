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
var course_1 = require("../../models/course");
var course_service_1 = require("../../services/course.service");
var router_1 = require("@angular/router");
var specialty_service_1 = require("../../services/specialty.service");
var education_level_service_1 = require("../../services/education-level.service");
var teacher_function_service_1 = require("../../services/teacher-function.service");
var angular2_notifications_1 = require("angular2-notifications");
var skill_century_service_1 = require("../../services/skill-century.service");
var skill_century_area_service_1 = require("../../services/skill-century-area.service");
var inee_service_1 = require("../../services/inee.service");
var location_1 = require('@angular/common')
var AdminCourseUpdateComponent = (function () {
    function AdminCourseUpdateComponent(_courseService, _specialtyService, _educationLevelService, _teacherFunctionService, _notificationsService, _activatedRoute, _skillCenturyService, _skillCenturyAreaService, _router, _ineeService ,location) {
        this._courseService = _courseService;
        this._specialtyService = _specialtyService;
        this._educationLevelService = _educationLevelService;
        this._teacherFunctionService = _teacherFunctionService;
        this._notificationsService = _notificationsService;
        this._activatedRoute = _activatedRoute;
        this._skillCenturyService = _skillCenturyService;
        this._skillCenturyAreaService = _skillCenturyAreaService;
        this._router = _router;
        this._ineeService = _ineeService;
        this.model = new course_1.Course();
        this.title = 'Actualizar';
        this.suggestion_century = 1;
        this.suggestion_inee = 2;
        this.areas = [];
        this.optionsChecked = [];
		this.updStateOptionsChecked = [];
        this.dimension_list = [];
        this.location = location;
    }
    AdminCourseUpdateComponent.prototype.ngOnInit = function () {
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
        this._activatedRoute.params.subscribe(function (params) {
            _this.courseId = params['id'];
            _this._courseService.view(_this.courseId).subscribe(function (response) {
				console.log(response);
                _this.model = response;
                _this.model.area_century = JSON.parse(response.areaCenturyIds);
                _this.model.teacher_function = response.teacherFunction.id;
                _this.model.education_level = response.educationLevel.id;
                _this.model.specialty = response.speciality.id;
                if (response.typeSuggestion == _this.suggestion_century) {
                    jQuery('#suggestion_century').trigger("click");
                }
                else if (response.typeSuggestion == _this.suggestion_inee) {
                    jQuery('#suggestion_inee').trigger("click");
                }
                // this.model.type_suggestion = parseInt(response.typeSuggestion);
                if (response.skillCentury) {
                    _this.model.skill_century = response.skillCentury.id;
                    _this.showAreas(response.skillCentury.id, true);
                }
                if (response.dimension) {
                    _this.showDimensions(_this.model.teacher_function, true, response.dimension.id);
                }
				if (response.state) {
					var states = JSON.parse(response.state);
					states.forEach(function(element) {
					  console.log(element.toLowerCase());
					  jQuery('#' + element.toLowerCase()).trigger("click");
					});
                }
            });
        });
    };
    AdminCourseUpdateComponent.prototype.onSubmit = function () {
        var _this = this;
        //noinspection TypeScriptValidateJSTypes
        jQuery("#courseFormButton").button('loading');
        this.model.area_century = this.optionsChecked;
		this.model.eva_states = this.updStateOptionsChecked;
        this._courseService.update(this.model, this.courseId).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#courseFormButton").button('reset');
            if (response.status == 'success') {
                //noinspection JSIgnoredPromiseFromCall
                _this._router.navigate(['/admin/course/view', _this.courseId]);
            }
            else {
                _this._notificationsService.error(response.title, response.message);
            }
        }, function (error) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#courseFormButton").button('reset');
            _this._notificationsService.error("Error", "Ocurrió un error al actualizar el curso");
        });
    };
    AdminCourseUpdateComponent.prototype.onChange = function (event) {
        if (event.length > 0) {
            this.selector.removeClass('custom-ckeditor-invalid');
            this.selector.addClass('custom-ckeditor-valid');
        }
        else {
            this.selector.removeClass('custom-ckeditor-valid');
            this.selector.addClass('custom-ckeditor-invalid');
        }
    };
    AdminCourseUpdateComponent.prototype.showAreas = function (skillId, onLoad) {
        var _this = this;
        if (onLoad === void 0) { onLoad = false; }
        this.areas = [];
        this.optionsChecked = [];
        this._skillCenturyAreaService.findAll(skillId, -1).subscribe(function (response) {
            _this.areas = response.data;
            if (onLoad) {
                setTimeout(function () { return _this.updateSelectedCheckbox(); }, 500);
            }
        }, function (error) {
            console.log(error);
        });
    };
    AdminCourseUpdateComponent.prototype.updateSelectedCheckbox = function () {
        for (var _i = 0, _a = this.model.area_century; _i < _a.length; _i++) {
            var _selectedArea = _a[_i];
            for (var _b = 0, _c = this.areas; _b < _c.length; _b++) {
                var area = _c[_b];
                if (_selectedArea == area.id) {
                    jQuery("#area-" + area.id).trigger("click");
                }
            }
        }
    };
    AdminCourseUpdateComponent.prototype.updateSelectedOptions  = function (area, event) {
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
     * @param onLoad
     * @param dimensionId
     */
    AdminCourseUpdateComponent.prototype.showDimensions = function (teacher_function, onLoad, dimensionId) {
        var _this = this;
        if (onLoad === void 0) { onLoad = false; }
        if (dimensionId === void 0) { dimensionId = null; }
        if (!teacher_function) {
            return;
        }
        this.dimension_list = [];
        this._ineeService.getList(this.model.education_level, teacher_function).subscribe(function (response) {
            _this.dimension_list = response;
            if (onLoad) {
                setTimeout(function () {
                    jQuery('#dim-' + dimensionId).trigger("click");
                }, 1000);
            }
        });
    };
	AdminCourseUpdateComponent.prototype.updStateSelectedOptions = function (state, event) {
		console.log(state);
        if (event.target.checked) {
            this.updStateOptionsChecked.push(state);
        }
        else if (!event.target.checked) {
            var index = this.updStateOptionsChecked.indexOf(state);
            this.updStateOptionsChecked.splice(index, 1);
        }
    };
	
    AdminCourseUpdateComponent.prototype.toGoBack = function () {
        var _this = this;
        _this.location.back();
    };
    AdminCourseUpdateComponent = __decorate([
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
            router_1.ActivatedRoute,
            skill_century_service_1.SkillCenturyService,
            skill_century_area_service_1.SkillCenturyAreaService,
            router_1.Router,
            inee_service_1.IneeService,
            location_1.Location])
    ], AdminCourseUpdateComponent);
    return AdminCourseUpdateComponent;
}());
exports.AdminCourseUpdateComponent = AdminCourseUpdateComponent;
//# sourceMappingURL=admin-course-update.component.js.map