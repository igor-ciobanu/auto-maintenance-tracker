import { Component, Inject, ViewEncapsulation } from '@angular/core';
import { MD_DIALOG_DATA, MdDialogRef } from '@angular/material';
import { MaintenanceRule, MaintenanceRuleService } from '../../maintenance-rule.service';

@Component({
    selector: 'edit-maintenance-rule',
    encapsulation: ViewEncapsulation.Emulated,
    styleUrls: ['./edit-maintenance-rule.component.scss'],
    templateUrl: './edit-maintenance-rule.component.html'
})
export class EditMaintenanceRuleComponent {

    public maintenanceRule: MaintenanceRule;

    constructor(
        @Inject(MD_DIALOG_DATA)
        private _maintenanceRule: MaintenanceRule,
        private _dialogRef: MdDialogRef<EditMaintenanceRuleComponent>,
        private _maintenanceRuleService: MaintenanceRuleService
    ) {
        this.maintenanceRule = _maintenanceRule;
    }

    public update(): void {
        this._maintenanceRuleService.maintenanceRuleList.subscribe(() => {
            this._dialogRef.close();
        });
        this._maintenanceRuleService.update(this.maintenanceRule);
    }

}
