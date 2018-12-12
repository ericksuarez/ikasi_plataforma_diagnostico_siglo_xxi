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
var auth_service_1 = require("../services/auth.service");
var router_1 = require("@angular/router");
var user_service_1 = require("../services/user.service");
var DefaultComponent = (function () {
    function DefaultComponent(_authService, router, _userService) {
        this._authService = _authService;
        this.router = router;
        if (this._authService.isAdmin()) {
            this.router.navigate(['/admin/dashboard']);
        }
        else {
            this.noAdmin = true;
        }
        this._userService = _userService;
    }
    DefaultComponent.prototype.ngOnInit = function () {
        var _this = this;
        jQuery("#main-navigation").find(">ul>li.active").removeClass("active");
        _this._userService.getHome().subscribe(function (response) {
            console.log(response);
            jQuery("#text_left").html(response.data[0].text_left.replace(/\n/g, "<br/>"));
            jQuery("#text_right").html(response.data[0].text_right.replace(/\n/g, "<br/>"));
        }, function (error) {
            console.log("Error al cargar las especialidades");
        });
    };
    DefaultComponent = __decorate([
        core_1.Component({
            selector: 'default',
            templateUrl: 'app/views/default.html',
            providers: [auth_service_1.AuthService, user_service_1.UserService]
        }), 
        __metadata('design:paramtypes', [auth_service_1.AuthService, router_1.Router, user_service_1.UserService])
    ], DefaultComponent);
    return DefaultComponent;
}());
exports.DefaultComponent = DefaultComponent;
//# sourceMappingURL=default.component.js.map