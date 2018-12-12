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
var skill_century_category_service_1 = require("../../../services/skill-century-category.service");
var notifications_service_1 = require("angular2-notifications/src/notifications.service");
var router_1 = require("@angular/router");
var SkillCenturyCategory_1 = require("../../../models/SkillCenturyCategory");
var location_1 = require('@angular/common');
var AdminSkillCenturyCreateCategoryComponent = (function () {
    function AdminSkillCenturyCreateCategoryComponent(_skillCenturyCategoryService, _notificationsService, activatedRoute ,location) {
        this._skillCenturyCategoryService = _skillCenturyCategoryService;
        this._notificationsService = _notificationsService;
        this.activatedRoute = activatedRoute;
        this.category = new SkillCenturyCategory_1.SkillCenturyCategory(0, "");
        this.categories = [];
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
        this.location = location;
    }
    AdminSkillCenturyCreateCategoryComponent.prototype.onSubmit = function () {
        var _this = this;
        //noinspection TypeScriptValidateJSTypes
        jQuery("#categoryFormButton").button('loading');
        console.log(this.category);
        this._skillCenturyCategoryService.create(this.category).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#categoryFormButton").button('reset');
            if (response.status == 'success') {
                _this.categories.push(response);
                _this._notificationsService.success(response.title, response.message);
            }
            else {
                _this._notificationsService.error(response.title, response.message);
            }
        });
    };
    AdminSkillCenturyCreateCategoryComponent.prototype.toGoBack = function () {
        var _this = this;
        _this.location.back();
    };
    AdminSkillCenturyCreateCategoryComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/skill-century/categories/create.html',
            providers: [skill_century_category_service_1.SkillCenturyCategoryService, notifications_service_1.NotificationsService, 
                location_1.Location]
        }),
        __metadata("design:paramtypes", [skill_century_category_service_1.SkillCenturyCategoryService,
            notifications_service_1.NotificationsService,
            router_1.ActivatedRoute, 
            location_1.Location])
    ], AdminSkillCenturyCreateCategoryComponent);
    return AdminSkillCenturyCreateCategoryComponent;
}());
exports.AdminSkillCenturyCreateCategoryComponent = AdminSkillCenturyCreateCategoryComponent;
//# sourceMappingURL=admin-skill-century-create-category.component.js.map