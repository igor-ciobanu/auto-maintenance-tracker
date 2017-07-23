import { Component, ViewEncapsulation } from '@angular/core';
import { MdDialogRef } from '@angular/material';
import { CarMark, CarMarkService } from '../../car-mark.service';

@Component({
    selector: 'create-car-mark',
    encapsulation: ViewEncapsulation.Emulated,
    styleUrls: ['./create-car-mark.component.scss'],
    templateUrl: './create-car-mark.component.html'
})
export class CreateCarMarkComponent {

    public carMarkName: string;

    constructor(
        private _dialogRef: MdDialogRef<CreateCarMarkComponent>,
        private _carMarkService: CarMarkService,
    ) {}

    public create(): void {
        this._carMarkService.carMarkList.subscribe(() => {
            this._dialogRef.close();
        });
        this._carMarkService.create(<CarMark>{
            name: this.carMarkName
        });
    }

}
