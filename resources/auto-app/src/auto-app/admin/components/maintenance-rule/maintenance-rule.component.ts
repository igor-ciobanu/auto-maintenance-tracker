import { Component, OnInit, ViewEncapsulation } from '@angular/core';
import { Observable } from 'rxjs/Observable';
import { DataSource } from '@angular/cdk';
import { MaintenanceRule, MaintenanceRuleService } from './maintenance-rule.service';
import { MdDialog, MdDialogConfig } from '@angular/material';
import { CreateMaintenanceRuleComponent } from './components/create-maintenance-rule/create-maintenance-rule.component';
import { EditMaintenanceRuleComponent } from './components/edit-maintenance-rule/edit-maintenance-rule.component';

class MaintenanceRuleDataSource extends DataSource<any> {

    constructor(private _maintenanceRuleService: MaintenanceRuleService) {
        super();
    }

    connect(): Observable<MaintenanceRule[]> {
        return this._maintenanceRuleService.maintenanceRuleList;
    }

    disconnect() {}
}


@Component({
    selector: 'maintenance-rule',
    encapsulation: ViewEncapsulation.Emulated,
    styleUrls: ['./maintenance-rule.component.scss'],
    templateUrl: './maintenance-rule.component.html'
})
export class MaintenanceRuleComponent implements OnInit {

    public maintenanceRuleList: MaintenanceRuleDataSource | null;

    public displayedColumns: string[] = ['carType', 'maintenanceType', 'name', 'action'];

    constructor(
        private _maintenanceRuleService: MaintenanceRuleService,
        private _dialog: MdDialog
    ) {
        this.maintenanceRuleList = new MaintenanceRuleDataSource(_maintenanceRuleService);
    }

    public ngOnInit(): void {
        this._maintenanceRuleService.getList();
    }

    public createMaintenanceRule(): void {
        let dialogRef = this._dialog.open(CreateMaintenanceRuleComponent);
        dialogRef.afterClosed().subscribe(() => {});
    }

    public editMaintenanceRule(maintenanceRule: MaintenanceRule): void {
        let dialogRef = this._dialog.open(EditMaintenanceRuleComponent, <MdDialogConfig>{
            data: maintenanceRule
        });
        dialogRef.afterClosed().subscribe(() => {});
    }

    public removeMaintenanceRule(maintenanceRule: MaintenanceRule): void {
        this._maintenanceRuleService.remove(maintenanceRule.id);
    }

}
