"use strict";
var __extends = (this && this.__extends) || (function () {
    var extendStatics = Object.setPrototypeOf ||
            ({__proto__: []} instanceof Array && function (d, b) {
                d.__proto__ = b;
            }) ||
            function (d, b) {
                for (var p in b)
                    if (b.hasOwnProperty(p))
                        d[p] = b[p];
            };
    return function (d, b) {
        extendStatics(d, b);
        function __() {
            this.constructor = d;
        }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function")
        r = Reflect.decorate(decorators, target, key, desc);
    else
        for (var i = decorators.length - 1; i >= 0; i--)
            if (d = decorators[i])
                r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function")
        return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", {value: true});
var core_1 = require("@angular/core");
var teacher_service_1 = require("../../services/teacher.service");
var router_1 = require("@angular/router");
var helper_1 = require("../../helpers/helper");
var skill_century_teacher_answer_century_service_1 = require("../../services/skill-century-teacher-answer-century.service");
var evaluation_inee_service_1 = require("../../services/evaluation-inee.service");
var notifications_service_1 = require("angular2-notifications/src/notifications.service");
var AdminTeacherComponent = (function (_super) {
    __extends(AdminTeacherComponent, _super);
    function AdminTeacherComponent(teacherService, _skillCenturyTeacherAnswerCenturyService, activatedRoute, evaluationIneeService, _notificationsService) {
        var _this = _super.call(this) || this;
        _this.teacherService = teacherService;
        _this._skillCenturyTeacherAnswerCenturyService = _skillCenturyTeacherAnswerCenturyService;
        _this.activatedRoute = activatedRoute;
        _this.evaluationIneeService = evaluationIneeService;
        // Página anterior
        _this.pagePrev = 1;
        // Siguiente página
        _this.pageNext = 1;
        _this.directoryUploadsEvaluationXXI = "evaluation_xxi_teacher_";
        _this._notificationsService = _notificationsService;
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
        return _this;
    }
    AdminTeacherComponent.prototype.ngOnInit = function () {
        var _this = this;
        //noinspection TypeScriptUnresolvedFunction
        jQuery("body").tooltip({
            selector: '[data-toggle="tooltip"]'
        });
        this.loading = true;
        this.activatedRoute.params.subscribe(function (params) {
            _this.page = params['page'];
            if (!_this.page) {
                _this.page = 1;
            }
            _this.teacherService.findAll(_this.page).subscribe(function (response) {
                _this.teachersList = response.data;
                _this.pages = [];
                //noinspection TypeScriptUnresolvedVariable
                for (var i = 0; i < response.total_pages; i++) {
                    _this.pages.push(i);
                }
                _this.pagePrev = (_this.page > 1) ? (parseInt(_this.page) - 1) : _this.page;
                //noinspection TypeScriptUnresolvedVariable
                _this.pageNext = (_this.page < response.total_pages) ? (parseInt(_this.page) + 1) : _this.page;
                _this.loading = false;
            }, function (error) {
                console.log(error);
            });
        });
        jQuery("#main-navigation").find(">ul>li.active").removeClass("active");
        jQuery("#menu-teacher").addClass("active");
    };
    AdminTeacherComponent.prototype.exportResultData = function (userId) {
        jQuery("#teacher_" + userId).removeClass("fa-file-excel-o");
        jQuery("#teacher_" + userId).addClass("fa-spin fa-spinner");
        this._skillCenturyTeacherAnswerCenturyService
                .exportResultToExcel(userId)
                .subscribe(function (response) {
                    if (response.status == 'success') {
                        window.open(response.url, '_blank');
                    }
                    jQuery("#teacher_" + userId).removeClass("fa-spin fa-spinner");
                    jQuery("#teacher_" + userId).addClass("fa-file-excel-o");
                }, function (error) {
                    jQuery("#teacher_" + userId).removeClass("fa-spin fa-spinner");
                    jQuery("#teacher_" + userId).addClass("fa-warning");
                });
    };
    AdminTeacherComponent.prototype.exportResultDataToPDF = function (userId) {
        var _this = this;
        jQuery("#teacher_pdf_" + userId).removeClass("fa-file-pdf-o");
        jQuery("#teacher_pdf_" + userId).addClass("fa-spin fa-spinner");
        this._skillCenturyTeacherAnswerCenturyService.teacherId = userId;
        this._skillCenturyTeacherAnswerCenturyService
                .exportResultToPDF()
                .subscribe(function (response) {
                    if (response.status == 'success') {
                        window.open(_this._skillCenturyTeacherAnswerCenturyService.apiEndPoint + _this.directoryUploadsEvaluationXXI
                                + response.userId + "/result.pdf", '_blank');
                    }
                    jQuery("#teacher_pdf_" + userId).removeClass("fa-spin fa-spinner");
                    jQuery("#teacher_pdf_" + userId).addClass("fa-file-pdf-o");
                }, function (error) {
                    jQuery("#teacher_pdf_" + userId).removeClass("fa-spin fa-spinner");
                    jQuery("#teacher_pdf_" + userId).addClass("fa-warning");
                });
    };
    /**
     * Export results of evaluation inee to excel
     * @param teacherId
     */
    AdminTeacherComponent.prototype.exportResultIneeDataToExcel = function (teacherId) {
        var $teacher_excel_inee = jQuery("#teacher_inee_" + teacherId);
        $teacher_excel_inee.removeClass("fa-file-excel-o");
        $teacher_excel_inee.addClass("fa-spin fa-spinner");
        this.evaluationIneeService.exportToExcel(teacherId).subscribe(function (response) {
            if (response.status == 'success') {
                window.open(response.url, '_blank');
            }
            $teacher_excel_inee.removeClass("fa-spin fa-spinner");
            $teacher_excel_inee.addClass("fa-file-excel-o");
        }, function (error) {
            $teacher_excel_inee.removeClass("fa-spin fa-spinner");
            $teacher_excel_inee.addClass("fa-warning");
        });
    };
    /**
     * Export results of evaluation inee to PDF
     * @param teacherId
     */
    AdminTeacherComponent.prototype.exportResultIneeDataToPDF = function (teacherId) {
        var _this = this;
        var $teacher_pdf_inee = jQuery("#teacher_pdf_inee_" + teacherId);
        $teacher_pdf_inee.removeClass("fa-file-pdf-o");
        $teacher_pdf_inee.addClass("fa-spin fa-spinner");
        this.evaluationIneeService.exportToPDF(teacherId).subscribe(function (response) {
            if (response.status == 'success') {
                window.open(_this._skillCenturyTeacherAnswerCenturyService.apiEndPoint + _this.directoryUploadsEvaluationXXI
                        + response.userId + "/result_inee.pdf", '_blank');
            }
            $teacher_pdf_inee.removeClass("fa-spin fa-spinner");
            $teacher_pdf_inee.addClass("fa-file-pdf-o");
        }, function (error) {
            $teacher_pdf_inee.removeClass("fa-spin fa-spinner");
            $teacher_pdf_inee.addClass("fa-warning");
        });
    };
	/**
     * Funcion borrado de teacher, evaluaciones siglos xxi y evaluation diagnostica
     * @param teacherId
	 * @param opcion valores de opcion 
	 *	1 => Elimiar al Profesor
	 *	2 => Elimiar al Evaluación Siglo XXI
	 *	3 => Elimiar al Evaluación Diagnostica
     */
    AdminTeacherComponent.prototype.delete = function (teacherId,opcion) {
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
                        _this.teacherService.delete(teacherId,opcion).subscribe(function (response) {
                            if (response.status === 200) {
                                _this._notificationsService.success(response.title, response.message);
                                _this.loading = true;

                                _this.teacherService.findAll(_this.page).subscribe(function (response) {
                                    _this.teachersList = response.data;
                                    _this.pages = [];
                                    //noinspection TypeScriptUnresolvedVariable
                                    for (var i = 0; i < response.total_pages; i++) {
                                        _this.pages.push(i);
                                    }
                                    _this.pagePrev = (_this.page > 1) ? (parseInt(_this.page) - 1) : _this.page;
                                    //noinspection TypeScriptUnresolvedVariable
                                    _this.pageNext = (_this.page < response.total_pages) ? (parseInt(_this.page) + 1) : _this.page;
                                    _this.loading = false;
                                }, function (error) {
                                    _this._notificationsService.error("Error!!!", "No se logro cargar el listado");
                                });
                                jQuery("#main-navigation").find(">ul>li.active").removeClass("active");
                                jQuery("#menu-course").addClass("active");
                            } else {
                                _this._notificationsService.error(response.title, response.message);
                            }
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
    };

    AdminTeacherComponent.prototype.goSearch = function () {
        var _this = this;
        this.loading = true;
        var fullname = jQuery("#fullname").val();
        this.activatedRoute.params.subscribe(function (params) {
            _this.page = params['page'];
            if (!_this.page) {
                _this.page = 1;
            }
            _this.teacherService.findAllFullText(_this.page, fullname).subscribe(function (response) {
                _this.teachersList = response.data;
                _this.pages = [];
                //noinspection TypeScriptUnresolvedVariable
                for (var i = 0; i < response.total_pages; i++) {
                    _this.pages.push(i);
                }
                _this.pagePrev = (_this.page > 1) ? (parseInt(_this.page) - 1) : _this.page;
                //noinspection TypeScriptUnresolvedVariable
                _this.pageNext = (_this.page < response.total_pages) ? (parseInt(_this.page) + 1) : _this.page;
                _this.loading = false;
            }, function (error) {
                _this._notificationsService.error("Error!!!", "No se logro cargar el listado");
            });
        });
        jQuery("#main-navigation").find(">ul>li.active").removeClass("active");
        jQuery("#menu-teacher").addClass("active");
    };
    
    AdminTeacherComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/teacher/index.html',
            providers: [teacher_service_1.TeacherService, skill_century_teacher_answer_century_service_1.SkillCenturyTeacherAnswerCenturyService,
                evaluation_inee_service_1.EvaluationIneeService, notifications_service_1.NotificationsService]
        }),
        __metadata("design:paramtypes", [teacher_service_1.TeacherService,
            skill_century_teacher_answer_century_service_1.SkillCenturyTeacherAnswerCenturyService,
            router_1.ActivatedRoute,
            evaluation_inee_service_1.EvaluationIneeService,
            notifications_service_1.NotificationsService])
    ], AdminTeacherComponent);
    return AdminTeacherComponent;
}(helper_1.Helper));
exports.AdminTeacherComponent = AdminTeacherComponent;
//# sourceMappingURL=admin-teacher.component.js.map