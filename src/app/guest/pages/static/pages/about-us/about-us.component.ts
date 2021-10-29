import { Component, OnInit, ViewEncapsulation } from '@angular/core';
import { ConfigService } from 'src/app/data/services/config.service';
import { StaticContentService } from 'src/app/data/services/guest/static-content.service';

@Component({
  selector: 'app-about-us',
  templateUrl: './about-us.component.html',
  styleUrls: ['./about-us.component.scss'],
  encapsulation: ViewEncapsulation.None
})
export class AboutUsComponent implements OnInit {
  content;

  constructor(
    private staticContentService: StaticContentService,
    private configService: ConfigService,
  ) { }

  ngOnInit(): void {
    this.getContent();
  }

  private getContent() {
    this.staticContentService.retrieveAbout.subscribe(res => {
      if (res) {
        this.content = res.about;
      }
    });
  }

  treatImgUrl(url) {
    return this.configService.treatImgUrl(url);
  }

}
