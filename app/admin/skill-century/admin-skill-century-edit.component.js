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
var skill_century_service_1 = require("../../services/skill-century.service");
var notifications_service_1 = require("angular2-notifications/src/notifications.service");
var router_1 = require("@angular/router");
var SkillCentury_1 = require("../../models/SkillCentury");
var location_1 = require('@angular/common')
var AdminSkillCenturyEditComponent = (function () {
    function AdminSkillCenturyEditComponent(_skillCenturyService, _notificationsService, _route, _router ,location) {
        this._skillCenturyService = _skillCenturyService;
        this._notificationsService = _notificationsService;
        this._route = _route;
        this._router = _router;
        this.skill = new SkillCentury_1.SkillCentury("", "");
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
    AdminSkillCenturyEditComponent.prototype.ngOnInit = function () {
        var _this = this;
        this._route.params.subscribe(function (params) {
            _this.skill.name = params["name"];
            _this.skill.id = params["id"];
        });
    };
    AdminSkillCenturyEditComponent.prototype.onSubmit = function () {
        var _this = this;
        this._notificationsService.info("Guardando", "...");
        this._skillCenturyService.edit(this.skill).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#skillFormButton").button('reset');
            if (response.status == 'success') {
                _this._notificationsService.success(response.title, response.message);
                _this._router.navigate(["/admin/skill-century/index"]);
            }
            else {
                _this._notificationsService.error(response.title, response.message);
            }
        });
    };
    AdminSkillCenturyEditComponent.prototype.toGoBack = function () {
        var _this = this;
        _this.location.back();
    };
    AdminSkillCenturyEditComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/skill-century/edit.html',
            providers: [skill_century_service_1.SkillCenturyService, notifications_service_1.NotificationsService, location_1.Location]
        }),
        __metadata("design:paramtypes", [skill_century_service_1.SkillCenturyService,
            notifications_service_1.NotificationsService,
            router_1.ActivatedRoute,
            router_1.Router,
            location_1.Location])
    ], AdminSkillCenturyEditComponent);
    return AdminSkillCenturyEditComponent;
}());
exports.AdminSkillCenturyEditComponent = AdminSkillCenturyEditComponent;
//# sourceMappingURL=admin-skill-century-edit.component.js.map