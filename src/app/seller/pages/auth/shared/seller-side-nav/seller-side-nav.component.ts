import { Component, OnInit } from '@angular/core';
import { SellerAuthService } from 'src/app/data/services/seller/seller-auth.service';

@Component({
  selector: 'app-seller-side-nav',
  templateUrl: './seller-side-nav.component.html',
  styleUrls: ['./seller-side-nav.component.scss']
})
export class SellerSideNavComponent implements OnInit {

  constructor(
    private authService: SellerAuthService
  ) { }

  ngOnInit(): void {
  }

  logout() {
    this.authService.logout();
  }

}
