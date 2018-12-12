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
var education_level_service_1 = require("../../services/education-level.service");
var teacher_function_service_1 = require("../../services/teacher-function.service");
var inee_service_1 = require("../../services/inee.service");
var dimension_1 = require("../../models/dimension");
var notifications_service_1 = require("angular2-notifications/src/notifications.service");
var AdminSkillIneeComponent = (function () {
    function AdminSkillIneeComponent(_educationLevelService, _teacherFunctionService, _ineeService, _notificationsService) {
        this._educationLevelService = _educationLevelService;
        this._teacherFunctionService = _teacherFunctionService;
        this._ineeService = _ineeService;
        this.model = new dimension_1.Dimension();
        this.dimensions = [];
		this._notificationsService = _notificationsService;
		// Configuración para las notificaciones
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
        this.colors = [
            {
                dimension: '#97B9E4',
                parameter: '#DCE8F6',
                indicator: '#EBF1F9'
            },
            {
                dimension: '#AB73D4',
                parameter: '#E1D0F0',
                indicator: '#F4ECF8'
            },
            {
                dimension: '#FF9225',
                parameter: '#FFE7CF',
                indicator: '#FFF3E7'
            },
            {
                dimension: '#31928B',
                parameter: '#B5E4E1',
                indicator: '#DAF1EF'
            },
            {
                dimension: '#61C52B',
                parameter: '#D2F0C1',
                indicator: '#E8F8DF'
            },
			{
                dimension: '#97B9E4',
                parameter: '#DCE8F6',
                indicator: '#EBF1F9'
            },
            {
                dimension: '#AB73D4',
                parameter: '#E1D0F0',
                indicator: '#F4ECF8'
            },
            {
                dimension: '#FF9225',
                parameter: '#FFE7CF',
                indicator: '#FFF3E7'
            },
            {
                dimension: '#31928B',
                parameter: '#B5E4E1',
                indicator: '#DAF1EF'
            },
            {
                dimension: '#61C52B',
                parameter: '#D2F0C1',
                indicator: '#E8F8DF'
            },
			{
                dimension: '#97B9E4',
                parameter: '#DCE8F6',
                indicator: '#EBF1F9'
            },
            {
                dimension: '#AB73D4',
                parameter: '#E1D0F0',
                indicator: '#F4ECF8'
            },
            {
                dimension: '#FF9225',
                parameter: '#FFE7CF',
                indicator: '#FFF3E7'
            },
            {
                dimension: '#31928B',
                parameter: '#B5E4E1',
                indicator: '#DAF1EF'
            },
            {
                dimension: '#61C52B',
                parameter: '#D2F0C1',
                indicator: '#E8F8DF'
            },
			{
                dimension: '#97B9E4',
                parameter: '#DCE8F6',
                indicator: '#EBF1F9'
            },
            {
                dimension: '#AB73D4',
                parameter: '#E1D0F0',
                indicator: '#F4ECF8'
            },
            {
                dimension: '#FF9225',
                parameter: '#FFE7CF',
                indicator: '#FFF3E7'
            },
            {
                dimension: '#31928B',
                parameter: '#B5E4E1',
                indicator: '#DAF1EF'
            },
            {
                dimension: '#61C52B',
                parameter: '#D2F0C1',
                indicator: '#E8F8DF'
            },
			{
                dimension: '#97B9E4',
                parameter: '#DCE8F6',
                indicator: '#EBF1F9'
            },
            {
                dimension: '#AB73D4',
                parameter: '#E1D0F0',
                indicator: '#F4ECF8'
            },
            {
                dimension: '#FF9225',
                parameter: '#FFE7CF',
                indicator: '#FFF3E7'
            },
            {
                dimension: '#31928B',
                parameter: '#B5E4E1',
                indicator: '#DAF1EF'
            },
            {
                dimension: '#61C52B',
                parameter: '#D2F0C1',
                indicator: '#E8F8DF'
            },
			{
                dimension: '#97B9E4',
                parameter: '#DCE8F6',
                indicator: '#EBF1F9'
            },
            {
                dimension: '#AB73D4',
                parameter: '#E1D0F0',
                indicator: '#F4ECF8'
            },
            {
                dimension: '#FF9225',
                parameter: '#FFE7CF',
                indicator: '#FFF3E7'
            },
            {
                dimension: '#31928B',
                parameter: '#B5E4E1',
                indicator: '#DAF1EF'
            },
            {
                dimension: '#61C52B',
                parameter: '#D2F0C1',
                indicator: '#E8F8DF'
            },
			{
                dimension: '#97B9E4',
                parameter: '#DCE8F6',
                indicator: '#EBF1F9'
            },
            {
                dimension: '#AB73D4',
                parameter: '#E1D0F0',
                indicator: '#F4ECF8'
            },
            {
                dimension: '#FF9225',
                parameter: '#FFE7CF',
                indicator: '#FFF3E7'
            },
            {
                dimension: '#31928B',
                parameter: '#B5E4E1',
                indicator: '#DAF1EF'
            },
            {
                dimension: '#61C52B',
                parameter: '#D2F0C1',
                indicator: '#E8F8DF'
            }
        ];
    }
    AdminSkillIneeComponent.prototype.ngOnInit = function () {
        var _this = this;
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
    AdminSkillIneeComponent.prototype.onSubmit = function () {
        var _this = this;
        //noinspection TypeScriptValidateJSTypes
        jQuery("#dimensionButton").button('loading');
        this._ineeService.filterDimension(this.model).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#dimensionButton").button('reset');
            _this.dimensions = response;
        }, function (error) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#dimensionButton").button('reset');
        });
    };
	AdminSkillIneeComponent.prototype.delete = function (id) {
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
						_this._ineeService.delete(id,3).subscribe(function (response) {
						console.log(response);
							if (response.status == 200) {
								_this._notificationsService.success(response.title, response.message);
								jQuery("#container-dimension-" + id).remove();
							}
							else {
								_this._notificationsService.error(response.title, response.message);
							}
						}, function (error) {
							_this._notificationsService.error("Error", "Ocurrió un error al guardar los datos");
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
    AdminSkillIneeComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/skill-inee/index.html',
            providers: [education_level_service_1.EducationLevelService, teacher_function_service_1.TeacherFunctionService, inee_service_1.IneeService, notifications_service_1.NotificationsService]
        }), 
        __metadata('design:paramtypes', [education_level_service_1.EducationLevelService, teacher_function_service_1.TeacherFunctionService, inee_service_1.IneeService, notifications_service_1.NotificationsService])
    ], AdminSkillIneeComponent);
    return AdminSkillIneeComponent;
}());
exports.AdminSkillIneeComponent = AdminSkillIneeComponent;
//# sourceMappingURL=admin-skill-inee.component.js.map