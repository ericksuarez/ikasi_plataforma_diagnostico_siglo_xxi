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
var skill_century_service_1 = require("../../../services/skill-century.service");
var skill_century_area_service_1 = require("../../../services/skill-century-area.service");
var skill_century_category_service_1 = require("../../../services/skill-century-category.service");
var skill_century_question_century_service_1 = require("../../../services/skill-century-question-century.service");
var notifications_service_1 = require("angular2-notifications/src/notifications.service");
var router_1 = require("@angular/router");
var SkillCenturyQuestionCentury_1 = require("../../../models/SkillCenturyQuestionCentury");
var location_1 = require('@angular/common');
var SkillCenturyCreateQuestionCenturyComponent = (function () {
    function SkillCenturyCreateQuestionCenturyComponent(_skillCenturyAreaService, _skillCenturyService, _skillCenturyCategoryService, _skillCenturyQuestionCentury, _notificationsService, activatedRoute ,location) {
        this._skillCenturyAreaService = _skillCenturyAreaService;
        this._skillCenturyService = _skillCenturyService;
        this._skillCenturyCategoryService = _skillCenturyCategoryService;
        this._skillCenturyQuestionCentury = _skillCenturyQuestionCentury;
        this._notificationsService = _notificationsService;
        this.activatedRoute = activatedRoute;
        //1er parametro id	
        //2do parametro area_id
        //3er parametro category_id
        //4to parametro name
        this.model = new SkillCenturyQuestionCentury_1.SkillQuestionCentury(0, 0, 0, "");
        this.skillId = 0;
        this.skills = [];
        this.areas = [];
        this.questions = [];
        this.categories = [];
        this.loading = true;
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
    SkillCenturyCreateQuestionCenturyComponent.prototype.ngOnInit = function () {
        var _this = this;
        this._skillCenturyService.findAll(-1).subscribe(function (response) {
            _this.skills = response.data;
            _this.loading = false;
        }, function (error) {
            console.log(error);
        });
        this._skillCenturyCategoryService.findAll(-1).subscribe(function (response) {
            _this.categories = response.data;
            _this.loading = false;
        }, function (error) {
            console.log(error);
        });
    };
    SkillCenturyCreateQuestionCenturyComponent.prototype.onSubmit = function () {
        var _this = this;
        //noinspection TypeScriptValidateJSTypes
        jQuery("#skillFormButton").button('loading');
        this._skillCenturyQuestionCentury.create(this.model).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#questionFormButton").button('reset');
            if (response.status == 'success') {
                _this.questions.push(response);
                _this._notificationsService.success(response.title, response.message);
            } else {
                _this._notificationsService.error(response.title, response.message);
            }
        });
    };
    SkillCenturyCreateQuestionCenturyComponent.prototype.showAreas = function (skillId) {
        var _this = this;
        this.loading = true;
        this.areas = [];
        this._skillCenturyAreaService.findAll(skillId, -1).subscribe(function (response) {
            _this.loading = false;
            _this.areas = response.data;
        }, function (error) {
            console.log(error);
        });
    };
    SkillCenturyCreateQuestionCenturyComponent.prototype.setAreaId = function (area_id) {
        this.model.area_id = area_id;
        console.log(this.model);
    };
    SkillCenturyCreateQuestionCenturyComponent.prototype.setCategoryId = function (category_id) {
        this.model.category_id = category_id;
        console.log(this.model);
    };
    SkillCenturyCreateQuestionCenturyComponent.prototype.toGoBack = function () {
        var _this = this;
        _this.location.back();
    };
    SkillCenturyCreateQuestionCenturyComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/skill-century/question-century/create.html',
            providers: [
                skill_century_service_1.SkillCenturyService,
                skill_century_area_service_1.SkillCenturyAreaService,
                skill_century_category_service_1.SkillCenturyCategoryService,
                skill_century_question_century_service_1.SkillCenturyQuestionCenturyService,
                notifications_service_1.NotificationsService,
                location_1.Location
            ]
        }),
        __metadata("design:paramtypes", [skill_century_area_service_1.SkillCenturyAreaService,
            skill_century_service_1.SkillCenturyService,
            skill_century_category_service_1.SkillCenturyCategoryService,
            skill_century_question_century_service_1.SkillCenturyQuestionCenturyService,
            notifications_service_1.NotificationsService,
            router_1.ActivatedRoute,
            location_1.Location
        ])
    ], SkillCenturyCreateQuestionCenturyComponent);
    return SkillCenturyCreateQuestionCenturyComponent;
}());
exports.SkillCenturyCreateQuestionCenturyComponent = SkillCenturyCreateQuestionCenturyComponent;
//# sourceMappingURL=skill-century-create-question-century.component.js.map