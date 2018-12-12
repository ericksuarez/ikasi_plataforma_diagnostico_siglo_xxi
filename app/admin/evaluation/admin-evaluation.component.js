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
var core_1 = require("@angular/core");
var AdminEvaluationComponent = (function () {
    function AdminEvaluationComponent() {
    }
    AdminEvaluationComponent.prototype.ngOnInit = function () {
        jQuery("#main-navigation").find(">ul>li.active").removeClass("active");
        jQuery("#menu-evaluation").addClass("active");
    };
    AdminEvaluationComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/evaluation/index.html'
        }), 
        __metadata('design:paramtypes', [])
    ], AdminEvaluationComponent);
    return AdminEvaluationComponent;
}());
exports.AdminEvaluationComponent = AdminEvaluationComponent;
//# sourceMappingURL=admin-evaluation.component.js.map