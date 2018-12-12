"use strict";
var platform_browser_dynamic_1 = require('@angular/platform-browser-dynamic');
var app_module_1 = require('./app.module');
var core_1 = require('@angular/core');
var app_config_1 = require("./app.config");
if (app_config_1.ENVIRONMENT.production) {
    core_1.enableProdMode();
}
var platform = platform_browser_dynamic_1.platformBrowserDynamic();
platform.bootstrapModule(app_module_1.AppModule);
//# sourceMappingURL=main.js.map