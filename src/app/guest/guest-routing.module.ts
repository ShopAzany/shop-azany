import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ForgotPasswordComponent } from './pages/forgot-password/forgot-password.component';
import { HomeComponent } from './pages/home/home.component';
import { LoginComponent } from './pages/login/login.component';
import { ProductDetailsComponent } from './pages/product-details/product-details.component';
import { ProductsComponent } from './pages/products/products.component';
import { RegisterComponent } from './pages/register/register.component';
import { ShoppingCartComponent } from './pages/shopping-cart/shopping-cart.component';
import { DynamicStaticComponent } from './pages/static/dynamic-static/dynamic-static.component';
import { AboutUsComponent } from './pages/static/pages/about-us/about-us.component';
import { CustomerServiceComponent } from './pages/static/pages/customer-service/customer-service.component';
import { FaqComponent } from './pages/static/pages/faq/faq.component';

const routes: Routes = [
  { path: '', component: HomeComponent },
  { path: 'product/:pid/:name', component: ProductDetailsComponent },
  { path: 'login', component: LoginComponent },
  { path: 'forgot-password', component: ForgotPasswordComponent },
  { path: 'register', component: RegisterComponent },
  { path: 'shopping-cart', component: ShoppingCartComponent },
  { path: 'deals', component: ProductsComponent },
  { path: 'recommended', component: ProductsComponent },
  { path: 'top-selling', component: ProductsComponent },
  { path: 'recent', component: ProductsComponent },
  { path: 'recently-viewed', component: ProductsComponent },
  { path: 'categories', component: ProductsComponent },
  { path: 'search/:keyword', component: ProductsComponent },
  { path: 'category/:category', component: ProductsComponent },
  { path: 'category/:category/:subcategory', component: ProductsComponent },
  { path: 'category/:category/:subcategory/:subsubcategory', component: ProductsComponent },

  //static routing
  { path: 'customer-service', component: CustomerServiceComponent },
  { path: 'about', component: AboutUsComponent },
  { path: 'pages/:url', component: DynamicStaticComponent },
  { path: 'faq', component: FaqComponent },

];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class GuestRoutingModule { }
