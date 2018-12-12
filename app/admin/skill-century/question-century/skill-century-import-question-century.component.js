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
var SkillCenturyQuestionCentury_1 = require("../../../models/SkillCenturyQuestionCentury");
var SkillCenturyImportQuestionCenturyComponent = (function () {
    function SkillCenturyImportQuestionCenturyComponent(_skillCenturyAreaService, _skillCenturyService, _skillCenturyCategoryService, _skillCenturyQuestionCentury) {
        this._skillCenturyAreaService = _skillCenturyAreaService;
        this._skillCenturyService = _skillCenturyService;
        this._skillCenturyCategoryService = _skillCenturyCategoryService;
        this._skillCenturyQuestionCentury = _skillCenturyQuestionCentury;
        this.model = new SkillCenturyQuestionCentury_1.SkillQuestionCentury(0, 0, 0, "");
        this.skillId = 0;
        this.skills = [];
        this.areas = [];
        this.questions = [];
        this.categories = [];
        this.loading = false;
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
        this.error = false;
    }
    SkillCenturyImportQuestionCenturyComponent.prototype.ngOnInit = function () {
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
    SkillCenturyImportQuestionCenturyComponent.prototype.showAreas = function (skillId) {
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
    SkillCenturyImportQuestionCenturyComponent.prototype.setAreaId = function (area_id) {
        this.model.area_id = area_id;
        console.log(this.model);
    };
    SkillCenturyImportQuestionCenturyComponent.prototype.setCategoryId = function (category_id) {
        this.model.category_id = category_id;
        console.log(this.model);
    };
    SkillCenturyImportQuestionCenturyComponent.prototype.setReplace = function (replace) {
        this.replace = replace;
    };
    SkillCenturyImportQuestionCenturyComponent.prototype.csvUploadToServer = function (fileInput) {
        var _this = this;
        if (this.replace == 1 || this.replace == 0) {
            if (confirm("¿Esta seguro de cargar este archivo?")) {
                this.filesToUpload = fileInput.target.files;
                this._skillCenturyQuestionCentury.makeFileRequest(['csv'], this.filesToUpload, this.model, this.replace).then(function (result) {
                    _this.resultUpload = result;
                    console.log(_this.resultUpload);
                }, function (error) {
                    console.log(error);
                });
            }
            this.error = false;
        } else {
            this.error = true;
        }
    };
    SkillCenturyImportQuestionCenturyComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/skill-century/question-century/import.html',
            providers: [
                skill_century_service_1.SkillCenturyService,
                skill_century_area_service_1.SkillCenturyAreaService,
                skill_century_category_service_1.SkillCenturyCategoryService,
                skill_century_question_century_service_1.SkillCenturyQuestionCenturyService
            ]
        }),
        __metadata("design:paramtypes", [skill_century_area_service_1.SkillCenturyAreaService,
            skill_century_service_1.SkillCenturyService,
            skill_century_category_service_1.SkillCenturyCategoryService,
            skill_century_question_century_service_1.SkillCenturyQuestionCenturyService])
    ], SkillCenturyImportQuestionCenturyComponent);
    return SkillCenturyImportQuestionCenturyComponent;
}());
exports.SkillCenturyImportQuestionCenturyComponent = SkillCenturyImportQuestionCenturyComponent;
//# sourceMappingURL=skill-century-import-question-century.component.js.map