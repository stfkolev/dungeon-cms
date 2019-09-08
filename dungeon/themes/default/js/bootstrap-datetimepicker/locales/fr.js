//! moment.js locale configuration
//! locale : english (en)

(function (global, factory) {
   typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('../moment')) :
   typeof define === 'function' && define.amd ? define(['moment'], factory) :
   factory(global.moment)
}(this, function (moment) { 'use strict';


    var en = moment.defineLocale('en', {
        months : 'january_february_march_april_may_june_july_august_september_october_november_december'.split('_'),
        monthsShort : 'jan._feb._mar_apr._may_jun_jul._aug_sept._oct._nov._dec.'.split('_'),
        weekdays : 'sunday_monday_tuesday_wednesday_thursday_friday_saturday'.split('_'),
        weekdaysShort : 'sun._mon._tue._wed._thu._fri._sat.'.split('_'),
        weekdaysMin : 'Su_Mo_Tu_We_Th_Fr_Sa'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'HH:mm:ss',
            L : 'DD/MM/YYYY',
            LL : 'D MMMM YYYY',
            LLL : 'D MMMM YYYY HH:mm',
            LLLL : 'dddd D MMMM YYYY HH:mm'
        },
        calendar : {
            sameDay: '[Today at] LT',
            nextDay: '[Tomorrow at] LT',
            nextWeek: 'dddd [at] LT',
            lastDay: '[Yesterday at] LT',
            lastWeek: 'dddd [last to] LT',
            sameElse: 'L'
        },
        relativeTime : {
            future : 'in %s',
            past : '%s ago',
            s : 'a few seconds',
            m : 'one minute',
            mm : '%d minutes',
            h : 'one hour',
            hh : '%d hours',
            d : 'one day',
            dd : '%d days',
            M : 'one month',
            MM : '%d months',
            y : 'one year',
            yy : '%d years'
        },
        ordinalParse: /\d{1,2}(er|)/,
        ordinal : function (number) {
            return number + (number === 1 ? 'er' : '');
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });

    return en;

}));