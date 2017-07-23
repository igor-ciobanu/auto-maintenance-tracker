import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs/BehaviorSubject';
import { Http, Headers } from '@angular/http';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/map'

export interface Car {
    id: number;
    vin: string;
    year: number;
    km: number;
    car_type_id?: number,
    model_id?: number,
    maintenances?: any[],
    _embedded?: any;
}

@Injectable()
export class HomeService {

    public carList: Observable<Car[]>;

    private _carList: BehaviorSubject<Car[]>;

    private _dataStore: {
        carList: Car[]
    };

    constructor(
        private _http: Http
    ) {
        this._dataStore = {
            carList: []
        };
        this._carList = <BehaviorSubject<Car[]>>new BehaviorSubject([]);
        this.carList = this._carList.asObservable();
    }

    public getList(): void {
        this._http.get(`/api/car`)
            .map((response: any) => response.json()._embedded.cars)
            .subscribe((data: any) => {
                this._dataStore.carList = data;
                this._carList.next(Object.assign({}, this._dataStore).carList);
            }, error => console.log('Could not load car.'));
    }

    public get(id: number | string): void {
        this._http.get(`/api/car/${id}`)
            .map((response: any) => response.json())
            .subscribe(data => {
                let notFound = true;
                this._dataStore.carList.forEach((item, index) => {
                    if (item.id === data.id) {
                        this._dataStore.carList[index] = data;
                        notFound = false;
                    }
                });
                notFound && this._dataStore.carList.push(data);
                this._carList.next(Object.assign({}, this._dataStore).carList);
            }, error => console.log('Could not load car.'));
    }

    public create(car: Car): void {
        let headers = new Headers();
        headers.append('Content-Type', 'application/json');
        this._http.post(`/api/car`, JSON.stringify(car), {headers})
            .map((response: any) => response.json())
            .subscribe((data: any) => {
                this._dataStore.carList.push(data);
                this._carList.next(Object.assign({}, this._dataStore).carList);
            }, (error: any) => console.log('Could not create car.'));
    }

    public update(car: Car): void {
        let headers = new Headers();
        headers.append('Content-Type', 'application/json');
        car.car_type_id = car._embedded.carType.id;
        car.model_id = car._embedded.model.id;
        this._http.put(`/api/car/${car.id}`, JSON.stringify(car), {headers})
            .map((response: any) => response.json())
            .subscribe((data: any) => {
                this._dataStore.carList.forEach((item, index) => {
                    if (item.id === data.id) {
                        this._dataStore.carList[index] = data;
                    }
                });
                this._carList.next(Object.assign({}, this._dataStore).carList);
            }, (error: any) => console.log('Could not update car.'));
    }

    public remove(id: number): void {
        this._http.delete(`/api/car/${id}`)
            .subscribe(() => {
                this._dataStore.carList.forEach((item, index) => {
                    if (item.id === id) {
                        this._dataStore.carList.splice(index, 1);
                    }
                });
                this._carList.next(Object.assign({}, this._dataStore).carList);
            }, (error: any) => console.log('Could not delete car.'));
    }
}