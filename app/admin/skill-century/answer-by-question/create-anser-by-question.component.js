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
var skill_century_answer_by_question_service_1 = require("../../../services/skill-century-answer-by-question.service");
var notifications_service_1 = require("angular2-notifications/src/notifications.service");
var router_1 = require("@angular/router");
var AnswerQuestionCentury_1 = require("../../../models/AnswerQuestionCentury");
var location_1 = require('@angular/common');
var AnswerQuestionCenturyCreateComponent = (function () {
    function AnswerQuestionCenturyCreateComponent(_skillCenturyAnswerByQuestionService, _notificationsService, activatedRoute ,location) {
        this._skillCenturyAnswerByQuestionService = _skillCenturyAnswerByQuestionService;
        this._notificationsService = _notificationsService;
        this.activatedRoute = activatedRoute;
        this.model = new AnswerQuestionCentury_1.AnswerQuestionCentury();
        this.questionId = 0;
        this.answers = [];
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
    AnswerQuestionCenturyCreateComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.activatedRoute.params.subscribe(function (params) {
            _this.questionId = params['id'];
            _this.question = params["question"];
        });
        this._skillCenturyAnswerByQuestionService.findAll(this.questionId, 1).subscribe(function (response) {
            if (response.status != "error") {
                _this.question = response.pregunta;
                _this.answers = response.data;
            }
            _this.loading = false;
        }, function (error) {
            console.log(error);
        });
        this.model.questionId = this.questionId;
    };
    AnswerQuestionCenturyCreateComponent.prototype.onSubmit = function () {
        var _this = this;
        //noinspection TypeScriptValidateJSTypes
        jQuery("#skillFormButtonSave").button('loading');
        this._skillCenturyAnswerByQuestionService.create(this.model).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#skillFormButtonSave").button('reset');
            if (response.status == 'success') {
                _this.answers.push(response);
                _this._notificationsService.success(response.title, response.message);
            } else {
                _this._notificationsService.error(response.title, response.message);
            }
        });
    };
    AnswerQuestionCenturyCreateComponent.prototype.toGoBack = function () {
        var _this = this;
        _this.location.back();
    };
    AnswerQuestionCenturyCreateComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/skill-century/answer-question/create.html',
            providers: [skill_century_answer_by_question_service_1.SkillCenturyAnswerByQuestionService, notifications_service_1.NotificationsService,
                location_1.Location]
        }),
        __metadata("design:paramtypes", [skill_century_answer_by_question_service_1.SkillCenturyAnswerByQuestionService,
            notifications_service_1.NotificationsService,
            router_1.ActivatedRoute,
            location_1.Location])
    ], AnswerQuestionCenturyCreateComponent);
    return AnswerQuestionCenturyCreateComponent;
}());
exports.AnswerQuestionCenturyCreateComponent = AnswerQuestionCenturyCreateComponent;
//# sourceMappingURL=create-anser-by-question.component.js.map