import { Component, ViewEncapsulation } from '@angular/core';
import { MdDialogRef } from '@angular/material';
import { MaintenanceType, MaintenanceTypeService } from '../../maintenance-type.service';

@Component({
    selector: 'create-maintenance-type',
    encapsulation: ViewEncapsulation.Emulated,
    styleUrls: ['./create-maintenance-type.component.scss'],
    templateUrl: './create-maintenance-type.component.html'
})
export class CreateMaintenanceTypeComponent {

    public maintenanceTypeName: string;

    constructor(
        private _dialogRef: MdDialogRef<CreateMaintenanceTypeComponent>,
        private _maintenanceTypeService: MaintenanceTypeService,
    ) {}

    public create(): void {
        this._maintenanceTypeService.maintenanceTypeList.subscribe(() => {
            this._dialogRef.close();
        });
        this._maintenanceTypeService.create(<MaintenanceType>{
            name: this.maintenanceTypeName
        });
    }

}
