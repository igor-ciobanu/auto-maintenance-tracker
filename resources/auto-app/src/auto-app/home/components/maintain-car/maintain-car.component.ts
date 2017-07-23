import { Component, Inject, ViewEncapsulation } from '@angular/core';
import { CarMaintain, MaintainService } from '../../maintain.service';
import { Car } from '../../home.service';
import { MD_DIALOG_DATA, MdDialogRef } from '@angular/material';

@Component({
    selector: 'maintain-car',
    encapsulation: ViewEncapsulation.Emulated,
    styleUrls: ['./maintain-car.component.scss'],
    templateUrl: './maintain-car.component.html'
})

export class MaintainCarComponent {

    public car: Car;
    public maintenanceKm: number;
    public maintenanceRuleId: number;

    constructor(
        @Inject(MD_DIALOG_DATA)
        private _car: Car,
        private _dialogRef: MdDialogRef<MaintainCarComponent>,
        private _maintainService: MaintainService,
    ) {
        this.car = _car;
    }

    public maintain(): void {
        this._maintainService.maintain(<CarMaintain>{
            car_id: this.car.id,
            maintenance_rule_id: this.maintenanceRuleId,
            km: this.maintenanceKm
        });
        this._dialogRef.close();
    }
}
