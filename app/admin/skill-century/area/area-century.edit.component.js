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
var AdminSkillCenturyAreaEditComponent = (function () {
    function AdminSkillCenturyAreaEditComponent(_skillCenturyAreaService, _notificationsService, activatedRoute, _router, location) {
        this._skillCenturyAreaService = _skillCenturyAreaService;
        this._notificationsService = _notificationsService;
        this.activatedRoute = activatedRoute;
        this._router = _router;
        this.model = new SkillArea_1.SkillArea(0, "", 0, 0, 0, 0, 0, 0);
        this.areaId = 0;
        this.skillId = 0;
        this.skills = [];
        this.editing = true;
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
    AdminSkillCenturyAreaEditComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.activatedRoute.params.subscribe(function (params) {
            _this.areaId = params['areaId'];
            _this.skillId = params['skillId'];
            _this._skillCenturyAreaService.areaDetail(_this.areaId).subscribe(function (response) {
                if (response.status == "success") {
                    var skill = response.data;
                    _this.model.skill_century_id = skill.id;
                    _this.model.name = skill.name;
                    _this.model.min_vulnerable = skill.minVulnerable;
                    _this.model.max_vulnerable = skill.maxVulnerable;
                    _this.model.min_competent = skill.minCompetent;
                    _this.model.max_competent = skill.maxCompetent,
                            _this.model.min_optimum = skill.minOtimum;
                    _this.model.max_optimum = skill.maxOtimum;
                }
            });
        });
    };
    AdminSkillCenturyAreaEditComponent.prototype.onSubmit = function () {
        var _this = this;
        this._notificationsService.info("Guardando", "...");
        this._skillCenturyAreaService.edit(this.model).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#skillFormButton").button('reset');
            if (response.status == 'success') {
                _this._notificationsService.success(response.title, response.message);
                _this._router.navigate(["/admin/skill-century/skill-area/" + _this.skillId]);
            } else {
                _this._notificationsService.error(response.title, response.message);
            }
        });
    };
    AdminSkillCenturyAreaEditComponent.prototype.delete = function () {
        alert(this.areaId);
    };
    AdminSkillCenturyAreaEditComponent.prototype.toGoBack = function () {
        var _this = this;
        _this.location.back();
    };
    AdminSkillCenturyAreaEditComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/skill-century/area_create.html',
            providers: [skill_century_area_service_1.SkillCenturyAreaService, notifications_service_1.NotificationsService, location_1.Location]
        }),
        __metadata("design:paramtypes", [skill_century_area_service_1.SkillCenturyAreaService,
            notifications_service_1.NotificationsService,
            router_1.ActivatedRoute,
            router_1.Router,
            location_1.Location])
    ], AdminSkillCenturyAreaEditComponent);
    return AdminSkillCenturyAreaEditComponent;
}());
exports.AdminSkillCenturyAreaEditComponent = AdminSkillCenturyAreaEditComponent;
//# sourceMappingURL=area-century.edit.component.js.map