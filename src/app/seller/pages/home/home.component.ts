import { Component, OnInit, ViewEncapsulation } from '@angular/core';
import { ConfigService } from 'src/app/data/services/config.service';
import { StaticContentService } from 'src/app/data/services/guest/static-content.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss'],
  encapsulation: ViewEncapsulation.None
})
export class HomeComponent implements OnInit {
  content;

  constructor(
    private staticContentService: StaticContentService,
    private configService: ConfigService,
  ) { }

  ngOnInit(): void {
    this.getContent();
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

}
