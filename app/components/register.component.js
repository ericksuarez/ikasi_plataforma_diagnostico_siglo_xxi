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
var core_1 = require('@angular/core');
var router_1 = require('@angular/router');
var register_1 = require("../models/register");
var specialty_service_1 = require('../services/specialty.service');
var education_level_service_1 = require('../services/education-level.service');
var teacher_function_service_1 = require('../services/teacher-function.service');
var register_service_1 = require('../services/register.service');
var auth_service_1 = require("../services/auth.service");
var helper_1 = require("../helpers/helper");
var RegisterComponent = (function () {
    function RegisterComponent(_authService, _activatedRoute, _router, _specialtyService, _educationLevelService, _teacherFunctionService, _registerService, _helper) {
        this._authService = _authService;
        this._activatedRoute = _activatedRoute;
        this._router = _router;
        this._specialtyService = _specialtyService;
        this._educationLevelService = _educationLevelService;
        this._teacherFunctionService = _teacherFunctionService;
        this._registerService = _registerService;
        this._helper = _helper;
        this.model = new register_1.Register();
        this.error = false;
    }
    RegisterComponent.prototype.ngOnInit = function () {
        var _this = this;
        if (this._authService.isLoggedIn()) {
            //noinspection JSIgnoredPromiseFromCall
            this._router.navigate(["/"]);
        }
        this._specialtyService.getList().subscribe(function (response) {
            _this.specialty_list = response;
        }, function (error) {
            console.log("Error al cargar las especialidades");
        });
        this._educationLevelService.getList().subscribe(function (response) {
            _this.education_level_list = response;
        }, function (error) {
            console.log("Error al cargar los niveles");
        });
        this._teacherFunctionService.getList().subscribe(function (response) {
            _this.teacher_function_list = response;
        }, function (error) {
            console.log("Error al cargar las funciones");
        });
        this._activatedRoute.params.subscribe(function (params) {
            var data = params['data'];
            if (typeof data != "undefined") {
                _this.pre_register = JSON.parse(_this._helper.base64Decode(data));
                _this.model.curp = _this.pre_register.curp;
                _this.model.fullname = _this.pre_register.name;
                _this.model.email = _this.pre_register.email;
                _this.model.specialty = _this.pre_register.speciality;
                _this.model.education_level = _this.pre_register.educationLevel;
                _this.model.teacher_function = _this.pre_register.teacherFunction;
            }
        });

        //** Se consulta la info en sinadep
        var params = {};
        var parser = document.createElement('a');
        parser.href = window.location.href;
        var query = parser.search.substring(1);
		var domain = parser.href.substring(0, parser.href.indexOf("/register?"));
        var vars = query.split('&');
        for (var i = 0; i < vars.length; i++) {
            var pair = vars[i].split('=');
            params[pair[0]] = decodeURIComponent(pair[1]);
        }
    //	console.log("domain " + domain);
        this._teacherFunctionService.codeAccess(params.code,domain).subscribe(function (response) {
            console.log(response);
////        var response = {
////            "token_type": "Bearer",
////            "scope": "admin_impersonation Employees.Read.All user_impersonation",
////            "expires_in": "3599",
////            "ext_expires_in": "0",
////            "expires_on": "1536313444",
////            "not_before": "1536309544",
////            "resource": "https://sinadep.org.mx/Sinadep.Api",
////            "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsIng1dCI6IjdfWnVmMXR2a3dMeFlhSFMzcTZsVWpVWUlHdyIsImtpZCI6IjdfWnVmMXR2a3dMeFlhSFMzcTZsVWpVWUlHdyJ9.eyJhdWQiOiJodHRwczovL3NpbmFkZXAub3JnLm14L1NpbmFkZXAuQXBpIiwiaXNzIjoiaHR0cHM6Ly9zdHMud2luZG93cy5uZXQvNjk1Yjg5ZjctMWU0My00ZTFiLWE2NGItZWI3MDJkN2I0YzI2LyIsImlhdCI6MTUzNjMwOTU0NCwibmJmIjoxNTM2MzA5NTQ0LCJleHAiOjE1MzYzMTM0NDQsImFjciI6IjEiLCJhaW8iOiI0MkJnWUZpZGMvSldlZG42SE83cXhQUkY5ZC82cnVwNGlyZ3p5SjNhWG1EeUowNWdjUVVBIiwiYW1yIjpbInB3ZCJdLCJhcHBpZCI6IjZiODQyZjhhLWNmY2MtNDNmNC1hODJjLTNjYTc5ZTQ4NWNkMSIsImFwcGlkYWNyIjoiMSIsImZhbWlseV9uYW1lIjoiU2lnbG8gWFhJIiwiZ2l2ZW5fbmFtZSI6IkRpYWdub3N0aWNvIiwiaXBhZGRyIjoiMTg3LjIyNC44MS41MiIsIm5hbWUiOiJEaWFnbm9zdGljbyBTaWdsbyBYWEkiLCJvaWQiOiJkMDMwZGY0Yi0yMDY3LTQ3YjMtYTNiNS1mYTk2NjZhOTI0MWYiLCJzY3AiOiJhZG1pbl9pbXBlcnNvbmF0aW9uIEVtcGxveWVlcy5SZWFkLkFsbCB1c2VyX2ltcGVyc29uYXRpb24iLCJzdWIiOiJhTHQ1NllHSmZnMUQ1UXJyeXdna3RoNVg0NEtuOVVlN3NhbEZrSk15QzI0IiwidGlkIjoiNjk1Yjg5ZjctMWU0My00ZTFiLWE2NGItZWI3MDJkN2I0YzI2IiwidW5pcXVlX25hbWUiOiJhLmRzeGlpQHNpbmFkZXAub3JnLm14IiwidXBuIjoiYS5kc3hpaUBzaW5hZGVwLm9yZy5teCIsInV0aSI6IkxjYWkwV04tLVVtXzhKQzhFdm9sQUEiLCJ2ZXIiOiIxLjAifQ.h7GcldEEbMcRifT_64VwdiHgyp70i67krDDA07YHusYw8pdlzuwwM1uxkgvJzdaI5Vyo8sOMbp6OOUAyRK-7g01yxym7ebZuNaTn0iv5HLeu-CZEJumXR1kG5VeBMtxbxKFuq6ulgocfaoiSQafD9FHx38bIodtKsTwd0ndG8CDBxnwGqg0eioA3yJbReMvdU8w8tTQBZm65rP3G_wTHyAAyg9Px_eW-UWf3d9WgdruOBNDbyD9y9g3VFlZCktyQvZVNIELl9N648eQz20Z7iYyTMhhqeCSwFaHMTtHMyGk0W2QRziHmZTUTI3UrpzkoJeksfeje-Y9YUa1iNHT3Lg",
////            "refresh_token": "AQABAAAAAADXzZ3ifr-GRbDT45zNSEFEUGRAISugpRYDR0wVfejb-Lr_YyuAHRMd_z2if2T872K558D6z-e5-P5IQdwskl9bnWy7OZeDYc2cJlryQVaODrkIaRDDa9cEbdh-fJy_M1EGDYhRtsK6jmDPznD3FEjHMJduAxO6lpHXpVe6YD0EMdI82hlb-29cAJIRIJ3lEm6n4cCRD8hsL25vMFBEc58f-MvgGojFClyikfXiUtbAWzt_FpYb21dpV68tXqVq3PH5DdT-EZV4KcG74Ldzrl_kLXlltfx4afK8mErmU-H34hG77o3hdLjB7yExRm-aWgp9MxdCUJE17-K1mJpF4wQCm99-WLSGDQeZ-mUDGv6Y8yHJi_8SxmaBF4PzWFJG9JivgqjKK1Y3TCRTDEJu995KSAIBBoAguxuzKDAJR8P_sBRXZhKNJUM5OQNwNboSHMOEldRS6uIkpfTbt9wmUuszDxs-KS2wYCRri_aMUKRb354Yobkvi0ucjPxSalQCj6a6ezAdabQZf2rPVekwM6Cf66XYHR-4TVg8jMy0VWNKOO7cAfyT1LW5t5GKhIedke3WKytxndbS8Tf_HK2GW58-jZHYIXAgu8R5Ptu2Vns6Qg0ZufApUpYVg_n74WLGnUu132VuG7pgpA_RNGToCqhb6kFSNF08YXGR4LQLFSC6Mez0ttqz7r01yMiDVmmWo60SmtOuv2eQyqQxAjLuiB_i_Q2ONaiFXVPcFhwQkT02UV7J0T_rikLhVC1UjGGPbbf6VPkPksgxZk1XegLEBOdQma-GXHmq03dSMHxIETxXrcYBnn7ORPQa_C6nfxx4S7Tpdp8lJnohIg9Y9EGtqJjbIAA",
////            "id_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJub25lIn0.eyJhdWQiOiI2Yjg0MmY4YS1jZmNjLTQzZjQtYTgyYy0zY2E3OWU0ODVjZDEiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC82OTViODlmNy0xZTQzLTRlMWItYTY0Yi1lYjcwMmQ3YjRjMjYvIiwiaWF0IjoxNTM2MzA5NTQ0LCJuYmYiOjE1MzYzMDk1NDQsImV4cCI6MTUzNjMxMzQ0NCwiYW1yIjpbInB3ZCJdLCJmYW1pbHlfbmFtZSI6IlNpZ2xvIFhYSSIsImdpdmVuX25hbWUiOiJEaWFnbm9zdGljbyIsImlwYWRkciI6IjE4Ny4yMjQuODEuNTIiLCJuYW1lIjoiRGlhZ25vc3RpY28gU2lnbG8gWFhJIiwib2lkIjoiZDAzMGRmNGItMjA2Ny00N2IzLWEzYjUtZmE5NjY2YTkyNDFmIiwic3ViIjoiVHBzeEVQVHVZVjBaTVpIbUdzRkdORHp4N1Z1eVZfWFlZRzdjR3BfZHUydyIsInRpZCI6IjY5NWI4OWY3LTFlNDMtNGUxYi1hNjRiLWViNzAyZDdiNGMyNiIsInVuaXF1ZV9uYW1lIjoiYS5kc3hpaUBzaW5hZGVwLm9yZy5teCIsInVwbiI6ImEuZHN4aWlAc2luYWRlcC5vcmcubXgiLCJ2ZXIiOiIxLjAifQ."
////        };
        this._teacherFunctionService.userInfo(response.access_token).subscribe(function (response) {
            console.log(response);
			var user = response;
////            var user = {
////                "Birthday": "0001-01-01T00:00:00",
////                "Category": 0,
////                "ContentPermits": 0,
////                "EmailAddress1": "prueba43@puntual.biz",
////                "FullName": "Diagnostico Siglo XXI",
////                "FullNameInverse": "Siglo XXI Diagnostico",
////                "Name": "a.dsxii@sinadep.org.mx",
////                "Name1": "Diagnostico",
////                "Name2": "Siglo XXI",
////                "NewMembersRequestsType": 0,
////                "Privacy": 0,
////                "PublicationsMustBeApproved": false,
////                "SessionDuration": 20,
////                "SectionName": "24 Querétaro",
////                "Sex": 2,
////                "SocialId": "PEMM780912MBCLAA00",
////                "Status": 3,
////                "Type": 0,
////                "UserRol": 0,
////                "CreationDate": "0001-01-01T00:00:00",
////                "ForceUpdate": false,
////                "IsActive": true,
////                "LastModificationDate": "0001-01-01T00:00:00",
////                "RecordStatus": 0
////            };
            _this.model.fullname = user.FullName;
            _this.model.email = user.Name;
            _this.model.seccionSindical = user.SectionName;
        }, function (error) {
            confirm("Error al obtener la informacion del usuario. " + error);
        });
        }, function (error) {
            confirm("Error al obtener el codigo de acceso. " + error);
        });
    };
    RegisterComponent.prototype.onSubmit = function () {
        var _this = this;
        this.error = false;
        //noinspection TypeScriptValidateJSTypes
        jQuery("#registerButton").button('loading');
        this._registerService.register(this.model).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#registerButton").button('reset');
            if (response.status == 'error') {
                _this.errorMessage = response.message;
                _this.error = true;
                return;
            }
            // Si no existe un error, direccionamos a la página de confirmación
            _this._router.navigate(["confirmation"]);
        }, function (error) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#registerButton").button('reset');
            _this.errorMessage = error;
            if (_this.errorMessage != null) {
                console.log(_this.errorMessage);
            }
        });
    };
    RegisterComponent = __decorate([
        core_1.Component({
            selector: 'register',
            templateUrl: 'app/views/register.html',
            providers: [auth_service_1.AuthService, specialty_service_1.SpecialtyService, education_level_service_1.EducationLevelService, teacher_function_service_1.TeacherFunctionService, register_service_1.RegisterService, helper_1.Helper]
        }),
        __metadata('design:paramtypes', [auth_service_1.AuthService, router_1.ActivatedRoute, router_1.Router, specialty_service_1.SpecialtyService, education_level_service_1.EducationLevelService, teacher_function_service_1.TeacherFunctionService, register_service_1.RegisterService, helper_1.Helper])
    ], RegisterComponent);
    return RegisterComponent;
}());
exports.RegisterComponent = RegisterComponent;
//# sourceMappingURL=register.component.js.map