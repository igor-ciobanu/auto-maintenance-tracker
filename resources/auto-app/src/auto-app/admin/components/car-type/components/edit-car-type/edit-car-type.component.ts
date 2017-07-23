import { Component, Inject, ViewEncapsulation } from '@angular/core';
import { MD_DIALOG_DATA, MdDialogRef } from '@angular/material';
import { CarType, CarTypeService } from '../../car-type.service';

@Component({
    selector: 'edit-car-type',
    encapsulation: ViewEncapsulation.Emulated,
    styleUrls: ['./edit-car-type.component.scss'],
    templateUrl: './edit-car-type.component.html'
})
export class EditCarTypeComponent {

    public carType: CarType;

    constructor(
        @Inject(MD_DIALOG_DATA)
        private _carType: CarType,
        private _dialogRef: MdDialogRef<EditCarTypeComponent>,
        private _carTypeService: CarTypeService
    ) {
        this.carType = _carType;
    }

    public update(): void {
        this._carTypeService.carTypeList.subscribe(() => {
            this._dialogRef.close();
        });
        this._carTypeService.update(this.carType);
    }

}
