import { filter } from 'rxjs/operators';
import { Injectable } from '@angular/core';
import { Country } from '../../model/country';

@Injectable({ providedIn: 'root' })
export class CountryService {

  private countries = new Array<Country>(
    { name: 'Afghanistan', code: 'AFN', symbol: '&#1547', dailing: '+93', iso: 'AF' },
    { name: 'Albania', code: 'ALL', symbol: '&#76;&#101;&#107', dailing: '+355', iso: 'AL' },
    { name: 'Algeria', code: 'DZD', symbol: 'DA', dailing: '+213', iso: 'DZ' },
    { name: 'American Samoa', code: 'WS$', symbol: 'DA', dailing: '+1684', iso: 'AS' },
    { name: 'Andorra', code: 'EUR', symbol: 'EUR', dailing: '+376', iso: 'AD' },
    { name: 'Angola', code: 'AOA', symbol: 'Kz', dailing: '+244', iso: 'AO' },
    { name: 'Anguilla', code: 'XCD', symbol: 'XCD', dailing: '+1264', iso: 'AI' },
    { name: 'Antigua & Barbuda', code: 'XCD', symbol: 'XCD', dailing: '+1268', iso: 'AG' },
    { name: 'Argentina', code: 'ARS', symbol: '&#36', dailing: '+54', iso: 'AR' },
    { name: 'Armenia', code: 'AMD', symbol: '&#1423', dailing: '+374', iso: 'AM' },
    { name: 'Aruba', code: 'AWG', symbol: '&#402', dailing: '+297', iso: 'AW' },
    { name: 'Australia', code: 'AUD', symbol: '&#36', dailing: '+61', iso: 'AU' },
    { name: 'Austria', code: 'AUR', symbol: '&#8364', dailing: '+43', iso: 'AT' },
    { name: 'Azerbaijan', code: 'AZN', symbol: '&#1084', dailing: '+994', iso: 'AZ' },
    { name: 'Bahamas', code: 'BSD', symbol: '&#36', dailing: '+1242', iso: 'BS' },
    { name: 'Bahrain', code: 'BHD', symbol: 'BD', dailing: '+973', iso: 'BH' },
    { name: 'Bangladesh', code: 'BDT', symbol: 'BDT', dailing: '+880', iso: 'BD' },
    { name: 'Barbados', code: 'BBD', symbol: '&#36', dailing: '+1246', iso: 'BB' },
    { name: 'Belarus', code: 'BYR', symbol: '&#66;&#114', dailing: '+375', iso: 'BB' },
    { name: 'Belgium', code: 'EUR', symbol: 'EUR', dailing: '+32', iso: 'BE' },
    { name: 'Belize', code: 'BZD', symbol: '&#66;&#90;&#36', dailing: '+501', iso: 'BZ' },
    { name: 'Benin', code: 'XOF', symbol: 'CFA', dailing: '+229', iso: 'BJ' },
    { name: 'Bermuda', code: 'BMD', symbol: '&#36', dailing: '+1441', iso: 'BM' },
    { name: 'Bhutan', code: 'BTN', symbol: 'BTN', dailing: '+975', iso: 'BT' },
    { name: 'Bolivia', code: 'BOB', symbol: '&#36;&#98', dailing: '+591', iso: 'BO' },
    { name: 'Bonaire', code: 'USD', symbol: 'USD', dailing: '+599', iso: 'BQ' },
    { name: 'Bosnia & Herzegovina', code: 'BAM', symbol: '&#75;&#77', dailing: '+977', iso: 'BA' },
    { name: 'Botswana', code: 'BWP', symbol: '&#80', dailing: '+267', iso: 'BW' },
    { name: 'Brazil', code: 'BRL', symbol: '&#82;&#36', dailing: '+55', iso: 'BR' },
    { name: 'British Indian Ocean Ter', code: 'GBP', symbol: 'GBP', dailing: '+246', iso: 'IO' },
    { name: 'Brunei', code: 'BND', symbol: '&#36', dailing: '+673', iso: 'BN' },
    { name: 'Bulgaria', code: 'BGN', symbol: '&#1083;&#1074', dailing: '+395', iso: 'BG' },
    { name: 'Burkina Faso', code: 'XOF', symbol: 'CFA', dailing: '+226', iso: 'BF' },
    { name: 'Burundi', code: 'BIF', symbol: 'FBu', dailing: '+257', iso: 'BI' },
    { name: 'Cambodia', code: 'KHR', symbol: '&#6107', dailing: '+855', iso: 'KH' },
    { name: 'Cameroon', code: 'XAF', symbol: 'FCFA', dailing: '+237', iso: 'CM' },
    { name: 'Canada', code: 'CAD', symbol: '&#36', dailing: '+1', iso: 'CA' },
    { name: 'Canary Islands', code: 'EUR', symbol: 'EUR', dailing: '+34', iso: 'ES' },
    { name: 'Cape Verde', code: 'CVE', symbol: 'CVE', dailing: '+238', iso: 'CV' },
    { name: 'Cayman Islands', code: 'KYD', symbol: '&#36', dailing: '+1345', iso: 'CKY' },
    { name: 'Central African Republic', code: 'XAF', symbol: 'FCFA', dailing: '+236', iso: 'CF' },
    { name: 'Chad', code: 'XAF', symbol: 'FCFA', dailing: '+235', iso: 'TD' },
    { name: 'Channel Islands', code: 'JEP', symbol: '£', dailing: '+1345', iso: 'KY' },
    { name: 'Chile', code: 'CLP', symbol: '&#36', dailing: '+56', iso: 'CL' },
    { name: 'China', code: 'CNY', symbol: '&#165', dailing: '+86', iso: 'CN' },
    { name: 'Christmas Island', code: 'AUD', symbol: 'AUD', dailing: '+61', iso: 'CX' },
    { name: 'Cocos Island', code: 'AUD', symbol: 'AUD', dailing: '+61', iso: 'CC' },
    { name: 'Colombia', code: 'COP', symbol: '&#36', dailing: '+57', iso: 'CO' },
    { name: 'Comoros', code: 'KMF', symbol: 'CF', dailing: '+269', iso: 'KM' },
    { name: 'Congo', code: 'XAF', symbol: 'FCFA', dailing: '+242', iso: 'CG' },
    { name: 'Cook Islands', code: 'NZD', symbol: 'NZD', dailing: '+682', iso: 'CK' },
    { name: 'Costa Rica', code: 'CRC', symbol: '&#8353', dailing: '+506', iso: 'CR' },
    { name: 'Cote D\'Ivoire', code: 'XOF', symbol: 'CFA', dailing: '+225', iso: 'CI' },
    { name: 'Croatia', code: 'HRK', symbol: '&#107;&#110', dailing: '+385', iso: 'HR' },
    { name: 'Cuba', code: 'CUP', symbol: '&#8369', dailing: '+53', iso: 'CU' },
    { name: 'Curacao', code: 'ANG', symbol: 'ANG', dailing: '+599', iso: 'CW' },
    { name: 'Cyprus', code: 'EUR', symbol: 'EUR', dailing: '+357', iso: 'CY' },
    { name: 'Czech Republic', code: 'CZK', symbol: '&#75;&#269', dailing: '+420', iso: 'CZ' },
    { name: 'Denmark', code: 'DKK', symbol: '&#107;&#114', dailing: '+45', iso: 'DK' },
    { name: 'Djibouti', code: 'DJF', symbol: 'Fdj', dailing: '+253', iso: 'DJ' },
    { name: 'Dominica', code: 'XCD', symbol: 'XCD', dailing: '+1767', iso: 'DM' },
    { name: 'Dominican Republic', code: 'DOP', symbol: '&#82;&#68;&#36', dailing: '+1809', iso: 'DO' },
    { name: 'East Timor', code: 'USD', symbol: 'USD', dailing: '+670', iso: 'TL' },
    { name: 'Ecuador', code: 'USD', symbol: 'USD', dailing: '+593', iso: 'EC' },
    { name: 'Egypt', code: 'EGP', symbol: '&#163', dailing: '+20', iso: 'EG' },
    { name: 'El Salvador', code: 'SVC', symbol: '&#36', dailing: '+503', iso: 'SV' },
    { name: 'Equatorial Guinea', code: 'XAF', symbol: 'FCFA', dailing: '+240', iso: 'GQ' },
    { name: 'Eritrea', code: 'ERN', symbol: 'NKF', dailing: '+291', iso: 'ER' },
    { name: 'Estonia', code: 'EUR', symbol: 'EUR', dailing: '+372', iso: 'EE' },
    { name: 'Ethiopia', code: 'ETB', symbol: 'BR', dailing: '+251', iso: 'ET' },
    { name: 'Falkland Islands', code: 'FKP', symbol: '&#163', dailing: '+500', iso: 'FK' },
    { name: 'Faroe Islands', code: 'DKK', symbol: 'Kr', dailing: '+298', iso: 'FO' },
    { name: 'Fiji', code: 'FJD', symbol: '&#36', dailing: '+679', iso: 'FJ' },
    { name: 'Finland', code: 'EUR', symbol: 'EUR', dailing: '+358', iso: 'FI' },
    { name: 'France', code: 'EUR', symbol: 'EUR', dailing: '+33', iso: 'FR' },
    { name: 'French Guiana', code: 'EUR', symbol: 'EUR', dailing: '+594', iso: 'GF' },
    { name: 'French Polynesia', code: 'EUR', symbol: 'EUR', dailing: '+698', iso: 'PF' },
    { name: 'French Southern Ter', code: 'EUR', symbol: 'EUR', dailing: '+262', iso: 'TF' },
    { name: 'Gabon', code: 'XAF', symbol: 'FCFA', dailing: '+241', iso: 'GA' },
    { name: 'Gambia', code: 'GMD', symbol: 'D', dailing: '+220', iso: 'GM' },
    { name: 'Georgia', code: 'GEL', symbol: 'GEL', dailing: '+995', iso: 'GE' },
    { name: 'Germany', code: 'EUR', symbol: 'EUR', dailing: '+49', iso: 'DE' },
    { name: 'Ghana', code: 'GHS', symbol: '&#162', dailing: '+233', iso: 'GH' },
    { name: 'Gibraltar', code: 'GIP', symbol: '&#163', dailing: '+350', iso: 'GI' },
    // { name: 'Great Britain', code: 'GPB', symbol: 'GPB', dailing: '+44', iso: 'UK' },
    { name: 'Greece', code: 'EUR', symbol: 'EUR', dailing: '+30', iso: 'GR' },
    { name: 'Greenland', code: 'EUR', symbol: 'EUR', dailing: '+299', iso: 'GL' },
    { name: 'Grenada', code: 'XCD', symbol: 'EC$', dailing: '+1473', iso: 'GD' },
    { name: 'Guadeloupe', code: 'EUR', symbol: 'EUR', dailing: '+590', iso: 'GP' },
    { name: 'Guam', code: 'USD', symbol: 'USD', dailing: '+1671', iso: 'GU' },
    { name: 'Guatemala', code: 'GTQ', symbol: '&#81', dailing: '+502', iso: 'GT' },
    { name: 'Guinea', code: 'GNF', symbol: 'FG', dailing: '+224', iso: 'GN' },
    { name: 'Guyana', code: 'GYD', symbol: '&#36', dailing: '+592', iso: 'GY' },
    { name: 'Haiti', code: 'USD', symbol: 'USD', dailing: '+509', iso: 'HT' },
    { name: 'Honduras', code: 'HNL', symbol: '&#76', dailing: '+504', iso: 'HN' },
    { name: 'Hong Kong', code: 'HKD', symbol: '&#36', dailing: '+852', iso: 'HK' },
    { name: 'Hungary', code: 'HUF', symbol: '&#70;&#116', dailing: '+36', iso: 'HU' },
    { name: 'Iceland', code: 'ISK', symbol: '&#107;&#114', dailing: '+354', iso: 'IS' },
    { name: 'India', code: 'INR', symbol: '&#8377', dailing: '+91', iso: 'IN' },
    { name: 'Indonesia', code: 'IDR', symbol: '&#82;&#112', dailing: '+62', iso: 'ID' },
    { name: 'Iran', code: 'IRR', symbol: '&#65020', dailing: '+91', iso: 'IR' },
    { name: 'Iraq', code: 'IQD', symbol: 'IQD', dailing: '+964', iso: 'IQ' },
    { name: 'Ireland', code: 'EUR', symbol: 'EUR', dailing: '+353', iso: 'IE' },
    // { name: 'Isle of Man', code: 'IMP', symbol: '&#163', dailing: '+44', iso: 'IM' },
    { name: 'Israel', code: 'ILS', symbol: '&#8362', dailing: '+972', iso: 'IL' },
    { name: 'Italy', code: 'EUR', symbol: 'EUR', dailing: '+39', iso: 'IT' },
    { name: 'Jamaica', code: 'JMD', symbol: '&#74;&#36', dailing: '+1876', iso: 'JM' },
    { name: 'Japan', code: 'JPY', symbol: '&#165', dailing: '+81', iso: 'JP' },
    { name: 'Jordan', code: 'JOD', symbol: 'JOD', dailing: '+962', iso: 'JO' },
    { name: 'Kazakhstan', code: 'KZT', symbol: '&#1083;&#1074', dailing: '+7', iso: 'KZ' },
    { name: 'Kenya', code: 'KES', symbol: 'KSh', dailing: '+254', iso: 'KE' },
    { name: 'Kiribati', code: 'AUD', symbol: 'AUD', dailing: '+686', iso: 'KI' },
    { name: 'Korea North', code: 'KPW', symbol: '&#8361', dailing: '+850', iso: 'KP' },
    { name: 'Korea South', code: 'KRW', symbol: '&#8361', dailing: '+82', iso: 'KR' },
    { name: 'Kuwait', code: 'KWD', symbol: 'KD', dailing: '+965', iso: 'KW' },
    { name: 'Kyrgyzstan', code: 'KGS', symbol: '&#1083;&#1074', dailing: '+996', iso: 'KG' },
    { name: 'Laos', code: 'LAK', symbol: '&#8365', dailing: '+856', iso: 'LA' },
    { name: 'Latvia', code: 'EUR', symbol: 'EUR', dailing: '+371', iso: 'LV' },
    { name: 'Lebanon', code: 'LBP', symbol: '&#163', dailing: '+961', iso: 'LB' },
    { name: 'Lesotho', code: 'LSL', symbol: 'L or M', dailing: '+266', iso: 'LS' },
    { name: 'Liberia', code: 'LRD', symbol: '&#36', dailing: '+231', iso: 'LR' },
    { name: 'Libya', code: 'LYD', symbol: 'LD', dailing: '+218', iso: 'LY' },
    { name: 'Liechtenstein', code: 'CHF', symbol: 'CHF', dailing: '+423', iso: 'LI' },
    { name: 'Lithuania', code: 'LTL', symbol: 'LT', dailing: '+370', iso: 'LT' },
    { name: 'Luxembourg', code: 'EUR', symbol: 'EUR', dailing: '+352', iso: 'LU' },
    { name: 'Macau', code: 'MOP', symbol: 'MOP$', dailing: '+853', iso: 'MO' },
    { name: 'Macedonia', code: 'MKD', symbol: '&#1076;&#1077;&#1085', dailing: '+389', iso: 'MK' },
    { name: 'Madagascar', code: 'MGA', symbol: 'Ar', dailing: '+261', iso: 'MG' },
    { name: 'Malaysia', code: 'MYR', symbol: '&#82;&#77', dailing: '+60', iso: 'MY' },
    { name: 'Malawi', code: 'MWK', symbol: 'K', dailing: '+265', iso: 'MW' },
    { name: 'Maldives', code: 'MVR', symbol: 'Rf', dailing: '+960', iso: 'MV' },
    { name: 'Mali', code: 'XOF', symbol: 'CFAF', dailing: '+223', iso: 'ML' },
    { name: 'Malta', code: 'EUR', symbol: 'EUR', dailing: '+356', iso: 'MT' },
    { name: 'Marshall Islands', code: 'USD', symbol: 'USD', dailing: '+692', iso: 'MH' },
    { name: 'Martinique', code: 'EUR', symbol: 'EUR', dailing: '+596', iso: 'MQ' },
    { name: 'Mauritania', code: 'MRO', symbol: 'UM', dailing: '+222', iso: 'MR' },
    { name: 'Mauritius', code: 'MUR', symbol: '&#8360', dailing: '+230', iso: 'MU' },
    { name: 'Mayotte', code: 'EUR', symbol: 'EUR', dailing: '+262', iso: 'YT' },
    { name: 'Mexico', code: 'MXN', symbol: '&#36', dailing: '+52', iso: 'MX' },
    { name: 'Midway Islands', code: 'USD', symbol: 'USD', dailing: '+1808', iso: 'UM' },
    { name: 'Moldova', code: 'MDL', symbol: 'L', dailing: '+373', iso: 'MD' },
    { name: 'Monaco', code: 'EUR', symbol: 'EUR', dailing: '+377', iso: 'MC' },
    { name: 'Mongolia', code: 'MNT', symbol: '&#8366', dailing: '+976', iso: 'MN' },
    { name: 'Montserrat', code: 'XCD', symbol: 'EC$', dailing: '+1664', iso: 'MS' },
    { name: 'Morocco', code: 'MAD', symbol: 'DH', dailing: '+212', iso: 'MA' },
    { name: 'Mozambique', code: 'MZN', symbol: '&#77;&#84', dailing: '+258', iso: 'MZ' },
    { name: 'Myanmar', code: 'MMK', symbol: 'K', dailing: '+95', iso: 'MM' },
    { name: 'Namibia', code: 'NAD', symbol: '&#36', dailing: '+264', iso: 'NA' },
    { name: 'Nauru', code: 'AUD', symbol: 'AUD', dailing: '+674', iso: 'NR' },
    { name: 'Nepal', code: 'NPR', symbol: '&#8360', dailing: '+977', iso: 'NP' },
    { name: 'Netherland', code: 'ANG', symbol: '&#402', dailing: '+31', iso: 'NL' },
    { name: 'New Caledonia', code: 'XPF', symbol: 'XPF', dailing: '+687', iso: 'NC' },
    { name: 'New Zealand', code: 'NZD', symbol: '&#36', dailing: '+64', iso: 'NZ' },
    { name: 'Nicaragua', code: 'NIO', symbol: '&#67;&#36', dailing: '+505', iso: 'NI' },
    { name: 'Niger', code: 'XOF', symbol: 'XOF', dailing: '+227', iso: 'NE' },
    { name: 'Nigeria', code: 'NGN', symbol: '&#8358', dailing: '+234', iso: 'NG' },
    { name: 'Niue', code: 'NZD', symbol: 'NZD', dailing: '+683', iso: 'NU' },
    { name: 'Norfolk Island', code: 'AUD', symbol: 'AUD', dailing: '+672', iso: 'NF' },
    { name: 'Norway', code: 'NOK', symbol: '&#107;&#114', dailing: '+47', iso: 'NO' },
    { name: 'Oman', code: 'OMR', symbol: '&#65020', dailing: '+968', iso: 'OM' },
    { name: 'Pakistan', code: 'PKR', symbol: '&#8360', dailing: '+92', iso: 'PK' },
    { name: 'Palau Island', code: 'USD', symbol: 'USD', dailing: '+680', iso: 'PW' },
    { name: 'Palestine', code: 'PSP', symbol: '&#8362', dailing: '+970', iso: 'PS' },
    { name: 'Panama', code: 'PAB', symbol: '&#66;&#47;&#46', dailing: '+507', iso: 'PA' },
    { name: 'Papua New Guinea', code: 'PGK', symbol: 'PGK', dailing: '+675', iso: 'PG' },
    { name: 'Paraguay', code: 'PYG', symbol: '&#71;&#115', dailing: '+595', iso: 'PY' },
    { name: 'Peru', code: 'PEN', symbol: '&#83;&#47;&#46', dailing: '+51', iso: 'PE' },
    { name: 'Philippines', code: 'PHP', symbol: '&#8369', dailing: '+63', iso: 'PH' },
    { name: 'Pitcairn Island', code: 'NZD', symbol: 'NZD', dailing: '+870', iso: 'PN' },
    { name: 'Poland', code: 'PLN', symbol: '&#122;&#322', dailing: '+48', iso: 'PL' },
    { name: 'Portugal', code: 'EUR', symbol: 'EUR', dailing: '+351', iso: 'PT' },
    { name: 'Puerto Rico', code: 'USD', symbol: 'USD', dailing: '+1', iso: 'PR' },
    { name: 'Qatar', code: 'QAR', symbol: '&#65020', dailing: '+974', iso: 'QA' },
    { name: 'Republic of Montenegro', code: 'EUR', symbol: 'EUR', dailing: '+382', iso: 'ME' },
    { name: 'Republic of Serbia', code: 'RSD', symbol: '&#1044;&#1080', dailing: '+381', iso: 'RS' },
    { name: 'Reunion', code: 'EUR', symbol: 'EUR', dailing: '+262', iso: 'RE' },
    { name: 'Romania', code: 'RON', symbol: '&#108;&#101;&#105', dailing: '+40', iso: 'RO' },
    { name: 'Russia', code: 'RUB', symbol: '&#1088;&#1091;&#1073', dailing: '+7', iso: 'RU' },
    { name: 'Rwanda', code: 'RWF', symbol: 'FRw', dailing: '+250', iso: 'RW' },
    { name: 'St Barthelemy', code: 'EUR', symbol: 'EUR', dailing: '+590', iso: 'BL' },
    { name: 'St Eustatius', code: 'USD', symbol: 'USD', dailing: '+599', iso: 'BQ' },
    { name: 'St Helena', code: 'SHP', symbol: '&#163', dailing: '+290', iso: 'SH' },
    { name: 'St Helena', code: 'SHP', symbol: '&#163', dailing: '+290', iso: 'SH' },
    { name: 'Saint Kitts and Nevis', code: 'XCD', symbol: 'XCD', dailing: '+1869', iso: 'KN' },
    { name: 'St Lucia', code: 'XCD', symbol: 'XCD', dailing: '+1758', iso: 'LC' },
    { name: 'Sint Maarten (Dutch part)', code: 'ANG', symbol: 'ANG', dailing: '+1721', iso: 'SX' },
    { name: 'Saint Martin (French part)', code: 'EUR', symbol: 'EUR', dailing: '+590', iso: 'MF' },
    { name: 'St Pierre & Miquelon', code: 'EUR', symbol: 'EUR', dailing: '+508', iso: 'PM' },
    { name: 'St Vincent & Grenadines', code: 'XCD', symbol: 'XCD', dailing: '+1784', iso: 'VC' },
    { name: 'Saipan', code: 'USD', symbol: 'USD', dailing: '+1670', iso: 'MP' },
    { name: 'Samoa', code: 'WST', symbol: 'WS$', dailing: '+685', iso: 'WS' },
    { name: 'San Marino', code: 'EUR', symbol: 'EUR', dailing: '+378', iso: 'SM' },
    { name: 'Sao Tome & Principe', code: 'STD', symbol: 'STD', dailing: '+239', iso: 'ST' },
    { name: 'Saudi Arabia', code: 'SAR', symbol: '&#65020', dailing: '+966', iso: 'SA' },
    { name: 'Senegal', code: 'XOF', symbol: 'CFA', dailing: '+221', iso: 'SN' },
    { name: 'Serbia', code: 'RSD', symbol: '&#1044;&#1080;&#1085;&#46', dailing: '+381', iso: 'RS' },
    { name: 'Seychelles', code: 'SCR', symbol: 'SRe', dailing: '+248', iso: 'SC' },
    { name: 'Sierra Leone', code: 'SLL', symbol: 'Le', dailing: '+232', iso: 'SL' },
    { name: 'Singapore', code: 'SGD', symbol: '&#36', dailing: '+65', iso: 'SG' },
    { name: 'Slovakia', code: 'EUR', symbol: 'EUR', dailing: '+421', iso: 'SK' },
    { name: 'Slovenia', code: 'EUR', symbol: 'EUR', dailing: '+386', iso: 'SI' },
    { name: 'Solomon Islands', code: 'SBD', symbol: '&#36', dailing: '+677', iso: 'SB' },
    { name: 'Somalia', code: 'SOS', symbol: '&#83', dailing: '+252', iso: 'SO' },
    { name: 'South Africa', code: 'SAR', symbol: '&#82', dailing: '+27', iso: 'ZA' },
    { name: 'Spain', code: 'EUR', symbol: 'EUR', dailing: '+34', iso: 'ES' },
    { name: 'Sri Lanka', code: 'LKR', symbol: '&#8360', dailing: '+94', iso: 'LK' },
    { name: 'Sudan', code: 'SDG', symbol: 'SDG', dailing: '+249', iso: 'SD' },
    { name: 'Suriname', code: 'SRD', symbol: '&#36', dailing: '+597', iso: 'SR' },
    { name: 'Swaziland', code: 'SZL', symbol: 'SZL', dailing: '+268', iso: 'SZ' },
    { name: 'Sweden', code: 'SEK', symbol: '&#107;&#114', dailing: '+46', iso: 'SE' },
    { name: 'Switzerland', code: 'CHF', symbol: '&#67;&#72;&#70', dailing: '+41', iso: 'CH' },
    { name: 'Syria', code: 'SYP', symbol: '&#163', dailing: '+963', iso: 'SY' },
    { name: 'Tahiti', code: 'XPF', symbol: 'XPF', dailing: '+689', iso: 'PF' },
    { name: 'Taiwan', code: 'TWD', symbol: '&#78;&#84;&#36', dailing: '+886', iso: 'TW' },
    { name: 'Tajikistan', code: 'TJS', symbol: 'TJS', dailing: '+992', iso: 'TJ' },
    { name: 'Tanzania', code: 'TZS', symbol: 'TZS', dailing: '+255', iso: 'TZ' },
    { name: 'Thailand', code: 'THB', symbol: '&#3647', dailing: '+66', iso: 'TH' },
    { name: 'Togo', code: 'XOF', symbol: 'CFA', dailing: '+228', iso: 'TG' },
    { name: 'Tokelau', code: 'NZD', symbol: 'NZD', dailing: '+690', iso: 'TK' },
    { name: 'Tonga', code: 'TOP', symbol: 'TOP', dailing: '+676', iso: 'TO' },
    { name: 'Trinidad & Tobago', code: 'TTD', symbol: '&#84;&#84;&#36', dailing: '+1868', iso: 'TT' },
    { name: 'Tunisia', code: 'TND', symbol: 'TND', dailing: '+216', iso: 'TN' },
    { name: 'Turkey', code: 'TRY', symbol: 'TRY', dailing: '+90', iso: 'TR' },
    { name: 'Turkmenistan', code: 'TMT', symbol: 'TMT', dailing: '+993', iso: 'TM' },
    { name: 'Turks & Caicos Is', code: 'USD', symbol: 'USD', dailing: '+1649', iso: 'TC' },
    { name: 'Tuvalu', code: 'TVD', symbol: '&#36', dailing: '+688', iso: 'TV' },
    { name: 'Uganda', code: 'UGX', symbol: 'UGX', dailing: '+256', iso: 'UG' },
    { name: 'Ukraine', code: 'UAH', symbol: '&#8372', dailing: '+380', iso: 'UA' },
    { name: 'United Arab Emirates', code: 'AED', symbol: 'AED', dailing: '+971', iso: 'AE' },
    { name: 'United Kingdom', code: 'GBP', symbol: '&#163', dailing: '+44', iso: 'GB' },
    { name: 'United States', code: 'USD', symbol: '&#36', dailing: '+1', iso: 'US' },
    { name: 'Uruguay', code: 'UYU', symbol: '&#36;&#85', dailing: '+598', iso: 'UY' },
    { name: 'Uzbekistan', code: 'UZS', symbol: '&#1083;&#1074', dailing: '+998', iso: 'UZ' },
    { name: 'Vanuatu', code: 'VUV', symbol: 'VUV', dailing: '+678', iso: 'VU' },
    { name: 'Vatican City State', code: 'EUR', symbol: 'EUR', dailing: '+379', iso: 'VA' },
    { name: 'Venezuela', code: 'VEF', symbol: '&#66;&#115', dailing: '+58', iso: 'VE' },
    { name: 'Vietnam', code: 'VND', symbol: '&#8363', dailing: '+84', iso: 'VN' },
    { name: 'Virgin Islands (Brit)', code: 'USD', symbol: 'USD', dailing: '+1284', iso: 'VG' },
    { name: 'Virgin Islands (USA)', code: 'USD', symbol: 'USD', dailing: '+1340', iso: 'VI' },
    { name: 'Wake Island', code: 'USD', symbol: 'USD', dailing: '+1808', iso: 'UM' },
    { name: 'Wallis & Futana Is Yemen', code: 'XPF', symbol: 'XPF', dailing: '+681', iso: 'WF' },
    { name: 'Zaire', code: 'ZRZ', symbol: 'ZRZ', dailing: '+243', iso: 'ZR' },
    { name: 'Zambia', code: 'ZMW', symbol: 'ZMW', dailing: '+260', iso: 'ZM' },
    { name: ' Zimbabwe', code: 'ZWD', symbol: '&#90;&#36', dailing: '+263', iso: 'ZW' },
  );

  getCountries(): Country[] {
    return this.countries;
  }

  getCountry(name: string): Country {
    return this.countries.filter(country => country.name === name)[0];
  }

  getCountryWithName(name) {
    return this.countries.filter(country => country.dailing == name);
  }

  getCountryWithDialing(dialing) {
    return this.countries.filter(country => country.dailing == dialing);
  }
}
