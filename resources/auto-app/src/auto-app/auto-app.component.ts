import { Component, Injectable, ViewEncapsulation } from '@angular/core';

@Injectable()
@Component({
    selector: 'auto-app',
    encapsulation: ViewEncapsulation.Emulated,
    styleUrls: ['./auto-app.component.scss'],
    templateUrl: './auto-app.component.html'
})
export class AutoAppComponent {}
