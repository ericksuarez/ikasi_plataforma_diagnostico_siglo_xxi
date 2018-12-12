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
var __param = (this && this.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};
var core_1 = require('@angular/core');
var user_service_1 = require("../services/user.service");
var angular2_notifications_1 = require("angular2-notifications");
var user_service_1 = require("../services/user.service");
var email_1 = require("../models/email");
var upload_service_1 = require("../services/upload.service");
var app_config_1 = require("../app.config");
var AdminDashboardComponent = (function () {
    function AdminDashboardComponent(_userService, _uploadService, config) {
        this.options = {
            timeOut: 5000,
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
            position: ['right', 'bottom']
        };
        this._userService = _userService;
        this.model = new email_1.Email();
        this._uploadService = _uploadService;
        this.config = config;
        this.controller = "/course";
        this.url = config.apiEndPoint + this.controller;
		this.niveles_educativos;
    }
    AdminDashboardComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.title = "Dashboard";
        jQuery("#main-navigation").find(">ul>li.active").removeClass("active");
        _this._userService.getHome().subscribe(function (response) {
            console.log(response);
            _this.model = response.data[0];
			_this.niveles_educativos = response.data.niveles_educativos;
			_this.model.total = response.data.niveles_educativos.reduce((sum, item) => sum + parseInt(item.INSCRITOS), 0);
			console.log(_this.model);

		// INFORMACION PARA LAS GRAFICAS
			google.charts.load('current', {'packages':['corechart']});
			// SIGLO XXI PARTICIPACIÓN NIVEL ESCOLAR 
			google.charts.setOnLoadCallback(function() {
				var data = google.visualization.arrayToDataTable(response.data.graph_nivel);
				var options = {title: 'PARTICIPACIÓN NIVEL ESCOLAR'};
				var chart = new google.visualization.PieChart(document.getElementById('siglo_xxi_1'));
				chart.draw(data, options);
			});
		// SIGLO XXI RESULTADOS  GLOBALES estatus_nivel
			google.charts.setOnLoadCallback(function() {
				var data = google.visualization.arrayToDataTable(response.data.estatus_nivel);
				var options = {title: 'RESULTADOS  GLOBALES'};
				var chart = new google.visualization.PieChart(document.getElementById('siglo_xxi_2'));
				chart.draw(data, options);
				});
		// EVALUACIÓN DIAGNÓSTICA PARTICIPACIÓN NIVEL ESCOLAR 
			google.charts.setOnLoadCallback(function() {
				var data = google.visualization.arrayToDataTable(response.data.graph_diagnostica);
				var options = {title: 'PARTICIPACIÓN NIVEL ESCOLAR'};
				var chart = new google.visualization.PieChart(document.getElementById('eva_diagnostica_1'));
				chart.draw(data, options);
				});
		// EVALUACIÓN DIAGNÓSTICA RESULTADOS  GLOBALES
			google.charts.setOnLoadCallback(function() {
				var data = google.visualization.arrayToDataTable(response.data.globales_diagnostica);
				var options = {title: 'RESULTADOS  GLOBALES'};
				var chart = new google.visualization.PieChart(document.getElementById('eva_diagnostica_2'));
				chart.draw(data, options);
				});
			console.log(response.data.chart_data[0].labels);	
			console.log(response.data.chart_data[1].datasets);	
		// ESTATUS PROMEDIO EN LOS NIVELES EDUCATIVOS
				var ctx = document.getElementById('myChart').getContext('2d');
				var chart = new Chart(ctx, {
					// The type of chart we want to create
					type: 'radar',
					// The data for our dataset
					data: {
					labels: response.data.chart_data[0].labels,
					datasets: response.data.chart_data[1].datasets
					},
					// Configuration options go here
					options: {}
				});
				
			}, function (error) {
				console.log("Error al cargar las especialidades");
			});

    };
    AdminDashboardComponent.prototype.submitHomeText = function () {
        var _this = this;
        //noinspection TypeScriptValidateJSTypes
        var textsHome = {
            text_left: jQuery("#text_left").val(),
            text_right: jQuery("#text_right").val(),
            accionType: 1
        };
        this._userService.changeHome(textsHome).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            if (response.status == 200) {
                confirm("Correcto !!! Los textos se guardaron correctamente");
            } else {
                alert("Error al guardar los textos");
            }
        }, function (error) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#passwordButton").button('reset');
            _this._notificationsService.error("Error", "Imposible cambiar la contraseña");
        });
    };
    AdminDashboardComponent.prototype.loadFilePageHeader = function (event) {
        var input = event.target;
        if (input.files.length == 0) {
            return;
        }
        this.filesToUpload = input.files;
        var reader = new FileReader();
        reader.onload = function () {
            var dataURL = reader.result;
            jQuery('#page_header').attr('src', dataURL);
        };
        reader.readAsDataURL(input.files[0]);
        this.readyPageHeader = true;
    };
    AdminDashboardComponent.prototype.uploadPageHeader = function () {
        var _this = this;
        var _url = this.url + "/upload-image/page_header";
        this._uploadService.makeFileRequest(this.token, _url, ['image'], this.filesToUpload).then(function (result) {
            _this.resultUpload = result;
            jQuery('#page_header-progress-bar').attr("value", 100);
            jQuery('#page_header-progress-bar').css("width", 100 + "%");
            jQuery('#status-page_header').text("Carga completa !!!");
        }, function (error) {
            console.log(error);
        });
    };
    AdminDashboardComponent.prototype.loadFileFundacion = function (event) {
        var input = event.target;
        if (input.files.length == 0) {
            return;
        }
        this.filesToUpload = input.files;
        var reader = new FileReader();
        reader.onload = function () {
            var dataURL = reader.result;
            jQuery('#fundacion').attr('src', dataURL);
        };
        reader.readAsDataURL(input.files[0]);
        this.readyFundacion = true;
    };
    AdminDashboardComponent.prototype.uploadFundacion = function () {
        var _this = this;
        var _url = this.url + "/upload-image/fundacion";
        this._uploadService.makeFileRequest(this.token, _url, ['image'], this.filesToUpload).then(function (result) {
            _this.resultUpload = result;
            jQuery('#fundacion-progress-bar').attr("value", 100);
            jQuery('#fundacion-progress-bar').css("width", 100 + "%");
            jQuery('#status-fundacion').text("Carga completa !!!");
        }, function (error) {
            console.log(error);
        });
    };
    AdminDashboardComponent.prototype.loadFileLogoSinadepFooter = function (event) {
        var input = event.target;
        if (input.files.length == 0) {
            return;
        }
        this.filesToUpload = input.files;
        var reader = new FileReader();
        reader.onload = function () {
            var dataURL = reader.result;
            jQuery('#logo_sinadep_footer').attr('src', dataURL);
        };
        reader.readAsDataURL(input.files[0]);
        this.readyLogoSinadepFooter = true;
    };
    AdminDashboardComponent.prototype.uploadLogoSinadepFooter = function () {
        var _this = this;
        var _url = this.url + "/upload-image/logo_sinadep_footer";
        this._uploadService.makeFileRequest(this.token, _url, ['image'], this.filesToUpload).then(function (result) {
            _this.resultUpload = result;
            jQuery('#logo_sinadep_footer-progress-bar').attr("value", 100);
            jQuery('#logo_sinadep_footer-progress-bar').css("width", 100 + "%");
            jQuery('#status-logo_sinadep_footer').text("Carga completa !!!");
        }, function (error) {
            console.log(error);
        });
    };
    AdminDashboardComponent.prototype.loadFileLogoSinadep = function (event) {
        var input = event.target;
        if (input.files.length == 0) {
            return;
        }
        this.filesToUpload = input.files;
        var reader = new FileReader();
        reader.onload = function () {
            var dataURL = reader.result;
            jQuery('#logo_sinadep').attr('src', dataURL);
        };
        reader.readAsDataURL(input.files[0]);
        this.readyLogoSinadep = true;
    };
    AdminDashboardComponent.prototype.uploadLogoSinadep = function () {
        var _this = this;
        var _url = this.url + "/upload-image/logo_sinadep";
        this._uploadService.makeFileRequest(this.token, _url, ['image'], this.filesToUpload).then(function (result) {
            _this.resultUpload = result;
            jQuery('#logo_sinadep-progress-bar').attr("value", 100);
            jQuery('#logo_sinadep-progress-bar').css("width", 100 + "%");
            jQuery('#status-logo_sinadep').text("Carga completa !!!");
        }, function (error) {
            console.log(error);
        });
    };
    AdminDashboardComponent.prototype.loadFileMejoresMaestros = function (event) {
        var input = event.target;
        if (input.files.length == 0) {
            return;
        }
        this.filesToUpload = input.files;
        var reader = new FileReader();
        reader.onload = function () {
            var dataURL = reader.result;
            jQuery('#mejores_maestros').attr('src', dataURL);
        };
        reader.readAsDataURL(input.files[0]);
        this.readyMejoresMaestros = true;
    };
    AdminDashboardComponent.prototype.uploadMejoresMaestros = function () {
        var _this = this;
        var _url = this.url + "/upload-image/mejores_maestros";
        this._uploadService.makeFileRequest(this.token, _url, ['image'], this.filesToUpload).then(function (result) {
            _this.resultUpload = result;
            jQuery('#mejores_maestros-progress-bar').attr("value", 100);
            jQuery('#mejores_maestros-progress-bar').css("width", 100 + "%");
            jQuery('#status-mejores_maestros').text("Carga completa !!!");
        }, function (error) {
            console.log(error);
        });
    };
    AdminDashboardComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/dashboard.html',
            providers: [user_service_1.UserService,
                angular2_notifications_1.NotificationsService, user_service_1.UserService, upload_service_1.UploadService]
        }),
        __param(2, core_1.Inject(app_config_1.APP_CONFIG)), 
        __metadata('design:paramtypes', [user_service_1.UserService, upload_service_1.UploadService, Object])
    ], AdminDashboardComponent);
    return AdminDashboardComponent;
}());
exports.AdminDashboardComponent = AdminDashboardComponent;
//# sourceMappingURL=admin-dashboard.component.js.map