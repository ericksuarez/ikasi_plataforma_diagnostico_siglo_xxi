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
var password_1 = require("../../models/password");
var email_1 = require("../../models/email");
var angular2_notifications_1 = require("angular2-notifications");
var user_service_1 = require("../../services/user.service");
var auth_service_1 = require("../../services/auth.service");
var AdminProfileComponent = (function () {
    function AdminProfileComponent(_notificationsService, _userService, _authService) {
        this._notificationsService = _notificationsService;
        this._userService = _userService;
        this._authService = _authService;
        this.modelPassword = new password_1.Password();
        this.modelEmail = new email_1.Email();
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
    /**
     * Cambio de contraseña
     */
    AdminProfileComponent.prototype.submitPassword = function () {
        var _this = this;
        this.dontMatchPassword = false;
        if (!AdminProfileComponent.matchFields(this.modelPassword.newPassword, this.modelPassword.repeatNewPassword)) {
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
    AdminProfileComponent.prototype.submitEmail = function () {
        var _this = this;
        this.dontMatchEmail = false;
        if (!AdminProfileComponent.matchFields(this.modelEmail.email, this.modelEmail.emailRepeat)) {
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
    /**
     * Compara dos campos para verificar que sean iguales
     * @param original
     * @param compare
     * @returns {boolean}
     */
    AdminProfileComponent.matchFields = function (original, compare) {
        return original == compare;
    };
    AdminProfileComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/profile.html',
            providers: [user_service_1.UserService, angular2_notifications_1.NotificationsService]
        }), 
        __metadata('design:paramtypes', [angular2_notifications_1.NotificationsService, user_service_1.UserService, auth_service_1.AuthService])
    ], AdminProfileComponent);
    return AdminProfileComponent;
}());
exports.AdminProfileComponent = AdminProfileComponent;
//# sourceMappingURL=admin-profile.component.js.map