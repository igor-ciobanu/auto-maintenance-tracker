import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs/BehaviorSubject';
import { Http, Headers } from '@angular/http';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/map'

export interface CarModel {
    id: number;
    name: string;
    mark_id?: number;
    _embedded?: any;
}

@Injectable()
export class CarModelService {

    public carModelList: Observable<CarModel[]>;

    private _carModelList: BehaviorSubject<CarModel[]>;

    private _dataStore: {
        carModelList: CarModel[]
    };

    constructor(
        private _http: Http
    ) {
        this._dataStore = {
            carModelList: []
        };
        this._carModelList = <BehaviorSubject<CarModel[]>>new BehaviorSubject([]);
        this.carModelList = this._carModelList.asObservable();
    }

    public getList(): void {
        this._http.get(`/api/model`)
            .map(response => response.json()._embedded.models)
            .subscribe((data: any) => {
                this._dataStore.carModelList = data;
                this._carModelList.next(Object.assign({}, this._dataStore).carModelList);
            }, error => console.log('Could not load model.'));
    }

    public get(id: number | string): void {
        this._http.get(`/api/model/${id}`)
            .map(response => response.json())
            .subscribe(data => {
                let notFound = true;
                this._dataStore.carModelList.forEach((item, index) => {
                    if (item.id === data.id) {
                        this._dataStore.carModelList[index] = data;
                        notFound = false;
                    }
                });
                notFound && this._dataStore.carModelList.push(data);
                this._carModelList.next(Object.assign({}, this._dataStore).carModelList);
            }, error => console.log('Could not load model.'));
    }

    public create(model: CarModel): void {
        let headers = new Headers();
        headers.append('Content-Type', 'application/json');
        this._http.post(`/api/model`, JSON.stringify(model), {headers})
            .map((response: any) => response.json())
            .subscribe((data: any) => {
                this._dataStore.carModelList.push(data);
                this._carModelList.next(Object.assign({}, this._dataStore).carModelList);
            }, (error: any) => console.log('Could not create model.'));
    }

    public update(model: CarModel): void {
        let headers = new Headers();
        headers.append('Content-Type', 'application/json');
        model.mark_id = model._embedded.mark.id;
        this._http.put(`/api/model/${model.id}`, JSON.stringify(model), {headers})
            .map((response: any) => response.json())
            .subscribe((data: any) => {
                this._dataStore.carModelList.forEach((item, index) => {
                    if (item.id === data.id) {
                        this._dataStore.carModelList[index] = data;
                    }
                });
                this._carModelList.next(Object.assign({}, this._dataStore).carModelList);
            }, (error: any) => console.log('Could not update model.'));
    }

    public remove(id: number): void {
        this._http.delete(`/api/model/${id}`)
            .subscribe(() => {
                this._dataStore.carModelList.forEach((item, index) => {
                    if (item.id === id) {
                        this._dataStore.carModelList.splice(index, 1);
                    }
                });
                this._carModelList.next(Object.assign({}, this._dataStore).carModelList);
            }, (error: any) => console.log('Could not delete model.'));
    }
}