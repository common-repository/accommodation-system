/**
 * @version: 2.1.25
 * @author: Dan Grossman http://www.dangrossman.info/
 * @copyright: Copyright (c) 2012-2017 Dan Grossman. All rights reserved.
 * @license: Licensed under the MIT license. See http://www.opensource.org/licenses/mit-license.php
 * @website: http://www.daterangepicker.com/
 */

//! moment.js
//! version : 2.13.0
//! authors : Tim Wood, Iskren Chernev, Moment.js contributors
//! license : MIT
//! momentjs.com
!function(a,
          b){
    "object" == typeof exports && "undefined" != typeof module
            ? module.exports = b()
            : "function" == typeof define && define.amd
            ? define(b)
            : a.moment = b();
}(this,
  function(){
      "use strict";

      function a(){
          return fd.apply(null,
                          arguments);
      }

      function b(a){
          fd = a;
      }

      function c(a){
          return a instanceof Array || "[object Array]" === Object.prototype.toString.call(a);
      }

      function d(a){
          return a instanceof Date || "[object Date]" === Object.prototype.toString.call(a);
      }

      function e(a,
                 b){
          var c,
              d = [];
          for (c = 0; c<a.length; ++c){
              d.push(b(a[c],
                       c));
          }
          return d;
      }

      function f(a,
                 b){
          return Object.prototype.hasOwnProperty.call(a,
                                                      b);
      }

      function g(a,
                 b){
          for (var c in b){
              f(b,
                c) && (a[c] = b[c]);
          }
          return f(b,
                   "toString") && (a.toString = b.toString), f(b,
                                                               "valueOf") && (a.valueOf = b.valueOf), a;
      }

      function h(a,
                 b,
                 c,
                 d){
          return Ja(a,
                    b,
                    c,
                    d,
                    !0)
          .utc();
      }

      function i(){
          return {
              empty          : !1,
              unusedTokens   : [],
              unusedInput    : [],
              overflow       : -2,
              charsLeftOver  : 0,
              nullInput      : !1,
              invalidMonth   : null,
              invalidFormat  : !1,
              userInvalidated: !1,
              iso            : !1,
              parsedDateParts: [],
              meridiem       : null
          };
      }

      function j(a){
          return null == a._pf && (a._pf = i()), a._pf;
      }

      function k(a){
          if (null == a._isValid){
              var b = j(a),
                  c = gd.call(b.parsedDateParts,
                              function(a){
                                  return null != a;
                              });
              a._isValid = !isNaN(a._d.getTime()) && b.overflow<0 && !b.empty && !b.invalidMonth && !b.invalidWeekday && !b.nullInput && !b.invalidFormat && !b.userInvalidated && (!b.meridiem || b.meridiem && c), a._strict && (a._isValid = a._isValid && 0 === b.charsLeftOver && 0 === b.unusedTokens.length && void 0 === b.bigHour);
          }
          return a._isValid;
      }

      function l(a){
          var b = h(NaN);
          return null != a
                  ? g(j(b),
                      a)
                  : j(b).userInvalidated = !0, b;
      }

      function m(a){
          return void 0 === a;
      }

      function n(a,
                 b){
          var c,
              d,
              e;
          if (m(b._isAMomentObject) || (a._isAMomentObject = b._isAMomentObject), m(b._i) || (a._i = b._i), m(b._f) || (a._f = b._f), m(b._l) || (a._l = b._l), m(b._strict) || (a._strict = b._strict), m(b._tzm) || (a._tzm = b._tzm), m(b._isUTC) || (a._isUTC = b._isUTC), m(b._offset) || (a._offset = b._offset), m(b._pf) || (a._pf = j(b)), m(b._locale) || (a._locale = b._locale), hd.length>0){
              for (c in hd){
                  d = hd[c], e = b[d], m(e) || (a[d] = e);
              }
          }
          return a;
      }

      function o(b){
          n(this,
            b), this._d = new Date(null != b._d
                                           ? b._d.getTime()
                                           : NaN), id === !1 && (id = !0, a.updateOffset(this), id = !1);
      }

      function p(a){
          return a instanceof o || null != a && null != a._isAMomentObject;
      }

      function q(a){
          return 0>a
                  ? Math.ceil(a)
                  : Math.floor(a);
      }

      function r(a){
          var b = +a,
              c = 0;
          return 0 !== b && isFinite(b) && (c = q(b)), c;
      }

      function s(a,
                 b,
                 c){
          var d,
              e = Math.min(a.length,
                           b.length),
              f = Math.abs(a.length-b.length),
              g = 0;
          for (d = 0; e>d; d++){
              (c && a[d] !== b[d] || !c && r(a[d]) !== r(b[d])) && g++;
          }
          return g+f;
      }

      function t(b){
          a.suppressDeprecationWarnings === !1 && "undefined" != typeof console && console.warn && console.warn("Deprecation warning: "+b);
      }

      function u(b,
                 c){
          var d = !0;
          return g(function(){
                       return null != a.deprecationHandler && a.deprecationHandler(null,
                                                                                   b), d && (t(b+"\nArguments: "+Array.prototype.slice.call(arguments)
                                                                                                                      .join(", ")+"\n"+(new Error).stack), d = !1), c.apply(this,
                                                                                                                                                                            arguments);
                   },
                   c);
      }

      function v(b,
                 c){
          null != a.deprecationHandler && a.deprecationHandler(b,
                                                               c), jd[b] || (t(c), jd[b] = !0);
      }

      function w(a){
          return a instanceof Function || "[object Function]" === Object.prototype.toString.call(a);
      }

      function x(a){
          return "[object Object]" === Object.prototype.toString.call(a);
      }

      function y(a){
          var b,
              c;
          for (c in a){
              b = a[c], w(b)
                      ? this[c] = b
                      : this["_"+c] = b;
          }
          this._config = a, this._ordinalParseLenient = new RegExp(this._ordinalParse.source+"|"+/\d{1,2}/.source);
      }

      function z(a,
                 b){
          var c,
              d = g({},
                    a);
          for (c in b){
              f(b,
                c) && (x(a[c]) && x(b[c])
                      ? (d[c] = {}, g(d[c],
                                      a[c]), g(d[c],
                                               b[c]))
                      : null != b[c]
                              ? d[c] = b[c]
                              : delete d[c]);
          }
          return d;
      }

      function A(a){
          null != a && this.set(a);
      }

      function B(a){
          return a
                  ? a.toLowerCase()
                     .replace("_",
                              "-")
                  : a;
      }

      function C(a){
          for (var b, c, d, e, f = 0; f<a.length;){
              for (e = B(a[f])
              .split("-"), b = e.length, c = B(a[f+1]), c = c
                      ? c.split("-")
                      : null; b>0;){
                  if (d = D(e.slice(0,
                                    b)
                             .join("-"))){
                      return d;
                  }
                  if (c && c.length>=b && s(e,
                                            c,
                                            !0)>=b-1){
                      break;
                  }
                  b--;
              }
              f++;
          }
          return null;
      }

      function D(a){
          var b = null;
          if (!nd[a] && "undefined" != typeof module && module && module.exports){
              try{
                  b = ld._abbr, require("./locale/"+a), E(b);
              }
              catch (c){
              }
          }
          return nd[a];
      }

      function E(a,
                 b){
          var c;
          return a && (c = m(b)
                  ? H(a)
                  : F(a,
                      b), c && (ld = c)), ld._abbr;
      }

      function F(a,
                 b){
          return null !== b
                  ? (b.abbr = a, null != nd[a]
                          ? (v("defineLocaleOverride",
                               "use moment.updateLocale(localeName, config) to change an existing locale. moment.defineLocale(localeName, config) should only be used for creating a new locale"), b = z(nd[a]._config,
                                                                                                                                                                                                         b))
                          : null != b.parentLocale && (null != nd[b.parentLocale]
                          ? b = z(nd[b.parentLocale]._config,
                                  b)
                          : v("parentLocaleUndefined",
                              "specified parentLocale is not defined yet")), nd[a] = new A(b), E(a), nd[a])
                  : (delete nd[a], null);
      }

      function G(a,
                 b){
          if (null != b){
              var c;
              null != nd[a] && (b = z(nd[a]._config,
                                      b)), c = new A(b), c.parentLocale = nd[a], nd[a] = c, E(a);
          }
          else{
              null != nd[a] && (null != nd[a].parentLocale
                      ? nd[a] = nd[a].parentLocale
                      : null != nd[a] && delete nd[a]);
          }
          return nd[a];
      }

      function H(a){
          var b;
          if (a && a._locale && a._locale._abbr && (a = a._locale._abbr), !a){
              return ld;
          }
          if (!c(a)){
              if (b = D(a)){
                  return b;
              }
              a = [a];
          }
          return C(a);
      }

      function I(){
          return kd(nd);
      }

      function J(a,
                 b){
          var c = a.toLowerCase();
          od[c] = od[c+"s"] = od[b] = a;
      }

      function K(a){
          return "string" == typeof a
                  ? od[a] || od[a.toLowerCase()]
                  : void 0;
      }

      function L(a){
          var b,
              c,
              d = {};
          for (c in a){
              f(a,
                c) && (b = K(c), b && (d[b] = a[c]));
          }
          return d;
      }

      function M(b,
                 c){
          return function(d){
              return null != d
                      ? (O(this,
                           b,
                           d), a.updateOffset(this,
                                              c), this)
                      : N(this,
                          b);
          };
      }

      function N(a,
                 b){
          return a.isValid()
                  ? a._d["get"+(a._isUTC
                          ? "UTC"
                          : "")+b]()
                  : NaN;
      }

      function O(a,
                 b,
                 c){
          a.isValid() && a._d["set"+(a._isUTC
                  ? "UTC"
                  : "")+b](c);
      }

      function P(a,
                 b){
          var c;
          if ("object" == typeof a){
              for (c in a){
                  this.set(c,
                           a[c]);
              }
          }
          else if (a = K(a), w(this[a])){
              return this[a](b);
          }
          return this;
      }

      function Q(a,
                 b,
                 c){
          var d = ""+Math.abs(a),
              e = b-d.length,
              f = a>=0;
          return (f
                  ? c
                          ? "+"
                          : ""
                  : "-")+Math.pow(10,
                                  Math.max(0,
                                           e))
                             .toString()
                             .substr(1)+d;
      }

      function R(a,
                 b,
                 c,
                 d){
          var e = d;
          "string" == typeof d && (e = function(){
              return this[d]();
          }), a && (sd[a] = e), b && (sd[b[0]] = function(){
              return Q(e.apply(this,
                               arguments),
                       b[1],
                       b[2]);
          }), c && (sd[c] = function(){
              return this.localeData()
                         .ordinal(e.apply(this,
                                          arguments),
                                  a);
          });
      }

      function S(a){
          return a.match(/\[[\s\S]/)
                  ? a.replace(/^\[|\]$/g,
                              "")
                  : a.replace(/\\/g,
                              "");
      }

      function T(a){
          var b,
              c,
              d = a.match(pd);
          for (b = 0, c = d.length; c>b; b++){
              sd[d[b]]
                      ? d[b] = sd[d[b]]
                      : d[b] = S(d[b]);
          }
          return function(b){
              var e,
                  f = "";
              for (e = 0; c>e; e++){
                  f += d[e] instanceof Function
                          ? d[e].call(b,
                                      a)
                          : d[e];
              }
              return f;
          };
      }

      function U(a,
                 b){
          return a.isValid()
                  ? (b = V(b,
                           a.localeData()), rd[b] = rd[b] || T(b), rd[b](a))
                  : a.localeData()
                     .invalidDate();
      }

      function V(a,
                 b){
          function c(a){
              return b.longDateFormat(a) || a;
          }

          var d = 5;
          for (qd.lastIndex = 0; d>=0 && qd.test(a);){
              a = a.replace(qd,
                            c), qd.lastIndex = 0, d -= 1;
          }
          return a;
      }

      function W(a,
                 b,
                 c){
          Kd[a] = w(b)
                  ? b
                  : function(a,
                             d){
                      return a && c
                              ? c
                              : b;
                  };
      }

      function X(a,
                 b){
          return f(Kd,
                   a)
                  ? Kd[a](b._strict,
                          b._locale)
                  : new RegExp(Y(a));
      }

      function Y(a){
          return Z(a.replace("\\",
                             "")
                    .replace(/\\(\[)|\\(\])|\[([^\]\[]*)\]|\\(.)/g,
                             function(a,
                                      b,
                                      c,
                                      d,
                                      e){
                                 return b || c || d || e;
                             }));
      }

      function Z(a){
          return a.replace(/[-\/\\^$*+?.()|[\]{}]/g,
                           "\\$&");
      }

      function $(a,
                 b){
          var c,
              d = b;
          for ("string" == typeof a && (a = [a]), "number" == typeof b && (d = function(a,
                                                                                        c){
              c[b] = r(a);
          }), c = 0; c<a.length; c++){
              Ld[a[c]] = d;
          }
      }

      function _(a,
                 b){
          $(a,
            function(a,
                     c,
                     d,
                     e){
                d._w = d._w || {}, b(a,
                                     d._w,
                                     d,
                                     e);
            });
      }

      function aa(a,
                  b,
                  c){
          null != b && f(Ld,
                         a) && Ld[a](b,
                                     c._a,
                                     c,
                                     a);
      }

      function ba(a,
                  b){
          return new Date(Date.UTC(a,
                                   b+1,
                                   0)).getUTCDate();
      }

      function ca(a,
                  b){
          return c(this._months)
                  ? this._months[a.month()]
                  : this._months[Vd.test(b)
                          ? "format"
                          : "standalone"][a.month()];
      }

      function da(a,
                  b){
          return c(this._monthsShort)
                  ? this._monthsShort[a.month()]
                  : this._monthsShort[Vd.test(b)
                          ? "format"
                          : "standalone"][a.month()];
      }

      function ea(a,
                  b,
                  c){
          var d,
              e,
              f,
              g = a.toLocaleLowerCase();
          if (!this._monthsParse){
              for (this._monthsParse = [], this._longMonthsParse = [], this._shortMonthsParse = [], d = 0; 12>d; ++d){
                  f = h([2e3,
                         d]), this._shortMonthsParse[d] = this.monthsShort(f,
                                                                           "")
                                                              .toLocaleLowerCase(), this._longMonthsParse[d] = this.months(f,
                                                                                                                           "")
                                                                                                                   .toLocaleLowerCase();
              }
          }
          return c
                  ? "MMM" === b
                          ? (e = md.call(this._shortMonthsParse,
                                         g), -1 !== e
                                  ? e
                                  : null)
                          : (e = md.call(this._longMonthsParse,
                                         g), -1 !== e
                                  ? e
                                  : null)
                  : "MMM" === b
                          ? (e = md.call(this._shortMonthsParse,
                                         g), -1 !== e
                                  ? e
                                  : (e = md.call(this._longMonthsParse,
                                                 g), -1 !== e
                                          ? e
                                          : null))
                          : (e = md.call(this._longMonthsParse,
                                         g), -1 !== e
                                  ? e
                                  : (e = md.call(this._shortMonthsParse,
                                                 g), -1 !== e
                                          ? e
                                          : null));
      }

      function fa(a,
                  b,
                  c){
          var d,
              e,
              f;
          if (this._monthsParseExact){
              return ea.call(this,
                             a,
                             b,
                             c);
          }
          for (this._monthsParse || (this._monthsParse = [], this._longMonthsParse = [], this._shortMonthsParse = []), d = 0; 12>d; d++){
              if (e = h([2e3,
                         d]), c && !this._longMonthsParse[d] && (this._longMonthsParse[d] = new RegExp("^"+this.months(e,
                                                                                                                       "")
                                                                                                               .replace(".",
                                                                                                                        "")+"$",
                                                                                                       "i"), this._shortMonthsParse[d] = new RegExp("^"+this.monthsShort(e,
                                                                                                                                                                         "")
                                                                                                                                                            .replace(".",
                                                                                                                                                                     "")+"$",
                                                                                                                                                    "i")), c || this._monthsParse[d] || (f = "^"+this.months(e,
                                                                                                                                                                                                             "")+"|^"+this.monthsShort(e,
                                                                                                                                                                                                                                       ""), this._monthsParse[d] = new RegExp(f.replace(".",
                                                                                                                                                                                                                                                                                        ""),
                                                                                                                                                                                                                                                                              "i")), c && "MMMM" === b && this._longMonthsParse[d].test(a)){
                  return d;
              }
              if (c && "MMM" === b && this._shortMonthsParse[d].test(a)){
                  return d;
              }
              if (!c && this._monthsParse[d].test(a)){
                  return d;
              }
          }
      }

      function ga(a,
                  b){
          var c;
          if (!a.isValid()){
              return a;
          }
          if ("string" == typeof b){
              if (/^\d+$/.test(b)){
                  b = r(b);
              }
              else if (b = a.localeData()
                            .monthsParse(b), "number" != typeof b){
                  return a;
              }
          }
          return c = Math.min(a.date(),
                              ba(a.year(),
                                 b)), a._d["set"+(a._isUTC
                  ? "UTC"
                  : "")+"Month"](b,
                                 c), a;
      }

      function ha(b){
          return null != b
                  ? (ga(this,
                        b), a.updateOffset(this,
                                           !0), this)
                  : N(this,
                      "Month");
      }

      function ia(){
          return ba(this.year(),
                    this.month());
      }

      function ja(a){
          return this._monthsParseExact
                  ? (f(this,
                       "_monthsRegex") || la.call(this), a
                          ? this._monthsShortStrictRegex
                          : this._monthsShortRegex)
                  : this._monthsShortStrictRegex && a
                          ? this._monthsShortStrictRegex
                          : this._monthsShortRegex;
      }

      function ka(a){
          return this._monthsParseExact
                  ? (f(this,
                       "_monthsRegex") || la.call(this), a
                          ? this._monthsStrictRegex
                          : this._monthsRegex)
                  : this._monthsStrictRegex && a
                          ? this._monthsStrictRegex
                          : this._monthsRegex;
      }

      function la(){
          function a(a,
                     b){
              return b.length-a.length;
          }

          var b,
              c,
              d = [],
              e = [],
              f = [];
          for (b = 0; 12>b; b++){
              c = h([2e3,
                     b]), d.push(this.monthsShort(c,
                                                  "")), e.push(this.months(c,
                                                                           "")), f.push(this.months(c,
                                                                                                    "")), f.push(this.monthsShort(c,
                                                                                                                                  ""));
          }
          for (d.sort(a), e.sort(a), f.sort(a), b = 0; 12>b; b++){
              d[b] = Z(d[b]), e[b] = Z(e[b]), f[b] = Z(f[b]);
          }
          this._monthsRegex = new RegExp("^("+f.join("|")+")",
                                         "i"), this._monthsShortRegex = this._monthsRegex, this._monthsStrictRegex = new RegExp("^("+e.join("|")+")",
                                                                                                                                "i"), this._monthsShortStrictRegex = new RegExp("^("+d.join("|")+")",
                                                                                                                                                                                "i");
      }

      function ma(a){
          var b,
              c = a._a;
          return c && -2 === j(a).overflow && (b = c[Nd]<0 || c[Nd]>11
                  ? Nd
                  : c[Od]<1 || c[Od]>ba(c[Md],
                                        c[Nd])
                          ? Od
                          : c[Pd]<0 || c[Pd]>24 || 24 === c[Pd] && (0 !== c[Qd] || 0 !== c[Rd] || 0 !== c[Sd])
                                  ? Pd
                                  : c[Qd]<0 || c[Qd]>59
                                          ? Qd
                                          : c[Rd]<0 || c[Rd]>59
                                                  ? Rd
                                                  : c[Sd]<0 || c[Sd]>999
                                                          ? Sd
                                                          : -1, j(a)._overflowDayOfYear && (Md>b || b>Od) && (b = Od), j(a)._overflowWeeks && -1 === b && (b = Td), j(a)._overflowWeekday && -1 === b && (b = Ud), j(a).overflow = b), a;
      }

      function na(a){
          var b,
              c,
              d,
              e,
              f,
              g,
              h = a._i,
              i = $d.exec(h) || _d.exec(h);
          if (i){
              for (j(a).iso = !0, b = 0, c = be.length; c>b; b++){
                  if (be[b][1].exec(i[1])){
                      e = be[b][0], d = be[b][2] !== !1;
                      break;
                  }
              }
              if (null == e){
                  return void (a._isValid = !1);
              }
              if (i[3]){
                  for (b = 0, c = ce.length; c>b; b++){
                      if (ce[b][1].exec(i[3])){
                          f = (i[2] || " ")+ce[b][0];
                          break;
                      }
                  }
                  if (null == f){
                      return void (a._isValid = !1);
                  }
              }
              if (!d && null != f){
                  return void (a._isValid = !1);
              }
              if (i[4]){
                  if (!ae.exec(i[4])){
                      return void (a._isValid = !1);
                  }
                  g = "Z";
              }
              a._f = e+(f || "")+(g || ""), Ca(a);
          }
          else{
              a._isValid = !1;
          }
      }

      function oa(b){
          var c = de.exec(b._i);
          return null !== c
                  ? void (b._d = new Date(+c[1]))
                  : (na(b), void (b._isValid === !1 && (delete b._isValid, a.createFromInputFallback(b))));
      }

      function pa(a,
                  b,
                  c,
                  d,
                  e,
                  f,
                  g){
          var h = new Date(a,
                           b,
                           c,
                           d,
                           e,
                           f,
                           g);
          return 100>a && a>=0 && isFinite(h.getFullYear()) && h.setFullYear(a), h;
      }

      function qa(a){
          var b = new Date(Date.UTC.apply(null,
                                          arguments));
          return 100>a && a>=0 && isFinite(b.getUTCFullYear()) && b.setUTCFullYear(a), b;
      }

      function ra(a){
          return sa(a)
                  ? 366
                  : 365;
      }

      function sa(a){
          return a%4 === 0 && a%100 !== 0 || a%400 === 0;
      }

      function ta(){
          return sa(this.year());
      }

      function ua(a,
                  b,
                  c){
          var d = 7+b-c,
              e = (7+qa(a,
                        0,
                        d)
              .getUTCDay()-b)%7;
          return -e+d-1;
      }

      function va(a,
                  b,
                  c,
                  d,
                  e){
          var f,
              g,
              h = (7+c-d)%7,
              i = ua(a,
                     d,
                     e),
              j = 1+7*(b-1)+h+i;
          return 0>=j
                  ? (f = a-1, g = ra(f)+j)
                  : j>ra(a)
                          ? (f = a+1, g = j-ra(a))
                          : (f = a, g = j), {
              year     : f,
              dayOfYear: g
          };
      }

      function wa(a,
                  b,
                  c){
          var d,
              e,
              f = ua(a.year(),
                     b,
                     c),
              g = Math.floor((a.dayOfYear()-f-1)/7)+1;
          return 1>g
                  ? (e = a.year()-1, d = g+xa(e,
                                              b,
                                              c))
                  : g>xa(a.year(),
                         b,
                         c)
                          ? (d = g-xa(a.year(),
                                      b,
                                      c), e = a.year()+1)
                          : (e = a.year(), d = g), {
              week: d,
              year: e
          };
      }

      function xa(a,
                  b,
                  c){
          var d = ua(a,
                     b,
                     c),
              e = ua(a+1,
                     b,
                     c);
          return (ra(a)-d+e)/7;
      }

      function ya(a,
                  b,
                  c){
          return null != a
                  ? a
                  : null != b
                          ? b
                          : c;
      }

      function za(b){
          var c = new Date(a.now());
          return b._useUTC
                  ? [c.getUTCFullYear(),
                     c.getUTCMonth(),
                     c.getUTCDate()]
                  : [c.getFullYear(),
                     c.getMonth(),
                     c.getDate()];
      }

      function Aa(a){
          var b,
              c,
              d,
              e,
              f = [];
          if (!a._d){
              for (d = za(a), a._w && null == a._a[Od] && null == a._a[Nd] && Ba(a), a._dayOfYear && (e = ya(a._a[Md],
                                                                                                             d[Md]), a._dayOfYear>ra(e) && (j(a)._overflowDayOfYear = !0), c = qa(e,
                                                                                                                                                                                  0,
                                                                                                                                                                                  a._dayOfYear), a._a[Nd] = c.getUTCMonth(), a._a[Od] = c.getUTCDate()), b = 0; 3>b && null == a._a[b]; ++b){
                  a._a[b] = f[b] = d[b];
              }
              for (; 7>b; b++){
                  a._a[b] = f[b] = null == a._a[b]
                          ? 2 === b
                                  ? 1
                                  : 0
                          : a._a[b];
              }
              24 === a._a[Pd] && 0 === a._a[Qd] && 0 === a._a[Rd] && 0 === a._a[Sd] && (a._nextDay = !0, a._a[Pd] = 0), a._d = (a._useUTC
                      ? qa
                      : pa).apply(null,
                                  f), null != a._tzm && a._d.setUTCMinutes(a._d.getUTCMinutes()-a._tzm), a._nextDay && (a._a[Pd] = 24);
          }
      }

      function Ba(a){
          var b,
              c,
              d,
              e,
              f,
              g,
              h,
              i;
          b = a._w, null != b.GG || null != b.W || null != b.E
                  ? (f = 1, g = 4, c = ya(b.GG,
                                          a._a[Md],
                                          wa(Ka(),
                                             1,
                                             4).year), d = ya(b.W,
                                                              1), e = ya(b.E,
                                                                         1), (1>e || e>7) && (i = !0))
                  : (f = a._locale._week.dow, g = a._locale._week.doy, c = ya(b.gg,
                                                                              a._a[Md],
                                                                              wa(Ka(),
                                                                                 f,
                                                                                 g).year), d = ya(b.w,
                                                                                                  1), null != b.d
                          ? (e = b.d, (0>e || e>6) && (i = !0))
                          : null != b.e
                                  ? (e = b.e+f, (b.e<0 || b.e>6) && (i = !0))
                                  : e = f), 1>d || d>xa(c,
                                                        f,
                                                        g)
                  ? j(a)._overflowWeeks = !0
                  : null != i
                          ? j(a)._overflowWeekday = !0
                          : (h = va(c,
                                    d,
                                    e,
                                    f,
                                    g), a._a[Md] = h.year, a._dayOfYear = h.dayOfYear);
      }

      function Ca(b){
          if (b._f === a.ISO_8601){
              return void na(b);
          }
          b._a = [], j(b).empty = !0;
          var c,
              d,
              e,
              f,
              g,
              h = ""+b._i,
              i = h.length,
              k = 0;
          for (e = V(b._f,
                     b._locale)
          .match(pd) || [], c = 0; c<e.length; c++){
              f = e[c], d = (h.match(X(f,
                                       b)) || [])[0], d && (g = h.substr(0,
                                                                         h.indexOf(d)), g.length>0 && j(b)
              .unusedInput
              .push(g), h = h.slice(h.indexOf(d)+d.length), k += d.length), sd[f]
                      ? (d
                              ? j(b).empty = !1
                              : j(b)
                              .unusedTokens
                              .push(f), aa(f,
                                           d,
                                           b))
                      : b._strict && !d && j(b)
              .unusedTokens
              .push(f);
          }
          j(b).charsLeftOver = i-k, h.length>0 && j(b)
          .unusedInput
          .push(h), j(b).bigHour === !0 && b._a[Pd]<=12 && b._a[Pd]>0 && (j(b).bigHour = void 0), j(b).parsedDateParts = b._a.slice(0), j(b).meridiem = b._meridiem, b._a[Pd] = Da(b._locale,
                                                                                                                                                                                   b._a[Pd],
                                                                                                                                                                                   b._meridiem), Aa(b), ma(b);
      }

      function Da(a,
                  b,
                  c){
          var d;
          return null == c
                  ? b
                  : null != a.meridiemHour
                          ? a.meridiemHour(b,
                                           c)
                          : null != a.isPM
                                  ? (d = a.isPM(c), d && 12>b && (b += 12), d || 12 !== b || (b = 0), b)
                                  : b;
      }

      function Ea(a){
          var b,
              c,
              d,
              e,
              f;
          if (0 === a._f.length){
              return j(a).invalidFormat = !0, void (a._d = new Date(NaN));
          }
          for (e = 0; e<a._f.length; e++){
              f = 0, b = n({},
                           a), null != a._useUTC && (b._useUTC = a._useUTC), b._f = a._f[e], Ca(b), k(b) && (f += j(b).charsLeftOver, f += 10*j(b).unusedTokens.length, j(b).score = f, (null == d || d>f) && (d = f, c = b));
          }
          g(a,
            c || b);
      }

      function Fa(a){
          if (!a._d){
              var b = L(a._i);
              a._a = e([b.year,
                        b.month,
                        b.day || b.date,
                        b.hour,
                        b.minute,
                        b.second,
                        b.millisecond],
                       function(a){
                           return a && parseInt(a,
                                                10);
                       }), Aa(a);
          }
      }

      function Ga(a){
          var b = new o(ma(Ha(a)));
          return b._nextDay && (b.add(1,
                                      "d"), b._nextDay = void 0), b;
      }

      function Ha(a){
          var b = a._i,
              e = a._f;
          return a._locale = a._locale || H(a._l), null === b || void 0 === e && "" === b
                  ? l({nullInput: !0})
                  : ("string" == typeof b && (a._i = b = a._locale.preparse(b)), p(b)
                          ? new o(ma(b))
                          : (c(e)
                                  ? Ea(a)
                                  : e
                                          ? Ca(a)
                                          : d(b)
                                                  ? a._d = b
                                                  : Ia(a), k(a) || (a._d = null), a));
      }

      function Ia(b){
          var f = b._i;
          void 0 === f
                  ? b._d = new Date(a.now())
                  : d(f)
                  ? b._d = new Date(f.valueOf())
                  : "string" == typeof f
                          ? oa(b)
                          : c(f)
                                  ? (b._a = e(f.slice(0),
                                              function(a){
                                                  return parseInt(a,
                                                                  10);
                                              }), Aa(b))
                                  : "object" == typeof f
                                          ? Fa(b)
                                          : "number" == typeof f
                                                  ? b._d = new Date(f)
                                                  : a.createFromInputFallback(b);
      }

      function Ja(a,
                  b,
                  c,
                  d,
                  e){
          var f = {};
          return "boolean" == typeof c && (d = c, c = void 0), f._isAMomentObject = !0, f._useUTC = f._isUTC = e, f._l = c, f._i = a, f._f = b, f._strict = d, Ga(f);
      }

      function Ka(a,
                  b,
                  c,
                  d){
          return Ja(a,
                    b,
                    c,
                    d,
                    !1);
      }

      function La(a,
                  b){
          var d,
              e;
          if (1 === b.length && c(b[0]) && (b = b[0]), !b.length){
              return Ka();
          }
          for (d = b[0], e = 1; e<b.length; ++e){
              (!b[e].isValid() || b[e][a](d)) && (d = b[e]);
          }
          return d;
      }

      function Ma(){
          var a = [].slice.call(arguments,
                                0);
          return La("isBefore",
                    a);
      }

      function Na(){
          var a = [].slice.call(arguments,
                                0);
          return La("isAfter",
                    a);
      }

      function Oa(a){
          var b = L(a),
              c = b.year || 0,
              d = b.quarter || 0,
              e = b.month || 0,
              f = b.week || 0,
              g = b.day || 0,
              h = b.hour || 0,
              i = b.minute || 0,
              j = b.second || 0,
              k = b.millisecond || 0;
          this._milliseconds = +k+1e3*j+6e4*i+1e3*h*60*60, this._days = +g+7*f, this._months = +e+3*d+12*c, this._data = {}, this._locale = H(), this._bubble();
      }

      function Pa(a){
          return a instanceof Oa;
      }

      function Qa(a,
                  b){
          R(a,
            0,
            0,
            function(){
                var a = this.utcOffset(),
                    c = "+";
                return 0>a && (a = -a, c = "-"), c+Q(~~(a/60),
                                                     2)+b+Q(~~a%60,
                                                            2);
            });
      }

      function Ra(a,
                  b){
          var c = (b || "").match(a) || [],
              d = c[c.length-1] || [],
              e = (d+"").match(ie) || ["-",
                                       0,
                                       0],
              f = +(60*e[1])+r(e[2]);
          return "+" === e[0]
                  ? f
                  : -f;
      }

      function Sa(b,
                  c){
          var e,
              f;
          return c._isUTC
                  ? (e = c.clone(), f = (p(b) || d(b)
                          ? b.valueOf()
                          : Ka(b)
                          .valueOf())-e.valueOf(), e._d.setTime(e._d.valueOf()+f), a.updateOffset(e,
                                                                                                  !1), e)
                  : Ka(b)
                  .local();
      }

      function Ta(a){
          return 15* -Math.round(a._d.getTimezoneOffset()/15);
      }

      function Ua(b,
                  c){
          var d,
              e = this._offset || 0;
          return this.isValid()
                  ? null != b
                          ? ("string" == typeof b
                                  ? b = Ra(Hd,
                                           b)
                                  : Math.abs(b)<16 && (b = 60*b), !this._isUTC && c && (d = Ta(this)), this._offset = b, this._isUTC = !0, null != d && this.add(d,
                                                                                                                                                                 "m"), e !== b && (!c || this._changeInProgress
                                  ? jb(this,
                                       db(b-e,
                                          "m"),
                                       1,
                                       !1)
                                  : this._changeInProgress || (this._changeInProgress = !0, a.updateOffset(this,
                                                                                                           !0), this._changeInProgress = null)), this)
                          : this._isUTC
                                  ? e
                                  : Ta(this)
                  : null != b
                          ? this
                          : NaN;
      }

      function Va(a,
                  b){
          return null != a
                  ? ("string" != typeof a && (a = -a), this.utcOffset(a,
                                                                      b), this)
                  : -this.utcOffset();
      }

      function Wa(a){
          return this.utcOffset(0,
                                a);
      }

      function Xa(a){
          return this._isUTC && (this.utcOffset(0,
                                                a), this._isUTC = !1, a && this.subtract(Ta(this),
                                                                                         "m")), this;
      }

      function Ya(){
          return this._tzm
                  ? this.utcOffset(this._tzm)
                  : "string" == typeof this._i && this.utcOffset(Ra(Gd,
                                                                    this._i)), this;
      }

      function Za(a){
          return this.isValid()
                  ? (a = a
                          ? Ka(a)
                          .utcOffset()
                          : 0, (this.utcOffset()-a)%60 === 0)
                  : !1;
      }

      function $a(){
          return this.utcOffset()>this.clone()
                                      .month(0)
                                      .utcOffset() || this.utcOffset()>this.clone()
                                                                           .month(5)
                                                                           .utcOffset();
      }

      function _a(){
          if (!m(this._isDSTShifted)){
              return this._isDSTShifted;
          }
          var a = {};
          if (n(a,
                this), a = Ha(a), a._a){
              var b = a._isUTC
                      ? h(a._a)
                      : Ka(a._a);
              this._isDSTShifted = this.isValid() && s(a._a,
                                                       b.toArray())>0;
          }
          else{
              this._isDSTShifted = !1;
          }
          return this._isDSTShifted;
      }

      function ab(){
          return this.isValid()
                  ? !this._isUTC
                  : !1;
      }

      function bb(){
          return this.isValid()
                  ? this._isUTC
                  : !1;
      }

      function cb(){
          return this.isValid()
                  ? this._isUTC && 0 === this._offset
                  : !1;
      }

      function db(a,
                  b){
          var c,
              d,
              e,
              g = a,
              h = null;
          return Pa(a)
                  ? g = {
                      ms: a._milliseconds,
                      d : a._days,
                      M : a._months
                  }
                  : "number" == typeof a
                          ? (g = {}, b
                                  ? g[b] = a
                                  : g.milliseconds = a)
                          : (h = je.exec(a))
                                  ? (c = "-" === h[1]
                                          ? -1
                                          : 1, g = {
                                      y : 0,
                                      d : r(h[Od])*c,
                                      h : r(h[Pd])*c,
                                      m : r(h[Qd])*c,
                                      s : r(h[Rd])*c,
                                      ms: r(h[Sd])*c
                                  })
                                  : (h = ke.exec(a))
                                          ? (c = "-" === h[1]
                                                  ? -1
                                                  : 1, g = {
                                              y: eb(h[2],
                                                    c),
                                              M: eb(h[3],
                                                    c),
                                              w: eb(h[4],
                                                    c),
                                              d: eb(h[5],
                                                    c),
                                              h: eb(h[6],
                                                    c),
                                              m: eb(h[7],
                                                    c),
                                              s: eb(h[8],
                                                    c)
                                          })
                                          : null == g
                                                  ? g = {}
                                                  : "object" == typeof g && ("from" in g || "to" in g) && (e = gb(Ka(g.from),
                                                                                                                  Ka(g.to)), g = {}, g.ms = e.milliseconds, g.M = e.months), d = new Oa(g), Pa(a) && f(a,
                                                                                                                                                                                                       "_locale") && (d._locale = a._locale), d;
      }

      function eb(a,
                  b){
          var c = a && parseFloat(a.replace(",",
                                            "."));
          return (isNaN(c)
                  ? 0
                  : c)*b;
      }

      function fb(a,
                  b){
          var c = {
              milliseconds: 0,
              months      : 0
          };
          return c.months = b.month()-a.month()+12*(b.year()-a.year()), a.clone()
                                                                         .add(c.months,
                                                                              "M")
                                                                         .isAfter(b) && --c.months, c.milliseconds = +b- +a.clone()
                                                                                                                           .add(c.months,
                                                                                                                                "M"), c;
      }

      function gb(a,
                  b){
          var c;
          return a.isValid() && b.isValid()
                  ? (b = Sa(b,
                            a), a.isBefore(b)
                          ? c = fb(a,
                                   b)
                          : (c = fb(b,
                                    a), c.milliseconds = -c.milliseconds, c.months = -c.months), c)
                  : {
                      milliseconds: 0,
                      months      : 0
                  };
      }

      function hb(a){
          return 0>a
                  ? -1*Math.round(-1*a)
                  : Math.round(a);
      }

      function ib(a,
                  b){
          return function(c,
                          d){
              var e,
                  f;
              return null === d || isNaN(+d) || (v(b,
                                                   "moment()."+b+"(period, number) is deprecated. Please use moment()."+b+"(number, period)."), f = c, c = d, d = f), c = "string" == typeof c
                      ? +c
                      : c, e = db(c,
                                  d), jb(this,
                                         e,
                                         a), this;
          };
      }

      function jb(b,
                  c,
                  d,
                  e){
          var f = c._milliseconds,
              g = hb(c._days),
              h = hb(c._months);
          b.isValid() && (e = null == e
                  ? !0
                  : e, f && b._d.setTime(b._d.valueOf()+f*d), g && O(b,
                                                                     "Date",
                                                                     N(b,
                                                                       "Date")+g*d), h && ga(b,
                                                                                             N(b,
                                                                                               "Month")+h*d), e && a.updateOffset(b,
                                                                                                                                  g || h));
      }

      function kb(a,
                  b){
          var c = a || Ka(),
              d = Sa(c,
                     this)
              .startOf("day"),
              e = this.diff(d,
                            "days",
                            !0),
              f = -6>e
                      ? "sameElse"
                      : -1>e
                              ? "lastWeek"
                              : 0>e
                                      ? "lastDay"
                                      : 1>e
                                              ? "sameDay"
                                              : 2>e
                                                      ? "nextDay"
                                                      : 7>e
                                                              ? "nextWeek"
                                                              : "sameElse",
              g = b && (w(b[f])
                      ? b[f]()
                      : b[f]);
          return this.format(g || this.localeData()
                                      .calendar(f,
                                                this,
                                                Ka(c)));
      }

      function lb(){
          return new o(this);
      }

      function mb(a,
                  b){
          var c = p(a)
                  ? a
                  : Ka(a);
          return this.isValid() && c.isValid()
                  ? (b = K(m(b)
                                   ? "millisecond"
                                   : b), "millisecond" === b
                          ? this.valueOf()>c.valueOf()
                          : c.valueOf()<this.clone()
                                            .startOf(b)
                                            .valueOf())
                  : !1;
      }

      function nb(a,
                  b){
          var c = p(a)
                  ? a
                  : Ka(a);
          return this.isValid() && c.isValid()
                  ? (b = K(m(b)
                                   ? "millisecond"
                                   : b), "millisecond" === b
                          ? this.valueOf()<c.valueOf()
                          : this.clone()
                                .endOf(b)
                                .valueOf()<c.valueOf())
                  : !1;
      }

      function ob(a,
                  b,
                  c,
                  d){
          return d = d || "()", ("(" === d[0]
                  ? this.isAfter(a,
                                 c)
                  : !this.isBefore(a,
                                   c)) && (")" === d[1]
                  ? this.isBefore(b,
                                  c)
                  : !this.isAfter(b,
                                  c));
      }

      function pb(a,
                  b){
          var c,
              d = p(a)
                      ? a
                      : Ka(a);
          return this.isValid() && d.isValid()
                  ? (b = K(b || "millisecond"), "millisecond" === b
                          ? this.valueOf() === d.valueOf()
                          : (c = d.valueOf(), this.clone()
                                                  .startOf(b)
                                                  .valueOf()<=c && c<=this.clone()
                                                                          .endOf(b)
                                                                          .valueOf()))
                  : !1;
      }

      function qb(a,
                  b){
          return this.isSame(a,
                             b) || this.isAfter(a,
                                                b);
      }

      function rb(a,
                  b){
          return this.isSame(a,
                             b) || this.isBefore(a,
                                                 b);
      }

      function sb(a,
                  b,
                  c){
          var d,
              e,
              f,
              g;
          return this.isValid()
                  ? (d = Sa(a,
                            this), d.isValid()
                          ? (e = 6e4*(d.utcOffset()-this.utcOffset()), b = K(b), "year" === b || "month" === b || "quarter" === b
                                  ? (g = tb(this,
                                            d), "quarter" === b
                                          ? g /= 3
                                          : "year" === b && (g /= 12))
                                  : (f = this-d, g = "second" === b
                                          ? f/1e3
                                          : "minute" === b
                                                  ? f/6e4
                                                  : "hour" === b
                                                          ? f/36e5
                                                          : "day" === b
                                                                  ? (f-e)/864e5
                                                                  : "week" === b
                                                                          ? (f-e)/6048e5
                                                                          : f), c
                                  ? g
                                  : q(g))
                          : NaN)
                  : NaN;
      }

      function tb(a,
                  b){
          var c,
              d,
              e = 12*(b.year()-a.year())+(b.month()-a.month()),
              f = a.clone()
                   .add(e,
                        "months");
          return 0>b-f
                  ? (c = a.clone()
                          .add(e-1,
                               "months"), d = (b-f)/(f-c))
                  : (c = a.clone()
                          .add(e+1,
                               "months"), d = (b-f)/(c-f)), -(e+d) || 0;
      }

      function ub(){
          return this.clone()
                     .locale("en")
                     .format("ddd MMM DD YYYY HH:mm:ss [GMT]ZZ");
      }

      function vb(){
          var a = this.clone()
                      .utc();
          return 0<a.year() && a.year()<=9999
                  ? w(Date.prototype.toISOString)
                          ? this.toDate()
                                .toISOString()
                          : U(a,
                              "YYYY-MM-DD[T]HH:mm:ss.SSS[Z]")
                  : U(a,
                      "YYYYYY-MM-DD[T]HH:mm:ss.SSS[Z]");
      }

      function wb(b){
          b || (b = this.isUtc()
                  ? a.defaultFormatUtc
                  : a.defaultFormat);
          var c = U(this,
                    b);
          return this.localeData()
                     .postformat(c);
      }

      function xb(a,
                  b){
          return this.isValid() && (p(a) && a.isValid() || Ka(a)
          .isValid())
                  ? db({
                           to  : this,
                           from: a
                       })
                  .locale(this.locale())
                  .humanize(!b)
                  : this.localeData()
                        .invalidDate();
      }

      function yb(a){
          return this.from(Ka(),
                           a);
      }

      function zb(a,
                  b){
          return this.isValid() && (p(a) && a.isValid() || Ka(a)
          .isValid())
                  ? db({
                           from: this,
                           to  : a
                       })
                  .locale(this.locale())
                  .humanize(!b)
                  : this.localeData()
                        .invalidDate();
      }

      function Ab(a){
          return this.to(Ka(),
                         a);
      }

      function Bb(a){
          var b;
          return void 0 === a
                  ? this._locale._abbr
                  : (b = H(a), null != b && (this._locale = b), this);
      }

      function Cb(){
          return this._locale;
      }

      function Db(a){
          switch (a = K(a)){
              case"year":
                  this.month(0);
              case"quarter":
              case"month":
                  this.date(1);
              case"week":
              case"isoWeek":
              case"day":
              case"date":
                  this.hours(0);
              case"hour":
                  this.minutes(0);
              case"minute":
                  this.seconds(0);
              case"second":
                  this.milliseconds(0);
          }
          return "week" === a && this.weekday(0), "isoWeek" === a && this.isoWeekday(1), "quarter" === a && this.month(3*Math.floor(this.month()/3)), this;
      }

      function Eb(a){
          return a = K(a), void 0 === a || "millisecond" === a
                  ? this
                  : ("date" === a && (a = "day"), this.startOf(a)
                                                      .add(1,
                                                           "isoWeek" === a
                                                                   ? "week"
                                                                   : a)
                                                      .subtract(1,
                                                                "ms"));
      }

      function Fb(){
          return this._d.valueOf()-6e4*(this._offset || 0);
      }

      function Gb(){
          return Math.floor(this.valueOf()/1e3);
      }

      function Hb(){
          return this._offset
                  ? new Date(this.valueOf())
                  : this._d;
      }

      function Ib(){
          var a = this;
          return [a.year(),
                  a.month(),
                  a.date(),
                  a.hour(),
                  a.minute(),
                  a.second(),
                  a.millisecond()];
      }

      function Jb(){
          var a = this;
          return {
              years       : a.year(),
              months      : a.month(),
              date        : a.date(),
              hours       : a.hours(),
              minutes     : a.minutes(),
              seconds     : a.seconds(),
              milliseconds: a.milliseconds()
          };
      }

      function Kb(){
          return this.isValid()
                  ? this.toISOString()
                  : null;
      }

      function Lb(){
          return k(this);
      }

      function Mb(){
          return g({},
                   j(this));
      }

      function Nb(){
          return j(this).overflow;
      }

      function Ob(){
          return {
              input : this._i,
              format: this._f,
              locale: this._locale,
              isUTC : this._isUTC,
              strict: this._strict
          };
      }

      function Pb(a,
                  b){
          R(0,
            [a,
             a.length],
            0,
            b);
      }

      function Qb(a){
          return Ub.call(this,
                         a,
                         this.week(),
                         this.weekday(),
                         this.localeData()._week.dow,
                         this.localeData()._week.doy);
      }

      function Rb(a){
          return Ub.call(this,
                         a,
                         this.isoWeek(),
                         this.isoWeekday(),
                         1,
                         4);
      }

      function Sb(){
          return xa(this.year(),
                    1,
                    4);
      }

      function Tb(){
          var a = this.localeData()._week;
          return xa(this.year(),
                    a.dow,
                    a.doy);
      }

      function Ub(a,
                  b,
                  c,
                  d,
                  e){
          var f;
          return null == a
                  ? wa(this,
                       d,
                       e).year
                  : (f = xa(a,
                            d,
                            e), b>f && (b = f), Vb.call(this,
                                                        a,
                                                        b,
                                                        c,
                                                        d,
                                                        e));
      }

      function Vb(a,
                  b,
                  c,
                  d,
                  e){
          var f = va(a,
                     b,
                     c,
                     d,
                     e),
              g = qa(f.year,
                     0,
                     f.dayOfYear);
          return this.year(g.getUTCFullYear()), this.month(g.getUTCMonth()), this.date(g.getUTCDate()), this;
      }

      function Wb(a){
          return null == a
                  ? Math.ceil((this.month()+1)/3)
                  : this.month(3*(a-1)+this.month()%3);
      }

      function Xb(a){
          return wa(a,
                    this._week.dow,
                    this._week.doy).week;
      }

      function Yb(){
          return this._week.dow;
      }

      function Zb(){
          return this._week.doy;
      }

      function $b(a){
          var b = this.localeData()
                      .week(this);
          return null == a
                  ? b
                  : this.add(7*(a-b),
                             "d");
      }

      function _b(a){
          var b = wa(this,
                     1,
                     4).week;
          return null == a
                  ? b
                  : this.add(7*(a-b),
                             "d");
      }

      function ac(a,
                  b){
          return "string" != typeof a
                  ? a
                  : isNaN(a)
                          ? (a = b.weekdaysParse(a), "number" == typeof a
                                  ? a
                                  : null)
                          : parseInt(a,
                                     10);
      }

      function bc(a,
                  b){
          return c(this._weekdays)
                  ? this._weekdays[a.day()]
                  : this._weekdays[this._weekdays.isFormat.test(b)
                          ? "format"
                          : "standalone"][a.day()];
      }

      function cc(a){
          return this._weekdaysShort[a.day()];
      }

      function dc(a){
          return this._weekdaysMin[a.day()];
      }

      function ec(a,
                  b,
                  c){
          var d,
              e,
              f,
              g = a.toLocaleLowerCase();
          if (!this._weekdaysParse){
              for (this._weekdaysParse = [], this._shortWeekdaysParse = [], this._minWeekdaysParse = [], d = 0; 7>d; ++d){
                  f = h([2e3,
                         1])
                  .day(d), this._minWeekdaysParse[d] = this.weekdaysMin(f,
                                                                        "")
                                                           .toLocaleLowerCase(), this._shortWeekdaysParse[d] = this.weekdaysShort(f,
                                                                                                                                  "")
                                                                                                                   .toLocaleLowerCase(), this._weekdaysParse[d] = this.weekdays(f,
                                                                                                                                                                                "")
                                                                                                                                                                      .toLocaleLowerCase();
              }
          }
          return c
                  ? "dddd" === b
                          ? (e = md.call(this._weekdaysParse,
                                         g), -1 !== e
                                  ? e
                                  : null)
                          : "ddd" === b
                                  ? (e = md.call(this._shortWeekdaysParse,
                                                 g), -1 !== e
                                          ? e
                                          : null)
                                  : (e = md.call(this._minWeekdaysParse,
                                                 g), -1 !== e
                                          ? e
                                          : null)
                  : "dddd" === b
                          ? (e = md.call(this._weekdaysParse,
                                         g), -1 !== e
                                  ? e
                                  : (e = md.call(this._shortWeekdaysParse,
                                                 g), -1 !== e
                                          ? e
                                          : (e = md.call(this._minWeekdaysParse,
                                                         g), -1 !== e
                                                  ? e
                                                  : null)))
                          : "ddd" === b
                                  ? (e = md.call(this._shortWeekdaysParse,
                                                 g), -1 !== e
                                          ? e
                                          : (e = md.call(this._weekdaysParse,
                                                         g), -1 !== e
                                                  ? e
                                                  : (e = md.call(this._minWeekdaysParse,
                                                                 g), -1 !== e
                                                          ? e
                                                          : null)))
                                  : (e = md.call(this._minWeekdaysParse,
                                                 g), -1 !== e
                                          ? e
                                          : (e = md.call(this._weekdaysParse,
                                                         g), -1 !== e
                                                  ? e
                                                  : (e = md.call(this._shortWeekdaysParse,
                                                                 g), -1 !== e
                                                          ? e
                                                          : null)));
      }

      function fc(a,
                  b,
                  c){
          var d,
              e,
              f;
          if (this._weekdaysParseExact){
              return ec.call(this,
                             a,
                             b,
                             c);
          }
          for (this._weekdaysParse || (this._weekdaysParse = [], this._minWeekdaysParse = [], this._shortWeekdaysParse = [], this._fullWeekdaysParse = []), d = 0; 7>d; d++){
              if (e = h([2e3,
                         1])
              .day(d), c && !this._fullWeekdaysParse[d] && (this._fullWeekdaysParse[d] = new RegExp("^"+this.weekdays(e,
                                                                                                                      "")
                                                                                                            .replace(".",
                                                                                                                     ".?")+"$",
                                                                                                    "i"), this._shortWeekdaysParse[d] = new RegExp("^"+this.weekdaysShort(e,
                                                                                                                                                                          "")
                                                                                                                                                           .replace(".",
                                                                                                                                                                    ".?")+"$",
                                                                                                                                                   "i"), this._minWeekdaysParse[d] = new RegExp("^"+this.weekdaysMin(e,
                                                                                                                                                                                                                     "")
                                                                                                                                                                                                        .replace(".",
                                                                                                                                                                                                                 ".?")+"$",
                                                                                                                                                                                                "i")), this._weekdaysParse[d] || (f = "^"+this.weekdays(e,
                                                                                                                                                                                                                                                        "")+"|^"+this.weekdaysShort(e,
                                                                                                                                                                                                                                                                                    "")+"|^"+this.weekdaysMin(e,
                                                                                                                                                                                                                                                                                                              ""), this._weekdaysParse[d] = new RegExp(f.replace(".",
                                                                                                                                                                                                                                                                                                                                                                 ""),
                                                                                                                                                                                                                                                                                                                                                       "i")), c && "dddd" === b && this._fullWeekdaysParse[d].test(a)){
                  return d;
              }
              if (c && "ddd" === b && this._shortWeekdaysParse[d].test(a)){
                  return d;
              }
              if (c && "dd" === b && this._minWeekdaysParse[d].test(a)){
                  return d;
              }
              if (!c && this._weekdaysParse[d].test(a)){
                  return d;
              }
          }
      }

      function gc(a){
          if (!this.isValid()){
              return null != a
                      ? this
                      : NaN;
          }
          var b = this._isUTC
                  ? this._d.getUTCDay()
                  : this._d.getDay();
          return null != a
                  ? (a = ac(a,
                            this.localeData()), this.add(a-b,
                                                         "d"))
                  : b;
      }

      function hc(a){
          if (!this.isValid()){
              return null != a
                      ? this
                      : NaN;
          }
          var b = (this.day()+7-this.localeData()._week.dow)%7;
          return null == a
                  ? b
                  : this.add(a-b,
                             "d");
      }

      function ic(a){
          return this.isValid()
                  ? null == a
                          ? this.day() || 7
                          : this.day(this.day()%7
                                             ? a
                                             : a-7)
                  : null != a
                          ? this
                          : NaN;
      }

      function jc(a){
          return this._weekdaysParseExact
                  ? (f(this,
                       "_weekdaysRegex") || mc.call(this), a
                          ? this._weekdaysStrictRegex
                          : this._weekdaysRegex)
                  : this._weekdaysStrictRegex && a
                          ? this._weekdaysStrictRegex
                          : this._weekdaysRegex;
      }

      function kc(a){
          return this._weekdaysParseExact
                  ? (f(this,
                       "_weekdaysRegex") || mc.call(this), a
                          ? this._weekdaysShortStrictRegex
                          : this._weekdaysShortRegex)
                  : this._weekdaysShortStrictRegex && a
                          ? this._weekdaysShortStrictRegex
                          : this._weekdaysShortRegex;
      }

      function lc(a){
          return this._weekdaysParseExact
                  ? (f(this,
                       "_weekdaysRegex") || mc.call(this), a
                          ? this._weekdaysMinStrictRegex
                          : this._weekdaysMinRegex)
                  : this._weekdaysMinStrictRegex && a
                          ? this._weekdaysMinStrictRegex
                          : this._weekdaysMinRegex;
      }

      function mc(){
          function a(a,
                     b){
              return b.length-a.length;
          }

          var b,
              c,
              d,
              e,
              f,
              g = [],
              i = [],
              j = [],
              k = [];
          for (b = 0; 7>b; b++){
              c = h([2e3,
                     1])
              .day(b), d = this.weekdaysMin(c,
                                            ""), e = this.weekdaysShort(c,
                                                                        ""), f = this.weekdays(c,
                                                                                               ""), g.push(d), i.push(e), j.push(f), k.push(d), k.push(e), k.push(f);
          }
          for (g.sort(a), i.sort(a), j.sort(a), k.sort(a), b = 0; 7>b; b++){
              i[b] = Z(i[b]), j[b] = Z(j[b]), k[b] = Z(k[b]);
          }
          this._weekdaysRegex = new RegExp("^("+k.join("|")+")",
                                           "i"), this._weekdaysShortRegex = this._weekdaysRegex, this._weekdaysMinRegex = this._weekdaysRegex, this._weekdaysStrictRegex = new RegExp("^("+j.join("|")+")",
                                                                                                                                                                                      "i"), this._weekdaysShortStrictRegex = new RegExp("^("+i.join("|")+")",
                                                                                                                                                                                                                                        "i"), this._weekdaysMinStrictRegex = new RegExp("^("+g.join("|")+")",
                                                                                                                                                                                                                                                                                        "i");
      }

      function nc(a){
          var b = Math.round((this.clone()
                                  .startOf("day")-this.clone()
                                                      .startOf("year"))/864e5)+1;
          return null == a
                  ? b
                  : this.add(a-b,
                             "d");
      }

      function oc(){
          return this.hours()%12 || 12;
      }

      function pc(){
          return this.hours() || 24;
      }

      function qc(a,
                  b){
          R(a,
            0,
            0,
            function(){
                return this.localeData()
                           .meridiem(this.hours(),
                                     this.minutes(),
                                     b);
            });
      }

      function rc(a,
                  b){
          return b._meridiemParse;
      }

      function sc(a){
          return "p" === (a+"").toLowerCase()
                               .charAt(0);
      }

      function tc(a,
                  b,
                  c){
          return a>11
                  ? c
                          ? "pm"
                          : "PM"
                  : c
                          ? "am"
                          : "AM";
      }

      function uc(a,
                  b){
          b[Sd] = r(1e3*("0."+a));
      }

      function vc(){
          return this._isUTC
                  ? "UTC"
                  : "";
      }

      function wc(){
          return this._isUTC
                  ? "Coordinated Universal Time"
                  : "";
      }

      function xc(a){
          return Ka(1e3*a);
      }

      function yc(){
          return Ka.apply(null,
                          arguments)
                   .parseZone();
      }

      function zc(a,
                  b,
                  c){
          var d = this._calendar[a];
          return w(d)
                  ? d.call(b,
                           c)
                  : d;
      }

      function Ac(a){
          var b = this._longDateFormat[a],
              c = this._longDateFormat[a.toUpperCase()];
          return b || !c
                  ? b
                  : (this._longDateFormat[a] = c.replace(/MMMM|MM|DD|dddd/g,
                                                         function(a){
                                                             return a.slice(1);
                                                         }), this._longDateFormat[a]);
      }

      function Bc(){
          return this._invalidDate;
      }

      function Cc(a){
          return this._ordinal.replace("%d",
                                       a);
      }

      function Dc(a){
          return a;
      }

      function Ec(a,
                  b,
                  c,
                  d){
          var e = this._relativeTime[c];
          return w(e)
                  ? e(a,
                      b,
                      c,
                      d)
                  : e.replace(/%d/i,
                              a);
      }

      function Fc(a,
                  b){
          var c = this._relativeTime[a>0
                  ? "future"
                  : "past"];
          return w(c)
                  ? c(b)
                  : c.replace(/%s/i,
                              b);
      }

      function Gc(a,
                  b,
                  c,
                  d){
          var e = H(),
              f = h()
              .set(d,
                   b);
          return e[c](f,
                      a);
      }

      function Hc(a,
                  b,
                  c){
          if ("number" == typeof a && (b = a, a = void 0), a = a || "", null != b){
              return Gc(a,
                        b,
                        c,
                        "month");
          }
          var d,
              e = [];
          for (d = 0; 12>d; d++){
              e[d] = Gc(a,
                        d,
                        c,
                        "month");
          }
          return e;
      }

      function Ic(a,
                  b,
                  c,
                  d){
          "boolean" == typeof a
                  ? ("number" == typeof b && (c = b, b = void 0), b = b || "")
                  : (b = a, c = b, a = !1, "number" == typeof b && (c = b, b = void 0), b = b || "");
          var e = H(),
              f = a
                      ? e._week.dow
                      : 0;
          if (null != c){
              return Gc(b,
                        (c+f)%7,
                        d,
                        "day");
          }
          var g,
              h = [];
          for (g = 0; 7>g; g++){
              h[g] = Gc(b,
                        (g+f)%7,
                        d,
                        "day");
          }
          return h;
      }

      function Jc(a,
                  b){
          return Hc(a,
                    b,
                    "months");
      }

      function Kc(a,
                  b){
          return Hc(a,
                    b,
                    "monthsShort");
      }

      function Lc(a,
                  b,
                  c){
          return Ic(a,
                    b,
                    c,
                    "weekdays");
      }

      function Mc(a,
                  b,
                  c){
          return Ic(a,
                    b,
                    c,
                    "weekdaysShort");
      }

      function Nc(a,
                  b,
                  c){
          return Ic(a,
                    b,
                    c,
                    "weekdaysMin");
      }

      function Oc(){
          var a = this._data;
          return this._milliseconds = Le(this._milliseconds), this._days = Le(this._days), this._months = Le(this._months), a.milliseconds = Le(a.milliseconds), a.seconds = Le(a.seconds), a.minutes = Le(a.minutes), a.hours = Le(a.hours), a.months = Le(a.months), a.years = Le(a.years), this;
      }

      function Pc(a,
                  b,
                  c,
                  d){
          var e = db(b,
                     c);
          return a._milliseconds += d*e._milliseconds, a._days += d*e._days, a._months += d*e._months, a._bubble();
      }

      function Qc(a,
                  b){
          return Pc(this,
                    a,
                    b,
                    1);
      }

      function Rc(a,
                  b){
          return Pc(this,
                    a,
                    b,
                    -1);
      }

      function Sc(a){
          return 0>a
                  ? Math.floor(a)
                  : Math.ceil(a);
      }

      function Tc(){
          var a,
              b,
              c,
              d,
              e,
              f = this._milliseconds,
              g = this._days,
              h = this._months,
              i = this._data;
          return f>=0 && g>=0 && h>=0 || 0>=f && 0>=g && 0>=h || (f += 864e5*Sc(Vc(h)+g), g = 0, h = 0), i.milliseconds = f%1e3, a = q(f/1e3), i.seconds = a%60, b = q(a/60), i.minutes = b%60, c = q(b/60), i.hours = c%24, g += q(c/24), e = q(Uc(g)), h += e, g -= Sc(Vc(e)), d = q(h/12), h %= 12, i.days = g, i.months = h, i.years = d, this;
      }

      function Uc(a){
          return 4800*a/146097;
      }

      function Vc(a){
          return 146097*a/4800;
      }

      function Wc(a){
          var b,
              c,
              d = this._milliseconds;
          if (a = K(a), "month" === a || "year" === a){
              return b = this._days+d/864e5, c = this._months+Uc(b), "month" === a
                      ? c
                      : c/12;
          }
          switch (b = this._days+Math.round(Vc(this._months)), a){
              case"week":
                  return b/7+d/6048e5;
              case"day":
                  return b+d/864e5;
              case"hour":
                  return 24*b+d/36e5;
              case"minute":
                  return 1440*b+d/6e4;
              case"second":
                  return 86400*b+d/1e3;
              case"millisecond":
                  return Math.floor(864e5*b)+d;
              default:
                  throw new Error("Unknown unit "+a);
          }
      }

      function Xc(){
          return this._milliseconds+864e5*this._days+this._months%12*2592e6+31536e6*r(this._months/12);
      }

      function Yc(a){
          return function(){
              return this.as(a);
          };
      }

      function Zc(a){
          return a = K(a), this[a+"s"]();
      }

      function $c(a){
          return function(){
              return this._data[a];
          };
      }

      function _c(){
          return q(this.days()/7);
      }

      function ad(a,
                  b,
                  c,
                  d,
                  e){
          return e.relativeTime(b || 1,
                                !!c,
                                a,
                                d);
      }

      function bd(a,
                  b,
                  c){
          var d = db(a)
              .abs(),
              e = _e(d.as("s")),
              f = _e(d.as("m")),
              g = _e(d.as("h")),
              h = _e(d.as("d")),
              i = _e(d.as("M")),
              j = _e(d.as("y")),
              k = e<af.s && ["s",
                             e] || 1>=f && ["m"] || f<af.m && ["mm",
                                                               f] || 1>=g && ["h"] || g<af.h && ["hh",
                                                                                                 g] || 1>=h && ["d"] || h<af.d && ["dd",
                                                                                                                                   h] || 1>=i && ["M"] || i<af.M && ["MM",
                                                                                                                                                                     i] || 1>=j && ["y"] || ["yy",
                                                                                                                                                                                             j];
          return k[2] = b, k[3] = +a>0, k[4] = c, ad.apply(null,
                                                           k);
      }

      function cd(a,
                  b){
          return void 0 === af[a]
                  ? !1
                  : void 0 === b
                          ? af[a]
                          : (af[a] = b, !0);
      }

      function dd(a){
          var b = this.localeData(),
              c = bd(this,
                     !a,
                     b);
          return a && (c = b.pastFuture(+this,
                                        c)), b.postformat(c);
      }

      function ed(){
          var a,
              b,
              c,
              d = bf(this._milliseconds)/1e3,
              e = bf(this._days),
              f = bf(this._months);
          a = q(d/60), b = q(a/60), d %= 60, a %= 60, c = q(f/12), f %= 12;
          var g = c,
              h = f,
              i = e,
              j = b,
              k = a,
              l = d,
              m = this.asSeconds();
          return m
                  ? (0>m
                  ? "-"
                  : "")+"P"+(g
                  ? g+"Y"
                  : "")+(h
                  ? h+"M"
                  : "")+(i
                  ? i+"D"
                  : "")+(j || k || l
                  ? "T"
                  : "")+(j
                  ? j+"H"
                  : "")+(k
                  ? k+"M"
                  : "")+(l
                  ? l+"S"
                  : "")
                  : "P0D";
      }

      var fd,
          gd;
      gd = Array.prototype.some
              ? Array.prototype.some
              : function(a){
                  for (var b = Object(this), c = b.length>>>0, d = 0; c>d; d++){
                      if (d in b && a.call(this,
                                           b[d],
                                           d,
                                           b)){
                          return !0;
                      }
                  }
                  return !1;
              };
      var hd = a.momentProperties = [],
          id = !1,
          jd = {};
      a.suppressDeprecationWarnings = !1, a.deprecationHandler = null;
      var kd;
      kd = Object.keys
              ? Object.keys
              : function(a){
                  var b,
                      c = [];
                  for (b in a){
                      f(a,
                        b) && c.push(b);
                  }
                  return c;
              };
      var ld,
          md,
          nd = {},
          od = {},
          pd = /(\[[^\[]*\])|(\\)?([Hh]mm(ss)?|Mo|MM?M?M?|Do|DDDo|DD?D?D?|ddd?d?|do?|w[o|w]?|W[o|W]?|Qo?|YYYYYY|YYYYY|YYYY|YY|gg(ggg?)?|GG(GGG?)?|e|E|a|A|hh?|HH?|kk?|mm?|ss?|S{1,9}|x|X|zz?|ZZ?|.)/g,
          qd = /(\[[^\[]*\])|(\\)?(LTS|LT|LL?L?L?|l{1,4})/g,
          rd = {},
          sd = {},
          td = /\d/,
          ud = /\d\d/,
          vd = /\d{3}/,
          wd = /\d{4}/,
          xd = /[+-]?\d{6}/,
          yd = /\d\d?/,
          zd = /\d\d\d\d?/,
          Ad = /\d\d\d\d\d\d?/,
          Bd = /\d{1,3}/,
          Cd = /\d{1,4}/,
          Dd = /[+-]?\d{1,6}/,
          Ed = /\d+/,
          Fd = /[+-]?\d+/,
          Gd = /Z|[+-]\d\d:?\d\d/gi,
          Hd = /Z|[+-]\d\d(?::?\d\d)?/gi,
          Id = /[+-]?\d+(\.\d{1,3})?/,
          Jd = /[0-9]*['a-z\u00A0-\u05FF\u0700-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+|[\u0600-\u06FF\/]+(\s*?[\u0600-\u06FF]+){1,2}/i,
          Kd = {},
          Ld = {},
          Md = 0,
          Nd = 1,
          Od = 2,
          Pd = 3,
          Qd = 4,
          Rd = 5,
          Sd = 6,
          Td = 7,
          Ud = 8;
      md = Array.prototype.indexOf
              ? Array.prototype.indexOf
              : function(a){
                  var b;
                  for (b = 0; b<this.length; ++b){
                      if (this[b] === a){
                          return b;
                      }
                  }
                  return -1;
              }, R("M",
                   ["MM",
                    2],
                   "Mo",
                   function(){
                       return this.month()+1;
                   }), R("MMM",
                         0,
                         0,
                         function(a){
                             return this.localeData()
                                        .monthsShort(this,
                                                     a);
                         }), R("MMMM",
                               0,
                               0,
                               function(a){
                                   return this.localeData()
                                              .months(this,
                                                      a);
                               }), J("month",
                                     "M"), W("M",
                                             yd), W("MM",
                                                    yd,
                                                    ud), W("MMM",
                                                           function(a,
                                                                    b){
                                                               return b.monthsShortRegex(a);
                                                           }), W("MMMM",
                                                                 function(a,
                                                                          b){
                                                                     return b.monthsRegex(a);
                                                                 }), $(["M",
                                                                        "MM"],
                                                                       function(a,
                                                                                b){
                                                                           b[Nd] = r(a)-1;
                                                                       }), $(["MMM",
                                                                              "MMMM"],
                                                                             function(a,
                                                                                      b,
                                                                                      c,
                                                                                      d){
                                                                                 var e = c._locale.monthsParse(a,
                                                                                                               d,
                                                                                                               c._strict);
                                                                                 null != e
                                                                                         ? b[Nd] = e
                                                                                         : j(c).invalidMonth = a;
                                                                             });
      var Vd = /D[oD]?(\[[^\[\]]*\]|\s+)+MMMM?/,
          Wd = "January_February_March_April_May_June_July_August_September_October_November_December".split("_"),
          Xd = "Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec".split("_"),
          Yd = Jd,
          Zd = Jd,
          $d = /^\s*((?:[+-]\d{6}|\d{4})-(?:\d\d-\d\d|W\d\d-\d|W\d\d|\d\d\d|\d\d))(?:(T| )(\d\d(?::\d\d(?::\d\d(?:[.,]\d+)?)?)?)([\+\-]\d\d(?::?\d\d)?|\s*Z)?)?/,
          _d = /^\s*((?:[+-]\d{6}|\d{4})(?:\d\d\d\d|W\d\d\d|W\d\d|\d\d\d|\d\d))(?:(T| )(\d\d(?:\d\d(?:\d\d(?:[.,]\d+)?)?)?)([\+\-]\d\d(?::?\d\d)?|\s*Z)?)?/,
          ae = /Z|[+-]\d\d(?::?\d\d)?/,
          be = [["YYYYYY-MM-DD",
                 /[+-]\d{6}-\d\d-\d\d/],
                ["YYYY-MM-DD",
                 /\d{4}-\d\d-\d\d/],
                ["GGGG-[W]WW-E",
                 /\d{4}-W\d\d-\d/],
                ["GGGG-[W]WW",
                 /\d{4}-W\d\d/,
                 !1],
                ["YYYY-DDD",
                 /\d{4}-\d{3}/],
                ["YYYY-MM",
                 /\d{4}-\d\d/,
                 !1],
                ["YYYYYYMMDD",
                 /[+-]\d{10}/],
                ["YYYYMMDD",
                 /\d{8}/],
                ["GGGG[W]WWE",
                 /\d{4}W\d{3}/],
                ["GGGG[W]WW",
                 /\d{4}W\d{2}/,
                 !1],
                ["YYYYDDD",
                 /\d{7}/]],
          ce = [["HH:mm:ss.SSSS",
                 /\d\d:\d\d:\d\d\.\d+/],
                ["HH:mm:ss,SSSS",
                 /\d\d:\d\d:\d\d,\d+/],
                ["HH:mm:ss",
                 /\d\d:\d\d:\d\d/],
                ["HH:mm",
                 /\d\d:\d\d/],
                ["HHmmss.SSSS",
                 /\d\d\d\d\d\d\.\d+/],
                ["HHmmss,SSSS",
                 /\d\d\d\d\d\d,\d+/],
                ["HHmmss",
                 /\d\d\d\d\d\d/],
                ["HHmm",
                 /\d\d\d\d/],
                ["HH",
                 /\d\d/]],
          de = /^\/?Date\((\-?\d+)/i;
      a.createFromInputFallback = u("moment construction falls back to js Date. This is discouraged and will be removed in upcoming major release. Please refer to https://github.com/moment/moment/issues/1407 for more info.",
                                    function(a){
                                        a._d = new Date(a._i+(a._useUTC
                                                ? " UTC"
                                                : ""));
                                    }), R("Y",
                                          0,
                                          0,
                                          function(){
                                              var a = this.year();
                                              return 9999>=a
                                                      ? ""+a
                                                      : "+"+a;
                                          }), R(0,
                                                ["YY",
                                                 2],
                                                0,
                                                function(){
                                                    return this.year()%100;
                                                }), R(0,
                                                      ["YYYY",
                                                       4],
                                                      0,
                                                      "year"), R(0,
                                                                 ["YYYYY",
                                                                  5],
                                                                 0,
                                                                 "year"), R(0,
                                                                            ["YYYYYY",
                                                                             6,
                                                                             !0],
                                                                            0,
                                                                            "year"), J("year",
                                                                                       "y"), W("Y",
                                                                                               Fd), W("YY",
                                                                                                      yd,
                                                                                                      ud), W("YYYY",
                                                                                                             Cd,
                                                                                                             wd), W("YYYYY",
                                                                                                                    Dd,
                                                                                                                    xd), W("YYYYYY",
                                                                                                                           Dd,
                                                                                                                           xd), $(["YYYYY",
                                                                                                                                   "YYYYYY"],
                                                                                                                                  Md), $("YYYY",
                                                                                                                                         function(b,
                                                                                                                                                  c){
                                                                                                                                             c[Md] = 2 === b.length
                                                                                                                                                     ? a.parseTwoDigitYear(b)
                                                                                                                                                     : r(b);
                                                                                                                                         }), $("YY",
                                                                                                                                               function(b,
                                                                                                                                                        c){
                                                                                                                                                   c[Md] = a.parseTwoDigitYear(b);
                                                                                                                                               }), $("Y",
                                                                                                                                                     function(a,
                                                                                                                                                              b){
                                                                                                                                                         b[Md] = parseInt(a,
                                                                                                                                                                          10);
                                                                                                                                                     }), a.parseTwoDigitYear = function(a){
          return r(a)+(r(a)>68
                  ? 1900
                  : 2e3);
      };
      var ee = M("FullYear",
                 !0);
      a.ISO_8601 = function(){
      };
      var fe = u("moment().min is deprecated, use moment.max instead. https://github.com/moment/moment/issues/1548",
                 function(){
                     var a = Ka.apply(null,
                                      arguments);
                     return this.isValid() && a.isValid()
                             ? this>a
                                     ? this
                                     : a
                             : l();
                 }),
          ge = u("moment().max is deprecated, use moment.min instead. https://github.com/moment/moment/issues/1548",
                 function(){
                     var a = Ka.apply(null,
                                      arguments);
                     return this.isValid() && a.isValid()
                             ? a>this
                                     ? this
                                     : a
                             : l();
                 }),
          he = function(){
              return Date.now
                      ? Date.now()
                      : +new Date;
          };
      Qa("Z",
         ":"), Qa("ZZ",
                  ""), W("Z",
                         Hd), W("ZZ",
                                Hd), $(["Z",
                                        "ZZ"],
                                       function(a,
                                                b,
                                                c){
                                           c._useUTC = !0, c._tzm = Ra(Hd,
                                                                       a);
                                       });
      var ie = /([\+\-]|\d\d)/gi;
      a.updateOffset = function(){
      };
      var je = /^(\-)?(?:(\d*)[. ])?(\d+)\:(\d+)(?:\:(\d+)\.?(\d{3})?\d*)?$/,
          ke = /^(-)?P(?:(-?[0-9,.]*)Y)?(?:(-?[0-9,.]*)M)?(?:(-?[0-9,.]*)W)?(?:(-?[0-9,.]*)D)?(?:T(?:(-?[0-9,.]*)H)?(?:(-?[0-9,.]*)M)?(?:(-?[0-9,.]*)S)?)?$/;
      db.fn = Oa.prototype;
      var le = ib(1,
                  "add"),
          me = ib(-1,
                  "subtract");
      a.defaultFormat = "YYYY-MM-DDTHH:mm:ssZ", a.defaultFormatUtc = "YYYY-MM-DDTHH:mm:ss[Z]";
      var ne = u("moment().lang() is deprecated. Instead, use moment().localeData() to get the language configuration. Use moment().locale() to change languages.",
                 function(a){
                     return void 0 === a
                             ? this.localeData()
                             : this.locale(a);
                 });
      R(0,
        ["gg",
         2],
        0,
        function(){
            return this.weekYear()%100;
        }), R(0,
              ["GG",
               2],
              0,
              function(){
                  return this.isoWeekYear()%100;
              }), Pb("gggg",
                     "weekYear"), Pb("ggggg",
                                     "weekYear"), Pb("GGGG",
                                                     "isoWeekYear"), Pb("GGGGG",
                                                                        "isoWeekYear"), J("weekYear",
                                                                                          "gg"), J("isoWeekYear",
                                                                                                   "GG"), W("G",
                                                                                                            Fd), W("g",
                                                                                                                   Fd), W("GG",
                                                                                                                          yd,
                                                                                                                          ud), W("gg",
                                                                                                                                 yd,
                                                                                                                                 ud), W("GGGG",
                                                                                                                                        Cd,
                                                                                                                                        wd), W("gggg",
                                                                                                                                               Cd,
                                                                                                                                               wd), W("GGGGG",
                                                                                                                                                      Dd,
                                                                                                                                                      xd), W("ggggg",
                                                                                                                                                             Dd,
                                                                                                                                                             xd), _(["gggg",
                                                                                                                                                                     "ggggg",
                                                                                                                                                                     "GGGG",
                                                                                                                                                                     "GGGGG"],
                                                                                                                                                                    function(a,
                                                                                                                                                                             b,
                                                                                                                                                                             c,
                                                                                                                                                                             d){
                                                                                                                                                                        b[d.substr(0,
                                                                                                                                                                                   2)] = r(a);
                                                                                                                                                                    }), _(["gg",
                                                                                                                                                                           "GG"],
                                                                                                                                                                          function(b,
                                                                                                                                                                                   c,
                                                                                                                                                                                   d,
                                                                                                                                                                                   e){
                                                                                                                                                                              c[e] = a.parseTwoDigitYear(b);
                                                                                                                                                                          }), R("Q",
                                                                                                                                                                                0,
                                                                                                                                                                                "Qo",
                                                                                                                                                                                "quarter"), J("quarter",
                                                                                                                                                                                              "Q"), W("Q",
                                                                                                                                                                                                      td), $("Q",
                                                                                                                                                                                                             function(a,
                                                                                                                                                                                                                      b){
                                                                                                                                                                                                                 b[Nd] = 3*(r(a)-1);
                                                                                                                                                                                                             }), R("w",
                                                                                                                                                                                                                   ["ww",
                                                                                                                                                                                                                    2],
                                                                                                                                                                                                                   "wo",
                                                                                                                                                                                                                   "week"), R("W",
                                                                                                                                                                                                                              ["WW",
                                                                                                                                                                                                                               2],
                                                                                                                                                                                                                              "Wo",
                                                                                                                                                                                                                              "isoWeek"), J("week",
                                                                                                                                                                                                                                            "w"), J("isoWeek",
                                                                                                                                                                                                                                                    "W"), W("w",
                                                                                                                                                                                                                                                            yd), W("ww",
                                                                                                                                                                                                                                                                   yd,
                                                                                                                                                                                                                                                                   ud), W("W",
                                                                                                                                                                                                                                                                          yd), W("WW",
                                                                                                                                                                                                                                                                                 yd,
                                                                                                                                                                                                                                                                                 ud), _(["w",
                                                                                                                                                                                                                                                                                         "ww",
                                                                                                                                                                                                                                                                                         "W",
                                                                                                                                                                                                                                                                                         "WW"],
                                                                                                                                                                                                                                                                                        function(a,
                                                                                                                                                                                                                                                                                                 b,
                                                                                                                                                                                                                                                                                                 c,
                                                                                                                                                                                                                                                                                                 d){
                                                                                                                                                                                                                                                                                            b[d.substr(0,
                                                                                                                                                                                                                                                                                                       1)] = r(a);
                                                                                                                                                                                                                                                                                        });
      var oe = {
          dow: 0,
          doy: 6
      };
      R("D",
        ["DD",
         2],
        "Do",
        "date"), J("date",
                   "D"), W("D",
                           yd), W("DD",
                                  yd,
                                  ud), W("Do",
                                         function(a,
                                                  b){
                                             return a
                                                     ? b._ordinalParse
                                                     : b._ordinalParseLenient;
                                         }), $(["D",
                                                "DD"],
                                               Od), $("Do",
                                                      function(a,
                                                               b){
                                                          b[Od] = r(a.match(yd)[0],
                                                                    10);
                                                      });
      var pe = M("Date",
                 !0);
      R("d",
        0,
        "do",
        "day"), R("dd",
                  0,
                  0,
                  function(a){
                      return this.localeData()
                                 .weekdaysMin(this,
                                              a);
                  }), R("ddd",
                        0,
                        0,
                        function(a){
                            return this.localeData()
                                       .weekdaysShort(this,
                                                      a);
                        }), R("dddd",
                              0,
                              0,
                              function(a){
                                  return this.localeData()
                                             .weekdays(this,
                                                       a);
                              }), R("e",
                                    0,
                                    0,
                                    "weekday"), R("E",
                                                  0,
                                                  0,
                                                  "isoWeekday"), J("day",
                                                                   "d"), J("weekday",
                                                                           "e"), J("isoWeekday",
                                                                                   "E"), W("d",
                                                                                           yd), W("e",
                                                                                                  yd), W("E",
                                                                                                         yd), W("dd",
                                                                                                                function(a,
                                                                                                                         b){
                                                                                                                    return b.weekdaysMinRegex(a);
                                                                                                                }), W("ddd",
                                                                                                                      function(a,
                                                                                                                               b){
                                                                                                                          return b.weekdaysShortRegex(a);
                                                                                                                      }), W("dddd",
                                                                                                                            function(a,
                                                                                                                                     b){
                                                                                                                                return b.weekdaysRegex(a);
                                                                                                                            }), _(["dd",
                                                                                                                                   "ddd",
                                                                                                                                   "dddd"],
                                                                                                                                  function(a,
                                                                                                                                           b,
                                                                                                                                           c,
                                                                                                                                           d){
                                                                                                                                      var e = c._locale.weekdaysParse(a,
                                                                                                                                                                      d,
                                                                                                                                                                      c._strict);
                                                                                                                                      null != e
                                                                                                                                              ? b.d = e
                                                                                                                                              : j(c).invalidWeekday = a;
                                                                                                                                  }), _(["d",
                                                                                                                                         "e",
                                                                                                                                         "E"],
                                                                                                                                        function(a,
                                                                                                                                                 b,
                                                                                                                                                 c,
                                                                                                                                                 d){
                                                                                                                                            b[d] = r(a);
                                                                                                                                        });
      var qe = "Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday".split("_"),
          re = "Sun_Mon_Tue_Wed_Thu_Fri_Sat".split("_"),
          se = "Su_Mo_Tu_We_Th_Fr_Sa".split("_"),
          te = Jd,
          ue = Jd,
          ve = Jd;
      R("DDD",
        ["DDDD",
         3],
        "DDDo",
        "dayOfYear"), J("dayOfYear",
                        "DDD"), W("DDD",
                                  Bd), W("DDDD",
                                         vd), $(["DDD",
                                                 "DDDD"],
                                                function(a,
                                                         b,
                                                         c){
                                                    c._dayOfYear = r(a);
                                                }), R("H",
                                                      ["HH",
                                                       2],
                                                      0,
                                                      "hour"), R("h",
                                                                 ["hh",
                                                                  2],
                                                                 0,
                                                                 oc), R("k",
                                                                        ["kk",
                                                                         2],
                                                                        0,
                                                                        pc), R("hmm",
                                                                               0,
                                                                               0,
                                                                               function(){
                                                                                   return ""+oc.apply(this)+Q(this.minutes(),
                                                                                                              2);
                                                                               }), R("hmmss",
                                                                                     0,
                                                                                     0,
                                                                                     function(){
                                                                                         return ""+oc.apply(this)+Q(this.minutes(),
                                                                                                                    2)+Q(this.seconds(),
                                                                                                                         2);
                                                                                     }), R("Hmm",
                                                                                           0,
                                                                                           0,
                                                                                           function(){
                                                                                               return ""+this.hours()+Q(this.minutes(),
                                                                                                                        2);
                                                                                           }), R("Hmmss",
                                                                                                 0,
                                                                                                 0,
                                                                                                 function(){
                                                                                                     return ""+this.hours()+Q(this.minutes(),
                                                                                                                              2)+Q(this.seconds(),
                                                                                                                                   2);
                                                                                                 }), qc("a",
                                                                                                        !0), qc("A",
                                                                                                                !1), J("hour",
                                                                                                                       "h"), W("a",
                                                                                                                               rc), W("A",
                                                                                                                                      rc), W("H",
                                                                                                                                             yd), W("h",
                                                                                                                                                    yd), W("HH",
                                                                                                                                                           yd,
                                                                                                                                                           ud), W("hh",
                                                                                                                                                                  yd,
                                                                                                                                                                  ud), W("hmm",
                                                                                                                                                                         zd), W("hmmss",
                                                                                                                                                                                Ad), W("Hmm",
                                                                                                                                                                                       zd), W("Hmmss",
                                                                                                                                                                                              Ad), $(["H",
                                                                                                                                                                                                      "HH"],
                                                                                                                                                                                                     Pd), $(["a",
                                                                                                                                                                                                             "A"],
                                                                                                                                                                                                            function(a,
                                                                                                                                                                                                                     b,
                                                                                                                                                                                                                     c){
                                                                                                                                                                                                                c._isPm = c._locale.isPM(a), c._meridiem = a;
                                                                                                                                                                                                            }), $(["h",
                                                                                                                                                                                                                   "hh"],
                                                                                                                                                                                                                  function(a,
                                                                                                                                                                                                                           b,
                                                                                                                                                                                                                           c){
                                                                                                                                                                                                                      b[Pd] = r(a), j(c).bigHour = !0;
                                                                                                                                                                                                                  }), $("hmm",
                                                                                                                                                                                                                        function(a,
                                                                                                                                                                                                                                 b,
                                                                                                                                                                                                                                 c){
                                                                                                                                                                                                                            var d = a.length-2;
                                                                                                                                                                                                                            b[Pd] = r(a.substr(0,
                                                                                                                                                                                                                                               d)), b[Qd] = r(a.substr(d)), j(c).bigHour = !0;
                                                                                                                                                                                                                        }), $("hmmss",
                                                                                                                                                                                                                              function(a,
                                                                                                                                                                                                                                       b,
                                                                                                                                                                                                                                       c){
                                                                                                                                                                                                                                  var d = a.length-4,
                                                                                                                                                                                                                                      e = a.length-2;
                                                                                                                                                                                                                                  b[Pd] = r(a.substr(0,
                                                                                                                                                                                                                                                     d)), b[Qd] = r(a.substr(d,
                                                                                                                                                                                                                                                                             2)), b[Rd] = r(a.substr(e)), j(c).bigHour = !0;
                                                                                                                                                                                                                              }), $("Hmm",
                                                                                                                                                                                                                                    function(a,
                                                                                                                                                                                                                                             b,
                                                                                                                                                                                                                                             c){
                                                                                                                                                                                                                                        var d = a.length-2;
                                                                                                                                                                                                                                        b[Pd] = r(a.substr(0,
                                                                                                                                                                                                                                                           d)), b[Qd] = r(a.substr(d));
                                                                                                                                                                                                                                    }), $("Hmmss",
                                                                                                                                                                                                                                          function(a,
                                                                                                                                                                                                                                                   b,
                                                                                                                                                                                                                                                   c){
                                                                                                                                                                                                                                              var d = a.length-4,
                                                                                                                                                                                                                                                  e = a.length-2;
                                                                                                                                                                                                                                              b[Pd] = r(a.substr(0,
                                                                                                                                                                                                                                                                 d)), b[Qd] = r(a.substr(d,
                                                                                                                                                                                                                                                                                         2)), b[Rd] = r(a.substr(e));
                                                                                                                                                                                                                                          });
      var we = /[ap]\.?m?\.?/i,
          xe = M("Hours",
                 !0);
      R("m",
        ["mm",
         2],
        0,
        "minute"), J("minute",
                     "m"), W("m",
                             yd), W("mm",
                                    yd,
                                    ud), $(["m",
                                            "mm"],
                                           Qd);
      var ye = M("Minutes",
                 !1);
      R("s",
        ["ss",
         2],
        0,
        "second"), J("second",
                     "s"), W("s",
                             yd), W("ss",
                                    yd,
                                    ud), $(["s",
                                            "ss"],
                                           Rd);
      var ze = M("Seconds",
                 !1);
      R("S",
        0,
        0,
        function(){
            return ~~(this.millisecond()/100);
        }), R(0,
              ["SS",
               2],
              0,
              function(){
                  return ~~(this.millisecond()/10);
              }), R(0,
                    ["SSS",
                     3],
                    0,
                    "millisecond"), R(0,
                                      ["SSSS",
                                       4],
                                      0,
                                      function(){
                                          return 10*this.millisecond();
                                      }), R(0,
                                            ["SSSSS",
                                             5],
                                            0,
                                            function(){
                                                return 100*this.millisecond();
                                            }), R(0,
                                                  ["SSSSSS",
                                                   6],
                                                  0,
                                                  function(){
                                                      return 1e3*this.millisecond();
                                                  }), R(0,
                                                        ["SSSSSSS",
                                                         7],
                                                        0,
                                                        function(){
                                                            return 1e4*this.millisecond();
                                                        }), R(0,
                                                              ["SSSSSSSS",
                                                               8],
                                                              0,
                                                              function(){
                                                                  return 1e5*this.millisecond();
                                                              }), R(0,
                                                                    ["SSSSSSSSS",
                                                                     9],
                                                                    0,
                                                                    function(){
                                                                        return 1e6*this.millisecond();
                                                                    }), J("millisecond",
                                                                          "ms"), W("S",
                                                                                   Bd,
                                                                                   td), W("SS",
                                                                                          Bd,
                                                                                          ud), W("SSS",
                                                                                                 Bd,
                                                                                                 vd);
      var Ae;
      for (Ae = "SSSS"; Ae.length<=9; Ae += "S"){
          W(Ae,
            Ed);
      }
      for (Ae = "S"; Ae.length<=9; Ae += "S"){
          $(Ae,
            uc);
      }
      var Be = M("Milliseconds",
                 !1);
      R("z",
        0,
        0,
        "zoneAbbr"), R("zz",
                       0,
                       0,
                       "zoneName");
      var Ce = o.prototype;
      Ce.add = le, Ce.calendar = kb, Ce.clone = lb, Ce.diff = sb, Ce.endOf = Eb, Ce.format = wb, Ce.from = xb, Ce.fromNow = yb, Ce.to = zb, Ce.toNow = Ab, Ce.get = P, Ce.invalidAt = Nb, Ce.isAfter = mb, Ce.isBefore = nb, Ce.isBetween = ob, Ce.isSame = pb, Ce.isSameOrAfter = qb, Ce.isSameOrBefore = rb, Ce.isValid = Lb, Ce.lang = ne, Ce.locale = Bb, Ce.localeData = Cb, Ce.max = ge, Ce.min = fe, Ce.parsingFlags = Mb, Ce.set = P, Ce.startOf = Db, Ce.subtract = me, Ce.toArray = Ib, Ce.toObject = Jb, Ce.toDate = Hb, Ce.toISOString = vb, Ce.toJSON = Kb, Ce.toString = ub, Ce.unix = Gb, Ce.valueOf = Fb, Ce.creationData = Ob, Ce.year = ee, Ce.isLeapYear = ta, Ce.weekYear = Qb, Ce.isoWeekYear = Rb, Ce.quarter = Ce.quarters = Wb, Ce.month = ha, Ce.daysInMonth = ia, Ce.week = Ce.weeks = $b, Ce.isoWeek = Ce.isoWeeks = _b, Ce.weeksInYear = Tb, Ce.isoWeeksInYear = Sb, Ce.date = pe, Ce.day = Ce.days = gc, Ce.weekday = hc, Ce.isoWeekday = ic, Ce.dayOfYear = nc, Ce.hour = Ce.hours = xe, Ce.minute = Ce.minutes = ye, Ce.second = Ce.seconds = ze, Ce.millisecond = Ce.milliseconds = Be, Ce.utcOffset = Ua, Ce.utc = Wa, Ce.local = Xa, Ce.parseZone = Ya, Ce.hasAlignedHourOffset = Za, Ce.isDST = $a, Ce.isDSTShifted = _a, Ce.isLocal = ab, Ce.isUtcOffset = bb, Ce.isUtc = cb, Ce.isUTC = cb, Ce.zoneAbbr = vc, Ce.zoneName = wc, Ce.dates = u("dates accessor is deprecated. Use date instead.",
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         pe), Ce.months = u("months accessor is deprecated. Use month instead",
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ha), Ce.years = u("years accessor is deprecated. Use year instead",
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              ee), Ce.zone = u("moment().zone is deprecated, use moment().utcOffset instead. https://github.com/moment/moment/issues/1779",
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               Va);
      var De = Ce,
          Ee = {
              sameDay : "[Today at] LT",
              nextDay : "[Tomorrow at] LT",
              nextWeek: "dddd [at] LT",
              lastDay : "[Yesterday at] LT",
              lastWeek: "[Last] dddd [at] LT",
              sameElse: "L"
          },
          Fe = {
              LTS : "h:mm:ss A",
              LT  : "h:mm A",
              L   : "MM/DD/YYYY",
              LL  : "MMMM D, YYYY",
              LLL : "MMMM D, YYYY h:mm A",
              LLLL: "dddd, MMMM D, YYYY h:mm A"
          },
          Ge = "Invalid date",
          He = "%d",
          Ie = /\d{1,2}/,
          Je = {
              future: "in %s",
              past  : "%s ago",
              s     : "a few seconds",
              m     : "a minute",
              mm    : "%d minutes",
              h     : "an hour",
              hh    : "%d hours",
              d     : "a day",
              dd    : "%d days",
              M     : "a month",
              MM    : "%d months",
              y     : "a year",
              yy    : "%d years"
          },
          Ke = A.prototype;
      Ke._calendar = Ee, Ke.calendar = zc, Ke._longDateFormat = Fe, Ke.longDateFormat = Ac, Ke._invalidDate = Ge, Ke.invalidDate = Bc, Ke._ordinal = He, Ke.ordinal = Cc, Ke._ordinalParse = Ie, Ke.preparse = Dc, Ke.postformat = Dc, Ke._relativeTime = Je, Ke.relativeTime = Ec, Ke.pastFuture = Fc, Ke.set = y, Ke.months = ca, Ke._months = Wd, Ke.monthsShort = da, Ke._monthsShort = Xd, Ke.monthsParse = fa, Ke._monthsRegex = Zd, Ke.monthsRegex = ka, Ke._monthsShortRegex = Yd, Ke.monthsShortRegex = ja, Ke.week = Xb, Ke._week = oe, Ke.firstDayOfYear = Zb, Ke.firstDayOfWeek = Yb, Ke.weekdays = bc, Ke._weekdays = qe, Ke.weekdaysMin = dc, Ke._weekdaysMin = se, Ke.weekdaysShort = cc, Ke._weekdaysShort = re, Ke.weekdaysParse = fc, Ke._weekdaysRegex = te, Ke.weekdaysRegex = jc, Ke._weekdaysShortRegex = ue, Ke.weekdaysShortRegex = kc, Ke._weekdaysMinRegex = ve, Ke.weekdaysMinRegex = lc, Ke.isPM = sc, Ke._meridiemParse = we, Ke.meridiem = tc, E("en",
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   ordinalParse: /\d{1,2}(th|st|nd|rd)/,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   ordinal     : function(a){
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       var b = a%10,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           c = 1 === r(a%100/10)
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   ? "th"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   : 1 === b
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           ? "st"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           : 2 === b
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   ? "nd"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   : 3 === b
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           ? "rd"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           : "th";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       return a+c;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               }), a.lang = u("moment.lang is deprecated. Use moment.locale instead.",
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              E), a.langData = u("moment.langData is deprecated. Use moment.localeData instead.",
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 H);
      var Le = Math.abs,
          Me = Yc("ms"),
          Ne = Yc("s"),
          Oe = Yc("m"),
          Pe = Yc("h"),
          Qe = Yc("d"),
          Re = Yc("w"),
          Se = Yc("M"),
          Te = Yc("y"),
          Ue = $c("milliseconds"),
          Ve = $c("seconds"),
          We = $c("minutes"),
          Xe = $c("hours"),
          Ye = $c("days"),
          Ze = $c("months"),
          $e = $c("years"),
          _e = Math.round,
          af = {
              s: 45,
              m: 45,
              h: 22,
              d: 26,
              M: 11
          },
          bf = Math.abs,
          cf = Oa.prototype;
      cf.abs = Oc, cf.add = Qc, cf.subtract = Rc, cf.as = Wc, cf.asMilliseconds = Me, cf.asSeconds = Ne, cf.asMinutes = Oe, cf.asHours = Pe, cf.asDays = Qe, cf.asWeeks = Re, cf.asMonths = Se, cf.asYears = Te, cf.valueOf = Xc, cf._bubble = Tc, cf.get = Zc, cf.milliseconds = Ue, cf.seconds = Ve, cf.minutes = We, cf.hours = Xe, cf.days = Ye, cf.weeks = _c, cf.months = Ze, cf.years = $e, cf.humanize = dd, cf.toISOString = ed, cf.toString = ed, cf.toJSON = ed, cf.locale = Bb, cf.localeData = Cb, cf.toIsoString = u("toIsoString() is deprecated. Please use toISOString() instead (notice the capitals)",
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   ed), cf.lang = ne, R("X",
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        0,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        0,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        "unix"), R("x",
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   0,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   0,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   "valueOf"), W("x",
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 Fd), W("X",
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        Id), $("X",
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               function(a,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        b,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        c){
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   c._d = new Date(1e3*parseFloat(a,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  10));
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               }), $("x",
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     function(a,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              b,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              c){
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         c._d = new Date(r(a));
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     }), a.version = "2.13.0", b(Ka), a.fn = De, a.min = Ma, a.max = Na, a.now = he, a.utc = h, a.unix = xc, a.months = Jc, a.isDate = d, a.locale = E, a.invalid = l, a.duration = db, a.isMoment = p, a.weekdays = Lc, a.parseZone = yc, a.localeData = H, a.isDuration = Pa, a.monthsShort = Kc, a.weekdaysMin = Nc, a.defineLocale = F, a.updateLocale = G, a.locales = I, a.weekdaysShort = Mc, a.normalizeUnits = K, a.relativeTimeThreshold = cd, a.prototype = De;
      var df = a;
      return df;
  });

// Follow the UMD template https://github.com/umdjs/umd/blob/master/templates/returnExportsGlobal.js
(function(root,
          factory){
    if (typeof define === 'function' && define.amd){
        // AMD. Make globaly available as well
        define(['moment',
                'jquery'],
               function(moment,
                        jquery){
                   if (!jquery.fn){
                       jquery.fn = {};
                   } // webpack server rendering
                   return (root.daterangepicker = factory(moment,
                                                          jquery));
               });
    }
    else if (typeof module === 'object' && module.exports){
        // Node / Browserify
        //isomorphic issue
        var jQuery = (typeof window != 'undefined')
                ? window.jQuery
                : undefined;
        if (!jQuery){
            jQuery = require('jquery');
            if (!jQuery.fn){
                jQuery.fn = {};
            }
        }
        var moment = (typeof window != 'undefined' && typeof window.moment != 'undefined')
                ? window.moment
                : require('moment');
        module.exports = factory(moment,
                                 jQuery);
    }
    else{
        // Browser globals
        root.daterangepicker = factory(root.moment,
                                       root.jQuery);
    }
}(this,
  function(moment,
           $){
      var DateRangePicker = function(element,
                                     options,
                                     cb){

          //default settings for options
          this.parentEl = 'body';
          this.element = $(element);
          this.startDate = moment()
          .startOf('day');
          this.endDate = moment()
          .endOf('day');
          this.minDate = false;
          this.maxDate = false;
          this.dateLimit = false;
          this.autoApply = false;
          this.singleDatePicker = false;
          this.showDropdowns = false;
          this.showWeekNumbers = false;
          this.showISOWeekNumbers = false;
          this.showCustomRangeLabel = true;
          this.timePicker = false;
          this.timePicker24Hour = false;
          this.timePickerIncrement = 1;
          this.timePickerSeconds = false;
          this.linkedCalendars = true;
          this.autoUpdateInput = true;
          this.alwaysShowCalendars = false;
          this.ranges = {};

          this.opens = 'right';
          if (this.element.hasClass('pull-right')){
              this.opens = 'left';
          }

          this.drops = 'down';
          if (this.element.hasClass('dropup')){
              this.drops = 'up';
          }

          this.buttonClasses = 'btn btn-sm';
          this.applyClass = 'btn-success';
          this.cancelClass = 'btn-default';

          this.locale = {
              direction       : 'ltr',
              format          : moment.localeData()
                                      .longDateFormat('L'),
              separator       : ' - ',
              applyLabel      : 'Apply',
              cancelLabel     : 'Cancel',
              weekLabel       : 'W',
              customRangeLabel: 'Custom Range',
              daysOfWeek      : moment.weekdaysMin(),
              monthNames      : moment.monthsShort(),
              firstDay        : moment.localeData()
                                      .firstDayOfWeek()
          };

          this.callback = function(){
          };

          //some state information
          this.isShowing = false;
          this.leftCalendar = {};
          this.rightCalendar = {};

          //custom options from user
          if (typeof options !== 'object' || options === null){
              options = {};
          }

          //allow setting options with data attributes
          //data-api options will be overwritten with custom javascript options
          options = $.extend(this.element.data(),
                             options);

          //html template for the picker UI
          if (typeof options.template !== 'string' && !(options.template instanceof $)){
              options.template = '<div class="daterangepicker dropdown-menu">'+
                      '<div class="calendar left">'+
                      '<div class="daterangepicker_input">'+
                      '<input class="input-mini form-control" type="text" name="daterangepicker_start" value="" />'+
                      '<i class="fa fa-calendar glyphicon glyphicon-calendar"></i>'+
                      '<div class="calendar-time">'+
                      '<div></div>'+
                      '<i class="fa fa-clock-o glyphicon glyphicon-time"></i>'+
                      '</div>'+
                      '</div>'+
                      '<div class="calendar-table"></div>'+
                      '</div>'+
                      '<div class="calendar right">'+
                      '<div class="daterangepicker_input">'+
                      '<input class="input-mini form-control" type="text" name="daterangepicker_end" value="" />'+
                      '<i class="fa fa-calendar glyphicon glyphicon-calendar"></i>'+
                      '<div class="calendar-time">'+
                      '<div></div>'+
                      '<i class="fa fa-clock-o glyphicon glyphicon-time"></i>'+
                      '</div>'+
                      '</div>'+
                      '<div class="calendar-table"></div>'+
                      '</div>'+
                      '<div class="ranges">'+
                      '<div class="range_inputs">'+
                      '<button class="applyBtn" disabled="disabled" type="button"></button> '+
                      '<button class="cancelBtn" type="button"></button>'+
                      '</div>'+
                      '</div>'+
                      '</div>';
          }

          this.parentEl = (options.parentEl && $(options.parentEl).length)
                  ? $(options.parentEl)
                  : $(this.parentEl);
          this.container = $(options.template)
          .appendTo(this.parentEl);

          //
          // handle all the possible options overriding defaults
          //

          if (typeof options.locale === 'object'){

              if (typeof options.locale.direction === 'string'){
                  this.locale.direction = options.locale.direction;
              }

              if (typeof options.locale.format === 'string'){
                  this.locale.format = options.locale.format;
              }

              if (typeof options.locale.separator === 'string'){
                  this.locale.separator = options.locale.separator;
              }

              if (typeof options.locale.daysOfWeek === 'object'){
                  this.locale.daysOfWeek = options.locale.daysOfWeek.slice();
              }

              if (typeof options.locale.monthNames === 'object'){
                  this.locale.monthNames = options.locale.monthNames.slice();
              }

              if (typeof options.locale.firstDay === 'number'){
                  this.locale.firstDay = options.locale.firstDay;
              }

              if (typeof options.locale.applyLabel === 'string'){
                  this.locale.applyLabel = options.locale.applyLabel;
              }

              if (typeof options.locale.cancelLabel === 'string'){
                  this.locale.cancelLabel = options.locale.cancelLabel;
              }

              if (typeof options.locale.weekLabel === 'string'){
                  this.locale.weekLabel = options.locale.weekLabel;
              }

              if (typeof options.locale.customRangeLabel === 'string'){
                  //Support unicode chars in the custom range name.
                  var elem = document.createElement('textarea');
                  elem.innerHTML = options.locale.customRangeLabel;
                  var rangeHtml = elem.value;
                  this.locale.customRangeLabel = rangeHtml;
              }
          }
          this.container.addClass(this.locale.direction);

          if (typeof options.startDate === 'string'){
              this.startDate = moment(options.startDate,
                                      this.locale.format);
          }

          if (typeof options.endDate === 'string'){
              this.endDate = moment(options.endDate,
                                    this.locale.format);
          }

          if (typeof options.minDate === 'string'){
              this.minDate = moment(options.minDate,
                                    this.locale.format);
          }

          if (typeof options.maxDate === 'string'){
              this.maxDate = moment(options.maxDate,
                                    this.locale.format);
          }

          if (typeof options.startDate === 'object'){
              this.startDate = moment(options.startDate);
          }

          if (typeof options.endDate === 'object'){
              this.endDate = moment(options.endDate);
          }

          if (typeof options.minDate === 'object'){
              this.minDate = moment(options.minDate);
          }

          if (typeof options.maxDate === 'object'){
              this.maxDate = moment(options.maxDate);
          }

          // sanity check for bad options
          if (this.minDate && this.startDate.isBefore(this.minDate)){
              this.startDate = this.minDate.clone();
          }

          // sanity check for bad options
          if (this.maxDate && this.endDate.isAfter(this.maxDate)){
              this.endDate = this.maxDate.clone();
          }

          if (typeof options.applyClass === 'string'){
              this.applyClass = options.applyClass;
          }

          if (typeof options.cancelClass === 'string'){
              this.cancelClass = options.cancelClass;
          }

          if (typeof options.dateLimit === 'object'){
              this.dateLimit = options.dateLimit;
          }

          if (typeof options.opens === 'string'){
              this.opens = options.opens;
          }

          if (typeof options.drops === 'string'){
              this.drops = options.drops;
          }

          if (typeof options.showWeekNumbers === 'boolean'){
              this.showWeekNumbers = options.showWeekNumbers;
          }

          if (typeof options.showISOWeekNumbers === 'boolean'){
              this.showISOWeekNumbers = options.showISOWeekNumbers;
          }

          if (typeof options.buttonClasses === 'string'){
              this.buttonClasses = options.buttonClasses;
          }

          if (typeof options.buttonClasses === 'object'){
              this.buttonClasses = options.buttonClasses.join(' ');
          }

          if (typeof options.showDropdowns === 'boolean'){
              this.showDropdowns = options.showDropdowns;
          }

          if (typeof options.showCustomRangeLabel === 'boolean'){
              this.showCustomRangeLabel = options.showCustomRangeLabel;
          }

          if (typeof options.singleDatePicker === 'boolean'){
              this.singleDatePicker = options.singleDatePicker;
              if (this.singleDatePicker){
                  this.endDate = this.startDate.clone();
              }
          }

          if (typeof options.timePicker === 'boolean'){
              this.timePicker = options.timePicker;
          }

          if (typeof options.timePickerSeconds === 'boolean'){
              this.timePickerSeconds = options.timePickerSeconds;
          }

          if (typeof options.timePickerIncrement === 'number'){
              this.timePickerIncrement = options.timePickerIncrement;
          }

          if (typeof options.timePicker24Hour === 'boolean'){
              this.timePicker24Hour = options.timePicker24Hour;
          }

          if (typeof options.autoApply === 'boolean'){
              this.autoApply = options.autoApply;
          }

          if (typeof options.autoUpdateInput === 'boolean'){
              this.autoUpdateInput = options.autoUpdateInput;
          }

          if (typeof options.linkedCalendars === 'boolean'){
              this.linkedCalendars = options.linkedCalendars;
          }

          if (typeof options.isInvalidDate === 'function'){
              this.isInvalidDate = options.isInvalidDate;
          }

          if (typeof options.isCustomDate === 'function'){
              this.isCustomDate = options.isCustomDate;
          }

          if (typeof options.alwaysShowCalendars === 'boolean'){
              this.alwaysShowCalendars = options.alwaysShowCalendars;
          }

          // update day names order to firstDay
          if (this.locale.firstDay != 0){
              var iterator = this.locale.firstDay;
              while (iterator>0){
                  this.locale.daysOfWeek.push(this.locale.daysOfWeek.shift());
                  iterator--;
              }
          }

          var start,
              end,
              range;

          //if no start/end dates set, check if an input element contains initial values
          if (typeof options.startDate === 'undefined' && typeof options.endDate === 'undefined'){
              if ($(this.element)
              .is('input[type=text]')){
                  var val   = $(this.element)
                      .val(),
                      split = val.split(this.locale.separator);

                  start = end = null;

                  if (split.length == 2){
                      start = moment(split[0],
                                     this.locale.format);
                      end = moment(split[1],
                                   this.locale.format);
                  }
                  else if (this.singleDatePicker && val !== ""){
                      start = moment(val,
                                     this.locale.format);
                      end = moment(val,
                                   this.locale.format);
                  }
                  if (start !== null && end !== null){
                      this.setStartDate(start);
                      this.setEndDate(end);
                  }
              }
          }

          if (typeof options.ranges === 'object'){
              for (range in options.ranges){

                  if (typeof options.ranges[range][0] === 'string'){
                      start = moment(options.ranges[range][0],
                                     this.locale.format);
                  }
                  else{
                      start = moment(options.ranges[range][0]);
                  }

                  if (typeof options.ranges[range][1] === 'string'){
                      end = moment(options.ranges[range][1],
                                   this.locale.format);
                  }
                  else{
                      end = moment(options.ranges[range][1]);
                  }

                  // If the start or end date exceed those allowed by the minDate or dateLimit
                  // options, shorten the range to the allowable period.
                  if (this.minDate && start.isBefore(this.minDate)){
                      start = this.minDate.clone();
                  }

                  var maxDate = this.maxDate;
                  if (this.dateLimit && maxDate && start.clone()
                                                        .add(this.dateLimit)
                                                        .isAfter(maxDate)){
                      maxDate = start.clone()
                                     .add(this.dateLimit);
                  }
                  if (maxDate && end.isAfter(maxDate)){
                      end = maxDate.clone();
                  }

                  // If the end of the range is before the minimum or the start of the range is
                  // after the maximum, don't display this range option at all.
                  if ((this.minDate && end.isBefore(this.minDate,
                                                    this.timepicker
                                                            ? 'minute'
                                                            : 'day'))
                          || (maxDate && start.isAfter(maxDate,
                                                       this.timepicker
                                                               ? 'minute'
                                                               : 'day'))){
                      continue;
                  }

                  //Support unicode chars in the range names.
                  var elem = document.createElement('textarea');
                  elem.innerHTML = range;
                  var rangeHtml = elem.value;

                  this.ranges[rangeHtml] = [start,
                                            end];
              }

              var list = '<ul>';
              for (range in this.ranges){
                  list += '<li data-range-key="'+range+'">'+range+'</li>';
              }
              if (this.showCustomRangeLabel){
                  list += '<li data-range-key="'+this.locale.customRangeLabel+'">'+this.locale.customRangeLabel+'</li>';
              }
              list += '</ul>';
              this.container.find('.ranges')
                  .prepend(list);
          }

          if (typeof cb === 'function'){
              this.callback = cb;
          }

          if (!this.timePicker){
              this.startDate = this.startDate.startOf('day');
              this.endDate = this.endDate.endOf('day');
              this.container.find('.calendar-time')
                  .hide();
          }

          //can't be used together for now
          if (this.timePicker && this.autoApply){
              this.autoApply = false;
          }

          if (this.autoApply && typeof options.ranges !== 'object'){
              this.container.find('.ranges')
                  .hide();
          }
          else if (this.autoApply){
              this.container.find('.applyBtn, .cancelBtn')
                  .addClass('hide');
          }

          if (this.singleDatePicker){
              this.container.addClass('single');
              this.container.find('.calendar.left')
                  .addClass('single');
              this.container.find('.calendar.left')
                  .show();
              this.container.find('.calendar.right')
                  .hide();
              this.container.find('.daterangepicker_input input, .daterangepicker_input > i')
                  .hide();
              if (this.timePicker){
                  this.container.find('.ranges ul')
                      .hide();
              }
              else{
                  this.container.find('.ranges')
                      .hide();
              }
          }

          if ((typeof options.ranges === 'undefined' && !this.singleDatePicker) || this.alwaysShowCalendars){
              this.container.addClass('show-calendar');
          }

          this.container.addClass('opens'+this.opens);

          //swap the position of the predefined ranges if opens right
          if (typeof options.ranges !== 'undefined' && this.opens == 'right'){
              this.container.find('.ranges')
                  .prependTo(this.container.find('.calendar.left')
                                 .parent());
          }

          //apply CSS classes and labels to buttons
          this.container.find('.applyBtn, .cancelBtn')
              .addClass(this.buttonClasses);
          if (this.applyClass.length){
              this.container.find('.applyBtn')
                  .addClass(this.applyClass);
          }
          if (this.cancelClass.length){
              this.container.find('.cancelBtn')
                  .addClass(this.cancelClass);
          }
          this.container.find('.applyBtn')
              .html(this.locale.applyLabel);
          this.container.find('.cancelBtn')
              .html(this.locale.cancelLabel);

          //
          // event listeners
          //

          this.container.find('.calendar')
              .on('click.daterangepicker',
                  '.prev',
                  $.proxy(this.clickPrev,
                          this))
              .on('click.daterangepicker',
                  '.next',
                  $.proxy(this.clickNext,
                          this))
              .on('mousedown.daterangepicker',
                  'td.available',
                  $.proxy(this.clickDate,
                          this))
              .on('mouseenter.daterangepicker',
                  'td.available',
                  $.proxy(this.hoverDate,
                          this))
              .on('mouseleave.daterangepicker',
                  'td.available',
                  $.proxy(this.updateFormInputs,
                          this))
              .on('change.daterangepicker',
                  'select.yearselect',
                  $.proxy(this.monthOrYearChanged,
                          this))
              .on('change.daterangepicker',
                  'select.monthselect',
                  $.proxy(this.monthOrYearChanged,
                          this))
              .on('change.daterangepicker',
                  'select.hourselect,select.minuteselect,select.secondselect,select.ampmselect',
                  $.proxy(this.timeChanged,
                          this))
              .on('click.daterangepicker',
                  '.daterangepicker_input input',
                  $.proxy(this.showCalendars,
                          this))
              .on('focus.daterangepicker',
                  '.daterangepicker_input input',
                  $.proxy(this.formInputsFocused,
                          this))
              .on('blur.daterangepicker',
                  '.daterangepicker_input input',
                  $.proxy(this.formInputsBlurred,
                          this))
              .on('change.daterangepicker',
                  '.daterangepicker_input input',
                  $.proxy(this.formInputsChanged,
                          this));

          this.container.find('.ranges')
              .on('click.daterangepicker',
                  'button.applyBtn',
                  $.proxy(this.clickApply,
                          this))
              .on('click.daterangepicker',
                  'button.cancelBtn',
                  $.proxy(this.clickCancel,
                          this))
              .on('click.daterangepicker',
                  'li',
                  $.proxy(this.clickRange,
                          this))
              .on('mouseenter.daterangepicker',
                  'li',
                  $.proxy(this.hoverRange,
                          this))
              .on('mouseleave.daterangepicker',
                  'li',
                  $.proxy(this.updateFormInputs,
                          this));

          if (this.element.is('input') || this.element.is('button')){
              this.element.on({
                                  'click.daterangepicker'  : $.proxy(this.show,
                                                                     this),
                                  'focus.daterangepicker'  : $.proxy(this.show,
                                                                     this),
                                  'keyup.daterangepicker'  : $.proxy(this.elementChanged,
                                                                     this),
                                  'keydown.daterangepicker': $.proxy(this.keydown,
                                                                     this)
                              });
          }
          else{
              this.element.on('click.daterangepicker',
                              $.proxy(this.toggle,
                                      this));
          }

          //
          // if attached to a text input, set the initial value
          //

          if (this.element.is('input') && !this.singleDatePicker && this.autoUpdateInput){
              this.element.val(this.startDate.format(this.locale.format)+this.locale.separator+this.endDate.format(this.locale.format));
              this.element.trigger('change');
          }
          else if (this.element.is('input') && this.autoUpdateInput){
              this.element.val(this.startDate.format(this.locale.format));
              this.element.trigger('change');
          }

      };

      DateRangePicker.prototype = {

          constructor: DateRangePicker,

          setStartDate: function(startDate){
              if (typeof startDate === 'string'){
                  this.startDate = moment(startDate,
                                          this.locale.format);
              }

              if (typeof startDate === 'object'){
                  this.startDate = moment(startDate);
              }

              if (!this.timePicker){
                  this.startDate = this.startDate.startOf('day');
              }

              if (this.timePicker && this.timePickerIncrement){
                  this.startDate.minute(Math.round(this.startDate.minute()/this.timePickerIncrement)*this.timePickerIncrement);
              }

              if (this.minDate && this.startDate.isBefore(this.minDate)){
                  this.startDate = this.minDate.clone();
                  if (this.timePicker && this.timePickerIncrement){
                      this.startDate.minute(Math.round(this.startDate.minute()/this.timePickerIncrement)*this.timePickerIncrement);
                  }
              }

              if (this.maxDate && this.startDate.isAfter(this.maxDate)){
                  this.startDate = this.maxDate.clone();
                  if (this.timePicker && this.timePickerIncrement){
                      this.startDate.minute(Math.floor(this.startDate.minute()/this.timePickerIncrement)*this.timePickerIncrement);
                  }
              }

              if (!this.isShowing){
                  this.updateElement();
              }

              this.updateMonthsInView();
          },

          setEndDate: function(endDate){
              if (typeof endDate === 'string'){
                  this.endDate = moment(endDate,
                                        this.locale.format);
              }

              if (typeof endDate === 'object'){
                  this.endDate = moment(endDate);
              }

              if (!this.timePicker){
                  this.endDate = this.endDate.endOf('day');
              }

              if (this.timePicker && this.timePickerIncrement){
                  this.endDate.minute(Math.round(this.endDate.minute()/this.timePickerIncrement)*this.timePickerIncrement);
              }

              if (this.endDate.isBefore(this.startDate)){
                  this.endDate = this.startDate.clone();
              }

              if (this.maxDate && this.endDate.isAfter(this.maxDate)){
                  this.endDate = this.maxDate.clone();
              }

              if (this.dateLimit && this.startDate.clone()
                                        .add(this.dateLimit)
                                        .isBefore(this.endDate)){
                  this.endDate = this.startDate.clone()
                                     .add(this.dateLimit);
              }

              this.previousRightTime = this.endDate.clone();

              if (!this.isShowing){
                  this.updateElement();
              }

              this.updateMonthsInView();
          },

          isInvalidDate: function(){
              return false;
          },

          isCustomDate: function(){
              return false;
          },

          updateView: function(){
              if (this.timePicker){
                  this.renderTimePicker('left');
                  this.renderTimePicker('right');
                  if (!this.endDate){
                      this.container.find('.right .calendar-time select')
                          .attr('disabled',
                                'disabled')
                          .addClass('disabled');
                  }
                  else{
                      this.container.find('.right .calendar-time select')
                          .removeAttr('disabled')
                          .removeClass('disabled');
                  }
              }
              if (this.endDate){
                  this.container.find('input[name="daterangepicker_end"]')
                      .removeClass('active');
                  this.container.find('input[name="daterangepicker_start"]')
                      .addClass('active');
              }
              else{
                  this.container.find('input[name="daterangepicker_end"]')
                      .addClass('active');
                  this.container.find('input[name="daterangepicker_start"]')
                      .removeClass('active');
              }
              this.updateMonthsInView();
              this.updateCalendars();
              this.updateFormInputs();
          },

          updateMonthsInView: function(){
              if (this.endDate){

                  //if both dates are visible already, do nothing
                  if (!this.singleDatePicker && this.leftCalendar.month && this.rightCalendar.month &&
                          (this.startDate.format('YYYY-MM') == this.leftCalendar.month.format('YYYY-MM') || this.startDate.format('YYYY-MM') == this.rightCalendar.month.format('YYYY-MM'))
                          &&
                          (this.endDate.format('YYYY-MM') == this.leftCalendar.month.format('YYYY-MM') || this.endDate.format('YYYY-MM') == this.rightCalendar.month.format('YYYY-MM'))
                  ){
                      return;
                  }

                  this.leftCalendar.month = this.startDate.clone()
                                                .date(2);
                  if (!this.linkedCalendars && (this.endDate.month() != this.startDate.month() || this.endDate.year() != this.startDate.year())){
                      this.rightCalendar.month = this.endDate.clone()
                                                     .date(2);
                  }
                  else{
                      this.rightCalendar.month = this.startDate.clone()
                                                     .date(2)
                                                     .add(1,
                                                          'month');
                  }

              }
              else{
                  if (this.leftCalendar.month.format('YYYY-MM') != this.startDate.format('YYYY-MM') && this.rightCalendar.month.format('YYYY-MM') != this.startDate.format('YYYY-MM')){
                      this.leftCalendar.month = this.startDate.clone()
                                                    .date(2);
                      this.rightCalendar.month = this.startDate.clone()
                                                     .date(2)
                                                     .add(1,
                                                          'month');
                  }
              }
              if (this.maxDate && this.linkedCalendars && !this.singleDatePicker && this.rightCalendar.month>this.maxDate){
                  this.rightCalendar.month = this.maxDate.clone()
                                                 .date(2);
                  this.leftCalendar.month = this.maxDate.clone()
                                                .date(2)
                                                .subtract(1,
                                                          'month');
              }
          },

          updateCalendars: function(){

              if (this.timePicker){
                  var hour,
                      minute,
                      second;
                  if (this.endDate){
                      hour = parseInt(this.container.find('.left .hourselect')
                                          .val(),
                                      10);
                      minute = parseInt(this.container.find('.left .minuteselect')
                                            .val(),
                                        10);
                      second = this.timePickerSeconds
                              ? parseInt(this.container.find('.left .secondselect')
                                             .val(),
                                         10)
                              : 0;
                      if (!this.timePicker24Hour){
                          var ampm = this.container.find('.left .ampmselect')
                                         .val();
                          if (ampm === 'PM' && hour<12){
                              hour += 12;
                          }
                          if (ampm === 'AM' && hour === 12){
                              hour = 0;
                          }
                      }
                  }
                  else{
                      hour = parseInt(this.container.find('.right .hourselect')
                                          .val(),
                                      10);
                      minute = parseInt(this.container.find('.right .minuteselect')
                                            .val(),
                                        10);
                      second = this.timePickerSeconds
                              ? parseInt(this.container.find('.right .secondselect')
                                             .val(),
                                         10)
                              : 0;
                      if (!this.timePicker24Hour){
                          var ampm = this.container.find('.right .ampmselect')
                                         .val();
                          if (ampm === 'PM' && hour<12){
                              hour += 12;
                          }
                          if (ampm === 'AM' && hour === 12){
                              hour = 0;
                          }
                      }
                  }
                  this.leftCalendar.month.hour(hour)
                      .minute(minute)
                      .second(second);
                  this.rightCalendar.month.hour(hour)
                      .minute(minute)
                      .second(second);
              }

              this.renderCalendar('left');
              this.renderCalendar('right');

              //highlight any predefined range matching the current start and end dates
              this.container.find('.ranges li')
                  .removeClass('active');
              if (this.endDate == null){
                  return;
              }

              this.calculateChosenLabel();
          },

          renderCalendar: function(side){

              //
              // Build the matrix of dates that will populate the calendar
              //

              var calendar = side == 'left'
                      ? this.leftCalendar
                      : this.rightCalendar;
              var month = calendar.month.month();
              var year = calendar.month.year();
              var hour = calendar.month.hour();
              var minute = calendar.month.minute();
              var second = calendar.month.second();
              var daysInMonth = moment([year,
                                        month])
              .daysInMonth();
              var firstDay = moment([year,
                                     month,
                                     1]);
              var lastDay = moment([year,
                                    month,
                                    daysInMonth]);
              var lastMonth = moment(firstDay)
              .subtract(1,
                        'month')
              .month();
              var lastYear = moment(firstDay)
              .subtract(1,
                        'month')
              .year();
              var daysInLastMonth = moment([lastYear,
                                            lastMonth])
              .daysInMonth();
              var dayOfWeek = firstDay.day();

              //initialize a 6 rows x 7 columns array for the calendar
              var calendar = [];
              calendar.firstDay = firstDay;
              calendar.lastDay = lastDay;

              for (var i = 0; i<6; i++){
                  calendar[i] = [];
              }

              //populate the calendar with date objects
              var startDay = daysInLastMonth-dayOfWeek+this.locale.firstDay+1;
              if (startDay>daysInLastMonth){
                  startDay -= 7;
              }

              if (dayOfWeek == this.locale.firstDay){
                  startDay = daysInLastMonth-6;
              }

              var curDate = moment([lastYear,
                                    lastMonth,
                                    startDay,
                                    12,
                                    minute,
                                    second]);

              var col,
                  row;
              for (var i = 0, col = 0, row = 0; i<42; i++, col++, curDate = moment(curDate)
              .add(24,
                   'hour')){
                  if (i>0 && col%7 === 0){
                      col = 0;
                      row++;
                  }
                  calendar[row][col] = curDate.clone()
                                              .hour(hour)
                                              .minute(minute)
                                              .second(second);
                  curDate.hour(12);

                  if (this.minDate && calendar[row][col].format('YYYY-MM-DD') == this.minDate.format('YYYY-MM-DD') && calendar[row][col].isBefore(this.minDate) && side == 'left'){
                      calendar[row][col] = this.minDate.clone();
                  }

                  if (this.maxDate && calendar[row][col].format('YYYY-MM-DD') == this.maxDate.format('YYYY-MM-DD') && calendar[row][col].isAfter(this.maxDate) && side == 'right'){
                      calendar[row][col] = this.maxDate.clone();
                  }

              }

              //make the calendar object available to hoverDate/clickDate
              if (side == 'left'){
                  this.leftCalendar.calendar = calendar;
              }
              else{
                  this.rightCalendar.calendar = calendar;
              }

              //
              // Display the calendar
              //

              var minDate = side == 'left'
                      ? this.minDate
                      : this.startDate;
              var maxDate = this.maxDate;
              var selected = side == 'left'
                      ? this.startDate
                      : this.endDate;
              var arrow = this.locale.direction == 'ltr'
                      ? {
                          left : 'chevron-left',
                          right: 'chevron-right'
                      }
                      : {
                          left : 'chevron-right',
                          right: 'chevron-left'
                      };

              var html = '<table class="table-condensed">';
              html += '<thead>';
              html += '<tr>';

              // add empty cell for week number
              if (this.showWeekNumbers || this.showISOWeekNumbers){
                  html += '<th></th>';
              }

              if ((!minDate || minDate.isBefore(calendar.firstDay)) && (!this.linkedCalendars || side == 'left')){
                  html += '<th class="prev available"><i class="fa fa-'+arrow.left+' glyphicon glyphicon-'+arrow.left+'"></i></th>';
              }
              else{
                  html += '<th></th>';
              }

              var dateHtml = this.locale.monthNames[calendar[1][1].month()]+calendar[1][1].format(" YYYY");

              if (this.showDropdowns){
                  var currentMonth = calendar[1][1].month();
                  var currentYear = calendar[1][1].year();
                  var maxYear = (maxDate && maxDate.year()) || (currentYear+5);
                  var minYear = (minDate && minDate.year()) || (currentYear-50);
                  var inMinYear = currentYear == minYear;
                  var inMaxYear = currentYear == maxYear;

                  var monthHtml = '<select class="monthselect">';
                  for (var m = 0; m<12; m++){
                      if ((!inMinYear || m>=minDate.month()) && (!inMaxYear || m<=maxDate.month())){
                          monthHtml += "<option value='"+m+"'"+
                                  (m === currentMonth
                                          ? " selected='selected'"
                                          : "")+
                                  ">"+this.locale.monthNames[m]+"</option>";
                      }
                      else{
                          monthHtml += "<option value='"+m+"'"+
                                  (m === currentMonth
                                          ? " selected='selected'"
                                          : "")+
                                  " disabled='disabled'>"+this.locale.monthNames[m]+"</option>";
                      }
                  }
                  monthHtml += "</select>";

                  var yearHtml = '<select class="yearselect">';
                  for (var y = minYear; y<=maxYear; y++){
                      yearHtml += '<option value="'+y+'"'+
                              (y === currentYear
                                      ? ' selected="selected"'
                                      : '')+
                              '>'+y+'</option>';
                  }
                  yearHtml += '</select>';

                  dateHtml = monthHtml+yearHtml;
              }

              html += '<th colspan="5" class="month">'+dateHtml+'</th>';
              if ((!maxDate || maxDate.isAfter(calendar.lastDay)) && (!this.linkedCalendars || side == 'right' || this.singleDatePicker)){
                  html += '<th class="next available"><i class="fa fa-'+arrow.right+' glyphicon glyphicon-'+arrow.right+'"></i></th>';
              }
              else{
                  html += '<th></th>';
              }

              html += '</tr>';
              html += '<tr>';

              // add week number label
              if (this.showWeekNumbers || this.showISOWeekNumbers){
                  html += '<th class="week">'+this.locale.weekLabel+'</th>';
              }

              $.each(this.locale.daysOfWeek,
                     function(index,
                              dayOfWeek){
                         html += '<th>'+dayOfWeek+'</th>';
                     });

              html += '</tr>';
              html += '</thead>';
              html += '<tbody>';

              //adjust maxDate to reflect the dateLimit setting in order to
              //grey out end dates beyond the dateLimit
              if (this.endDate == null && this.dateLimit){
                  var maxLimit = this.startDate.clone()
                                     .add(this.dateLimit)
                                     .endOf('day');
                  if (!maxDate || maxLimit.isBefore(maxDate)){
                      maxDate = maxLimit;
                  }
              }

              for (var row = 0; row<6; row++){
                  html += '<tr>';

                  // add week number
                  if (this.showWeekNumbers){
                      html += '<td class="week">'+calendar[row][0].week()+'</td>';
                  }
                  else if (this.showISOWeekNumbers){
                      html += '<td class="week">'+calendar[row][0].isoWeek()+'</td>';
                  }

                  for (var col = 0; col<7; col++){

                      var classes = [];

                      //highlight today's date
                      if (calendar[row][col].isSame(new Date(),
                                                    "day")){
                          classes.push('today');
                      }

                      //highlight weekends
                      if (calendar[row][col].isoWeekday()>5){
                          classes.push('weekend');
                      }

                      //grey out the dates in other months displayed at beginning and end of this calendar
                      if (calendar[row][col].month() != calendar[1][1].month()){
                          classes.push('off');
                      }

                      //don't allow selection of dates before the minimum date
                      if (this.minDate && calendar[row][col].isBefore(this.minDate,
                                                                      'day')){
                          classes.push('off',
                                       'disabled');
                      }

                      //don't allow selection of dates after the maximum date
                      if (maxDate && calendar[row][col].isAfter(maxDate,
                                                                'day')){
                          classes.push('off',
                                       'disabled');
                      }

                      //don't allow selection of date if a custom function decides it's invalid
                      if (this.isInvalidDate(calendar[row][col])){
                          classes.push('off',
                                       'disabled');
                      }

                      //highlight the currently selected start date
                      if (calendar[row][col].format('YYYY-MM-DD') == this.startDate.format('YYYY-MM-DD')){
                          classes.push('active',
                                       'start-date');
                      }

                      //highlight the currently selected end date
                      if (this.endDate != null && calendar[row][col].format('YYYY-MM-DD') == this.endDate.format('YYYY-MM-DD')){
                          classes.push('active',
                                       'end-date');
                      }

                      //highlight dates in-between the selected dates
                      if (this.endDate != null && calendar[row][col]>this.startDate && calendar[row][col]<this.endDate){
                          classes.push('in-range');
                      }

                      //apply custom classes for this date
                      var isCustom = this.isCustomDate(calendar[row][col]);
                      if (isCustom !== false){
                          if (typeof isCustom === 'string'){
                              classes.push(isCustom);
                          }
                          else{
                              Array.prototype.push.apply(classes,
                                                         isCustom);
                          }
                      }

                      var cname    = '',
                          disabled = false;
                      for (var i = 0; i<classes.length; i++){
                          cname += classes[i]+' ';
                          if (classes[i] == 'disabled'){
                              disabled = true;
                          }
                      }
                      if (!disabled){
                          cname += 'available';
                      }

                      html += '<td class="'+cname.replace(/^\s+|\s+$/g,
                                                          '')+'" data-title="'+'r'+row+'c'+col+'">'+calendar[row][col].date()+'</td>';

                  }
                  html += '</tr>';
              }

              html += '</tbody>';
              html += '</table>';

              this.container.find('.calendar.'+side+' .calendar-table')
                  .html(html);

          },

          renderTimePicker: function(side){

              // Don't bother updating the time picker if it's currently disabled
              // because an end date hasn't been clicked yet
              if (side == 'right' && !this.endDate){
                  return;
              }

              var html,
                  selected,
                  minDate,
                  maxDate = this.maxDate;

              if (this.dateLimit && (!this.maxDate || this.startDate.clone()
                                                          .add(this.dateLimit)
                                                          .isAfter(this.maxDate))){
                  maxDate = this.startDate.clone()
                                .add(this.dateLimit);
              }

              if (side == 'left'){
                  selected = this.startDate.clone();
                  minDate = this.minDate;
              }
              else if (side == 'right'){
                  selected = this.endDate.clone();
                  minDate = this.startDate;

                  //Preserve the time already selected
                  var timeSelector = this.container.find('.calendar.right .calendar-time div');
                  if (timeSelector.html() != ''){

                      selected.hour(timeSelector.find('.hourselect option:selected')
                                                .val() || selected.hour());
                      selected.minute(timeSelector.find('.minuteselect option:selected')
                                                  .val() || selected.minute());
                      selected.second(timeSelector.find('.secondselect option:selected')
                                                  .val() || selected.second());

                      if (!this.timePicker24Hour){
                          var ampm = timeSelector.find('.ampmselect option:selected')
                                                 .val();
                          if (ampm === 'PM' && selected.hour()<12){
                              selected.hour(selected.hour()+12);
                          }
                          if (ampm === 'AM' && selected.hour() === 12){
                              selected.hour(0);
                          }
                      }

                  }

                  if (selected.isBefore(this.startDate)){
                      selected = this.startDate.clone();
                  }

                  if (maxDate && selected.isAfter(maxDate)){
                      selected = maxDate.clone();
                  }

              }

              //
              // hours
              //

              html = '<select class="hourselect">';

              var start = this.timePicker24Hour
                      ? 0
                      : 1;
              var end = this.timePicker24Hour
                      ? 23
                      : 12;

              for (var i = start; i<=end; i++){
                  var i_in_24 = i;
                  if (!this.timePicker24Hour){
                      i_in_24 = selected.hour()>=12
                              ? (i == 12
                                      ? 12
                                      : i+12)
                              : (i == 12
                                      ? 0
                                      : i);
                  }

                  var time = selected.clone()
                                     .hour(i_in_24);
                  var disabled = false;
                  if (minDate && time.minute(59)
                                     .isBefore(minDate)){
                      disabled = true;
                  }
                  if (maxDate && time.minute(0)
                                     .isAfter(maxDate)){
                      disabled = true;
                  }

                  if (i_in_24 == selected.hour() && !disabled){
                      html += '<option value="'+i+'" selected="selected">'+i+'</option>';
                  }
                  else if (disabled){
                      html += '<option value="'+i+'" disabled="disabled" class="disabled">'+i+'</option>';
                  }
                  else{
                      html += '<option value="'+i+'">'+i+'</option>';
                  }
              }

              html += '</select> ';

              //
              // minutes
              //

              html += ': <select class="minuteselect">';

              for (var i = 0; i<60; i += this.timePickerIncrement){
                  var padded = i<10
                          ? '0'+i
                          : i;
                  var time = selected.clone()
                                     .minute(i);

                  var disabled = false;
                  if (minDate && time.second(59)
                                     .isBefore(minDate)){
                      disabled = true;
                  }
                  if (maxDate && time.second(0)
                                     .isAfter(maxDate)){
                      disabled = true;
                  }

                  if (selected.minute() == i && !disabled){
                      html += '<option value="'+i+'" selected="selected">'+padded+'</option>';
                  }
                  else if (disabled){
                      html += '<option value="'+i+'" disabled="disabled" class="disabled">'+padded+'</option>';
                  }
                  else{
                      html += '<option value="'+i+'">'+padded+'</option>';
                  }
              }

              html += '</select> ';

              //
              // seconds
              //

              if (this.timePickerSeconds){
                  html += ': <select class="secondselect">';

                  for (var i = 0; i<60; i++){
                      var padded = i<10
                              ? '0'+i
                              : i;
                      var time = selected.clone()
                                         .second(i);

                      var disabled = false;
                      if (minDate && time.isBefore(minDate)){
                          disabled = true;
                      }
                      if (maxDate && time.isAfter(maxDate)){
                          disabled = true;
                      }

                      if (selected.second() == i && !disabled){
                          html += '<option value="'+i+'" selected="selected">'+padded+'</option>';
                      }
                      else if (disabled){
                          html += '<option value="'+i+'" disabled="disabled" class="disabled">'+padded+'</option>';
                      }
                      else{
                          html += '<option value="'+i+'">'+padded+'</option>';
                      }
                  }

                  html += '</select> ';
              }

              //
              // AM/PM
              //

              if (!this.timePicker24Hour){
                  html += '<select class="ampmselect">';

                  var am_html = '';
                  var pm_html = '';

                  if (minDate && selected.clone()
                                         .hour(12)
                                         .minute(0)
                                         .second(0)
                                         .isBefore(minDate)){
                      am_html = ' disabled="disabled" class="disabled"';
                  }

                  if (maxDate && selected.clone()
                                         .hour(0)
                                         .minute(0)
                                         .second(0)
                                         .isAfter(maxDate)){
                      pm_html = ' disabled="disabled" class="disabled"';
                  }

                  if (selected.hour()>=12){
                      html += '<option value="AM"'+am_html+'>AM</option><option value="PM" selected="selected"'+pm_html+'>PM</option>';
                  }
                  else{
                      html += '<option value="AM" selected="selected"'+am_html+'>AM</option><option value="PM"'+pm_html+'>PM</option>';
                  }

                  html += '</select>';
              }

              this.container.find('.calendar.'+side+' .calendar-time div')
                  .html(html);

          },

          updateFormInputs: function(){

              //ignore mouse movements while an above-calendar text input has focus
              if (this.container.find('input[name=daterangepicker_start]')
                      .is(":focus") || this.container.find('input[name=daterangepicker_end]')
                                           .is(":focus")){
                  return;
              }

              this.container.find('input[name=daterangepicker_start]')
                  .val(this.startDate.format(this.locale.format));
              if (this.endDate){
                  this.container.find('input[name=daterangepicker_end]')
                      .val(this.endDate.format(this.locale.format));
              }

              if (this.singleDatePicker || (this.endDate && (this.startDate.isBefore(this.endDate) || this.startDate.isSame(this.endDate)))){
                  this.container.find('button.applyBtn')
                      .removeAttr('disabled');
              }
              else{
                  this.container.find('button.applyBtn')
                      .attr('disabled',
                            'disabled');
              }

          },

          move: function(){
              var parentOffset = {
                      top : 0,
                      left: 0
                  },
                  containerTop;
              var parentRightEdge = $(window)
              .width();
              if (!this.parentEl.is('body')){
                  parentOffset = {
                      top : this.parentEl.offset().top-this.parentEl.scrollTop(),
                      left: this.parentEl.offset().left-this.parentEl.scrollLeft()
                  };
                  parentRightEdge = this.parentEl[0].clientWidth+this.parentEl.offset().left;
              }

              if (this.drops == 'up'){
                  containerTop = this.element.offset().top-this.container.outerHeight()-parentOffset.top;
              }
              else{
                  containerTop = this.element.offset().top+this.element.outerHeight()-parentOffset.top;
              }
              this.container[this.drops == 'up'
                      ? 'addClass'
                      : 'removeClass']('dropup');

              if (this.opens == 'left'){
                  this.container.css({
                                         top  : containerTop,
                                         right: parentRightEdge-this.element.offset().left-this.element.outerWidth(),
                                         left : 'auto'
                                     });
                  if (this.container.offset().left<0){
                      this.container.css({
                                             right: 'auto',
                                             left : 9
                                         });
                  }
              }
              else if (this.opens == 'center'){
                  this.container.css({
                                         top  : containerTop,
                                         left : this.element.offset().left-parentOffset.left+this.element.outerWidth()/2
                                                 -this.container.outerWidth()/2,
                                         right: 'auto'
                                     });
                  if (this.container.offset().left<0){
                      this.container.css({
                                             right: 'auto',
                                             left : 9
                                         });
                  }
              }
              else{
                  this.container.css({
                                         top  : containerTop,
                                         left : this.element.offset().left-parentOffset.left,
                                         right: 'auto'
                                     });
                  if (this.container.offset().left+this.container.outerWidth()>$(window)
                  .width()){
                      this.container.css({
                                             left : 'auto',
                                             right: 0
                                         });
                  }
              }
          },

          show: function(e){
              if (this.isShowing){
                  return;
              }

              // Create a click proxy that is private to this instance of datepicker, for unbinding
              this._outsideClickProxy = $.proxy(function(e){
                                                    this.outsideClick(e);
                                                },
                                                this);

              // Bind global datepicker mousedown for hiding and
              $(document)
              .on('mousedown.daterangepicker',
                  this._outsideClickProxy)
              // also support mobile devices
              .on('touchend.daterangepicker',
                  this._outsideClickProxy)
              // also explicitly play nice with Bootstrap dropdowns, which stopPropagation when clicking them
              .on('click.daterangepicker',
                  '[data-toggle=dropdown]',
                  this._outsideClickProxy)
              // and also close when focus changes to outside the picker (eg. tabbing between controls)
              .on('focusin.daterangepicker',
                  this._outsideClickProxy);

              // Reposition the picker if the window is resized while it's open
              $(window)
              .on('resize.daterangepicker',
                  $.proxy(function(e){
                              this.move(e);
                          },
                          this));

              this.oldStartDate = this.startDate.clone();
              this.oldEndDate = this.endDate.clone();
              this.previousRightTime = this.endDate.clone();

              this.updateView();
              this.container.show();
              this.move();
              this.element.trigger('show.daterangepicker',
                                   this);
              this.isShowing = true;
          },

          hide: function(e){
              if (!this.isShowing){
                  return;
              }

              //incomplete date selection, revert to last values
              if (!this.endDate){
                  this.startDate = this.oldStartDate.clone();
                  this.endDate = this.oldEndDate.clone();
              }

              //if a new date range was selected, invoke the user callback function
              if (!this.startDate.isSame(this.oldStartDate) || !this.endDate.isSame(this.oldEndDate)){
                  this.callback(this.startDate,
                                this.endDate,
                                this.chosenLabel);
              }

              //if picker is attached to a text input, update it
              this.updateElement();

              $(document)
              .off('.daterangepicker');
              $(window)
              .off('.daterangepicker');
              this.container.hide();
              this.element.trigger('hide.daterangepicker',
                                   this);
              this.isShowing = false;
          },

          toggle: function(e){
              if (this.isShowing){
                  this.hide();
              }
              else{
                  this.show();
              }
          },

          outsideClick: function(e){
              var target = $(e.target);
              // if the page is clicked anywhere except within the daterangerpicker/button
              // itself then call this.hide()
              if (
                      // ie modal dialog fix
                      e.type == "focusin" ||
                      target.closest(this.element).length ||
                      target.closest(this.container).length ||
                      target.closest('.calendar-table').length
              ){
                  return;
              }
              this.hide();
              this.element.trigger('outsideClick.daterangepicker',
                                   this);
          },

          showCalendars: function(){
              this.container.addClass('show-calendar');
              this.move();
              this.element.trigger('showCalendar.daterangepicker',
                                   this);
          },

          hideCalendars: function(){
              this.container.removeClass('show-calendar');
              this.element.trigger('hideCalendar.daterangepicker',
                                   this);
          },

          hoverRange: function(e){

              //ignore mouse movements while an above-calendar text input has focus
              if (this.container.find('input[name=daterangepicker_start]')
                      .is(":focus") || this.container.find('input[name=daterangepicker_end]')
                                           .is(":focus")){
                  return;
              }

              var label = e.target.getAttribute('data-range-key');

              if (label == this.locale.customRangeLabel){
                  this.updateView();
              }
              else{
                  var dates = this.ranges[label];
                  this.container.find('input[name=daterangepicker_start]')
                      .val(dates[0].format(this.locale.format));
                  this.container.find('input[name=daterangepicker_end]')
                      .val(dates[1].format(this.locale.format));
              }

          },

          clickRange: function(e){
              var label = e.target.getAttribute('data-range-key');
              this.chosenLabel = label;
              if (label == this.locale.customRangeLabel){
                  this.showCalendars();
              }
              else{
                  var dates = this.ranges[label];
                  this.startDate = dates[0];
                  this.endDate = dates[1];

                  if (!this.timePicker){
                      this.startDate.startOf('day');
                      this.endDate.endOf('day');
                  }

                  if (!this.alwaysShowCalendars){
                      this.hideCalendars();
                  }
                  this.clickApply();
              }
          },

          clickPrev: function(e){
              var cal = $(e.target)
              .parents('.calendar');
              if (cal.hasClass('left')){
                  this.leftCalendar.month.subtract(1,
                                                   'month');
                  if (this.linkedCalendars){
                      this.rightCalendar.month.subtract(1,
                                                        'month');
                  }
              }
              else{
                  this.rightCalendar.month.subtract(1,
                                                    'month');
              }
              this.updateCalendars();
          },

          clickNext: function(e){
              var cal = $(e.target)
              .parents('.calendar');
              if (cal.hasClass('left')){
                  this.leftCalendar.month.add(1,
                                              'month');
              }
              else{
                  this.rightCalendar.month.add(1,
                                               'month');
                  if (this.linkedCalendars){
                      this.leftCalendar.month.add(1,
                                                  'month');
                  }
              }
              this.updateCalendars();
          },

          hoverDate: function(e){

              //ignore mouse movements while an above-calendar text input has focus
              //if (this.container.find('input[name=daterangepicker_start]').is(":focus") || this.container.find('input[name=daterangepicker_end]').is(":focus"))
              //    return;

              //ignore dates that can't be selected
              if (!$(e.target)
              .hasClass('available')){
                  return;
              }

              //have the text inputs above calendars reflect the date being hovered over
              var title = $(e.target)
              .attr('data-title');
              var row = title.substr(1,
                                     1);
              var col = title.substr(3,
                                     1);
              var cal = $(e.target)
              .parents('.calendar');
              var date = cal.hasClass('left')
                      ? this.leftCalendar.calendar[row][col]
                      : this.rightCalendar.calendar[row][col];

              if (this.endDate && !this.container.find('input[name=daterangepicker_start]')
                                       .is(":focus")){
                  this.container.find('input[name=daterangepicker_start]')
                      .val(date.format(this.locale.format));
              }
              else if (!this.endDate && !this.container.find('input[name=daterangepicker_end]')
                                             .is(":focus")){
                  this.container.find('input[name=daterangepicker_end]')
                      .val(date.format(this.locale.format));
              }

              //highlight the dates between the start date and the date being hovered as a potential end date
              var leftCalendar = this.leftCalendar;
              var rightCalendar = this.rightCalendar;
              var startDate = this.startDate;
              if (!this.endDate){
                  this.container.find('.calendar tbody td')
                      .each(function(index,
                                     el){

                          //skip week numbers, only look at dates
                          if ($(el)
                          .hasClass('week')){
                              return;
                          }

                          var title = $(el)
                          .attr('data-title');
                          var row = title.substr(1,
                                                 1);
                          var col = title.substr(3,
                                                 1);
                          var cal = $(el)
                          .parents('.calendar');
                          var dt = cal.hasClass('left')
                                  ? leftCalendar.calendar[row][col]
                                  : rightCalendar.calendar[row][col];

                          if ((dt.isAfter(startDate) && dt.isBefore(date)) || dt.isSame(date,
                                                                                        'day')){
                              $(el)
                              .addClass('in-range');
                          }
                          else{
                              $(el)
                              .removeClass('in-range');
                          }

                      });
              }

          },

          clickDate: function(e){

              if (!$(e.target)
              .hasClass('available')){
                  return;
              }

              var title = $(e.target)
              .attr('data-title');
              var row = title.substr(1,
                                     1);
              var col = title.substr(3,
                                     1);
              var cal = $(e.target)
              .parents('.calendar');
              var date = cal.hasClass('left')
                      ? this.leftCalendar.calendar[row][col]
                      : this.rightCalendar.calendar[row][col];

              //
              // this function needs to do a few things:
              // * alternate between selecting a start and end date for the range,
              // * if the time picker is enabled, apply the hour/minute/second from the select boxes to the clicked date
              // * if autoapply is enabled, and an end date was chosen, apply the selection
              // * if single date picker mode, and time picker isn't enabled, apply the selection immediately
              // * if one of the inputs above the calendars was focused, cancel that manual input
              //

              if (this.endDate || date.isBefore(this.startDate,
                                                'day')){ //picking start
                  if (this.timePicker){
                      var hour = parseInt(this.container.find('.left .hourselect')
                                              .val(),
                                          10);
                      if (!this.timePicker24Hour){
                          var ampm = this.container.find('.left .ampmselect')
                                         .val();
                          if (ampm === 'PM' && hour<12){
                              hour += 12;
                          }
                          if (ampm === 'AM' && hour === 12){
                              hour = 0;
                          }
                      }
                      var minute = parseInt(this.container.find('.left .minuteselect')
                                                .val(),
                                            10);
                      var second = this.timePickerSeconds
                              ? parseInt(this.container.find('.left .secondselect')
                                             .val(),
                                         10)
                              : 0;
                      date = date.clone()
                                 .hour(hour)
                                 .minute(minute)
                                 .second(second);
                  }
                  this.endDate = null;
                  this.setStartDate(date.clone());
              }
              else if (!this.endDate && date.isBefore(this.startDate)){
                  //special case: clicking the same date for start/end,
                  //but the time of the end date is before the start date
                  this.setEndDate(this.startDate.clone());
              }
              else{ // picking end
                  if (this.timePicker){
                      var hour = parseInt(this.container.find('.right .hourselect')
                                              .val(),
                                          10);
                      if (!this.timePicker24Hour){
                          var ampm = this.container.find('.right .ampmselect')
                                         .val();
                          if (ampm === 'PM' && hour<12){
                              hour += 12;
                          }
                          if (ampm === 'AM' && hour === 12){
                              hour = 0;
                          }
                      }
                      var minute = parseInt(this.container.find('.right .minuteselect')
                                                .val(),
                                            10);
                      var second = this.timePickerSeconds
                              ? parseInt(this.container.find('.right .secondselect')
                                             .val(),
                                         10)
                              : 0;
                      date = date.clone()
                                 .hour(hour)
                                 .minute(minute)
                                 .second(second);
                  }
                  this.setEndDate(date.clone());
                  if (this.autoApply){
                      this.calculateChosenLabel();
                      this.clickApply();
                  }
              }

              if (this.singleDatePicker){
                  this.setEndDate(this.startDate);
                  if (!this.timePicker){
                      this.clickApply();
                  }
              }

              this.updateView();

              //This is to cancel the blur event handler if the mouse was in one of the inputs
              e.stopPropagation();

          },

          calculateChosenLabel: function(){
              var customRange = true;
              var i = 0;
              for (var range in this.ranges){
                  if (this.timePicker){
                      if (this.startDate.isSame(this.ranges[range][0]) && this.endDate.isSame(this.ranges[range][1])){
                          customRange = false;
                          this.chosenLabel = this.container.find('.ranges li:eq('+i+')')
                                                 .addClass('active')
                                                 .html();
                          break;
                      }
                  }
                  else{
                      //ignore times when comparing dates if time picker is not enabled
                      if (this.startDate.format('YYYY-MM-DD') == this.ranges[range][0].format('YYYY-MM-DD') && this.endDate.format('YYYY-MM-DD') == this.ranges[range][1].format('YYYY-MM-DD')){
                          customRange = false;
                          this.chosenLabel = this.container.find('.ranges li:eq('+i+')')
                                                 .addClass('active')
                                                 .html();
                          break;
                      }
                  }
                  i++;
              }
              if (customRange){
                  if (this.showCustomRangeLabel){
                      this.chosenLabel = this.container.find('.ranges li:last')
                                             .addClass('active')
                                             .html();
                  }
                  else{
                      this.chosenLabel = null;
                  }
                  this.showCalendars();
              }
          },

          clickApply: function(e){
              this.hide();
              this.element.trigger('apply.daterangepicker',
                                   this);
          },

          clickCancel: function(e){
              this.startDate = this.oldStartDate;
              this.endDate = this.oldEndDate;
              this.hide();
              this.element.trigger('cancel.daterangepicker',
                                   this);
          },

          monthOrYearChanged: function(e){
              var isLeft      = $(e.target)
                  .closest('.calendar')
                  .hasClass('left'),
                  leftOrRight = isLeft
                          ? 'left'
                          : 'right',
                  cal         = this.container.find('.calendar.'+leftOrRight);

              // Month must be Number for new moment versions
              var month = parseInt(cal.find('.monthselect')
                                      .val(),
                                   10);
              var year = cal.find('.yearselect')
                            .val();

              if (!isLeft){
                  if (year<this.startDate.year() || (year == this.startDate.year() && month<this.startDate.month())){
                      month = this.startDate.month();
                      year = this.startDate.year();
                  }
              }

              if (this.minDate){
                  if (year<this.minDate.year() || (year == this.minDate.year() && month<this.minDate.month())){
                      month = this.minDate.month();
                      year = this.minDate.year();
                  }
              }

              if (this.maxDate){
                  if (year>this.maxDate.year() || (year == this.maxDate.year() && month>this.maxDate.month())){
                      month = this.maxDate.month();
                      year = this.maxDate.year();
                  }
              }

              if (isLeft){
                  this.leftCalendar.month.month(month)
                      .year(year);
                  if (this.linkedCalendars){
                      this.rightCalendar.month = this.leftCalendar.month.clone()
                                                     .add(1,
                                                          'month');
                  }
              }
              else{
                  this.rightCalendar.month.month(month)
                      .year(year);
                  if (this.linkedCalendars){
                      this.leftCalendar.month = this.rightCalendar.month.clone()
                                                    .subtract(1,
                                                              'month');
                  }
              }
              this.updateCalendars();
          },

          timeChanged: function(e){

              var cal    = $(e.target)
                  .closest('.calendar'),
                  isLeft = cal.hasClass('left');

              var hour = parseInt(cal.find('.hourselect')
                                     .val(),
                                  10);
              var minute = parseInt(cal.find('.minuteselect')
                                       .val(),
                                    10);
              var second = this.timePickerSeconds
                      ? parseInt(cal.find('.secondselect')
                                    .val(),
                                 10)
                      : 0;

              if (!this.timePicker24Hour){
                  var ampm = cal.find('.ampmselect')
                                .val();
                  if (ampm === 'PM' && hour<12){
                      hour += 12;
                  }
                  if (ampm === 'AM' && hour === 12){
                      hour = 0;
                  }
              }

              if (isLeft){
                  var start = this.startDate.clone();
                  start.hour(hour);
                  start.minute(minute);
                  start.second(second);
                  this.setStartDate(start);
                  if (this.singleDatePicker){
                      this.endDate = this.startDate.clone();
                  }
                  else if (this.endDate && this.endDate.format('YYYY-MM-DD') == start.format('YYYY-MM-DD') && this.endDate.isBefore(start)){
                      this.setEndDate(start.clone());
                  }
              }
              else if (this.endDate){
                  var end = this.endDate.clone();
                  end.hour(hour);
                  end.minute(minute);
                  end.second(second);
                  this.setEndDate(end);
              }

              //update the calendars so all clickable dates reflect the new time component
              this.updateCalendars();

              //update the form inputs above the calendars with the new time
              this.updateFormInputs();

              //re-render the time pickers because changing one selection can affect what's enabled in another
              this.renderTimePicker('left');
              this.renderTimePicker('right');

          },

          formInputsChanged: function(e){
              var isRight = $(e.target)
              .closest('.calendar')
              .hasClass('right');
              var start = moment(this.container.find('input[name="daterangepicker_start"]')
                                     .val(),
                                 this.locale.format);
              var end = moment(this.container.find('input[name="daterangepicker_end"]')
                                   .val(),
                               this.locale.format);

              if (start.isValid() && end.isValid()){

                  if (isRight && end.isBefore(start)){
                      start = end.clone();
                  }

                  this.setStartDate(start);
                  this.setEndDate(end);

                  if (isRight){
                      this.container.find('input[name="daterangepicker_start"]')
                          .val(this.startDate.format(this.locale.format));
                  }
                  else{
                      this.container.find('input[name="daterangepicker_end"]')
                          .val(this.endDate.format(this.locale.format));
                  }

              }

              this.updateView();
          },

          formInputsFocused: function(e){

              // Highlight the focused input
              this.container.find('input[name="daterangepicker_start"], input[name="daterangepicker_end"]')
                  .removeClass('active');
              $(e.target)
              .addClass('active');

              // Set the state such that if the user goes back to using a mouse,
              // the calendars are aware we're selecting the end of the range, not
              // the start. This allows someone to edit the end of a date range without
              // re-selecting the beginning, by clicking on the end date input then
              // using the calendar.
              var isRight = $(e.target)
              .closest('.calendar')
              .hasClass('right');
              if (isRight){
                  this.endDate = null;
                  this.setStartDate(this.startDate.clone());
                  this.updateView();
              }

          },

          formInputsBlurred: function(e){

              // this function has one purpose right now: if you tab from the first
              // text input to the second in the UI, the endDate is nulled so that
              // you can click another, but if you tab out without clicking anything
              // or changing the input value, the old endDate should be retained

              if (!this.endDate){
                  var val = this.container.find('input[name="daterangepicker_end"]')
                                .val();
                  var end = moment(val,
                                   this.locale.format);
                  if (end.isValid()){
                      this.setEndDate(end);
                      this.updateView();
                  }
              }

          },

          elementChanged: function(){
              if (!this.element.is('input')){
                  return;
              }
              if (!this.element.val().length){
                  return;
              }
              if (this.element.val().length<this.locale.format.length){
                  return;
              }

              var dateString = this.element.val()
                                   .split(this.locale.separator),
                  start      = null,
                  end        = null;

              if (dateString.length === 2){
                  start = moment(dateString[0],
                                 this.locale.format);
                  end = moment(dateString[1],
                               this.locale.format);
              }

              if (this.singleDatePicker || start === null || end === null){
                  start = moment(this.element.val(),
                                 this.locale.format);
                  end = start;
              }

              if (!start.isValid() || !end.isValid()){
                  return;
              }

              this.setStartDate(start);
              this.setEndDate(end);
              this.updateView();
          },

          keydown: function(e){
              //hide on tab or enter
              if ((e.keyCode === 9) || (e.keyCode === 13)){
                  this.hide();
              }
          },

          updateElement: function(){
              if (this.element.is('input') && !this.singleDatePicker && this.autoUpdateInput){
                  this.element.val(this.startDate.format(this.locale.format)+this.locale.separator+this.endDate.format(this.locale.format));
                  this.element.trigger('change');
              }
              else if (this.element.is('input') && this.autoUpdateInput){
                  this.element.val(this.startDate.format(this.locale.format));
                  this.element.trigger('change');
              }
          },

          remove: function(){
              this.container.remove();
              this.element.off('.daterangepicker');
              this.element.removeData();
          }

      };

      $.fn.daterangepicker = function(options,
                                      callback){
          this.each(function(){
              var el = $(this);
              if (el.data('daterangepicker')){
                  el.data('daterangepicker')
                    .remove();
              }
              el.data('daterangepicker',
                      new DateRangePicker(el,
                                          options,
                                          callback));
          });
          return this;
      };

      return DateRangePicker;

  }));
