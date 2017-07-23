import { enableDebugTools, disableDebugTools } from '@angular/platform-browser';
import { ApplicationRef } from '@angular/core';

export function decorateModuleRef(modRef: any) {
    if ('production' === ENV) {
        disableDebugTools();
        return modRef;
    }
    (<any> window).ng.probe = (<any> window).ng.probe;
    (<any> window).ng.coreTokens = (<any> window).ng.coreTokens;
    enableDebugTools(modRef.injector.get(ApplicationRef).components[0]);
    return modRef;
};
