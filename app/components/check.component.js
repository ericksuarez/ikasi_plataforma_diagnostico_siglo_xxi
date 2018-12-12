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
var user_service_1 = require("../services/user.service");
var helper_1 = require("../helpers/helper");
var router_1 = require("@angular/router");
var CheckComponent = (function () {
    function CheckComponent(_userService, _helper, _router) {
        this._userService = _userService;
        this._helper = _helper;
        this._router = _router;
        this.model = {
            curp: null
        };
        this.showError = false;
        this.exists = false;
    }
    CheckComponent.prototype.onSubmit = function () {
        var _this = this;
        this.showError = false;
        this.exists = false;
        //noinspection TypeScriptValidateJSTypes
        jQuery("#recoveryButton").button('loading');
        this._userService.checkCurp(this.model).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#recoveryButton").button('reset');
            if (response.status == 'error') {
                if (response.code == 1001) {
                    _this.exists = true;
                }
                _this.showError = true;
                _this.message = response.message;
            }
            else {
                _this._router.navigate(["register", _this._helper.base64Encode(JSON.stringify(response.data))]);
            }
        }, function (error) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#recoveryButton").button('reset');
        });
    };
    CheckComponent = __decorate([
        core_1.Component({
            selector: 'check',
            templateUrl: 'app/views/check.html',
            providers: [user_service_1.UserService, helper_1.Helper]
        }), 
        __metadata('design:paramtypes', [user_service_1.UserService, helper_1.Helper, router_1.Router])
    ], CheckComponent);
    return CheckComponent;
}());
exports.CheckComponent = CheckComponent;
//# sourceMappingURL=check.component.js.map