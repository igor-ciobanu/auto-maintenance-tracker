import { Component, Inject, ViewEncapsulation } from '@angular/core';
import { MD_DIALOG_DATA, MdDialogRef } from '@angular/material';
import { CarMark, CarMarkService } from '../../car-mark.service';

@Component({
    selector: 'edit-car-mark',
    encapsulation: ViewEncapsulation.Emulated,
    styleUrls: ['./edit-car-mark.component.scss'],
    templateUrl: './edit-car-mark.component.html'
})
export class EditCarMarkComponent {

    public carMark: CarMark;

    constructor(
        @Inject(MD_DIALOG_DATA)
        private _carMark: CarMark,
        private _dialogRef: MdDialogRef<EditCarMarkComponent>,
        private _carMarkService: CarMarkService
    ) {
        this.carMark = _carMark;
    }

    public update(): void {
        this._carMarkService.carMarkList.subscribe(() => {
            this._dialogRef.close();
        });
        this._carMarkService.update(this.carMark);
    }

}
