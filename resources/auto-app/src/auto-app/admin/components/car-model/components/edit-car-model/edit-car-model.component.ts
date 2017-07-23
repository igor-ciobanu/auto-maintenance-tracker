import { Component, Inject, ViewEncapsulation } from '@angular/core';
import { MD_DIALOG_DATA, MdDialogRef } from '@angular/material';
import { CarModel, CarModelService } from '../../car-model.service';

@Component({
    selector: 'edit-car-model',
    encapsulation: ViewEncapsulation.Emulated,
    styleUrls: ['./edit-car-model.component.scss'],
    templateUrl: './edit-car-model.component.html'
})
export class EditCarModelComponent {

    public carModel: CarModel;

    constructor(
        @Inject(MD_DIALOG_DATA)
        private _carModel: CarModel,
        private _dialogRef: MdDialogRef<EditCarModelComponent>,
        private _carModelService: CarModelService
    ) {
        this.carModel = _carModel;
    }

    public update(): void {
        this._carModelService.carModelList.subscribe(() => {
            this._dialogRef.close();
        });
        this._carModelService.update(this.carModel);
    }
}
