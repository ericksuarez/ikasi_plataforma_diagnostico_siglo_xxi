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
var skill_century_area_service_1 = require("../../../services/skill-century-area.service");
var router_1 = require("@angular/router");
var helper_1 = require("../../../helpers/helper");
var location_1 = require('@angular/common');
var AdminSkillCenturyAreaViewComponent = (function (_super) {
    __extends(AdminSkillCenturyAreaViewComponent, _super);
    function AdminSkillCenturyAreaViewComponent(_skillCenturyAreaService, activatedRoute, location) {
        var _this = _super.call(this) || this;
        _this._skillCenturyAreaService = _skillCenturyAreaService;
        _this.activatedRoute = activatedRoute;
        // Página anterior
        _this.pagePrev = 1;
        // Siguiente página
        _this.pageNext = 1;
        _this.location = location;
        return _this;
    }
    AdminSkillCenturyAreaViewComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.loading = true;
        this.activatedRoute.params.subscribe(function (params) {
            _this.page = params['page'];
            _this.skillId = params['id'];
            
            if (!_this.page) {
                _this.page = 1;
            }
            
            _this._skillCenturyAreaService.view(_this.skillId).subscribe(function (response) {
                if (response.status == 'success') {
                    jQuery("#skill_name").html(response.name); 
                } else {
                    alert("Error al cargar el nombre de la Habilidad.");
                }
            });

            _this._skillCenturyAreaService.findAll(_this.skillId, _this.page).subscribe(function (response) {
                _this.areas = response.data;
                _this.estatus = response.status;
                _this.message = response.message;
                _this.pages = [];
                //noinspection TypeScriptUnresolvedVariable
                for (var i = 0; i < response.total_pages; i++) {
                    _this.pages.push(i);
                }
                if (response.total_pages == 1) {
                    document.getElementById("paginator").style.display = "none";
                }
                _this.pagePrev = (_this.page > 1) ? (parseInt(_this.page) - 1) : _this.page;
                //noinspection TypeScriptUnresolvedVariable
                _this.pageNext = (_this.page < response.total_pages) ? (parseInt(_this.page) + 1) : _this.page;
                _this.loading = false;
            }, function (error) {
                console.log(error);
            });
        });
        jQuery("#main-navigation").find(">ul>li.active").removeClass("active");
        jQuery("#menu-catalog").addClass("active");
    };
    AdminSkillCenturyAreaViewComponent.prototype.toGoBack = function () {
        var _this = this;
        _this.location.back();
    };
    AdminSkillCenturyAreaViewComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/skill-century/area-view.html',
            providers: [skill_century_area_service_1.SkillCenturyAreaService, location_1.Location]
        }),
        __metadata("design:paramtypes", [skill_century_area_service_1.SkillCenturyAreaService,
            router_1.ActivatedRoute, location_1.Location])
    ], AdminSkillCenturyAreaViewComponent);
    return AdminSkillCenturyAreaViewComponent;
}(helper_1.Helper));
exports.AdminSkillCenturyAreaViewComponent = AdminSkillCenturyAreaViewComponent;
//# sourceMappingURL=area-century.view.component.js.map