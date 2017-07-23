import { platformBrowserDynamic } from '@angular/platform-browser-dynamic';
import { enableDebugTools, disableDebugTools } from '@angular/platform-browser';
import { ApplicationRef, enableProdMode } from '@angular/core';
import { AutoAppModule } from './auto-app';

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
    return platformBrowserDynamic()
        .bootstrapModule(AutoAppModule)
        .then(decorateModuleRef)
        .catch((err) => console.error(err));
}

main();
