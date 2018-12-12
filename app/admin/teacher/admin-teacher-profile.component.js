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
var router_1 = require("@angular/router");
var teacher_service_1 = require("../../services/teacher.service");
var helper_1 = require("../../helpers/helper");
var AdminTeacherProfileComponent = (function (_super) {
    __extends(AdminTeacherProfileComponent, _super);
    function AdminTeacherProfileComponent(activatedRoute, teacherService) {
        var _this = _super.call(this) || this;
        _this.activatedRoute = activatedRoute;
        _this.teacherService = teacherService;
        _this.teacher = {
            user: {},
            speciality: {},
            teacherFunction: {},
            educationLevel: {},
            createTime: {}
        };
        return _this;
    }
    AdminTeacherProfileComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.loading = true;
        this.activatedRoute.params.subscribe(function (params) {
            var id = params['id'];
            _this.teacherService.getProfile(id).subscribe(function (response) {
                _this.teacher = response;
                _this.loading = false;
            });
        });
    };
    AdminTeacherProfileComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/teacher/profile.html',
            providers: [teacher_service_1.TeacherService]
        }),
        __metadata("design:paramtypes", [router_1.ActivatedRoute,
            teacher_service_1.TeacherService])
    ], AdminTeacherProfileComponent);
    return AdminTeacherProfileComponent;
}(helper_1.Helper));
exports.AdminTeacherProfileComponent = AdminTeacherProfileComponent;
//# sourceMappingURL=admin-teacher-profile.component.js.map