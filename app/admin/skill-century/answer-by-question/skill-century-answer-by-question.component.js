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
var skill_century_answer_by_question_service_1 = require("../../../services/skill-century-answer-by-question.service");
var router_1 = require("@angular/router");
var helper_1 = require("../../../helpers/helper");
var SkillCenturyAnswerByQuestionComponent = (function (_super) {
    __extends(SkillCenturyAnswerByQuestionComponent, _super);
    function SkillCenturyAnswerByQuestionComponent(_skillCenturyAnswerByQuestionService, activatedRoute) {
        var _this = _super.call(this) || this;
        _this._skillCenturyAnswerByQuestionService = _skillCenturyAnswerByQuestionService;
        _this.activatedRoute = activatedRoute;
        // Página anterior
        _this.pagePrev = 1;
        // Siguiente página
        _this.pageNext = 1;
        return _this;
    }
    SkillCenturyAnswerByQuestionComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.loading = true;
        this.activatedRoute.params.subscribe(function (params) {
            _this.questionId = params['id'];
            _this.page = params['page'];
            if (!_this.page) {
                _this.page = 1;
            }
            _this._skillCenturyAnswerByQuestionService.findAll(_this.questionId, _this.page).subscribe(function (response) {
                _this.pregunta = response.pregunta;
                _this.answers = response.data;
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
    SkillCenturyAnswerByQuestionComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/skill-century/answer-question/index.html',
            providers: [skill_century_answer_by_question_service_1.SkillCenturyAnswerByQuestionService]
        }),
        __metadata("design:paramtypes", [skill_century_answer_by_question_service_1.SkillCenturyAnswerByQuestionService,
            router_1.ActivatedRoute])
    ], SkillCenturyAnswerByQuestionComponent);
    return SkillCenturyAnswerByQuestionComponent;
}(helper_1.Helper));
exports.SkillCenturyAnswerByQuestionComponent = SkillCenturyAnswerByQuestionComponent;
//# sourceMappingURL=skill-century-answer-by-question.component.js.map