import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { AdditionalInfoComponent } from './components/additional-info/additional-info.component';
import { BusinessInfoComponent } from './components/business-info/business-info.component';
import { NavBarComponent } from './shared/nav-bar/nav-bar.component';
import { SharedModule } from 'src/app/shared/shared.module';


@NgModule({
  declarations: [
    BusinessInfoComponent,
    AdditionalInfoComponent,
    NavBarComponent
  ],
  imports: [
    CommonModule,
    SharedModule
  ]
})
export class RegisterModule { }
