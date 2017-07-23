import { Component, ViewEncapsulation } from '@angular/core';
import { MdDialogRef } from '@angular/material';
import { CarType, CarTypeService } from '../../car-type.service';

@Component({
    selector: 'create-car-type',
    encapsulation: ViewEncapsulation.Emulated,
    styleUrls: ['./create-car-type.component.scss'],
    templateUrl: './create-car-type.component.html'
})
export class CreateCarTypeComponent {

    public carTypeName: string;

    constructor(
        private _dialogRef: MdDialogRef<CreateCarTypeComponent>,
        private _carTypeService: CarTypeService,
    ) {}

    public create(): void {
        this._carTypeService.carTypeList.subscribe(() => {
            this._dialogRef.close();
        });
        this._carTypeService.create(<CarType>{
            type: this.carTypeName
        });
    }

}
