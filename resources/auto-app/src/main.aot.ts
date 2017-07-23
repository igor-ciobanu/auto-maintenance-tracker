import { platformBrowser } from '@angular/platform-browser';
import { enableDebugTools, disableDebugTools } from '@angular/platform-browser';
import { ApplicationRef, enableProdMode } from '@angular/core';
import { AutoAppModuleNgFactory } from '../compiled/src/auto-app/auto-app.module.ngfactory';

let decorateModuleRef = (modRef: any) => {
    const appRef = modRef.injector.get(ApplicationRef);
    const cmpRef = appRef.components[0];

    let _ng = (<any> window).ng;
    enableDebugTools(cmpRef);
    (<any> window).ng.probe = _ng.probe;
    (<any> window).ng.coreTokens = _ng.coreTokens;
    return modRef;
};

if ('production' === ENV) {
    enableProdMode();
    decorateModuleRef = (modRef: any) => {
        disableDebugTools();
        return modRef;
    };
}

export function main(): Promise<any> {
    return platformBrowser()
        .bootstrapModuleFactory(AutoAppModuleNgFactory)
        .then(decorateModuleRef)
        .catch((err) => console.error(err));
}

export function bootstrapDomReady() {
    document.addEventListener('DOMContentLoaded', main);
}

bootstrapDomReady();
