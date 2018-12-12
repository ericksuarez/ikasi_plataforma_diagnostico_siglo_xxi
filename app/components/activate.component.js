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
var register_service_1 = require('../services/register.service');
var ActivateComponent = (function () {
    function ActivateComponent(_activateRoute, _registerService) {
        this._activateRoute = _activateRoute;
        this._registerService = _registerService;
        this.error = false;
    }
    ActivateComponent.prototype.ngOnInit = function () {
        var _this = this;
        this._activateRoute.params.subscribe(function (params) {
            _this.id = params['id'];
            _this.authKey = params['authKey'];
        });
        this._registerService.activate(this.id, this.authKey).subscribe(function (response) {
            if (response.status == 'error') {
                _this.error = true;
            }
            _this.title_breadcrumb = response.message;
        }, function (error) {
            _this.error = true;
            _this.title_breadcrumb = "Error al activar la cuenta";
        });
    };
    ActivateComponent = __decorate([
        core_1.Component({
            selector: 'activate',
            templateUrl: 'app/views/activate.html',
            providers: [register_service_1.RegisterService]
        }), 
        __metadata('design:paramtypes', [router_1.ActivatedRoute, register_service_1.RegisterService])
    ], ActivateComponent);
    return ActivateComponent;
}());
exports.ActivateComponent = ActivateComponent;
//# sourceMappingURL=activate.component.js.map