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
var skill_century_answer_category_service_1 = require("../../../services/skill-century-answer-category.service");
var notifications_service_1 = require("angular2-notifications/src/notifications.service");
var router_1 = require("@angular/router");
var SkillCenturyAnswerCategory_1 = require("../../../models/SkillCenturyAnswerCategory");
var location_1 = require('@angular/common');
var SkillCenturyEditAnswerCategoryComponent = (function () {
    function SkillCenturyEditAnswerCategoryComponent(_skillCenturyAnswerCategoryService, _notificationsService, activatedRoute, _router, location) {
        this._skillCenturyAnswerCategoryService = _skillCenturyAnswerCategoryService;
        this._notificationsService = _notificationsService;
        this.activatedRoute = activatedRoute;
        this._router = _router;
        this.model = new SkillCenturyAnswerCategory_1.SkillCenturyAnswerCategory(0, 0, "", 0);
        this.answerId = 0;
        this.categoryId = 0;
        this.answers = [];
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
    SkillCenturyEditAnswerCategoryComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.activatedRoute.params.subscribe(function (params) {
            _this.answerId = params['answerId'];
            _this.categoryId = params['categoryId'];
            _this._skillCenturyAnswerCategoryService.answerDetail(_this.answerId).subscribe(function (response) {
                if (response.status == "success") {
                    var answer = response.data;
                    _this.model.id = answer.id;
                    _this.model.category_id = answer.category.id;
                    _this.model.name = answer.name;
                    _this.model.value = answer.value;
                }
            });
        });
    };
    SkillCenturyEditAnswerCategoryComponent.prototype.onSubmit = function () {
        var _this = this;
        this._notificationsService.info("Guardando", "...");
        this._skillCenturyAnswerCategoryService.edit(this.model).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#skillFormButton").button('reset');
            if (response.status == 'success') {
                _this._notificationsService.success(response.title, response.message);
                _this._router.navigate(["/admin/skill-century/view-questions-by-category/" + _this.categoryId]);
            } else {
                _this._notificationsService.error(response.title, response.message);
            }
        });
    };
    SkillCenturyEditAnswerCategoryComponent.prototype.toGoBack = function () {
        var _this = this;
        _this.location.back();
    };
    SkillCenturyEditAnswerCategoryComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/skill-century/answer-by-category/create.html',
            providers: [skill_century_answer_category_service_1.SkillCenturyAnswerCategoryService, notifications_service_1.NotificationsService,
                location_1.Location]
        }),
        __metadata("design:paramtypes", [skill_century_answer_category_service_1.SkillCenturyAnswerCategoryService,
            notifications_service_1.NotificationsService,
            router_1.ActivatedRoute,
            router_1.Router,
            location_1.Location])
    ], SkillCenturyEditAnswerCategoryComponent);
    return SkillCenturyEditAnswerCategoryComponent;
}());
exports.SkillCenturyEditAnswerCategoryComponent = SkillCenturyEditAnswerCategoryComponent;
//# sourceMappingURL=skill-century-edit-answer-by-category.component.js.map