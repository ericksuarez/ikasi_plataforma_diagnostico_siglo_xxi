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
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = require("@angular/core");
var location_1 = require('@angular/common')
var catalog_form_1 = require("../../models/catalog_form");
var notifications_service_1 = require("angular2-notifications/src/notifications.service");
var education_level_service_1 = require("../../services/education-level.service");
var AdminLevelEducationCreateComponent = (function () {
    function AdminLevelEducationCreateComponent(educationLevelService, _notificationsService ,location) {
        this.educationLevelService = educationLevelService;
        this.location = location;
        this._notificationsService = _notificationsService;
        this.model = new catalog_form_1.CatalogForm();
        this.educationLevelList = [];
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
    }
    AdminLevelEducationCreateComponent.prototype.onSubmit = function () {
        var _this = this;
        //noinspection TypeScriptValidateJSTypes
        jQuery("#educationLevelFormButton").button('loading');
        this.educationLevelService.create(this.model).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#educationLevelFormButton").button('reset');
            if (response.status == 'success') {
                _this.educationLevelList.push(response);
                _this._notificationsService.success(response.title, response.message);
            }
            else {
                _this._notificationsService.error(response.title, response.message);
            }
        });
    };
    AdminLevelEducationCreateComponent.prototype.toGoBack = function () {
        var _this = this;
        _this.location.back();
    };
    AdminLevelEducationCreateComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/level-education/create.html',
            providers: [education_level_service_1.EducationLevelService, notifications_service_1.NotificationsService, location_1.Location]
        }),
        __metadata("design:paramtypes", [education_level_service_1.EducationLevelService, notifications_service_1.NotificationsService, location_1.Location])
    ], AdminLevelEducationCreateComponent);
    return AdminLevelEducationCreateComponent;
}());
exports.AdminLevelEducationCreateComponent = AdminLevelEducationCreateComponent;
//# sourceMappingURL=admin-level-education-create.component.js.map