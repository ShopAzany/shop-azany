import { Component, OnInit } from '@angular/core';
import { GeneralSettingsService } from 'src/app/data/services/general-settings.service';

@Component({
  selector: 'app-customer-service',
  templateUrl: './customer-service.component.html',
  styleUrls: ['./customer-service.component.scss']
})
export class CustomerServiceComponent implements OnInit {
  settings;
  constructor(
    private generalSettingsService: GeneralSettingsService,
  ) { }

  ngOnInit(): void {
    this.getSettings();
  }

  private getSettings() {
    this.generalSettingsService.genSettings.subscribe(res => {
      if (res) {
        this.settings = res;
      }
    });
  }

}
