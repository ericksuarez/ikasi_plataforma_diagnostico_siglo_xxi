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
var core_1 = require('@angular/core');
var login_1 = require("../models/login");
var auth_service_1 = require("../services/auth.service");
var router_1 = require("@angular/router");
var LoginComponent = (function () {
    function LoginComponent(_authService, _router) {
        this._authService = _authService;
        this._router = _router;
        this.model = new login_1.Login();
        this.error = false;
    }
    LoginComponent.prototype.ngOnInit = function () {
        if (this._authService.isLoggedIn()) {
            this._router.navigate(["/"]);
        }
    };
    LoginComponent.prototype.onSubmit = function () {
        var _this = this;
        //noinspection TypeScriptValidateJSTypes
        jQuery("#submitLogin").button('loading');
        this.error = false;
        this._authService.login(this.model).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#submitLogin").button('reset');
            if (response.status == 'error') {
                _this.errorMessage = response.message;
                _this.error = true;
                return;
            }
            _this._authService.getIdentity(response.token).subscribe(function (response) {
                if (response.hasOwnProperty('sub')) {
                    localStorage.setItem('profile', JSON.stringify(response));
                    if (_this._authService.isAdmin()) {
                        location.href = "/admin/dashboard";
                    }
                    else {
                        location.href = "/index";
                    }
                }
            });
        }, function (error) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#submitLogin").button('reset');
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
            }
        });
    };
    LoginComponent = __decorate([
        core_1.Component({
            selector: 'login',
            templateUrl: 'app/views/login.html',
            providers: [auth_service_1.AuthService]
        }), 
        __metadata('design:paramtypes', [auth_service_1.AuthService, router_1.Router])
    ], LoginComponent);
    return LoginComponent;
}());
exports.LoginComponent = LoginComponent;
//# sourceMappingURL=login.component.js.map