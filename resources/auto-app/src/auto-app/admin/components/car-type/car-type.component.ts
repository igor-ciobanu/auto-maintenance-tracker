import { Component, OnInit, ViewEncapsulation } from '@angular/core';
import { Observable } from 'rxjs/Observable';
import { DataSource } from '@angular/cdk';
import { CarType, CarTypeService } from './car-type.service';
import { MdDialog, MdDialogConfig } from '@angular/material';
import { CreateCarTypeComponent } from './components/create-car-type/create-car-type.component';
import { EditCarTypeComponent } from './components/edit-car-type/edit-car-type.component';

class TypeDataSource extends DataSource<any> {

    constructor(private _typeService: CarTypeService) {
        super();
    }

    connect(): Observable<CarType[]> {
        return this._typeService.carTypeList;
    }

    disconnect() {}
}


@Component({
    selector: 'car-type',
    encapsulation: ViewEncapsulation.Emulated,
    styleUrls: ['./car-type.component.scss'],
    templateUrl: './car-type.component.html'
})
export class CarTypeComponent implements OnInit {

    public carTypeList: TypeDataSource | null;

    public displayedColumns: string[] = ['name', 'action'];

    constructor(
        private _carTypeService: CarTypeService,
        private _dialog: MdDialog
    ) {
        this.carTypeList = new TypeDataSource(_carTypeService);
    }

    public ngOnInit(): void {
        this._carTypeService.getList();
    }

    public createCarType(): void {
        let dialogRef = this._dialog.open(CreateCarTypeComponent);
        dialogRef.afterClosed().subscribe(() => {});
    }

    public editCarType(carType: CarType): void {
        let dialogRef = this._dialog.open(EditCarTypeComponent, <MdDialogConfig>{
            data: carType
        });
        dialogRef.afterClosed().subscribe(() => {});
    }

    public removeCarType(carType: CarType): void {
        this._carTypeService.remove(carType.id);
    }

}
