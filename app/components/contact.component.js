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
var contact_1 = require('../models/contact');
var contact_service_1 = require('../services/contact.service');
var ContactComponent = (function () {
    function ContactComponent(_contact_service) {
        this._contact_service = _contact_service;
        this.model = new contact_1.Contact();
        this.responseMessage = "";
    }
    ContactComponent.prototype.ngOnInit = function () {
        jQuery("#main-navigation").find(">ul>li.active").removeClass("active");
        jQuery("#menu-contact").addClass("active");
    };
    ContactComponent.prototype.onSubmit = function () {
        var _this = this;
        //noinspection TypeScriptValidateJSTypes
        jQuery("#contactButton").button('loading');
        this._contact_service.send(this.model).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#contactButton").button('reset');
            _this.responseStatus = response.status != 'error';
            _this.responseMessage = response.message;
            //noinspection TypeScriptUnresolvedFunction
            jQuery("#contactForm").trigger('reset');
        }, function (error) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#contactButton").button('reset');
        });
    };
    ContactComponent = __decorate([
        core_1.Component({
            selector: 'contact',
            templateUrl: 'app/views/contact.html',
            providers: [contact_service_1.ContactService]
        }), 
        __metadata('design:paramtypes', [contact_service_1.ContactService])
    ], ContactComponent);
    return ContactComponent;
}());
exports.ContactComponent = ContactComponent;
//# sourceMappingURL=contact.component.js.map