import { Injectable } from '@angular/core';

@Injectable({ providedIn: 'root' })
export class ConfigService {

  get adminURL() {
    return 'administrator';
  }

  get sellerURL() {
    return 'seller';
  }

  getProject_name() {
    return 'Azany';
  }

  getBusiness_name() {
    return 'Azany Limited';
  }

  base_url() {
    return 'https://shopazany.com/backend/';
  }

  manageUrl(){
    return 'https://manage.shopazany.com/';
  }

  treatImgUrl(imgurl) {
    if (imgurl) {
      let baseIp = this.base_url().split('//')[1].split('/')[0];
      let imgIp = imgurl.split('//')[1].split('/')[0];
      return imgIp == 'localhost' || imgIp.match(/\d+\.\d+\.\d+\.\d+/) ? imgurl.replace(imgIp, baseIp) : imgurl;
    }
    return null;
  }

  bankInfo() {
    return null;
  }

  clearnUrl(name) {
    const str = name.trim();
    if (str) {
      return str.replace(/[^a-zA-Z0-9 &+,._-]/g, '').split('&').join('and')
        .split(' + ').join('-').split('+ ').join('-').split('+').join('-')
        .split(', ').join('-').split(',').join('-')
        .split('  ').join('-').split(' - ').join('-').split(' ').join('-')
        .toLowerCase().replace(/^-/g, '');
    }
  }

  clearnText(name) {
    const str = name.trim();
    if (str) {
      return str.replace(/[^a-zA-Z0-9 &+,._-]/g, '').split('and').join('&')
        .split(' + ').join(' ').split('+ ').join(' ').split('+').join(' ')
        .split(', ').join(' ').split(',').join(' ')
        .split('-').join(' ').split(' - ').join(' ').split(' -').join(' ').split('- ').join(' ')
        .toLowerCase().replace(/^-/g, '');
    }
  }

  numberFormat(num, dec = 0) {
    num = +num;
    let pref = num < 0 ? '-' : '';
    let numStr = num.toFixed(dec).replace('-', '');
    let intStr = numStr.split('.')[0];
    let convStr = '';
    let count = 0;
    for (let i = intStr.length - 1; i > -1; i--) {
      if (count == 3) {
        convStr = ',' + convStr;
        count = 0;
      }
      convStr = intStr[i] + convStr;
      count++;
    }
    return `${pref}${convStr}${dec > 0 ? '.' + numStr.split('.')[1] : ''}`;
  }

  getTitleCase(str) {
    return str.replace(/(^|\s)\S/g, function (t) { return t.toUpperCase(); });
  }

  getRandomString(lengthCnt) {
    let result = '', i;
    const chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for (i = lengthCnt; i > 0; --i) {
      result += chars[Math.floor(Math.random() * chars.length)];
    }
    return result;
  }
}
