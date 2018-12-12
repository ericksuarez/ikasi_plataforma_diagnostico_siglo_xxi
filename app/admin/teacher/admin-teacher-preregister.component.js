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
var router_1 = require("@angular/router");
var teacher_service_1 = require("../../services/teacher.service");
var AdminTeacherPreRegisterComponent = (function () {
    function AdminTeacherPreRegisterComponent(teacherService, activatedRoute) {
        this.teacherService = teacherService;
        this.activatedRoute = activatedRoute;
        this.teachersList = [];
        // Página anterior
        this.pagePrev = 1;
        // Siguiente página
        this.pageNext = 1;
    }
    AdminTeacherPreRegisterComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.loading = true;
        this.activatedRoute.params.subscribe(function (params) {
            _this.page = params['page'];
            if (!_this.page) {
                _this.page = 1;
            }
            _this.teacherService.findAllPreRegister(_this.page).subscribe(function (response) {
                _this.teachersList = response.data;
                _this.pages = [];
                //noinspection TypeScriptUnresolvedVariable
                for (var i = 0; i < response.total_pages; i++) {
                    _this.pages.push(i);
                }
                _this.pagePrev = (_this.page > 1) ? (parseInt(_this.page) - 1) : _this.page;
                //noinspection TypeScriptUnresolvedVariable
                _this.pageNext = (_this.page < response.total_pages) ? (parseInt(_this.page) + 1) : _this.page;
                _this.loading = false;
            }, function (error) {
                console.log(error);
            });
            console.log(_this.page);
        });
        jQuery("#main-navigation").find(">ul>li.active").removeClass("active");
        jQuery("#menu-teacher").addClass("active");
    };
    AdminTeacherPreRegisterComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/teacher/pre-register.html',
            providers: [teacher_service_1.TeacherService]
        }),
        __metadata("design:paramtypes", [teacher_service_1.TeacherService,
            router_1.ActivatedRoute])
    ], AdminTeacherPreRegisterComponent);
    return AdminTeacherPreRegisterComponent;
}());
exports.AdminTeacherPreRegisterComponent = AdminTeacherPreRegisterComponent;
//# sourceMappingURL=admin-teacher-preregister.component.js.map