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
var router_1 = require("@angular/router");
var register_service_1 = require("../services/register.service");
var password_reset_1 = require("../models/password-reset");
var angular2_notifications_1 = require("angular2-notifications");
var NewPasswordComponent = (function () {
    function NewPasswordComponent(_activateRoute, _registerService, _notificationsService) {
        this._activateRoute = _activateRoute;
        this._registerService = _registerService;
        this._notificationsService = _notificationsService;
        this.dontMatch = false;
        this.model = new password_reset_1.PasswordReset();
        this.seconds = 10;
        this.success = false;
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
    }
    NewPasswordComponent.prototype.ngOnInit = function () {
        var _this = this;
        this._activateRoute.params.subscribe(function (params) {
            _this.model.id = params['id'];
            _this.model.token = params['token'];
        });
    };
    NewPasswordComponent.prototype.onSubmit = function () {
        var _this = this;
        //noinspection TypeScriptValidateJSTypes
        jQuery("#recoveryButton").button('loading');
        this.dontMatch = false;
        if (!this.passwordMatch()) {
            this.dontMatch = true;
            return;
        }
        this._registerService.changePasswordWithtoken(this.model).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#recoveryButton").button('reset');
            if (response.status == 'error') {
                _this._notificationsService.error(response.title, response.message);
                return;
            }
            _this.success = true;
            var self = _this;
            var countdown = setInterval(function () {
                self.seconds = self.seconds - 1;
                if (self.seconds == 0) {
                    clearInterval(countdown);
                    // Redirect
                    location.href = '/login';
                }
            }, 1000);
        }, function (error) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#recoveryButton").button('reset');
        });
    };
    NewPasswordComponent.prototype.passwordMatch = function () {
        return this.model.password == this.model.password_repeat;
    };
    NewPasswordComponent = __decorate([
        core_1.Component({
            selector: 'new-password',
            templateUrl: 'app/views/new_password.html',
            providers: [register_service_1.RegisterService, angular2_notifications_1.NotificationsService]
        }), 
        __metadata('design:paramtypes', [router_1.ActivatedRoute, register_service_1.RegisterService, angular2_notifications_1.NotificationsService])
    ], NewPasswordComponent);
    return NewPasswordComponent;
}());
exports.NewPasswordComponent = NewPasswordComponent;
//# sourceMappingURL=new-password.component.js.map