import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HeaderComponent } from './components/header/header.component';
import { FooterComponent } from './components/footer/footer.component';
import { EachProductComponent } from './components/each-product/each-product.component';
import { SubscribeComponent } from './components/subscribe/subscribe.component';
import { EachAdvertProductComponent } from './components/each-advert-product/each-advert-product.component';
import { FeaturesComponent } from './components/features/features.component';
import { BreadcrumbComponent } from './components/breadcrumb/breadcrumb.component';
import { RouterModule } from '@angular/router';
import { SafeHtmlPipe } from './pipe/safe-html.pipe';
import { DropdownDirective } from './directives/dropdown.directive';
import { RelatedItemsComponent } from './components/related-items/related-items.component';
import { PassToggleDirective } from './directives/pass-toggle.directive';
import { BannerCarouselComponent } from './components/banner-carousel/banner-carousel.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { AllowNumDirective } from './directives/allow-num.directive';
import { AuthEachProductComponent } from './components/auth-each-product/auth-each-product.component';
import { PieChartComponent } from './components/pie-chart/pie-chart.component';
import { BarChartComponent } from './components/bar-chart/bar-chart.component';
import { ModalModule } from './modules/modal/modal.module';
import { SideNavToggleDirective } from './directives/side-nav-toggle.directive';
import { GraphComponent } from './components/graph/graph.component';
import { FlexSliderComponent } from './components/flex-slider/flex-slider.component';
import { CusAccordionComponent } from './components/cus-accordion/cus-accordion.component';
import { FilterSidebarComponent } from './components/filter-sidebar/filter-sidebar.component';
import { ProductListHeadingComponent } from './components/product-list-heading/product-list-heading.component';
import { BarChartLoadingComponent } from './components/bar-chart-loading/bar-chart-loading.component';
import { LoadingComponent } from './components/loading/loading.component';
import { SafeUrlPipe } from './pipe/safe-url.pipe';
import { AddCartSuccessComponent } from './components/add-cart-success/add-cart-success.component';
import { EmptyPageComponent } from './components/empty-page/empty-page.component';
import { ProductLoaderComponent } from './components/product-loader/product-loader.component';
import { HomePageLoadPlaceholderComponent } from './components/home-page-load-placeholder/home-page-load-placeholder.component';
import { LockValueDirective } from './directives/lock-value.directive';

@NgModule({
  declarations: [
    HeaderComponent,
    FooterComponent,
    EachProductComponent,
    SubscribeComponent,
    EachAdvertProductComponent,
    FeaturesComponent,
    BreadcrumbComponent,
    SafeHtmlPipe,
    DropdownDirective,
    RelatedItemsComponent,
    PassToggleDirective,
    BannerCarouselComponent,
    AllowNumDirective,
    AuthEachProductComponent,
    PieChartComponent,
    BarChartComponent,
    SideNavToggleDirective,
    GraphComponent,
    FlexSliderComponent,
    CusAccordionComponent,
    FilterSidebarComponent,
    ProductListHeadingComponent,
    BarChartLoadingComponent,
    LoadingComponent,
    SafeUrlPipe,
    AddCartSuccessComponent,
    EmptyPageComponent,
    ProductLoaderComponent,
    HomePageLoadPlaceholderComponent,
    LockValueDirective
  ],
  imports: [
    CommonModule,
    RouterModule,
    ReactiveFormsModule,
    FormsModule,
    ModalModule
  ],
  exports: [
    SafeHtmlPipe,
    ReactiveFormsModule,
    RouterModule,
    FormsModule,
    ModalModule,
    HeaderComponent,
    FooterComponent,
    EachProductComponent,
    SubscribeComponent,
    EachAdvertProductComponent,
    FeaturesComponent,
    BreadcrumbComponent,
    RelatedItemsComponent,
    PassToggleDirective,
    BannerCarouselComponent,
    AllowNumDirective,
    AuthEachProductComponent,
    PieChartComponent,
    BarChartComponent,
    DropdownDirective,
    SideNavToggleDirective,
    GraphComponent,
    FlexSliderComponent,
    CusAccordionComponent,
    FilterSidebarComponent,
    ProductListHeadingComponent,
    LoadingComponent,
    SafeUrlPipe,
    AddCartSuccessComponent,
    EmptyPageComponent,
    ProductLoaderComponent,
    HomePageLoadPlaceholderComponent,
    LockValueDirective
  ]
})
export class SharedModule { }
