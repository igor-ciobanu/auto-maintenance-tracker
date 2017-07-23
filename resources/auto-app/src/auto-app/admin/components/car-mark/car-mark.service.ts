import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs/BehaviorSubject';
import { Http, Headers } from '@angular/http';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/map'

export interface CarMark {
    id: number;
    name: string;
}

@Injectable()
export class CarMarkService {

    public carMarkList: Observable<CarMark[]>;

    private _carMarkList: BehaviorSubject<CarMark[]>;

    private _dataStore: {
        carMarkList: CarMark[]
    };

    constructor(
        private _http: Http
    ) {
        this._dataStore = {
            carMarkList: []
        };
        this._carMarkList = <BehaviorSubject<CarMark[]>>new BehaviorSubject([]);
        this.carMarkList = this._carMarkList.asObservable();
    }

    public getList(): void {
        this._http.get(`/api/mark`)
            .map(response => response.json()._embedded.marks)
            .subscribe((data: any) => {
                this._dataStore.carMarkList = data;
                this._carMarkList.next(Object.assign({}, this._dataStore).carMarkList);
            }, error => console.log('Could not load mark.'));
    }

    public get(id: number | string): void {
        this._http.get(`/api/mark/${id}`)
            .map(response => response.json())
            .subscribe(data => {
                let notFound = true;
                this._dataStore.carMarkList.forEach((item, index) => {
                    if (item.id === data.id) {
                        this._dataStore.carMarkList[index] = data;
                        notFound = false;
                    }
                });
                notFound && this._dataStore.carMarkList.push(data);
                this._carMarkList.next(Object.assign({}, this._dataStore).carMarkList);
            }, error => console.log('Could not load mark.'));
    }

    public create(mark: CarMark): void {
        let headers = new Headers();
        headers.append('Content-Type', 'application/json');
        this._http.post(`/api/mark`, JSON.stringify(mark), {headers})
            .map((response: any) => response.json())
            .subscribe((data: any) => {
                this._dataStore.carMarkList.push(data);
                this._carMarkList.next(Object.assign({}, this._dataStore).carMarkList);
            }, (error: any) => console.log('Could not create mark.'));
    }

    public update(mark: CarMark): void {
        let headers = new Headers();
        headers.append('Content-Type', 'application/json');
        this._http.put(`/api/mark/${mark.id}`, JSON.stringify(mark), {headers})
            .map((response: any) => response.json())
            .subscribe((data: any) => {
                this._dataStore.carMarkList.forEach((item, index) => {
                    if (item.id === data.id) {
                        this._dataStore.carMarkList[index] = data;
                    }
                });
                this._carMarkList.next(Object.assign({}, this._dataStore).carMarkList);
            }, (error: any) => console.log('Could not update mark.'));
    }

    public remove(id: number): void {
        this._http.delete(`/api/mark/${id}`)
            .subscribe(() => {
                this._dataStore.carMarkList.forEach((item, index) => {
                    if (item.id === id) {
                        this._dataStore.carMarkList.splice(index, 1);
                    }
                });
                this._carMarkList.next(Object.assign({}, this._dataStore).carMarkList);
            }, (error: any) => console.log('Could not delete mark.'));
    }
}