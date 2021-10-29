import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AuthGuard } from './data/services/auth.guard';

const routes: Routes = [
  {
    path: '',
    loadChildren: () => import(
      './guest/guest.module'
    ).then(mod => mod.GuestModule)
  },
  {
    path: 'seller',
    loadChildren: () => import(
      './seller/seller.module'
    ).then(mod => mod.SellerModule)
  },
  {
    path: 'customer',
    loadChildren: () => import(
      './customer/customer.module'
    ).then(mod => mod.CustomerModule),
    canLoad: [AuthGuard],
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
