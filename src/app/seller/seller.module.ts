import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { SellerRoutingModule } from './seller-routing.module';
import { HomeComponent } from './pages/home/home.component';
import { LoginComponent } from './pages/login/login.component';
import { SharedModule } from '../shared/shared.module';
import { SellerAuthGuard } from '../data/services/seller/seller-auth.guard';
import { RegisterModule } from './pages/auth/register/register.module';
import { ForgotPasswordComponent } from './pages/forgot-password/forgot-password.component';
import { RegisternComponent } from './pages/registern/registern.component';
import { VerificationComponent } from './pages/verification/verification.component';


@NgModule({
  declarations: [
    HomeComponent,
    LoginComponent,
    ForgotPasswordComponent,
    RegisternComponent,
    VerificationComponent,
  ],
  imports: [
    CommonModule,
    SellerRoutingModule,
    SharedModule,
    RegisterModule
  ],
  providers: [
    SellerAuthGuard
  ]
})
export class SellerModule { }
