"use strict";
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
var skill_century_service_1 = require("../../services/skill-century.service");
var skill_century_area_service_1 = require("../../services/skill-century-area.service");
var skill_century_teacher_answer_century_service_1 = require("../../services/skill-century-teacher-answer-century.service");
var DataResultEvaluationXII_1 = require("../../models/DataResultEvaluationXII");
var auth_service_1 = require("../../services/auth.service");
var teacher_service_1 = require("../../services/teacher.service");
var notifications_service_1 = require("angular2-notifications/src/notifications.service");
var ApplyCenturyEvaluation = (function () {
    function ApplyCenturyEvaluation(_skillCenturyService, _skillCenturyAreaService, _skillCenturyTeacherAnswerCenturyService, _authService, teacherService, _notificationsService) {
        this._skillCenturyService = _skillCenturyService;
        this._skillCenturyAreaService = _skillCenturyAreaService;
        this._skillCenturyTeacherAnswerCenturyService = _skillCenturyTeacherAnswerCenturyService;
        this._authService = _authService;
        this.areas = [];
        this.loading = false;
        this.totalQuestions = 0;
        this.totalAnswered = 0;
        this.percentage = 0;
        this.showGraph = false;
        this.color = [{"Vulnerable": "alert", "Competente": "waring", "Optimo": "success"}];
        this.graphImage = "";
        this.directoryUploadsEvaluationXXI = "evaluation_xxi_teacher_";
        // Radar
        this.radarChartLabels = [];
        this.radarChartData = [];
        this.radarChartType = 'radar';
		this.teacherService = teacherService
		this._notificationsService = _notificationsService;
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
    ApplyCenturyEvaluation_1 = ApplyCenturyEvaluation;
    ApplyCenturyEvaluation.prototype.ngOnInit = function () {
        var _this = this;
        jQuery("#main-navigation").find(">ul>li.active").removeClass("active");
        jQuery("#menu-century-xxi-evaluation").addClass("active");
        this.loading = true;
        this.userId = this._authService.getProfile().teacher_id;
        this._skillCenturyService.findAll(-1).subscribe(function (response) {
            _this.skills = response.data;
            if (_this.skills.length == 0) {
                _this.loading = false;
            }
            var _loop_1 = function (i) {
                _this._skillCenturyAreaService.findAll(_this.skills[i].id, -1).subscribe(function (response) {
                    _this.areas[_this.skills[i].id] = response.data;
                    var areas = _this.areas[_this.skills[i].id];
                    for (var _i = 0, areas_1 = areas; _i < areas_1.length; _i++) {
                        var area = areas_1[_i];
                        if (typeof area.totalQuestions !== "undefined") {
                            _this.totalQuestions += area.totalQuestions;
                        } else {
                            _this.totalQuestions += 0;
                        }
                        if (typeof area.questionsAnswered !== "undefined") {
                            _this.totalAnswered += area.questionsAnswered;
                        } else {
                            _this.totalAnswered += 0;
                        }
                    }
                    if (_this.totalQuestions === 0) {
                        _this.percentage = 0;
                    } else {
                        _this.percentage = parseInt((_this.totalAnswered / _this.totalQuestions) * 100 + "");
                    }
                    document.getElementById('barra').style.width = _this.percentage + "%";
                    _this.loading = false;
                }, function (error) {
                    _this.loading = false;
                    console.log(error);
                });
            };
            for (var i = 0; i < _this.skills.length; i++) {
                _loop_1(i);
            }
            _this._skillCenturyTeacherAnswerCenturyService
                    .getResults().subscribe(function (response) {
                _this.showGraph = false;
                if (response.didFinish != null) {
                    _this.showGraph = true;
                }
                _this.results = response.data;
                console.log(response);
                var data;
                var cuantosMas = 0;
                for (var _i = 0, _a = _this.results; _i < _a.length; _i++) {
                    var result = _a[_i];
                    data = new DataResultEvaluationXII_1.DataResultEvaluationXII();
                    data.label = result.name;
                    for (var i = 0; i < cuantosMas; i++) {
                        data.data.push(0);
                    }
                    for (var _b = 0, _c = result.areas; _b < _c.length; _b++) {
                        var area = _c[_b];
                        _this.radarChartLabels.push(area.name);
                        data.data.push(area.result);
                        cuantosMas++;
                    }
                    _this.radarChartData.push(data);
                }
                //this.showGraph = true;
                var cen = new ApplyCenturyEvaluation_1(_this._skillCenturyService, _this._skillCenturyAreaService, _this._skillCenturyTeacherAnswerCenturyService, _this._authService);
                cen.userId = _this.userId;
                setTimeout(function () {
                    cen.getImage(cen);
                }, 1000);
            }, function (error) {
                _this.loading = false;
                console.log(error);
            });
        }, function (error) {
            console.log(error);
        });
    };
    ApplyCenturyEvaluation.prototype.exportResult = function () {
        var _this = this;
        this._skillCenturyTeacherAnswerCenturyService
                .exportResultToPDF()
                .subscribe(function (response) {
                    if (response.status == 'success') {
                        window.open(_this._skillCenturyTeacherAnswerCenturyService.apiEndPoint + _this.directoryUploadsEvaluationXXI
                                + response.userId + "/result.pdf", '_blank');
                    }
                }, function (error) {
                });
    };
    ApplyCenturyEvaluation.prototype.getImage = function (cen) {
        cen.userId = this.userId;
        this.loading = true;
        var canvas = document.getElementById("resultGraph");
        if (canvas) {
            // let context: any = canvas.getContext('2d');
            cen.graphImage = this.graphImage = canvas.toDataURL("image/png");
            cen._skillCenturyTeacherAnswerCenturyService
                    .saveImage(cen.graphImage, cen.userId)
                    .subscribe(function (response) {
                        if (response.status == "error") {
                            console.log("Error al guardar la imagen");
                        } else {
                            console.log("Imagen guardada correctamente");
                        }
                    }, function (error) {
                        console.log(error);
                    });
        }
    };
		/**
     * Funcion borrado de teacher, evaluaciones siglos xxi y evaluation diagnostica
     * @param teacherId
	 * @param opcion valores de opcion 
	 *	1 => Elimiar al Profesor
	 *	2 => Elimiar al Evaluación Siglo XXI
	 *	3 => Elimiar al Evaluación Diagnostica
     */
    ApplyCenturyEvaluation.prototype.delete = function (teacherId,opcion) {
        var _this = this;

        $.confirm({
            icon: 'fa fa-warning',
            closeIcon: true,
            title: '¡Confirmación!',
            content: '¿Está seguro que desea reiniciar esta evaluation?',
            type: 'red',
            typeAnimated: true,
            autoClose: 'close|8000',
            buttons: {
                acptar: {
                    text: 'Aceptar',
                    btnClass: 'btn-green',
                    action: function () {
						console.log("teacher" + teacherId);
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
    ApplyCenturyEvaluation = ApplyCenturyEvaluation_1 = __decorate([
        core_1.Component({
            templateUrl: 'app/views/apply-evaluation/index.html',
            providers: [skill_century_service_1.SkillCenturyService, skill_century_area_service_1.SkillCenturyAreaService, skill_century_teacher_answer_century_service_1.SkillCenturyTeacherAnswerCenturyService, teacher_service_1.TeacherService, notifications_service_1.NotificationsService],
            selector: 'radar-chart-demo',
        }),
        __metadata("design:paramtypes", [skill_century_service_1.SkillCenturyService,
            skill_century_area_service_1.SkillCenturyAreaService,
            skill_century_teacher_answer_century_service_1.SkillCenturyTeacherAnswerCenturyService,
            auth_service_1.AuthService,
			teacher_service_1.TeacherService, 
			notifications_service_1.NotificationsService])
    ], ApplyCenturyEvaluation);
    return ApplyCenturyEvaluation;
    var ApplyCenturyEvaluation_1;
}());
exports.ApplyCenturyEvaluation = ApplyCenturyEvaluation;
//# sourceMappingURL=apply-century-evaluation.component.js.map