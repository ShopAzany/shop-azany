import { Inject, Injectable, PLATFORM_ID } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { ConfigService } from '../config.service';
import { delay, tap } from 'rxjs/operators';
import { AuthService } from '../auth.service';
import { StorageService } from '../../helpers/storage.service';
import { isPlatformBrowser } from '@angular/common';
import { ProductService } from '../guest/products.service';

@Injectable({ providedIn: 'root' })
export class FavoriteService {
  private serverUrl: string;
  private token: string;

  favInfo = { emitter: '', pid: -1, fav: false };

  constructor(
    @Inject(PLATFORM_ID) private platformId: Object,
    private http: HttpClient,
    private config: ConfigService,
    private authService: AuthService,
    private storageService: StorageService,

  ) {
    this.serverUrl = this.config.base_url();
    this.authService.customer.subscribe(auth => {
      if (auth) { this.token = auth.token; }
    });
  }

  favourites(limit = 10, page = 0) {
    return this.http.get<any>(
      this.serverUrl + 'user/favorites/favourites/'
      + this.token + '/' + limit + '/' + page
    );
  }



  is_favorite(pid, type) {
    return this.http.get<any>(
      this.serverUrl + 'user/favorites/is_favorite/'
      + this.token + '/' + pid + '/' + type
    );
  }

  updateStoredProdFav(prod, fav) {
    if (isPlatformBrowser(this.platformId)) {
      if (this.storageService.hasKey('prodPageProducts')) {
        let initialStored = JSON.parse(this.storageService.getString('prodPageProducts'));
        let filteredProd = initialStored.data.data.filter((x) => x.pid == prod.pid);
        if (filteredProd.length > 0) {
          let j = initialStored.data.data.indexOf(filteredProd[0]);
          let product = initialStored.data.data[j];
          if (fav) {
            product.isFavorite = product.pid;
          } else {
            product.isFavorite = null;
          }
          initialStored.data.data[j] = product;
          let updatedData = JSON.stringify(initialStored);
          this.storageService.storeString('prodPageProducts', updatedData);
        }
      }
      if (this.storageService.hasKey('authHomeProdFlancer')) {
        let authHomeInitProd = JSON.parse(this.storageService.getString('authHomeProdFlancer'));
        let filteredAuthPopular = authHomeInitProd.data.popularProducts.filter(x => x.pid == prod.pid);
        if (filteredAuthPopular.length > 0) {
          let j = authHomeInitProd.data.popularProducts.indexOf(filteredAuthPopular[0]);
          let product = authHomeInitProd.data.popularProducts[j];
          if (fav) {
            product.isFavorite = product.pid;
          } else {
            product.isFavorite = null;
          }
          authHomeInitProd.data.popularProducts[j] = product;
          let updatedData = JSON.stringify(authHomeInitProd);
          this.storageService.storeString('authHomeProdFlancer', updatedData);
        }
        let filteredAuthViewed = authHomeInitProd.data.viewedProducts.filter(x => x.pid == prod.pid);
        if (filteredAuthViewed.length > 0) {
          let j = authHomeInitProd.data.viewedProducts.indexOf(filteredAuthViewed[0]);
          let product = authHomeInitProd.data.viewedProducts[j];
          if (fav) {
            product.isFavorite = product.pid;
          } else {
            product.isFavorite = null;
          }
          authHomeInitProd.data.viewedProducts[j] = product;
          let updatedData = JSON.stringify(authHomeInitProd);
          this.storageService.storeString('authHomeProdFlancer', updatedData);
        }
      }
    }
  }

  getFreelancerOnFav(limit = 6, page = 1) {
    return this.http.get<any>(
      this.serverUrl + 'user/favorites/freelancer' + '/' + this.token + '/' + limit + '/' + page
    );
  }

  getFavJobs(limit = 6, page = 1) {
    return this.http.get<any>(
      this.serverUrl + 'user/favorites/job' + '/' + this.token + '/' + limit + '/' + page
    );
  }

  getFavProducts(limit = 6, page = 1) {
    return this.http.get<any>(
      this.serverUrl + 'user/favorites/product' + '/' + this.token + '/' + limit + '/' + page
    );
  }
}
