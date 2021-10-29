import { Component, OnInit } from '@angular/core';
import { GeneralSettingsService } from 'src/app/data/services/general-settings.service';

@Component({
  selector: 'app-footer',
  templateUrl: './footer.component.html',
  styleUrls: ['./footer.component.scss']
})
export class FooterComponent implements OnInit {
  settings;

  constructor(
    private generalSettings: GeneralSettingsService
  ) { }

  ngOnInit(): void {
    this.getSettings();
  }

  private getSettings() {
    this.generalSettings.genSettings.subscribe(res => {
      this.settings = res;
    });
  }

}
