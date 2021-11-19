import { ProfileComponent } from './profile/profile.component';
import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AddProductDetailsComponent } from './add-product-details/add-product-details.component';
import { AddProductSellingComponent } from './add-product-selling/add-product-selling.component';
import { AddProductShippingComponent } from './add-product-shipping/add-product-shipping.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { EarningsComponent } from './earnings/earnings.component';
import { ProductListingComponent } from './product-listing/product-listing.component';
import { ProductPreviewComponent } from './product-preview/product-preview.component';
import { StoreManagerComponent } from './store-manager/store-manager.component';
import { AdditionalInfoComponent } from '../auth/register/components/additional-info/additional-info.component';
import { BusinessInfoComponent } from '../auth/register/components/business-info/business-info.component';

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
  { path: 'profile', component: ProfileComponent },
  { path: 'manager', component: StoreManagerComponent },

  //COMPLETE REG
  { path: 'register/business-info', component: BusinessInfoComponent },
  { path: 'register/additional-info', component: AdditionalInfoComponent },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class AuthRoutingModule { }
