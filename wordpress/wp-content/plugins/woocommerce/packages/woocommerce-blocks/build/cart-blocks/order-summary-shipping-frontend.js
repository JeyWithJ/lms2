(window.webpackWcBlocksJsonp=window.webpackWcBlocksJsonp||[]).push([[31],{476:function(e,t,a){"use strict";a.r(t);var c=a(132),l=a(0),r=a(467),o=a(39),n=a(36),s=a(9),i=a(2),p={isShippingCalculatorEnabled:{type:"boolean",default:Object(i.getSetting)("isShippingCalculatorEnabled",!0)},lock:{type:"object",default:{move:!1,remove:!0}}};t.default=Object(c.withFilteredAttributes)(p)(e=>{let{className:t,isShippingCalculatorEnabled:a}=e;const{cartTotals:c,cartNeedsShipping:i}=Object(n.a)();if(!i)return null;const p=Object(o.getCurrencyFromPriceResponse)(c);return Object(l.createElement)(s.TotalsWrapper,{className:t},Object(l.createElement)(r.a,{showCalculator:a,showRateSelector:!0,values:c,currency:p}))})}}]);