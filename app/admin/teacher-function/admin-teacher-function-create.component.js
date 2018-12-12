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
var location_1 = require('@angular/common');
var catalog_form_1 = require("../../models/catalog_form");
var notifications_service_1 = require("angular2-notifications/src/notifications.service");
var teacher_function_service_1 = require("../../services/teacher-function.service");
var AdminTeacherFunctionCreateComponent = (function () {
    function AdminTeacherFunctionCreateComponent(educationLevelService, _notificationsService ,location) {
        this.educationLevelService = educationLevelService;
        this.location = location;
        this._notificationsService = _notificationsService;
        this.model = new catalog_form_1.CatalogForm();
        this.teacherFunctionList = [];
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
    AdminTeacherFunctionCreateComponent.prototype.onSubmit = function () {
        var _this = this;
        //noinspection TypeScriptValidateJSTypes
        jQuery("#teacherFunctionFormButton").button('loading');
        this.educationLevelService.create(this.model).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#teacherFunctionFormButton").button('reset');
            if (response.status == 'success') {
                _this.teacherFunctionList.push(response);
                _this._notificationsService.success(response.title, response.message);
            }
            else {
                _this._notificationsService.error(response.title, response.message);
            }
        });
    };
    AdminTeacherFunctionCreateComponent.prototype.toGoBack = function () {
        var _this = this;
        _this.location.back();
    };    
    AdminTeacherFunctionCreateComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/teacher-function/create.html',
            providers: [teacher_function_service_1.TeacherFunctionService, notifications_service_1.NotificationsService, location_1.Location]
        }),
        __metadata("design:paramtypes", [teacher_function_service_1.TeacherFunctionService, notifications_service_1.NotificationsService, location_1.Location])
    ], AdminTeacherFunctionCreateComponent);
    return AdminTeacherFunctionCreateComponent;
}());
exports.AdminTeacherFunctionCreateComponent = AdminTeacherFunctionCreateComponent;
//# sourceMappingURL=admin-teacher-function-create.component.js.map