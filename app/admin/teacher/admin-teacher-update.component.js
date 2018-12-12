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
var user_1 = require("../../models/user");
var router_1 = require("@angular/router");
var helper_1 = require("../../helpers/helper");
var teacher_service_1 = require("../../services/teacher.service");
var notifications_service_1 = require("angular2-notifications/src/notifications.service");
var AdminTeacherUpdateComponent = (function (_super) {
    __extends(AdminTeacherUpdateComponent, _super);
    function AdminTeacherUpdateComponent(activatedRoute, helper, teacherService, _notificationsService) {
        var _this = _super.call(this) || this;
        _this.activatedRoute = activatedRoute;
        _this.helper = helper;
        _this.teacherService = teacherService;
        _this._notificationsService = _notificationsService;
        _this.options = {
            timeOut: 5000,
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
    AdminTeacherUpdateComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.activatedRoute.params.subscribe(function (params) {
            var id = params['userId'];
            var email = params['email'];
            var status = params['status'];
            _this.teacherId = params['id'];
            _this.oldEmail = _this.helper.base64Decode(email);
            _this.model = new user_1.User(id, _this.helper.base64Decode(email), status, "");
        });
    };
    AdminTeacherUpdateComponent.prototype.onSubmit = function () {
        var _this = this;
        //noinspection TypeScriptValidateJSTypes
        jQuery("#updateTeacherButton").button('loading');
        this.teacherService.updateUser(this.model).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#updateTeacherButton").button('reset');
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
    AdminTeacherUpdateComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/teacher/update.html',
            providers: [helper_1.Helper, teacher_service_1.TeacherService, notifications_service_1.NotificationsService]
        }),
        __metadata("design:paramtypes", [router_1.ActivatedRoute,
            helper_1.Helper,
            teacher_service_1.TeacherService,
            notifications_service_1.NotificationsService])
    ], AdminTeacherUpdateComponent);
    return AdminTeacherUpdateComponent;
}(helper_1.Helper));
exports.AdminTeacherUpdateComponent = AdminTeacherUpdateComponent;
//# sourceMappingURL=admin-teacher-update.component.js.map