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
var skill_century_question_century_service_1 = require("../../../services/skill-century-question-century.service");
var skill_century_service_1 = require("../../../services/skill-century.service");
var skill_century_area_service_1 = require("../../../services/skill-century-area.service");
var skill_century_category_service_1 = require("../../../services/skill-century-category.service");
var helper_1 = require("../../../helpers/helper");
var notifications_service_1 = require("angular2-notifications/src/notifications.service");
var SkillCenturyViewQuestionCenturyComponent = (function (_super) {
    __extends(SkillCenturyViewQuestionCenturyComponent, _super);
    function SkillCenturyViewQuestionCenturyComponent(_skillCenturyQuestionCenturyService, _skillCenturyService, 
	_skillCenturyAreaService, _skillCenturyCategoryService, _notificationsService) {
        var _this = this;
        _this._skillCenturyQuestionCenturyService = _skillCenturyQuestionCenturyService;
        _this._skillCenturyService = _skillCenturyService;
        _this._skillCenturyAreaService = _skillCenturyAreaService;
        _this._skillCenturyCategoryService = _skillCenturyCategoryService;
        _this.questions = [];
        // Página anterior
        _this.pagePrev = 1;
        // Siguiente página
        _this.pageNext = 1;
        _this.areas = [];
        _this.colors = [
			{
                skill: '#97B9E4',
                area: '#DCE8F6',
                category: '#EBF1F9',
                question: '#f1f7ff'
            },
            {
                skill: '#AB73D4',
                area: '#E1D0F0',
                category: '#F4ECF8',
                question: '#fbf3ff'
            },
            {
                skill: '#FF9225',
                area: '#FFE7CF',
                category: '#f9ede1',
                question: '#fff3e7'
            },
            {
                skill: '#31928B',
                area: '#B5E4E1',
                category: '#DAF1EF',
                question: '#e8fffd'
            },
            {
                skill: 	  '#61C52B',
                area: 	  '#D2F0C1',
                category: '#E8F8DF',
                question: '#efffe6'
            },
			{
			    skill 		:'#ffebee',
			    area 		:'#ffcdd2',
			    category	:'#ef9a9a',
			    question	:'#e57373'
			},				
			{
			    skill 		:'#ef5350',
			    area 		:'#f44336',
			    category	:'#e53935',
			    question	:'#d32f2f'
			},
			{
			    skill 		:'#c62828',
			    area 		:'#b71c1c',
			    category	:'#ff8a80',
			    question	:'#ff5252'
			},	
			{
			    skill 		:'#ff1744',
			    area 		:'#d50000',
			    category	:'#fce4ec',
			    question	:'#f8bbd0'
			},		
			{
			    skill 		:'#f48fb1',
			    area 		:'#f06292',
			    category	:'#ec407a',
			    question	:'#e91e63'
			},
			{	
			    skill 		:'#d81b60',
			    area 		:'#c2185b',
			    category	:'#ad1457',
			    question	:'#880e4f'
			},				
			{	
			    skill 		:'#ff80ab',
			    area 		:'#ff4081',
			    category	:'#f50057',
			    question	:'#c51162'
			},				
			{	
			    skill 		:'#f3e5f5',
			    area 		:'#e1bee7',
			    category	:'#ce93d8',
			    question	:'#ba68c8'
			},				
			{	
			    skill 		:'#ab47bc',
			    area 		:'#9c27b0',
			    category	:'#8e24aa',
			    question	:'#7b1fa2'
			},				
			{	
			    skill 		:'#6a1b9a',
			    area 		:'#4a148c',
			    category	:'#ea80fc',
			    question	:'#e040fb'
			},				
			{	
			    skill 		:'#d500f9',
			    area 		:'#aa00ff',
			    category	:'#ede7f6',
			    question	:'#d1c4e9'
			},
			{
			    skill 		:'#b39ddb',
			    area 		:'#9575cd',
			    category	:'#7e57c2',
			    question	:'#673ab7'
			},
			{
			    skill 		:'#5e35b1',
			    area 		:'#512da8',
			    category	:'#4527a0',
			    question	:'#311b92'
			},
			{
			    skill 		:'#b388ff',
			    area 		:'#7c4dff',
			    category	:'#651fff',
			    question	:'#6200ea'
			},
			{
			    skill 		:'#e8eaf6',
			    area 		:'#c5cae9',
			    category	:'#9fa8da',
			    question	:'#7986cb'
			},
			{
			    skill 		:'#5c6bc0',
			    area 		:'#3f51b5',
			    category	:'#3949ab',
			    question	:'#303f9f'
			},
			{
			    skill 		:'#283593',
			    area 		:'#1a237e',
			    category	:'#8c9eff',
			    question	:'#536dfe'
			},
			{
			    skill 		:'#3d5afe',
			    area 		:'#304ffe',
			    category	:'#e3f2fd',
			    question	:'#bbdefb'
			},
			{
			    skill 		:'#90caf9',
			    area 		:'#64b5f6',
			    category	:'#42a5f5',
			    question	:'#2196f3'
			},
			{
			    skill 		:'#1e88e5',
			    area 		:'#1976d2',
			    category	:'#1565c0',
			    question	:'#0d47a1'
			},
			{
			    skill 		:'#82b1ff',
			    area 		:'#448aff',
			    category	:'#2979ff',
			    question	:'#2962ff'
			},
			{
			    skill 		:'#e1f5fe',
			    area 		:'#b3e5fc',
			    category	:'#81d4fa',
			    question	:'#4fc3f7'
			},
			{
			    skill 		:'#29b6f6',
			    area 		:'#03a9f4',
			    category	:'#039be5',
			    question	:'#0288d1'
			},
			{
			    skill 		:'#0277bd',
			    area 		:'#01579b',
			    category	:'#80d8ff',
			    question	:'#40c4ff'
			},
			{
			    skill 		:'#00b0ff',
			    area 		:'#0091ea',
			    category	:'#e0f7fa',
			    question	:'#b2ebf2'
			},
			{
			    skill 		:'#80deea',
			    area 		:'#4dd0e1',
			    category	:'#26c6da',
			    question	:'#00bcd4'
			},
			{
			    skill 		:'#00acc1',
			    area 		:'#0097a7',
			    category	:'#00838f',
			    question	:'#006064'
			},
			{
			    skill 		:'#84ffff',
			    area 		:'#18ffff',
			    category	:'#00e5ff',
			    question	:'#00b8d4'
			},
			{
			    skill 		:'#e0f2f1',
			    area 		:'#b2dfdb',
			    category	:'#80cbc4',
			    question	:'#4db6ac'
			},
			{					     
			    skill 		:'#009688',
			    area 		:'#00897b',
			    category	:'#00796b',
			    question	:'#00695c'
			},
			{
			    skill 		:'#004d40',
			    area 		:'#a7ffeb',
			    category	:'#64ffda',
			    question	:'#1de9b6'
			},
			{
			    skill 		:'#00bfa5',
			    area 		:'#e8f5e9',
			    category	:'#c8e6c9',
			    question	:'#a5d6a7'
			},
			{
			    skill 		:'#81c784',
			    area 		:'#66bb6a',
			    category	:'#4caf50',
			    question	:'#43a047'
			},
			{
			    skill 		:'#388e3c',
			    area 		:'#2e7d32',
			    category	:'#1b5e20',
			    question	:'#b9f6ca'
			},
			{
			    skill 		:'#69f0ae',
			    area 		:'#00e676',
			    category	:'#00c853',
			    question	:'#f1f8e9'
			},
			{
			    skill 		:'#dcedc8',
			    area 		:'#c5e1a5',
			    category	:'#aed581',
			    question	:'#9ccc65'
			},
			{
			    skill 		:'#8bc34a',
			    area 		:'#7cb342',
			    category	:'#689f38',
			    question	:'#558b2f'
			},
			{
			    skill 		:'#33691e',
			    area 		:'#ccff90',
			    category	:'#b2ff59',
			    question	:'#76ff03'
			},				         
			{	                     
			    skill 		:'#64dd17',
			    area 		:'#f9fbe7',
			    category	:'#f0f4c3',
			    question	:'#e6ee9c'
			},				         
			{	                     
			    skill 		:'#dce775',
			    area 		:'#d4e157',
			    category	:'#cddc39',
			    question	:'#c0ca33'
			},				         
			{	                     
			    skill 		:'#afb42b',
			    area 		:'#9e9d24',
			    category	:'#827717',
			    question	:'#f4ff81'
			},				         
			{	                     
			    skill 		:'#eeff41',
			    area 		:'#c6ff00',
			    category	:'#aeea00',
			    question	:'#fffde7'
			},				         
			{	                     
			    skill 		:'#fff9c4',
			    area 		:'#fff59d',
			    category	:'#fff176',
			    question	:'#ffee58'
			},				         
			{	                     
			    skill 		:'#ffeb3b',
			    area 		:'#fdd835',
			    category	:'#fbc02d',
			    question	:'#f9a825'
			},				         
			{	                     
			    skill 		:'#f57f17',
			    area 		:'#ffff8d',
			    category	:'#ffff00',
			    question	:'#ffea00'
			},				         
			{	                     
			    skill 		:'#ffd600',
			    area 		:'#fff8e1',
			    category	:'#ffecb3',
			    question	:'#ffe082'
			},				        
			{	                     
			    skill 		:'#ffd54f',
			    area 		:'#ffca28',
			    category	:'#ffc107',
			    question	:'#ffb300'
			},				         
			{	                     
			    skill 		:'#ffa000',
			    area 		:'#ff8f00',
			    category	:'#ff6f00',
			    question	:'#ffe57f'
			},				         
			{	                     
			    skill 		:'#ffd740',
			    area 		:'#ffc400',
			    category	:'#ffab00',
			    question	:'#fff3e0'
			},				         
			{	                     
			    skill 		:'#ffe0b2',
			    area 		:'#ffcc80',
			    category	:'#ffb74d',
			    question	:'#ffa726'
			},				         
			{	                     
			    skill 		:'#ff9800',
			    area 		:'#fb8c00',
			    category	:'#f57c00',
			    question	:'#ef6c00'
			},				         
			{	                     
			    skill 		:'#e65100',
			    area 		:'#ffd180',
			    category	:'#ffab40',
			    question	:'#ff9100'
			},				         
			{	                     
			    skill 		:'#ff6d00',
			    area 		:'#fbe9e7',
			    category	:'#ffccbc',
			    question	:'#ffab91'
			},				         
			{	                     
			    skill 		:'#ff8a65',
			    area 		:'#ff7043',
			    category	:'#ff5722',
			    question	:'#f4511e'
			},				         
			{	                     
			    skill 		:'#e64a19',
			    area 		:'#d84315',
			    category	:'#bf360c',
			    question	:'#ff9e80'
			},				         
			{	                     
			    skill 		:'#ff6e40',
			    area 		:'#ff3d00',
			    category	:'#dd2c00',
			    question	:'#efebe9'
			},				         
			{	                     
			    skill 		:'#d7ccc8',
			    area 		:'#bcaaa4',
			    category	:'#a1887f',
			    question	:'#8d6e63'
			},				         
			{	                     
			    skill 		:'#795548',
			    area 		:'#6d4c41',
			    category	:'#5d4037',
			    question	:'#4e342e'
			},				         
			{	                     
			    skill 		:'#3e2723',
			    area 		:'#fafafa',
			    category	:'#f5f5f5',
			    question	:'#eeeeee'
			},				         
			{	                     
			    skill 		:'#e0e0e0',
			    area 		:'#bdbdbd',
			    category	:'#9e9e9e',
			    question	:'#757575'
			},				         
			{	                     
			    skill 		:'#616161',
			    area 		:'#424242',
			    category	:'#212121',
			    question	:'#eceff1'
			},				         
			{	                     
			    skill 		:'#cfd8dc',
			    area 		:'#b0bec5',
			    category	:'#90a4ae',
			    question	:'#78909c'
			},				         
			{	                     
			    skill 		:'#607d8b',
			    area 		:'#546e7a',
			    category	:'#455a64',
			    question	:'#37474f'
            }
        ];
        _this._notificationsService = _notificationsService;
		_this.options = {
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
		_this.loading = true;
		
		return _this;
    }
    SkillCenturyViewQuestionCenturyComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.loading = true;
        this._skillCenturyCategoryService.findAll(-1).subscribe(function (response) {
            _this.categories = response.data;
            if (_this.categories.length == 0) {
                _this.loading = false;
            }
        }, function (error) {
            console.log(error);
        });
        this._skillCenturyService.findAll(-1).subscribe(function (response) {
            _this.skills = response.data;
            if (_this.skills.length == 0) {
                _this.loading = false;
            }
            var _loop_1 = function (i) {
                _this._skillCenturyAreaService.findAll(_this.skills[i].id, -1).subscribe(function (response) {
                    _this.areas[_this.skills[i].id] = response.data;
                    for (var j = 0; j < _this.categories.length; j++) {
                        var areas = _this.areas[_this.skills[i].id];
                        for (var k = 0; k < areas.length; k++) {
                            _this.getQuestionsByAreaAndCategory(areas[k].id, _this.categories[j].id);
                        }
                    }
                }, function (error) {
                    _this.loading = false;
                    console.log(error);
                });
            };
            for (var i = 0; i < _this.skills.length; i++) {
                _loop_1(i);
            }
        }, function (error) {
            console.log(error);
        });
        jQuery("#main-navigation").find(">ul>li.active").removeClass("active");
        jQuery("#menu-catalog").addClass("active");
    };
    SkillCenturyViewQuestionCenturyComponent.prototype.getQuestionsByAreaAndCategory = function (areaId, categoryId) {
        var _this = this;
        this.loading = false;
        this._skillCenturyQuestionCenturyService.findAll(areaId, categoryId).subscribe(function (response) {
            _this.questions[areaId + '_' + categoryId] = response.data;
        }, function (error) {
            console.log(error);
        });
    };
    SkillCenturyViewQuestionCenturyComponent.prototype.delete = function (id) {
        var _this = this;

        $.confirm({
            icon: 'fa fa-warning',
            closeIcon: true,
            title: '¡Confirmación!',
            content: '¿Está seguro que desea eliminar este elemento de la lista?',
            type: 'red',
            typeAnimated: true,
            autoClose: 'close|8000',
            buttons: {
                acptar: {
                    text: 'Aceptar',
                    btnClass: 'btn-green',
                    action: function () {
                        _this._skillCenturyService.deleteQuestion(id).subscribe(function (response) {
                            if (response.status === 200) {
                                _this._notificationsService.success(response.title, response.message + " Espere un momento en lo se actualizan las preguntas.");
                                this.loading = true;
								
								_this._skillCenturyCategoryService.findAll(-1).subscribe(function (response) {
									_this.categories = response.data;
									if (_this.categories.length == 0) {
										this.loading = false;
									}
								}, function (error) {
									console.log(error);
								});

                                _this._skillCenturyService.findAll(-1).subscribe(function (response) {
									_this.skills = response.data;
									if (_this.skills.length == 0) {
										this.loading = false;
									}
									var _loop_1 = function (i) {
										_this._skillCenturyAreaService.findAll(_this.skills[i].id, -1).subscribe(function (response) {
											_this.areas[_this.skills[i].id] = response.data;
											for (var j = 0; j < _this.categories.length; j++) {
												var areas = _this.areas[_this.skills[i].id];
												for (var k = 0; k < areas.length; k++) {
													_this.getQuestionsByAreaAndCategory(areas[k].id, _this.categories[j].id);
												}
											}
										}, function (error) {
											this.loading = false;
											console.log(error);
										});
									};
									for (var i = 0; i < _this.skills.length; i++) {
										_loop_1(i);
									}
								}, function (error) {
                                    _this._notificationsService.error("Error!!!", "No se logro cargar el listado");
                                });
                                
                            } else {
                                _this._notificationsService.error(response.title, response.message);
                            }
                        });
                    }
                },
                close: {
                    text: 'Cancelar',
                    btnClass: 'btn-red',
                    action: function () {
                    }
                }
            }
        });
    };
	SkillCenturyViewQuestionCenturyComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/skill-century/question-century/index.html',
            providers: [
                skill_century_question_century_service_1.SkillCenturyQuestionCenturyService,
                skill_century_service_1.SkillCenturyService,
                skill_century_area_service_1.SkillCenturyAreaService,
                skill_century_category_service_1.SkillCenturyCategoryService,
				notifications_service_1.NotificationsService
            ]
        }),
        __metadata("design:paramtypes", [skill_century_question_century_service_1.SkillCenturyQuestionCenturyService,
            skill_century_service_1.SkillCenturyService,
            skill_century_area_service_1.SkillCenturyAreaService,
            skill_century_category_service_1.SkillCenturyCategoryService,
			notifications_service_1.NotificationsService])
    ], SkillCenturyViewQuestionCenturyComponent);
    return SkillCenturyViewQuestionCenturyComponent;
}(helper_1.Helper));
exports.SkillCenturyViewQuestionCenturyComponent = SkillCenturyViewQuestionCenturyComponent;
//# sourceMappingURL=skill-century-view-question-century.component.js.map