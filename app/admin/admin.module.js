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
var common_1 = require('@angular/common');
var admin_component_1 = require('./admin.component');
var admin_dashboard_component_1 = require('./admin-dashboard.component');
var admin_routing_module_1 = require('./admin-routing.module');
var admin_course_component_1 = require("./course/admin-course.component");
var admin_evaluation_component_1 = require("./evaluation/admin-evaluation.component");
var admin_teacher_component_1 = require("./teacher/admin-teacher.component");
var admin_speciality_component_1 = require("./speciality/admin-speciality.component");
var admin_level_education_component_1 = require("./level-education/admin-level-education.component");
var admin_teacher_function_component_1 = require("./teacher-function/admin-teacher-function.component");
var admin_skill_century_component_1 = require("./skill-century/admin-skill-century.component");
var admin_skill_inee_component_1 = require("./skill-inee/admin-skill-inee.component");
var admin_speciality_create_component_1 = require("./speciality/admin-speciality-create.component");
var forms_1 = require("@angular/forms");
var simple_notifications_module_1 = require("angular2-notifications/src/simple-notifications.module");
var admin_level_education_create_component_1 = require("./level-education/admin-level-education-create.component");
var admin_teacher_function_create_component_1 = require("./teacher-function/admin-teacher-function-create.component");
var admin_teacher_profile_component_1 = require("./teacher/admin-teacher-profile.component");
var admin_teacher_update_component_1 = require("./teacher/admin-teacher-update.component");
var admin_course_create_component_1 = require("./course/admin-course-create.component");
var ng2_ckeditor_1 = require("ng2-ckeditor");
var admin_skill_inee_create_dimension_component_1 = require("./skill-inee/admin-skill-inee-create-dimension.component");
var admin_create_parameter_component_1 = require("./skill-inee/admin-create-parameter.component");
var admin_indicator_create_component_1 = require("./skill-inee/admin-indicator-create.component");
var admin_course_view_component_1 = require("./course/admin-course-view.component");
var admin_course_update_component_1 = require("./course/admin-course-update.component");
var admin_skill_century_create_component_1 = require("./skill-century/admin-skill-century-create.component");
var admin_skill_century_edit_component_1 = require("./skill-century/admin-skill-century-edit.component");
var area_century_create_component_1 = require("./skill-century/area/area-century.create.component");
var area_century_view_component_1 = require("./skill-century/area/area-century.view.component");
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
var AdminModule = (function () {
    function AdminModule() {
    }
    AdminModule = __decorate([
        core_1.NgModule({
            imports: [
                common_1.CommonModule,
                admin_routing_module_1.AdminRoutingModule,
                forms_1.FormsModule,
                simple_notifications_module_1.SimpleNotificationsModule,
                ng2_ckeditor_1.CKEditorModule
            ],
            declarations: [
                admin_component_1.AdminComponent,
                admin_dashboard_component_1.AdminDashboardComponent,
                admin_profile_component_1.AdminProfileComponent,
                admin_course_component_1.AdminCourseComponent,
                admin_course_create_component_1.AdminCourseCreateComponent,
                admin_course_view_component_1.AdminCourseViewComponent,
                admin_course_update_component_1.AdminCourseUpdateComponent,
                admin_evaluation_component_1.AdminEvaluationComponent,
                admin_teacher_component_1.AdminTeacherComponent,
                admin_teacher_profile_component_1.AdminTeacherProfileComponent,
                admin_speciality_component_1.AdminSpecialityComponent,
                admin_speciality_create_component_1.AdminSpecialityCreateComponent,
                admin_speciality_update_component_1.AdminSpecialityUpdateComponent,
                admin_level_education_component_1.AdminLevelEducationComponent,
                admin_level_education_create_component_1.AdminLevelEducationCreateComponent,
                admin_level_education_update_component_1.AdminLevelEducationUpdateComponent,
                admin_teacher_function_component_1.AdminTeacherFunctionComponent,
                admin_teacher_function_create_component_1.AdminTeacherFunctionCreateComponent,
                admin_teacher_update_component_1.AdminTeacherUpdateComponent,
                admin_skill_century_component_1.AdminSkillCenturyComponent,
                admin_skill_inee_component_1.AdminSkillIneeComponent,
                admin_skill_inee_create_dimension_component_1.AdminDimensionCreateComponent,
                admin_create_parameter_component_1.AdminCreateParameterComponent,
                admin_indicator_create_component_1.AdminIndicatorCreateComponent,
                admin_skill_century_create_component_1.AdminSkillCenturyCreateComponent,
                admin_skill_century_edit_component_1.AdminSkillCenturyEditComponent,
                area_century_create_component_1.AdminSkillCenturyAreaCreateComponent,
                area_century_view_component_1.AdminSkillCenturyAreaViewComponent,
                area_century_edit_component_1.AdminSkillCenturyAreaEditComponent,
                admin_skill_century_categories_component_1.AdminSkillCenturyCategoryComponent,
                admin_skill_century_edit_categories_component_1.AdminSkillCenturyEditCategoryComponent,
                admin_skill_century_create_category_component_1.AdminSkillCenturyCreateCategoryComponent,
                skill_century_answer_by_category_component_1.SkillCenturyAnswerByCategoryComponent,
                skill_century_create_answer_by_category_component_1.SkillCenturyCreateAnswerByCategoryComponent,
                skill_century_edit_answer_by_category_component_1.SkillCenturyEditAnswerCategoryComponent,
                skill_century_view_question_century_component_1.SkillCenturyViewQuestionCenturyComponent,
                skill_century_create_question_century_component_1.SkillCenturyCreateQuestionCenturyComponent,
                skill_century_answer_by_question_component_1.SkillCenturyAnswerByQuestionComponent,
                create_anser_by_question_component_1.AnswerQuestionCenturyCreateComponent,
                skill_century_import_question_century_component_1.SkillCenturyImportQuestionCenturyComponent,
                admin_teacher_preregister_component_1.AdminTeacherPreRegisterComponent,
                admin_teacher_import_component_1.AdminTeacherImportComponent,
                admin_import_inee_component_1.AdminImportIneeComponent,
                admin_inee_evaluation_component_1.AdminIneeEvaluationComponent,
                admin_inee_evaluation_create_component_1.AdminIneeEvaluationCreateComponent,
                admin_inee_evaluation_import_component_1.AdminIneeEvaluationImportComponent,
                admin_inee_evaluation_update_component_1.AdminIneeEvaluationUpdateComponent,
                admin_teacher_function_update_component_1.AdminTeacherFunctionUpdateComponent
            ]
        }), 
        __metadata('design:paramtypes', [])
    ], AdminModule);
    return AdminModule;
}());
exports.AdminModule = AdminModule;
//# sourceMappingURL=admin.module.js.map