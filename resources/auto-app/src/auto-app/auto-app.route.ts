import { Routes } from '@angular/router';

import { HomeComponent } from './home';
import { AdminComponent } from './admin';
import { NotFoundComponent } from './not-found';

export const APP_ROUTES: Routes = [
    {
        path: '',
        redirectTo: '/home',
        pathMatch: 'full'
    },
    {
        path: 'home',
        component: HomeComponent
    },
    {
        path: 'admin',
        component: AdminComponent
    },
    {
        path: '**',
        component: NotFoundComponent
    }
];
