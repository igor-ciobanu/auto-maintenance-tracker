import { Component, Inject, ViewEncapsulation } from '@angular/core';
import { MD_DIALOG_DATA, MdDialogRef } from '@angular/material';
import { Car, HomeService } from '../../home.service';

@Component({
    selector: 'edit-car',
    encapsulation: ViewEncapsulation.Emulated,
    styleUrls: ['./edit-car.component.scss'],
    templateUrl: './edit-car.component.html'
})
export class EditCarComponent {

    public car: Car;

    constructor(
        @Inject(MD_DIALOG_DATA)
        private _car: Car,
        private _dialogRef: MdDialogRef<EditCarComponent>,
        private _homeService: HomeService
    ) {
        this.car = _car;
    }

    public update(): void {
        this._homeService.carList.subscribe(() => {
            this._dialogRef.close();
        });
        this._homeService.update(this.car);
    }

}
