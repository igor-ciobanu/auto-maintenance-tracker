import { Component, ViewEncapsulation } from '@angular/core';

@Component({
    selector: 'not-found',
    encapsulation: ViewEncapsulation.Emulated,
    template: ''
})

export class NotFoundComponent {

    constructor() {
        window.location.href = '/not-found';
    }
}
