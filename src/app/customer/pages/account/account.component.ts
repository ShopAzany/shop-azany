import { Component, OnInit } from '@angular/core';
import { AuthService } from 'src/app/data/services/auth.service';
import { AddressService } from 'src/app/data/services/customer/address.service';

@Component({
  selector: 'app-account',
  templateUrl: './account.component.html',
  styleUrls: ['./account.component.scss']
})
export class AccountComponent implements OnInit {

  auth: any;
  defaultAddress: any;

  constructor(
    private authService: AuthService,
    private addressService: AddressService
  ) { }

  ngOnInit(): void {
    this.getAuth();
    this.defShipAddr();
  }

  private getAuth() {
    this.authService.customer.subscribe(res => {
      if (res && res.login_id) { 
        this.auth = res; 
      }
    });
  }

  private defShipAddr(){
    this.addressService.defaulAdd().subscribe(res => {
      if (res) {
        this.defaultAddress = res;
      }
    });
  }



}
