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
var AdminIneeEvaluationComponent = (function () {
    function AdminIneeEvaluationComponent(_educationLevelService, _teacherFunctionService, _ineeService, _notificationsService) {
        this._educationLevelService = _educationLevelService;
        this._teacherFunctionService = _teacherFunctionService;
        this._ineeService = _ineeService;
        this._notificationsService = _notificationsService;
        this.questions = [];
        this.model = {
            education_level: null,
            teacher_function: null
        };
        this.education_level_list = [];
        this.teacher_function_list = [];
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
    AdminIneeEvaluationComponent.prototype.ngOnInit = function () {
        var _this = this;
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
    AdminIneeEvaluationComponent.prototype.onSubmit = function () {
        var _this = this;
        //noinspection TypeScriptValidateJSTypes
        jQuery("#evaluationButton").button('loading');
        this._ineeService.filterEvaluation(this.model).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#evaluationButton").button('reset');
            _this.questions = response;
        }, function (error) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#evaluationButton").button('reset');
        });
    };
	AdminIneeEvaluationComponent.prototype.deleteQ = function (id) {
        var _this = this;

        $.confirm({
            icon: 'fa fa-warning',
            closeIcon: true,
            title: '¡Confirmación!',
            content: '¿Está seguro que desea eliminar este elemento de la lista?',
            type: 'red',
            typeAnimated: true,
            autoClose: 'close|8000',
            buttons: {
                acptar: {
                    text: 'Aceptar',
                    btnClass: 'btn-green',
                    action: function () {
                        _this._ineeService.deleteQuestion(id).subscribe(function (response) {
							if (response.status == 'success') {
								_this._notificationsService.success(response.title, response.message);
								jQuery("#question-" + id).remove();
								
								_this._educationLevelService.getList().subscribe(function (response) {
									_this.education_level_list = response;
								}, function (error) {
									console.log("Error al cargar los niveles");
								});
								_this._teacherFunctionService.getList().subscribe(function (response) {
									_this.teacher_function_list = response;
								}, function (error) {
									console.log("Error al cargar las funciones");
								});
							}
							else {
								_this._notificationsService.error(response.title, response.message);
							}
						}, function (error) {
							_this._notificationsService.error(response.title, response.message);
						});
                    }
                },
                close: {
                    text: 'Cancelar',
                    btnClass: 'btn-red',
                    action: function () {
                    }
                }
            }
        });
    }
    AdminIneeEvaluationComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/inee/evaluation/index.html',
            providers: [education_level_service_1.EducationLevelService, teacher_function_service_1.TeacherFunctionService, inee_service_1.IneeService, notifications_service_1.NotificationsService]
        }), 
        __metadata('design:paramtypes', [education_level_service_1.EducationLevelService, teacher_function_service_1.TeacherFunctionService, inee_service_1.IneeService, notifications_service_1.NotificationsService])
    ], AdminIneeEvaluationComponent);
    return AdminIneeEvaluationComponent;
}());
exports.AdminIneeEvaluationComponent = AdminIneeEvaluationComponent;
//# sourceMappingURL=admin-inee-evaluation.component.js.map