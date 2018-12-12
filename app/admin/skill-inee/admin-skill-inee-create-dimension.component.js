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
var dimension_1 = require("../../models/dimension");
var education_level_service_1 = require("../../services/education-level.service");
var teacher_function_service_1 = require("../../services/teacher-function.service");
var inee_service_1 = require("../../services/inee.service");
var notifications_service_1 = require("angular2-notifications/src/notifications.service");
var router_1 = require("@angular/router");
var AdminDimensionCreateComponent = (function () {
    function AdminDimensionCreateComponent(_educationLevelService, _teacherFunctionService, _ineeService, _notificationsService, _router, activatedRoute) {
		this._educationLevelService = _educationLevelService;
        this._teacherFunctionService = _teacherFunctionService;
        this._ineeService = _ineeService;
        this._notificationsService = _notificationsService;
        this._router = _router;
        this.model = new dimension_1.Dimension();
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
		this.activatedRoute = activatedRoute;
    }
    AdminDimensionCreateComponent.prototype.ngOnInit = function () {
        var _this = this;
        _this.selector = jQuery("#validator-dimension-ckeditor");
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
		
		_this.activatedRoute.params.subscribe(function (params) {
            var id = params['id'];
			_this._ineeService.getDimension(id).subscribe(function (response) {
				if (response.status == 'success') {
					console.log(response);
					_this.model.education_level = response.dimension.educationLevel.id;
					_this.model.teacher_function = response.dimension.teacherFunction.id;
					_this.model.name = response.dimension.name;
					_this.model.id = response.dimension.id;
				}
//				else {
//					_this._notificationsService.error("Error", "Ocurrió un error al guardar los datos");
//				}
			}, function (error) {
				//noinspection TypeScriptValidateJSTypes
				jQuery("#dimensionButton").button('reset');
				_this._notificationsService.error("Error", "Ocurrió un error al guardar los datos");
			});
        });

    };
    AdminDimensionCreateComponent.prototype.onChange = function (event) {
        if (event.length > 0) {
            this.selector.removeClass('custom-ckeditor-invalid');
            this.selector.addClass('custom-ckeditor-valid');
        }
        else {
            this.selector.removeClass('custom-ckeditor-valid');
            this.selector.addClass('custom-ckeditor-invalid');
        }
    };
    AdminDimensionCreateComponent.prototype.onSubmit = function () {
        var _this = this;
        //noinspection TypeScriptValidateJSTypes
        jQuery("#dimensionButton").button('loading');
        this._ineeService.createDimension(this.model).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#dimensionButton").button('reset');
            if (response.status == 'success') {
				_this._notificationsService.success(response.title, response.message);
                _this._router.navigate(['/admin/skill-inee/parameter/create', response.id]);
            }
            else {
                _this._notificationsService.error(response.title, response.message);
            }
        }, function (error) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#dimensionButton").button('reset');
            _this._notificationsService.error("Error", response.message);
        });
    };
    AdminDimensionCreateComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/skill-inee/dimension/create.html',
            providers: [education_level_service_1.EducationLevelService, teacher_function_service_1.TeacherFunctionService, inee_service_1.IneeService, notifications_service_1.NotificationsService]
        }), 
        __metadata('design:paramtypes', [education_level_service_1.EducationLevelService, teacher_function_service_1.TeacherFunctionService, inee_service_1.IneeService, notifications_service_1.NotificationsService, router_1.Router, router_1.ActivatedRoute])
    ], AdminDimensionCreateComponent);
    return AdminDimensionCreateComponent;
}());
exports.AdminDimensionCreateComponent = AdminDimensionCreateComponent;
//# sourceMappingURL=admin-skill-inee-create-dimension.component.js.map