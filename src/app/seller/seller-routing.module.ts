import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { SellerAuthGuard } from '../data/services/seller/seller-auth.guard';
import { ForgotPasswordComponent } from './pages/forgot-password/forgot-password.component';
import { HomeComponent } from './pages/home/home.component';
import { LoginComponent } from './pages/login/login.component';
import { AdditionalInfoComponent } from './pages/register/components/additional-info/additional-info.component';
import { BusinessInfoComponent } from './pages/register/components/business-info/business-info.component';
import { CreateAccountComponent } from './pages/register/components/create-account/create-account.component';

const routes: Routes = [
  { path: '', component: HomeComponent },
  { path: 'login', component: LoginComponent },
  { path: 'forgot-password', component: ForgotPasswordComponent },
  { path: 'register', component: CreateAccountComponent },
  { path: 'register/business-info', component: BusinessInfoComponent },
  { path: 'register/additional-info', component: AdditionalInfoComponent },
  {
    path: 'auth', loadChildren: () => import(
      './pages/auth/auth.module'
    ).then(mod => mod.AuthModule),
    canLoad: [SellerAuthGuard]
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class SellerRoutingModule { }
