import { Component, ViewEncapsulation, OnInit } from '@angular/core';
import { DataSource } from '@angular/cdk';
import { Observable } from 'rxjs/Observable';
import { Car, HomeService } from './home.service';
import { MdDialog, MdDialogConfig } from '@angular/material';
import { MaintainCarComponent } from './components/maintain-car/maintain-car.component';
import { EditCarComponent } from './components/edit-car/edit-car.component';
import { CreateCarComponent } from './components/create-car/create-car.component';

class HomeDataSource extends DataSource<any> {

    constructor(private _homeService: HomeService) {
        super();
    }

    connect(): Observable<Car[]> {
        return this._homeService.carList;
    }

    disconnect() {}
}

@Component({
    selector: 'home',
    encapsulation: ViewEncapsulation.Emulated,
    styleUrls: ['./home.component.scss'],
    templateUrl: './home.component.html'
})
export class HomeComponent implements OnInit {

    public carList: HomeDataSource | null;

    public displayedColumns: string[] = ['mark', 'model', 'vin', 'odometer', 'year', 'maintenances', 'action'];

    constructor(
        private _homeService: HomeService,
        private _dialog: MdDialog
    ) {
        this.carList = new HomeDataSource(_homeService);
    }

    public ngOnInit(): void {
        this._homeService.getList();
    }

    public createCar(): void {
        let dialogRef = this._dialog.open(CreateCarComponent);
        dialogRef.afterClosed().subscribe(() => {});
    }

    public editCar(car: Car): void {
        let dialogRef = this._dialog.open(EditCarComponent, <MdDialogConfig>{
            data: car
        });
        dialogRef.afterClosed().subscribe(() => {});
    }

    public maintainCar(car: Car): void {
        let dialogRef = this._dialog.open(MaintainCarComponent, <MdDialogConfig>{
            data: car
        });
        dialogRef.afterClosed().subscribe(() => {
            this._homeService.getList()
        });
    }

    public removeCar(car: Car): void {
        this._homeService.remove(car.id);
    }
}
