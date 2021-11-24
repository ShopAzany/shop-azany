import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { BehaviorSubject } from 'rxjs';
import { ConfigService } from 'src/app/data/services/config.service';
import { GeneralSettingsService } from 'src/app/data/services/general-settings.service';
import { EarningsService } from 'src/app/data/services/seller/earnings.service';
import { SellerAuthService } from 'src/app/data/services/seller/seller-auth.service';

@Component({
  selector: 'app-earnings',
  templateUrl: './earnings.component.html',
  styleUrls: ['./earnings.component.scss']
})
export class EarningsComponent implements OnInit {

  seller_id;

  auth;

  bizerr = false;

  rawTrans;
  totalEarnings;
  available;
  transHistory = [];

  closeModal = new BehaviorSubject<boolean>(false);
  withdrawbankId = -1;
  deleting = false;
  adding = false;
  withdrawing = false;

  currency;

  selectedBankInfo;

  bankInfo;

  addBankForm = new FormGroup({
    account_name: new FormControl('', Validators.required),
    account_number: new FormControl('', Validators.required),
    bank_name: new FormControl('', Validators.required),
    account_type: new FormControl(null, Validators.required)
  });

  widthdrawForm = new FormGroup({
    amount: new FormControl('', Validators.required),
  });

  get amount() {
    return this.widthdrawForm.get('amount');
  }

  get accName() {
    return this.addBankForm.get('account_name');
  }
  get accNum() {
    return this.addBankForm.get('account_number');
  }
  get accType() {
    return this.addBankForm.get('account_type');
  }
  get bank() {
    return this.addBankForm.get('bank_name');
  }

  get validAmnt() {
    if (this.amount.touched) {
      if (this.amount.valid) {
        return +this.amount.value <= this.available;
      }
    }
    return true;
  }

  get totalEarn() {
    if (this.totalEarnings) {
      return this.configService.numberFormat(this.totalEarnings, 2).split('.');
    }
    return [0, 0]
  }

  isNaN(date) {
    return isNaN(Date.parse(date));
  }

  constructor(
    private authService: SellerAuthService,
    private earningsService: EarningsService,
    private configService: ConfigService,
    private generalSettings: GeneralSettingsService,
  ) { }

  ngOnInit(): void {
    this.getAuth();
    this.getTransHistory();
    this.getCurrency();
    this.checkbiz();
    this.get_seller_id();
  }

  private get_seller_id(){
    this.seller_id = this.auth.seller_id;
  }

  private checkbiz() {
    if (this.auth.biz_info_status == 0) {
      this.bizerr = true;
    }
  }

  private getCurrency() {
    this.generalSettings.genSettings.subscribe(res => {
      if (res) {
        this.currency = res.currency.symbol;
      }
    });
  }

  private getAuth() {
    this.authService.seller.subscribe(auth => {
      this.auth = auth;
      console.log(this.auth)
    });
  }

  private getTransHistory() {
    this.earningsService.getTransactions().subscribe(res => {
      this.rawTrans = res.walletHiistory;
      this.totalEarnings = res.totalEarnings;
      this.available = res.totalAvailable;
      this.groupTrans();
    });
  }

  private groupTrans() {
    for (let i = 0; i < this.rawTrans.length; i++) {
      let dateExist;
      if (this.transHistory.length) {
        dateExist = this.transHistory.filter((each) => {
          return each.date == this.rawTrans[i].created_at.split(' ')[0];
        });
        dateExist = dateExist.length ? true : false;
      }
      if (!this.transHistory.length || !dateExist) {
        this.transHistory.push({
          date: this.rawTrans[i].created_at.split(' ')[0],
          transactions: this.rawTrans.filter((each) => {
            let currTransDate = this.rawTrans[i].created_at.split(' ')[0];
            return currTransDate == each.created_at.split(' ')[0];
          })
        });
      } else {
        continue;
      }
    }
    this.transHistory.sort((a, b) => {
      return Date.parse(b.date) - Date.parse(a.date);
    });
    this.transHistory.filter((each, i) => {
      let today = new Date();
      let eachDate = new Date(each.date);
      if (eachDate.getFullYear() == today.getFullYear() && eachDate.getMonth() == today.getMonth()) {
        if (eachDate.getDate() == today.getDate()) {
          this.transHistory[i].date = 'Today';
        } else if (eachDate.getDate() == today.getDate() - 1) {
          this.transHistory[i].date = 'Yesterday';
        }
      }
    });
  }

  timeGetter(dateStr) {
    let timePart = dateStr.split(' ')[1];
    let timeFrag = timePart.split(':');
    let [h, m, s] = timeFrag;
    let meridian;
    if (+h >= 12) {
      meridian = 'PM';
    } else {
      meridian = 'AM';
    }
    return `${h}:${m} ${meridian}`;
  }

  delete() {
    this.deleting = true;
    this.authService.deleteBank(this.selectedBankInfo.id, this.seller_id).subscribe(res => {
      this.deleting = false;
      this.closeModal.next(true);
    });
  }

  addBank() {
    this.adding = true;
    const data = JSON.stringify(this.addBankForm.value);
    this.authService.signupBankInfo(data, this.seller_id).subscribe(res => {
      this.adding = false;
      this.closeModal.next(true);
    });
  }

  withdraw() {
    this.withdrawing = true;
    let data = this.widthdrawForm.value;
    data['bankID'] = this.withdrawbankId;
    data = JSON.stringify(data);
    this.withdrawing = false;
    this.earningsService.withdraw(data).subscribe(res => {
      if (res) {
        if (res.status == 'success') {
          this.rawTrans = res.walletHiistory;
          this.totalEarnings = res.totalEarnings;
          this.available = res.totalAvailable;
          this.transHistory = [];
          this.groupTrans();
          this.withdrawbankId = -1;
          this.closeModal.next(true);
        }
      }
      this.withdrawing = false;
    });
  }

  slide(n, slideCont: HTMLElement) {
    slideCont.scrollLeft = slideCont.scrollLeft + (n * 330);
  }
}
