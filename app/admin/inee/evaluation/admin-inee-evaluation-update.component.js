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
var education_level_service_1 = require("../../../services/education-level.service");
var teacher_function_service_1 = require("../../../services/teacher-function.service");
var inee_service_1 = require("../../../services/inee.service");
var notifications_service_1 = require("angular2-notifications/src/notifications.service");
var inee_evaluation_1 = require("../../../models/inee-evaluation");
var router_1 = require("@angular/router");
var AdminIneeEvaluationUpdateComponent = (function () {
    function AdminIneeEvaluationUpdateComponent(_educationLevelService, _teacherFunctionService, _ineeService, _notificationsService, _activatedRoute) {
        this._educationLevelService = _educationLevelService;
        this._teacherFunctionService = _teacherFunctionService;
        this._ineeService = _ineeService;
        this._notificationsService = _notificationsService;
        this._activatedRoute = _activatedRoute;
        this.model = new inee_evaluation_1.IneeEvaluation();
        this.education_level_list = [];
        this.teacher_function_list = [];
        this.dimension_list = [];
        this.parameter_list = [];
        this.indicator_list = [];
        this.questionsCollection = [];
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
    }
    AdminIneeEvaluationUpdateComponent.prototype.ngOnInit = function () {
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
        this._activatedRoute.params.subscribe(function (params) {
            _this.questionId = params['id'];
            _this._ineeService.viewQuestion(_this.questionId).subscribe(function (response) {
                _this.model = response;
                _this.showDimensions(response.teacher_function);
                _this.showParameters(response.dimension);
                _this.showIndicators(response.parameter);
                _this.model.answerCollection = response.answers;
            });
        });
    };
    AdminIneeEvaluationUpdateComponent.prototype.onSubmit = function () {
        var _this = this;
        if (!this.model.correctAnswer) {
            return;
        }
        jQuery("#questionFormButton").button('loading');
        this._ineeService.updateQuestion(this.model, this.questionId).subscribe(function (response) {
            jQuery("#questionFormButton").button('reset');
            if (response.status == 'success') {
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
    /**
     * Fill select dimensions
     * @param teacher_function
     */
    AdminIneeEvaluationUpdateComponent.prototype.showDimensions = function (teacher_function) {
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
    AdminIneeEvaluationUpdateComponent.prototype.showParameters = function (dimensionId) {
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
    AdminIneeEvaluationUpdateComponent.prototype.showIndicators = function (parameterId) {
        var _this = this;
        this.indicator_list = [];
        this._ineeService.getListIndicator(parameterId).subscribe(function (response) {
            _this.indicator_list = response;
        });
    };
    /**
     * Add answer to collection
     */
    AdminIneeEvaluationUpdateComponent.prototype.addAnswer = function () {
        this.model.answerCollection.push({ id: null, title: this.model.answer });
        this.model.answer = null;
    };
    /**
     * Delete answer from collection
     * @param name
     */
    AdminIneeEvaluationUpdateComponent.prototype.deleteAnswer = function (name) {
        var index = this.model.answerCollection.indexOf(name);
        this.model.answerCollection[index]['removed'] = true;
        if (!this.model.answerCollection[index]['id']) {
            this.model.answerCollection.splice(index, 1);
        }
    };
    AdminIneeEvaluationUpdateComponent.prototype.onChange = function (event) {
        if (event.length > 0) {
            this.selector.removeClass('custom-ckeditor-invalid');
            this.selector.addClass('custom-ckeditor-valid');
        }
        else {
            this.selector.removeClass('custom-ckeditor-valid');
            this.selector.addClass('custom-ckeditor-invalid');
        }
    };
    AdminIneeEvaluationUpdateComponent.prototype.onChangeArg = function (event) {
        if (event.length > 0) {
            this.selectorArg.removeClass('custom-ckeditor-invalid');
            this.selectorArg.addClass('custom-ckeditor-valid');
        }
        else {
            this.selectorArg.removeClass('custom-ckeditor-valid');
            this.selectorArg.addClass('custom-ckeditor-invalid');
        }
    };
    AdminIneeEvaluationUpdateComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/inee/evaluation/update.html',
            providers: [education_level_service_1.EducationLevelService, teacher_function_service_1.TeacherFunctionService, inee_service_1.IneeService, notifications_service_1.NotificationsService]
        }), 
        __metadata('design:paramtypes', [education_level_service_1.EducationLevelService, teacher_function_service_1.TeacherFunctionService, inee_service_1.IneeService, notifications_service_1.NotificationsService, router_1.ActivatedRoute])
    ], AdminIneeEvaluationUpdateComponent);
    return AdminIneeEvaluationUpdateComponent;
}());
exports.AdminIneeEvaluationUpdateComponent = AdminIneeEvaluationUpdateComponent;
//# sourceMappingURL=admin-inee-evaluation-update.component.js.map