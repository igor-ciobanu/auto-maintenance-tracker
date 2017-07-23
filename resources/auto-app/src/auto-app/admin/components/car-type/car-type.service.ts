import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs/BehaviorSubject';
import { Http, Headers } from '@angular/http';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/map'

export interface CarType {
    id: number;
    type: string;
    _embedded?: any;
}

@Injectable()
export class CarTypeService {

    public carTypeList: Observable<CarType[]>;

    private _carTypeList: BehaviorSubject<CarType[]>;

    private _dataStore: {
        carTypeList: CarType[]
    };

    constructor(
        private _http: Http
    ) {
        this._dataStore = {
            carTypeList: []
        };
        this._carTypeList = <BehaviorSubject<CarType[]>>new BehaviorSubject([]);
        this.carTypeList = this._carTypeList.asObservable();
    }

    public getList(): void {
        this._http.get(`/api/car-type`)
            .map(response => response.json()._embedded.carTypes)
            .subscribe((data: any) => {
                this._dataStore.carTypeList = data;
                this._carTypeList.next(Object.assign({}, this._dataStore).carTypeList);
            }, error => console.log('Could not load type.'));
    }

    public get(id: number | string): void {
        this._http.get(`/api/car-type/${id}`)
            .map(response => response.json())
            .subscribe(data => {
                let notFound = true;
                this._dataStore.carTypeList.forEach((item, index) => {
                    if (item.id === data.id) {
                        this._dataStore.carTypeList[index] = data;
                        notFound = false;
                    }
                });
                notFound && this._dataStore.carTypeList.push(data);
                this._carTypeList.next(Object.assign({}, this._dataStore).carTypeList);
            }, error => console.log('Could not load type.'));
    }

    public create(type: CarType): void {
        let headers = new Headers();
        headers.append('Content-Type', 'application/json');
        this._http.post(`/api/car-type`, JSON.stringify(type), {headers})
            .map((response: any) => response.json())
            .subscribe((data: any) => {
                this._dataStore.carTypeList.push(data);
                this._carTypeList.next(Object.assign({}, this._dataStore).carTypeList);
            }, (error: any) => console.log('Could not create type.'));
    }

    public update(type: CarType): void {
        let headers = new Headers();
        headers.append('Content-Type', 'application/json');
        this._http.put(`/api/car-type/${type.id}`, JSON.stringify(type), {headers})
            .map((response: any) => response.json())
            .subscribe((data: any) => {
                this._dataStore.carTypeList.forEach((item, index) => {
                    if (item.id === data.id) {
                        this._dataStore.carTypeList[index] = data;
                    }
                });
                this._carTypeList.next(Object.assign({}, this._dataStore).carTypeList);
            }, (error: any) => console.log('Could not update type.'));
    }

    public remove(id: number): void {
        this._http.delete(`/api/car-type/${id}`)
            .subscribe(() => {
                this._dataStore.carTypeList.forEach((item, index) => {
                    if (item.id === id) {
                        this._dataStore.carTypeList.splice(index, 1);
                    }
                });
                this._carTypeList.next(Object.assign({}, this._dataStore).carTypeList);
            }, (error: any) => console.log('Could not delete type.'));
    }
}