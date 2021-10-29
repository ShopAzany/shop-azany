import { Component, OnInit } from '@angular/core';
import { StaticContentService } from 'src/app/data/services/guest/static-content.service';

@Component({
  selector: 'app-faq',
  templateUrl: './faq.component.html',
  styleUrls: ['./faq.component.scss']
})
export class FaqComponent implements OnInit {

  faqs;

  constructor(
    private staticContentService: StaticContentService,
  ) { }

  ngOnInit(): void {
    this.getContent();
  }

  private getContent() {
    this.staticContentService.retrieveFaq.subscribe(res => {
      if (res) {
        this.faqs = res;
      }
    })
  }

}
