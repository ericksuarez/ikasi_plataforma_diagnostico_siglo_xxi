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
var core_1 = require('@angular/core');
var platform_browser_1 = require('@angular/platform-browser');
var forms_1 = require('@angular/forms');
var app_component_1 = require('./app.component');
var http_1 = require('@angular/http');
// Importamos la configuración de las rutas
var app_routing_1 = require('./app.routing');
// Importamos los componentes
var logout_component_1 = require('./components/logout.component');
var register_component_1 = require('./components/register.component');
var default_component_1 = require('./components/default.component');
var confirmation_component_1 = require('./components/confirmation.component');
var activate_component_1 = require('./components/activate.component');
var contact_component_1 = require('./components/contact.component');
var not_found_component_1 = require('./components/not-found.component');
var login_component_1 = require('./components/login.component');
var unauthorized_component_1 = require('./components/unauthorized.component');
var app_config_1 = require('./app.config');
var suggested_course_component_1 = require("./components/suggested-course.component");
var password_recovery_component_1 = require("./components/password-recovery.component");
var simple_notifications_module_1 = require("angular2-notifications/src/simple-notifications.module");
var new_password_component_1 = require("./components/new-password.component");
var apply_century_evaluation_component_1 = require("./components/apply-evaluation/apply-century-evaluation.component");
var apply_century_evaluating_component_1 = require("./components/apply-evaluation/apply-century-evaluating.component");
var profile_component_1 = require("./components/profile.component");
var check_component_1 = require("./components/check.component");
var ng2_charts_1 = require("ng2-charts");
var evaluation_teacher_component_1 = require("./components/inee/evaluation-teacher.component");
var questionnaire_inee_component_1 = require("./components/inee/questionnaire-inee.component");
var AppModule = (function () {
    function AppModule() {
    }
    AppModule = __decorate([
        core_1.NgModule({
            imports: [
                platform_browser_1.BrowserModule,
                app_routing_1.AppRoutingModule,
                forms_1.FormsModule,
                http_1.HttpModule,
                http_1.JsonpModule,
                simple_notifications_module_1.SimpleNotificationsModule,
                ng2_charts_1.ChartsModule
            ],
            declarations: [
                app_component_1.AppComponent,
                logout_component_1.LogoutComponent,
                login_component_1.LoginComponent,
                register_component_1.RegisterComponent,
                default_component_1.DefaultComponent,
                confirmation_component_1.ConfirmationComponent,
                activate_component_1.ActivateComponent,
                contact_component_1.ContactComponent,
                not_found_component_1.NotFoundComponent,
                unauthorized_component_1.UnauthorizedComponent,
                suggested_course_component_1.SuggestedCourseComponent,
                password_recovery_component_1.PasswordRecoveryComponent,
                new_password_component_1.NewPasswordComponent,
                apply_century_evaluation_component_1.ApplyCenturyEvaluation,
                apply_century_evaluating_component_1.ApplyCenturyEvaluating,
                profile_component_1.ProfileComponent,
                check_component_1.CheckComponent,
                evaluation_teacher_component_1.EvaluationTeacherComponent,
                questionnaire_inee_component_1.QuestionnaireIneeComponent
            ],
            bootstrap: [app_component_1.AppComponent],
            providers: [
                {
                    provide: app_config_1.APP_CONFIG, useValue: app_config_1.AppConfig
                }
            ]
        }), 
        __metadata('design:paramtypes', [])
    ], AppModule);
    return AppModule;
}());
exports.AppModule = AppModule;
//# sourceMappingURL=app.module.js.map