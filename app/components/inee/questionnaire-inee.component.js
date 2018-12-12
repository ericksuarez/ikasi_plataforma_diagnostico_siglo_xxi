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
var evaluation_inee_service_1 = require("../../services/evaluation-inee.service");
var router_1 = require("@angular/router");
var notifications_service_1 = require("angular2-notifications/src/notifications.service");
var QuestionnaireIneeComponent = (function () {
    function QuestionnaireIneeComponent(evaluationIneeService, _activatedRoute, _notificationsService, _router) {
        this.evaluationIneeService = evaluationIneeService;
        this._activatedRoute = _activatedRoute;
        this._notificationsService = _notificationsService;
        this._router = _router;
        this.questions = [];
        this.form = {
            dimension: null,
            answers: {},
            total: null
        };
        this.options = {
            timeOut: 5000,
            lastOnBottom: true,
            clickToClose: false,
            maxLength: 0,
            maxStack: 7,
            showProgressBar: true,
            pauseOnHover: false,
            preventDuplicates: false,
            preventLastDuplicates: 'visible',
            rtl: false,
            animate: 'scale',
            position: ['right', 'bottom']
        };
    }
    QuestionnaireIneeComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.loading = true;
        jQuery("#main-navigation").find(">ul>li.active").removeClass("active");
        jQuery("#menu-century-xxi-evaluation").addClass("active");
        this._activatedRoute.params.subscribe(function (params) {
            _this.form.dimension = params['dimension'];
            _this.evaluationIneeService.getQuestionnaire(params['dimension'], params['educationLevel'], params['teacherFunction']).subscribe(function (response) {
                _this.loading = false;
                _this.questions = response;
                _this.education_level_name = _this.questions[0].educationLevel;
                _this.form.total = _this.questions.length;
            }, function (error) {
                console.log(error);
            });
        });
    };
    QuestionnaireIneeComponent.prototype.onSubmit = function () {
        var _this = this;
        jQuery("#questionnaireFormButton").button('loading');
        this.evaluationIneeService.save(this.form).subscribe(function (response) {
            jQuery("#questionnaireFormButton").button('reset');
            if (response.status == 'success') {
                _this._notificationsService.success(response.title, response.message);
                setTimeout(function () {
                    _this._router.navigate(["/evaluation-inee/index"]);
                }, 5000);
            }
            else {
                _this._notificationsService.error(response.title, response.message);
            }
        }, function (error) {
            jQuery("#questionnaireFormButton").button('reset');
            _this._notificationsService.error("Error", "Ocurrió un problema con el servidor");
        });
    };
    QuestionnaireIneeComponent = __decorate([
        core_1.Component({
            selector: 'questionnaire-inee',
            templateUrl: 'app/views/inee/questionnaire.html',
            providers: [evaluation_inee_service_1.EvaluationIneeService, notifications_service_1.NotificationsService]
        }),
        __metadata("design:paramtypes", [evaluation_inee_service_1.EvaluationIneeService, router_1.ActivatedRoute,
            notifications_service_1.NotificationsService, router_1.Router])
    ], QuestionnaireIneeComponent);
    return QuestionnaireIneeComponent;
}());
exports.QuestionnaireIneeComponent = QuestionnaireIneeComponent;
//# sourceMappingURL=questionnaire-inee.component.js.map