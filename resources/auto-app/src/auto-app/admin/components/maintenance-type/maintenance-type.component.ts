import { Component, OnInit, ViewEncapsulation } from '@angular/core';
import { Observable } from 'rxjs/Observable';
import { DataSource } from '@angular/cdk';
import { MaintenanceType, MaintenanceTypeService } from './maintenance-type.service';
import { MdDialog, MdDialogConfig } from '@angular/material';
import { CreateMaintenanceTypeComponent } from './components/create-maintenance-type/create-maintenance-type.component';
import { EditMaintenanceTypeComponent } from './components/edit-maintenance-type/edit-maintenance-type.component';

class MaintenanceTypeDataSource extends DataSource<any> {

    constructor(private _maintenanceTypeService: MaintenanceTypeService) {
        super();
    }

    connect(): Observable<MaintenanceType[]> {
        return this._maintenanceTypeService.maintenanceTypeList;
    }

    disconnect() {}
}


@Component({
    selector: 'maintenance-type',
    encapsulation: ViewEncapsulation.Emulated,
    styleUrls: ['./maintenance-type.component.scss'],
    templateUrl: './maintenance-type.component.html'
})
export class MaintenanceTypeComponent implements OnInit {

    public maintenanceTypeList: MaintenanceTypeDataSource | null;

    public displayedColumns: string[] = ['name', 'action'];

    constructor(
        private _maintenanceTypeService: MaintenanceTypeService,
        private _dialog: MdDialog
    ) {
        this.maintenanceTypeList = new MaintenanceTypeDataSource(_maintenanceTypeService);
    }

    public ngOnInit(): void {
        this._maintenanceTypeService.getList();
    }

    public createMaintenanceType(): void {
        let dialogRef = this._dialog.open(CreateMaintenanceTypeComponent);
        dialogRef.afterClosed().subscribe(() => {});
    }

    public editMaintenanceType(maintenanceType: MaintenanceType): void {
        let dialogRef = this._dialog.open(EditMaintenanceTypeComponent, <MdDialogConfig>{
            data: maintenanceType
        });
        dialogRef.afterClosed().subscribe(() => {});
    }

    public removeMaintenanceType(maintenanceType: MaintenanceType): void {
        this._maintenanceTypeService.remove(maintenanceType.id);
    }

}
