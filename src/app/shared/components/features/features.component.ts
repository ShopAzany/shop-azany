import { Component, OnInit, Sanitizer } from '@angular/core';
import { DomSanitizer } from '@angular/platform-browser';
import { GuestHomeService } from 'src/app/data/services/guest/guest-home.service';

@Component({
  selector: 'app-features',
  templateUrl: './features.component.html',
  styleUrls: ['./features.component.scss']
})
export class FeaturesComponent implements OnInit {

  features = [];

  more = { status: false, i: -1 };

  // sanitize(content) {
  //   return this.sanitizer.bypassSecurityTrustHtml(content);
  // }

  constructor(
    private guestHomeService: GuestHomeService
  ) { }

  ngOnInit(): void {
    this.getFeatures();
  }

  private getFeatures() {
    this.guestHomeService.homeOthers.subscribe(res => {
      if (res) {
        this.features = res.whyChoseUs;
      } else {
        this.guestHomeService.getOtherData().subscribe();
      }
    })
  }

  toggleMore(i) {
    this.more.status = this.more.i == i ? !this.more.status : true;
    this.more.i = i;
  }

}
