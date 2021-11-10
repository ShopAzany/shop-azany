import { Component, OnInit, ViewChild, Input, ElementRef} from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Router, ActivatedRoute, RouterStateSnapshot } from '@angular/router';
import { SellerAuthService } from 'src/app/data/services/seller/seller-auth.service';
import { CookieService } from 'ngx-cookie';

@Component({
  selector: 'app-verification',
  templateUrl: './verification.component.html',
  styleUrls: ['./verification.component.scss']
})
export class VerificationComponent implements OnInit {

  isSubmitting = false;
  forPwdForm = true;
  comEmailForm = false;
  resetPassForm = false;
  tokenError: any;

  auth;

  constructor(
    private route: Router, 
    private routee: ActivatedRoute,
    private authService: SellerAuthService,
    private CookieService: CookieService,
  ) {}

  form = new FormGroup({
    email: new FormControl(this.getemail(), [
      Validators.required
    ]),
    token_code: new FormControl('', [
      Validators.required,
      Validators.maxLength(6),
      Validators.minLength(6)
    ]),
  });

  get tokenCode() {
    return this.form.get('token_code');
  }
  get email() {
    return this.form.get('email');
  }

  ngOnInit(): void {
    this.getemail();
  }

  getemail() {
    const data =this.CookieService.get('reg-data');
    //console.log(data);
    let parsedData = JSON.parse(data);
    let parsedDataa = (parsedData.email);
    //console.log(parsedDataa);
    return parsedDataa;
  }

  submit(){
    this.isSubmitting = true;
    const data = JSON.stringify(this.form.value);
    this.authService.verifyEmail(data).subscribe(res => {
      if (res && res.status === 'success') {
        //this.route.navigateByUrl('/seller/login');
        const data2 =this.CookieService.get('reg-data');
        this.authService.signup(data2).subscribe(/*res*/auth => {
          this.auth = auth;
            if (auth) {
              this.route.navigateByUrl('/seller/auth');
            } else {
              this.route.navigateByUrl('/seller/register');
            }
        });
      } else {
        this.tokenError = res.data
      }
      this.isSubmitting = false;
  })
}}
