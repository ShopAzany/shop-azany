import { Injectable } from '@angular/core';
import { Title, Meta } from '@angular/platform-browser';
import { Router } from '@angular/router';
import { ConfigService } from './config.service';

@Injectable({ providedIn: 'root' })
export class SEOService {
    projectName: string;
    myInterval;

    constructor(
        private title: Title,
        private meta: Meta,
        private configService: ConfigService,
        private router: Router,
    ) {
        this.projectName = this.configService.getProject_name();
    }

    updateTitle(title: string) {
        this.updateOgPrefix('og:title', `${title}`);
        // this.updateOgPrefix('twitter:title', `${title} | ${this.projectName}`);
        this.meta.updateTag({ name: 'twitter:title', content: title }, 'name="twitter:title"');
        this.title.setTitle(title);
    }

    private updateOgPrefix(ogprop, value) {
        const prefixMeta = this.meta.getTags(`property="${ogprop}"`);
        for (let i = 0; i < prefixMeta.length; i++) {
            prefixMeta[i.toString()].setAttribute('content', value);
        }
    }

    updateOgImg(url = 'assets/images/connect-with-freelancers-on-oziconnect.jpg') {
        this.updateOgPrefix('og:image', url);
        this.updateOgPrefix('twitter:image', url);
        this.meta.updateTag({ name: 'twitter:image', content: url }, 'name="twitter:image"');
    }

    updateDescription(desc: string) {
        this.meta.updateTag({ name: 'description', content: desc + ' | ' + this.projectName }, 'name="description"');
        this.meta.updateTag({ name: 'twitter:description', content: desc + ' | ' + this.projectName }, 'name="twitter:description"');
        this.updateOgPrefix('og:description', `${desc} | ${this.projectName}`);
        // this.updateOgPrefix('twitter:description', `${desc} | ${this.projectName}`);
        this.updateOgPrefix('og:url', this.router.url);
    }

    updateKeyword(keywords: string) {
        this.meta.updateTag({ name: 'keywords', content: keywords + ' | ' + this.projectName }, 'name="keywords"');
    }

    stopInterval() {
        const me = this;
        clearInterval(me.myInterval);
    }
}
