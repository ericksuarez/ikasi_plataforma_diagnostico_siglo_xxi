"use strict";
var __extends = (this && this.__extends) || (function () {
    var extendStatics = Object.setPrototypeOf ||
        ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
        function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
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
var router_1 = require("@angular/router");
var helper_1 = require("../../../helpers/helper");
var SkillCenturyCategory_1 = require("../../../models/SkillCenturyCategory");
var notifications_service_1 = require("angular2-notifications/src/notifications.service");
var location_1 = require('@angular/common');
var AdminSkillCenturyEditCategoryComponent = (function (_super) {
    __extends(AdminSkillCenturyEditCategoryComponent, _super);
    function AdminSkillCenturyEditCategoryComponent(_skillCenturyCategoryService, _notificationsService, activatedRoute, _router ,location) {
        var _this = _super.call(this) || this;
        _this._skillCenturyCategoryService = _skillCenturyCategoryService;
        _this._notificationsService = _notificationsService;
        _this.activatedRoute = activatedRoute;
        _this._router = _router;
        _this.category = new SkillCenturyCategory_1.SkillCenturyCategory(0, "");
        _this.categories = [];
        _this.editing = true;
        _this.options = {
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
        _this.location = location;
        return _this;
    }
    AdminSkillCenturyEditCategoryComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.activatedRoute.params.subscribe(function (params) {
            _this.category.name = params['name'];
            _this.category.skill_century_category_id = params['id'];
        });
    };
    AdminSkillCenturyEditCategoryComponent.prototype.onSubmit = function () {
        var _this = this;
        this._notificationsService.info("Guardando", "...");
        this._skillCenturyCategoryService.edit(this.category).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#categoryFormButton").button('reset');
            if (response.status == 'success') {
                _this._notificationsService.success(response.title, response.message);
                _this._router.navigate(["/admin/skill-century/categories"]);
            }
            else {
                _this._notificationsService.error(response.title, response.message);
            }
        });
    };
    AdminSkillCenturyEditCategoryComponent.prototype.toGoBack = function () {
        var _this = this;
        _this.location.back();
    };    
    AdminSkillCenturyEditCategoryComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/skill-century/categories/create.html',
            providers: [skill_century_category_service_1.SkillCenturyCategoryService, notifications_service_1.NotificationsService,
                location_1.Location]
        }),
        __metadata("design:paramtypes", [skill_century_category_service_1.SkillCenturyCategoryService,
            notifications_service_1.NotificationsService,
            router_1.ActivatedRoute,
            router_1.Router,
            location_1.Location])
    ], AdminSkillCenturyEditCategoryComponent);
    return AdminSkillCenturyEditCategoryComponent;
}(helper_1.Helper));
exports.AdminSkillCenturyEditCategoryComponent = AdminSkillCenturyEditCategoryComponent;
//# sourceMappingURL=admin-skill-century-edit-categories.component.js.map