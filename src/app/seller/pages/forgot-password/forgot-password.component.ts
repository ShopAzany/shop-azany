import { Route } from '@angular/compiler/src/core';
import { Component, ElementRef, OnInit, ViewChild } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { AuthService } from 'src/app/data/services/auth.service';
import { SellerAuthService } from 'src/app/data/services/seller/seller-auth.service';

@Component({
  selector: 'app-forgot-password',
  templateUrl: './forgot-password.component.html',
  styleUrls: ['./forgot-password.component.scss']
})
export class ForgotPasswordComponent implements OnInit {


  isSubmitting = false;
  forPwdForm = true;
  comEmailForm = false;
  resetPassForm = false;
  emailError: any;
  tokenError: any;

  notMatched = false;

  form = new FormGroup({
    email: new FormControl('', [Validators.required]),
  });

  formToken = new FormGroup({
    email: new FormControl('', []),
    token: new FormControl('', [Validators.required]),
  });

  formReset = new FormGroup({
    email: new FormControl('', []),
    password: new FormControl('', [Validators.required]),
    retype_password: new FormControl('', [Validators.required]),
  });


  get email() {
    return this.form.get("email");
  }
  get token() {
    return this.formToken.get("token");
  }
  get password() {
    return this.formReset.get("password");
  }
  get retype_password() {
    return this.formReset.get("retype_password");
  }

  constructor(
    private authService: SellerAuthService,
    private router: Router
  ) { }

  ngOnInit(): void {
  }


  submit() {
    this.isSubmitting = true;
    this.formToken.get('email').setValue(this.form.value.email);
    this.formReset.get('email').setValue(this.form.value.email);
    const data = JSON.stringify(this.form.value);
    this.authService.resetPass(data).subscribe(res => {
      console.log(res);
      if (res && res.status === 'success') {
        // this.router.navigateByUrl('/reset-password');
        this.forPwdForm = false;
        this.comEmailForm = true;
      } else {
        this.emailError = res.data
      }
      this.isSubmitting = false;
    },
      err => {
        console.log(err);
        this.isSubmitting = false;
      });
  }


  submitToken() {
    this.isSubmitting = true;
    const data = JSON.stringify(this.formToken.value);
    this.authService.verifyToken(data).subscribe(res => {
      console.log(res);
      // return;
      if (res && res.status === 'success') {
        this.forPwdForm = false;
        this.comEmailForm = false;
        this.resetPassForm = true;
      } else {
        this.tokenError = res.data
      }
      this.isSubmitting = false;
    },
      err => {
        console.log(err);
        this.isSubmitting = false;
      });
  }


  checkPass(event) {
    this.notMatched = true;
    const pass = this.formReset.get('password').value;
    if (pass == event.target.value) {
      this.notMatched = false;
    }
  }

  submitReset() {
    this.isSubmitting = true;
    const data = JSON.stringify(this.formReset.value);
    this.authService.changePassword(data).subscribe(res => {
      console.log(res);
      if (res && res.status === 'success') {
        alert('Password successfully reset');
        this.router.navigateByUrl('/seller/login');
        this.forPwdForm = false;
        this.comEmailForm = false;
        this.resetPassForm = false;
      } else {
        this.emailError = res.data
      }
      this.isSubmitting = false;
    },
      err => {
        console.log(err);
        this.isSubmitting = false;
      });
  }


}
