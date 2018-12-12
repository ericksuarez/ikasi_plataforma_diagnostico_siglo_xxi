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
var __param = (this && this.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};
var core_1 = require("@angular/core");
var http_1 = require("@angular/http");
var auth_service_1 = require("./auth.service");
var app_config_1 = require("../app.config");
var IneeService = (function () {
    function IneeService(_http, _authservice, config) {
        this._http = _http;
        this._authservice = _authservice;
        this.config = config;
        this.controller = "/inee";
        this.controllerEvaluation = "/evaluation-inee";
        this.url = config.apiEndPoint + this.controller;
        this.urlEvaluation = config.apiEndPoint + this.controllerEvaluation;
        this.token = _authservice.getToken();
    }
    /**
     * Método para crear una nueva dimensión
     * @param dimension
     * @returns {Observable<R>}
     */
    IneeService.prototype.createDimension = function (dimension) {
        var json = JSON.stringify(dimension);
        var params = "json=" + json;
        var headers = new http_1.Headers({ 'Content-Type': 'application/x-www-form-urlencoded' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.post(this.url + '/create-dimension', params, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    /**
     * Devuelve los datos de una dimensión
     * @param id
     * @returns {Observable<R>}
     */
    IneeService.prototype.getDimension = function (id) {
        var headers = new http_1.Headers({ 'Accept': 'application/json' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.get(this.url + "/get-dimension/" + id, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
        //    if (response.code == 401) {
        //        location.href = "/unauthorized";
        //    }
        //    else if (response.code == 404) {
        //        location.href = "/404";
        //    }
            return response;
        });
    };
    /**
     * Método para crear un nuevo parámetro
     * @param parameter
     * @param id
     * @returns {Observable<R>}
     */
    IneeService.prototype.createParameter = function (parameter, id) {
        var json = JSON.stringify(parameter);
        var params = "json=" + json;
        return this.sendRequest(params, '/create-parameter/', id);
    };
    /**
     * Devuelve los datos de un parámetro
     * @param id
     * @returns {Observable<R>}
     */
    IneeService.prototype.getParameter = function (id) {
        var headers = new http_1.Headers({ 'Accept': 'application/json' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.get(this.url + "/get-parameter/" + id, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            else if (response.code == 404) {
                location.href = "/404";
            }
            return response;
        });
    };
    /**
     * Método para crear un nuevo indicador
     * @param indicator
     * @param id
     * @returns {Observable<R>}
     */
    IneeService.prototype.createIndicator = function (indicator, id) {
        var json = JSON.stringify(indicator);
        var params = "json=" + json;
        return this.sendRequest(params, '/create-indicator/', id);
    };

    IneeService.prototype.filterDimension = function (filters) {
        var headers = new http_1.Headers({ 'Accept': 'application/json' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.get(this.url + "/filter-dimension/" + filters.education_level + "/" + filters.teacher_function, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            else if (response.code == 404) {
                location.href = "/404";
            }
            return response;
        });
    };
    /**
     * Listado para selector HTML
     * @returns {Observable<R>}
     */
    IneeService.prototype.getList = function (educationLevel, teacherFunction) {
        return this._http.get(this.url + "/list-dimension/" + educationLevel + "/" + teacherFunction).map(function (response) { return response.json(); });
    };
    /**
     * Listado de parámetros según el identificador de la dimensión
     * @param dimensionId
     * @returns {Observable<R>}
     */
    IneeService.prototype.getListParameter = function (dimensionId) {
        return this._http.get(this.url + "/list-parameter/" + dimensionId).map(function (response) { return response.json(); });
    };
    /**
     * Listado de indicadores según el identificador del parametro
     * @param parameterId
     * @returns {Observable<any | Promise<any>>}
     */
    IneeService.prototype.getListIndicator = function (parameterId) {
        return this._http.get(this.url + "/list-indicator/" + parameterId).map(function (response) { return response.json(); });
    };
    /**
     * Add question to evaluation per profile
     * @param question
     * @returns {Observable<R>}
     */
    IneeService.prototype.createQuestion = function (question) {
        var json = JSON.stringify(question);
        var params = "json=" + json;
        var headers = new http_1.Headers({ 'Content-Type': 'application/x-www-form-urlencoded' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.post(this.urlEvaluation + "/create", params, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            else if (response.code == 404) {
                location.href = "/404";
            }
            return response;
        });
    };
    /**
     * Update question
     * @param question
     * @param questionId
     * @returns {Observable<any>}
     */
    IneeService.prototype.updateQuestion = function (question, questionId) {
        var json = JSON.stringify(question);
        var params = "json=" + json;
        var headers = new http_1.Headers({ 'Content-Type': 'application/x-www-form-urlencoded' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.post(this.urlEvaluation + "/update/" + questionId, params, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            else if (response.code == 404) {
                location.href = "/404";
            }
            return response;
        });
    };
    /**
     * Get all questions
     * @param filters
     * @returns {Observable<any>}
     */
    IneeService.prototype.filterEvaluation = function (filters) {
        var headers = new http_1.Headers({ 'Accept': 'application/json' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.get(this.urlEvaluation + "/filter-evaluation/" + filters.education_level + "/" + filters.teacher_function, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            else if (response.code == 404) {
                location.href = "/404";
            }
            return response;
        });
    };
    /**
     * Delete a question
     * @param id
     * @returns {Observable<any>}
     */
    IneeService.prototype.deleteQuestion = function (id) {
        var headers = new http_1.Headers({ 'X-API-KEY': this.token });
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.post(this.urlEvaluation + "/delete/" + id, {}, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            else if (response.code == 404) {
                location.href = "/404";
            }
            return response;
        });
    };
    /**
     * Detail view of question
     * @param id
     * @returns {Observable<any>}
     */
    IneeService.prototype.viewQuestion = function (id) {
        var headers = new http_1.Headers({ 'Accept': 'application/json' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.get(this.urlEvaluation + "/view/" + id, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
	/**
     * Método para eleminar parametro, indicador
     * @param id
	 * @param level 1 - parameter , 2 - indicator
     * @returns {Observable<R>}
     */
    IneeService.prototype.delete = function (id, level) {
		if(level == 1){
			var headers = new http_1.Headers({ 'Accept': 'application/json' });
			headers.append('X-API-KEY', this.token);
			var options = new http_1.RequestOptions({ headers: headers });
			return this._http.get(this.url + "/delete-parameter/" + id, options)
				.map(function (response) { return response.json(); })
				.map(function (response) {
				if (response.code == 401) {
					location.href = "/unauthorized";
				}
				return response;
			});
		} 
		if(level == 2){
			var headers = new http_1.Headers({ 'Accept': 'application/json' });
			headers.append('X-API-KEY', this.token);
			var options = new http_1.RequestOptions({ headers: headers });
			return this._http.get(this.url + "/delete-indicator/" + id, options)
				.map(function (response) { return response.json(); })
				.map(function (response) {
				if (response.code == 401) {
					location.href = "/unauthorized";
				}
				return response;
			});
		}
		if(level == 3){
			var headers = new http_1.Headers({ 'Accept': 'application/json' });
			headers.append('X-API-KEY', this.token);
			var options = new http_1.RequestOptions({ headers: headers });
			return this._http.get(this.url + "/delete-dimension/" + id, options)
				.map(function (response) { return response.json(); })
				.map(function (response) {
				if (response.code == 401) {
					location.href = "/unauthorized";
				}
				return response;
			});
		}
    };
	/**
     * Método para eleminar parametro, indicador
     * @param id
	 * @param level 1 - parameter , 2 - indicator
     * @returns {Observable<R>}
     */
    IneeService.prototype.edit = function (id, name, level) {
		if(level == 1){
			var data = {
				id: id,
				name: name
			};
			var json = JSON.stringify(data);
			var params = "json=" + json;
			return this.sendRequest(params, '/update-parameter/', id);
		} else {
			var json = JSON.stringify({name: name});
			var params = "json=" + json;
			return this.sendRequest(params, '/update-indicator/', id);
		}
    };
	/**
     * @param params
     * @param method
     * @param id
     * @returns {Observable<R>}
     */
    IneeService.prototype.sendRequest = function (params, method, id) {
        var headers = new http_1.Headers({ 'Content-Type': 'application/x-www-form-urlencoded' });
        headers.append('X-API-KEY', this.token);
        var options = new http_1.RequestOptions({ headers: headers });
        return this._http.post(this.url + method + id, params, options)
            .map(function (response) { return response.json(); })
            .map(function (response) {
            if (response.code == 401) {
                location.href = "/unauthorized";
            }
            return response;
        });
    };
    IneeService = __decorate([
        core_1.Injectable(),
        __param(2, core_1.Inject(app_config_1.APP_CONFIG)), 
        __metadata('design:paramtypes', [http_1.Http, auth_service_1.AuthService, Object])
    ], IneeService);
    return IneeService;
}());
exports.IneeService = IneeService;
//# sourceMappingURL=inee.service.js.map