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
var catalog_form_1 = require("../../models/catalog_form");
var inee_service_1 = require("../../services/inee.service");
var router_1 = require("@angular/router");
var notifications_service_1 = require("angular2-notifications/src/notifications.service");
var location_1 = require('@angular/common');
var AdminIndicatorCreateComponent = (function () {
    function AdminIndicatorCreateComponent(_ineeService, _activatedRoute, _notificationsService ,location) {
        this._ineeService = _ineeService;
		this.location = location;
        this._activatedRoute = _activatedRoute;
        this._notificationsService = _notificationsService;
        this.model = new catalog_form_1.CatalogForm();
        this.parameter = {
            id: null,
            name: null,
            dimension: {
                id: 0
            }
        };
        this.indicators = [];
        // Configuración para las notificaciones
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
    }
    AdminIndicatorCreateComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.loading = true;
        this.selector = jQuery("#validator-dimension-ckeditor");
        this._activatedRoute.params.subscribe(function (params) {
            var id = params['id'];
            _this._ineeService.getParameter(id).subscribe(function (response) {
                _this.parameter = response.parameter;
                _this.indicators = response.indicators;
                _this.loading = false;
            });
        });
    };
    AdminIndicatorCreateComponent.prototype.onChange = function (event) {
        if (event.length > 0) {
            this.selector.removeClass('custom-ckeditor-invalid');
            this.selector.addClass('custom-ckeditor-valid');
        }
        else {
            this.selector.removeClass('custom-ckeditor-valid');
            this.selector.addClass('custom-ckeditor-invalid');
        }
    };
    AdminIndicatorCreateComponent.prototype.onSubmit = function () {
        var _this = this;
        //noinspection TypeScriptValidateJSTypes
        jQuery("#parameterFormButton").button('loading');
        this._ineeService.createIndicator(this.model, this.parameter.id).subscribe(function (response) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#parameterFormButton").button('reset');
            if (response.status == 'success') {
                _this._notificationsService.success(response.title, response.message);
                _this.indicators.push(response.data);
            }
            else {
                _this._notificationsService.error(response.title, response.message);
            }
        }, function (error) {
            //noinspection TypeScriptValidateJSTypes
            jQuery("#parameterFormButton").button('reset');
            _this._notificationsService.error("Error", "Ocurrió un error al guardar los datos");
        });
    };
    AdminIndicatorCreateComponent.prototype.toGoBack = function () {
        var _this = this;
        _this.location.back();
    };
	AdminIndicatorCreateComponent.prototype.delete = function (id) {
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
						_this._ineeService.delete(id,2).subscribe(function (response) {

							if (response.status == 200) {
								_this._notificationsService.success(response.title, response.message);
								jQuery("#indicator-" + id).remove();
							}
							else {
								_this._notificationsService.error(response.title, response.message);
							}
						}, function (error) {
							_this._notificationsService.error("Error", "Ocurrió un error al guardar los datos");
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
	AdminIndicatorCreateComponent.prototype.edit = function (id, name) {
        var _this = this;

        $.confirm({
			icon: 'fa fa-pencil',
            closeIcon: true,
			title: 'Editar Parámetro.',
			content: '' +
			'<form action="" class="formName">' +
			'<div class="form-group">' +
			'<label>Parámetro: ' + name + '</label>' +
			'<input type="text" placeholder="Nuevo nombre del parámetro" class="name form-control" required />' +
			'</div>' +
			'</form>',
			buttons: {
				formSubmit: {
					text: 'Actualizar',
					btnClass: 'btn-success',
					action: function () {
						var name = this.$content.find('.name').val();
						if(!name){
							$.alert('El nombre NO puede ser vacio.');
							return false;
						} else {
							_this._ineeService.edit(id, name,2).subscribe(function (response) {

								if (response.status == 200) {
									_this._notificationsService.success(response.title, response.message);
									jQuery("#name-" + id).html(name);
								}
								else {
									_this._notificationsService.error(response.title, response.message);
								}
							}, function (error) {
								_this._notificationsService.error("Error", "Ocurrió un error al guardar los datos");
							});
						}
					}
				},
				cancel: {
                    text: 'Cancelar',
                    btnClass: 'btn-red',
                    action: function () {
                    }
                }
			},
			onContentReady: function () {
				// bind to events
				var jc = this;
				this.$content.find('form').on('submit', function (e) {
					// if the user submits the form by pressing enter in the field.
					e.preventDefault();
					jc.$$formSubmit.trigger('click'); // reference the button and click it
				});
			}
		});
    };
	AdminIndicatorCreateComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/skill-inee/dimension/add_indicator.html',
            providers: [inee_service_1.IneeService, notifications_service_1.NotificationsService, location_1.Location]
        }), 
        __metadata('design:paramtypes', [inee_service_1.IneeService, router_1.ActivatedRoute, notifications_service_1.NotificationsService, location_1.Location])
    ], AdminIndicatorCreateComponent);
    return AdminIndicatorCreateComponent;
}());
exports.AdminIndicatorCreateComponent = AdminIndicatorCreateComponent;
//# sourceMappingURL=admin-indicator-create.component.js.map