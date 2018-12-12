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
var notifications_service_1 = require("angular2-notifications/src/notifications.service");
var router_1 = require("@angular/router");
var auth_service_1 = require("../../services/auth.service");
var skill_century_question_century_service_1 = require("../../services/skill-century-question-century.service");
var skill_century_teacher_answer_century_service_1 = require("../../services/skill-century-teacher-answer-century.service");
var ApplyCenturyEvaluating = (function () {
    function ApplyCenturyEvaluating(_skillCenturyQuestionCenturyService, _skillCenturyTeacherAnswerCenturyService, _authService, activatedRoute, _notificationsService, _router) {
        this._skillCenturyQuestionCenturyService = _skillCenturyQuestionCenturyService;
        this._skillCenturyTeacherAnswerCenturyService = _skillCenturyTeacherAnswerCenturyService;
        this._authService = _authService;
        this.activatedRoute = activatedRoute;
        this._notificationsService = _notificationsService;
        this._router = _router;
        this.loading = false;
        this.answers = [];
    }
    ApplyCenturyEvaluating.prototype.ngOnInit = function () {
        var _this = this;
        jQuery("#main-navigation").find(">ul>li.active").removeClass("active");
        jQuery("#menu-century-xxi-evaluation").addClass("active");
        this.loading = true;
        this.activatedRoute.params.subscribe(function (params) {
            _this.area = params['name'];
        });
        this.activatedRoute.params.subscribe(function (params) {
            _this.areaId = params['id'];
            _this._skillCenturyQuestionCenturyService.findByArea(_this.areaId, _this._authService.getProfile().sub).subscribe(function (response) {
                _this.categories = response.data;
                _this.skill_century = response.skill_century;
                console.log(response);
                _this.loading = false;
            }, function (error) {
                console.log(error);
            });
        });
    };
    ApplyCenturyEvaluating.prototype.addValue = function (questionId, answerId) {
        this.answers["q_" + questionId] = answerId;
        this.json = "[";
        for (var i in this.answers) {
            this.json += '{"' + i + '": ' + this.answers[i] + '},';
        }
        this.json += "]";
    };
    ApplyCenturyEvaluating.prototype.saveAnswers = function () {
        var _this = this;
        //noinspection TypeScriptValidateJSTypes
        jQuery(".saveButton").val("Guardando...");
        document.getElementsByClassName("guar");
        this._skillCenturyTeacherAnswerCenturyService.saveAnswer(this.json, this._authService.getProfile().sub).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#skillFormButton").button('reset');
            if (response.status == 'success') {
                _this._router.navigate(["/evaluation-xxi/index"]);
                //alert("Guardado correctamente");
            } else {
                _this._notificationsService.error(response.title, response.message);
            }
        });
    };
    ApplyCenturyEvaluating = __decorate([
        core_1.Component({
            templateUrl: 'app/views/apply-evaluation/evaluating.html',
            providers: [skill_century_question_century_service_1.SkillCenturyQuestionCenturyService, auth_service_1.AuthService, skill_century_teacher_answer_century_service_1.SkillCenturyTeacherAnswerCenturyService, notifications_service_1.NotificationsService]
        }),
        __metadata("design:paramtypes", [skill_century_question_century_service_1.SkillCenturyQuestionCenturyService,
            skill_century_teacher_answer_century_service_1.SkillCenturyTeacherAnswerCenturyService,
            auth_service_1.AuthService,
            router_1.ActivatedRoute,
            notifications_service_1.NotificationsService,
            router_1.Router])
    ], ApplyCenturyEvaluating);
    return ApplyCenturyEvaluating;
}());
exports.ApplyCenturyEvaluating = ApplyCenturyEvaluating;
//# sourceMappingURL=apply-century-evaluating.component.js.map