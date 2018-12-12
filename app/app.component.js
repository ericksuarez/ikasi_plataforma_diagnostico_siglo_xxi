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
var auth_service_1 = require("./services/auth.service");
var AppComponent = (function () {
    function AppComponent(authService) {
        this.authService = authService;
        this.isAdmin = authService.isAdmin();
        this.profile = authService.getProfile();
        this.isLoggedIn = authService.isLoggedIn();
    }
    AppComponent.prototype.ngOnInit = function () {
        if (jQuery("#back").length) {
            // Back To Top Icon
            this.callBackToTop();
        }
    };
    AppComponent.prototype.callBackToTop = function () {
        var offset = 250; // Offset after which Back To Top button will be visible
        var duration = 1000; // Time duration in which the page scrolls back up.
        //noinspection TypeScriptValidateJSTypes
        jQuery(window).scroll(function () {
            //noinspection TypeScriptValidateJSTypes
            if (jQuery(this).scrollTop() > offset) {
                //noinspection TypeScriptUnresolvedFunction
                jQuery('#back').fadeIn(500);
            }
            else {
                //noinspection TypeScriptUnresolvedFunction
                jQuery('#back').fadeOut(500);
            }
        });
        jQuery('#back').click(function (event) {
            event.preventDefault();
            jQuery('html, body').animate({ scrollTop: 0 }, duration);
            return false;
        });
    };
    AppComponent = __decorate([
        core_1.Component({
            selector: 'my-app',
            templateUrl: 'app/views/layout.html',
        }), 
        __metadata('design:paramtypes', [auth_service_1.AuthService])
    ], AppComponent);
    return AppComponent;
}());
exports.AppComponent = AppComponent;
//# sourceMappingURL=app.component.js.map