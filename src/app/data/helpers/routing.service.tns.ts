import { Injectable } from '@angular/core';
import { RouterExtensions } from 'nativescript-angular/router';

@Injectable({ providedIn: 'root' })
export class RoutingService {
  constructor(private router: RouterExtensions) {}

  get activeRoute() {
    return this.router.router.url.split('/').slice(-1).pop();
  }

  get activeRoutePath() {
    return this.router.router.url;
  }

  replace(commands: any[], clearHistory = true) {
    if (clearHistory) {
      this.router.navigate(commands, { clearHistory: true });
    } else {
      this.router.navigate(commands);
    }
  }

  reloadCurrentRoute() {
   return;
  }

  urlLocator(event) {
    return;
  }
}
