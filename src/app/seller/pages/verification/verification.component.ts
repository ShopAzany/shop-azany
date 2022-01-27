import { Component, OnInit, ViewChild, Input, ElementRef} from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Router, ActivatedRoute, RouterStateSnapshot } from '@angular/router';
import { SellerAuthService } from 'src/app/data/services/seller/seller-auth.service';
import { CookieService } from 'ngx-cookie';
import { UserService } from 'src/app/data/services/guest/user.service';

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
  newreg = false;

  auth;

  constructor(
    private route: Router, 
    private routee: ActivatedRoute,
    private authService: SellerAuthService,
    private CookieService: CookieService,
    private userService: UserService
  ) {}

  form = new FormGroup({
    email: new FormControl(this.getemail(), [
      Validators.required
    ]),
    token: new FormControl('', [
      Validators.required,
      Validators.maxLength(6),
      Validators.minLength(6)
    ]),
  });

  get tokenCode() {
    return this.form.get('token');
  }
  get email() {
    return this.form.get('email');
  }

  ngOnInit(): void {
    this.getemail();
  }

  getemail() {
    return window.localStorage.getItem('email');
  }

  submit(){
    this.isSubmitting = true;
    const data = JSON.stringify(this.form.value);
    this.userService.verifyEmail(data).subscribe(
      (res: any) => {
        this.route.navigate(['/seller/auth']);
      },
      (err: any) => {
        this.tokenError = err.error.message;
        this.isSubmitting = false;
      }
    );
  }

}
