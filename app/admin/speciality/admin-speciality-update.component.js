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
var location_1 = require('@angular/common')
var catalog_form_1 = require("../../models/catalog_form");
var helper_1 = require("../../helpers/helper");
var router_1 = require("@angular/router");
var specialty_service_1 = require("../../services/specialty.service");
var notifications_service_1 = require("angular2-notifications/src/notifications.service");
var AdminSpecialityUpdateComponent = (function (_super) {
    __extends(AdminSpecialityUpdateComponent, _super);
    function AdminSpecialityUpdateComponent(activatedRoute, helper, specialtyService, _notificationsService ,location) {
        var _this = _super.call(this) || this;
        _this.activatedRoute = activatedRoute;
        _this.helper = helper;
        _this.location = location;
        _this.specialtyService = specialtyService;
        _this._notificationsService = _notificationsService;
        _this.model = new catalog_form_1.CatalogForm();
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
        return _this;
    }
    AdminSpecialityUpdateComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.activatedRoute.params.subscribe(function (params) {
            var name = params['name'];
            _this.model.name = _this.helper.base64Decode(name);
            _this.specialityId = params['id'];
        });
    };
    AdminSpecialityUpdateComponent.prototype.onSubmit = function () {
        var _this = this;
        jQuery("#specialityFormButton").button('loading');
        this.specialtyService.update(this.model, this.specialityId).subscribe(function (response) {
            jQuery("#specialityFormButton").button('reset');
            if (response.status == 'success') {
                _this._notificationsService.success(response.title, response.message);
            }
            else {
                _this._notificationsService.error(response.title, response.message);
            }
        }, function (error) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#updateTeacherButton").button('reset');
            _this._notificationsService.error("Error", "Ocurrio un error al tratar de actualizar la información");
        });
    };
    AdminSpecialityUpdateComponent.prototype.toGoBack = function () {
        var _this = this;
        _this.location.back();
    };
    AdminSpecialityUpdateComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/speciality/update.html',
            providers: [helper_1.Helper, specialty_service_1.SpecialtyService, notifications_service_1.NotificationsService, location_1.Location]
        }),
        __metadata("design:paramtypes", [router_1.ActivatedRoute,
            helper_1.Helper,
            specialty_service_1.SpecialtyService,
            notifications_service_1.NotificationsService, location_1.Location])
    ], AdminSpecialityUpdateComponent);
    return AdminSpecialityUpdateComponent;
}(helper_1.Helper));
exports.AdminSpecialityUpdateComponent = AdminSpecialityUpdateComponent;
//# sourceMappingURL=admin-speciality-update.component.js.map