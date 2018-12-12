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
var skill_century_answer_category_service_1 = require("../../../services/skill-century-answer-category.service");
var notifications_service_1 = require("angular2-notifications/src/notifications.service");
var router_1 = require("@angular/router");
var SkillCenturyAnswerCategory_1 = require("../../../models/SkillCenturyAnswerCategory");
var location_1 = require('@angular/common');
var SkillCenturyCreateAnswerByCategoryComponent = (function () {
    function SkillCenturyCreateAnswerByCategoryComponent(_skillCenturyAnswerCategoryService, _notificationsService, activatedRoute ,location) {
        this._skillCenturyAnswerCategoryService = _skillCenturyAnswerCategoryService;
        this._notificationsService = _notificationsService;
        this.activatedRoute = activatedRoute;
        //1er parametro id
        //2do parametro category_id
        //3er parametro name
        //4to parametro value
        this.model = new SkillCenturyAnswerCategory_1.SkillCenturyAnswerCategory(0, 0, "", 0);
        this.categoryId = 0;
        this.answers = [];
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
    SkillCenturyCreateAnswerByCategoryComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.activatedRoute.params.subscribe(function (params) {
            _this.categoryId = params['id'];
        });
        this.model.category_id = this.categoryId;
    };
    SkillCenturyCreateAnswerByCategoryComponent.prototype.onSubmit = function () {
        var _this = this;
        //noinspection TypeScriptValidateJSTypes
        jQuery("#answerFormButton").button('loading');
        this._skillCenturyAnswerCategoryService.create(this.model).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#answerFormButton").button('reset');
            if (response.status == 'success') {
                _this.answers.push(response);
                _this._notificationsService.success(response.title, response.message);
            }
            else {
                _this._notificationsService.error(response.title, response.message);
            }
        });
    };
    SkillCenturyCreateAnswerByCategoryComponent.prototype.toGoBack = function () {
        var _this = this;
        _this.location.back();
    };    
    SkillCenturyCreateAnswerByCategoryComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/skill-century/answer-by-category/create.html',
            providers: [skill_century_answer_category_service_1.SkillCenturyAnswerCategoryService, notifications_service_1.NotificationsService, 
                location_1.Location]
        }),
        __metadata("design:paramtypes", [skill_century_answer_category_service_1.SkillCenturyAnswerCategoryService,
            notifications_service_1.NotificationsService,
            router_1.ActivatedRoute, 
            location_1.Location])
    ], SkillCenturyCreateAnswerByCategoryComponent);
    return SkillCenturyCreateAnswerByCategoryComponent;
}());
exports.SkillCenturyCreateAnswerByCategoryComponent = SkillCenturyCreateAnswerByCategoryComponent;
//# sourceMappingURL=skill-century-create-answer-by-category.component.js.map