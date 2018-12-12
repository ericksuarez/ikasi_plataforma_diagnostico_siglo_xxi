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
var router_1 = require('@angular/router');
// Componentes
var register_component_1 = require('./components/register.component');
var default_component_1 = require('./components/default.component');
var logout_component_1 = require('./components/logout.component');
var not_found_component_1 = require('./components/not-found.component');
var confirmation_component_1 = require('./components/confirmation.component');
var activate_component_1 = require('./components/activate.component');
var contact_component_1 = require('./components/contact.component');
var login_component_1 = require("./components/login.component");
var auth_guard_service_1 = require("./services/auth-guard.service");
var auth_service_1 = require("./services/auth.service");
var unauthorized_component_1 = require("./components/unauthorized.component");
var suggested_course_component_1 = require("./components/suggested-course.component");
var password_recovery_component_1 = require("./components/password-recovery.component");
var new_password_component_1 = require("./components/new-password.component");
var apply_century_evaluation_component_1 = require("./components/apply-evaluation/apply-century-evaluation.component");
var apply_century_evaluating_component_1 = require("./components/apply-evaluation/apply-century-evaluating.component");
var profile_component_1 = require("./components/profile.component");
var check_component_1 = require("./components/check.component");
var evaluation_teacher_component_1 = require("./components/inee/evaluation-teacher.component");
var questionnaire_inee_component_1 = require("./components/inee/questionnaire-inee.component");
var routes = [
    { path: '', redirectTo: '/index', pathMatch: 'full', canActivate: [auth_guard_service_1.AuthGuard] },
    { path: 'login', component: login_component_1.LoginComponent },
    { path: 'register', component: register_component_1.RegisterComponent },
    { path: 'register/:data', component: register_component_1.RegisterComponent },
    { path: 'index', component: default_component_1.DefaultComponent, canActivate: [auth_guard_service_1.AuthGuard] },
    { path: 'logout', component: logout_component_1.LogoutComponent },
    { path: '404', component: not_found_component_1.NotFoundComponent },
    { path: 'unauthorized', component: unauthorized_component_1.UnauthorizedComponent },
    { path: 'confirmation', component: confirmation_component_1.ConfirmationComponent },
    { path: 'activate/:id/:authKey', component: activate_component_1.ActivateComponent },
    { path: 'contact', component: contact_component_1.ContactComponent },
    { path: 'suggested-course', component: suggested_course_component_1.SuggestedCourseComponent, canActivate: [auth_guard_service_1.AuthGuard] },
    { path: 'profile', component: profile_component_1.ProfileComponent, canActivate: [auth_guard_service_1.AuthGuard] },
    { path: 'password-recovery', component: password_recovery_component_1.PasswordRecoveryComponent },
    { path: 'new-password/:id/:token', component: new_password_component_1.NewPasswordComponent },
    { path: 'check', component: check_component_1.CheckComponent },
    { path: 'admin', loadChildren: 'app/admin/admin.module#AdminModule', canLoad: [auth_guard_service_1.AuthGuard] },
    {
        path: 'evaluation-xxi',
        canActivateChild: [auth_guard_service_1.AuthGuard],
        children: [
            {
                path: '',
                redirectTo: '/evaluation-xxi/index',
                pathMatch: 'full',
                canActivate: [auth_guard_service_1.AuthGuard]
            },
            { path: 'index', component: apply_century_evaluation_component_1.ApplyCenturyEvaluation },
            { path: 'evaluating/:id/:name', component: apply_century_evaluating_component_1.ApplyCenturyEvaluating }
        ]
    },
    {
        path: 'evaluation-inee',
        canActivateChild: [auth_guard_service_1.AuthGuard],
        children: [
            {
                path: '',
                redirectTo: '/evaluation-inee/index',
                pathMatch: 'full',
                canActivate: [auth_guard_service_1.AuthGuard]
            },
            { path: 'index', component: evaluation_teacher_component_1.EvaluationTeacherComponent },
            { path: 'questionnaire/:dimension/:educationLevel/:teacherFunction', component: questionnaire_inee_component_1.QuestionnaireIneeComponent }
        ]
    },
    { path: '**', redirectTo: '/404', pathMatch: 'full' }
];
var AppRoutingModule = (function () {
    function AppRoutingModule() {
    }
    AppRoutingModule = __decorate([
        core_1.NgModule({
            imports: [router_1.RouterModule.forRoot(routes)],
            exports: [router_1.RouterModule],
            providers: [auth_guard_service_1.AuthGuard, auth_service_1.AuthService]
        }), 
        __metadata('design:paramtypes', [])
    ], AppRoutingModule);
    return AppRoutingModule;
}());
exports.AppRoutingModule = AppRoutingModule;
//# sourceMappingURL=app.routing.js.map