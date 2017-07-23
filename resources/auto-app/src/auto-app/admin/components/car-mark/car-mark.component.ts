import { Component, OnInit, ViewEncapsulation } from '@angular/core';
import { Observable } from 'rxjs/Observable';
import { DataSource } from '@angular/cdk';
import { CarMark, CarMarkService } from './car-mark.service';
import { MdDialog, MdDialogConfig } from '@angular/material';
import { CreateCarMarkComponent } from './components/create-car-mark/create-car-mark.component';
import { EditCarMarkComponent } from './components/edit-car-mark/edit-car-mark.component';

class MarkDataSource extends DataSource<any> {

    constructor(private _markService: CarMarkService) {
        super();
    }

    connect(): Observable<CarMark[]> {
        return this._markService.carMarkList;
    }

    disconnect() {}
}


@Component({
    selector: 'car-mark',
    encapsulation: ViewEncapsulation.Emulated,
    styleUrls: ['./car-mark.component.scss'],
    templateUrl: './car-mark.component.html'
})
export class CarMarkComponent implements OnInit {

    public carMarkList: MarkDataSource | null;

    public displayedColumns: string[] = ['name', 'action'];

    constructor(
        private _carMarkService: CarMarkService,
        private _dialog: MdDialog
    ) {
        this.carMarkList = new MarkDataSource(_carMarkService);
    }

    public ngOnInit(): void {
        this._carMarkService.getList();
    }

    public createCarMark(): void {
        let dialogRef = this._dialog.open(CreateCarMarkComponent);
        dialogRef.afterClosed().subscribe(() => {});
    }

    public editCarMark(carMark: CarMark): void {
        let dialogRef = this._dialog.open(EditCarMarkComponent, <MdDialogConfig>{
            data: carMark
        });
        dialogRef.afterClosed().subscribe(() => {});
    }

    public removeCarMark(carMark: CarMark): void {
        this._carMarkService.remove(carMark.id);
    }

}
