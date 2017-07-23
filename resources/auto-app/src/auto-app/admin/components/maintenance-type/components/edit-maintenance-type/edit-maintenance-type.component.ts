import { Component, Inject, ViewEncapsulation } from '@angular/core';
import { MD_DIALOG_DATA, MdDialogRef } from '@angular/material';
import { MaintenanceType, MaintenanceTypeService } from '../../maintenance-type.service';

@Component({
    selector: 'edit-maintenance-type',
    encapsulation: ViewEncapsulation.Emulated,
    styleUrls: ['./edit-maintenance-type.component.scss'],
    templateUrl: './edit-maintenance-type.component.html'
})
export class EditMaintenanceTypeComponent {

    public maintenanceType: MaintenanceType;

    constructor(
        @Inject(MD_DIALOG_DATA)
        private _maintenanceType: MaintenanceType,
        private _dialogRef: MdDialogRef<EditMaintenanceTypeComponent>,
        private _maintenanceTypeService: MaintenanceTypeService
    ) {
        this.maintenanceType = _maintenanceType;
    }

    public update(): void {
        this._maintenanceTypeService.maintenanceTypeList.subscribe(() => {
            this._dialogRef.close();
        });
        this._maintenanceTypeService.update(this.maintenanceType);
    }

}
