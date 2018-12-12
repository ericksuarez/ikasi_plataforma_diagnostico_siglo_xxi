"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = require("@angular/core");
var router_1 = require("@angular/router");
var admin_component_1 = require("./admin.component");
var admin_dashboard_component_1 = require("./admin-dashboard.component");
var auth_guard_service_1 = require("../services/auth-guard.service");
var auth_service_1 = require("../services/auth.service");
var admin_course_component_1 = require("./course/admin-course.component");
var admin_evaluation_component_1 = require("./evaluation/admin-evaluation.component");
var admin_teacher_component_1 = require("./teacher/admin-teacher.component");
var admin_speciality_component_1 = require("./speciality/admin-speciality.component");
var admin_level_education_component_1 = require("./level-education/admin-level-education.component");
var admin_teacher_function_component_1 = require("./teacher-function/admin-teacher-function.component");
var admin_skill_century_component_1 = require("./skill-century/admin-skill-century.component");
var admin_skill_inee_component_1 = require("./skill-inee/admin-skill-inee.component");
var admin_speciality_create_component_1 = require("./speciality/admin-speciality-create.component");
var admin_level_education_create_component_1 = require("./level-education/admin-level-education-create.component");
var admin_teacher_function_create_component_1 = require("./teacher-function/admin-teacher-function-create.component");
var admin_teacher_profile_component_1 = require("./teacher/admin-teacher-profile.component");
var admin_teacher_update_component_1 = require("./teacher/admin-teacher-update.component");
var admin_course_create_component_1 = require("./course/admin-course-create.component");
var admin_skill_inee_create_dimension_component_1 = require("./skill-inee/admin-skill-inee-create-dimension.component");
var admin_create_parameter_component_1 = require("./skill-inee/admin-create-parameter.component");
var admin_indicator_create_component_1 = require("./skill-inee/admin-indicator-create.component");
var admin_course_view_component_1 = require("./course/admin-course-view.component");
var admin_course_update_component_1 = require("./course/admin-course-update.component");
var admin_skill_century_create_component_1 = require("./skill-century/admin-skill-century-create.component");
var admin_skill_century_edit_component_1 = require("./skill-century/admin-skill-century-edit.component");
var area_century_view_component_1 = require("./skill-century/area/area-century.view.component");
var area_century_create_component_1 = require("./skill-century/area/area-century.create.component");
var area_century_edit_component_1 = require("./skill-century/area/area-century.edit.component");
var admin_profile_component_1 = require("./components/admin-profile.component");
var admin_skill_century_categories_component_1 = require("./skill-century/categories/admin-skill-century-categories.component");
var admin_skill_century_edit_categories_component_1 = require("./skill-century/categories/admin-skill-century-edit-categories.component");
var admin_skill_century_create_category_component_1 = require("./skill-century/categories/admin-skill-century-create-category.component");
var skill_century_answer_by_category_component_1 = require("./skill-century/answer-by-category/skill-century-answer-by-category.component");
var skill_century_create_answer_by_category_component_1 = require("./skill-century/answer-by-category/skill-century-create-answer-by-category.component");
var skill_century_edit_answer_by_category_component_1 = require("./skill-century/answer-by-category/skill-century-edit-answer-by-category.component");
var skill_century_view_question_century_component_1 = require("./skill-century/question-century/skill-century-view-question-century.component");
var skill_century_create_question_century_component_1 = require("./skill-century/question-century/skill-century-create-question-century.component");
var skill_century_answer_by_question_component_1 = require("./skill-century/answer-by-question/skill-century-answer-by-question.component");
var create_anser_by_question_component_1 = require("./skill-century/answer-by-question/create-anser-by-question.component");
var skill_century_import_question_century_component_1 = require("./skill-century/question-century/skill-century-import-question-century.component");
var admin_teacher_preregister_component_1 = require("./teacher/admin-teacher-preregister.component");
var admin_teacher_import_component_1 = require("./teacher/admin-teacher-import.component");
var admin_import_inee_component_1 = require("./skill-inee/admin-import-inee.component");
var admin_inee_evaluation_component_1 = require("./inee/evaluation/admin-inee-evaluation.component");
var admin_inee_evaluation_create_component_1 = require("./inee/evaluation/admin-inee-evaluation-create.component");
var admin_inee_evaluation_import_component_1 = require("./inee/evaluation/admin-inee-evaluation-import.component");
var admin_inee_evaluation_update_component_1 = require("./inee/evaluation/admin-inee-evaluation-update.component");
var admin_speciality_update_component_1 = require("./speciality/admin-speciality-update.component");
var admin_level_education_update_component_1 = require("./level-education/admin-level-education-update.component");
var admin_teacher_function_update_component_1 = require("./teacher-function/admin-teacher-function-update.component");
var AdminRoutingModule = (function () {
    function AdminRoutingModule() {
    }
    AdminRoutingModule = __decorate([
        core_1.NgModule({
            imports: [
                router_1.RouterModule.forChild([
                    {
                        path: '',
                        component: admin_component_1.AdminComponent,
                        canActivate: [auth_guard_service_1.AuthGuard],
                        children: [
                            {
                                path: '',
                                canActivateChild: [auth_guard_service_1.AuthGuard],
                                children: [
                                    { path: 'dashboard', component: admin_dashboard_component_1.AdminDashboardComponent },
                                    { path: 'profile', component: admin_profile_component_1.AdminProfileComponent }
                                ]
                            },
                            {
                                path: 'course',
                                canActivateChild: [auth_guard_service_1.AuthGuard],
                                children: [
                                    { path: '', redirectTo: '/admin/course/index', pathMatch: 'full', canActivate: [auth_guard_service_1.AuthGuard] },
                                    { path: 'index', component: admin_course_component_1.AdminCourseComponent },
                                    { path: 'index/:page', component: admin_course_component_1.AdminCourseComponent },
                                    { path: 'create', component: admin_course_create_component_1.AdminCourseCreateComponent },
                                    { path: 'view/:id', component: admin_course_view_component_1.AdminCourseViewComponent },
                                    { path: 'update/:id', component: admin_course_update_component_1.AdminCourseUpdateComponent }
                                ]
                            },
                            {
                                path: 'evaluation',
                                canActivateChild: [auth_guard_service_1.AuthGuard],
                                children: [
                                    {
                                        path: '',
                                        redirectTo: '/admin/evaluation/index',
                                        pathMatch: 'full',
                                        canActivate: [auth_guard_service_1.AuthGuard]
                                    },
                                    { path: 'index', component: admin_evaluation_component_1.AdminEvaluationComponent }
                                ]
                            },
                            {
                                path: 'teacher',
                                canActivateChild: [auth_guard_service_1.AuthGuard],
                                children: [
                                    { path: '', redirectTo: '/admin/teacher/index', pathMatch: 'full', canActivate: [auth_guard_service_1.AuthGuard] },
                                    { path: 'index', component: admin_teacher_component_1.AdminTeacherComponent },
                                    { path: 'index/:page', component: admin_teacher_component_1.AdminTeacherComponent },
                                    { path: 'profile/:id', component: admin_teacher_profile_component_1.AdminTeacherProfileComponent },
                                    { path: 'update/:id/:userId/:email/:status', component: admin_teacher_update_component_1.AdminTeacherUpdateComponent },
                                    { path: 'preregister', component: admin_teacher_preregister_component_1.AdminTeacherPreRegisterComponent },
                                    { path: 'preregister/:page', component: admin_teacher_preregister_component_1.AdminTeacherPreRegisterComponent },
                                    { path: 'import', component: admin_teacher_import_component_1.AdminTeacherImportComponent }
                                ]
                            },
                            {
                                path: 'speciality',
                                canActivateChild: [auth_guard_service_1.AuthGuard],
                                children: [
                                    {
                                        path: '',
                                        redirectTo: '/admin/speciality/index',
                                        pathMatch: 'full',
                                        canActivate: [auth_guard_service_1.AuthGuard]
                                    },
                                    { path: 'index', component: admin_speciality_component_1.AdminSpecialityComponent },
                                    { path: 'index/:page', component: admin_speciality_component_1.AdminSpecialityComponent },
                                    { path: 'create', component: admin_speciality_create_component_1.AdminSpecialityCreateComponent },
                                    { path: 'update/:id/:name', component: admin_speciality_update_component_1.AdminSpecialityUpdateComponent }
                                ]
                            },
                            {
                                path: 'level-education',
                                canActivateChild: [auth_guard_service_1.AuthGuard],
                                children: [
                                    {
                                        path: '',
                                        redirectTo: '/admin/level-education/index',
                                        pathMatch: 'full',
                                        canActivate: [auth_guard_service_1.AuthGuard]
                                    },
                                    { path: 'index', component: admin_level_education_component_1.AdminLevelEducationComponent },
                                    { path: 'index/:page', component: admin_level_education_component_1.AdminLevelEducationComponent },
                                    { path: 'create', component: admin_level_education_create_component_1.AdminLevelEducationCreateComponent },
                                    { path: 'update/:id/:name', component: admin_level_education_update_component_1.AdminLevelEducationUpdateComponent }
                                ]
                            },
                            {
                                path: 'teacher-function',
                                canActivateChild: [auth_guard_service_1.AuthGuard],
                                children: [
                                    {
                                        path: '',
                                        redirectTo: '/admin/teacher-function/index',
                                        pathMatch: 'full',
                                        canActivate: [auth_guard_service_1.AuthGuard]
                                    },
                                    { path: 'index', component: admin_teacher_function_component_1.AdminTeacherFunctionComponent },
                                    { path: 'index/:page', component: admin_teacher_function_component_1.AdminTeacherFunctionComponent },
                                    { path: 'create', component: admin_teacher_function_create_component_1.AdminTeacherFunctionCreateComponent },
                                    { path: 'update/:id/:name', component: admin_teacher_function_update_component_1.AdminTeacherFunctionUpdateComponent }
                                ]
                            },
                            {
                                path: 'skill-century',
                                canActivateChild: [auth_guard_service_1.AuthGuard],
                                children: [
                                    {
                                        path: '',
                                        redirectTo: '/admin/skill-century/index',
                                        pathMatch: 'full',
                                        canActivate: [auth_guard_service_1.AuthGuard]
                                    },
                                    { path: 'index', component: admin_skill_century_component_1.AdminSkillCenturyComponent },
                                    { path: 'index/:page', component: admin_skill_century_component_1.AdminSkillCenturyComponent },
                                    { path: 'create', component: admin_skill_century_create_component_1.AdminSkillCenturyCreateComponent },
                                    { path: 'edit/:id/:name', component: admin_skill_century_edit_component_1.AdminSkillCenturyEditComponent },
                                    { path: 'skill-area/:id', component: area_century_view_component_1.AdminSkillCenturyAreaViewComponent },
                                    { path: 'skill-area/:id/:page', component: area_century_view_component_1.AdminSkillCenturyAreaViewComponent },
                                    { path: 'skill-create-area/:id', component: area_century_create_component_1.AdminSkillCenturyAreaCreateComponent },
                                    {
                                        path: 'skill-area/create',
                                        redirectTo: '/admin/skill-century/index',
                                        canActivate: [auth_guard_service_1.AuthGuard]
                                    },
                                    { path: 'skill-edit-area/:skillId/:areaId', component: area_century_edit_component_1.AdminSkillCenturyAreaEditComponent },
                                    { path: 'categories', component: admin_skill_century_categories_component_1.AdminSkillCenturyCategoryComponent },
                                    { path: 'categories/:page', component: admin_skill_century_categories_component_1.AdminSkillCenturyCategoryComponent },
                                    { path: 'edit-caregory/:id/:name', component: admin_skill_century_edit_categories_component_1.AdminSkillCenturyEditCategoryComponent },
                                    { path: 'create-category', component: admin_skill_century_create_category_component_1.AdminSkillCenturyCreateCategoryComponent },
                                    { path: 'view-questions-by-category/:id', component: skill_century_answer_by_category_component_1.SkillCenturyAnswerByCategoryComponent },
                                    {
                                        path: 'view-questions-by-category/:id/:page',
                                        component: skill_century_answer_by_category_component_1.SkillCenturyAnswerByCategoryComponent
                                    },
                                    {
                                        path: 'skill-create-answer-category/:id',
                                        component: skill_century_create_answer_by_category_component_1.SkillCenturyCreateAnswerByCategoryComponent
                                    },
                                    {
                                        path: 'edit-answer-category/:categoryId/:answerId',
                                        component: skill_century_edit_answer_by_category_component_1.SkillCenturyEditAnswerCategoryComponent
                                    },
                                    { path: 'view-question-century', component: skill_century_view_question_century_component_1.SkillCenturyViewQuestionCenturyComponent },
                                    { path: 'view-question-century/:page', component: skill_century_view_question_century_component_1.SkillCenturyViewQuestionCenturyComponent },
                                    { path: 'create-question-century', component: skill_century_create_question_century_component_1.SkillCenturyCreateQuestionCenturyComponent },
                                    {
                                        path: 'skill-create-answer-question/:id',
                                        component: skill_century_answer_by_question_component_1.SkillCenturyAnswerByQuestionComponent
                                    },
                                    {
                                        path: 'create-answer-quetion/:id/:question',
                                        component: create_anser_by_question_component_1.AnswerQuestionCenturyCreateComponent
                                    },
                                    { path: 'import-question-century', component: skill_century_import_question_century_component_1.SkillCenturyImportQuestionCenturyComponent },
                                ]
                            },
                            {
                                path: 'skill-inee',
                                canActivateChild: [auth_guard_service_1.AuthGuard],
                                children: [
                                    {
                                        path: '',
                                        redirectTo: '/admin/skill-inee/index',
                                        pathMatch: 'full',
                                        canActivate: [auth_guard_service_1.AuthGuard]
                                    },
                                    { path: 'index', component: admin_skill_inee_component_1.AdminSkillIneeComponent },
                                    {
                                        path: 'dimension',
                                        canActivateChild: [auth_guard_service_1.AuthGuard],
                                        children: [
                                            { path: 'create/:id', component: admin_skill_inee_create_dimension_component_1.AdminDimensionCreateComponent }
                                        ]
                                    },
									{
                                        path: 'dimension',
                                        canActivateChild: [auth_guard_service_1.AuthGuard],
                                        children: [
                                            { path: 'create', component: admin_skill_inee_create_dimension_component_1.AdminDimensionCreateComponent }
                                        ]
                                    },
                                    {
                                        path: 'parameter',
                                        canActivateChild: [auth_guard_service_1.AuthGuard],
                                        children: [
                                            { path: 'create/:id', component: admin_create_parameter_component_1.AdminCreateParameterComponent }
                                        ]
                                    },
                                    {
                                        path: 'indicator',
                                        canActivateChild: [auth_guard_service_1.AuthGuard],
                                        children: [
                                            { path: 'create/:id', component: admin_indicator_create_component_1.AdminIndicatorCreateComponent }
                                        ]
                                    },
                                    { path: 'import', component: admin_import_inee_component_1.AdminImportIneeComponent }
                                ]
                            },
                            {
                                path: 'inee',
                                canActivateChild: [auth_guard_service_1.AuthGuard],
                                children: [
                                    {
                                        path: 'evaluation',
                                        canActivateChild: [auth_guard_service_1.AuthGuard],
                                        children: [
                                            {
                                                path: '',
                                                redirectTo: '/admin/inee/evaluation/index',
                                                pathMatch: 'full',
                                                canActivate: [auth_guard_service_1.AuthGuard]
                                            },
                                            { path: 'index', component: admin_inee_evaluation_component_1.AdminIneeEvaluationComponent },
                                            { path: 'create', component: admin_inee_evaluation_create_component_1.AdminIneeEvaluationCreateComponent },
                                            { path: 'import', component: admin_inee_evaluation_import_component_1.AdminIneeEvaluationImportComponent },
                                            { path: 'update/:id', component: admin_inee_evaluation_update_component_1.AdminIneeEvaluationUpdateComponent }
                                        ]
                                    }
                                ]
                            }
                        ]
                    }
                ])
            ],
            exports: [
                router_1.RouterModule
            ],
            providers: [auth_guard_service_1.AuthGuard, auth_service_1.AuthService]
        })
    ], AdminRoutingModule);
    return AdminRoutingModule;
}());
exports.AdminRoutingModule = AdminRoutingModule;
//# sourceMappingURL=admin-routing.module.js.map
