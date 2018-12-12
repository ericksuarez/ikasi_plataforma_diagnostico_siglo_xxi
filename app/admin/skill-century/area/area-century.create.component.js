"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function")
        r = Reflect.decorate(decorators, target, key, desc);
    else
        for (var i = decorators.length - 1; i >= 0; i--)
            if (d = decorators[i])
                r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function")
        return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", {value: true});
var core_1 = require("@angular/core");
var skill_century_area_service_1 = require("../../../services/skill-century-area.service");
var notifications_service_1 = require("angular2-notifications/src/notifications.service");
var router_1 = require("@angular/router");
var SkillArea_1 = require("../../../models/SkillArea");
var location_1 = require('@angular/common')
var AdminSkillCenturyAreaCreateComponent = (function () {
    function AdminSkillCenturyAreaCreateComponent(_skillCenturyAreaService, _notificationsService, activatedRoute, location) {
        this._skillCenturyAreaService = _skillCenturyAreaService;
        this._notificationsService = _notificationsService;
        this.activatedRoute = activatedRoute;
        this.model = new SkillArea_1.SkillArea(0, "", 0, 0, 0, 0, 0, 0);
        this.skillId = 0;
        this.skills = [];
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
    AdminSkillCenturyAreaCreateComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.activatedRoute.params.subscribe(function (params) {
            _this.skillId = params['id'];
        });
        this.model.skill_century_id = this.skillId;
        jQuery("#main-navigation").find(">ul>li.active").removeClass("active");
        jQuery("#menu-siglo-xxi").addClass("active");
    };
    AdminSkillCenturyAreaCreateComponent.prototype.onSubmit = function () {
        var _this = this;
        //noinspection TypeScriptValidateJSTypes
        jQuery("#skillFormButton").button('loading');
        this._skillCenturyAreaService.create(this.model).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#skillFormButton").button('reset');
            if (response.status == 'success') {
                _this.skills.push(response);
                _this._notificationsService.success(response.title, response.message);
            } else {
                _this._notificationsService.error(response.title, response.message);
            }
        });
    };
    AdminSkillCenturyAreaCreateComponent.prototype.toGoBack = function () {
        var _this = this;
        _this.location.back();
    };
    AdminSkillCenturyAreaCreateComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/skill-century/area_create.html',
            providers: [skill_century_area_service_1.SkillCenturyAreaService, notifications_service_1.NotificationsService, location_1.Location]
        }),
        __metadata("design:paramtypes", [skill_century_area_service_1.SkillCenturyAreaService,
            notifications_service_1.NotificationsService,
            router_1.ActivatedRoute, location_1.Location])
    ], AdminSkillCenturyAreaCreateComponent);
    return AdminSkillCenturyAreaCreateComponent;
}());
exports.AdminSkillCenturyAreaCreateComponent = AdminSkillCenturyAreaCreateComponent;
//# sourceMappingURL=area-century.create.component.js.map