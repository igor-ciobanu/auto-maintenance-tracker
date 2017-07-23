import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs/BehaviorSubject';
import { Http, Headers } from '@angular/http';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/map'

export interface MaintenanceRule {
    id: number;
    km: number;
    car_type_id?: number;
    maintenance_type_id?: number;
    _embedded?: any;
}

@Injectable()
export class MaintenanceRuleService {

    public maintenanceRuleList: Observable<MaintenanceRule[]>;

    private _maintenanceRuleList: BehaviorSubject<MaintenanceRule[]>;

    private _dataStore: {
        maintenanceRuleList: MaintenanceRule[]
    };

    constructor(
        private _http: Http
    ) {
        this._dataStore = {
            maintenanceRuleList: []
        };
        this._maintenanceRuleList = <BehaviorSubject<MaintenanceRule[]>>new BehaviorSubject([]);
        this.maintenanceRuleList = this._maintenanceRuleList.asObservable();
    }

    public getList(): void {
        this._http.get(`/api/maintenance-rule`)
            .map(response => response.json()._embedded.maintenanceRules)
            .subscribe((data: any) => {
                this._dataStore.maintenanceRuleList = data;
                this._maintenanceRuleList.next(Object.assign({}, this._dataStore).maintenanceRuleList);
            }, error => console.log('Could not load maintenance rule.'));
    }

    public get(id: number | string): void {
        this._http.get(`/api/maintenance-rule/${id}`)
            .map(response => response.json())
            .subscribe(data => {
                let notFound = true;
                this._dataStore.maintenanceRuleList.forEach((item, index) => {
                    if (item.id === data.id) {
                        this._dataStore.maintenanceRuleList[index] = data;
                        notFound = false;
                    }
                });
                notFound && this._dataStore.maintenanceRuleList.push(data);
                this._maintenanceRuleList.next(Object.assign({}, this._dataStore).maintenanceRuleList);
            }, error => console.log('Could not load maintenance rule.'));
    }

    public create(maintenanceRule: MaintenanceRule): void {
        let headers = new Headers();
        headers.append('Content-Type', 'application/json');
        this._http.post(`/api/maintenance-rule`, JSON.stringify(maintenanceRule), {headers})
            .map((response: any) => response.json())
            .subscribe((data: any) => {
                this._dataStore.maintenanceRuleList.push(data);
                this._maintenanceRuleList.next(Object.assign({}, this._dataStore).maintenanceRuleList);
            }, (error: any) => console.log('Could not create maintenance rule.'));
    }

    public update(maintenanceRule: MaintenanceRule): void {
        let headers = new Headers();
        headers.append('Content-Type', 'application/json');
        maintenanceRule.car_type_id = maintenanceRule._embedded.carType.id;
        maintenanceRule.maintenance_type_id = maintenanceRule._embedded.maintenanceType.id;
        this._http.put(`/api/maintenance-rule/${maintenanceRule.id}`, JSON.stringify(maintenanceRule), {headers})
            .map((response: any) => response.json())
            .subscribe((data: any) => {
                this._dataStore.maintenanceRuleList.forEach((item, index) => {
                    if (item.id === data.id) {
                        this._dataStore.maintenanceRuleList[index] = data;
                    }
                });
                this._maintenanceRuleList.next(Object.assign({}, this._dataStore).maintenanceRuleList);
            }, (error: any) => console.log('Could not update maintenance rule.'));
    }

    public remove(id: number): void {
        this._http.delete(`/api/maintenance-rule/${id}`)
            .subscribe(() => {
                this._dataStore.maintenanceRuleList.forEach((item, index) => {
                    if (item.id === id) {
                        this._dataStore.maintenanceRuleList.splice(index, 1);
                    }
                });
                this._maintenanceRuleList.next(Object.assign({}, this._dataStore).maintenanceRuleList);
            }, (error: any) => console.log('Could not delete maintenance rule.'));
    }
}