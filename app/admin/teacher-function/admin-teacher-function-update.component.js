"use strict";
var __extends = (this && this.__extends) || (function () {
    var extendStatics = Object.setPrototypeOf ||
            ({__proto__: []} instanceof Array && function (d, b) {
                d.__proto__ = b;
            }) ||
            function (d, b) {
                for (var p in b)
                    if (b.hasOwnProperty(p))
                        d[p] = b[p];
            };
    return function (d, b) {
        extendStatics(d, b);
        function __() {
            this.constructor = d;
        }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
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
var location_1 = require('@angular/common')
var catalog_form_1 = require("../../models/catalog_form");
var helper_1 = require("../../helpers/helper");
var router_1 = require("@angular/router");
var notifications_service_1 = require("angular2-notifications/src/notifications.service");
var teacher_function_service_1 = require("../../services/teacher-function.service");
var AdminTeacherFunctionUpdateComponent = (function (_super) {
    __extends(AdminTeacherFunctionUpdateComponent, _super);
    function AdminTeacherFunctionUpdateComponent(activatedRoute, helper, teacherFunctionService, _notificationsService ,location) {
        var _this = _super.call(this) || this;
        _this.activatedRoute = activatedRoute;
        _this.helper = helper;
        _this.location = location;
        _this.teacherFunctionService = teacherFunctionService;
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
    AdminTeacherFunctionUpdateComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.activatedRoute.params.subscribe(function (params) {
            var name = params['name'];
            _this.model.name = _this.helper.base64Decode(name);
            _this.teacherFunctionId = params['id'];
        });
    };
    AdminTeacherFunctionUpdateComponent.prototype.onSubmit = function () {
        var _this = this;
        jQuery("#teacherFunctionFormButton").button('loading');
        this.teacherFunctionService.update(this.model, this.teacherFunctionId).subscribe(function (response) {
            jQuery("#teacherFunctionFormButton").button('reset');
            if (response.status == 'success') {
                _this._notificationsService.success(response.title, response.message);
            } else {
                _this._notificationsService.error(response.title, response.message);
            }
        }, function (error) {
            jQuery("#teacherFunctionFormButton").button('reset');
            _this._notificationsService.error("Error", "Ocurrio un error al tratar de actualizar la información");
        });
    };
    AdminTeacherFunctionUpdateComponent.prototype.toGoBack = function () {
        var _this = this;
        _this.location.back();
    };
    AdminTeacherFunctionUpdateComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/teacher-function/update.html',
            providers: [helper_1.Helper, teacher_function_service_1.TeacherFunctionService, notifications_service_1.NotificationsService, location_1.Location]
        }),
        __metadata("design:paramtypes", [router_1.ActivatedRoute,
            helper_1.Helper,
            teacher_function_service_1.TeacherFunctionService,
            notifications_service_1.NotificationsService, location_1.Location])
    ], AdminTeacherFunctionUpdateComponent);
    return AdminTeacherFunctionUpdateComponent;
}(helper_1.Helper));
exports.AdminTeacherFunctionUpdateComponent = AdminTeacherFunctionUpdateComponent;
//# sourceMappingURL=admin-teacher-function-update.component.js.map