import { Component, ViewEncapsulation } from '@angular/core';
import { MdDialogRef } from '@angular/material';
import { Observable } from 'rxjs/Observable';
import { CarModel, CarModelService } from '../../car-model.service';
import { CarMark, CarMarkService } from '../../../car-mark/car-mark.service';

@Component({
    selector: 'create-car-model',
    encapsulation: ViewEncapsulation.Emulated,
    styleUrls: ['./create-car-model.component.scss'],
    templateUrl: './create-car-model.component.html'
})
export class CreateCarModelComponent {

    public carModelName: string;

    public carMarkId: number;

    public carMarkList:  Observable<CarMark[]>;

    constructor(
        private _dialogRef: MdDialogRef<CreateCarModelComponent>,
        private _carMarkService: CarMarkService,
        private _carModelService: CarModelService,
    ) {
        this.carMarkList = _carMarkService.carMarkList;
        _carMarkService.getList();
    }

    public create(): void {
        this._carModelService.carModelList.subscribe(() => {
            this._dialogRef.close();
        });
        this._carModelService.create(<CarModel>{
            mark_id: this.carMarkId,
            name: this.carModelName
        });
    }

}
