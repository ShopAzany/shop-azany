import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AddProductDetailsComponent } from './add-product-details/add-product-details.component';
import { AddProductSellingComponent } from './add-product-selling/add-product-selling.component';
import { AddProductShippingComponent } from './add-product-shipping/add-product-shipping.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { EarningsComponent } from './earnings/earnings.component';
import { ProductListingComponent } from './product-listing/product-listing.component';
import { ProductPreviewComponent } from './product-preview/product-preview.component';

const routes: Routes = [
  { path: '', component: DashboardComponent },
  { path: 'product-manager', component: ProductListingComponent },
  { path: 'product-manager/add', component: AddProductDetailsComponent },
  { path: 'product-manager/:pid/:name/selling', component: AddProductSellingComponent },
  { path: 'product-manager/:pid/:name/shipping', component: AddProductShippingComponent },
  { path: 'product-manager/:pid/preview/:name', component: ProductPreviewComponent },
  { path: 'product-manager/:pid/preview/:name/success', component: ProductPreviewComponent },

  // EDITING
  { path: 'product-manager/:pid/details/:name/edit', component: AddProductDetailsComponent },
  { path: 'product-manager/:pid/selling/:name/edit', component: AddProductSellingComponent },
  { path: 'product-manager/:pid/shipping/:name/edit', component: AddProductShippingComponent },
  { path: 'earnings', component: EarningsComponent },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class AuthRoutingModule { }
