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
var register_service_1 = require("../services/register.service");
var notifications_service_1 = require("angular2-notifications/src/notifications.service");
var PasswordRecoveryComponent = (function () {
    function PasswordRecoveryComponent(_registerService, _notificationsService) {
        this._registerService = _registerService;
        this._notificationsService = _notificationsService;
        this.model = {
            email: null
        };
        this.options = {
            timeOut: 10000,
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
    }
    PasswordRecoveryComponent.prototype.onSubmit = function () {
        var _this = this;
        //noinspection TypeScriptValidateJSTypes
        jQuery("#recoveryButton").button('loading');
        this._registerService.passwordRecovery(this.model.email).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#recoveryButton").button('reset');
            if (response.status == 'success') {
                _this._notificationsService.success(response.title, response.message);
            }
            else {
                _this._notificationsService.error(response.title, response.message);
            }
        }, function (error) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#recoveryButton").button('reset');
        });
    };
    PasswordRecoveryComponent = __decorate([
        core_1.Component({
            selector: 'password-recovery',
            templateUrl: 'app/views/password-recovery.html',
            providers: [register_service_1.RegisterService, notifications_service_1.NotificationsService]
        }), 
        __metadata('design:paramtypes', [register_service_1.RegisterService, notifications_service_1.NotificationsService])
    ], PasswordRecoveryComponent);
    return PasswordRecoveryComponent;
}());
exports.PasswordRecoveryComponent = PasswordRecoveryComponent;
//# sourceMappingURL=password-recovery.component.js.map