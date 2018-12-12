"use strict";
var __extends = (this && this.__extends) || (function () {
    var extendStatics = Object.setPrototypeOf ||
            ({__proto__: []} instanceof Array && function (d, b) {
                d.__proto__ = b;
            }) ||
            function (d, b) {
                for (var p in b)
                    if (b.hasOwnProperty(p))
                        d[p] = b[p];
            };
    return function (d, b) {
        extendStatics(d, b);
        function __() {
            this.constructor = d;
        }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
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
var course_service_1 = require("../../services/course.service");
var router_1 = require("@angular/router");
var helper_1 = require("../../helpers/helper");
var notifications_service_1 = require("angular2-notifications/src/notifications.service");
var AdminCourseComponent = /** @class */ (function (_super) {
    __extends(AdminCourseComponent, _super);
    function AdminCourseComponent(_courseService, _activatedRoute, _notificationsService) {
        var _this = _super.call(this) || this;
        _this._notificationsService = _notificationsService;
        _this._courseService = _courseService;
        _this._activatedRoute = _activatedRoute;
        // Página anterior
        _this.pagePrev = 1;
        // Siguiente página
        _this.pageNext = 1;
        // Array de cursos
        _this.courses = [];

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
        _this.status = 1;
        return _this;
    }
    AdminCourseComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.loading = true;
        _this.input_show_import = true;

        this._activatedRoute.params.subscribe(function (params) {
            _this.page = params['page'];
            if (!_this.page) {
                _this.page = 1;
            }
            _this._courseService.index(_this.page).subscribe(function (response) {
                _this.courses = response.data;
                _this.pages = [];
                //noinspection TypeScriptUnresolvedVariable
                for (var i = 0; i < response.total_pages; i++) {
                    _this.pages.push(i);
                }
                _this.pagePrev = (_this.page > 1) ? (parseInt(_this.page) - 1) : _this.page;
                //noinspection TypeScriptUnresolvedVariable
                _this.pageNext = (_this.page < response.total_pages) ? (parseInt(_this.page) + 1) : _this.page;
                _this.loading = false;
            }, function (error) {
                _this._notificationsService.error("Error!!!", "No se logro cargar el listado");
            });
        });
        jQuery("#main-navigation").find(">ul>li.active").removeClass("active");
        jQuery("#menu-catalog").addClass("active");

    };
    AdminCourseComponent.prototype.showImport = function () {
        console.log("showImport");
        var _this = this;
        this.table_list_course = true;
        this.input_show_import = false;
    }
    AdminCourseComponent.prototype.loadFile = function (event) {
        var _this = this;
        var input = event.target;
        const files = input.files;
        jQuery("#title-msj").html("<samp>Los cursos se estan cargando...</samp>");
        jQuery("#status").html("");

        if (files && files.length) {
            jQuery("#status").append("<p class='text-warning'><samp>Nombre del archivo: " + files[0].name + "</samp></p>");
            jQuery("#status").append("<p class='text-warning'><samp>Tipo de archivo: " + files[0].type + "</samp></p>");
            jQuery("#status").append("<p class='text-warning'><samp>Tamaño: " + files[0].size + " bytes</samp></p>");
//            console.log("Filename: " + files[0].name);
//            console.log("Type: " + files[0].type);
//            console.log("Size: " + files[0].size + " bytes");
            if (files[0].type === "text/plain") {
                const fileToRead = files[0];
                const fileReader = new FileReader();
                fileReader.onload = function (fileLoadedEvent) {
                    const textFromFileLoaded = fileLoadedEvent.target.result;
                    this.csvContent = textFromFileLoaded;
//                console.log(this.csvContent);
                    var rows = this.csvContent.split("\r\n");

                    for (var i = 1; i < rows.length; i++) {
//                    console.log(rows[i]);
                        var columns = rows[i].split('\t');
                        if (columns[0].trim() !== "") {
                            var area_elemnts = [];
                            for (var j = 8; j <= columns.length; j++) {
                                if (columns[j] !== "undefined" && columns[j] !== "" && columns[j] !== null) {
                                    area_elemnts.push(columns[j]);
                                }
                            }

                            var course = {
                                name: columns[0],
                                description: columns[1],
                                education_level: columns[2],
                                teacher_function: columns[3],
                                specialty: columns[4],
                                link: columns[5],
                                type_suggestion: columns[6],
                                skill_century: columns[7],
                                area_century: area_elemnts
                            };

                            console.log(course);

                            _this._courseService.createBulk(course).subscribe(function (response) {
                                if (response.status == 'success') {
                                    jQuery("#status").append("<p class='text-success'><samp>" + response.title + " - " + response.message + ".</samp></p>");
                                } else {
                                    jQuery("#status").append("<p class='text-danger'><samp>" + response.title + " - " + response.message + ".</samp></p>");
                                }
                            });
                        }
                    }
                };
                fileReader.onloadend = function () {
                    jQuery("#title-msj").html("<samp>Se termino de cargar los cursos.</samp>");
                };

                fileReader.readAsText(input.files[0], "windows-1252");
            } else {
                jQuery("#status").append("<p class='text-danger'><samp>Error al cargar el archivo. Solo se aceptan archivos 'txt'.</samp></p>");
            }
        }
        this.ready = true;
    };
    AdminCourseComponent.prototype.upload = function () {
        var _this = this;
        this.table_list_course = false;
        this.loading = true;
        _this.input_show_import = true;
        jQuery("#title-msj").html("<samp>Los cursos se estan cargando...</samp>");
        jQuery("#status").html("");
        this._activatedRoute.params.subscribe(function (params) {
            _this.page = params['page'];
            if (!_this.page) {
                _this.page = 1;
            }
            _this._courseService.index(_this.page).subscribe(function (response) {
                _this.courses = response.data;
                _this.pages = [];
                //noinspection TypeScriptUnresolvedVariable
                for (var i = 0; i < response.total_pages; i++) {
                    _this.pages.push(i);
                }
                _this.pagePrev = (_this.page > 1) ? (parseInt(_this.page) - 1) : _this.page;
                //noinspection TypeScriptUnresolvedVariable
                _this.pageNext = (_this.page < response.total_pages) ? (parseInt(_this.page) + 1) : _this.page;
                _this.loading = false;
            }, function (error) {
                console.log(error);
            });
        });
        jQuery("#main-navigation").find(">ul>li.active").removeClass("active");
        jQuery("#menu-course").addClass("active");
    }
    AdminCourseComponent.prototype.delete = function (courseId) {
        var _this = this;

        $.confirm({
            icon: 'fa fa-warning',
            closeIcon: true,
            title: '¡Confirmación!',
            content: '¿Está seguro que desea desactivar este elemento de la lista?',
            type: 'red',
            typeAnimated: true,
            autoClose: 'close|8000',
            buttons: {
                acptar: {
                    text: 'Aceptar',
                    btnClass: 'btn-green',
                    action: function () {
                        _this._courseService.deactivated(courseId).subscribe(function (response) {
                            if (response.status === 200) {
                                _this._notificationsService.success(response.title, response.message);
                                _this.loading = true;

                                _this._courseService.index(_this.page).subscribe(function (response) {
                                    _this.courses = response.data;
                                    _this.pages = [];
                                    //noinspection TypeScriptUnresolvedVariable
                                    for (var i = 0; i < response.total_pages; i++) {
                                        _this.pages.push(i);
                                    }
                                    _this.pagePrev = (_this.page > 1) ? (parseInt(_this.page) - 1) : _this.page;
                                    //noinspection TypeScriptUnresolvedVariable
                                    _this.pageNext = (_this.page < response.total_pages) ? (parseInt(_this.page) + 1) : _this.page;
                                    _this.loading = false;
                                }, function (error) {
                                    _this._notificationsService.error("Error!!!", "No se logro cargar el listado");
                                });
                                jQuery("#main-navigation").find(">ul>li.active").removeClass("active");
                                jQuery("#menu-course").addClass("active");
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
    AdminCourseComponent.prototype.goSearch = function () {
        var _this = this;
        this.loading = true;
        _this.input_show_import = true;
        _this.page = 1;
        
        _this._courseService.searchByStatus(_this.page, _this.status).subscribe(function (response) {
            _this.courses = response.data;
            _this.pages = [];
            //noinspection TypeScriptUnresolvedVariable
            for (var i = 0; i < response.total_pages; i++) {
                _this.pages.push(i);
            }
            _this.pagePrev = (_this.page > 1) ? (parseInt(_this.page) - 1) : _this.page;
            //noinspection TypeScriptUnresolvedVariable
            _this.pageNext = (_this.page < response.total_pages) ? (parseInt(_this.page) + 1) : _this.page;
            _this.loading = false;
        }, function (error) {
            _this._notificationsService.error("Error!!!", "No se logro cargar el listado");
        });
        jQuery("#main-navigation").find(">ul>li.active").removeClass("active");
        jQuery("#menu-catalog").addClass("active");
    };
    AdminCourseComponent.prototype.statusChangeHandler = function (event) {
        var _this = this;
        _this.status = event.target.value;
        console.log(_this.status);
    };
    AdminCourseComponent = __decorate([
        core_1.Component({
            templateUrl: 'app/views/admin/course/index.html',
            providers: [course_service_1.CourseService, notifications_service_1.NotificationsService]
        }),
        __metadata("design:paramtypes", [course_service_1.CourseService,
            router_1.ActivatedRoute, notifications_service_1.NotificationsService])
    ], AdminCourseComponent);
    return AdminCourseComponent;
}(helper_1.Helper));
exports.AdminCourseComponent = AdminCourseComponent;
//# sourceMappingURL=admin-course.component.js.map