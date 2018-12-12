/**
 * System configuration for Angular samples
 * Adjust as necessary for your application needs.
 */
(function (global) {
    System.config({
        paths: {
            // paths serve as alias
            'npm:': 'node_modules/'
        },
        // map tells the System loader where to look for things
        map: {
            // our app is within the app folder
            app: 'app',
            // angular bundles
            '@angular/core': 'npm:@angular/core/bundles/core.umd.js',
            '@angular/common': 'npm:@angular/common/bundles/common.umd.js',
            '@angular/compiler': 'npm:@angular/compiler/bundles/compiler.umd.js',
            '@angular/platform-browser': 'npm:@angular/platform-browser/bundles/platform-browser.umd.js',
            '@angular/platform-browser-dynamic': 'npm:@angular/platform-browser-dynamic/bundles/platform-browser-dynamic.umd.js',
            '@angular/http': 'npm:@angular/http/bundles/http.umd.js',
            '@angular/router': 'npm:@angular/router/bundles/router.umd.js',
            '@angular/forms': 'npm:@angular/forms/bundles/forms.umd.js',
            // other libraries
            'rxjs': 'npm:rxjs',
            'angular-in-memory-web-api': 'npm:angular-in-memory-web-api',
            'moment': 'node_modules/moment',
            'angular2-notifications': 'node_modules/angular2-notifications',
            'ng2-ckeditor': 'npm:ng2-ckeditor',
            'ng2-charts': 'node_modules/ng2-charts',
            'chart.js': 'node_modules/chart.js/dist/Chart.bundle.js'
        },
        // packages tells the System loader how to load when no filename and/or no extension
        packages: {
            app: {
                main: './main.js',
                defaultExtension: 'js'
            },
            rxjs: {
                defaultExtension: 'js'
            },
            'angular-in-memory-web-api': {
                main: './index.js',
                defaultExtension: 'js'
            },
            'moment': {defaultExtension: 'js'},
            'angular2-notifications': {main: 'components.js', defaultExtension: 'js'},
            "ng2-ckeditor": {
                main: 'lib/index.js',
                defaultExtension: 'js'
            },
            "ng2-charts": {main: 'index.js', defaultExtension: 'js'},
            'chart.js': {defaultExtension: 'js'}
        }
    });
})(this);