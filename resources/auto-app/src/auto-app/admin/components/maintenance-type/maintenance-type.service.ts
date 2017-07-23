
import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs/BehaviorSubject';
import { Http, Headers } from '@angular/http';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/map'

export interface MaintenanceType {
    id: number;
    name: string;
}

@Injectable()
export class MaintenanceTypeService {

    public maintenanceTypeList: Observable<MaintenanceType[]>;

    private _maintenanceTypeList: BehaviorSubject<MaintenanceType[]>;

    private _dataStore: {
        maintenanceTypeList: MaintenanceType[]
    };

    constructor(
        private _http: Http
    ) {
        this._dataStore = {
            maintenanceTypeList: []
        };
        this._maintenanceTypeList = <BehaviorSubject<MaintenanceType[]>>new BehaviorSubject([]);
        this.maintenanceTypeList = this._maintenanceTypeList.asObservable();
    }

    public getList(): void {
        this._http.get(`/api/maintenance-type`)
            .map(response => response.json()._embedded.maintenanceTypes)
            .subscribe((data: any) => {
                this._dataStore.maintenanceTypeList = data;
                this._maintenanceTypeList.next(Object.assign({}, this._dataStore).maintenanceTypeList);
            }, error => console.log('Could not load maintenance type.'));
    }

    public get(id: number | string): void {
        this._http.get(`/api/maintenance-type/${id}`)
            .map(response => response.json())
            .subscribe(data => {
                let notFound = true;
                this._dataStore.maintenanceTypeList.forEach((item, index) => {
                    if (item.id === data.id) {
                        this._dataStore.maintenanceTypeList[index] = data;
                        notFound = false;
                    }
                });
                notFound && this._dataStore.maintenanceTypeList.push(data);
                this._maintenanceTypeList.next(Object.assign({}, this._dataStore).maintenanceTypeList);
            }, error => console.log('Could not load maintenance type.'));
    }

    public create(maintenanceType: MaintenanceType): void {
        let headers = new Headers();
        headers.append('Content-Type', 'application/json');
        this._http.post(`/api/maintenance-type`, JSON.stringify(maintenanceType), {headers})
            .map((response: any) => response.json())
            .subscribe((data: any) => {
                this._dataStore.maintenanceTypeList.push(data);
                this._maintenanceTypeList.next(Object.assign({}, this._dataStore).maintenanceTypeList);
            }, (error: any) => console.log('Could not create maintenance type.'));
    }

    public update(maintenanceType: MaintenanceType): void {
        let headers = new Headers();
        headers.append('Content-Type', 'application/json');
        this._http.put(`/api/maintenance-type/${maintenanceType.id}`, JSON.stringify(maintenanceType), {headers})
            .map((response: any) => response.json())
            .subscribe((data: any) => {
                this._dataStore.maintenanceTypeList.forEach((item, index) => {
                    if (item.id === data.id) {
                        this._dataStore.maintenanceTypeList[index] = data;
                    }
                });
                this._maintenanceTypeList.next(Object.assign({}, this._dataStore).maintenanceTypeList);
            }, (error: any) => console.log('Could not update maintenance type.'));
    }

    public remove(id: number): void {
        this._http.delete(`/api/maintenance-type/${id}`)
            .subscribe(() => {
                this._dataStore.maintenanceTypeList.forEach((item, index) => {
                    if (item.id === id) {
                        this._dataStore.maintenanceTypeList.splice(index, 1);
                    }
                });
                this._maintenanceTypeList.next(Object.assign({}, this._dataStore).maintenanceTypeList);
            }, (error: any) => console.log('Could not delete maintenance type.'));
    }
}