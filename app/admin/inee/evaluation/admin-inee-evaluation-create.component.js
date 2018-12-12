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
var inee_service_1 = require("../../../services/inee.service");
var teacher_function_service_1 = require("../../../services/teacher-function.service");
var education_level_service_1 = require("../../../services/education-level.service");
var inee_evaluation_1 = require("../../../models/inee-evaluation");
var angular2_notifications_1 = require("angular2-notifications");
var AdminIneeEvaluationCreateComponent = (function () {
    function AdminIneeEvaluationCreateComponent(_educationLevelService, _teacherFunctionService, _ineeService, _notificationsService) {
        this._educationLevelService = _educationLevelService;
        this._teacherFunctionService = _teacherFunctionService;
        this._ineeService = _ineeService;
        this._notificationsService = _notificationsService;
        this.model = new inee_evaluation_1.IneeEvaluation();
        this.education_level_list = [];
        this.teacher_function_list = [];
        this.dimension_list = [];
        this.parameter_list = [];
        this.indicator_list = [];
        this.options = {
            timeOut: 3000,
            lastOnBottom: true,
            clickToClose: true,
            maxLength: 0,
            maxStack: 7,
            showProgressBar: true,
            pauseOnHover: true,
            preventDuplicates: false,
            preventLastDuplicates: 'visible',
            rtl: false,
            animate: 'scale',
            position: ['left', 'bottom']
        };
        this.questionsCollection = [];
        this.model.answerCollection = [];
    }
    AdminIneeEvaluationCreateComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.selector = jQuery("#validator-dimension-ckeditor");
        this.selectorArg = jQuery("#validator-argumentation-ckeditor");
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
    /**
     * Reset form values per default
     */
    AdminIneeEvaluationCreateComponent.prototype.resetForm = function () {
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
    AdminIneeEvaluationCreateComponent.prototype.showDimensions = function (teacher_function) {
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
    AdminIneeEvaluationCreateComponent.prototype.showParameters = function (dimensionId) {
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
    AdminIneeEvaluationCreateComponent.prototype.showIndicators = function (parameterId) {
        var _this = this;
        this.indicator_list = [];
        this._ineeService.getListIndicator(parameterId).subscribe(function (response) {
            _this.indicator_list = response;
        });
    };
    /**
     * Add answer from collection
     */
    AdminIneeEvaluationCreateComponent.prototype.addAnswer = function () {
        this.model.answerCollection.push(this.model.answer);
        this.model.answer = null;
		console.log(this.model);
    };
    /**
     * Delete answer from collection
     * @param name
     */
    AdminIneeEvaluationCreateComponent.prototype.deleteAnswer = function (name) {
        var index = this.model.answerCollection.indexOf(name);
        this.model.answerCollection.splice(index, 1);
    };
    AdminIneeEvaluationCreateComponent.prototype.onSubmit = function () {
		console.log((this.model));
        var _this = this;
        if (!this.model.correctAnswer) {
            return;
        }
        jQuery("#questionFormButton").button('loading');
        this._ineeService.createQuestion(this.model).subscribe(function (response) {
            jQuery("#questionFormButton").button('reset');
            if (response.status == 'success') {
                _this.questionsCollection.push(response.data);
                _this.model.reagent_base = null;
                _this.model.argumentation = null;
                _this.model.answerCollection = [];
                _this.model.correctAnswer = null;
                _this._notificationsService.success(response.title, response.message);
            }
            else {
                _this._notificationsService.error(response.title, response.message);
            }
        }, function (error) {
            jQuery("#questionFormButton").button('reset');
            _this._notificationsService.error("Error", "Ocurrió un error al guardar los datos");
        });
    };
    AdminIneeEvaluationCreateComponent.prototype.onChange = function (event) {
        if (event.length > 0) {
            this.selector.removeClass('custom-ckeditor-invalid');
            this.selector.addClass('custom-ckeditor-valid');
        }
        else {
            this.selector.removeClass('custom-ckeditor-valid');
            this.selector.addClass('custom-ckeditor-invalid');
        }
    };
    AdminIneeEvaluationCreateComponent.prototype.onChangeArg = function (event) {
        if (event.length > 0) {
            this.selectorArg.removeClass('custom-ckeditor-invalid');
            this.selectorArg.addClass('custom-ckeditor-valid');
        }
        else {
            this.selectorArg.removeClass('custom-ckeditor-valid');
            this.selectorArg.addClass('custom-ckeditor-invalid');
        }
    };
    AdminIneeEvaluationCreateComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/inee/evaluation/create.html',
            providers: [education_level_service_1.EducationLevelService, teacher_function_service_1.TeacherFunctionService, inee_service_1.IneeService, angular2_notifications_1.NotificationsService]
        }), 
        __metadata('design:paramtypes', [education_level_service_1.EducationLevelService, teacher_function_service_1.TeacherFunctionService, inee_service_1.IneeService, angular2_notifications_1.NotificationsService])
    ], AdminIneeEvaluationCreateComponent);
    return AdminIneeEvaluationCreateComponent;
}());
exports.AdminIneeEvaluationCreateComponent = AdminIneeEvaluationCreateComponent;
//# sourceMappingURL=admin-inee-evaluation-create.component.js.map