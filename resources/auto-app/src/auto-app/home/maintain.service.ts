import { Injectable } from '@angular/core';
import { Http, Headers } from '@angular/http';
import 'rxjs/add/operator/map'

export interface CarMaintain {
    maintenance_rule_id: number;
    car_id: number;
    km: number;
}

@Injectable()
export class MaintainService {

    constructor(
        private _http: Http
    ) {
    }

    public maintain(maintain: CarMaintain): void {
        let headers = new Headers();
        headers.append('Content-Type', 'application/json');
        this._http.post(`/api/maintenance-history`, JSON.stringify(maintain), {headers})
            .map((response: any) => response.json())
            .subscribe((data: any) => {
                console.log(data);
            }, (error: any) => console.log('Could do any works to car.'));
    }
}