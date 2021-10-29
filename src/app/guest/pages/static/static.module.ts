import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

// import { StaticRoutingModule } from './static-routing.module';
import { CustomerServiceComponent } from './pages/customer-service/customer-service.component';
import { SharedModule } from 'src/app/shared/shared.module';
import { AboutUsComponent } from './pages/about-us/about-us.component';
import { FaqComponent } from './pages/faq/faq.component';
import { DynamicStaticComponent } from './dynamic-static/dynamic-static.component';


@NgModule({
  declarations: [
    CustomerServiceComponent,
    AboutUsComponent,
    FaqComponent,
    DynamicStaticComponent
  ],
  imports: [
    CommonModule,
    SharedModule
  ]
})
export class StaticModule { }
