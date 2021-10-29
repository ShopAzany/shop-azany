import { isPlatformBrowser } from '@angular/common';
import { Inject, Injectable, PLATFORM_ID, VERSION } from '@angular/core';
// import { DeviceDetectorService } from 'ngx-device-detector';

@Injectable({ providedIn: 'root' })
export class DeviceDetectService {
    isBrowser = false;
    propsToShow = [
        'userAgent',
        'os',
        'browser',
        'device',
        'os_version',
        'browser_version'
    ];
    deviceInfo = null;
    version = VERSION.full;

    constructor(
        @Inject(PLATFORM_ID) private platformId: Object
        // private deviceService: DeviceDetectorService
    ) {
        if (isPlatformBrowser(this.platformId)) {
            this.isBrowser = true;
        }
        // this.deviceInfo = deviceService.getDeviceInfo();
        // console.log(this.deviceInfo);
    }

    get isMobile() {
        // return true;
        if (!this.isBrowser) return false;
        var isMobile = true;
        if (window.navigator.userAgent.toLowerCase().indexOf('mobile') < 0) {
            isMobile = false;
        }
        return isMobile;
    }

    get isTablet() {
        // return this.deviceService.isTablet();
        if (!this.isBrowser) return false;
        var isMobile = true;
        if (window.navigator.userAgent.toLowerCase().indexOf('mobile') < 0) {
            isMobile = false;
        }
        return isMobile;
    }

    get isDesktop() {
        // return this.deviceService.isDesktop();
        if (!this.isBrowser) return false;
        var isDesktop = true;
        if (window.navigator.userAgent.toLowerCase().indexOf('mobile') > -1) {
            isDesktop = false;
        }
        return isDesktop;
    }
}
