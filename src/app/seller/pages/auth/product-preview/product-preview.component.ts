import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { RoutingService } from 'src/app/data/helpers/routing.service';
import { ConfigService } from 'src/app/data/services/config.service';
import { ProductManagerService } from 'src/app/data/services/seller/product-manager.service';

@Component({
  selector: 'app-product-preview',
  templateUrl: './product-preview.component.html',
  styleUrls: ['./product-preview.component.scss']
})
export class ProductPreviewComponent implements OnInit {

  isDescription = true;
  isShipping = false;
  product: any;
  categoryOne: any;
  categoryTwo: any;
  categoryThree: any;
  titleUrl: any;
  lastRoute: any;
  catList;
  activeImg = 0;

  gettingProd = true;

  slideResizeConfig = [
    { minW: 536, slideNo: 5 },
    { minW: 420, maxW: 536, slideNo: 4 },
    { minW: 320, maxW: 420, slideNo: 3 },
    { maxW: 320, slideNo: 2 }
  ];

  constructor(
    private routingService: RoutingService,
    private configService: ConfigService,
    private productManagerService: ProductManagerService,
    private route: ActivatedRoute,
  ) { }

  get cleanedUrl() {
    if (this.product && this.product.name) {
      return this.configService.clearnUrl(this.product.name);
    }
    return null;
  }

  get sellerUrl() {
    return this.configService.sellerURL;
  }

  ngOnInit(): void {
    const proID = this.route.snapshot.paramMap.get('pid');
    this.lastRoute = this.routingService.activeRoute;
    if (proID) {
      this.getProduct(proID);
    } else {
      this.routingService.replace([
        '/' + this.sellerUrl + '/product-manager'
      ]);
    }
    this.getProduct(proID);
  }

  cleanText(url) {
    return this.configService.clearnText(url);
  }

  numberFormat(num) {
    if (num) {
      return this.configService.numberFormat(num, 2).split('.');
    }
    return [0, '00'];
  }

  private getProduct(proID) {
    this.productManagerService.single(proID).subscribe(res => {
      if (res && res.pid) {
        res.images = typeof res.images == 'string' ? JSON.parse(res.images) : res.images;
        this.product = res;
        this.catList = this.product.category.split(',');
      }
      this.gettingProd = false;
    })
  }

  clickShipping() {
    this.isDescription = false;
    this.isShipping = true;
  }
  clickDescription() {
    this.isDescription = true;
    this.isShipping = false;
  }

  goto() {
    this.titleUrl = this.configService.clearnUrl(this.product.name);
    this.routingService.replace([
      this.sellerUrl + '/auth/product-manager/' + this.product.pid + '/preview/' + this.titleUrl
    ], false);
  }

}
