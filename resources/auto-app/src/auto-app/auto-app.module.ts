import { NgModule } from '@angular/core';

import { BrowserModule } from '@angular/platform-browser';

import { HttpModule } from '@angular/http';

import { BrowserAnimationsModule } from '@angular/platform-browser/animations';

import { RouterModule } from '@angular/router';

import { FormsModule } from '@angular/forms';

import {
    MdButtonModule,
    MdListModule,
    MdCheckboxModule,
    MdTableModule,
    MdRadioModule,
    MdTabsModule,
    MdDialogModule,
    MdInputModule,
    MdSelectModule
} from '@angular/material';

import { CdkTableModule } from '@angular/cdk';

import { APP_ROUTES } from './auto-app.route';

import { AutoAppComponent } from './auto-app.component';

import { NotFoundComponent } from './not-found';

import { AdminComponent } from './admin';

import {
    HomeComponent,
    HomeService,
    MaintainService,
    EditCarComponent,
    CreateCarComponent,
    MaintainCarComponent
} from './home';

import {
    CarMarkComponent,
    CarMarkService,
    EditCarMarkComponent,
    CreateCarMarkComponent
} from './admin/components/car-mark';

import {
    CarModelComponent,
    CarModelService,
    EditCarModelComponent,
    CreateCarModelComponent
} from './admin/components/car-model';

import {
    CarTypeComponent,
    CarTypeService,
    EditCarTypeComponent,
    CreateCarTypeComponent
} from './admin/components/car-type';

import {
    MaintenanceRuleComponent,
    MaintenanceRuleService,
    EditMaintenanceRuleComponent,
    CreateMaintenanceRuleComponent
} from './admin/components/maintenance-rule';

import {
    MaintenanceTypeComponent,
    MaintenanceTypeService,
    EditMaintenanceTypeComponent,
    CreateMaintenanceTypeComponent
} from './admin/components/maintenance-type';

const MATERIAL_MODULES = [
    MdButtonModule,
    MdListModule,
    MdTableModule,
    CdkTableModule,
    MdRadioModule,
    MdTabsModule,
    MdCheckboxModule,
    MdDialogModule,
    MdInputModule,
    MdSelectModule
];

@NgModule({
    bootstrap: [
        AutoAppComponent
    ],
    imports: [
        BrowserAnimationsModule,
        BrowserModule,
        RouterModule.forRoot(APP_ROUTES),
        HttpModule,
        FormsModule,
        ...MATERIAL_MODULES
    ],
    entryComponents: [
        CreateCarMarkComponent,
        EditCarMarkComponent,
        CreateCarModelComponent,
        EditCarModelComponent,
        CreateCarTypeComponent,
        EditCarTypeComponent,
        EditMaintenanceTypeComponent,
        CreateMaintenanceTypeComponent,
        EditMaintenanceRuleComponent,
        CreateMaintenanceRuleComponent,
        EditCarComponent,
        CreateCarComponent,
        MaintainCarComponent
    ],
    declarations: [
        AutoAppComponent,
        NotFoundComponent,
        HomeComponent,
        AdminComponent,
        CarMarkComponent,
        CreateCarMarkComponent,
        EditCarMarkComponent,
        CarModelComponent,
        CreateCarModelComponent,
        EditCarModelComponent,
        CarTypeComponent,
        CreateCarTypeComponent,
        EditCarTypeComponent,
        MaintenanceTypeComponent,
        EditMaintenanceTypeComponent,
        CreateMaintenanceTypeComponent,
        MaintenanceRuleComponent,
        EditMaintenanceRuleComponent,
        CreateMaintenanceRuleComponent,
        EditCarComponent,
        CreateCarComponent,
        MaintainCarComponent
    ],
    providers: [
        MaintainService,
        HomeService,
        MaintainService,
        CarMarkService,
        CarModelService,
        CarTypeService,
        MaintenanceTypeService,
        MaintenanceRuleService,
    ]
})
export class AutoAppModule {}
