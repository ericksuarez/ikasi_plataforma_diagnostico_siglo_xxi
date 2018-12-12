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
var location_1 = require('@angular/common');
var user_service_1 = require("../services/user.service");
var password_1 = require("../models/password");
var email_1 = require("../models/email");
var auth_service_1 = require("../services/auth.service");
var angular2_notifications_1 = require("angular2-notifications");
var register_1 = require("../models/register");
var teacher_function_service_1 = require("../services/teacher-function.service");
var teacher_service_1 = require("../services/teacher.service");
var education_level_service_1 = require("../services/education-level.service");
var specialty_service_1 = require("../services/specialty.service");
var ProfileComponent = (function () {
    function ProfileComponent(_notificationsService, _userService, _authService, _specialtyService, _educationLevelService, _teacherFunctionService, teacherService ,location) {
        this._notificationsService = _notificationsService;
        this._userService = _userService;
        this._authService = _authService;
        this._specialtyService = _specialtyService;
        this._educationLevelService = _educationLevelService;
        this._teacherFunctionService = _teacherFunctionService;
		this.teacherService = teacherService;
		this.location = location;
        this.modelPassword = new password_1.Password();
        this.modelEmail = new email_1.Email();
        this.modelPersonal = new register_1.Register();
        this.dontMatchPassword = false;
        this.dontMatchEmail = false;
        this.options = {
            timeOut: 5000,
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
            position: ['right', 'bottom']
        };
        this.profile = _authService.getProfile();
    }
    ProfileComponent.prototype.ngOnInit = function () {
        var _this = this;
        jQuery("#main-navigation").find(">ul>li.active").removeClass("active");
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
		
		console.log(this.profile);
        this.modelPersonal.fullname = this.profile.fullname;
        this.modelPersonal.curp = this.profile.curp;
        this.modelPersonal.teacher_function = this.profile.teacher_function_id;
        this.modelPersonal.specialty = this.profile.speciality_id;
        this.modelPersonal.education_level = this.profile.educational_level_id;
		
		this.teacherService.getProfile(this.profile.teacher_id).subscribe(function (response) {
                this.teacher = response;
                console.log(this.teacher);
				if(this.teacher.didFinishXxiQuestionary == null || this.teacher.evaluationIneeFinish == false){
					$('#block_profile').modal({backdrop: 'static', keyboard: false});
					$("#block_profile").on("hidden.bs.modal", function () {
						_this.location.back();
					});
				}
            });
		
    };
    /**
     * Cambio de contraseña
     */
    ProfileComponent.prototype.submitPassword = function () {
        var _this = this;
        this.dontMatchPassword = false;
        if (!ProfileComponent.matchFields(this.modelPassword.newPassword, this.modelPassword.repeatNewPassword)) {
            this.dontMatchPassword = true;
            return;
        }
        //noinspection TypeScriptValidateJSTypes
        jQuery("#passwordButton").button('loading');
        this._userService.changePassword(this.modelPassword).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#passwordButton").button('reset');
            if (response.status == 'success') {
                _this._notificationsService.success(response.title, response.message);
            }
            else {
                _this._notificationsService.error(response.title, response.message);
            }
        }, function (error) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#passwordButton").button('reset');
            _this._notificationsService.error("Error", "Imposible cambiar la contraseña");
        });
    };
    /**
     * Cambio de correo electrónico
     */
    ProfileComponent.prototype.submitEmail = function () {
        var _this = this;
        this.dontMatchEmail = false;
        if (!ProfileComponent.matchFields(this.modelEmail.email, this.modelEmail.emailRepeat)) {
            this.dontMatchEmail = true;
            return;
        }
        //noinspection TypeScriptValidateJSTypes
        jQuery("#emailButton").button('loading');
        this._userService.changeEmail(this.modelEmail).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#emailButton").button('reset');
            if (response.status == 'success') {
                _this._authService.updateProfile(response.token);
                _this.profile.email = _this.modelEmail.email;
                _this._notificationsService.success(response.title, response.message);
            }
            else {
                _this._notificationsService.error(response.title, response.message);
            }
        }, function (error) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#emailButton").button('reset');
            _this._notificationsService.error("Error", "Imposible cambiar el correo electrónico");
        });
    };
    ProfileComponent.prototype.submitProfile = function () {
        var _this = this;
		$.confirm({
            icon: 'fa fa-warning',
            closeIcon: true,
            title: '¡Confirmación!',
            content: '¿Está seguro que desea modificar su perfil? Al realizar este cambia sus evaluaciones se reiniciaran, para volver a realizarlas. ¿Desea continuar?',
            type: 'red',
            typeAnimated: true,
            autoClose: 'close|8000',
            buttons: {
                acptar: {
                    text: 'Aceptar',
                    btnClass: 'btn-green',
                    action: function () {
                        //noinspection TypeScriptValidateJSTypes
						jQuery("#profileButton").button('loading');
						_this._userService.updateProfile(_this.modelPersonal).subscribe(function (response) {
							//noinspection TypeScriptValidateJSTypes
							jQuery("#profileButton").button('reset');
							if (response.status == 'success') {
								_this._authService.updateProfile(response.token);
								_this._notificationsService.success(response.title, response.message);
							}
							else {
								_this._notificationsService.error(response.title, response.message);
							}
						}, function (error) {
							//noinspection TypeScriptValidateJSTypes
							jQuery("#emailButton").button('reset');
							_this._notificationsService.error("Error", "Imposible cambiar el correo electrónico");
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
    /**
     * Compara dos campos para verificar que sean iguales
     * @param original
     * @param compare
     * @returns {boolean}
     */
    ProfileComponent.matchFields = function (original, compare) {
        return original == compare;
    };
    ProfileComponent = __decorate([
        core_1.Component({
            selector: 'profile',
            templateUrl: 'app/views/profile.html',
            providers: [user_service_1.UserService, specialty_service_1.SpecialtyService, education_level_service_1.EducationLevelService, teacher_function_service_1.TeacherFunctionService, angular2_notifications_1.NotificationsService, teacher_service_1.TeacherService, location_1.Location]
        }), 
        __metadata('design:paramtypes', [angular2_notifications_1.NotificationsService, user_service_1.UserService, auth_service_1.AuthService, specialty_service_1.SpecialtyService, education_level_service_1.EducationLevelService, teacher_function_service_1.TeacherFunctionService, teacher_service_1.TeacherService, location_1.Location])
    ], ProfileComponent);
    return ProfileComponent;
}());
exports.ProfileComponent = ProfileComponent;
//# sourceMappingURL=profile.component.js.map