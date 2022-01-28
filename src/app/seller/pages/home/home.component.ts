import { CountrynotService } from './../../../data/services/local-data/countrynot.service';
import { Component, OnInit, ViewEncapsulation } from '@angular/core';
import { ConfigService } from 'src/app/data/services/config.service';
import { StaticContentService } from 'src/app/data/services/guest/static-content.service';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { CountryService } from 'src/app/data/services/local-data/country.service';
import { UserService } from 'src/app/data/services/guest/user.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss'],
  encapsulation: ViewEncapsulation.None
})
export class HomeComponent implements OnInit {
  selected: any;
  content;
  selectedValue = 0;
  selectedCountry;

  countries;
  countriesnot;

  form = new FormGroup({
    country: new FormControl('Choose a Country', [
      Validators.required
    ])
  });

  get country() {
    return this.form.get('country');
  }

  constructor(
    private staticContentService: StaticContentService,
    private configService: ConfigService,
    private countryService: CountryService,
    private countrynotService: CountrynotService,
    private userService: UserService
  ) { }

  ngOnInit(): void {
    this.getContent();
    this.userService.getVendorCountries().subscribe(
      (data: any) => {
        this.countries = data.data;
        this.countriesnot = this.countrynotService.getCountriesnot();
      }
    );
  }

  private getContent() {
    this.staticContentService.retrieveSellerContent.subscribe(res => {
      if (res) {
        this.content = res;
      }
    })
  }

  treatImgUrl(url) {
    return this.configService.treatImgUrl(url);
  }

  scroll(el: HTMLElement) {
    el.scrollIntoView();
}

}
