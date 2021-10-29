import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { AuthRoutingModule } from './auth-routing.module';
import { DashboardComponent } from './dashboard/dashboard.component';
import { SharedModule } from 'src/app/shared/shared.module';
import { SellerSideNavComponent } from './shared/seller-side-nav/seller-side-nav.component';
import { ProductListingComponent } from './product-listing/product-listing.component';
import { EarningsComponent } from './earnings/earnings.component';
import { AddProductDetailsComponent } from './add-product-details/add-product-details.component';
import { AddProductSellingComponent } from './add-product-selling/add-product-selling.component';
import { AddProductShippingComponent } from './add-product-shipping/add-product-shipping.component';
import { AngularEditorModule } from '@kolkov/angular-editor';
import { ProductPreviewComponent } from './product-preview/product-preview.component';
import { ProductNavBarComponent } from './shared/product-nav-bar/product-nav-bar.component';


@NgModule({
  declarations: [
    DashboardComponent,
    SellerSideNavComponent,
    ProductListingComponent,
    EarningsComponent,
    AddProductDetailsComponent,
    AddProductSellingComponent,
    AddProductShippingComponent,
    ProductPreviewComponent,
    ProductNavBarComponent
  ],
  imports: [
    CommonModule,
    AuthRoutingModule,
    SharedModule,
    AngularEditorModule
  ]
})
export class AuthModule { }
