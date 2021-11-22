import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { StorageService } from 'src/app/data/helpers/storage.service';
import { SellerAuthService } from 'src/app/data/services/seller/seller-auth.service';

@Component({
  selector: 'app-additional-info',
  templateUrl: './additional-info.component.html',
  styleUrls: ['./additional-info.component.scss']
})
export class AdditionalInfoComponent implements OnInit {
  isSubmitting = false;
  form = new FormGroup({
    account_name: new FormControl('', [
      Validators.required
    ]),
    account_number: new FormControl('', [
      Validators.required
    ]),
    account_type: new FormControl('', Validators.required),
    bank_name: new FormControl('', [
      Validators.required,
    ])
  });

  get accName() {
    return this.form.get('account_name');
  }
  get accNum() {
    return this.form.get('account_number');
  }
  get accType() {
    return this.form.get('account_type');
  }
  get bank() {
    return this.form.get('bank_name');
  }

  constructor(
    private router: Router,
    private authService: SellerAuthService,
    private storageService: StorageService,
  ) { }

  ngOnInit(): void {
    this.checkAuth()
  }

  private checkAuth() {
    this.authService.seller.subscribe(auth => {
      if (auth) {
        //change back to 0
        if (auth.biz_info_status == 0) {
          this.router.navigateByUrl('/seller/register/business-info');
        } else if (auth.bank_info_status == 1) {
          // form test
          this.router.navigateByUrl('/seller/auth');
          //this.router.navigateByUrl('/seller/register/business-info');
        }
      } else {
        this.router.navigateByUrl('/seller/register');
      }
    })
  }

  submit() {
    this.isSubmitting = true;
    const data = JSON.stringify(this.form.value);
    this.authService.signupBankInfo(data).subscribe(res => {
      if (res) {
        if (res.status == 'success') {
          this.storageService.remove('biz_info');
          this.router.navigateByUrl('/seller/auth');
        }
      }
      this.isSubmitting = false;
    })

  }

}
