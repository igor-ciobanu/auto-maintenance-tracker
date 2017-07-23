import { Component, ViewEncapsulation } from '@angular/core';
import { MdDialogRef } from '@angular/material';
import { Observable } from 'rxjs/Observable';
import { CarModel, CarModelService } from '../../../admin/components/car-model/car-model.service';
import { CarType, CarTypeService } from '../../../admin/components/car-type/car-type.service';
import { Car, HomeService } from '../../home.service';

@Component({
    selector: 'create-car',
    encapsulation: ViewEncapsulation.Emulated,
    styleUrls: ['./create-car.component.scss'],
    templateUrl: './create-car.component.html'
})
export class CreateCarComponent {

    public carVIN: string;
    public carYear: number;
    public carKm: number;
    public carModelId: number;
    public carTypeId: number;
    public carModelList:  Observable<CarModel[]>;
    public carTypeList:  Observable<CarType[]>;


    constructor(
        private _dialogRef: MdDialogRef<CreateCarComponent>,
        private _homeService: HomeService,
        private _carModelService: CarModelService,
        private _carTypeService: CarTypeService,
    ) {
        this.carModelList = _carModelService.carModelList;
        _carModelService.getList();
        this.carTypeList = _carTypeService.carTypeList;
        _carTypeService.getList();
    }

    public create(): void {
        this._homeService.carList.subscribe(() => {
            this._dialogRef.close();
        });
        this._homeService.create(<Car>{
            id: null,
            model_id: this.carModelId,
            car_type_id: this.carTypeId,
            vin: this.carVIN,
            year: this.carYear,
            km: this.carKm
        });
    }

}
