import { Component, ViewEncapsulation } from '@angular/core';
import { MdDialogRef } from '@angular/material';
import { MaintenanceRule, MaintenanceRuleService } from '../../maintenance-rule.service';
import { Observable } from 'rxjs/Observable';
import { CarType, CarTypeService } from '../../../car-type/car-type.service';
import { MaintenanceType, MaintenanceTypeService } from '../../../maintenance-type/maintenance-type.service';

@Component({
    selector: 'create-maintenance-rule',
    encapsulation: ViewEncapsulation.Emulated,
    styleUrls: ['./create-maintenance-rule.component.scss'],
    templateUrl: './create-maintenance-rule.component.html'
})
export class CreateMaintenanceRuleComponent {

    public carTypeId: number;

    public maintenanceTypeId: number;

    public maintenanceTypeKM: number;

    public carTypeList: Observable<CarType[]>;

    public maintenanceTypeList: Observable<MaintenanceType[]>;

    constructor(
        private _dialogRef: MdDialogRef<CreateMaintenanceRuleComponent>,
        private _maintenanceRuleService: MaintenanceRuleService,
        private _carTypeService: CarTypeService,
        private _maintenanceTypeService: MaintenanceTypeService
    ) {
        this.carTypeList = _carTypeService.carTypeList;
        this.maintenanceTypeList = _maintenanceTypeService.maintenanceTypeList;
        _carTypeService.getList();
        _maintenanceTypeService.getList();
    }

    public create(): void {
        this._maintenanceRuleService.maintenanceRuleList.subscribe(() => {
            this._dialogRef.close();
        });
        this._maintenanceRuleService.create(<MaintenanceRule>{
            km: this.maintenanceTypeKM,
            car_type_id: this.carTypeId,
            maintenance_type_id: this.maintenanceTypeId
        });
    }

}
