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
var skill_century_answer_category_service_1 = require("../../../services/skill-century-answer-category.service");
var router_1 = require("@angular/router");
var helper_1 = require("../../../helpers/helper");
var location_1 = require('@angular/common');
var notifications_service_1 = require("angular2-notifications/src/notifications.service");
var SkillCenturyAnswerByCategoryComponent = (function (_super) {
    __extends(SkillCenturyAnswerByCategoryComponent, _super);
    function SkillCenturyAnswerByCategoryComponent(_skillCenturyAnswerCategoryService, activatedRoute ,location, _notificationsService) {
        var _this = _super.call(this) || this;
        _this._skillCenturyAnswerCategoryService = _skillCenturyAnswerCategoryService;
        _this.activatedRoute = activatedRoute;
        // Página anterior
        _this.pagePrev = 1;
        // Siguiente página
        _this.pageNext = 1;
        _this.location = location;
		_this._notificationsService = _notificationsService;
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
        return _this;
    }
    SkillCenturyAnswerByCategoryComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.loading = true;
        this.activatedRoute.params.subscribe(function (params) {
            _this.page = params['page'];
            _this.categoryId = params['id'];
            if (!_this.page) {
                _this.page = 1;
            }
            _this._skillCenturyAnswerCategoryService.findAll(_this.categoryId, _this.page).subscribe(function (response) {
                _this.answers = response.data;
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
    SkillCenturyAnswerByCategoryComponent.prototype.toGoBack = function () {
        var _this = this;
        _this.location.back();
    };    
    SkillCenturyAnswerByCategoryComponent.prototype.delete = function (id) {
        var _this = this;

        $.confirm({
            icon: 'fa fa-warning',
            closeIcon: true,
            title: '¡Confirmación!',
            content: '¿Está seguro que desea eliminar este elemento de la lista?',
            type: 'red',
            typeAnimated: true,
            autoClose: 'close|8000',
            buttons: {
                acptar: {
                    text: 'Aceptar',
                    btnClass: 'btn-green',
                    action: function () {
                        _this._skillCenturyAnswerCategoryService.delete(id).subscribe(function (response) {
                            if (response.status === 200) {
                                _this._notificationsService.success(response.title, response.message);
                                _this.loading = true;

                                _this._skillCenturyAnswerCategoryService.findAll(_this.categoryId, _this.page).subscribe(function (response) {
									_this.answers = response.data;
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
                                    _this._notificationsService.error("Error!!!", "No se logro cargar el listado.");
                                });

                                jQuery("#main-navigation").find(">ul>li.active").removeClass("active");
                                jQuery("#menu-catalog").addClass("active")
                            } else {
                                _this._notificationsService.error(response.title, response.message);
                            }
                        });
                    }
                },
                close: {
                    text: 'Cancelar',
                    btnClass: 'btn-red',
                    action: function () {
                    }
                }
            }
        });
    }
    SkillCenturyAnswerByCategoryComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/skill-century/answer-by-category/index.html',
            providers: [skill_century_answer_category_service_1.SkillCenturyAnswerCategoryService, location_1.Location, notifications_service_1.NotificationsService]
        }),
        __metadata("design:paramtypes", [skill_century_answer_category_service_1.SkillCenturyAnswerCategoryService,
            router_1.ActivatedRoute, 
            location_1.Location, notifications_service_1.NotificationsService])
    ], SkillCenturyAnswerByCategoryComponent);
    return SkillCenturyAnswerByCategoryComponent;
}(helper_1.Helper));
exports.SkillCenturyAnswerByCategoryComponent = SkillCenturyAnswerByCategoryComponent;
//# sourceMappingURL=skill-century-answer-by-category.component.js.map