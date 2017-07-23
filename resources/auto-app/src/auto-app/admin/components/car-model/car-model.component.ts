import { Component, OnInit, ViewEncapsulation } from '@angular/core';
import { Observable } from 'rxjs/Observable';
import { DataSource } from '@angular/cdk';
import { CarModel, CarModelService } from './car-model.service';
import { MdDialog, MdDialogConfig } from '@angular/material';
import { CreateCarModelComponent } from './components/create-car-model/create-car-model.component';
import { EditCarModelComponent } from './components/edit-car-model/edit-car-model.component';

class ModelDataSource extends DataSource<any> {

    constructor(private _markService: CarModelService) {
        super();
    }

    connect(): Observable<CarModel[]> {
        return this._markService.carModelList;
    }

    disconnect() {}
}


@Component({
    selector: 'car-model',
    encapsulation: ViewEncapsulation.Emulated,
    styleUrls: ['./car-model.component.scss'],
    templateUrl: './car-model.component.html'
})
export class CarModelComponent implements OnInit {

    public carModelList: ModelDataSource | null;

    public displayedColumns: string[] = ['mark', 'model', 'action'];

    constructor(
        private _carModelService: CarModelService,
        private _dialog: MdDialog
    ) {
        this.carModelList = new ModelDataSource(_carModelService);
    }

    public ngOnInit(): void {
        this._carModelService.getList();
    }

    public createCarModel(): void {
        let dialogRef = this._dialog.open(CreateCarModelComponent);
        dialogRef.afterClosed().subscribe(() => {});
    }

    public editCarModel(carMark: CarModel): void {
        let dialogRef = this._dialog.open(EditCarModelComponent, <MdDialogConfig>{
            data: carMark
        });
        dialogRef.afterClosed().subscribe(() => {});
    }

    public removeCarModel(carMark: CarModel): void {
        this._carModelService.remove(carMark.id);
    }

}
