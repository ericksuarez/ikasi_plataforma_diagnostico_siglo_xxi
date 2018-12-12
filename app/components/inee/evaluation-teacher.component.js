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
var evaluation_inee_service_1 = require("../../services/evaluation-inee.service");
var notifications_service_1 = require("angular2-notifications/src/notifications.service");
var EvaluationTeacherComponent = (function () {
    function EvaluationTeacherComponent(evaluationIneeService, _notificationsService) {
        this.evaluationIneeService = evaluationIneeService;
        this.loading = false;
        this.showGraphic = false;
        this.radarChartType = 'radar';
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
        this.teacher_id;
    }
    EvaluationTeacherComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.loading = true;
        jQuery("#main-navigation").find(">ul>li.active").removeClass("active");
        jQuery("#menu-century-xxi-evaluation").addClass("active");
        this.evaluationIneeService.getDimentionToEvaluate().subscribe(function (response) {
			console.log(response);
            if (response.data) {
                _this.radarChartLabels = response.dimensions;
				_this.tagDimensions = response.tagDimensions;
                _this.radarChartData = response.data;
                _this.loading = false;
                _this.showGraphic = true;
                _this.saveImage();
                _this.teacher_id = response.id;
            } else {
                _this.dimensions = response;
                _this.loading = false;
            }
        }, function (error) {
            _this.loading = false;
            console.log(error);
        });
    };
    /**
     * Get image from canvas and save in data teacher
     */
    EvaluationTeacherComponent.prototype.saveImage = function () {
        var _this = this;
        setTimeout(function () {
            var canvas = document.getElementById("graphInee");
            var image = canvas.toDataURL("image/png");
            _this.evaluationIneeService.saveImage(image).subscribe(function (response) {
				console.log(response);
            }, function (error) {
                console.log(error);
            });
        }, 1000);
    };
    EvaluationTeacherComponent.prototype.resetEvaluationInee = function () {
        var _this = this;

        $.confirm({
            icon: 'fa fa-warning',
            closeIcon: true,
            title: '¡Confirmación!',
            content: '¿Está seguro que desea reiniciar la evaluación?',
            type: 'red',
            typeAnimated: true,
            autoClose: 'close|8000',
            buttons: {
                acptar: {
                    text: 'Aceptar',
                    btnClass: 'btn-green',
                    action: function () {
                        _this.evaluationIneeService.doResetEvaluationInee(_this.teacher_id).subscribe(function (response) {
                            if (response.status == 200) {
                                _this._notificationsService.success(response.title, response.message);
                                location.reload();
                            } else {
                                _this._notificationsService.error(response.title, response.message);
                            }
                        }, function (error) {
                            _this.loading = false;
                            _this._notificationsService.error("Error", "Ocurrio un error al tratar de reiniciar la evaluación.");
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
    EvaluationTeacherComponent = __decorate([
        core_1.Component({
            selector: 'evaluation-inne',
            templateUrl: 'app/views/inee/evaluation-teacher.html',
            providers: [evaluation_inee_service_1.EvaluationIneeService, notifications_service_1.NotificationsService]
        }),
        __metadata("design:paramtypes", [evaluation_inee_service_1.EvaluationIneeService, notifications_service_1.NotificationsService])
    ], EvaluationTeacherComponent);
    return EvaluationTeacherComponent;
}());
exports.EvaluationTeacherComponent = EvaluationTeacherComponent;
//# sourceMappingURL=evaluation-teacher.component.js.map