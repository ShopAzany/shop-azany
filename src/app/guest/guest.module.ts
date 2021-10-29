import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { GuestRoutingModule } from './guest-routing.module';
import { HomeComponent } from './pages/home/home.component';
import { ProductDetailsComponent } from './pages/product-details/product-details.component';
import { SharedModule } from '../shared/shared.module';
import { ShoppingCartComponent } from './pages/shopping-cart/shopping-cart.component';
import { LoginComponent } from './pages/login/login.component';
import { RegisterComponent } from './pages/register/register.component';
import { ProductsComponent } from './pages/products/products.component';
import { StaticModule } from './pages/static/static.module';
import { FbLoginComponent } from './shared/fb-login/fb-login.component';
import { GoogleLoginComponent } from './shared/google-login/google-login.component';
import { ForgotPasswordComponent } from './pages/forgot-password/forgot-password.component';


@NgModule({
  declarations: [
    HomeComponent,
    ProductDetailsComponent,
    ShoppingCartComponent,
    LoginComponent,
    RegisterComponent,
    ProductsComponent,
    FbLoginComponent,
    GoogleLoginComponent,
    ForgotPasswordComponent
  ],
  imports: [
    CommonModule,
    GuestRoutingModule,
    SharedModule,
    StaticModule
  ]
})
export class GuestModule { }
